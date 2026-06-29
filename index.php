<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>JetScore Live Score - Canlı Skor</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta property="og:title" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <link rel="icon" href="assets/img/logo.svg" type="image/x-icon" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.min.css">
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    <link href="assets/css/daterangepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

    <?php
    
    include "inc/baglan.php";
    include "inc/fonk.php";
    $tarih = date("Y-m-d");
    
?>

</head>

<body>


    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="bildirimToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="bildirim_baslik"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="bildirim_icerik">
            </div>
        </div>
    </div>

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
                <center><a href="#" class="logo"><img style="width:100px; height:50px" src="assets/img/logo.svg"
                            alt="jetscore" title="jetscore"></a></center>
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
    <style>
    .team {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .team img {
        border-radius: 50%;
        margin: auto;
    }

    .team .text {
        flex-grow: 1;
    }

    .team h4 {
        margin: 0;
        font-size: 16px;
        font-weight: bold;
    }
    </style>
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
                            <input type="text" class="form-control" onkeyup="showResult(this.value)"
                                aria-label="Search.." placeholder="Search..">

                        </div>
                    </div>

                
                </div>
                <div id="livesearch" style="margin-top: 50px;">
                </div>


            </form>
        </div>
    </div>



    <section id="categories" class="mb-3">
        <div class="container pe-0">
            <ul>
                <li>
                    <a href="#" class="futbol active">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" fill="none">
                            <mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="21">
                                <path fill="#D9D9D9" d="M0 .5h20v20H0z" />
                            </mask>
                            <g mask="url(#a)" stroke="#fff" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
                                <path
                                    d="m3.936 6.1 1.148 2.777-2.548 2.305M7.5 3.417 10 5.083l2.5-1.666M8.106 17.72l-.846-2.884-3.43-.198M11.989 17.72l.846-2.884 3.43-.198M16.083 6.1l-1.148 2.777 2.548 2.305M10 8 7.5 9.667 8.333 13h3.334l.833-3.333L10 8Z" />
                            </g>
                        </svg>
                        <span>Futbol</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="basketbol">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none">
                            <g>
                                <mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                                    <path fill="#D9D9D9" d="M0 0h20v20H0z" />
                                </mask>
                                <g mask="url(#a)" stroke="#fff" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10 17.5a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
                                    <path d="M13.533 16.616c0-5.606-4.523-10.155-10.118-10.2" />
                                    <path
                                        d="M10.806 2.686a7.5 7.5 0 0 1-8.195 8.113M9.2 17.38a7.5 7.5 0 0 1 8.079-8.189" />
                                </g>
                            </g>
                        </svg>
                        <span>Basketbol</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="voleybol" data-bs-container="body" data-bs-toggle="popover"
                        data-bs-trigger="focus" data-bs-placement="bottom" data-bs-content="Çok yakında..">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none">
                            <g>
                                <mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                                    <path fill="#D9D9D9" d="M0 0h20v20H0z" />
                                </mask>
                                <g mask="url(#a)" stroke="#fff" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10 17.5a7.5 7.5 0 1 0 0-15 7.5 7.5 0 0 0 0 15Z" />
                                    <path d="M10 10a6.667 6.667 0 0 0 6.667 3.333M6.25 11.25a10 10 0 0 0 7.083 5.417" />
                                    <path d="M10 10a6.667 6.667 0 0 0-6.22 4.107M10.793 6.127A10 10 0 0 0 2.56 9.553" />
                                    <path d="M10 10a6.667 6.667 0 0 0-.447-7.44M12.957 12.623a10 10 0 0 0 1.15-8.843" />
                                </g>
                            </g>
                        </svg>
                        <span>Voleybol</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="afutbol" data-bs-container="body" data-bs-toggle="popover"
                        data-bs-trigger="focus" data-bs-placement="bottom" data-bs-content="Çok yakında..">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none">
                            <g>
                                <mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                                    <path fill="#D9D9D9" d="M0 0h20v20H0z" />
                                </mask>
                                <g mask="url(#a)" stroke="#fff" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M6.76 17.419a4.16 4.16 0 0 0-4.16-4.16M13.25 2.587a4.16 4.16 0 0 0 4.16 4.16M11.961 8.037l-4.215 4.216M11.732 10.356 9.639 8.264M10.063 12.023 7.971 9.93" />
                                    <path
                                        d="M17.478 6.553c.081-1.173-.056-2.504-.792-3.24-.732-.733-2.06-.875-3.244-.792A11.767 11.767 0 0 0 2.52 13.475c-.08 1.181.06 2.483.776 3.205.729.735 2.045.88 3.224.801A11.767 11.767 0 0 0 17.478 6.553Z" />
                                </g>
                            </g>
                        </svg>
                        <span>Amerikan Futbolu</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="tenis" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="focus"
                        data-bs-placement="bottom" data-bs-content="Çok yakında..">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none">
                            <g opacity=".6">
                                <mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                                    <path fill="#D9D9D9" d="M0 0h20v20H0z" />
                                </mask>
                                <g mask="url(#a)" stroke="#fff" stroke-linecap="round" stroke-linejoin="round">
                                    <path clip-rule="evenodd"
                                        d="M15.303 15.303A7.5 7.5 0 1 1 4.697 4.697a7.5 7.5 0 1 1 10.607 10.606Z" />
                                    <path
                                        d="M9.588 2.516a7.5 7.5 0 0 0 7.896 7.896M2.517 9.588a7.5 7.5 0 0 1 7.895 7.896M12.5 7.5l-1.666 1.667M9.167 10.833 7.5 12.5M10.834 5.833l-1.667.834M14.167 9.167l-.833 1.666M6.667 9.167l-.833 1.666M10.834 13.333l-1.667.834" />
                                </g>
                            </g>
                        </svg>
                        <span>Tenis</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="tenis" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="focus"
                        data-bs-placement="bottom" data-bs-content="Çok yakında..">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none">
                            <g opacity=".6">
                                <mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                                    <path fill="#D9D9D9" d="M0 0h20v20H0z" />
                                </mask>
                                <g mask="url(#a)" stroke="#fff" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10 17.5a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
                                    <path
                                        d="M5 4.41A7.481 7.481 0 0 1 7.5 10 7.481 7.481 0 0 1 5 15.59M15 4.41A7.482 7.482 0 0 0 12.5 10c0 2.222.966 4.217 2.5 5.59" />
                                </g>
                            </g>
                        </svg>
                        <span>Tenis</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="container">
            <div class="info-boxes">
                <div class="calendar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" fill="none">
                        <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="20"
                            height="21">
                            <path fill="#D9D9D9" d="M0 .5h20v20H0z" />
                        </mask>
                        <g mask="url(#a)" stroke="#418DFF" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M13.056 3v2.686M6.535 3v2.686" />
                            <path clip-rule="evenodd"
                                d="M13.534 4.239h-7.47C3.87 4.24 2.5 5.461 2.5 7.707v6.761C2.5 16.75 3.87 18 6.064 18h7.463c2.201 0 3.564-1.23 3.564-3.476V7.706c.007-2.246-1.357-3.467-3.557-3.467Z" />
                            <path
                                d="M6.17 9.992h.008M6.17 13.11h.008M9.792 9.992H9.8M9.792 13.11H9.8M13.405 9.992h.009M13.405 13.11h.009" />
                        </g>
                    </svg>
                    <select onchange="tarihSec()" id="selectpicker" class="selectpicker">
                 

                        <?php for($i=-7;$i<=7;$i++){
                            if($i != 0){ ?>
                        <option  value="<?php echo date('Y-m-d', strtotime($i.'days')) ?>" ><?php echo date('d/m/Y', strtotime($i.'days')) ?></option>
                        <?php }else{ ?>
                        <option  value="<?php echo date('Y-m-d') ?>" selected >Bugün</option>
                        <?php }} ?>
                    </select>

                </div>
                <div class="live">
                    <div class="text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none">
                            <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="20"
                                height="20">
                                <path fill="#D9D9D9" d="M0 0h20v20H0z" />
                            </mask>
                            <g mask="url(#a)" stroke="#FF565E" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M17.5 10a7.5 7.5 0 1 0-15 0 7.5 7.5 0 0 0 15 0Z" />
                                <path
                                    d="M6.408 13.101a4.704 4.704 0 0 1-1.16-3.095c0-1.191.433-2.273 1.16-3.11M13.592 6.898a4.714 4.714 0 0 1 1.16 3.11 4.703 4.703 0 0 1-1.16 3.095" />
                                <path clip-rule="evenodd"
                                    d="M10 8.22a1.78 1.78 0 1 1 0 3.558 1.78 1.78 0 0 1 0-3.559Z" />
                            </g>
                        </svg>
                        <span>Canlı</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"
                            checked>
                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <div style="display:none;" id="loaders">
        <img src="loader.gif" style="width:100%;" alt="">
        <img src="loader.gif" style="width:100%;" alt="">
        <img src="loader.gif" style="width:100%;" alt="">
    </div>
    <div id="maclars">



    </div>



    <footer></footer>

    <script>
    var sunucu = null;
    var macBilgi = {};
    sunucu = io("https://jetskor.xyz:4444");
    sunucu.on('reconnect', function() {
        window.location.reload();
    });
    sunucu.on('connect', function() {
        sunucu.emit("canli_aktif");
        //sunucu.emit("anasayfa");

        <?php 
            if(isset($_SESSION["user"])){
        ?>
        sunucu.emit("anasayfa", {
            "user_id": "<?php echo $_SESSION["user"]; ?>"
        });
        <?php }else{ ?>
        sunucu.emit("anasayfa");
        <?php } ?>

        //$("#loaders").show();
    });
    sunucu.on('disconnect', function() {
    });

    sunucu.on('mac_kaldir', function(veri) {
        $("#match_id_" + veri.match_id).remove();
        delete macBilgi[veri.match_id];

        var ligKontrol = $('#' + seoUrl(veri.match_league) + ' .match-wrap').length;
        if (ligKontrol < 1) {
            $('#' + seoUrl(veri.match_league)).remove();
        }
    });

    sunucu.on('mac_bilgi', async function(veri) {
        if (!(macBilgi[veri.match_id])) {
            macBilgi[veri.match_id] = {};
            macBilgi[veri.match_id].eklendi = 0;
        }
        if (!$(".matches").length) {
            $("#maclars").append(`
                    <section id="matches">
                        <div class="container" id="ligler">

                        </div>
                    </div>
                `);
        }
        /*  */
        if (!$("#" + seoUrl(veri.match_league)).length) {
            $("#ligler").append(`
                    <div class="league" id="` + seoUrl(veri.match_league) + `">
                        <div class="league-title">
                            <div class="league-img">
                                <img src="` + veri.match_countryimg + `" alt="premier league" title="premier league" width="32" height="32">
                            </div>
                            <div class="league-txt">
                                <p>` + veri.match_country + `: ` + veri.match_league + `</p>
                            </div>
                        </div>

                    </div>
                `);
        }
        var zamanDurum = "";
        if (veri.match_status == 2) {
            zamanDurum = "Devre Arası";
        } else {
            if (veri.match_addedtime.length != 0) {
                zamanDurum = veri.match_eventtime + "(" + veri.match_addedtime + ")";
            } else {
                zamanDurum = veri.match_eventtime;
            }
        }
        var favori_kontrol = "";
        if (veri.match_favorite == 1) {
            favori_kontrol = "fav";
        }
        if ( /*!$("#match_id_" + veri.match_id).length*/ macBilgi[veri.match_id].eklendi == 0) {
            var logo_home = "",
                logo_away = "";
            try {
                if (await checkIfImageExists(veri.match_homepng)) {
                    logo_home = veri.match_homepng;
                } else {
                    logo_home = "assets/img/yok.png";
                }

            } catch (error) {
                logo_home = "assets/img/yok.png";
            }

            try {
                if (await checkIfImageExists(veri.match_awaypng)) {
                    logo_away = veri.match_awaypng;
                } else {
                    logo_away = "assets/img/yok.png";
                }
            } catch (error) {
                logo_away = "assets/img/yok.png";
            }

            macBilgi[veri.match_id].homeLogo = logo_home;
            macBilgi[veri.match_id].awayLogo = logo_away;



            $("#" + seoUrl(veri.match_league)).append(`
                    <div class="match-wrap" id="match_id_` + veri.match_id + `">
                        <a href="match.php?id=` + veri.match_id + `" class="match-item">
                            <div class="time">
                                <span>` + zamanDurum + `</span>
                                <img src="assets/img/time-border.png" alt="">
                            </div>

                            <div class="teams">
                                <div class="team">
                                    <img src="` + logo_home + `" alt="" width="48" height="48">
                                    <p>` + veri.match_home + `</p>
                                </div>
                                <div class="score">
                                    <div class="number">
                                        <p style="color: red;">` + veri.match_homegol + `</p>
                                        <span>:</span>
                                        <p style="color: red;">` + veri.match_awaygol + `</p>
                                    </div>
                                </div>
                                <div class="team">
                                    <img src="` + logo_away + `" alt="" width="48" height="48">
                                    <p>` + veri.match_away + `</p>
                                </div>
                            </div>
                        </a>
                        <button id="favori_` + veri.match_id + `" class="favourite ` + favori_kontrol +
                `" onclick="favori(` + veri.match_id + `)">
                            <svg class="inactive" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="18" height="18"><path fill="#D9D9D9" d="M.5.5h20v20H.5z"/></mask><g mask="url(#a)"><path clip-rule="evenodd" d="m11.42 3.564 1.523 3.042c.15.3.437.506.771.554l3.407.49c.842.122 1.177 1.142.568 1.727l-2.464 2.367a1.003 1.003 0 0 0-.295.896l.582 3.341c.143.827-.737 1.458-1.49 1.067l-3.044-1.58a1.04 1.04 0 0 0-.956 0l-3.045 1.58c-.752.39-1.632-.24-1.488-1.066l.58-3.342a1.003 1.003 0 0 0-.294-.896L3.31 9.377c-.609-.585-.274-1.605.568-1.726l3.407-.49c.334-.049.623-.256.772-.555L9.58 3.564c.376-.752 1.464-.752 1.84 0Z" stroke="#000" stroke-linecap="round" stroke-linejoin="round"/></g></svg>
                            <svg class="active" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="18" height="18"><path fill="#D9D9D9" d="M0 0h20v20H0z"/></mask><g mask="url(#a)"><path fill-rule="evenodd" clip-rule="evenodd" d="m10.92 3.064 1.523 3.042c.15.3.437.506.771.554l3.407.49c.842.122 1.177 1.142.568 1.727l-2.464 2.367a1.003 1.003 0 0 0-.295.896l.582 3.341c.143.827-.737 1.458-1.49 1.067l-3.044-1.58a1.04 1.04 0 0 0-.956 0l-3.045 1.58c-.752.39-1.632-.24-1.488-1.066l.58-3.342a1.003 1.003 0 0 0-.294-.896L2.81 8.877c-.609-.585-.274-1.605.568-1.726l3.407-.49c.334-.049.623-.256.772-.555L9.08 3.064c.376-.752 1.464-.752 1.84 0Z" fill="#FFA800" stroke="#FFA800" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></g></svg>
                        </button>
                    </div>
                `);

            macBilgi[veri.match_id].eklendi = 1;

            divKontrol(veri.match_id);
            //$("#loaders").hide();
        } else {
            //güncelleme işlemi
            $("#match_id_" + veri.match_id).html(`
                    <a href="match.php?id=` + veri.match_id + `" class="match-item">
                        <div class="time">
                            <span>` + zamanDurum + `</span>
                            <img src="assets/img/time-border.png" alt="">
                        </div>

                        <div class="teams">
                            <div class="team">
                                <img src="` + macBilgi[veri.match_id].homeLogo + `" alt="" width="48" height="48">
                                <p>` + veri.match_home + `</p>
                            </div>
                            <div class="score">
                                <div class="number">
                                    <p style="color: red;">` + veri.match_homegol + `</p>
                                    <span>:</span>
                                    <p style="color: red;">` + veri.match_awaygol + `</p>
                                </div>
                            </div>
                            <div class="team">
                                <img src="` + macBilgi[veri.match_id].awayLogo + `" alt="" width="48" height="48">
                                <p>` + veri.match_away + `</p>
                            </div>
                        </div>
                    </a>
                    <button id="favori_` + veri.match_id + `" class="favourite ` + favori_kontrol +
                `" onclick="favori(` + veri.match_id + `)">
                        <svg class="inactive" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="18" height="18"><path fill="#D9D9D9" d="M.5.5h20v20H.5z"/></mask><g mask="url(#a)"><path clip-rule="evenodd" d="m11.42 3.564 1.523 3.042c.15.3.437.506.771.554l3.407.49c.842.122 1.177 1.142.568 1.727l-2.464 2.367a1.003 1.003 0 0 0-.295.896l.582 3.341c.143.827-.737 1.458-1.49 1.067l-3.044-1.58a1.04 1.04 0 0 0-.956 0l-3.045 1.58c-.752.39-1.632-.24-1.488-1.066l.58-3.342a1.003 1.003 0 0 0-.294-.896L3.31 9.377c-.609-.585-.274-1.605.568-1.726l3.407-.49c.334-.049.623-.256.772-.555L9.58 3.564c.376-.752 1.464-.752 1.84 0Z" stroke="#000" stroke-linecap="round" stroke-linejoin="round"/></g></svg>
                        <svg class="active" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="18" height="18"><path fill="#D9D9D9" d="M0 0h20v20H0z"/></mask><g mask="url(#a)"><path fill-rule="evenodd" clip-rule="evenodd" d="m10.92 3.064 1.523 3.042c.15.3.437.506.771.554l3.407.49c.842.122 1.177 1.142.568 1.727l-2.464 2.367a1.003 1.003 0 0 0-.295.896l.582 3.341c.143.827-.737 1.458-1.49 1.067l-3.044-1.58a1.04 1.04 0 0 0-.956 0l-3.045 1.58c-.752.39-1.632-.24-1.488-1.066l.58-3.342a1.003 1.003 0 0 0-.294-.896L2.81 8.877c-.609-.585-.274-1.605.568-1.726l3.407-.49c.334-.049.623-.256.772-.555L9.08 3.064c.376-.752 1.464-.752 1.84 0Z" fill="#FFA800" stroke="#FFA800" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></g></svg>
                    </button>
                
                `);
        }
    });

    sunucu.on('favori_ekle', function(veri) {
        $("#favori_" + veri.match_id).addClass("fav");
    });

    sunucu.on('favori_kaldir', function(veri) {
        $("#favori_" + veri.match_id).removeClass("fav");
    });

    function favori(idMac) {
        sunucu.emit("favori", {
            "match_id": idMac
        });
    }

    function divKontrol(id) {
        var seen = {};
        $('#match_id_' + id).each(function() {
            if (seen[this.id]) {
                $(this).remove();
            } else {
                seen[this.id] = true;
            }
        });
    }

    function seoUrl(url) {
        return url.toString()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/\s+/g, '-')
            .toLowerCase()
            .replace(/&/g, '-and-')
            .replace(/[^a-z0-9\-]/g, '')
            .replace(/-+/g, '-')
            .replace(/^-*/, '')
            .replace(/-*$/, '');
    }
    /*function checkIfImageExists(url, callback) {
        const img = new Image();
        img.src = url;

        if (img.complete) {
            callback(true);
        }
        else
        {
            img.onload = () => {
                callback(true);
            };
            
            img.onerror = () => {
                callback(false);
            };
        }
    }*/

    function checkIfImageExists(url) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.src = url;

            img.onload = () => resolve(true);
            img.onerror = () => reject(false);
        });
    }
    </script>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.min.js"></script>

    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/daterangepicker.js"></script>
    <script src="assets/js/bootstrap-select.js"></script>


    <script>
    var tarih = "<?php echo $tarih ?>";

    document.getElementById("flexSwitchCheckChecked").checked = false;


    function showResult(str) {
        if (str.length == 0) {
            document.getElementById("livesearch").innerHTML = "";
            document.getElementById("livesearch").style.border = "0px";
            return;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("livesearch").innerHTML = this.responseText;
                document.getElementById("livesearch").style.border = " #A5ACB2";
                var element = document.getElementById("offcanvasSearch");
                element.style.height = "600px";
            }
        }
        xmlhttp.open("GET", "livesearch.php?q=" + str, true);
        xmlhttp.send();
    }
    </script>
    <script>
    //1 canlı



    $('#flexSwitchCheckChecked').click(function() {
        if ($(this).is(':checked')) {
            //$("#loaders").show();
            //$(".datepicker").prop('disabled', true);
            $("#maclars").html("");
            sunucu.emit("canli_aktif");
            //sunucu.emit("anasayfa");
        
        } else {
            //$("#loaders").show();
            //$(".datepicker").prop('disabled', false);
            tarihSec();
            sunucu.emit("canli_inaktif");
            for (mac in macBilgi) {
                delete macBilgi[mac];
            }

        }
    });

    // Tarihe Göre Maçları Listeler
    var ilk = 0;

    function tarihSec() {
   
        tarih = document.getElementById('selectpicker').value;

        $("#maclars").html("");
        $("#maclars").load("maclar.php?tarih=" + tarih);
    }



    function addFav(e) {
        e.classList.toggle("fav");
    }

    tarihSec()

    function bildirim(baslik, uyari) {
        const bildirim = document.getElementById('bildirimToast');
        const bildirimTrigger = bootstrap.Toast.getOrCreateInstance(bildirim);
        $("#bildirim_icerik").html(uyari);
        $("#bildirim_baslik").html(baslik);
        bildirimTrigger.show();

    }
    </script>

</body>

</html>
