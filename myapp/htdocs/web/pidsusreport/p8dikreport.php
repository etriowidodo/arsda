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

$odf = new odf("p8dkreport.odt");


/*$reportFunction=new reportFunction();
$connection=$reportFunction->openConnection();
$reportFunction->getSuratIsi($odf,$_GET['id'],$connection);
$reportFunction->getSuratTembusan($odf,$_GET['id'],$connection);
$reportFunction->closeConnection($connection);*/

$reportFunction=new reportFunction();
$connection=$reportFunction->openConnection();
$reportFunction->getSuratIsiDik2($odf,$_GET['id'],$connection);
$reportFunction->getSuratTembusanDik($odf,$_GET['id'],$connection);
$reportFunction->getSuratJaksaDik($odf,$_GET['id'],$connection);
//function getSuratDetail($odf,$id,$type,$connection)
$reportFunction->closeConnection($connection);


$query="Select * from pidsus.rpt_pds_dik_surat('".$_GET['id']."');";//query to get form's basic setup
//echo $query;
$row = $connection->createCommand($query)->queryOne();

$odf->setVars('nama_satker', $row['nama_satker']);
$odf->setVars('no_surat', $row['no_surat']);
/*$odf->setVars('sifat_surat',$row['sifat_surat']);
$odf->setVars('lampiran_surat', $row['lampiran_surat']);
$odf->setVars('perihal_surat', $row['perihal_surat']);*/
$odf->setVars('lokasi_surat', $row['lokasi_surat']);
$odf->setVars('tgl_surat', $row['tgl_surat']);
/*$odf->setVars('kepada', $row['kepada']);
$odf->setVars('kepada_lokasi', $row['kepada_lokasi']);
$odf->setVars('jabatan_ttd', $row['jabatan_ttd']);*/
$odf->setVars('nama_ttd', $row['nama_ttd']);
$odf->setVars('pangkat_ttd', $row['pangkat_ttd']);
$odf->setVars('nip_ttd', $row['nip_ttd']);


// surat isi
$odf->setVars('isi1', $isi1);
$odf->setVars('isi2', $isi2);
$odf->setVars('isi3', $isi3);
if ($isi10=="Jaksa Agung RI")
{
$isi11="";
}
//echo $isi7;
if ($isi7=='Sudah')
{
	$noPertimbangan1 = "1.";
	$isiPertimbangan1 = "Bahwa ada laporan tentang telah terjadinya tindak pidana ".$isi4." pada tanggal ".$isi5." di ".$isi6." yang dilakukan oleh ".$isi8;
	$noPertimbangan2 = "2.";
	$isiPertimbangan2 = "Bahwa ".$isi9." ".$isi10." ".$isi11." Tanggal ".$isi12." Nomor ".$isi13. " perlu dilaksanakan";
	$noPertimbangan3 = "";
	$isiPertimbangan3 = "";
	$untuk = "Melaksanakan penyidikan atas tindak pidana ".$isi4." yang diduga dilakukan oleh ".$isi8;
}
else
{
	$noPertimbangan1 = "1.";
	$isiPertimbangan1 = "Bahwa ada laporan tentang telah terjadinya tindak pidana ".$isi4." pada tanggal ".$isi5." di ".$isi6;
	$noPertimbangan2 = "2.";
	$isiPertimbangan2 = "Bahwa oleh karena itu perlu dilakukan pencarian dan pengumpulan bukti yang dengan bukti itu membuat terang tentang tindak pidana yang terjadi, guna menemukan tersangkanya";
	$noPertimbangan3 = "3.";
	$isiPertimbangan3 = "Bahwa ".$isi9." ".$isi10." ".$isi11." Tanggal ".$isi12." Nomor ".$isi13. " perlu dilaksanakan";;
	$untuk = "Melaksanakan penyidikan atas tindak pidana ".$isi4;
}

$odf->setVars('noT1',$noPertimbangan1);
$odf->setVars('noT2',$noPertimbangan2);
$odf->setVars('noT3',$noPertimbangan3);
$odf->setVars('isipertimbangan1',$isiPertimbangan1);
$odf->setVars('isipertimbangan2',$isiPertimbangan2);
$odf->setVars('isipertimbangan3',$isiPertimbangan3);
$odf->setVars('untuk',$untuk);
// untuk surat isi yang pakai format khusus bisa diubah disini
//$isi1 = $isi1.'tes';
//$odf->setVars('isi1', $isi1);
//echo $i;
//echo $noPertimbangan3;
//print_r($row);
// We export the file
$odf->exportAsAttachedFile('P8.odt');
 
?>