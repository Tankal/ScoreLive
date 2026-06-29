<?php
include "baglan.php";
include "fonk.php";

function js_redirect(string $url): void
{
    echo '<script>location.href = ' . json_encode($url) . '</script>';
}

function js_alert(string $title, string $message): void
{
    echo '<script>uyariGoster(' . json_encode($title) . ', ' . json_encode($message) . ');</script>';
}

if (isset($_GET["kayitol"]) && $_GET["kayitol"] == 1) {
    $eposta = trim($_POST["eposta"] ?? '');
    $sifre = $_POST["sifre"] ?? '';
    $sifre2 = $_POST["sifre2"] ?? '';

    if (!filter_var($eposta, FILTER_VALIDATE_EMAIL) || $sifre === '' || $sifre2 === '') {
        js_alert('Uyarı!', 'Lütfen geçerli bilgiler girin.');
        exit;
    }

    $sorgu = $db->prepare("SELECT * FROM kullanici WHERE mail = :mail LIMIT 1");
    $sorgu->execute(['mail' => $eposta]);
    $user = $sorgu->fetch(PDO::FETCH_ASSOC);

    if ($user && $user["mail"] == $eposta) {
        js_alert('Uyarı!', 'Bu e-posta hesabıyla zaten bir kayıt var. Lütfen giriş yapın.');
    } elseif ($sifre !== $sifre2) {
        js_alert('Uyarı!', 'Girdiğiniz şifreler uyuşmuyor.');
    } else {
        Db_Ekle($db, "kullanici", ["mail", "sifre"], [$eposta, password_hash($sifre, PASSWORD_DEFAULT)]);
        js_alert('Kayıt Başarılı', 'Başarı ile kayıt yaptınız.');
        js_redirect('login.php');
    }
}

if (isset($_GET["girisyap"]) && $_GET["girisyap"] == 1) {
    $eposta = trim($_POST["eposta"] ?? '');
    $sifre = $_POST["sifre"] ?? '';

    $sorgu = $db->prepare("SELECT * FROM kullanici WHERE mail = :mail LIMIT 1");
    $sorgu->execute(['mail' => $eposta]);
    $user = $sorgu->fetch(PDO::FETCH_ASSOC);

    $validPassword = $user && (
        password_verify($sifre, $user["sifre"]) ||
        hash_equals((string) $user["sifre"], $sifre)
    );

    if ($validPassword) {
        if (password_needs_rehash($user["sifre"], PASSWORD_DEFAULT)) {
            $rehash = $db->prepare("UPDATE kullanici SET sifre = :sifre WHERE id = :id");
            $rehash->execute([
                'sifre' => password_hash($sifre, PASSWORD_DEFAULT),
                'id' => (int) $user["id"],
            ]);
        }

        session_regenerate_id(true);
        $_SESSION["user"] = (int) $user["id"];
        js_alert('Giriş Başarılı', 'Hoşgeldin ' . ($user["isim"] ?? ''));
        js_redirect('index.php');
    } else {
        js_alert('Uyarı!', 'E-posta veya şifre hatalı.');
    }
}

if (isset($_GET["profil_guncelle"]) && $_GET["profil_guncelle"] == 1) {
    if (!isset($_SESSION["user"])) {
        http_response_code(401);
        exit;
    }

    $id = (int) $_SESSION["user"];
    $isim = trim($_POST["isim"] ?? '');
    $soyisim = trim($_POST["soyisim"] ?? '');
    $eposta = trim($_POST["eposta"] ?? '');

    if (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
        js_alert('Uyarı!', 'Geçerli bir e-posta adresi girin.');
        exit;
    }

    $sonuc = Db_Duzenle_uyarisiz($db, "kullanici", ["isim", "soyisim", "mail"], [$isim, $soyisim, $eposta], "id = $id");

    if ($sonuc == 1) {
        js_alert('Güncelleme Başarılı', 'Profiliniz güncellenmiştir.');
    } else {
        js_alert('Bir Hata Oluştu', 'Profiliniz güncellenirken bir sorun oluştu. Lütfen tekrar deneyin.');
    }
}

if (isset($_GET["sifre_guncelle"]) && $_GET["sifre_guncelle"] == 1) {
    if (!isset($_SESSION["user"])) {
        http_response_code(401);
        exit;
    }

    $id = (int) $_SESSION["user"];
    $isim = trim($_POST["isim"] ?? '');
    $soyisim = trim($_POST["soyisim"] ?? '');
    $eposta = trim($_POST["eposta"] ?? '');
    $sifre = $_POST["sifre"] ?? '';
    $sifre2 = $_POST["sifre2"] ?? '';

    if (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
        js_alert('Uyarı!', 'Geçerli bir e-posta adresi girin.');
        exit;
    }

    if ($sifre === '' || $sifre !== $sifre2) {
        js_alert('Uyarı!', 'Girdiğiniz şifreler uyuşmuyor.');
        exit;
    }

    $sonuc = Db_Duzenle_uyarisiz(
        $db,
        "kullanici",
        ["isim", "soyisim", "mail", "sifre"],
        [$isim, $soyisim, $eposta, password_hash($sifre, PASSWORD_DEFAULT)],
        "id = $id"
    );

    if ($sonuc == 1) {
        js_alert('Güncelleme Başarılı', 'Profiliniz ve şifreniz güncellenmiştir.');
    } else {
        js_alert('Bir Hata Oluştu', 'Profiliniz güncellenirken bir sorun oluştu. Lütfen tekrar deneyin.');
    }
}

if (isset($_GET["cikis"]) && $_GET["cikis"] == 1) {
    unset($_SESSION["user"]);
    session_regenerate_id(true);
    js_redirect('../index.php');
}

if (isset($_GET["hesapsil"]) && $_GET["hesapsil"] == 1) {
    $id = (int) ($_SESSION["user"] ?? 0);
    $kaydet = $db->prepare("DELETE FROM kullanici WHERE id = :id");
    $kaydet->execute(['id' => $id]);

    unset($_SESSION["user"]);
    header("Location: ../index.php");
}
?>
