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
$query="select * from pidsus.rpt_pds_lp8 ('".$_GET['ID_SATKER']."','".$_GET['ID_JENIS_KASUS']."','".$_GET['BULAN']."','".$_GET['TAHUN']."')";//query to get form's basic setup

//echo $query;
//$rows = $connection->createCommand($query)->queryAll();
$odf = new odf("lp8report.odt");
/*

$i=1;
$lp8 = $odf->setSegment('lp8');
foreach($rows as $currentRow) {

 $lp8->nomor($currentRow['nomor']);
 $lp8->kejaksaan($currentRow['kejaksaan']);
 $lp8->sisa_bulan_lalu($currentRow['sisa_bulan_lalu']);
 $lp8->masuk_bulan_lap($currentRow['masuk_bulan_lap']);
 $lp8->jumlah($currentRow['jumlah']);
 $lp8->lengkap($currentRow['lengkap']);
 $lp8->berkas_kembali($currentRow['berkas_kembali']);
 $lp8->dpt_dilengkapi($currentRow['dpt_dilengkapi']);
 $lp8->tdk_dpt_dilengkapi($currentRow['tdk_dpt_dilengkapi']);
 $lp8->tdk_kembali_jpu($currentRow['tdk_kembali_jpu']);
 $lp8->jumlah2($currentRow['jumlah2']);
 $lp8->sisa($currentRow['sisa']);
 $lp8->keterangan($currentRow['keterangan']);
 $lp8->merge();
 $i++;
}
$odf->mergeSegment($lp8);
$reportFunction->closeConnection($connection);
$connection=$reportFunction->openConnection();
$query2="select * from pidsus.rpt_pds_lp8_sum ('".$_GET['ID_SATKER']."','".$_GET['ID_JENIS_KASUS']."','".$_GET['BULAN']."','".$_GET['TAHUN']."')";//query to get form's basic setup

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
$odf->exportAsAttachedFile("LP 8.odt");
 
?>