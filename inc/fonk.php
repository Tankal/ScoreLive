<?php 
 
function Db_Ekle($db, $tablo, $sutun, $deger){
        $say = 0; 
        $execute_array = [];
        $sutunlar = "";
        foreach ($sutun as $sutuni) {
            $say++;
            if (count($sutun) > $say) {
                $sutunlar .=  "$sutuni=:$sutuni,";
                $execute_array["$sutuni"] = $deger[$say-1];
            }else{
                $sutunlar .=  "$sutuni=:$sutuni";
                $execute_array["$sutuni"] = $deger[$say-1];
            } 
        }

        $kaydet = $db->prepare("INSERT INTO $tablo SET 
        $sutunlar
        ");
        $kaydet->execute($execute_array); 
        if ($kaydet) {
             //uyari_goster("Bilgi","İşlem Başarılı.","info");
        }else{
            //uyari_goster("Bilgi","Veritabanı Hatası.","danger");
        }
}

function Db_Loop($db, $tablo, $sutun, $deger){
    $say = 0; 
    $execute_array = [];
    $sutunlar = "";
    foreach ($sutun as $sutuni) {
        $say++;
        if (count($sutun) > $say) {
            $sutunlar .=  "$sutuni=:$sutuni,";
            $execute_array["$sutuni"] = $deger[$say-1];
        }else{
            $sutunlar .=  "$sutuni=:$sutuni";
            $execute_array["$sutuni"] = $deger[$say-1];
        } 
    }

    $kaydet = $db->prepare("INSERT INTO $tablo SET 
    $sutunlar
    ");
    $kaydet->execute($execute_array); 
    return $id = $db->lastInsertId();
     
}

function Db_Sil($db, $tablo, $sutun, $deger){
    $say = 0; 
    $execute_array = [];
    $sutunlar = "";
    foreach ($sutun as $sutuni) {
        $say++;
        if (count($sutun) > $say) {
            $sutunlar .=  "$sutuni=:$sutuni and ";
            $execute_array["$sutuni"] = $deger[$say-1];
        }else{
            $sutunlar .=  "$sutuni=:$sutuni";
            $execute_array["$sutuni"] = $deger[$say-1];
        } 
    }

    $kaydet = $db->prepare("DELETE FROM $tablo WHERE 
    $sutunlar
    ");
    $kaydet->execute($execute_array); 
    if ($kaydet) {
        uyari_goster("Bilgi","İşlem Başarılı.","info");

   }else{
       uyari_goster("Bilgi","Veritabanı Hatası.","danger");
   }
}


function Db_Duzenle($db, $tablo, $sutun, $deger , $where){
    $say = 0; 
    $execute_array = [];
    $sutunlar = "";
    foreach ($sutun as $sutuni) {
        $say++;
        if (count($sutun) > $say) {
            $sutunlar .=  "$sutuni=:$sutuni,";
            $execute_array["$sutuni"] = $deger[$say-1];
        }else{
            $sutunlar .=  "$sutuni=:$sutuni";
            $execute_array["$sutuni"] = $deger[$say-1];
        } 
    }

    $kaydet = $db->prepare("UPDATE  $tablo SET 
    $sutunlar WHERE $where
    ");
    $kaydet->execute($execute_array); 
    if ($kaydet) {
        uyari_goster("Düzenleme işlemi Başarılı.","Success");
      
   }else{
       uyari_goster("Bilgi","Veritabanı Hatası.","danger");
   }
}

function Db_Duzenle_uyarisiz($db, $tablo, $sutun, $deger , $where){
    $say = 0; 
    $execute_array = [];
    $sutunlar = "";
    foreach ($sutun as $sutuni) {
        $say++;
        if (count($sutun) > $say) {
            $sutunlar .=  "$sutuni=:$sutuni,";
            $execute_array["$sutuni"] = $deger[$say-1];
        }else{
            $sutunlar .=  "$sutuni=:$sutuni";
            $execute_array["$sutuni"] = $deger[$say-1];
        } 
    }

    $kaydet = $db->prepare("UPDATE  $tablo SET 
    $sutunlar WHERE $where
    ");
    $kaydet->execute($execute_array); 
     
    if($kaydet){
        return 1;
    }else{
        return 0;
    }
}
 
 function Db_Cek($db,$tablo,$sutun,$where){
    $koop = $db->prepare("SELECT * FROM $tablo WHERE $where");
	$koop->execute(); 
	$kcek = $koop->fetch(PDO::FETCH_ASSOC);
	
    return $kcek[$sutun] ?? null; 
 }


 function tarih($date){
     
    $tarih = explode("-",$date);
    switch ($tarih[1]) {
        
        case 'Ocak,': $tarih[1] = "01" ; break; 
        case 'Şubat,': $tarih[1] = "02" ; break; 
        case 'Mart,': $tarih[1] = "03" ; break; 
        case 'Nisan,': $tarih[1] = "04" ; break; 
        case 'Mayıs,': $tarih[1] = "05" ; break; 
        case 'Haziran,': $tarih[1] = "06" ; break; 
        case 'Temmuz,': $tarih[1] = "07" ; break; 
        case 'Ağustos,': $tarih[1] = "08" ; break; 
        case 'Eylül,': $tarih[1] = "09" ; break; 
        case 'Ekim,': $tarih[1] = "10" ; break; 
        case 'Kasım,': $tarih[1] = "11" ; break; 
        case 'Aralık,': $tarih[1] = "12" ; break; 
 
        
    }
    if ($tarih[0] == 1 || $tarih[0] == 2 ||  $tarih[0] == 3 ||  $tarih[0] == 4 ||  $tarih[0] == 5 ||  $tarih[0] == 6 ||  $tarih[0] == 7 ||  $tarih[0] == 8 ||  $tarih[0] == 9 ) {
        $tarih[0] = "0".$tarih[0];
    }
    return $tarih[2]. "-" . $tarih[1] . "-" . $tarih[0];
 

 }

 function SatirSay($db,$tablo,$where){
        $satirsor = $db->prepare("SELECT * FROM $tablo where $where");
		$satirsor->execute(); 
		return $satirsor->RowCount();
 }




 function tarihDuzelt($date){
    $bolundu = explode(" ",$date);
    $tarih = explode("-",$bolundu[0]);
    switch ($tarih[1]) {
        
        case '1': $tarih[1] = "Ocak" ; break; 
        case '2': $tarih[1] = "Şubat" ; break; 
        case '3': $tarih[1] = "Mart" ; break; 
        case '4': $tarih[1] = "Nisan" ; break; 
        case '5': $tarih[1] = "Mayıs" ; break; 
        case '6': $tarih[1] = "Haziran" ; break; 
        case '7': $tarih[1] = "Temmuz" ; break; 
        case '8': $tarih[1] = "Ağustos" ; break; 
        case '9': $tarih[1] = "Eylül" ; break; 
        case '10': $tarih[1] = "Ekim" ; break; 
        case '11': $tarih[1] = "Kasım" ; break; 
        case '12': $tarih[1] = "Aralık" ; break; 
 
        
    }
    return $tarih[2]. " " . $tarih[1] . " " . $tarih[0];

 

 }
 function tarihDuzeltSaatli($date){
    $bolundu = explode(" ",$date);
    $tarih = explode("-",$bolundu[0]);
    $saat = explode(":",$bolundu[1]);
    switch ($tarih[1]) {
        
        case '1': $tarih[1] = "Ocak" ; break; 
        case '2': $tarih[1] = "Şubat" ; break; 
        case '3': $tarih[1] = "Mart" ; break; 
        case '4': $tarih[1] = "Nisan" ; break; 
        case '5': $tarih[1] = "Mayıs" ; break; 
        case '6': $tarih[1] = "Haziran" ; break; 
        case '7': $tarih[1] = "Temmuz" ; break; 
        case '8': $tarih[1] = "Ağustos" ; break; 
        case '9': $tarih[1] = "Eylül" ; break; 
        case '10': $tarih[1] = "Ekim" ; break; 
        case '11': $tarih[1] = "Kasım" ; break; 
        case '12': $tarih[1] = "Aralık" ; break; 
 
        
    }
    

    return $tarih[2]. " " . $tarih[1] . " " . $tarih[0]. "<br>". $saat[0].":".$saat[1] ;

 

 }
 function sadeSaat($date){
    $bolundu = explode(" ",$date);
    $saat = explode(":",$bolundu[1]);
   
    return $saat[0].":".$saat[1] ;

 

 }
?>
<script>
    function uyari_goster(baslik, mesaj, tur) {
    // Uyarı türüne göre farklı işlemler yapabilirsiniz.
    if (tur === "danger") {
        // Danger uyarısı için özel işlemler yapabilirsiniz (örneğin, kırmızı renkli bir bildirim).
        console.error("baslik: " + mesaj);
        alert("baslik: " + mesaj);
    } else if (tur === "warning") {
        // Warning uyarısı için özel işlemler yapabilirsiniz (örneğin, sarı renkli bir bildirim).
        console.warn("baslik: " + mesaj);
        alert("baslik: " + mesaj);
    } else if (tur === "info") {
        // Bilgi uyarısı için özel işlemler yapabilirsiniz (örneğin, mavi renkli bir bildirim).
        console.info("baslik: " + mesaj);
        alert("baslik: " + mesaj);
    } else {
        // Belirtilmeyen bir uyarı türü ise, varsayılan olarak bir bildirim gösterilebilir.
        alert(baslik + ": " + mesaj);
    }
}
</script>
