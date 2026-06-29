-- JetScore clean database schema.
-- Optional local setup:
-- CREATE DATABASE jetskor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE jetskor;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS kullanici (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    isim VARCHAR(100) NULL,
    soyisim VARCHAR(100) NULL,
    mail VARCHAR(190) NOT NULL,
    sifre VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_kullanici_mail (mail)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS spor (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    isim VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL,
    UNIQUE KEY uq_spor_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ulke (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    isim VARCHAR(120) NOT NULL,
    logo VARCHAR(255) NOT NULL DEFAULT 'assets/img/yok.png',
    UNIQUE KEY uq_ulke_isim (isim)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ligler (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ulke_id INT UNSIGNED NOT NULL,
    spor_id INT UNSIGNED NULL,
    isim VARCHAR(160) NOT NULL,
    logo VARCHAR(255) NOT NULL DEFAULT 'ligler/trsuperlig.png',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_ligler_ulke (ulke_id),
    KEY idx_ligler_spor (spor_id),
    CONSTRAINT fk_ligler_ulke FOREIGN KEY (ulke_id) REFERENCES ulke (id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_ligler_spor FOREIGN KEY (spor_id) REFERENCES spor (id)
        ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS takimlar (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lig_id INT UNSIGNED NOT NULL,
    isim VARCHAR(160) NOT NULL,
    logo VARCHAR(255) NOT NULL DEFAULT 'assets/img/yok.png',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_takimlar_lig (lig_id),
    KEY idx_takimlar_isim (isim),
    CONSTRAINT fk_takimlar_lig FOREIGN KEY (lig_id) REFERENCES ligler (id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS maclar (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lig_id INT UNSIGNED NOT NULL,
    takim1_id INT UNSIGNED NOT NULL,
    takim2_id INT UNSIGNED NOT NULL,
    mac_tarihi DATETIME NOT NULL,
    durum TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 fixture, 1 live, 2 half-time, 4 finished',
    eventtime VARCHAR(20) NULL,
    addedtime VARCHAR(20) NULL,
    takim1_skor SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    takim2_skor SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    takim1_skor_iy SMALLINT UNSIGNED NULL,
    takim2_skor_iy SMALLINT UNSIGNED NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_maclar_lig_tarih (lig_id, mac_tarihi),
    KEY idx_maclar_takim1 (takim1_id),
    KEY idx_maclar_takim2 (takim2_id),
    KEY idx_maclar_durum (durum),
    CONSTRAINT fk_maclar_lig FOREIGN KEY (lig_id) REFERENCES ligler (id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_maclar_takim1 FOREIGN KEY (takim1_id) REFERENCES takimlar (id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_maclar_takim2 FOREIGN KEY (takim2_id) REFERENCES takimlar (id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS detaylar (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mac_id INT UNSIGNED NOT NULL,
    veri LONGTEXT NOT NULL DEFAULT '[]',
    istatistik LONGTEXT NOT NULL DEFAULT '[]',
    kadro LONGTEXT NOT NULL DEFAULT '{"kadro_home":[],"kadro_away":[],"kadro_yedek_home":[],"kadro_yedek_away":[]}',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_detaylar_mac (mac_id),
    CONSTRAINT fk_detaylar_mac FOREIGN KEY (mac_id) REFERENCES maclar (id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS puan_tablosu (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lig_id INT UNSIGNED NOT NULL,
    takim_id INT UNSIGNED NOT NULL,
    siralama SMALLINT UNSIGNED NOT NULL,
    oynanan SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    kazanilan SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    kaybedilen SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    berabere SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    atilan_gol SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    yenilen_gol SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    puan SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    UNIQUE KEY uq_puan_lig_takim (lig_id, takim_id),
    KEY idx_puan_lig_siralama (lig_id, siralama),
    CONSTRAINT fk_puan_lig FOREIGN KEY (lig_id) REFERENCES ligler (id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_puan_takim FOREIGN KEY (takim_id) REFERENCES takimlar (id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS favori (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kullanici_id INT UNSIGNED NOT NULL,
    mac_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_favori_kullanici_mac (kullanici_id, mac_id),
    KEY idx_favori_mac (mac_id),
    CONSTRAINT fk_favori_kullanici FOREIGN KEY (kullanici_id) REFERENCES kullanici (id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_favori_mac FOREIGN KEY (mac_id) REFERENCES maclar (id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS site (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ayar_key VARCHAR(120) NOT NULL,
    ayar_value TEXT NULL,
    UNIQUE KEY uq_site_ayar_key (ayar_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
