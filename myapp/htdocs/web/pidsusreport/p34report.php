<?php

/**
 * Tutoriel file
 * Description : Imbricating several segments
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

$odf = new odf("p34report.odt");


/*$reportFunction=new reportFunction();
$connection=$reportFunction->openConnection();
$reportFunction->getSuratIsi($odf,$_GET['id'],$connection);
$reportFunction->getSuratTembusan($odf,$_GET['id'],$connection);
$reportFunction->closeConnection($connection);*/

$reportFunction=new reportFunction();
$connection=$reportFunction->openConnection();
$reportFunction->getSuratIsiTut($odf,$_GET['id'],$connection);
//$reportFunction->getSuratTembusanTut($odf,$_GET['id'],$connection);
//$reportFunction->getSuratJaksaTut($odf,$_GET['id'],$connection);
$reportFunction->getSuratDetailTut($odf,$_GET['id'],'BarangBukti',$connection);
//$reportFunction->getSuratDetailTut($odf,$_GET['id'],'Pertimbangan',$connection);
//=$reportFunction->getTersangkaTut($odf,$isi2,$connection);
//function getSuratDetail($odf,$id,$type,$connection)
$reportFunction->closeConnection($connection);


$query="Select * from pidsus.rpt_pds_tut_surat('".$_GET['id']."');";//query to get form's basic setup
//echo $query;
$row = $connection->createCommand($query)->queryOne();

$odf->setVars('nama_satker', $row['nama_satker']);
$odf->setVars('nama_hari', $row['nama_hari']);
$odf->setVars('jam_surat', $row['jam_surat']);
//$odf->setVars('no_surat', $row['no_surat']);
/*$odf->setVars('sifat_surat',$row['sifat_surat']);
$odf->setVars('lampiran_surat', $row['lampiran_surat']);
$odf->setVars('perihal_surat', $row['perihal_surat']);*/
$odf->setVars('lokasi_surat', $row['lokasi_surat']);
$odf->setVars('tgl_surat', $row['tgl_surat']);
/*$odf->setVars('kepada', $row['kepada']);
$odf->setVars('kepada_lokasi', $row['kepada_lokasi']);
$odf->setVars('jabatan_ttd', $row['jabatan_ttd']);*/
/*$odf->setVars('nama_ttd', $row['nama_ttd']);
$odf->setVars('pangkat_ttd', $row['pangkat_ttd']);
$odf->setVars('nip_ttd', $row['nip_ttd']);*/
$odf->setVars('isi6','');

// get info jaksa penyidik
$query="select * from pidsus.get_data_jaksa('".$isi6."');";//query to get form's basic setup
//echo $query;
$row = $connection->createCommand($query)->queryOne();
$odf->setVars('nama', $row['nama']);
$odf->setVars('nip', $row['nip']);
$odf->setVars('pangkat',$row['pangkat']);
$connection->close();
// end

// untuk surat isi yang pakai format khusus bisa diubah disini
//$isi1 = $isi1.'tes';
//$odf->setVars('isi1', $isi1);
//echo $i;
//echo $isi1;
//print_r($row);
// We export the file

$odf->exportAsAttachedFile('P34.odt');
 
?>