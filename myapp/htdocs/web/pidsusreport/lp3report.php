<?php

/**
 * Tutoriel file
 * Description : Simple substitutions of variables
 * You need PHP 5.2 at least
 * You need Zip Extension or PclZip library
 *
 * @copyright  GPL License 2008 - Julien Pauli - Cyril PIERRE de GEYER - Anaska (http://www.anaska.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL License
 * @version 1.3
 */


// Make sure you have Zip extension or PclZip library loaded
// First : include the librairy

require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../vendor/cybermonde/odtphp/library/Odf.php');
require('reportFunction.php');
$reportFunction=new reportFunction();
$connection=$reportFunction->openConnection();
$query="select * from pidsus.rpt_pds_lp3 ('".$_GET['ID_SATKER']."','".$_GET['ID_JENIS_KASUS']."','".$_GET['BULAN']."','".$_GET['TAHUN']."')";//query to get form's basic setup

//echo $query;
$rows = $connection->createCommand($query)->queryAll();
$odf = new odf("lp3report.odt");


$i=1;
$lp3 = $odf->setSegment('LP3');
foreach($rows as $currentRow) {

 $lp3->nomor($currentRow['nomor']);
 $lp3->kejaksaan($currentRow['kejaksaan']);
 $lp3->sisa_bulan_lalu($currentRow['sisa_bulan_lalu']);
 $lp3->masuk_bulan_lap($currentRow['masuk_bulan_lap']);
 $lp3->jumlah($currentRow['jumlah']);
 $lp3->hentikan_dik($currentRow['hentikan_dik']);
 $lp3->menjadi_berkas($currentRow['menjadi_berkas']);
 $lp3->jumlah_selesai($currentRow['jumlah_selesai']);
 $lp3->sisa_bulan_lap($currentRow['sisa_bulan_lap']);
 $lp3->sp3_tepat($currentRow['sp3_tepat']);
 $lp3->sp3_tdk_tepat($currentRow['sp3_tdk_tepat']);
 $lp3->didahului_spdp($currentRow['didahului_spdp']);
  $lp3->spdp_berkas($currentRow['spdp_berkas']);
 $lp3->keterangan($currentRow['keterangan']);
 $lp3->merge();
 $i++;
}
$odf->mergeSegment($lp3);
$reportFunction->closeConnection($connection);
$connection=$reportFunction->openConnection();
$query2="select * from pidsus.rpt_pds_lp3_sum ('".$_GET['ID_SATKER']."','".$_GET['ID_JENIS_KASUS']."','".$_GET['BULAN']."','".$_GET['TAHUN']."')";//query to get form's basic setup

$row = $connection->createCommand($query2)->queryOne();

$odf->setVars('satker', $row['satker']);
 $odf->setVars('bulan', $row['bulan']);
 $odf->setVars('tahun', $row['tahun']);
 $odf->setVars('sisa_bulan_lalu', $row['sisa_bulan_lalu']);
 $odf->setVars('masuk_bulan_lap', $row['masuk_bulan_lap']);
 $odf->setVars('jumlah', $row['jumlah']);
 $odf->setVars('hentikan_dik', $row['hentikan_dik']);
 $odf->setVars('menjadi_berkas', $row['menjadi_berkas']);
 $odf->setVars('jumlah_selesai', $row['jumlah_selesai']);
 $odf->setVars('sisa_bulan_lap', $row['sisa_bulan_lap']);
 $odf->setVars('sp3_tepat', $row['sp3_tepat']);
 $odf->setVars('sp3_tdk_tepat', $row['sp3_tdk_tepat']);
 $odf->setVars('didahului_spdp', $row['didahului_spdp']);
 $odf->setVars('spdp_berkas', $row['spdp_berkas']);
 $odf->setVars('keterangan', $row['keterangan']);
 
$reportFunction->closeConnection($connection);
// We export the file
$odf->exportAsAttachedFile("LP 3.odt");
 
?>