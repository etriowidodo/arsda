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
$query="select * from pidsus.rpt_pds_lp9 ('".$_GET['ID_SATKER']."','".$_GET['ID_JENIS_KASUS']."','".$_GET['BULAN']."','".$_GET['TAHUN']."')";//query to get form's basic setup

//echo $query;
//$rows = $connection->createCommand($query)->queryAll();
$odf = new odf("lp9report.odt");
/*

$i=1;
$lp9 = $odf->setSegment('lp9');
foreach($rows as $currentRow) {

 $lp9->nomor($currentRow['nomor']);
 $lp9->kejaksaan($currentRow['kejaksaan']);
 $lp9->sisa_bulan_lalu($currentRow['sisa_bulan_lalu']);
 $lp9->masuk_bulan_lap($currentRow['masuk_bulan_lap']);
 $lp9->jumlah($currentRow['jumlah']);
 $lp9->lengkap($currentRow['lengkap']);
 $lp9->berkas_kembali($currentRow['berkas_kembali']);
 $lp9->dpt_dilengkapi($currentRow['dpt_dilengkapi']);
 $lp9->tdk_dpt_dilengkapi($currentRow['tdk_dpt_dilengkapi']);
 $lp9->tdk_kembali_jpu($currentRow['tdk_kembali_jpu']);
 $lp9->jumlah2($currentRow['jumlah2']);
 $lp9->sisa($currentRow['sisa']);
 $lp9->keterangan($currentRow['keterangan']);
 $lp9->merge();
 $i++;
}
$odf->mergeSegment($lp9);
$reportFunction->closeConnection($connection);
$connection=$reportFunction->openConnection();
$query2="select * from pidsus.rpt_pds_lp9_sum ('".$_GET['ID_SATKER']."','".$_GET['ID_JENIS_KASUS']."','".$_GET['BULAN']."','".$_GET['TAHUN']."')";//query to get form's basic setup

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
$odf->exportAsAttachedFile("LP 9.odt");
 
?>