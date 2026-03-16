<?php
/**
 * ===================================================
 * DEPLOYMENT SETUP - Ar-Rohmah
 * ===================================================
 *
 * Script ini menjalankan perintah Laravel TANPA terminal.
 * Menggunakan Laravel Artisan secara langsung via PHP.
 *
 * CARA PAKAI:
 *   1. Upload semua file ke cPanel
 *   2. Akses: https://domainanda.com/deploy.php?key=arrohmah2026
 *   3. Klik tombol untuk menjalankan perintah
 *   4. HAPUS FILE INI SETELAH SELESAI!
 */

// ── Keamanan ──
$DEPLOY_KEY = 'arrohmah2026';

if (($_GET['key'] ?? '') !== $DEPLOY_KEY) {
    http_response_code(403);
    die('⛔ Akses ditolak. Tambahkan ?key=KUNCI_ANDA di URL.');
}

// ── Auto-detect path Laravel ──
$laravelPath = realpath(__DIR__ . '/../web-desa');
if (!$laravelPath || !file_exists($laravelPath . '/artisan')) {
    $laravelPath = realpath(__DIR__ . '/..');
    if (!$laravelPath || !file_exists($laravelPath . '/artisan')) {
        die('❌ Folder Laravel tidak ditemukan. Sesuaikan $laravelPath di file ini.');
    }
}

// ── Bootstrap Laravel ──
$app = null;
$artisanAvailable = false;

try {
    $autoloadPath = $laravelPath . '/vendor/autoload.php';
    $bootstrapPath = $laravelPath . '/bootstrap/app.php';

    if (file_exists($autoloadPath) && file_exists($bootstrapPath)) {
        require $autoloadPath;
        $app = require_once $bootstrapPath;
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        $artisanAvailable = true;
    }
} catch (Throwable $e) {
    // Laravel gagal bootstrap, lanjut dengan mode manual
}

// ── Jalankan Artisan command via PHP ──
function runArtisan(string $command, array $params = []): array
{
    global $artisanAvailable;

    if (!$artisanAvailable) {
        return ['output' => '❌ Laravel tidak bisa di-bootstrap. Pastikan vendor/ dan .env sudah benar.', 'code' => 1];
    }

    try {
        $exitCode = Illuminate\Support\Facades\Artisan::call($command, $params);
        $output = Illuminate\Support\Facades\Artisan::output();
        return ['output' => trim($output), 'code' => $exitCode];
    } catch (Throwable $e) {
        return ['output' => '❌ ' . $e->getMessage(), 'code' => 1];
    }
}

// ── Clear cache secara manual (tanpa Artisan) ──
function manualClearCache(string $laravelPath): array
{
    $msgs = [];
    $dirs = [
        'Config cache' => $laravelPath . '/bootstrap/cache/config.php',
        'Route cache' => $laravelPath . '/bootstrap/cache/routes-v7.php',
        'Services cache' => $laravelPath . '/bootstrap/cache/services.php',
        'Packages cache' => $laravelPath . '/bootstrap/cache/packages.php',
    ];

    foreach ($dirs as $label => $file) {
        if (file_exists($file)) {
            unlink($file);
            $msgs[] = "✅ $label dihapus";
        } else {
            $msgs[] = "⏭️ $label (tidak ada)";
        }
    }

    // Clear view cache
    $viewCacheDir = $laravelPath . '/storage/framework/views';
    if (is_dir($viewCacheDir)) {
        $count = 0;
        foreach (glob($viewCacheDir . '/*.php') as $file) {
            unlink($file);
            $count++;
        }
        $msgs[] = "✅ View cache dihapus ($count file)";
    }

    // Clear file cache
    $fileCacheDir = $laravelPath . '/storage/framework/cache/data';
    if (is_dir($fileCacheDir)) {
        deleteDirectory($fileCacheDir);
        @mkdir($fileCacheDir, 0775, true);
        $msgs[] = "✅ File cache dihapus";
    }

    return ['output' => implode("\n", $msgs), 'code' => 0];
}

function deleteDirectory(string $dir): void
{
    if (!is_dir($dir)) return;
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            deleteDirectory($path);
        } else {
            @unlink($path);
        }
    }
    @rmdir($dir);
}

function createStorageLink(string $publicPath, string $storagePath): string
{
    $link = $publicPath . '/storage';

    if (file_exists($link) || is_link($link)) {
        return '⚠️ Storage link sudah ada.';
    }

    if (@symlink($storagePath, $link)) {
        return '✅ Storage link berhasil dibuat!';
    } else {
        return '❌ Symlink gagal (normal di shared hosting).';
    }
}

// ── Handle action ──
$result = null;
$action = $_POST['action'] ?? null;

if ($action === 'migrate') {
    $result = runArtisan('migrate', ['--force' => true]);
} elseif ($action === 'seed') {
    $result = runArtisan('db:seed', ['--force' => true]);
} elseif ($action === 'cache') {
    $r1 = runArtisan('config:cache');
    $r2 = runArtisan('route:cache');
    $r3 = runArtisan('view:cache');
    $result = [
        'output' => $r1['output'] . "\n" . $r2['output'] . "\n" . $r3['output'],
        'code' => $r1['code'] + $r2['code'] + $r3['code'],
    ];
} elseif ($action === 'clear') {
    if ($artisanAvailable) {
        $result = runArtisan('optimize:clear');
    } else {
        $result = manualClearCache($laravelPath);
    }
} elseif ($action === 'clear-manual') {
    $result = manualClearCache($laravelPath);
} elseif ($action === 'storage') {
    $storagePath = $laravelPath . '/storage/app/public';
    $msgs = [];
    $msgs[] = createStorageLink(__DIR__, $storagePath);
    $msgs[] = '';
    $msgs[] = '── Diagnostik Storage Path ──';
    $msgs[] = 'Folder storage/app/public: ' . (is_dir($storagePath) ? '✅ Ada' : '❌ Tidak ada');
    $msgs[] = 'Symlink public/storage: ' . (is_link(__DIR__ . '/storage') ? '✅ Symlink aktif' : (file_exists(__DIR__ . '/storage') ? '⚠️ Ada tapi bukan symlink' : '❌ Tidak ada'));
    $msgs[] = '';
    $msgs[] = '💡 Jika symlink gagal, tidak masalah!';
    $msgs[] = '   File diakses via Laravel route fallback.';
    $result = ['output' => implode("\n", $msgs), 'code' => 0];
} elseif ($action === 'check') {
    $checks = [];
    $checks[] = '── Environment ──';
    $checks[] = 'PHP: ' . phpversion();
    $checks[] = 'Laravel Path: ' . $laravelPath;
    $checks[] = 'Document Root: ' . ($_SERVER['DOCUMENT_ROOT'] ?? 'N/A');
    $checks[] = 'Artisan via PHP: ' . ($artisanAvailable ? '✅ Tersedia' : '❌ Tidak tersedia');
    $checks[] = '';
    $checks[] = '── File Check ──';
    $checks[] = 'artisan: ' . (file_exists($laravelPath . '/artisan') ? '✅' : '❌');
    $checks[] = '.env: ' . (file_exists($laravelPath . '/.env') ? '✅' : '❌');
    $checks[] = 'vendor/: ' . (is_dir($laravelPath . '/vendor') ? '✅' : '❌');
    $checks[] = '';
    $checks[] = '── Permission ──';
    $checks[] = 'storage/ writable: ' . (is_writable($laravelPath . '/storage') ? '✅' : '❌');
    $checks[] = 'bootstrap/cache/ writable: ' . (is_writable($laravelPath . '/bootstrap/cache') ? '✅' : '❌');
    $checks[] = '';
    $checks[] = '── Storage Path ──';
    $storagePub = $laravelPath . '/storage/app/public';
    $checks[] = 'storage/app/public/: ' . (is_dir($storagePub) ? '✅ Ada' : '❌ Tidak ada');
    $checks[] = 'Symlink public/storage: ' . (is_link(__DIR__ . '/storage') ? '✅ Aktif' : (file_exists(__DIR__ . '/storage') ? '⚠️ Ada (bukan symlink)' : '❌ Tidak ada'));
    $checks[] = 'Root .htaccess: ' . (file_exists($laravelPath . '/.htaccess') ? '✅ Ada' : '⚠️ Tidak ada');
    $checks[] = '';
    $checks[] = '── Disabled Functions ──';
    $disabled = ini_get('disable_functions');
    $checks[] = $disabled ? $disabled : '(tidak ada yang di-disable)';

    if ($artisanAvailable) {
        $r = runArtisan('--version');
        $checks[] = '';
        $checks[] = 'Laravel: ' . trim($r['output']);
    }

    $result = ['output' => implode("\n", $checks), 'code' => 0];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deploy — Ar-Rohmah</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0f172a; color: #e2e8f0; min-height: 100vh; padding: 2rem; }
        .container { max-width: 700px; margin: 0 auto; }
        h1 { font-size: 1.5rem; color: #34d399; margin-bottom: 0.5rem; }
        .subtitle { color: #94a3b8; font-size: 0.85rem; margin-bottom: 2rem; }
        .warning { background: #7f1d1d; border: 1px solid #ef4444; color: #fca5a5; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.85rem; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1.5rem; }
        form { display: contents; }
        button { padding: 0.75rem 1rem; border: 1px solid #334155; background: #1e293b; color: #e2e8f0; border-radius: 0.5rem; cursor: pointer; font-size: 0.85rem; transition: all 0.2s; }
        button:hover { background: #334155; border-color: #34d399; }
        .result { background: #1e293b; border: 1px solid #334155; border-radius: 0.5rem; padding: 1rem; margin-top: 1rem; }
        .result h3 { font-size: 0.85rem; color: #34d399; margin-bottom: 0.5rem; }
        pre { white-space: pre-wrap; font-size: 0.8rem; color: #cbd5e1; line-height: 1.6; }
        .success { border-color: #22c55e; }
        .error { border-color: #ef4444; }
    </style>
</head>

<body>
    <div class="container">
        <h1>🚀 Deploy — Ar-Rohmah</h1>
        <p class="subtitle">Laravel Path: <?= htmlspecialchars($laravelPath) ?>
            | Artisan: <?= $artisanAvailable ? '✅' : '❌' ?>
        </p>

        <div class="warning">
            ⚠️ <strong>HAPUS FILE INI SETELAH DEPLOYMENT SELESAI!</strong><br>
            File ini memberikan akses ke perintah server.
        </div>

        <div class="grid">
            <form method="post">
                <input type="hidden" name="action" value="check">
                <button type="submit">🔍 Cek Environment</button>
            </form>
            <form method="post">
                <input type="hidden" name="action" value="storage">
                <button type="submit">🔗 Buat Storage Link</button>
            </form>
            <form method="post">
                <input type="hidden" name="action" value="migrate">
                <button type="submit">📦 Jalankan Migrasi</button>
            </form>
            <form method="post">
                <input type="hidden" name="action" value="seed">
                <button type="submit">🌱 Jalankan Seeder</button>
            </form>
            <form method="post">
                <input type="hidden" name="action" value="cache">
                <button type="submit">⚡ Cache Config & Route</button>
            </form>
            <form method="post">
                <input type="hidden" name="action" value="clear">
                <button type="submit">🧹 Clear All Cache</button>
            </form>
            <form method="post" class="col-span-2">
                <input type="hidden" name="action" value="clear-manual">
                <button type="submit" style="grid-column: span 2; background: #1e1b4b; border-color: #6366f1;">🔧 Clear Cache Manual (tanpa Artisan)</button>
            </form>
        </div>

        <?php if ($result): ?>
            <div class="result <?= $result['code'] === 0 ? 'success' : 'error' ?>">
                <h3>
                    <?= $result['code'] === 0 ? '✅ Berhasil' : '❌ Error' ?>
                </h3>
                <pre><?= htmlspecialchars($result['output']) ?></pre>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>