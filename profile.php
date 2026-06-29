<!DOCTYPE html>
<html lang="en">

<?php 
include "inc/baglan.php";
include "inc/fonk.php";
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
$id = (int) $_SESSION["user"];
$sorgu=$db->prepare("SELECT * FROM kullanici WHERE id = :id LIMIT 1");
$sorgu->execute(['id' => $id]);
$kullanici=$sorgu->fetch(PDO::FETCH_ASSOC); 
if (!$kullanici) {
    unset($_SESSION["user"]);
    header("Location: login.php");
    exit;
}
?>

<head>
    <meta charset="UTF-8">
    <title>Profile | JetScore</title>
    <meta charset="UTF-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta property="og:title" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.min.css">


</head>

<body>
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="uyaritablo" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong id="uyari_baslik" class="me-auto"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <span id="uyari_icerik"></span>
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
    <?php include "sidebar.php"  ?>

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



    <section id="profile">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    Profile Settings
                </div>
                <div class="card-body">
                    <form id="profile_form" class="custom-form" method="post" action="javascript:void(0)">

                        <!-- <div class="avatar-upload">
                        <div class="avatar-edit">
                            <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                            <label for="imageUpload"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#000000" viewBox="0 0 256 256"><path d="M224,152v56a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V152a8,8,0,0,1,16,0v56H208V152a8,8,0,0,1,16,0ZM93.66,85.66,120,59.31V152a8,8,0,0,0,16,0V59.31l26.34,26.35a8,8,0,0,0,11.32-11.32l-40-40a8,8,0,0,0-11.32,0l-40,40A8,8,0,0,0,93.66,85.66Z"></path></svg></label>
                        </div>
                        <div class="avatar-preview">
                            <img class="profile-user-img img-responsive img-circle" id="imagePreview" src="assets/img/avatar.png" alt="User profile picture">
                        </div>
                      </div>  -->

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="#000000" viewBox="0 0 256 256">
                                            <path
                                                d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z">
                                            </path>
                                        </svg></span>
                                    <input name="isim" id="isim" type="text" class="form-control" aria-label="Ad"
                                        placeholder="Ad" value="<?=$kullanici["isim"]?>">
                                    <input type="hidden" name="id" value="<?=$kullanici["id"]?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="#000000" viewBox="0 0 256 256">
                                            <path
                                                d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z">
                                            </path>
                                        </svg></span>
                                    <input name="soyisim" id="soyisim" type="text" class="form-control"
                                        aria-label="Soyad" placeholder="Soyad" value="<?=$kullanici["soyisim"]?>">
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><svg width="24" height="24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                        width="24" height="24">
                                        <path fill="#D9D9D9" d="M0 0h24v24H0z"></path>
                                    </mask>
                                    <g mask="url(#a)" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M21 15.194c0 2.765-1.845 5.013-4.582 5.006H7.582C4.845 20.207 3 17.96 3 15.194V9.013C3 6.25 4.845 4 7.582 4h8.836C19.155 4 21 6.25 21 9.013v6.181Z">
                                        </path>
                                        <path
                                            d="m17.305 9.01-4 3.251a2.069 2.069 0 0 1-2.573 0L6.7 9.01M9.963 11.642 6.695 15.19m10.61 0-3.23-3.548">
                                        </path>
                                    </g>
                                </svg></span>
                            <input name="eposta" id="eposta" type="text" class="form-control" aria-label="E-Posta"
                                placeholder="E-Posta" value="<?=$kullanici["mail"]?>">
                        </div>

                        <h5>Şifremi değiştir</h5>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><svg width="24" height="24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                        width="24" height="24">
                                        <path fill="#D9D9D9" d="M0 0h24v24H0z"></path>
                                    </mask>
                                    <g mask="url(#a)" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M8.962 15.205v-.064m-.259.05a.261.261 0 1 1 .523 0 .261.261 0 0 1-.523 0ZM12.407 15.205v-.064m-.259.05a.26.26 0 1 1 .521 0 .26.26 0 1 1-.521 0ZM15.849 15.205v-.064m-.26.05c0-.144.118-.261.262-.261a.26.26 0 0 1 .26.26.26.26 0 1 1-.521 0ZM16.858 9.49V7.392a4.448 4.448 0 0 0-8.897-.02V9.49">
                                        </path>
                                        <path
                                            d="M9.71 21.044h5.392c1.595 0 2.393 0 3.009-.296a3.002 3.002 0 0 0 1.405-1.405c.296-.616.296-1.414.296-3.009v-2.132c0-1.595 0-2.393-.296-3.008a3 3 0 0 0-1.405-1.406c-.616-.296-1.414-.296-3.009-.296H9.71c-1.595 0-2.393 0-3.009.296a3 3 0 0 0-1.405 1.406C5 11.81 5 12.607 5 14.202v2.132c0 1.595 0 2.393.296 3.01.295.613.791 1.11 1.405 1.404.616.296 1.414.296 3.009.296Z">
                                        </path>
                                    </g>
                                </svg></span>
                            <input name="sifre" id="sifre" type="password" class="form-control password-input"
                                aria-label="Şifre" placeholder="Şifre">
                            <span class="input-group-text toggle-password">
                                <svg class="show" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                        width="24" height="24">
                                        <path fill="#D9D9D9" d="M0 0h24v24H0z"></path>
                                    </mask>
                                    <g mask="url(#a)" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M4 7c3.2 6.933 12.8 6.933 16 0M6.863 10.539l-2.86 3.929M17.145 10.539l2.858 3.929M12 12.203v3.866">
                                        </path>
                                    </g>
                                </svg>
                                <svg class="hide" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                                    <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                        width="24" height="24">
                                        <path fill="#D9D9D9" d="M0 0h24v24H0z"></path>
                                    </mask>
                                    <g mask="url(#a)" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M4 13.2c3.2-6.934 12.8-6.934 16 0"></path>
                                        <path clip-rule="evenodd"
                                            d="M12.003 16.93a2.315 2.315 0 0 1-2.312-2.312 2.316 2.316 0 0 1 2.312-2.313 2.316 2.316 0 0 1 2.313 2.313 2.315 2.315 0 0 1-2.313 2.313Z">
                                        </path>
                                    </g>
                                </svg>
                            </span>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><svg width="24" height="24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                        width="24" height="24">
                                        <path fill="#D9D9D9" d="M0 0h24v24H0z"></path>
                                    </mask>
                                    <g mask="url(#a)" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M8.962 15.205v-.064m-.259.05a.261.261 0 1 1 .523 0 .261.261 0 0 1-.523 0ZM12.407 15.205v-.064m-.259.05a.26.26 0 1 1 .521 0 .26.26 0 1 1-.521 0ZM15.849 15.205v-.064m-.26.05c0-.144.118-.261.262-.261a.26.26 0 0 1 .26.26.26.26 0 1 1-.521 0ZM16.858 9.49V7.392a4.448 4.448 0 0 0-8.897-.02V9.49">
                                        </path>
                                        <path
                                            d="M9.71 21.044h5.392c1.595 0 2.393 0 3.009-.296a3.002 3.002 0 0 0 1.405-1.405c.296-.616.296-1.414.296-3.009v-2.132c0-1.595 0-2.393-.296-3.008a3 3 0 0 0-1.405-1.406c-.616-.296-1.414-.296-3.009-.296H9.71c-1.595 0-2.393 0-3.009.296a3 3 0 0 0-1.405 1.406C5 11.81 5 12.607 5 14.202v2.132c0 1.595 0 2.393.296 3.01.295.613.791 1.11 1.405 1.404.616.296 1.414.296 3.009.296Z">
                                        </path>
                                    </g>
                                </svg></span>
                            <input name="sifre2" id="sifre2" type="password" class="form-control password-input"
                                aria-label="Şifre Tekrarı" placeholder="Şifre Tekrarı">
                            <span class="input-group-text toggle-password">
                                <svg class="show" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                        width="24" height="24">
                                        <path fill="#D9D9D9" d="M0 0h24v24H0z"></path>
                                    </mask>
                                    <g mask="url(#a)" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M4 7c3.2 6.933 12.8 6.933 16 0M6.863 10.539l-2.86 3.929M17.145 10.539l2.858 3.929M12 12.203v3.866">
                                        </path>
                                    </g>
                                </svg>
                                <svg class="hide" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                                    <mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                        width="24" height="24">
                                        <path fill="#D9D9D9" d="M0 0h24v24H0z"></path>
                                    </mask>
                                    <g mask="url(#a)" stroke="#000" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M4 13.2c3.2-6.934 12.8-6.934 16 0"></path>
                                        <path clip-rule="evenodd"
                                            d="M12.003 16.93a2.315 2.315 0 0 1-2.312-2.312 2.316 2.316 0 0 1 2.312-2.313 2.316 2.316 0 0 1 2.313 2.313 2.315 2.315 0 0 1-2.313 2.313Z">
                                        </path>
                                    </g>
                                </svg>
                            </span>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn submit-btn">Kaydet</button>
                        </div><br>
                        <div class="form-group">
                            <button type="button" onclick="hesapSil()" style="background-color:darkred;"
                                class="btn submit-btn">Hesabımı Sil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <div id="bilgi"></div>


    <footer></footer>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function uyariGoster(baslik, icerik) {
        let uyari_bas = document.getElementById("uyari_baslik");
        let uyari_yazi = document.getElementById("uyari_icerik");

        uyari_bas.textContent = baslik;
        uyari_yazi.textContent = icerik;

        new bootstrap.Toast(document.querySelector('#uyaritablo')).show();
    }


    $("#profile_form").submit(function() {
        var isim = document.getElementById("isim").value;
        var soyisim = document.getElementById("soyisim").value;
        var eposta = document.getElementById("eposta").value;
        var sifre = document.getElementById("sifre").value;
        var sifre2 = document.getElementById("sifre2").value;
        if (isim != "" && soyisim != "" && eposta != "") {
            if (sifre != "" || sifre2 != "") {

                if (sifre == sifre2) {
                    Post_Gonder("profile_form", "&sifre_guncelle");
                } else {
                    uyariGoster("Uyarı!", "Girdiğiniz Şifreler Uyuşmuyor");
                }

            } else {
                Post_Gonder("profile_form", "&profil_guncelle");
            }
        } else {
            uyariGoster("Uyarı!", "Boş Alan Bırakmayınız");
        }
    })

    $("#imageUpload").change(function(data) {

        var imageFile = data.target.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(imageFile);

        reader.onload = function(evt) {
            $('#imagePreview').attr('src', evt.target.result);
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }

    });
    $(".toggle-password").click(function() {

        $(this).toggleClass("active");

        var input = $(this).prev('.password-input')

        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }

    });

    function hesapSil() {
        Swal.fire({
            title: "Emin misin?",
            text: "Hesabın silinecek!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Evet, Sil!",
            cancelButtonText: "İptal"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Silindi!",
                    text: "Hesabın silindi.",
                    icon: "success"
                });
                location.href = "inc/islem.php?hesapsil=1";
            }
        });
    }
    </script>

</body>

</html>
