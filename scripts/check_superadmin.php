<?php
$db = new PDO('sqlite:'.__DIR__.'/../database/database.sqlite');
$stmt = $db->query("SELECT id, ad, email, rol FROM kullanicilar WHERE email LIKE '%superadmin%'");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    echo $r['id']." | ".$r['ad']." | ".$r['email']." | ".$r['rol']."\n";
}
if (count($rows) === 0) {
    echo "Kayıt bulunamadı\n";
}
