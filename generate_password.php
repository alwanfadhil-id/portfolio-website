<?php
/**
 * Script untuk generate password hash
 * Jalankan: php generate_password.php
 */

echo "=== Admin Password Hash Generator ===\n";
echo "Masukkan password baru: ";
$password = trim(fgets(STDIN));

if (strlen($password) < 6) {
    echo "Error: Password minimal 6 karakter!\n";
    exit(1);
}

$hash = password_hash($password, PASSWORD_BCRYPT);

echo "\n=== Hasil ===\n";
echo "Password: " . $password . "\n";
echo "Hash: " . $hash . "\n";
echo "\nTambahkan ke file .env:\n";
echo "ADMIN_PASSWORD_HASH=" . $hash . "\n";
echo "\nAtau tambahkan ke config/admin.php:\n";
echo "'password_hash' => '" . $hash . "',\n";
echo "\n=== Selesai ===\n";