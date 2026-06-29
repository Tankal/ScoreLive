<!DOCTYPE html>
<html lang="en">
<?php
include "inc/baglan.php";
include "inc/fonk.php";
$lig_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$lig_id) {
    http_response_code(404);
    exit("League not found.");
}
$sorgulig=$db->prepare("SELECT * FROM ligler where id =$lig_id");
$sorgulig->execute();
$satirlig = $sorgulig->fetch(PDO::FETCH_ASSOC);
?>

<head>
    <meta charset="UTF-8">
    <title>League | JetScore</title>
    <meta charset="UTF-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta property="og:title" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="assets/css/main.min.css">


</head>

<body>

    <header>
        <div class="container">
            <nav>
                <button type="button" class="menu" data-bs-toggle="offcanvas" data-bs-target="#sideMenu"
                    aria-controls="sideMenu"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                        <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24"
                            height="24">
                            <path fill="#D9D9D9" d="M0 0h24v24H0z" />
                        </mask>
                        <g mask="url(#a)">
                            <path d="M3 8h18M3 16h18" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </g>
                    </svg></button>
                <a href="#" class="logo"><img src="assets/img/logo.svg" alt="jetscore" title="jetscore"></a>
                <div class="actions">
                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch"><svg width="24" height="24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24"
                                height="24">
                                <path fill="#D9D9D9" d="M0 0h24v24H0z" />
                            </mask>
                            <g mask="url(#a)">
                                <path d="m21 21-3.49-3.49m0 0A8.5 8.5 0 1 0 5.49 5.49a8.5 8.5 0 0 0 12.02 12.02Z"
                                    stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                        </svg></a>
                    <a href="#" class="favorites"><svg width="24" height="24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24"
                                height="24">
                                <path fill="#D9D9D9" d="M0 0h24v24H0z" />
                            </mask>
                            <g mask="url(#a)">
                                <path clip-rule="evenodd"
                                    d="m13.104 3.677 1.828 3.65c.179.36.524.608.925.665l4.088.589c1.01.145 1.412 1.37.681 2.07l-2.956 2.841c-.29.28-.423.681-.354 1.076l.698 4.01c.172.992-.884 1.749-1.787 1.28l-3.654-1.895a1.248 1.248 0 0 0-1.146 0l-3.654 1.894c-.903.47-1.959-.287-1.786-1.28l.697-4.01a1.203 1.203 0 0 0-.354-1.075l-2.956-2.84c-.731-.701-.33-1.926.68-2.071l4.089-.589c.4-.057.747-.306.926-.664l1.827-3.651c.452-.903 1.756-.903 2.208 0Z"
                                    stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                        </svg></a>
                </div>
            </nav>
        </div>
    </header>

    <?php
   include "sidebar.php";
   ?>
    <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasSearch" aria-labelledby="offcanvasTopLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasTopLabel">Search</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form class="custom-form">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="#000000" viewBox="0 0 256 256">
                                    <path
                                        d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z">
                                    </path>
                                </svg></span>
                            <input type="text" class="form-control" aria-label="Search.." placeholder="Search..">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <button type="submit" class="btn submit-btn">Ara</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <section id="text">
        <div class="card p-0">
            <div class="card-header p-3">
                <div class="league-content">
                    <div class="league-img">
                        <img src="assets/img/<?=$satirlig["logo"]?>" width="70" alt="bundesliga" title="bundesliga">
                    </div>

                    <div class="league-txt">
                        <h1><?=$satirlig["isim"]?></h1>
                        <small>2023/2024</small>
                    </div>

                </div>
            </div>
            <div class="card-body pt-0">
                <nav class="custom-tab">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-sonuclar-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-sonuclar" type="button" role="tab" aria-controls="nav-sonuclar"
                            aria-selected="true">SONUÇLAR</button>
                        <button class="nav-link" id="nav-fikstur-tab" data-bs-toggle="tab" data-bs-target="#nav-fikstur"
                            type="button" role="tab" aria-controls="nav-fikstur" aria-selected="false">FİKSTÜR</button>
                        <button class="nav-link" id="nav-puan-tab" data-bs-toggle="tab" data-bs-target="#nav-puan"
                            type="button" role="tab" aria-controls="nav-puan" aria-selected="false">PUAN DURUMU</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-sonuclar" role="tabpanel"
                        aria-labelledby="nav-sonuclar-tab" tabindex="0">
                        <?php
                        
                        $sorguh2h = $db->prepare("SELECT * FROM maclar WHERE durum = 4 AND lig_id = $lig_id ORDER BY mac_tarihi DESC");
                        $sorguh2h->execute();
                        $oncekitarih="";
                        while($satirh2h = $sorguh2h->fetch(PDO::FETCH_ASSOC)){ 
                        $takim1id=$satirh2h["takim1_id"];
                        $takim2id=$satirh2h["takim2_id"];

                        $detaysorgutakim1=$db->prepare("SELECT * FROM takimlar where id =$takim1id");
                        $detaysorgutakim1->execute();
                        $detaysatirtakim1 = $detaysorgutakim1->fetch(PDO::FETCH_ASSOC);
                        
                        // Detay Deplasman Takımı Sorgusu
                        $detaysorgutakim2=$db->prepare("SELECT * FROM takimlar where id =$takim2id");
                        $detaysorgutakim2->execute();
                        $detaysatirtakim2 = $detaysorgutakim2->fetch(PDO::FETCH_ASSOC);
                        if($oncekitarih != tarihDuzelt($satirh2h["mac_tarihi"])){
                        ?>
                        <div class="divider">
                            <?=tarihDuzelt($satirh2h["mac_tarihi"])?>
                        </div>
                        <?php } ?>
                        <a href="#" class="match-list-item">
                            <div class="team-row">
                                <div class="team">
                                    <img src="<?= $detaysatirtakim1["logo"] ?>" alt="" width="20" height="20">
                                    <p><?= $detaysatirtakim1["isim"] ?></p>
                                </div>
                                <div class="result"><?= $satirh2h["takim1_skor"] ?></div>
                            </div>
                            <div class="team-row">
                                <div class="team">
                                    <img src="<?= $detaysatirtakim2["logo"] ?>" alt="" width="20" height="20">
                                    <p><strong><?= $detaysatirtakim2["isim"] ?></strong></p>
                                </div>
                                <div class="result"><strong><?= $satirh2h["takim2_skor"] ?></strong></div>
                            </div>
                            <span><?=sadeSaat($satirh2h["mac_tarihi"])?></span>
                        </a>

                        <?php $oncekitarih=tarihDuzelt($satirh2h["mac_tarihi"]); } ?>




                    </div>
                    <div class="tab-pane fade" id="nav-fikstur" role="tabpanel" aria-labelledby="nav-fikstur-tab"
                        tabindex="0">

                        <?php
                        
                        $sorguh2h = $db->prepare("SELECT * FROM maclar WHERE durum = 0 AND lig_id = $lig_id ORDER BY mac_tarihi DESC");
                        $sorguh2h->execute();
                        $oncekitarih2="";
                        while($satirh2h = $sorguh2h->fetch(PDO::FETCH_ASSOC)){ 
                        $takim1id=$satirh2h["takim1_id"];
                        $takim2id=$satirh2h["takim2_id"];

                        $detaysorgutakim1=$db->prepare("SELECT * FROM takimlar where id =$takim1id");
                        $detaysorgutakim1->execute();
                        $detaysatirtakim1 = $detaysorgutakim1->fetch(PDO::FETCH_ASSOC);
                        
                        // Detay Deplasman Takımı Sorgusu
                        $detaysorgutakim2=$db->prepare("SELECT * FROM takimlar where id =$takim2id");
                        $detaysorgutakim2->execute();
                        $detaysatirtakim2 = $detaysorgutakim2->fetch(PDO::FETCH_ASSOC);
                        if($oncekitarih2 != tarihDuzelt($satirh2h["mac_tarihi"])){
                        ?>
                        <div class="divider">
                            <?=tarihDuzelt($satirh2h["mac_tarihi"])?>
                        </div>
                        <?php } ?>

                        <a href="#" class="match-list-item v2">
                            <div class="team-row">
                                <div class="team">
                                    <img src="<?= $detaysatirtakim1["logo"] ?>" alt="" width="20" height="20">
                                    <p><?= $detaysatirtakim1["isim"] ?></p>
                                </div>
                                <div class="result"><?= $satirh2h["takim1_skor"] ?></div>
                            </div>
                            <div class="team-row">
                                <div class="team">
                                    <img src="<?= $detaysatirtakim2["logo"] ?>" alt="" width="20" height="20">
                                    <p><strong><?= $detaysatirtakim2["isim"] ?></strong></p>
                                </div>
                                <div class="result"><strong><?= $satirh2h["takim2_skor"] ?></strong></div>
                            </div>
                            <span><?=sadeSaat($satirh2h["mac_tarihi"])?></span>
                        </a>
                        <?php $oncekitarih2=tarihDuzelt($satirh2h["mac_tarihi"]); } ?>

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
                                                <img src="<?=$satirpuantakim["logo"]?>" alt="" width="48" height="48">
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
                </div>
            </div>
        </div>
    </section>



    <footer></footer>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-select.js"></script>
    <script src="assets/js/main.min.js"></script>


</body>

</html>
