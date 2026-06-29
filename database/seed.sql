-- JetScore sanitized demo seed.
-- Demo login: demo@example.com / demo1234

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE favori;
TRUNCATE TABLE detaylar;
TRUNCATE TABLE puan_tablosu;
TRUNCATE TABLE maclar;
TRUNCATE TABLE takimlar;
TRUNCATE TABLE ligler;
TRUNCATE TABLE ulke;
TRUNCATE TABLE spor;
TRUNCATE TABLE site;
TRUNCATE TABLE kullanici;

SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO spor (id, isim, slug) VALUES
    (1, 'Futbol', 'futbol');

INSERT INTO ulke (id, isim, logo) VALUES
    (1, 'Türkiye', 'assets/img/ulkeler/turkiye.png');

INSERT INTO ligler (id, ulke_id, spor_id, isim, logo) VALUES
    (1, 1, 1, 'Süper Lig Demo', 'ligler/trsuperlig.png');

INSERT INTO takimlar (id, lig_id, isim, logo) VALUES
    (1, 1, 'Fenerbahçe Demo', 'assets/img/takimlar/fenerbahce.png'),
    (2, 1, 'Galatasaray Demo', 'assets/img/takimlar/galatasaray.png'),
    (3, 1, 'Beşiktaş Demo', 'assets/img/takimlar/besiktas.png');

INSERT INTO maclar (
    id, lig_id, takim1_id, takim2_id, mac_tarihi, durum, eventtime, addedtime,
    takim1_skor, takim2_skor, takim1_skor_iy, takim2_skor_iy
) VALUES
    (1, 1, 1, 2, TIMESTAMP(CURDATE(), '20:00:00'), 0, NULL, NULL, 0, 0, NULL, NULL),
    (2, 1, 2, 3, TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '20:00:00'), 4, NULL, NULL, 2, 1, 1, 0),
    (3, 1, 3, 1, TIMESTAMP(CURDATE(), '18:30:00'), 2, '45', NULL, 1, 1, 1, 1);

INSERT INTO detaylar (mac_id, veri, istatistik, kadro) VALUES
    (1, '[]', '[]', '{"kadro_home":[],"kadro_away":[],"kadro_yedek_home":[],"kadro_yedek_away":[]}'),
    (2, '[]', '[]', '{"kadro_home":[],"kadro_away":[],"kadro_yedek_home":[],"kadro_yedek_away":[]}'),
    (3, '[]', '[]', '{"kadro_home":[],"kadro_away":[],"kadro_yedek_home":[],"kadro_yedek_away":[]}');

INSERT INTO puan_tablosu (
    lig_id, takim_id, siralama, oynanan, kazanilan, kaybedilen, berabere,
    atilan_gol, yenilen_gol, puan
) VALUES
    (1, 2, 1, 1, 1, 0, 0, 2, 1, 3),
    (1, 3, 2, 2, 0, 1, 1, 2, 3, 1),
    (1, 1, 3, 1, 0, 0, 1, 1, 1, 1);

INSERT INTO kullanici (id, isim, soyisim, mail, sifre) VALUES
    (1, 'Demo', 'User', 'demo@example.com', '$2y$10$yUs9wQIsU2LjGdvBc8IBduV7GwI/1SIslh1zqLFRleO/58DYRlaOi');

INSERT INTO site (ayar_key, ayar_value) VALUES
    ('app_name', 'JetScore'),
    ('demo_mode', '1');
