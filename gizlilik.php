<!DOCTYPE html>
<html lang="en">
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
  <link rel="icon" href="assets/img/logo.svg" type="image/x-icon" />
  

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


  
<section id="text">
    <div class="container">
        <div class="card">
            <div class="card-header">
                Gizlilik Sözleşmesi
            </div>
            <div class="card-body">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam quia neque, repellat possimus nostrum enim quidem beatae, temporibus optio debitis quod? A eos omnis sed nulla error, beatae harum illum.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam dolor nesciunt error saepe consequatur! Modi cupiditate distinctio aliquam unde veritatis molestias placeat consequuntur, sapiente ab! Ab doloribus maxime dicta distinctio. Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum, velit? Voluptas, voluptatum? Obcaecati modi temporibus sed. Consequatur, fugit porro suscipit ipsum cum perspiciatis voluptatum necessitatibus eius. Qui voluptates facere vitae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo vitae iure laborum laboriosam sit, dignissimos vero qui ex unde consequatur cumque alias modi! Temporibus perferendis ex veritatis sequi, unde amet? Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ut, asperiores! Commodi rerum voluptatibus tenetur recusandae incidunt tempore ipsam doloribus harum iure esse, reiciendis est nesciunt eligendi mollitia quae ad labore?</p>
                <h1>Başlık buraya gelecek</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam dolor nesciunt error saepe consequatur! Modi cupiditate distinctio aliquam unde veritatis molestias placeat consequuntur, sapiente ab! Ab doloribus maxime dicta distinctio. Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum, velit? Voluptas, voluptatum? Obcaecati modi temporibus sed. Consequatur, fugit porro suscipit ipsum cum perspiciatis voluptatum necessitatibus eius. Qui voluptates facere vitae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo vitae iure laborum laboriosam sit, dignissimos vero qui ex unde consequatur cumque alias modi! Temporibus perferendis ex veritatis sequi, unde amet? Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ut, asperiores! Commodi rerum voluptatibus tenetur recusandae incidunt tempore ipsam doloribus harum iure esse, reiciendis est nesciunt eligendi mollitia quae ad labore?</p>

            </div>
        </div>
    </div>
</section>

  

  <footer></footer>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/main.min.js"></script>
  
<script>
      $("#imageUpload").change(function(data){

        var imageFile = data.target.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(imageFile);

        reader.onload = function(evt){
        $('#imagePreview').attr('src', evt.target.result);
        $('#imagePreview').hide();
        $('#imagePreview').fadeIn(650);
        }
        
    });
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

</body>
</html>
