<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-03-06 04:40:40 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\dashboard\views\v_dashboard_index.php 60
ERROR - 2022-03-06 04:40:40 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\dashboard\views\v_dashboard_index.php 71
ERROR - 2022-03-06 04:40:44 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\dashboard\views\v_dashboard_index.php 60
ERROR - 2022-03-06 04:40:44 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\dashboard\views\v_dashboard_index.php 71
ERROR - 2022-03-06 04:43:58 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\dashboard\views\v_dashboard_index.php 60
ERROR - 2022-03-06 04:43:58 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\dashboard\views\v_dashboard_index.php 71
ERROR - 2022-03-06 04:45:22 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\dashboard\views\v_dashboard_index.php 60
ERROR - 2022-03-06 04:45:22 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\dashboard\views\v_dashboard_index.php 71
ERROR - 2022-03-06 05:17:04 --> 404 Page Not Found: /index
ERROR - 2022-03-06 05:20:28 --> 404 Page Not Found: /index
ERROR - 2022-03-06 05:21:58 --> 404 Page Not Found: ../modules/refrensi/controllers//index
ERROR - 2022-03-06 05:21:59 --> 404 Page Not Found: ../modules/refrensi/controllers//index
ERROR - 2022-03-06 05:55:31 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kriteria D:\xampp\htdocs\apps\skripsi\spkframewroks\system\core\Loader.php 348
ERROR - 2022-03-06 05:58:00 --> Query error: Table 'skripsi.kriteria' doesn't exist - Invalid query: SELECT `kriteriaId` AS `id`, `kriteriaNama` AS `nama`, `kriteriaSifat` as `sifat`
FROM `kriteria`
ORDER BY `kriteriaId` ASC
 LIMIT 10
ERROR - 2022-03-06 05:58:00 --> Query error: Table 'skripsi.kriteria' doesn't exist - Invalid query: SELECT `kriteriaId` AS `id`, `kriteriaNama` AS `nama`, `kriteriaSifat` as `sifat`
FROM `kriteria`
ORDER BY `kriteriaId` ASC
 LIMIT 10
ERROR - 2022-03-06 05:58:12 --> Query error: Table 'skripsi.kriteria' doesn't exist - Invalid query: SELECT `kriteriaId` AS `id`, `kriteriaNama` AS `nama`, `kriteriaSifat` as `sifat`
FROM `kriteria`
ERROR - 2022-03-06 06:06:25 --> Query error: Duplicate entry '0' for key 'PRIMARY' - Invalid query: INSERT INTO `ref_kriteria` (`kriteriaNama`, `kriteriaSifat`) VALUES ('Open Source', 'Benefit')
ERROR - 2022-03-06 06:06:28 --> Query error: Duplicate entry '0' for key 'PRIMARY' - Invalid query: INSERT INTO `ref_kriteria` (`kriteriaNama`, `kriteriaSifat`) VALUES ('Open Source', 'Benefit')
ERROR - 2022-03-06 06:06:45 --> Query error: Duplicate entry '0' for key 'PRIMARY' - Invalid query: INSERT INTO `ref_kriteria` (`kriteriaNama`, `kriteriaSifat`) VALUES ('Open Source', 'Benefit')
ERROR - 2022-03-06 06:11:03 --> Query error: Unknown column 'alkesId' in 'field list' - Invalid query: SELECT `alkesId` AS `id`, `alkesNamaBarang` AS `nama`, `alkesKodeBarang` as `KodeBarang`, `alkesHargaDasar` AS `HargaDasar`, `alkesKeterangan` AS `keterangan`, `alkesIsAktif` as `Status`
FROM `ref_kriteria`
WHERE `alkesId` = '1'
ERROR - 2022-03-06 06:12:28 --> Query error: Unknown column 'alkesId' in 'field list' - Invalid query: SELECT `alkesId` AS `id`, `alkesNamaBarang` AS `nama`, `alkesKodeBarang` as `KodeBarang`, `alkesHargaDasar` AS `HargaDasar`, `alkesKeterangan` AS `keterangan`, `alkesIsAktif` as `Status`
FROM `ref_kriteria`
WHERE `alkesId` = '1'
ERROR - 2022-03-06 06:17:30 --> Query error: Unknown column 'alkesId' in 'field list' - Invalid query: SELECT `alkesId` AS `id`, `alkesNamaBarang` AS `nama`, `alkesKodeBarang` as `KodeBarang`, `alkesHargaDasar` AS `HargaDasar`, `alkesKeterangan` AS `keterangan`, `alkesIsAktif` as `Status`
FROM `ref_kriteria`
WHERE `alkesId` = '1'
ERROR - 2022-03-06 06:32:57 --> Severity: error --> Exception: Too few arguments to function M_kriteria::UpdateKriteria(), 1 passed in D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\controllers\Kriteria.php on line 139 and exactly 2 expected D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\models\M_kriteria.php 52
ERROR - 2022-03-06 06:39:21 --> 404 Page Not Found: ../modules/refrensi/controllers/Subkriteria/index
ERROR - 2022-03-06 06:47:02 --> 404 Page Not Found: ../modules/refrensi/controllers/Subkriteria/ajax_datatables
ERROR - 2022-03-06 06:47:02 --> 404 Page Not Found: ../modules/refrensi/controllers/Subkriteria/ajax_datatables
ERROR - 2022-03-06 06:56:45 --> Severity: error --> Exception: Class 'M_subkriteria' not found D:\xampp\htdocs\apps\skripsi\spkframewroks\application\third_party\MX\Loader.php 228
ERROR - 2022-03-06 07:15:24 --> Severity: error --> Exception: Call to a member function insertSubKriteria() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\controllers\Subkriteria.php 118
ERROR - 2022-03-06 07:19:52 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`skripsi`.`ref_sub_kriteria`, CONSTRAINT `ref_sub_kriteria_ibfk_1` FOREIGN KEY (`subKrtKriteriaId`) REFERENCES `ref_kriteria` (`kriteriaId`) ON DELETE CASCADE ON UPDATE CASCADE) - Invalid query: INSERT INTO `ref_sub_kriteria` (`subKrtKriteriaId`, `subKrtNama`, `subKrtValue`) VALUES ('Pilih Kriteria', 'murah', '4')
ERROR - 2022-03-06 07:20:59 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`skripsi`.`ref_sub_kriteria`, CONSTRAINT `ref_sub_kriteria_ibfk_1` FOREIGN KEY (`subKrtKriteriaId`) REFERENCES `ref_kriteria` (`kriteriaId`) ON DELETE CASCADE ON UPDATE CASCADE) - Invalid query: INSERT INTO `ref_sub_kriteria` (`subKrtKriteriaId`, `subKrtNama`, `subKrtValue`) VALUES ('Pilih Kriteria', 'menunjang', '4')
ERROR - 2022-03-06 07:24:06 --> Severity: error --> Exception: Too few arguments to function Subkriteria::update(), 0 passed in D:\xampp\htdocs\apps\skripsi\spkframewroks\system\core\CodeIgniter.php on line 532 and exactly 1 expected D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\controllers\Subkriteria.php 132
ERROR - 2022-03-06 07:24:14 --> Severity: error --> Exception: Too few arguments to function Subkriteria::update(), 0 passed in D:\xampp\htdocs\apps\skripsi\spkframewroks\system\core\CodeIgniter.php on line 532 and exactly 1 expected D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\controllers\Subkriteria.php 132
ERROR - 2022-03-06 07:25:41 --> Severity: error --> Exception: Too few arguments to function Subkriteria::update(), 0 passed in D:\xampp\htdocs\apps\skripsi\spkframewroks\system\core\CodeIgniter.php on line 532 and exactly 1 expected D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\controllers\Subkriteria.php 132
ERROR - 2022-03-06 07:26:40 --> Severity: error --> Exception: Call to a member function getKriteria() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\controllers\Subkriteria.php 163
ERROR - 2022-03-06 07:28:30 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\views\v_subkriteria_edit.php 9
ERROR - 2022-03-06 07:29:30 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\views\v_subkriteria_edit.php 9
ERROR - 2022-03-06 07:30:40 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\views\v_subkriteria_edit.php 9
ERROR - 2022-03-06 07:31:48 --> Severity: error --> Exception: syntax error, unexpected end of file D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\views\v_subkriteria_edit.php 36
ERROR - 2022-03-06 07:32:07 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\views\v_subkriteria_edit.php 9
ERROR - 2022-03-06 07:32:46 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\views\v_subkriteria_edit.php 9
ERROR - 2022-03-06 07:33:54 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\views\v_subkriteria_edit.php 10
ERROR - 2022-03-06 07:38:37 --> Severity: error --> Exception: Too few arguments to function Subkriteria::update(), 0 passed in D:\xampp\htdocs\apps\skripsi\spkframewroks\system\core\CodeIgniter.php on line 532 and exactly 1 expected D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\controllers\Subkriteria.php 132
ERROR - 2022-03-06 08:48:18 --> 404 Page Not Found: ../modules/refrensi/controllers/Pemrograman/index
ERROR - 2022-03-06 08:52:29 --> Severity: error --> Exception: Call to a member function list_bahasa() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\controllers\Pemrograman.php 54
ERROR - 2022-03-06 08:52:29 --> Severity: error --> Exception: Call to a member function list_bahasa() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\controllers\Pemrograman.php 54
ERROR - 2022-03-06 08:52:58 --> Severity: error --> Exception: Call to a member function list_bahasa() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\controllers\Pemrograman.php 54
ERROR - 2022-03-06 08:52:58 --> Severity: error --> Exception: Call to a member function list_bahasa() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\controllers\Pemrograman.php 54
ERROR - 2022-03-06 08:53:37 --> Query error: Unknown column 'PemrogramanNama' in 'order clause' - Invalid query: SELECT `pemId` AS `id`, `pemNama` AS `nama`
FROM `ref_pemrograman`
ORDER BY `PemrogramanNama` ASC, `PemrogramanId` ASC
 LIMIT 10
ERROR - 2022-03-06 08:53:38 --> Query error: Unknown column 'PemrogramanNama' in 'order clause' - Invalid query: SELECT `pemId` AS `id`, `pemNama` AS `nama`
FROM `ref_pemrograman`
ORDER BY `PemrogramanNama` ASC, `PemrogramanId` ASC
 LIMIT 10
ERROR - 2022-03-06 08:57:13 --> Query error: Duplicate entry '0' for key 'PRIMARY' - Invalid query: INSERT INTO `ref_pemrograman` (`pemNama`) VALUES ('C#')
ERROR - 2022-03-06 08:57:16 --> Query error: Duplicate entry '0' for key 'PRIMARY' - Invalid query: INSERT INTO `ref_pemrograman` (`pemNama`) VALUES ('C#')
