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

$odf = new odf("b4report.odt");


$reportFunction=new reportFunction();
$connection=$reportFunction->openConnection();
//$reportFunction->getSuratIsi($odf,$_GET['id'],$connection);
$reportFunction->getSuratIsiDik($odf,$_GET['id'],$connection);
$reportFunction->getSuratTembusanDik($odf,$_GET['id'],$connection);
$reportFunction->getSuratJaksaDikNoJabatan($odf,$_GET['id'],$connection);
$reportFunction->getSuratDetailDikHurup($odf,$_GET['id'],'Penggeledahan',$connection );
$reportFunction->getSuratDetailDikHurup($odf,$_GET['id'],'Penyitaan',$connection );
$reportFunction->closeConnection($connection);

/*$query="Select l.*,
		 ttd.peg_nip, ttd.peg_nama, ttd.peg_golakhir, s.inst_nama, kpd.peg_nama penerima
		 from pidsus.pds_lid_surat l 
		 left join kepegawaian.kp_pegawai ttd on l.id_ttd=ttd.peg_nik
		 left join kepegawaian.kp_pegawai kpd on l.kepada=ttd.peg_nik
		 left join public.user u on u.username=l.update_by
		 left join kepegawaian.kp_pegawai c on u.peg_nik=c.peg_nik
		 left join kepegawaian.kp_inst_satker s on c.peg_instakhir=s.inst_satkerkd
		 where id_pds_lid_surat='".$_GET['id']."'";//query to get form's basic setup
*/
$query="Select * from pidsus.rpt_pds_dik_surat('".$_GET['id']."');";//query to get form's basic setup
//echo $query;
$row = $connection->createCommand($query)->queryOne();

$odf->setVars('nama_satker', $row['nama_satker']);
$odf->setVars('no_surat', $row['no_surat']);
//$odf->setVars('sifat_surat',$row['sifat_surat']);
//$odf->setVars('lampiran_surat', $row['lampiran_surat']);
//$odf->setVars('perihal_surat', $row['perihal_surat']);
$odf->setVars('lokasi_surat', $row['lokasi_surat']);
$odf->setVars('tgl_surat', $row['tgl_surat']);
//$odf->setVars('kepada', $row['kepada']);
//$odf->setVars('kepada_lokasi', $row['kepada_lokasi']);
$odf->setVars('jabatan_ttd', $row['jabatan_ttd']);
$odf->setVars('nama_ttd', $row['nama_ttd']);
$odf->setVars('pangkat_ttd', $row['pangkat_ttd']);
$odf->setVars('nip_ttd', $row['nip_ttd']);
$odf->setVars('isi7', '');

// get nama tersangka
$query="select nama_tersangka from pidsus.pds_dik_tersangka where id_pds_dik_tersangka =('".$isi7."');";//query to get form's basic setup
//echo $query;
$row2 = $connection->createCommand($query)->queryOne();
$odf->setVars('nama', $row2['nama_tersangka']);

$connection->close();

// untuk surat isi yang pakai format khusus bisa diubah disini
//$isi1 = $isi1.'tes';
//$odf->setVars('isi1', $isi1);
//echo $i;
//echo $isi1;
//print_r($row);
// We export the file
$jenisKapital = strtoupper($isi1);
$odf->setVars('ISI1', $jenisKapital);
$odf->exportAsAttachedFile('B4.odt');
 
?>