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
//require_once('../tes/library/odf.php') ;
require(__DIR__ . '/../../vendor/cybermonde/odtphp/library/Odf.php');
require(__DIR__ . '/../../vendor/QRCodeSurat/QRSurat.php');
require('reportFunction.php');
$reportFunction=new reportFunction();
$connection=$reportFunction->openConnection();
/*$query="select distinct A.*,pidsus.tanggal_tulisan(A.tgl_diterima) as tgl_diterima_tulisan,pidsus.tanggal_tulisan(A.tgl_lap) as tgl_lap_tulisan,kepegawaian.nama_hari(A.tgl_diterima) as hari
 ,B.peg_nama nama_penandatangan, pidsus.get_jabatan_peg2(b.peg_nik) jabatan_penandatangan,g1.gol_pangkat pangkat_penandatangan,
C.peg_nama nama_penerima, pidsus.get_jabatan_peg(c.peg_nik) jabatan_penerima, g2.gol_pangkat pangkat_penerima, c.peg_nip_baru nip_penerima,b.peg_nip_baru nip_penandatangan,
D.inst_nama nama_satker
 from pidsus.pds_lid A
left join kepegawaian.kp_pegawai B on B.peg_nik = A.penandatangan_lap
left join kepegawaian.kp_pegawai C on C.peg_nik = A.penerima_lap
left join kepegawaian.kp_inst_satker D on D.inst_satkerkd = A.id_satker
 LEFT JOIN kepegawaian.kp_r_golpangkat g1 on b.peg_golakhir = g1.gol_kd
 left join kepegawaian.kp_r_golpangkat g2 on c.peg_golakhir = g2.gol_kd
where id_pds_lid =  '".$_GET['id']."'";//query to get form's basic setup*/
$query="select distinct A.*,i.inst_nama nama_satker,pidsus.tanggal_tulisan(A.tgl_diterima) as tgl_diterima_tulisan,pidsus.tanggal_tulisan(A.tgl_lap) as tgl_lap_tulisan,kepegawaian.nama_hari(A.tgl_diterima) as hari
 ,penandatangan_peg_nama nama_penandatangan,
 coalesce(penandatangan_pangkat_jaksa,penandatangan_pangkat) pangkat_penandatangan,
 coalesce(penandatangan_jabatan,'JABATAN KOSONG') penandatangan_jabatan,
penerima_peg_nama nama_penerima, penerima_jabatan jabatan_penerima, coalesce(penerima_pangkat_jaksa,penerima_pangkat) pangkat_penerima, penerima_peg_nip_baru nip_penerima,penandatangan_peg_nip_baru nip_penandatangan,
penandatangan_instansi
 from pidsus.pds_lid A left join kepegawaian.kp_inst_satker i on i.inst_satkerkd = A.id_satker

where id_pds_lid =  '".$_GET['id']."'";
$row = $connection->createCommand($query)->queryOne();
$odf = new odf("pidsus1report.odt");
//CMS_PIDSUS001_2#bowo tanggal 11 mei 2016
$sts_lap=$row['status_lap'];
switch ($sts_lap)
{
case '1':
	$odf->setVars('flag','');
	$odf->setVars('penandatangan_jabatan','');
	break;
case '2':
	$odf->setVars('flag','An. ');
	$odf->setVars('penandatangan_jabatan',$row['penandatangan_jabatan']);
	break;
case '3':
	$odf->setVars('flag','PLH. ');
	$odf->setVars('penandatangan_jabatan','');
	break;
case '4':
	$odf->setVars('flag','PLT. ');
	$odf->setVars('penandatangan_jabatan','');
	break;	
} //=== end bowo tanggal 11 mei 2016


$odf->setVars('nama_satker', $row['nama_satker']);
$odf->setVars('no_surat_lap', $row['no_surat_lap']);
$odf->setVars('tgl_lap',$row['tgl_lap_tulisan']);
$odf->setVars('perihal_lap',$row['perihal_lap']);
$odf->setVars('isi_surat_lap',$row['isi_surat_lap']);
$odf->setVars('tgl_diterima',$row['tgl_diterima_tulisan']);
$odf->setVars('nama_penerima',$row['nama_penerima']);
//$odf->setVars('pangkat_penerima',$row['pangkat_penerima']);
$odf->setVars('nip_penerima',$row['nip_penerima']);
$odf->setVars('jabatan_penerima',$row['jabatan_penerima']);
$odf->setVars('nama_penandatangan',$row['nama_penandatangan']);
$odf->setVars('nip_penandatangan',$row['nip_penandatangan']);
$odf->setVars('pangkat_penandatangan',$row['pangkat_penandatangan']);
$odf->setVars('pelapor',$row['pelapor']);
$odf->setVars('asal_surat_lap',$row['asal_surat_lap']);
$odf->setVars('uraian_surat_lap',$row['uraian_surat_lap']);
//MSM Change Code CMS_PIDSUS001_06
// ~~~~~ QR Code by Danar 11 mei 2016 ~~~~~~
$qrtemplate = $PNG_TEMP_DIR.'QR_'.md5($row['no_surat_lap']).'.png';	
QRcode::png(($row['id_satker'].'.PDS.PIDSUS-1.'.$row['no_surat_lap']), $qrtemplate, $errorCorrectionLevel, $matrixPointSize, 2);
$odf->setImage('QRCODE',$locationTempQR.md5($row['no_surat_lap']).'.png');
// ~~~~~ end barcode ~~~~~~~~~~~
$reportFunction->closeConnection($connection);
// We export the file
$odf->exportAsAttachedFile("Pidsus 1.odt");

//MSM Change Code CMS_PIDSUS001_06
// ~~~~~ QR Code by Danar 11 mei 2016 ~~~~~~
if(file_exists($locationTempQR.md5($row['no_surat_lap']).'.png'))
unlink($locationTempQR.md5($row['no_surat_lap']).'.png');
//End
?>