<?php
@mkdir('public/images', 0755, true);
$ctx = stream_context_create(['http' => ['user_agent' => 'Mozilla/5.0']]);
$img = file_get_contents('https://upload.wikimedia.org/wikipedia/commons/thumb/e/e2/Lambang_Kabupaten_Bekasi.png/200px-Lambang_Kabupaten_Bekasi.png', false, $ctx);
if ($img && strlen($img) > 500) {
    file_put_contents('public/images/logo-bekasi.png', $img);
    echo "Downloaded: " . strlen($img) . " bytes\n";
} else {
    echo "Download failed or too small. Trying alternative URL...\n";
    $img = file_get_contents('https://cdn.jsdelivr.net/gh/nicedozie4u/logos@master/kabupaten-bekasi.png', false, $ctx);
    if ($img && strlen($img) > 500) {
        file_put_contents('public/images/logo-bekasi.png', $img);
        echo "Downloaded from alt: " . strlen($img) . " bytes\n";
    } else {
        echo "Could not download logo. Size: " . strlen($img) . "\n";
    }
}
