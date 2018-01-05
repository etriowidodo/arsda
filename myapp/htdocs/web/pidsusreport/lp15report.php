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
$query="select * from pidsus.rpt_pds_lp15 ('".$_GET['ID_SATKER']."','".$_GET['ID_JENIS_KASUS']."','".$_GET['BULAN']."','".$_GET['TAHUN']."')";//query to get form's basic setup

//echo $query;
//$rows = $connection->createCommand($query)->queryAll();
$odf = new odf("lp15report.odt");
/*

$i=1;
$lp15 = $odf->setSegment('lp15');
foreach($rows as $currentRow) {

 $lp15->nomor($currentRow['nomor']);
 $lp15->kejaksaan($currentRow['kejaksaan']);
 $lp15->sisa_bulan_lalu($currentRow['sisa_bulan_lalu']);
 $lp15->masuk_bulan_lap($currentRow['masuk_bulan_lap']);
 $lp15->jumlah($currentRow['jumlah']);
 $lp15->lengkap($currentRow['lengkap']);
 $lp15->berkas_kembali($currentRow['berkas_kembali']);
 $lp15->dpt_dilengkapi($currentRow['dpt_dilengkapi']);
 $lp15->tdk_dpt_dilengkapi($currentRow['tdk_dpt_dilengkapi']);
 $lp15->tdk_kembali_jpu($currentRow['tdk_kembali_jpu']);
 $lp15->jumlah2($currentRow['jumlah2']);
 $lp15->sisa($currentRow['sisa']);
 $lp15->keterangan($currentRow['keterangan']);
 $lp15->merge();
 $i++;
}
$odf->mergeSegment($lp15);
$reportFunction->closeConnection($connection);
$connection=$reportFunction->openConnection();
$query2="select * from pidsus.rpt_pds_lp15_sum ('".$_GET['ID_SATKER']."','".$_GET['ID_JENIS_KASUS']."','".$_GET['BULAN']."','".$_GET['TAHUN']."')";//query to get form's basic setup

$row = $connection->createCommand($query2)->queryOne();

$odf->setVars('satker', $row['satker']);
 $odf->setVars('bulan', $row['bulan']);
 $odf->setVars('tahun', $row['tahun']);
 $odf->setVars('sisa_bulan_lalu', $row['sisa_bulan_lalu']);
 $odf->setVars('masuk_bulan_lap', $row['masuk_bulan_lap']);
 $odf->setVars('jumlah', $row['jumlah']);
 $odf->setVars('lengkap', $row['lengkap']);
 $odf->setVars('berkas_kembali', $row['berkas_kembali']);
 $odf->setVars('dpt_dilengkapi', $row['dpt_dilengkapi']);
 $odf->setVars('tdk_dpt_dilengkapi', $row['tdk_dpt_dilengkapi']);
 $odf->setVars('tdk_kembali_jpu', $row['tdk_kembali_jpu']);
 $odf->setVars('jumlah2', $row['jumlah2']);
 $odf->setVars('sisa', $row['sisa']);
 $odf->setVars('keterangan', $row['keterangan']);
 */
$reportFunction->closeConnection($connection);
// We export the file
$odf->exportAsAttachedFile("LP 15.odt");
 
?>