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
$query="select * from pidsus.rpt_pds_lp2 ('".$_GET['ID_SATKER']."','".$_GET['ID_JENIS_KASUS']."','".$_GET['BULAN']."','".$_GET['TAHUN']."')";//query to get form's basic setup

//echo $query;
$rows = $connection->createCommand($query)->queryAll();
$odf = new odf("lp2report.odt");


$i=1;
$lp2 = $odf->setSegment('LP2');
foreach($rows as $currentRow) {

 $lp2->nomor($currentRow['nomor']);
 $lp2->kejaksaan($currentRow['kejaksaan']);
 $lp2->sisa_bulan_lalu($currentRow['sisa_bulan_lalu']);
 $lp2->masuk_bulan_lap($currentRow['masuk_bulan_lap']);
 $lp2->jumlah($currentRow['jumlah']);
  $lp2->henti_tdk_ckp_bukti($currentRow['henti_tdk_ckp_bukti']);
 $lp2->henti_bukan_tp($currentRow['henti_bukan_tp']);
 $lp2->henti_demi_hukum($currentRow['henti_demi_hukum']);
 $lp2->kirim_inst_lain($currentRow['kirim_inst_lain']);
 $lp2->tingkat_tut($currentRow['tingkat_tut']);
 $lp2->jml_selesai($currentRow['jml_selesai']);
 $lp2->sisa_bln_lap($currentRow['sisa_bln_lap']);
 $lp2->keterangan($currentRow['keterangan']);
 $lp2->merge();
 $i++;
}
$odf->mergeSegment($lp2);
$reportFunction->closeConnection($connection);
$connection=$reportFunction->openConnection();
$query2="select * from pidsus.rpt_pds_lp2_sum ('".$_GET['ID_SATKER']."','".$_GET['ID_JENIS_KASUS']."','".$_GET['BULAN']."','".$_GET['TAHUN']."')";//query to get form's basic setup

$row = $connection->createCommand($query2)->queryOne();

$odf->setVars('satker', $row['satker']);
 $odf->setVars('bulan', $row['bulan']);
 $odf->setVars('tahun', $row['tahun']);
 $odf->setVars('sisa_bulan_lalu', $row['sisa_bulan_lalu']);
 $odf->setVars('masuk_bulan_lap', $row['masuk_bulan_lap']);
 $odf->setVars('jumlah', $row['jumlah']);
 $odf->setVars('henti_tdk_ckp_bukti', $row['henti_tdk_ckp_bukti']);
 $odf->setVars('henti_bukan_tp', $row['henti_bukan_tp']);
 $odf->setVars('henti_demi_hukum', $row['henti_demi_hukum']);
 $odf->setVars('kirim_inst_lain', $row['kirim_inst_lain']);
  $odf->setVars('tingkat_tut', $row['tingkat_tut']);
 $odf->setVars('jml_selesai', $row['jml_selesai']);
 $odf->setVars('sisa_bln_lap', $row['sisa_bln_lap']);
 $odf->setVars('keterangan', $row['keterangan']);
 
$reportFunction->closeConnection($connection);
// We export the file
$odf->exportAsAttachedFile("LP 2.odt");
 
?>