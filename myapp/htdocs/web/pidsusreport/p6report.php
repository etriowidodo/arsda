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
require(__DIR__ . '/../../vendor/QRCodeSurat/QRSurat.php');
require('reportFunction.php');

$odf = new odf("p6report.odt");


/*$reportFunction=new reportFunction();
$connection=$reportFunction->openConnection();
$reportFunction->getSuratIsi($odf,$_GET['id'],$connection);
$reportFunction->getSuratTembusan($odf,$_GET['id'],$connection);
$reportFunction->closeConnection($connection);*/

$reportFunction=new reportFunction();
$connection=$reportFunction->openConnection();
$query="select distinct A.*,pidsus.tanggal_terbilang(A.tgl_diterima) as tgl_diterima_tulisan,kepegawaian.nama_hari(A.tgl_diterima) as hari
 ,B.peg_nama nama_penandatangan, pidsus.get_jabatan_peg(b.peg_nik) jabatan_penandatangan,g1.gol_pangkat pangkat_penandatangan,
C.peg_nama nama_penerima, pidsus.get_jabatan_peg(c.peg_nik) jabatan_penerima, g2.gol_pangkat pangkat_penerima, c.peg_nip_baru nip_penerima,b.peg_nip_baru nip_penandatangan,
D.inst_nama nama_satker 
 from pidsus.pds_dik A
left join kepegawaian.kp_pegawai B on B.peg_nik = A.penandatangan_lap
left join kepegawaian.kp_pegawai C on C.peg_nik = A.penerima_lap
left join kepegawaian.kp_inst_satker D on D.inst_satkerkd = A.id_satker
 LEFT JOIN kepegawaian.kp_r_golpangkat g1 on b.peg_golakhir = g1.gol_kd
 left join kepegawaian.kp_r_golpangkat g2 on c.peg_golakhir = g2.gol_kd
where id_pds_dik =  '".$_GET['id']."'";//query to get form's basic setup
$row = $connection->createCommand($query)->queryOne();
//$reportFunction->closeConnection($connection);


//$query="Select * from pidsus.rpt_pds_dik_surat('".$_GET['id']."');";//query to get form's basic setup
//echo $query;
//$row = $connection->createCommand($query)->queryOne();

$odf->setVars('nama_satker', $row['nama_satker']);
$odf->setVars('no_spdp', $row['no_spdp']);
$odf->setVars('asal_spdp',$row['asal_spdp']);
$odf->setVars('kasus_posisi', $row['kasus_posisi']);
$odf->setVars('perihal_spdp', $row['perihal_spdp']);
$odf->setVars('dugaan_pelaku', $row['dugaan_pelaku']);
$odf->setVars('tgl_diterima_tulisan', $row['tgl_diterima_tulisan']);
$odf->setVars('hari', $row['hari']);
$odf->setVars('penerima_peg_nama', $row['penerima_peg_nama']);
$odf->setVars('penerima_pangkat', $row['penerima_pangkat']);
$odf->setVars('penerima_peg_nip_baru', $row['penerima_peg_nip_baru']);
$odf->setVars('penerima_jabatan', $row['penerima_jabatan']);
$odf->setVars('atasan_peg_nama', $row['atasan_peg_nama']);

//MSM Change Code CMS_PIDSUS001_06
// ~~~~~ QR Code by Danar 11 mei 2016 ~~~~~~
$qrtemplate = $PNG_TEMP_DIR.'QR_'.md5($row['no_spdp']).'.png';	
QRcode::png(($row['id_satker'].'.PDS.P-6.'.$row['no_spdp']), $qrtemplate, $errorCorrectionLevel, $matrixPointSize, 2);
$odf->setImage('QRCODE',$locationTempQR.md5($row['no_spdp']).'.png');
// ~~~~~ end barcode ~~~~~~~~~~~

// get info jaksa penyidik
//$query="select * from pidsus.get_data_jaksa('".penerima_spdp."');";//query to get form's basic setup
/*echo $query;
$row = $connection->createCommand($query)->queryOne();
$odf->setVars('nama', $row['nama']);
$odf->setVars('nip', $row['nip']);
$odf->setVars('pangkat',$row['pangkat']);
$odf->setVars('jabatan',$row['jabatan']);
$connection->close();
 end*/

// untuk surat isi yang pakai format khusus bisa diubah disini
//$isi1 = $isi1.'tes';
//$odf->setVars('isi1', $isi1);
//echo $i;
//echo $isi1;
//print_r($row);
// We export the file
$AwalKapital = ucwords(strtolower($row['nama_satker']));
$odf->setVars('nama_satker2', $AwalKapital);
$AwalKapital2 = ucwords(strtolower($row['penerima_jabatan']));
$odf->setVars('penerima_jabatan', $AwalKapital2);
$odf->exportAsAttachedFile('P6.odt');
  //MSM Change Code CMS_PIDSUS001_06
// ~~~~~ QR Code by Danar 11 mei 2016 ~~~~~~
if(file_exists($locationTempQR.md5($row['no_spdp']).'.png'))
unlink($locationTempQR.md5($row['no_spdp']).'.png');
//End
?>