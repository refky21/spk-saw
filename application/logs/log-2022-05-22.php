<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-05-22 04:24:38 --> 404 Page Not Found: ../modules/laporan/controllers/Hasil/index
ERROR - 2022-05-22 04:25:01 --> 404 Page Not Found: ../modules/transaksi/controllers//index
ERROR - 2022-05-22 04:31:59 --> 404 Page Not Found: ../modules/transaksi/controllers//index
ERROR - 2022-05-22 04:34:59 --> 404 Page Not Found: ../modules/transaksi/controllers//index
ERROR - 2022-05-22 04:35:11 --> 404 Page Not Found: ../modules/transaksi/controllers//index
ERROR - 2022-05-22 04:35:21 --> Severity: error --> Exception: Call to a member function getBahasa() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\transaksi\controllers\Penilaian.php 72
ERROR - 2022-05-22 04:35:32 --> Severity: error --> Exception: Unable to locate the model you have specified: M_bobot D:\xampp\htdocs\apps\skripsi\spkframewroks\system\core\Loader.php 348
ERROR - 2022-05-22 04:36:33 --> Severity: error --> Exception: Unable to locate the model you have specified: M_bobot D:\xampp\htdocs\apps\skripsi\spkframewroks\system\core\Loader.php 348
ERROR - 2022-05-22 04:36:46 --> Severity: error --> Exception: Call to a member function getBahasa() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\transaksi\controllers\Penilaian.php 72
ERROR - 2022-05-22 04:40:19 --> Severity: error --> Exception: Call to a member function getFramwork() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\transaksi\controllers\Penilaian.php 72
ERROR - 2022-05-22 04:41:18 --> Severity: error --> Exception: Call to a member function getFramwork() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\transaksi\controllers\Penilaian.php 72
ERROR - 2022-05-22 04:42:00 --> Severity: error --> Exception: Call to undefined method M_penilaian::getFramwork() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\transaksi\controllers\Penilaian.php 73
ERROR - 2022-05-22 04:47:28 --> Severity: error --> Exception: Call to undefined method M_penilaian::cekFw() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\transaksi\controllers\Penilaian.php 45
ERROR - 2022-05-22 04:47:53 --> Query error: Table 'skripsi.tr_framework' doesn't exist - Invalid query: SELECT *
FROM `tr_framework`
WHERE `fwPmId` = '1'
AND `fwId` = '1'
ERROR - 2022-05-22 06:32:22 --> 404 Page Not Found: ../modules/transaksi/controllers//index
ERROR - 2022-05-22 06:35:54 --> 404 Page Not Found: ../modules/transaksi/controllers//index
ERROR - 2022-05-22 07:10:26 --> 404 Page Not Found: ../modules/transaksi/controllers/Penilaian/ajax_datatables
ERROR - 2022-05-22 07:10:26 --> 404 Page Not Found: ../modules/transaksi/controllers/Penilaian/ajax_datatables
ERROR - 2022-05-22 07:10:48 --> 404 Page Not Found: ../modules/transaksi/controllers/Penilaian/ajax_datatables
ERROR - 2022-05-22 07:14:06 --> Severity: error --> Exception: Call to undefined method M_penilaian::list_nilai() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\transaksi\controllers\Penilaian.php 58
ERROR - 2022-05-22 07:14:06 --> Severity: error --> Exception: Call to undefined method M_penilaian::list_nilai() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\transaksi\controllers\Penilaian.php 58
ERROR - 2022-05-22 07:14:28 --> Query error: Unknown column 'bbtKrtId' in 'on clause' - Invalid query: SELECT `nilaiId` as `id`, `nilaiFwId` as `id_fw`, `nilaiBhsId` as `id_pem`, `nilaiKrtId` as `kriteriaId`, `nilaiAltrId` as `alternatifId`, `pemNama` as `pemrograman`, `fwNama` as `Framework`
FROM `tr_nilai`
JOIN `ref_kriteria` ON `kriteriaId`=`bbtKrtId`
JOIN `ref_pemrograman` ON `pemId`=`bbtBhsId`
JOIN `ref_framework` ON `fwPmId`=`pemId`
GROUP BY `bbtBhsId`
ORDER BY `pemNama` ASC
 LIMIT 10
ERROR - 2022-05-22 07:14:28 --> Query error: Unknown column 'bbtKrtId' in 'on clause' - Invalid query: SELECT `nilaiId` as `id`, `nilaiFwId` as `id_fw`, `nilaiBhsId` as `id_pem`, `nilaiKrtId` as `kriteriaId`, `nilaiAltrId` as `alternatifId`, `pemNama` as `pemrograman`, `fwNama` as `Framework`
FROM `tr_nilai`
JOIN `ref_kriteria` ON `kriteriaId`=`bbtKrtId`
JOIN `ref_pemrograman` ON `pemId`=`bbtBhsId`
JOIN `ref_framework` ON `fwPmId`=`pemId`
GROUP BY `bbtBhsId`
ORDER BY `pemNama` ASC
 LIMIT 10
ERROR - 2022-05-22 07:47:26 --> Query error: Unknown column 'bbtKrtId' in 'on clause' - Invalid query: SELECT `nilaiId` as `id`, `nilaiFwId` as `id_fw`, `nilaiBhsId` as `id_pem`, `nilaiKrtId` as `kriteriaId`, `nilaiAltrId` as `alternatifId`, `pemNama` as `pemrograman`, `fwNama` as `Framework`
FROM `tr_nilai`
JOIN `ref_kriteria` ON `kriteriaId`=`bbtKrtId`
JOIN `ref_pemrograman` ON `pemId`=`nilaiBhsId`
JOIN `ref_framework` ON `fwPmId`=`pemId`
GROUP BY `nilaiFwId`
ORDER BY `pemNama` ASC
 LIMIT 10
ERROR - 2022-05-22 07:47:27 --> Query error: Unknown column 'bbtKrtId' in 'on clause' - Invalid query: SELECT `nilaiId` as `id`, `nilaiFwId` as `id_fw`, `nilaiBhsId` as `id_pem`, `nilaiKrtId` as `kriteriaId`, `nilaiAltrId` as `alternatifId`, `pemNama` as `pemrograman`, `fwNama` as `Framework`
FROM `tr_nilai`
JOIN `ref_kriteria` ON `kriteriaId`=`bbtKrtId`
JOIN `ref_pemrograman` ON `pemId`=`nilaiBhsId`
JOIN `ref_framework` ON `fwPmId`=`pemId`
GROUP BY `nilaiFwId`
ORDER BY `pemNama` ASC
 LIMIT 10
ERROR - 2022-05-22 08:06:00 --> Severity: error --> Exception: Call to undefined method M_penilaian::DeleteNilai() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\transaksi\controllers\Penilaian.php 181
ERROR - 2022-05-22 08:10:08 --> 404 Page Not Found: ../modules/laporan/controllers/Hasil/index
ERROR - 2022-05-22 08:11:36 --> 404 Page Not Found: ../modules/laporan/controllers/Hasil/index
ERROR - 2022-05-22 08:21:52 --> Severity: error --> Exception: Unable to locate the model you have specified: M_hasil D:\xampp\htdocs\apps\skripsi\spkframewroks\system\core\Loader.php 348
ERROR - 2022-05-22 08:28:48 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:28:48 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:28:48 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:28:48 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:28:48 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:28:49 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:28:49 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:28:50 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:28:50 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:28:51 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:29:09 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:29:09 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:29:09 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:29:09 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:29:09 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:29:10 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:29:10 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:29:11 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:29:11 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:29:12 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:30:24 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:30:24 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:30:24 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:30:24 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:30:24 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:30:25 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:30:25 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:30:26 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:30:26 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:30:27 --> 404 Page Not Found: /index
ERROR - 2022-05-22 08:48:57 --> Severity: error --> Exception: Call to a member function getKriteria() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 10
ERROR - 2022-05-22 09:03:02 --> Severity: error --> Exception: Call to a member function result_array() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\models\M_hasil.php 81
ERROR - 2022-05-22 09:03:05 --> Severity: error --> Exception: Call to a member function result_array() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\models\M_hasil.php 81
ERROR - 2022-05-22 09:03:16 --> Severity: error --> Exception: Call to a member function result_array() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\models\M_hasil.php 81
ERROR - 2022-05-22 09:03:55 --> Query error: Table 'skripsi.ref_alternatif' doesn't exist - Invalid query: SELECT `nilaiId` as `id`, `nilaiFwId` as `id_fw`, `nilaiBhsId` as `id_bhs`, `nilaiKrtId` as `id_krt`, `nilaiAltrId` as `id_altr`
FROM `tr_nilai`
JOIN `ref_framework` ON `fwId` = `nilaiFwId`
JOIN `ref_pemrograman` ON `pemId` = `fwPmId`
JOIN `ref_sub_kriteria` ON `subKrtId` = `nilaiKrtId`
JOIN `ref_alternatif` ON `altrId` = `nilaiAltrId`
JOIN `ref_kriteria` ON `kriteriaId` = `subKrtKriteriaId`
ERROR - 2022-05-22 09:09:39 --> Query error: Unknown column 'nilaiBhsIda' in 'where clause' - Invalid query: SELECT `nilaiId` as `id`, `nilaiFwId` as `id_fw`, `nilaiBhsId` as `id_bhs`, `nilaiKrtId` as `id_krt`, `nilaiAltrId` as `id_altr`, `pemNama` as `nama_pem`, `fwNama` as `nama_fw`, `kriteriaSifat` as `sifat`, `subKrtNama` as `nama_altr`, `subKrtValue` as `nilai_altr`
FROM `tr_nilai`
JOIN `ref_framework` ON `fwId` = `nilaiFwId`
JOIN `ref_pemrograman` ON `pemId` = `fwPmId`
JOIN `ref_sub_kriteria` ON `subKrtId` = `nilaiKrtId`
JOIN `ref_kriteria` ON `kriteriaId` = `subKrtKriteriaId`
WHERE `nilaiBhsIda` IS NULL
ERROR - 2022-05-22 09:15:46 --> Severity: error --> Exception: Using $this when not in object context D:\xampp\htdocs\apps\skripsi\spkframewroks\application\helpers\app_helper.php 53
ERROR - 2022-05-22 09:16:22 --> Severity: error --> Exception: Call to undefined method CI::select() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\helpers\app_helper.php 55
ERROR - 2022-05-22 09:17:02 --> Severity: error --> Exception: Call to undefined method CI::select() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\helpers\app_helper.php 55
ERROR - 2022-05-22 09:18:14 --> Severity: error --> Exception: Call to undefined method CI::select() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\helpers\app_helper.php 56
ERROR - 2022-05-22 09:18:35 --> Severity: error --> Exception: Call to undefined method CI::join() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\helpers\app_helper.php 57
ERROR - 2022-05-22 09:18:56 --> Severity: error --> Exception: Call to undefined method CI::join() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\helpers\app_helper.php 68
ERROR - 2022-05-22 09:32:00 --> Severity: error --> Exception: Call to a member function getAlternatif() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\transaksi\controllers\Penilaian.php 155
ERROR - 2022-05-22 09:34:12 --> Query error: Unknown column 'kriteriaSifat' in 'field list' - Invalid query: SELECT `nilaiId` as `id`, `nilaiFwId` as `id_fw`, `nilaiBhsId` as `id_bhs`, `nilaiKrtId` as `id_krt`, `nilaiAltrId` as `id_altr`, `pemNama` as `nama_pem`, `fwNama` as `nama_fw`, `kriteriaSifat` as `sifat`, `subKrtNama` as `nama_altr`, `subKrtValue` as `nilai_altr`
FROM `tr_nilai`
JOIN `ref_framework` ON `fwId` = `nilaiFwId`
JOIN `ref_pemrograman` ON `pemId` = `fwPmId`
JOIN `ref_sub_kriteria` ON `subKrtId` = `nilaiAltrId`
WHERE `nilaiBhsId` = '1'
AND `nilaiFwId` = '1'
ERROR - 2022-05-22 09:42:06 --> Query error: Unknown column 'subKrtKriteriaId' in 'on clause' - Invalid query: SELECT `subKrtValue` as `nilai`, `kriteriaSifat` as `sifat`, `nilaiFwId` as `id_fw`
FROM `tr_nilai`
JOIN `ref_kriteria` ON `kriteriaId` = `subKrtKriteriaId`
JOIN `ref_sub_kriteria` ON `subKrtId` = `nilaiAltrId`
WHERE `nilaiBhsId` = '1'
AND `nilaiFwId` = '1'
ERROR - 2022-05-22 10:05:45 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 20
ERROR - 2022-05-22 10:05:50 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 20
ERROR - 2022-05-22 10:05:55 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 20
ERROR - 2022-05-22 10:06:18 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 20
ERROR - 2022-05-22 10:26:07 --> Severity: error --> Exception: Using $this when not in object context D:\xampp\htdocs\apps\skripsi\spkframewroks\application\helpers\app_helper.php 64
ERROR - 2022-05-22 10:26:23 --> Severity: error --> Exception: Using $this when not in object context D:\xampp\htdocs\apps\skripsi\spkframewroks\application\helpers\app_helper.php 64
ERROR - 2022-05-22 10:26:44 --> Severity: error --> Exception: Call to a member function result_array() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\helpers\app_helper.php 76
ERROR - 2022-05-22 10:27:20 --> Severity: error --> Exception: Call to undefined method CI::result_array() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\helpers\app_helper.php 76
ERROR - 2022-05-22 10:27:54 --> Severity: error --> Exception: Cannot use object of type mysqli as array D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 28
ERROR - 2022-05-22 10:28:25 --> Severity: error --> Exception: Cannot use object of type stdClass as array D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 28
ERROR - 2022-05-22 10:28:51 --> Severity: error --> Exception: Cannot use object of type stdClass as array D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 28
ERROR - 2022-05-22 10:50:05 --> Severity: error --> Exception: Call to a member function getAlternative() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 54
ERROR - 2022-05-22 10:50:13 --> Severity: error --> Exception: Call to a member function getAlternative() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 54
ERROR - 2022-05-22 10:50:54 --> Severity: error --> Exception: Call to a member function query() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\helpers\app_helper.php 107
ERROR - 2022-05-22 10:51:31 --> Severity: error --> Exception: Call to a member function query() on null D:\xampp\htdocs\apps\skripsi\spkframewroks\application\helpers\app_helper.php 107
ERROR - 2022-05-22 11:30:55 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 63
ERROR - 2022-05-22 11:31:13 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 63
ERROR - 2022-05-22 11:32:04 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 63
ERROR - 2022-05-22 11:33:10 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 63
ERROR - 2022-05-22 11:33:35 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 63
ERROR - 2022-05-22 11:36:18 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 63
ERROR - 2022-05-22 11:37:45 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 63
ERROR - 2022-05-22 11:38:11 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 63
ERROR - 2022-05-22 11:50:08 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 108
ERROR - 2022-05-22 11:50:20 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 108
ERROR - 2022-05-22 11:52:27 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 105
ERROR - 2022-05-22 11:52:27 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 105
ERROR - 2022-05-22 11:53:23 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 105
ERROR - 2022-05-22 11:53:57 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 105
ERROR - 2022-05-22 11:54:22 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 105
ERROR - 2022-05-22 11:54:22 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 105
ERROR - 2022-05-22 11:55:18 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 105
ERROR - 2022-05-22 11:56:06 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 106
ERROR - 2022-05-22 11:56:06 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 106
ERROR - 2022-05-22 11:56:40 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 106
ERROR - 2022-05-22 11:56:40 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 106
ERROR - 2022-05-22 11:57:11 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 63
ERROR - 2022-05-22 11:57:34 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 63
ERROR - 2022-05-22 11:57:57 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 63
ERROR - 2022-05-22 11:58:48 --> Severity: Warning --> array_column() expects parameter 1 to be array, null given D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 65
ERROR - 2022-05-22 11:58:48 --> Severity: Warning --> array_column() expects parameter 1 to be array, null given D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 65
ERROR - 2022-05-22 11:58:48 --> Severity: Warning --> array_column() expects parameter 1 to be array, null given D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 65
ERROR - 2022-05-22 11:58:48 --> Severity: Warning --> array_column() expects parameter 1 to be array, null given D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 65
ERROR - 2022-05-22 11:58:48 --> Severity: Warning --> array_column() expects parameter 1 to be array, null given D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 65
ERROR - 2022-05-22 11:58:48 --> Severity: Warning --> array_column() expects parameter 1 to be array, null given D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 65
ERROR - 2022-05-22 11:58:48 --> Severity: Warning --> array_column() expects parameter 1 to be array, null given D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 65
ERROR - 2022-05-22 11:58:48 --> Severity: Warning --> array_column() expects parameter 1 to be array, null given D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 65
ERROR - 2022-05-22 11:58:48 --> Severity: Warning --> array_column() expects parameter 1 to be array, null given D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 65
ERROR - 2022-05-22 11:58:48 --> Severity: Warning --> array_column() expects parameter 1 to be array, null given D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 65
ERROR - 2022-05-22 11:58:48 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 106
ERROR - 2022-05-22 11:58:48 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 106
ERROR - 2022-05-22 11:59:18 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 106
ERROR - 2022-05-22 11:59:18 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 106
ERROR - 2022-05-22 11:59:43 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 106
ERROR - 2022-05-22 11:59:43 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 106
ERROR - 2022-05-22 12:00:18 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 65
ERROR - 2022-05-22 12:01:34 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 108
ERROR - 2022-05-22 12:01:34 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 108
ERROR - 2022-05-22 12:02:15 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 111
ERROR - 2022-05-22 12:04:40 --> Severity: error --> Exception: Unsupported operand types D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 111
ERROR - 2022-05-22 12:12:45 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 106
ERROR - 2022-05-22 12:12:45 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 106
ERROR - 2022-05-22 12:13:26 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 106
ERROR - 2022-05-22 12:13:26 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\views\hasil\v_view.php 106
ERROR - 2022-05-22 12:31:45 --> Severity: error --> Exception: Call to undefined method CI_DB_mysqli_driver::num_rows() D:\xampp\htdocs\apps\skripsi\spkframewroks\application\helpers\app_helper.php 72
ERROR - 2022-05-22 12:32:14 --> Query error: Table 'skripsi.hasil' doesn't exist - Invalid query: INSERT INTO `hasil` (`hasil`, `hslFwId`, `hslBhsId`) VALUES (12, '1', '1')
ERROR - 2022-05-22 12:40:47 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '?)' at line 8 - Invalid query: SELECT 
        hasil,
        pemNama,
        fwNama
        FROM tr_hasil 
        JOIN ref_pemrograman ON hslBhsId=pemId
        JOIN ref_framework ON hslFwId=fwId
        WHERE hasil=(SELECT MAX(hasil) FROM tr_hasil WHERE hslBhsId=?)
ERROR - 2022-05-22 12:40:52 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '?)' at line 8 - Invalid query: SELECT 
        hasil,
        pemNama,
        fwNama
        FROM tr_hasil 
        JOIN ref_pemrograman ON hslBhsId=pemId
        JOIN ref_framework ON hslFwId=fwId
        WHERE hasil=(SELECT MAX(hasil) FROM tr_hasil WHERE hslBhsId=?)
ERROR - 2022-05-22 12:40:57 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '?)' at line 8 - Invalid query: SELECT 
        hasil,
        pemNama,
        fwNama
        FROM tr_hasil 
        JOIN ref_pemrograman ON hslBhsId=pemId
        JOIN ref_framework ON hslFwId=fwId
        WHERE hasil=(SELECT MAX(hasil) FROM tr_hasil WHERE hslBhsId=?)
