<?php
include "inc/baglan.php";
include "inc/fonk.php";

if(isset($_GET["tarih"])){
    $tarih = $_GET["tarih"];
} else {
    $tarih = date("Y/m/d");
}

?>
<section id="matches">
    <div class="container">

    <?php 
        $sorgulig=$db->prepare("SELECT ligler.*, ulke.isim AS ulke_isim, ulke.logo AS ulke_logo 
        FROM ligler 
        INNER JOIN ulke ON ligler.ulke_id = ulke.id 
        ORDER BY ulke.isim ASC, ligler.isim ASC");
        $sorgulig->execute();
        while ($satirlig = $sorgulig->fetch(PDO::FETCH_ASSOC)){ 
            $lig_id = $satirlig["id"];
            $ulkeisim= $satirlig["ulke_isim"];
            $ulkelogo= $satirlig["ulke_logo"];
            $sorgumac_count = $db->prepare("SELECT COUNT(*) as total FROM maclar WHERE lig_id = $lig_id  AND DATE(mac_tarihi) = :tarih" );
            $sorgumac_count->bindParam(':tarih', $tarih, PDO::PARAM_STR);
            $sorgumac_count->execute();
            $match_count = $sorgumac_count->fetch(PDO::FETCH_ASSOC)['total'];
            if ($match_count > 0){   
        ?>
        <div class="league">
            <div class="league-title">
                <div class="league-img">
                    <img src="<?php echo $ulkelogo; ?>" alt="premier league" title="premier league" width="32"
                        height="32">
                </div>
                <div class="league-txt">
                    <p><?=$ulkeisim?>: <?= $satirlig["isim"]; ?> </p>
                    <small><span></span></small>
                </div>
            </div>
            <?php 
                $sorgumac = $db->prepare("SELECT * FROM maclar WHERE lig_id = $lig_id AND DATE(mac_tarihi) = :tarih ORDER BY mac_tarihi ASC");
                $sorgumac->bindParam(':tarih', $tarih, PDO::PARAM_STR);
                $sorgumac->execute();
                while ($satirmac = $sorgumac->fetch(PDO::FETCH_ASSOC)){ 
                    $macid = $satirmac["id"];
                    if(strtotime($satirmac["mac_tarihi"]) < (strtotime("now")+60*60*4) && $satirmac["durum"] != 4){
                        Db_Duzenle_uyarisiz($db,"maclar",array("durum"),array("4"),"id = $macid");
                    }
                    $sorgutakim1=$db->prepare("SELECT * FROM takimlar where id = ".$satirmac["takim1_id"] );
                    $sorgutakim1->execute();
                    $satirtakim1 = $sorgutakim1->fetch(PDO::FETCH_ASSOC);
                    $sorgutakim2=$db->prepare("SELECT * FROM takimlar where id = ".$satirmac["takim2_id"] );
                    $sorgutakim2->execute();
                    $satirtakim2 = $sorgutakim2->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="match-wrap">
                <a href="match.php?id=<?= $satirmac["id"] ?>" class="match-item">
                    <div class="time">
                        <?php if($satirmac["durum"]==0){ echo "<h5>".sadeSaat($satirmac["mac_tarihi"])."</h5>";
                            }elseif($satirmac["durum"]==4){ echo "<h5> MS </h5>";}elseif($satirmac["durum"]==2){ echo "<h5> Devre Arası </h5>";}else{ 
                                if($satirmac["addedtime"] != ""){
                                echo "<span>".$satirmac["eventtime"]."+".$satirmac["addedtime"]."</span>"; }else{
                                    echo "<span>".$satirmac["eventtime"]."</span>";
                                }
                                
                            }
                            ?>
                        <img src="assets/img/time-border.png" alt="">
                    </div>

                    <div class="teams"  >
                        <div class="team">
                            <img src="<?php 
                                echo $satirtakim1["logo"];
                            /*if (file_exists("assets/img/".$satirtakim1["logo"]))
                                {  
                                echo "assets/img/".$satirtakim1["logo"]; 
                                }else{ 
                                echo "assets/img/yok.png"; 
                                }*/ ?>"    alt="" width="48" height="48">
                            <p><?= $satirtakim1["isim"] ?></p>
                        </div>

                        <div class="score">
                            <div class="number">
                                <?php if($satirmac["durum"]==0){ ?>
                                <span>V</span>
                                <?php
                                    }else{
                                    ?>
                                <p ><?= $satirmac["takim1_skor"] ?></p>
                                <span >:</span>
                                <p ><?= $satirmac["takim2_skor"] ?></p>
                                <?php
                                    }
                                    ?>
                            </div>
                        </div>
                        <div class="team">
                            <img src="<?php 
                            echo $satirtakim2["logo"];
                            /*if (file_exists("assets/img/".$satirtakim2["logo"])) {  echo "assets/img/".$satirtakim2["logo"]; } else{ echo "assets/img/yok.png"; } */?>"  alt="" width="48" height="48">
                            <p ><?= $satirtakim2["isim"] ?></p>
                        </div>
                    </div>
                </a>
                <button class="favourite" onclick="addFav(this)">
                    <svg class="inactive" width="21" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="21" height="21">
                            <path fill="#D9D9D9" d="M.5.5h20v20H.5z" />
                        </mask>
                        <g mask="url(#a)">
                            <path clip-rule="evenodd"
                                d="m11.42 3.564 1.523 3.042c.15.3.437.506.771.554l3.407.49c.842.122 1.177 1.142.568 1.727l-2.464 2.367a1.003 1.003 0 0 0-.295.896l.582 3.341c.143.827-.737 1.458-1.49 1.067l-3.044-1.58a1.04 1.04 0 0 0-.956 0l-3.045 1.58c-.752.39-1.632-.24-1.488-1.066l.58-3.342a1.003 1.003 0 0 0-.294-.896L3.31 9.377c-.609-.585-.274-1.605.568-1.726l3.407-.49c.334-.049.623-.256.772-.555L9.58 3.564c.376-.752 1.464-.752 1.84 0Z"
                                stroke="#000" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </svg>
                    <svg class="active" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                            <path fill="#D9D9D9" d="M0 0h20v20H0z" />
                        </mask>
                        <g mask="url(#a)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="m10.92 3.064 1.523 3.042c.15.3.437.506.771.554l3.407.49c.842.122 1.177 1.142.568 1.727l-2.464 2.367a1.003 1.003 0 0 0-.295.896l.582 3.341c.143.827-.737 1.458-1.49 1.067l-3.044-1.58a1.04 1.04 0 0 0-.956 0l-3.045 1.58c-.752.39-1.632-.24-1.488-1.066l.58-3.342a1.003 1.003 0 0 0-.294-.896L2.81 8.877c-.609-.585-.274-1.605.568-1.726l3.407-.49c.334-.049.623-.256.772-.555L9.08 3.064c.376-.752 1.464-.752 1.84 0Z"
                                fill="#FFA800" stroke="#FFA800" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </g>
                    </svg>
                </button>
                </div>
            <?php } ?>
        </div>
        <?php }}   ?>
    </div>
</section>
<script>
    $("#loaders").hide();
    document.getElementById("flexSwitchCheckChecked").checked = false;

</script>