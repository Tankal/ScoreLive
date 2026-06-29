<!DOCTYPE html>
<html lang="en">
<?php
include "inc/baglan.php";
include "inc/fonk.php";
$macid = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$macid) {
    http_response_code(404);
    exit("Match not found.");
}
// Maç Sorgusu
$sorgumac=$db->prepare("SELECT * FROM maclar where id = $macid");
$sorgumac->execute();
$satirmac = $sorgumac->fetch(PDO::FETCH_ASSOC);

$lig_id = $satirmac["lig_id"];
$takim1_id = $satirmac["takim1_id"];
$takim2_id = $satirmac["takim2_id"];

// Lig Sorgusu
$sorgulig=$db->prepare("SELECT * FROM ligler where id =".$satirmac["lig_id"]);
$sorgulig->execute();
$satirlig = $sorgulig->fetch(PDO::FETCH_ASSOC);

$sorgucountry=$db->prepare("SELECT * FROM ulke where id =".$satirlig["ulke_id"]);
$sorgucountry->execute();
$satircountry = $sorgucountry->fetch(PDO::FETCH_ASSOC);

// Ev Sahibi Takımı Sorgusu
$sorgutakim1=$db->prepare("SELECT * FROM takimlar where id = $takim1_id ");
$sorgutakim1->execute();
$satirtakim1 = $sorgutakim1->fetch(PDO::FETCH_ASSOC);

// Deplasman Takımı Sorgusu
$sorgutakim2=$db->prepare("SELECT * FROM takimlar where id = $takim2_id ");
$sorgutakim2->execute();
$satirtakim2 = $sorgutakim2->fetch(PDO::FETCH_ASSOC);

// Detay Sorgusu
$sorgudetay=$db->prepare("SELECT * FROM detaylar where mac_id =".$macid);
$sorgudetay->execute();
$satirdetay = $sorgudetay->fetch(PDO::FETCH_ASSOC);
if(isset($satirdetay["veri"])){
$detayarray = json_decode($satirdetay["veri"], true);
}

// İstatistikler
if(isset($satirdetay["istatistik"])){
$istatistikarray = json_decode($satirdetay["istatistik"], true);}

// İstatistikler
if(isset($satirdetay["kadro"])){
    $kadroarray = json_decode($satirdetay["kadro"], true);}
?>

<head>
    <meta charset="UTF-8">
    <title>Maç Detay | <?= $satirtakim1["isim"] . " - " . $satirtakim2["isim"]." - ". tarihDuzelt($satirmac["mac_tarihi"]) ?></title>
    <meta charset="UTF-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta property="og:title" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.min.css">
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    <link href="assets/css/bootstrap-table.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-table-fixed-columns.min.css" rel="stylesheet">
</head>

<body>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="bildirimToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="bildirim_baslik"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="bildirim_icerik">

            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="loginToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Üye ol ya da giriş yap.</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Sohbete katılmak için <a href="#">üye ol</a> ya da <a href="#">giriş yap</a>
            </div>
        </div>
    </div>



    <!--<div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="goalToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">⚽ Gooooooooooolllll!!!!!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Manchester United 1-0 öne geçti!
            </div>
        </div>
    </div>-->


    <section id="match-detail">
        <div class="container">
            <div class="match-action">
                <a href="index.php" class="prev">
                    <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24"
                            height="24">
                            <path fill="#D9D9D9" d="M0 0h24v24H0z" />
                        </mask>
                        <g mask="url(#a)" stroke="#fff" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M4 12.025h15M10.05 18.049 4 12.025 10.05 6" />
                        </g>
                    </svg>
                </a>
                <div class="league-title">
                    <img src="<?= $satircountry["logo"] ?>" style="width: 24px;height: 24px;border-radius:60px;">
                    <?= $satircountry["isim"] ?>: <?= $satirlig["isim"] ?>
                </div>

                <div class="actions">
                    <button class="favourite" onclick="addFav(this)">
                        <svg class="inactive" width="21" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="21" height="21">
                                <path fill="#D9D9D9" d="M.5.5h20v20H.5z"></path>
                            </mask>
                            <g mask="url(#a)">
                                <path clip-rule="evenodd"
                                    d="m11.42 3.564 1.523 3.042c.15.3.437.506.771.554l3.407.49c.842.122 1.177 1.142.568 1.727l-2.464 2.367a1.003 1.003 0 0 0-.295.896l.582 3.341c.143.827-.737 1.458-1.49 1.067l-3.044-1.58a1.04 1.04 0 0 0-.956 0l-3.045 1.58c-.752.39-1.632-.24-1.488-1.066l.58-3.342a1.003 1.003 0 0 0-.294-.896L3.31 9.377c-.609-.585-.274-1.605.568-1.726l3.407-.49c.334-.049.623-.256.772-.555L9.58 3.564c.376-.752 1.464-.752 1.84 0Z"
                                    stroke="#fff" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                        <svg class="active" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                                <path fill="#D9D9D9" d="M0 0h20v20H0z"></path>
                            </mask>
                            <g mask="url(#a)">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="m10.92 3.064 1.523 3.042c.15.3.437.506.771.554l3.407.49c.842.122 1.177 1.142.568 1.727l-2.464 2.367a1.003 1.003 0 0 0-.295.896l.582 3.341c.143.827-.737 1.458-1.49 1.067l-3.044-1.58a1.04 1.04 0 0 0-.956 0l-3.045 1.58c-.752.39-1.632-.24-1.488-1.066l.58-3.342a1.003 1.003 0 0 0-.294-.896L2.81 8.877c-.609-.585-.274-1.605.568-1.726l3.407-.49c.334-.049.623-.256.772-.555L9.08 3.064c.376-.752 1.464-.752 1.84 0Z"
                                    fill="#FFA800" stroke="#FFA800" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </button>
                    <!--<div class="more">
                        <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24"
                                height="24">
                                <path fill="#D9D9D9" d="M0 0h24v24H0z" />
                            </mask>
                            <g mask="url(#a)">
                                <path
                                    d="M11.5 9.25a2.25 2.25 0 1 1 0-4.5 2.25 2.25 0 0 1 0 4.5Zm0 10a2.25 2.25 0 1 1 0-4.5 2.25 2.25 0 0 1 0 4.5Z"
                                    stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                        </svg>
                    </div>-->
                </div>
            </div>

            <div class="teams v2">
                <div class="team">
                    <img src="<?php 
                            echo $satirtakim1["logo"];
                            /*if (file_exists("assets/img/".$satirtakim1["logo"]))
                                {  
                                echo "assets/img/".$satirtakim1["logo"]; 
                                }else{ 
                                echo "assets/img/yok.png"; 
                                }*/ ?>" alt="" width="48" height="48">
                    <p><?= $satirtakim1["isim"] ?></p>
                </div>
                <div class="score">
                    <div id="event_time" class="time"><?php if($satirmac["durum"] == 4) echo "MS"; ?></div>
                    <div class="number">
                        <p id="home_gol"><?= $satirmac["takim1_skor"]?></p>
                        <span>:</span>
                        <p id="away_gol"><?= $satirmac["takim2_skor"]?></p>
                    </div>
                </div>
                <div class="team">
                    <img src="<?php 
                            echo $satirtakim2["logo"];
                            /*if (file_exists("assets/img/".$satirtakim2["logo"]))
                                {  
                                echo "assets/img/".$satirtakim2["logo"]; 
                                }else{ 
                                echo "assets/img/yok.png"; 
                                }*/ ?>" alt="" width="48" height="48">
                    <p><?= $satirtakim2["isim"] ?></p>
                </div>
            </div>
        </div>

        <div class="match-info">
            <nav class="match-tab">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button <?php if($satirdetay["veri"] == "[]"){ echo "hidden";} ?> id="detaylar" class="nav-link active" id="nav-detail-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-detail" type="button" role="tab" aria-controls="nav-detail"
                        aria-selected="true"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                            <path clip-rule="evenodd"
                                d="M10.757 4.785H6.11c-.749 0-1.356-.607-1.356-1.356v-.573c0-.75.607-1.356 1.356-1.356h4.647c.75 0 1.356.607 1.356 1.356v.573c0 .75-.607 1.356-1.356 1.356Z"
                                stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M12.114 3.094a3.755 3.755 0 0 1 3.754 3.754v8.898a3.755 3.755 0 0 1-3.754 3.754h-7.36A3.755 3.755 0 0 1 1 15.746V6.848a3.755 3.755 0 0 1 3.755-3.754M7.917 9.5h3.987m-6.943 0h.281M7.917 14.32h3.987m-6.943 0h.281"
                                stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg> Detay</button>
                    <button <?php if($satirdetay["istatistik"] == "[]"){ echo "hidden";} ?> id="istatistikler" class="nav-link" id="nav-statistics-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-statistics" type="button" role="tab" aria-controls="nav-statistics"
                        aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M5.362 12.303V6.121M10.132 12.303V2.687M14.905 12.305v-2.75M16.868 17.5h-14a2 2 0 0 1-2-2v-14"
                                stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg> İstatistik</button>
                    <button <?php if($satirdetay["kadro"] == '{"kadro_home":[],"kadro_away":[],"kadro_yedek_home":[],"kadro_yedek_away":[]}'){ echo "hidden";} ?> class="nav-link" id="nav-kadro-tab" data-bs-toggle="tab" data-bs-target="#nav-kadro"
                        type="button" role="tab" aria-controls="nav-kadro" aria-selected="false"><svg
                            xmlns="http://www.w3.org/2000/svg" class="me-2" width="24" height="24" fill="#000000"
                            viewBox="0 0 256 256">
                            <path
                                d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24ZM74.08,197.5a64,64,0,0,1,107.84,0,87.83,87.83,0,0,1-107.84,0ZM96,120a32,32,0,1,1,32,32A32,32,0,0,1,96,120Zm97.76,66.41a79.66,79.66,0,0,0-36.06-28.75,48,48,0,1,0-59.4,0,79.66,79.66,0,0,0-36.06,28.75,88,88,0,1,1,131.52,0Z">
                            </path>
                        </svg>Kadrolar</button>
                    
                    <button <?php if($satirmac["durum"] == 4){echo "hidden";} ?> class="nav-link" id="nav-chat-tab" data-bs-toggle="tab" data-bs-target="#nav-chat"
                        type="button" role="tab" aria-controls="nav-chat" aria-selected="false"><svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                            <path
                                d="m8.823 17.735-1.421-1.427a2.153 2.153 0 0 0-1.526-.633H4.808a3.947 3.947 0 0 1-3.94-3.953v-6.94A3.946 3.946 0 0 1 4.808.831H14.93a3.945 3.945 0 0 1 3.938 3.951v6.94a3.946 3.946 0 0 1-3.938 3.953H13.86c-.572 0-1.12.227-1.525.633l-1.423 1.427c-.577.58-1.512.58-2.09 0ZM6.677 9.948h3.662M6.677 6.123h6.383"
                                stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg> Sohbet</button>
                    
                    <button class="nav-link" id="nav-h2h-tab" data-bs-toggle="tab" data-bs-target="#nav-h2h"
                        type="button" role="tab" aria-controls="nav-h2h" aria-selected="false"><svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M.876 7.963h15.699M12.254 1.5v2.872M5.201 1.5v2.872M16.578 9.864V6.93c.008-2.624-1.585-4.052-4.155-4.052h-7.39C2.469 2.878.868 4.306.868 6.93v7.9c0 2.664 1.601 4.126 4.165 4.126h2.15"
                                stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path clip-rule="evenodd"
                                d="M17.432 15.638a3.862 3.862 0 1 1-7.724 0 3.862 3.862 0 0 1 7.724 0Z" stroke="#000"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="m14.769 16.642-1.221-.73v-1.57M4.816 11.441h.01M4.816 14.918h.01M8.484 11.441h.01"
                                stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg> H2H</button>
                    <button class="nav-link" id="nav-points-tab" data-bs-toggle="tab" data-bs-target="#nav-points"
                        type="button" role="tab" aria-controls="nav-points" aria-selected="false"><svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                            <path clip-rule="evenodd"
                                d="m15.046 1.964.591 2.883a.885.885 0 0 0 .521.635l2.736 1.172a.872.872 0 0 1 .089 1.57l-2.588 1.425a.862.862 0 0 0-.447.683l-.261 2.922a.885.885 0 0 1-1.483.558l-2.19-2a.9.9 0 0 0-.798-.213l-2.897.636a.884.884 0 0 1-1.005-1.223L8.55 8.35a.865.865 0 0 0-.046-.814l-1.53-2.53a.873.873 0 0 1 .86-1.315l2.957.353a.888.888 0 0 0 .77-.289l1.955-2.201a.893.893 0 0 1 1.531.41Z"
                                stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M10.404 11.782a.714.714 0 0 0 .041.672l1.27 2.063a.73.73 0 0 1-.705 1.1l-2.437-.241a.742.742 0 0 0-.633.252L6.338 17.48a.73.73 0 0 1-1.27-.313l-.496-2.37a.711.711 0 0 0-.433-.517l-2.26-.919a.722.722 0 0 1-.079-1.294l2.13-1.226a.73.73 0 0 0 .365-.571l.206-2.42a.737.737 0 0 1 1.216-.485l1.816 1.615c.18.159.426.22.659.162"
                                stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg> Puan Durumu</button>
                    <button class="nav-link" id="nav-guess-tab" data-bs-toggle="tab" data-bs-target="#nav-guess"
                        type="button" role="tab" aria-controls="nav-guess" aria-selected="false"><svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M11.98 19.5H8.018M11.98 1.5H8.018M1 12.482V8.52M19 12.482V8.52M9.736 15.037v.044M9.735 12.395c-.013-.965.865-1.375 1.517-1.746.796-.44 1.335-1.138 1.335-2.107A2.585 2.585 0 0 0 10 5.954a2.58 2.58 0 0 0-2.588 2.588M1.027 15.414c.313 2.233 1.795 3.803 4.047 4.066M14.89 19.48c2.253-.264 3.725-1.833 4.037-4.066M1.027 5.595C1.34 3.362 2.822 1.783 5.074 1.52M14.89 1.52c2.253.263 3.725 1.842 4.037 4.075"
                                stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg> Tahmin</button>

                </div>
            </nav>
            <div class="container">
                <div class="tab-content mt-4" id="nav-tabContent">
                    <?php if(isset($satirdetay["veri"])){ ?>
                    <div class="tab-pane fade show active" id="nav-detail" role="tabpanel"
                        aria-labelledby="nav-detail-tab" tabindex="0">
                        <div class="match-summary">
                            <div class="summary-title">
                                <p>1. YARI </p>
                                <span><?php
                            if(isset($satirmac["takim1_skor_iy"])&& isset($satirmac["takim2_skor_iy"])){
                            echo $satirmac["takim1_skor_iy"]."-".$satirmac["takim2_skor_iy"];
                            }elseif(isset($satirmac["takim1_skor"])&& isset($satirmac["takim2_skor"])){
                            echo $satirmac["takim1_skor"]."-".$satirmac["takim2_skor"];
                            }else{echo "-";}
                            ?></span>
                            </div>
                            <ul class="summary-detail" id="birinciYari">
                                <?php foreach($detayarray as $detay){ 
                                if($detay["veri0"]== "1. YARI"){
                                    if($detay["veri1"]== "home"){ 
                                    if($detay["veri3"]=="VAR"){ ?>

                                <li>
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon var">VAR</span>
                                    <p>Ofsayt
                                        <?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Sarı Kart"){ ?>
                                <li>
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon yellowCard"><span></span></span>
                                    <p>
                                        <?= $detay["veri4"] ?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Kırmızı Kart"){ ?>
                                <li>
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon redCard"><span></span></span>
                                    <p>
                                        <?= $detay["veri4"] ?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Sarı Kart / Kırmızı Kart"){ ?>
                                <li>
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon yellowCard"><span></span></span> <span>+</span> <span
                                        class="icon redCard"><span></span></span>
                                    <p>
                                        <?=$detay["veri4"]?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Gol" || $detay["veri3"]=="Penaltı"){ ?>
                                <li>
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon goal">⚽</span>
                                    <p>
                                        <?= $detay["veri4"] ?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Oyuncu Değişikliği - Çıkan"){ ?>
                                <li>
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon change"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve">
                                            <path
                                                d="M493.815 70.629c-11.001-1.003-20.73 7.102-21.733 18.102l-2.65 29.069C424.473 47.194 346.429 0 256 0 158.719 0 72.988 55.522 30.43 138.854c-5.024 9.837-1.122 21.884 8.715 26.908 9.839 5.024 21.884 1.123 26.908-8.715C102.07 86.523 174.397 40 256 40c74.377 0 141.499 38.731 179.953 99.408l-28.517-20.367c-8.989-6.419-21.48-4.337-27.899 4.651-6.419 8.989-4.337 21.479 4.651 27.899l86.475 61.761c12.674 9.035 30.155.764 31.541-14.459l9.711-106.53c1.004-11.001-7.1-20.731-18.1-21.734zM472.855 346.238c-9.838-5.023-21.884-1.122-26.908 8.715C409.93 425.477 337.603 472 256 472c-74.377 0-141.499-38.731-179.953-99.408l28.517 20.367c8.989 6.419 21.479 4.337 27.899-4.651 6.419-8.989 4.337-21.479-4.651-27.899l-86.475-61.761c-12.519-8.944-30.141-.921-31.541 14.459L.085 419.637c-1.003 11 7.102 20.73 18.101 21.733 11.014 1.001 20.731-7.112 21.733-18.102l2.65-29.069C87.527 464.806 165.571 512 256 512c97.281 0 183.012-55.522 225.57-138.854 5.024-9.837 1.122-21.884-8.715-26.908z" />
                                        </svg></span>
                                    <p><?= $detay["veri4"] ?>
                                        <?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }}else{ 
                                if($detay["veri3"]=="VAR"){ ?>
                                <li class="rtl">
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon var">VAR</span>
                                    <p>Ofsayt
                                        <?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Sarı Kart"){ ?>
                                <li class="rtl">
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon yellowCard"><span></span></span>
                                    <p>
                                        <?= $detay["veri4"] ?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Kırmızı Kart"){ ?>
                                <li class="rtl">
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon redCard"><span></span></span>
                                    <p>
                                        <?= $detay["veri4"] ?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Sarı Kart / Kırmızı Kart"){ ?>
                                <li class="rtl">
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon redCard"><span></span></span> <span>+</span> <span
                                        class="icon yellowCard"><span></span></span>
                                    <p> <?=$detay["veri4"]?>
                                        <?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Gol" || $detay["veri3"]=="Penaltı"){ ?>
                                <li class="rtl">
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon goal">⚽</span>
                                    <p>
                                        <?= $detay["veri4"] ?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Oyuncu Değişikliği - Çıkan"){ ?>
                                <li class="rtl">
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon change"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve">
                                            <path
                                                d="M493.815 70.629c-11.001-1.003-20.73 7.102-21.733 18.102l-2.65 29.069C424.473 47.194 346.429 0 256 0 158.719 0 72.988 55.522 30.43 138.854c-5.024 9.837-1.122 21.884 8.715 26.908 9.839 5.024 21.884 1.123 26.908-8.715C102.07 86.523 174.397 40 256 40c74.377 0 141.499 38.731 179.953 99.408l-28.517-20.367c-8.989-6.419-21.48-4.337-27.899 4.651-6.419 8.989-4.337 21.479 4.651 27.899l86.475 61.761c12.674 9.035 30.155.764 31.541-14.459l9.711-106.53c1.004-11.001-7.1-20.731-18.1-21.734zM472.855 346.238c-9.838-5.023-21.884-1.122-26.908 8.715C409.93 425.477 337.603 472 256 472c-74.377 0-141.499-38.731-179.953-99.408l28.517 20.367c8.989 6.419 21.479 4.337 27.899-4.651 6.419-8.989 4.337-21.479-4.651-27.899l-86.475-61.761c-12.519-8.944-30.141-.921-31.541 14.459L.085 419.637c-1.003 11 7.102 20.73 18.101 21.733 11.014 1.001 20.731-7.112 21.733-18.102l2.65-29.069C87.527 464.806 165.571 512 256 512c97.281 0 183.012-55.522 225.57-138.854 5.024-9.837 1.122-21.884-8.715-26.908z" />
                                        </svg></span>
                                    <p><?= $detay["veri4"] ?>
                                        <?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }}}} ?>

                            </ul>
                            <div class="summary-title">
                                <p>2. YARI</p>
                                <span><?php
                           if(isset($satirmac["takim1_skor"])&& isset($satirmac["takim2_skor"])){
                            echo $satirmac["takim1_skor"]."-".$satirmac["takim2_skor"];
                            }else{echo "-";}
                            ?></span>
                            </div>
                            <ul class="summary-detail" id="ikinciYari">
                                <?php foreach($detayarray as $detay){ 
                                if($detay["veri0"]== "2. YARI"){
                                    if($detay["veri1"]== "home"){ 
                                    if($detay["veri3"]=="VAR"){ ?>

                                <li>
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon var">VAR</span>
                                    <p>Ofsayt<?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Sarı Kart"){ ?>
                                <li>
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon yellowCard"><span></span></span>
                                    <p>
                                        <?= $detay["veri4"] ?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Kırmızı Kart"){ ?>
                                <li>
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon redCard"><span></span></span>
                                    <p>
                                        <?= $detay["veri4"] ?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Sarı Kart / Kırmızı Kart"){ ?>
                                <li>
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon yellowCard"><span></span></span> <span>+</span> <span
                                        class="icon redCard"><span></span></span>
                                    <p>
                                        <?= $detay["veri4"] ?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Gol" || $detay["veri3"]=="Penaltı"){ ?>
                                <li>
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon goal">⚽</span>
                                    <p>
                                        <?= $detay["veri4"] ?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Oyuncu Değişikliği - Çıkan"){ ?>
                                <li>
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon change"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve">
                                            <path
                                                d="M493.815 70.629c-11.001-1.003-20.73 7.102-21.733 18.102l-2.65 29.069C424.473 47.194 346.429 0 256 0 158.719 0 72.988 55.522 30.43 138.854c-5.024 9.837-1.122 21.884 8.715 26.908 9.839 5.024 21.884 1.123 26.908-8.715C102.07 86.523 174.397 40 256 40c74.377 0 141.499 38.731 179.953 99.408l-28.517-20.367c-8.989-6.419-21.48-4.337-27.899 4.651-6.419 8.989-4.337 21.479 4.651 27.899l86.475 61.761c12.674 9.035 30.155.764 31.541-14.459l9.711-106.53c1.004-11.001-7.1-20.731-18.1-21.734zM472.855 346.238c-9.838-5.023-21.884-1.122-26.908 8.715C409.93 425.477 337.603 472 256 472c-74.377 0-141.499-38.731-179.953-99.408l28.517 20.367c8.989 6.419 21.479 4.337 27.899-4.651 6.419-8.989 4.337-21.479-4.651-27.899l-86.475-61.761c-12.519-8.944-30.141-.921-31.541 14.459L.085 419.637c-1.003 11 7.102 20.73 18.101 21.733 11.014 1.001 20.731-7.112 21.733-18.102l2.65-29.069C87.527 464.806 165.571 512 256 512c97.281 0 183.012-55.522 225.57-138.854 5.024-9.837 1.122-21.884-8.715-26.908z" />
                                        </svg></span>
                                    <p><?= $detay["veri4"] ?>
                                        <?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }}else{ 
                                if($detay["veri3"]=="VAR"){ ?>
                                <li class="rtl">
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon var">VAR</span>
                                    <p>Ofsayt<?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Sarı Kart"){ ?>
                                <li class="rtl">
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon yellowCard"><span></span></span>
                                    <p>
                                        <?= $detay["veri4"] ?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Kırmızı Kart"){ ?>
                                <li class="rtl">
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon redCard"><span></span></span>
                                    <p>
                                        <?= $detay["veri4"] ?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Sarı Kart / Kırmızı Kart"){ ?>
                                <li class="rtl">
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon redCard"><span></span></span> <span>+</span> <span
                                        class="icon yellowCard"><span></span></span>
                                    <p>
                                        <?= $detay["veri4"] ?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Gol"){ ?>
                                <li class="rtl">
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon goal">⚽</span>
                                    <p>
                                        <?= $detay["veri4"] ?><?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }elseif($detay["veri3"]=="Oyuncu Değişikliği - Çıkan"){ ?>
                                <li class="rtl">
                                    <span><?= $detay["veri2"] ?></span>
                                    <span class="icon change"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve">
                                            <path
                                                d="M493.815 70.629c-11.001-1.003-20.73 7.102-21.733 18.102l-2.65 29.069C424.473 47.194 346.429 0 256 0 158.719 0 72.988 55.522 30.43 138.854c-5.024 9.837-1.122 21.884 8.715 26.908 9.839 5.024 21.884 1.123 26.908-8.715C102.07 86.523 174.397 40 256 40c74.377 0 141.499 38.731 179.953 99.408l-28.517-20.367c-8.989-6.419-21.48-4.337-27.899 4.651-6.419 8.989-4.337 21.479 4.651 27.899l86.475 61.761c12.674 9.035 30.155.764 31.541-14.459l9.711-106.53c1.004-11.001-7.1-20.731-18.1-21.734zM472.855 346.238c-9.838-5.023-21.884-1.122-26.908 8.715C409.93 425.477 337.603 472 256 472c-74.377 0-141.499-38.731-179.953-99.408l28.517 20.367c8.989 6.419 21.479 4.337 27.899-4.651 6.419-8.989 4.337-21.479-4.651-27.899l-86.475-61.761c-12.519-8.944-30.141-.921-31.541 14.459L.085 419.637c-1.003 11 7.102 20.73 18.101 21.733 11.014 1.001 20.731-7.112 21.733-18.102l2.65-29.069C87.527 464.806 165.571 512 256 512c97.281 0 183.012-55.522 225.57-138.854 5.024-9.837 1.122-21.884-8.715-26.908z" />
                                        </svg></span>
                                    <p> <?= $detay["veri4"] ?>
                                        <?php if(isset($detay["veri5"]) && $detay["veri5"]!=""){ echo "(".$detay["veri5"].")"; }?>
                                    </p>
                                </li>
                                <?php }}}} ?>

                            </ul>
                        </div>
                    </div>
                    <?php } if(isset($satirdetay["veri"])){ ?>
                    <div class="tab-pane fade" id="nav-statistics" role="tabpanel" aria-labelledby="nav-statistics-tab"
                        tabindex="0">

                        <?php 
                        
                        function yuzde($a,$b){ 
                        $c = $a / 100;  
                        return floor($b / $c);  
                        }
                        foreach($istatistikarray as $istatistik){

                           $toplam = (float)$istatistik["veri1"] + (float)$istatistik["veri3"];
                           $oran1 = yuzde($toplam,(float)$istatistik["veri1"]);
                           $oran2 = yuzde($toplam,(float)$istatistik["veri3"]);
                            ?>
                        <div class="statistic-box mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <?=$istatistik["veri1"]?>
                                </div>
                                <div class="col-8 text-center"><?=$istatistik["veri2"]?></div>
                                <div class="col-2 text-end">
                                    <?=$istatistik["veri3"]?>
                                </div>
                            </div>
                            <div class="row margin-5 mt-2">
                                <div class="col-6">
                                    <div class="progress first" role="progressbar" aria-label="Basic example"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-info" style="width: <?=$oran1?>%"></div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="progress" role="progressbar" aria-label="Basic example"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-warning" style="width: <?=$oran2?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php } ?>
                    </div>
                    <div class="tab-pane fade" id="nav-kadro" role="tabpanel" aria-labelledby="nav-kadro-tab"
                        tabindex="0">
                        <?php if($kadroarray != ""){ ?>
                        <td style="font-size:13px;">EV KADRO</td>
                        </tr>
                        <table class="table" style="font-size:14px;">

                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">İsim</th>
                                    <th scope="col">Uyruk</th>
                                </tr>
                            </thead>
                            <tr>
                                <tbody>
                                    <?php $evkadro = $kadroarray["kadro_home"]; ?>
                                    <?php $evyedek = $kadroarray["kadro_yedek_home"]; ?>
                                    <?php $deplasmankadro = $kadroarray["kadro_away"]; ?>
                                    <?php $deplasmanyedek = $kadroarray["kadro_yedek_away"]; 
                                foreach($evkadro as $ev){ ?>
                                    <tr style="font-size:12px;">
                                        <th scope="row"><?= $ev["number"] ?></th>
                                        <td><?= $ev["name"] ?></td>
                                        <td><?= $ev["flag"] ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                        </table>
                        <td>EV KADRO YEDEKLER</td>
                        <table class="table" style="font-size:14px;">

                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">İsim</th>
                                    <th scope="col">Uyruk</th>
                                </tr>
                            </thead>
                            <tr>
                                <tbody>
                                    <?php foreach($evyedek as $yedekev){ ?>
                                    <tr>
                                        <th scope="row"><?= $yedekev["number"] ?></th>
                                        <td><?= $yedekev["name"] ?></td>
                                        <td><?= $yedekev["flag"] ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                        </table>
                        <tr>
                            <td style="font-size:13px;">DEPLASMAN KADRO</td>
                        </tr>
                        <table class="table" style="font-size:14px;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">İsim</th>
                                    <th scope="col">Uyruk</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach($deplasmankadro as $deplasman){ ?>
                                <tr style="font-size:12px;">
                                    <th scope="row"><?= $deplasman["number"] ?></th>
                                    <td><?= $deplasman["name"] ?></td>
                                    <td><?= $deplasman["flag"] ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <tr style="font-size:12px;">
                            <td>DEPLASMAN KADRO YEDEKLER</td>
                        </tr>
                        <table class="table" style="font-size:14px;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">İsim</th>
                                    <th scope="col">Uyruk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($deplasmanyedek as $yedekdeplasman){ ?>
                                <tr>
                                    <th scope="row"><?= $yedekdeplasman["number"] ?></th>
                                    <td><?= $yedekdeplasman["name"] ?></td>
                                    <td><?= $yedekdeplasman["flag"] ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <div class="tab-pane fade" id="nav-chat" role="tabpanel" aria-labelledby="nav-chat-tab"
                        tabindex="0">
                        <div class="chats" id="chat_screen" style="height: 500px; overflow-y: scroll;">



                        </div>


                        <div class="chat-panel active">
                            <button type="button" class="language-btn"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none">
                                    <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                        width="24" height="24">
                                        <path fill="#D9D9D9" d="M0 0h24v24H0z" />
                                    </mask>
                                    <g mask="url(#a)" stroke="#fff" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M7.783 3h8.435C19.166 3 21 5.081 21 8.026v7.948C21 18.919 19.166 21 16.217 21H7.783C4.835 21 3 18.919 3 15.974V8.026C3 5.081 4.844 3 7.783 3Z" />
                                        <path
                                            d="M12.639 14.984c.73.292 1.152.334 1.988.334.487 0 1.172-.22 1.63-.317" />
                                        <path
                                            d="m12.008 16.224 2.449-4.798 2.45 4.798M8.809 10.57a6.41 6.41 0 0 0 1.278 2.555c.206.248.433.482.675.699" />
                                        <path
                                            d="M12.415 8.645c.058.122-.24 4.445-5.021 5.908M7.094 8.645h6.949M10.389 7.777v.865" />
                                    </g>
                                </svg></button>
                            <form action="javascript:void(0);" id="mesaj_gonder" method="POST">
                                <div class="form-group">
                                    <input id="mesaj" type="text" placeholder="Bir mesaj gönderin...">
                                </div>
                                <div class="form-group">
                                    <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none">
                                            <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                                width="24" height="24">
                                                <path fill="#D9D9D9" d="M0 0h24v24H0z" />
                                            </mask>
                                            <g mask="url(#a)">
                                                <path
                                                    d="m15.832 8.175-5.723 5.784-6.51-4.071c-.932-.584-.738-2 .317-2.31L19.37 3.054c.966-.283 1.862.62 1.575 1.589l-4.573 15.445c-.313 1.056-1.722 1.245-2.3.308l-3.967-6.435"
                                                    stroke="#fff" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </g>
                                        </svg></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-h2h" role="tabpanel" aria-labelledby="nav-h2h-tab" tabindex="0">
                        <div class="encounter">
                            <div class="team mb-3">
                                <img src="<?php 
                                echo $satirtakim1["logo"];
                                
                                /*if (file_exists("assets/img/".$satirtakim1["logo"]))
                                {  
                                echo "assets/img/".$satirtakim1["logo"]; 
                                }else{ 
                                echo "assets/img/yok.png"; 
                                }*/ ?>" alt="" width="48" height="48">
                                <div class="text">
                                    <h4><?= $satirtakim1["isim"] ?></h4>
                                    <small>Son karşılaşmalar</small>
                                </div>
                            </div>
                            <?php $sorgutakim1maclar = $db->prepare("SELECT * FROM maclar WHERE durum = 2 AND (takim1_id = :takim1_id OR takim2_id = :takim1_id) ORDER BY mac_tarihi DESC Limit 3");
                                  $sorgutakim1maclar->execute(array(':takim1_id' => $takim1_id));
                                  while($satirtakim1maclar = $sorgutakim1maclar->fetch(PDO::FETCH_ASSOC)){ 
                    
                                    $detaytakim1_id = $satirtakim1maclar["takim1_id"];
                                    $detaytakim2_id = $satirtakim1maclar["takim2_id"];
                                    $detaytakim1_skor = $satirtakim1maclar["takim1_skor"];
                                    $detaytakim2_skor = $satirtakim1maclar["takim2_skor"];

                                    if($detaytakim1_id == $takim1_id){
                                        $anatakim = $satirtakim1maclar["takim1_skor"];
                                        $digertakim = $satirtakim1maclar["takim2_skor"];
                                    }else if($detaytakim2_id == $takim1_id){
                                        $anatakim = $satirtakim1maclar["takim2_skor"];
                                        $digertakim = $satirtakim1maclar["takim1_skor"];
                                    }

                                    // Detay Lig Sorgusu
                                    $sorgumaclig=$db->prepare("SELECT * FROM ligler where id = ".$satirtakim1maclar["lig_id"] );
                                    $sorgumaclig->execute();
                                    $satirmaclig = $sorgumaclig->fetch(PDO::FETCH_ASSOC); 
                                    // Detay Ev Sahibi Takımı Sorgusu
                                    $detaysorgutakim1=$db->prepare("SELECT * FROM takimlar where id = $detaytakim1_id ");
                                    $detaysorgutakim1->execute();
                                    $detaysatirtakim1 = $detaysorgutakim1->fetch(PDO::FETCH_ASSOC);

                                    // Detay Deplasman Takımı Sorgusu
                                    $detaysorgutakim2=$db->prepare("SELECT * FROM takimlar where id = $detaytakim2_id ");
                                    $detaysorgutakim2->execute();
                                    $detaysatirtakim2 = $detaysorgutakim2->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <div class="encounter-box mb-2">
                                <div class="date">
                                    <p><?= tarihDuzelt($satirtakim1maclar["mac_tarihi"]) ?></p>
                                    <span><?= $satirmaclig["isim"] ?></span>
                                </div>
                                <div class="encounter-teams">
                                    <div class="team">
                                        <div class="logo">
                                            <img src="<?php 
                                            echo $detaysatirtakim1["logo"];
                                            /*if (file_exists("assets/img/".$detaysatirtakim1["logo"]))
                                {  
                                echo "assets/img/".$detaysatirtakim1["logo"]; 
                                }else{ 
                                echo "assets/img/yok.png"; 
                                }*/ ?>" alt="" width="20" height="20">
                                            <p><?= $detaysatirtakim1["isim"] ?></p>
                                        </div>
                                        <div class="score">
                                            <?= $detaytakim1_skor ?>
                                        </div>
                                    </div>
                                    <div class="team">
                                        <div class="logo">
                                            <img src="<?php 
                                             echo $detaysatirtakim2["logo"];
                                /*if (file_exists("assets/img/".$detaysatirtakim2["logo"]))
                                {  
                                echo "assets/img/".$detaysatirtakim2["logo"]; 
                                }else{ 
                                echo "assets/img/yok.png"; 
                                }*/ ?>" alt="" width="20" height="20">
                                            <p><?= $detaysatirtakim2["isim"] ?></p>
                                        </div>
                                        <div class="score">
                                            <?= $detaytakim2_skor ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if($anatakim > $digertakim){ ?>
                                <span class="score-badge badge-success">G</span>
                                <?php }elseif($anatakim < $digertakim){ ?>
                                <span class="score-badge badge-danger">M</span>
                                <?php }elseif($anatakim == $digertakim){ ?>
                                <span class="score-badge badge-warning">B </span>
                                <?php }else{ ?>
                                <span class="score-badge badge-light">?</span>
                                <?php } ?>
                            </div>
                            <?php } ?>

                            <button class="btn btn-primary encounter-more" type="button" data-bs-toggle="collapse"
                                data-bs-target="#encounter-1" aria-expanded="false" aria-controls="encounter-1">
                                Daha fazla göster <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6"
                                    fill="none">
                                    <path d="M9 1 5 5 1 1" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>

                            <div class="collapse p-0 encounter-collapse" id="encounter-1">
                                <div class="card card-body" style="border:none;padding:0">

                                    <?php $sorgutakim1maclar = $db->prepare("SELECT * FROM maclar WHERE durum = 2 AND (takim1_id = :takim1_id OR takim2_id = :takim1_id) ORDER BY mac_tarihi DESC LIMIT 3,7");
                                  $sorgutakim1maclar->execute(array(':takim1_id' => $takim1_id));
                                  while($satirtakim1maclar = $sorgutakim1maclar->fetch(PDO::FETCH_ASSOC)){ 
                    
                                    $detaytakim1_id = $satirtakim1maclar["takim1_id"];
                                    $detaytakim2_id = $satirtakim1maclar["takim2_id"];
                                    $detaytakim1_skor = $satirtakim1maclar["takim1_skor"];
                                    $detaytakim2_skor = $satirtakim1maclar["takim2_skor"];

                                    if($detaytakim1_id == $takim1_id){
                                        $anatakim = $satirtakim1maclar["takim1_skor"];
                                        $digertakim = $satirtakim1maclar["takim2_skor"];
                                    }elseif($detaytakim2_id == $takim1_id){
                                        $anatakim = $satirtakim1maclar["takim2_skor"];
                                        $digertakim = $satirtakim1maclar["takim1_skor"];
                                    }

                                    // Detay Lig Sorgusu
                                    $sorgumaclig=$db->prepare("SELECT * FROM ligler where id = ".$satirtakim1maclar["lig_id"] );
                                    $sorgumaclig->execute();
                                    $satirmaclig = $sorgumaclig->fetch(PDO::FETCH_ASSOC); 
                                    // Detay Ev Sahibi Takımı Sorgusu
                                    $detaysorgutakim1=$db->prepare("SELECT * FROM takimlar where id = $detaytakim1_id ");
                                    $detaysorgutakim1->execute();
                                    $detaysatirtakim1 = $detaysorgutakim1->fetch(PDO::FETCH_ASSOC);

                                    // Detay Deplasman Takımı Sorgusu
                                    $detaysorgutakim2=$db->prepare("SELECT * FROM takimlar where id = $detaytakim2_id ");
                                    $detaysorgutakim2->execute();
                                    $detaysatirtakim2 = $detaysorgutakim2->fetch(PDO::FETCH_ASSOC);
                                ?>
                                    <div class="encounter-box mb-2">
                                        <div class="date">
                                            <p><?= tarihDuzelt($satirtakim1maclar["mac_tarihi"]) ?></p>
                                            <span><?= $satirmaclig["isim"] ?></span>
                                        </div>
                                        <div class="encounter-teams">
                                            <div class="team">
                                                <div class="logo">
                                                    <img src="<?= $detaysatirtakim1["logo"] ?>" alt=""
                                                        width="20" height="20">
                                                    <p><?= $detaysatirtakim1["isim"] ?></p>
                                                </div>
                                                <div class="score">
                                                    <?= $detaytakim1_skor ?>
                                                </div>
                                            </div>
                                            <div class="team">
                                                <div class="logo">
                                                    <img src="<?= $detaysatirtakim2["logo"] ?>" alt=""
                                                        width="20" height="20">
                                                    <p><?= $detaysatirtakim2["isim"] ?></p>
                                                </div>
                                                <div class="score">
                                                    <?= $detaytakim2_skor ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($anatakim > $digertakim){ ?>
                                        <span class="score-badge badge-success">G</span>
                                        <?php }elseif($anatakim < $digertakim){ ?>
                                        <span class="score-badge badge-danger">M</span>
                                        <?php }elseif($anatakim == $digertakim){ ?>
                                        <span class="score-badge badge-warning">B </span>
                                        <?php }else{ ?>
                                        <span class="score-badge badge-light">?</span>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>

                        <div class="encounter">
                            <div class="team mb-3">
                                <img src="<?php 
                                echo $satirtakim2["logo"];
                                
                                /*if (file_exists("assets/img/".$satirtakim2["logo"]))
                                {  
                                echo "assets/img/".$satirtakim2["logo"]; 
                                }else{ 
                                echo "assets/img/yok.png"; 
                                }*/ ?>" alt="" width="48" height="48">
                                <div class="text">
                                    <h4><?= $satirtakim2["isim"] ?></h4>
                                    <small>Son karşılaşmalar</small>
                                </div>
                            </div>
                            <?php $sorgutakim1maclar = $db->prepare("SELECT * FROM maclar WHERE durum = 2 AND (takim1_id = :takim1_id OR takim2_id = :takim1_id) ORDER BY mac_tarihi DESC Limit 3");
                                  $sorgutakim1maclar->execute(array(':takim1_id' => $takim2_id));
                                  while($satirtakim1maclar = $sorgutakim1maclar->fetch(PDO::FETCH_ASSOC)){ 
                    
                                    $detaytakim1_id = $satirtakim1maclar["takim1_id"];
                                    $detaytakim2_id = $satirtakim1maclar["takim2_id"];
                                    $detaytakim1_skor = $satirtakim1maclar["takim1_skor"];
                                    $detaytakim2_skor = $satirtakim1maclar["takim2_skor"];

                                    if($detaytakim1_id == $takim2_id){
                                        $anatakim = $satirtakim1maclar["takim1_skor"];
                                        $digertakim = $satirtakim1maclar["takim2_skor"];
                                    }elseif($detaytakim2_id == $takim2_id){
                                        $anatakim = $satirtakim1maclar["takim2_skor"];
                                        $digertakim = $satirtakim1maclar["takim1_skor"];
                                    }

                                    // Detay Lig Sorgusu
                                    $sorgumaclig=$db->prepare("SELECT * FROM ligler where id = ".$satirtakim1maclar["lig_id"] );
                                    $sorgumaclig->execute();
                                    $satirmaclig = $sorgumaclig->fetch(PDO::FETCH_ASSOC); 
                                    // Detay Ev Sahibi Takımı Sorgusu
                                    $detaysorgutakim1=$db->prepare("SELECT * FROM takimlar where id = $detaytakim1_id ");
                                    $detaysorgutakim1->execute();
                                    $detaysatirtakim1 = $detaysorgutakim1->fetch(PDO::FETCH_ASSOC);

                                    // Detay Deplasman Takımı Sorgusu
                                    $detaysorgutakim2=$db->prepare("SELECT * FROM takimlar where id = $detaytakim2_id ");
                                    $detaysorgutakim2->execute();
                                    $detaysatirtakim2 = $detaysorgutakim2->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <div class="encounter-box mb-2">
                                <div class="date">
                                    <p><?= tarihDuzelt($satirtakim1maclar["mac_tarihi"]) ?></p>
                                    <span><?= $satirmaclig["isim"] ?></span>
                                </div>
                                <div class="encounter-teams">
                                    <div class="team">
                                        <div class="logo">
                                            <img src="<?= $detaysatirtakim1["logo"] ?>" alt="" width="20"
                                                height="20">
                                            <p><?= $detaysatirtakim1["isim"] ?></p>
                                        </div>
                                        <div class="score">
                                            <?= $detaytakim1_skor ?>
                                        </div>
                                    </div>
                                    <div class="team">
                                        <div class="logo">
                                            <img src="<?= $detaysatirtakim2["logo"] ?>" alt="" width="20"
                                                height="20">
                                            <p><?= $detaysatirtakim2["isim"] ?></p>
                                        </div>
                                        <div class="score">
                                            <?= $detaytakim2_skor ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if($anatakim > $digertakim){ ?>
                                <span class="score-badge badge-success">G</span>
                                <?php }elseif($anatakim < $digertakim){ ?>
                                <span class="score-badge badge-danger">M</span>
                                <?php }elseif($anatakim == $digertakim){ ?>
                                <span class="score-badge badge-warning">B </span>
                                <?php }else{ ?>
                                <span class="score-badge badge-light">?</span>
                                <?php } ?>
                            </div>
                            <?php } ?>

                            <button class="btn btn-primary encounter-more" type="button" data-bs-toggle="collapse"
                                data-bs-target="#encounter-2" aria-expanded="false" aria-controls="encounter-1">
                                Daha fazla göster <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6"
                                    fill="none">
                                    <path d="M9 1 5 5 1 1" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>

                            <div class="collapse p-0 encounter-collapse" id="encounter-2">
                                <div class="card card-body" style="border:none;padding:0">

                                    <?php $sorgutakim1maclar = $db->prepare("SELECT * FROM maclar WHERE durum = 2 AND (takim1_id = :takim1_id OR takim2_id = :takim1_id) ORDER BY mac_tarihi DESC LIMIT 3,7");
                                  $sorgutakim1maclar->execute(array(':takim1_id' => $takim2_id));
                                  while($satirtakim1maclar = $sorgutakim1maclar->fetch(PDO::FETCH_ASSOC)){ 
                    
                                    $detaytakim1_id = $satirtakim1maclar["takim1_id"];
                                    $detaytakim2_id = $satirtakim1maclar["takim2_id"];
                                    $detaytakim1_skor = $satirtakim1maclar["takim1_skor"];
                                    $detaytakim2_skor = $satirtakim1maclar["takim2_skor"];

                                    if($detaytakim1_id == $takim2_id){
                                        $anatakim = $satirtakim1maclar["takim1_skor"];
                                        $digertakim = $satirtakim1maclar["takim2_skor"];
                                    }elseif($detaytakim2_id == $takim2_id){
                                        $anatakim = $satirtakim1maclar["takim2_skor"];
                                        $digertakim = $satirtakim1maclar["takim1_skor"];
                                    }

                                    // Detay Lig Sorgusu
                                    $sorgumaclig=$db->prepare("SELECT * FROM ligler where id = ".$satirtakim1maclar["lig_id"] );
                                    $sorgumaclig->execute();
                                    $satirmaclig = $sorgumaclig->fetch(PDO::FETCH_ASSOC); 
                                    // Detay Ev Sahibi Takımı Sorgusu
                                    $detaysorgutakim1=$db->prepare("SELECT * FROM takimlar where id = $detaytakim1_id ");
                                    $detaysorgutakim1->execute();
                                    $detaysatirtakim1 = $detaysorgutakim1->fetch(PDO::FETCH_ASSOC);

                                    // Detay Deplasman Takımı Sorgusu
                                    $detaysorgutakim2=$db->prepare("SELECT * FROM takimlar where id = $detaytakim2_id ");
                                    $detaysorgutakim2->execute();
                                    $detaysatirtakim2 = $detaysorgutakim2->fetch(PDO::FETCH_ASSOC);
                                ?>
                                    <div class="encounter-box mb-2">
                                        <div class="date">
                                            <p><?= tarihDuzelt($satirtakim1maclar["mac_tarihi"]) ?></p>
                                            <span><?= $satirmaclig["isim"] ?></span>
                                        </div>
                                        <div class="encounter-teams">
                                            <div class="team">
                                                <div class="logo">
                                                    <img src="<?= $detaysatirtakim1["logo"] ?>" alt=""
                                                        width="20" height="20">
                                                    <p><?= $detaysatirtakim1["isim"] ?></p>
                                                </div>
                                                <div class="score">
                                                    <?= $detaytakim1_skor ?>
                                                </div>
                                            </div>
                                            <div class="team">
                                                <div class="logo">
                                                    <img src="<?= $detaysatirtakim2["logo"] ?>" alt=""
                                                        width="20" height="20">
                                                    <p><?= $detaysatirtakim2["isim"] ?></p>
                                                </div>
                                                <div class="score">
                                                    <?= $detaytakim2_skor ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($anatakim > $digertakim){ ?>
                                        <span class="score-badge badge-success">G</span>
                                        <?php }elseif($anatakim < $digertakim){ ?>
                                        <span class="score-badge badge-danger">M</span>
                                        <?php }elseif($anatakim == $digertakim){ ?>
                                        <span class="score-badge badge-warning">B </span>
                                        <?php }else{ ?>
                                        <span class="score-badge badge-light">?</span>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-points" role="tabpanel" aria-labelledby="nav-points-tab"
                        tabindex="0">
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="sticky">Takım</th>
                                        <th class="text-center">O</th>
                                        <th class="text-center">G</th>
                                        <th class="text-center">B</th>
                                        <th class="text-center">M</th>
                                        <th class="text-center">G</th>
                                        <th class="text-center">AV</th>
                                        <th class="text-center">P</th>
                                        <th>Form</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $sorgupuan=$db->prepare("SELECT * FROM puan_tablosu where lig_id = $lig_id order by siralama");
                                    $sorgupuan->execute();
                                    while ($satirpuan = $sorgupuan->fetch(PDO::FETCH_ASSOC)){
                                    $puantakim_id = $satirpuan["takim_id"];
                                    $sorgupuantakim=$db->prepare("SELECT * FROM takimlar where id = $puantakim_id ");
                                    $sorgupuantakim->execute();
                                    $satirpuantakim = $sorgupuantakim->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <tr>
                                        <td class="sticky">
                                            <div class="team">
                                                <span class="number"><?=$satirpuan["siralama"]?></span>
                                                <img src="<?=$satirpuantakim["logo"]?>" alt="" width="48"
                                                    height="48">
                                                <p><?=$satirpuantakim["isim"]?></p>
                                            </div>
                                        </td>
                                        <td><?=$satirpuan["oynanan"]?></td>
                                        <td><?=$satirpuan["kazanilan"]?></td>
                                        <td><?=$satirpuan["kaybedilen"]?></td>
                                        <td><?=$satirpuan["berabere"]?></td>
                                        <td><?=$satirpuan["atilan_gol"]?>:<?=$satirpuan["yenilen_gol"]?></td>
                                        <td><?=$satirpuan["atilan_gol"]-$satirpuan["yenilen_gol"]  ?></td>
                                        <td><?=$satirpuan["puan"]?></td>
                                        <td>
                                            <span class="score-badge badge-light">?</span>
                                            <span class="score-badge badge-success">G</span>
                                            <span class="score-badge badge-warning">B</span>
                                            <span class="score-badge badge-danger">M</span>
                                            <span class="score-badge badge-success">G</span>
                                            <span class="score-badge badge-success">G</span>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-guess" role="tabpanel" aria-labelledby="nav-guess-tab"
                        tabindex="0">...</div>
                </div>
            </div>

        </div>
    </section>


    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.min.js"></script>

    <script src="assets/js/bootstrap-table.min.js"></script>
    <script src="assets/js/bootstrap-table-fixed-columns.min.js"></script>

    <script>
    function isNumeric(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    function yuzde(a, b, g) {

        if (g == "Topa sahip olma") {
            return parseInt(b);
        }

        var gelenYuzde = (100 * b) / a;

        return gelenYuzde;

    }



    var sunucu = null;
    sunucu = io("https://jetskor.xyz:4444");
    sunucu.on('reconnect', function() {
        window.location.reload();
    });
    sunucu.on('connect', function() {
        <?php if($satirmac["durum"] != 4){ ?>
        <?php 
                if(isset($_SESSION["user"])){
            ?>
        sunucu.emit("canli_mac", {
            "mac_id": <?php echo $macid; ?>,
            "user_id": "<?php echo $_SESSION["user"]; ?>"
        });
        <?php }else{ ?>
        sunucu.emit("canli_mac", {
            "mac_id": <?php echo $macid; ?>
        });
        <?php } ?>
        <?php } ?>
    });
    sunucu.on('disconnect', function() {
    });

    sunucu.on('mac_bilgi', function(veri) {

        var zamanDurum = "";
        if(veri.match_status == 2){
            zamanDurum = "İY";
        }else if(veri.match_status == 4){
            zamanDurum = "MS";
        }else{
            if(veri.match_addedtime.length != 0){
                zamanDurum = veri.match_eventtime + "(" + veri.match_addedtime + ")";
            }else{
                zamanDurum = veri.match_eventtime;
            }
        }

        $("#event_time").text(zamanDurum);
        $("#home_gol").text(veri.match_homegol);
        $("#away_gol").text(veri.match_awaygol);
        $("#birinciYari").html("");
        $("#ikinciYari").html("");
        $("#nav-statistics").html("");


        if(veri.match_ozet.length > 0 && $("#detaylar").is(":hidden")){
            $("#detaylar").show();
        }
        if(veri.match_istatistik.length > 0 && $("#istatistikler").is(":hidden")){
            $("#istatistikler").show();
        }

        for (is in veri.match_istatistik) {
            var toplam = parseFloat(veri.match_istatistik[is].veri1) + parseFloat(veri.match_istatistik[is]
                .veri3);

            $("#nav-statistics").prepend(`<div class="statistic-box mb-3">
                            <div class="row">
                                <div class="col-2">
                                    ` + veri.match_istatistik[is].veri1 + `
                                </div>
                                <div class="col-8 text-center">` + veri.match_istatistik[is].veri2 + `</div>
                                <div class="col-2 text-end">
                                ` + veri.match_istatistik[is].veri3 + `
                                </div>
                            </div>
                            <div class="row margin-5 mt-2">
                                <div class="col-6">
                                    <div class="progress first" role="progressbar" aria-label="Basic example"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-info" style="width:` + yuzde(toplam, veri
                .match_istatistik[is].veri1, veri.match_istatistik[is].veri2) + `%"></div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="progress" role="progressbar" aria-label="Basic example"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-warning" style="width:` + yuzde(toplam, veri
                .match_istatistik[is].veri3, veri.match_istatistik[is].veri2) + `%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>`);


        }


        for (oz in veri.match_ozet) {
            if (veri.match_ozet[oz].veri0 == "1. YARI") {
                var deger = ` <li `;
                if (veri.match_ozet[oz].veri1 == "Away") {
                    deger += `class="rtl"`
                }
                deger += ` >
                                    <span>` + veri.match_ozet[oz].veri2 + ` </span>`;
                if (veri.match_ozet[oz].veri3 == "Çelme takma" || veri.match_ozet[oz].veri3 == "Çekme" || veri.match_ozet[oz].veri3 == "Sarı Kart") {
                    deger += `<span class="icon yellowCard"><span></span></span>
                                    <p>`;
                } else if (veri.match_ozet[oz].veri3 == "Kırmızı Kart") {
                    deger += `<span class="icon redCard"><span></span></span>
                                    <p>`;
                } else if (veri.match_ozet[oz].veri3 == "Oyuncu Değişikliği - Çıkan") {
                    deger += `<span class="icon change"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve">
                                            <path
                                                d="M493.815 70.629c-11.001-1.003-20.73 7.102-21.733 18.102l-2.65 29.069C424.473 47.194 346.429 0 256 0 158.719 0 72.988 55.522 30.43 138.854c-5.024 9.837-1.122 21.884 8.715 26.908 9.839 5.024 21.884 1.123 26.908-8.715C102.07 86.523 174.397 40 256 40c74.377 0 141.499 38.731 179.953 99.408l-28.517-20.367c-8.989-6.419-21.48-4.337-27.899 4.651-6.419 8.989-4.337 21.479 4.651 27.899l86.475 61.761c12.674 9.035 30.155.764 31.541-14.459l9.711-106.53c1.004-11.001-7.1-20.731-18.1-21.734zM472.855 346.238c-9.838-5.023-21.884-1.122-26.908 8.715C409.93 425.477 337.603 472 256 472c-74.377 0-141.499-38.731-179.953-99.408l28.517 20.367c8.989 6.419 21.479 4.337 27.899-4.651 6.419-8.989 4.337-21.479-4.651-27.899l-86.475-61.761c-12.519-8.944-30.141-.921-31.541 14.459L.085 419.637c-1.003 11 7.102 20.73 18.101 21.733 11.014 1.001 20.731-7.112 21.733-18.102l2.65-29.069C87.527 464.806 165.571 512 256 512c97.281 0 183.012-55.522 225.57-138.854 5.024-9.837 1.122-21.884-8.715-26.908z" />
                                        </svg></span>
                                    <p> `;
                } else if (veri.match_ozet[oz].veri3 == "Gol" || veri.match_ozet[oz].veri3 == "Penaltı") {
                    deger += `<span class="icon goal">⚽<span></span></span>
                                    <p>`;
                } else if (veri.match_ozet[oz].veri3 == "VAR") {
                    deger += `<span class="icon var">VAR<span></span></span>
                                    <p>Var - `;
                } else if (veri.match_ozet[oz].veri3 == "Sarı Kart + Kırmızı Kart") {
                    deger += `<span class="icon yellowCard"><span></span></span> <span>+</span> <span
                                        class="icon redCard"><span></span></span>
                                    <p>`;
                }
                deger += veri.match_ozet[oz].veri4;
                if ((veri.match_ozet[oz].veri5)) {
                    deger += veri.match_ozet[oz].veri5
                }
                deger += ` </p>
                                </li>`;
                $("#birinciYari").append(deger);

            } else if (veri.match_ozet[oz].veri0 == "2. YARI") {
                var deger = ` <li `;
                if (veri.match_ozet[oz].veri1 == "Away") {
                    deger += `class="rtl"`
                }
                deger += ` >
                                    <span>` + veri.match_ozet[oz].veri2 + ` </span>`;
                if (veri.match_ozet[oz].veri3 == "Çelme takma" || veri.match_ozet[oz].veri3 == "Çekme") {
                    deger += `<span class="icon yellowCard"><span></span></span>
                                    <p>`;
                } else if (veri.match_ozet[oz].veri3 == "Kırmızı Kart") {
                    deger += `<span class="icon redCard"><span></span></span>
                                    <p>`;
                } else if (veri.match_ozet[oz].veri3 == "Oyuncu Değişikliği - Çıkan") {
                    deger += `<span class="icon change"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve">
                                            <path
                                                d="M493.815 70.629c-11.001-1.003-20.73 7.102-21.733 18.102l-2.65 29.069C424.473 47.194 346.429 0 256 0 158.719 0 72.988 55.522 30.43 138.854c-5.024 9.837-1.122 21.884 8.715 26.908 9.839 5.024 21.884 1.123 26.908-8.715C102.07 86.523 174.397 40 256 40c74.377 0 141.499 38.731 179.953 99.408l-28.517-20.367c-8.989-6.419-21.48-4.337-27.899 4.651-6.419 8.989-4.337 21.479 4.651 27.899l86.475 61.761c12.674 9.035 30.155.764 31.541-14.459l9.711-106.53c1.004-11.001-7.1-20.731-18.1-21.734zM472.855 346.238c-9.838-5.023-21.884-1.122-26.908 8.715C409.93 425.477 337.603 472 256 472c-74.377 0-141.499-38.731-179.953-99.408l28.517 20.367c8.989 6.419 21.479 4.337 27.899-4.651 6.419-8.989 4.337-21.479-4.651-27.899l-86.475-61.761c-12.519-8.944-30.141-.921-31.541 14.459L.085 419.637c-1.003 11 7.102 20.73 18.101 21.733 11.014 1.001 20.731-7.112 21.733-18.102l2.65-29.069C87.527 464.806 165.571 512 256 512c97.281 0 183.012-55.522 225.57-138.854 5.024-9.837 1.122-21.884-8.715-26.908z" />
                                        </svg></span>
                                    <p>`;
                } else if (veri.match_ozet[oz].veri3 == "Gol" || veri.match_ozet[oz].veri3 == "Penaltı") {
                    deger += `<span class="icon goal">⚽<span></span></span>
                                    <p>`;
                } else if (veri.match_ozet[oz].veri3 == "VAR") {
                    deger += `<span class="icon var">VAR<span></span></span>
                                    <p>Var - `;
                } else if (veri.match_ozet[oz].veri3 == "Sarı Kart + Kırmızı Kart") {
                    deger += `<span class="icon yellowCard"><span></span></span> <span>+</span> <span
                                        class="icon redCard"><span></span></span>
                                    <p>`;
                }
                deger += veri.match_ozet[oz].veri4;
                if ((veri.match_ozet[oz].veri5)) {
                    if (veri.match_ozet[oz].veri3 == "Oyuncu Değişikliği - Çıkan") {
                        deger += `(` + veri.match_ozet[oz].veri5 + `)`;
                    } else {
                        deger += veri.match_ozet[oz].veri5;
                    }
                }
                deger += ` </p>
                                </li>`;
                $("#ikinciYari").append(deger);

            }

        }
    });

    sunucu.on('yeni_mesaj', function(veri) {
        var yeni = `
                <div class="chat-item">
                    <div class="user">
                        <p class="name">` + veri.gonderen + `</p>
                        <span>` + veri.saat + `</span>
                    </div>
                    <div class="comment">
                        <p>` + veri.icerik + `</p>
                    </div>
                </div>
            `;
        $("#chat_screen").append(yeni);
        document.getElementById("chat_screen").scrollTop+=100;

    });


    $("#mesaj_gonder").on("submit", function(event) {
        if (!sunucu.connected) return bildirim("Uyarı:", "Sunucuya bağlanılamadı!");

        sunucu.emit("mesaj_gonder", {
            "mac_id": <?php echo $macid; ?>,
            "mesaj": $("#mesaj").val()
        });
        $("#mesaj").val("");

    });

    sunucu.on('uyari', function(veri) {
        bildirim(veri.baslik, veri.icerik);
    });

    function bildirim(baslik, uyari) {
        const bildirim = document.getElementById('bildirimToast');
        const bildirimTrigger = bootstrap.Toast.getOrCreateInstance(bildirim);
        $("#bildirim_icerik").html(uyari);
        $("#bildirim_baslik").html(baslik);
        bildirimTrigger.show();

    }
    </script>

    <script>
    function addFav(e) {
        e.classList.toggle("fav");
    }

    $('.encounter-more').on('click', function() {
        $(this).css('display', 'none')
    })


    new bootstrap.Toast(document.querySelector('#goalToast')).show();


    const toastTrigger = document.getElementById('sendBtn')
    const toastLiveExample = document.getElementById('loginToast')

    if (toastTrigger) {
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        toastTrigger.addEventListener('click', () => {
            toastBootstrap.show()
        })
    }
    </script>

</body>

</html>
