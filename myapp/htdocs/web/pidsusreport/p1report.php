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
$query="select distinct A.*,pidsus.tanggal_terbilang(A.tgl_diterima) as tgl_diterima_tulisan,kepegawaian.nama_hari(A.tgl_diterima) as hari
 ,B.peg_nama nama_penandatangan, pidsus.get_jabatan_peg(b.peg_nik) jabatan_penandatangan,g1.gol_pangkat pangkat_penandatangan,
C.peg_nama nama_penerima, pidsus.get_jabatan_peg(c.peg_nik) jabatan_penerima, g2.gol_pangkat pangkat_penerima, c.peg_nip_baru nip_penerima,b.peg_nip_baru nip_penandatangan,
D.inst_nama nama_satker,a.flag_dirahasiakan
 from pidsus.pds_lid A
left join kepegawaian.kp_pegawai B on B.peg_nik = A.penandatangan_lap
left join kepegawaian.kp_pegawai C on C.peg_nik = A.penerima_lap
left join kepegawaian.kp_inst_satker D on D.inst_satkerkd = A.id_satker
 LEFT JOIN kepegawaian.kp_r_golpangkat g1 on b.peg_golakhir = g1.gol_kd
 left join kepegawaian.kp_r_golpangkat g2 on c.peg_golakhir = g2.gol_kd
where id_pds_lid =  '".$_GET['id']."'";//query to get form's basic setup
$row = $connection->createCommand($query)->queryOne();
$odf = new odf("p1report.odt");

$odf->setVars('nama_satker', $row['nama_satker']);
$odf->setVars('no_lap', $row['no_lap']);
$odf->setVars('hari', $row['hari']);
$odf->setVars('tgl_diterima',$row['tgl_diterima_tulisan']);
$odf->setVars('lokasi_lap',$row['lokasi_lap']);
$odf->setVars('nama_penerima',$row['nama_penerima']);
$odf->setVars('pangkat_penerima',$row['pangkat_penerima']);
$odf->setVars('nip_penerima',$row['nip_penerima']);
$odf->setVars('jabatan_penerima',$row['jabatan_penerima']);
$odf->setVars('isi_surat_lap',$row['isi_surat_lap']);
$odf->setVars('asal_surat_lap',$row['asal_surat_lap']);
$odf->setVars('pelapor',$row['pelapor']);
if ($row['flag_dirahasiakan']=true) {
 $odf->setVars('pelapor','identitas dirahasiakan');
}

$reportFunction->closeConnection($connection);
// We export the file
$odf->exportAsAttachedFile("P1.odt");
 
?>