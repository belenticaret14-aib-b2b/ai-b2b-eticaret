<?php

// Bu betik, Laravel proje temizleme komutlarını çalıştırır.

function runCommand($command) {
    echo "\nKomut çalıştırılıyor: $command\n";
    $output = shell_exec($command);
    echo $output;
}

// Temizlik komutları
runCommand('php artisan config:clear');
runCommand('php artisan route:clear');
runCommand('php artisan cache:clear');
runCommand('composer dump-autoload');
runCommand('php artisan optimize:clear');

echo "\nTemizlik tamamlandı.\n";

?>
