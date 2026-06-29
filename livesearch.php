<?php
include "inc/baglan.php";

$tables = [
    'takimlar' => ['isim' => 'isim', 'id' => 'id'],
    'ulke' => ['isim' => 'isim', 'id' => 'id'],
    'ligler' => ['isim' => 'isim', 'id' => 'id'],
];

$q = trim($_GET["q"] ?? '');

if ($q === '') {
    exit;
}

$responses = [];

foreach ($tables as $table => $columns) {
    $sorgu = $db->prepare("SELECT * FROM $table WHERE isim LIKE :query LIMIT 3");
    $sorgu->execute(['query' => $q . '%']);
    $satir = $sorgu->fetchAll(PDO::FETCH_ASSOC);
    $hint = "";

    foreach ($satir as $row) {
        $title = htmlspecialchars($row[$columns['isim']], ENT_QUOTES, 'UTF-8');
        $logo = $row['logo'];
        if (!file_exists($logo)) {
            $logo = "assets/img/yok.png";
        }

        $hint .= '<div class="team mb-3">
            <img src="'. htmlspecialchars($logo, ENT_QUOTES, 'UTF-8') .'" alt="" width="48" height="48">
            <div class="text">
                <h4>'. $title .' </h4>
            </div>
        </div><hr style="border:1px solid;">';
    }

    if (!empty($hint)) {
        $responses[$table] = $hint;
    }
}

$response = "";
foreach ($responses as $table => $hint) {
    $tableName = ucwords($table);
    $response .= "<h4 style='margin-top: 30px;margin-bottom: 15px;' >$tableName</h4>$hint";
}

if (empty($response)) {
    $response = "Aramanızla uyuşan veri yok";
}

echo $response;
?>
