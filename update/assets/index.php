<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home | JetScore</title>
    <meta charset="UTF-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta property="og:title" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.min.css">

    <link href="assets/css/daterangepicker.css" rel="stylesheet">
    <?php
    
include "inc/baglan.php";
include "inc/fonk.php";
$tarih = date("Y-m-d");
?>

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
                    <a href="#"><svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
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

    <div class="offcanvas offcanvas-start" tabindex="-1" id="sideMenu" aria-labelledby="sideMenuLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="sideMenuLabel">JetScore</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

      <div class="row">
        <div class="col-lg-12 mb-3">
          <a href="profile.html" class="btn btn-primary d-flex align-items-center justify-content-center"><svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="24" height="24" fill="#000000" viewBox="0 0 256 256"><path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24ZM74.08,197.5a64,64,0,0,1,107.84,0,87.83,87.83,0,0,1-107.84,0ZM96,120a32,32,0,1,1,32,32A32,32,0,0,1,96,120Zm97.76,66.41a79.66,79.66,0,0,0-36.06-28.75,48,48,0,1,0-59.4,0,79.66,79.66,0,0,0-36.06,28.75,88,88,0,1,1,131.52,0Z"></path></svg> Profilim</a>
        </div>
        <div class="col-6 mb-3">
          <a href="login.html" class="btn btn-primary d-flex align-items-center justify-content-center"><svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="24" height="24" fill="#000000" viewBox="0 0 256 256"><path d="M141.66,133.66l-40,40a8,8,0,0,1-11.32-11.32L116.69,136H24a8,8,0,0,1,0-16h92.69L90.34,93.66a8,8,0,0,1,11.32-11.32l40,40A8,8,0,0,1,141.66,133.66ZM192,32H136a8,8,0,0,0,0,16h56V208H136a8,8,0,0,0,0,16h56a16,16,0,0,0,16-16V48A16,16,0,0,0,192,32Z"></path></svg> Üye Girişi</a>
        </div>
        <div class="col-6 mb-3">
          <a href="signup.html" class="btn btn-primary d-flex align-items-center justify-content-center"><svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="24" height="24" fill="#000000" viewBox="0 0 256 256"><path d="M168,56a8,8,0,0,1,8-8h16V32a8,8,0,0,1,16,0V48h16a8,8,0,0,1,0,16H208V80a8,8,0,0,1-16,0V64H176A8,8,0,0,1,168,56Zm62.56,54.68a103.92,103.92,0,1,1-85.24-85.24,8,8,0,0,1-2.64,15.78A88.07,88.07,0,0,0,40,128a87.62,87.62,0,0,0,22.24,58.41A79.66,79.66,0,0,1,98.3,157.66a48,48,0,1,1,59.4,0,79.66,79.66,0,0,1,36.06,28.75A87.62,87.62,0,0,0,216,128a88.85,88.85,0,0,0-1.22-14.68,8,8,0,1,1,15.78-2.64ZM128,152a32,32,0,1,0-32-32A32,32,0,0,0,128,152Zm0,64a87.57,87.57,0,0,0,53.92-18.5,64,64,0,0,0-107.84,0A87.57,87.57,0,0,0,128,216Z"></path></svg> Üye Ol</a>
        </div>
      </div>


      <ul class="main-menu">
        <li><a class="dropdown-item" href="#">Anasayfa</a></li>
        <li><a class="dropdown-item" href="#">Hakkımızda</a></li>
        <li><a class="dropdown-item" href="#">Tahminler</a></li>
        <li><a class="dropdown-item" href="#">Skorlar</a></li>
        <li><a class="dropdown-item" href="#">İletişim</a></li>
      </ul>

      <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
          <span class="d-flex align-items-center"><img src="assets/img/flags/tr.svg" width="20" class="me-2" alt="turkish" title="turkish"> Türkçe</span>
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Turkish</a></li>
          <li><a class="dropdown-item" href="#">English</a></li>
          <li><a class="dropdown-item" href="#">French</a></li>
        </ul>
      </div>
    </div>
  </div>

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
              <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#000000" viewBox="0 0 256 256"><path d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"></path></svg></span>
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
                    <input onchange="tarihSec()"  id="tarih" class="datepicker" name="date"
                        pattern="\d{4}-\d{2}-\d{2}">
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
                            onchange="canliMaclar()" checked>
                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <div id="maclar">

    </div>


    <footer></footer>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.min.js"></script>

    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/daterangepicker.js"></script>

    <script>

    var canli = 1;
    var tarih = "<?php echo $tarih ?>";
    
    // Canlı Maçları Listeler
    function canliMaclar() {

        if (canli == 1) {
            $("#maclar").load("maclar.php?canli=0&tarih=" + tarih);
            canli = 0;
        } else {
            $("#maclar").load("maclar.php?canli=1&tarih=" + tarih);
            canli = 1;
        }
    }

    // Tarihe Göre Maçları Listeler
    function tarihSec() {
        var tarihtxt = document.getElementsByClassName("drp-selected")[0].innerText;
        const tariharry = tarihtxt.split(" ");
        if(tariharry == ""){
        tarih = "<?php echo $tarih ?>"; 
        }else{
        tarih = tariharry[0];
        }
        $("#maclar").load("maclar.php?tarih=" + tarih +"&canli="+canli);
    }
    
  

    function addFav(e) {
        e.classList.toggle("fav");
    }
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

    $(function() {
        $('input[name="date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "locale": {
                "format": "YYYY-MM-DD",
                "separator": " - ",
                "applyLabel": "Uygula",
                "cancelLabel": "Vazgeç",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Pzr",
                    "Pzrt",
                    "Sal",
                    "Çar",
                    "Per",
                    "Cum",
                    "Cmrt"
                ],
                "monthNames": [
                    "Ocak",
                    "Şubat",
                    "Mart",
                    "Nisan",
                    "Mayıs",
                    "Haziran",
                    "Temmuz",
                    "Ağustos",
                    "Eylül",
                    "Ekim",
                    "Kasım",
                    "Aralık"
                ],
                "firstDay": 1
            },
        });
    });
    </script>

</body>

</html>