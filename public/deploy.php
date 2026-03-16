<?php
/**
 * ===================================================
 * DEPLOYMENT SETUP - Ar-Rohmah
 * ===================================================
 *
 * Script ini menggantikan perintah terminal untuk setup Laravel di cPanel.
 *
 * CARA PAKAI:
 *   1. Upload semua file ke cPanel (lihat panduan di bawah)
 *   2. Akses: https://domainanda.com/deploy.php?key=mukti2026
 *   3. Klik tombol untuk menjalankan perintah yang dibutuhkan
 *   4. HAPUS FILE INI SETELAH SELESAI!
 *
 * STRUKTUR FOLDER DI CPANEL:
 *   /home/username/
 *   ├── web-desa/           ← Upload SEMUA file Laravel ke sini
 *   │   ├── app/
 *   │   ├── bootstrap/
 *   │   ├── config/
 *   │   ├── database/
 *   │   ├── resources/
 *   │   ├── storage/
 *   │   ├── vendor/
 *   │   └── .env           ← Sesuaikan DB & APP_URL
 *   │
 *   └── public_html/        ← Upload ISI folder public/ ke sini
 *       ├── index.php       ← EDIT path (lihat bawah)
 *       ├── build/
 *       ├── images/
 *       └── deploy.php      ← File ini
 */

// ── Keamanan: ganti key ini dengan password Anda sendiri ──
$DEPLOY_KEY = 'arrohmah2026';

if (($_GET['key'] ?? '') !== $DEPLOY_KEY) {
    http_response_code(403);
    die('⛔ Akses ditolak. Tambahkan ?key=KUNCI_ANDA di URL.');
}

// ── Auto-detect path Laravel ──
// Sesuaikan jika folder Laravel Anda berbeda
$laravelPath = realpath(__DIR__ . '/../web-desa');
if (!$laravelPath || !file_exists($laravelPath . '/artisan')) {
    // Coba path alternatif
    $laravelPath = realpath(__DIR__ . '/..');
    if (!$laravelPath || !file_exists($laravelPath . '/artisan')) {
        die('❌ Folder Laravel tidak ditemukan. Sesuaikan $laravelPath di file ini.');
    }
}

// ── Functions ──
function runCommand(string $command, string $cwd): array
{
    $output = [];
    $code = 0;
    $fullCommand = sprintf('cd %s && php %s 2>&1', escapeshellarg($cwd), $command);
    exec($fullCommand, $output, $code);
    return ['output' => implode("\n", $output), 'code' => $code];
}

function createStorageLink(string $publicPath, string $storagePath): string
{
    $link = $publicPath . '/storage';

    if (file_exists($link) || is_link($link)) {
        return '⚠️ Storage link sudah ada.';
    }

    if (symlink($storagePath, $link)) {
        return '✅ Storage link berhasil dibuat!';
    } else {
        return '❌ Gagal membuat storage link. Coba buat manual di cPanel File Manager.';
    }
}

// ── Handle action ──
$result = null;
$action = $_POST['action'] ?? null;

if ($action === 'migrate') {
    $result = runCommand('artisan migrate --force', $laravelPath);
} elseif ($action === 'seed') {
    $result = runCommand('artisan db:seed --force', $laravelPath);
} elseif ($action === 'cache') {
    $result = runCommand('artisan config:cache', $laravelPath);
    $r2 = runCommand('artisan route:cache', $laravelPath);
    $r3 = runCommand('artisan view:cache', $laravelPath);
    $result = [
        'output' => $result['output'] . "\n" . $r2['output'] . "\n" . $r3['output'],
        'code' => $result['code'] + $r2['code'] + $r3['code'],
    ];
} elseif ($action === 'clear') {
    $result = runCommand('artisan optimize:clear', $laravelPath);
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
    $msgs[] = '   File sudah bisa diakses via:';
    $msgs[] = '   1. .htaccess rewrite rule (otomatis)';
    $msgs[] = '   2. Laravel route fallback (/storage/{path})';
    $result = ['output' => implode("\n", $msgs), 'code' => 0];
} elseif ($action === 'check') {
    $checks = [];
    $checks[] = '── Environment ──';
    $checks[] = 'PHP: ' . phpversion();
    $checks[] = 'Laravel Path: ' . $laravelPath;
    $checks[] = 'Document Root: ' . ($_SERVER['DOCUMENT_ROOT'] ?? 'N/A');
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
    $checks[] = 'storage/app/public/: ' . (is_dir($storagePub) ? '✅ Ada' : '❌ Tidak ada — buat folder ini!');
    $checks[] = 'Symlink public/storage: ' . (is_link(__DIR__ . '/storage') ? '✅ Symlink aktif' : (file_exists(__DIR__ . '/storage') ? '⚠️ Ada (bukan symlink)' : '❌ Tidak ada'));
    $checks[] = 'Root .htaccess: ' . (file_exists($laravelPath . '/.htaccess') ? '✅ Ada' : '⚠️ Tidak ada — upload .htaccess root!');

    $r = runCommand('artisan --version', $laravelPath);
    $checks[] = '';
    $checks[] = 'Laravel: ' . trim($r['output']);

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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            min-height: 100vh;
            padding: 2rem;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
        }

        h1 {
            font-size: 1.5rem;
            color: #34d399;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #94a3b8;
            font-size: 0.85rem;
            margin-bottom: 2rem;
        }

        .warning {
            background: #7f1d1d;
            border: 1px solid #ef4444;
            color: #fca5a5;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        form {
            display: contents;
        }

        button {
            padding: 0.75rem 1rem;
            border: 1px solid #334155;
            background: #1e293b;
            color: #e2e8f0;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        button:hover {
            background: #334155;
            border-color: #34d399;
        }

        .result {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        .result h3 {
            font-size: 0.85rem;
            color: #34d399;
            margin-bottom: 0.5rem;
        }

        pre {
            white-space: pre-wrap;
            font-size: 0.8rem;
            color: #cbd5e1;
            line-height: 1.6;
        }

        .success {
            border-color: #22c55e;
        }

        .error {
            border-color: #ef4444;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🚀 Deploy — Ar-Rohmah</h1>
        <p class="subtitle">Laravel Path:
            <?= htmlspecialchars($laravelPath) ?>
        </p>

        <div class="warning">
            ⚠️ <strong>HAPUS FILE INI SETELAH DEPLOYMENT SELESAI!</strong><br>
            File ini memberikan akses ke perintah server. Jangan biarkan tetap ada di production.
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