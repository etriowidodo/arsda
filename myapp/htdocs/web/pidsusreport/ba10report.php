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

$odf = new odf("ba10report.odt");


$reportFunction=new reportFunction();
$connection=$reportFunction->openConnection();
$reportFunction->getSuratIsiDik($odf,$_GET['id'],$connection);
$reportFunction->getTersangkaDik($odf,$isi3,$connection);
$reportFunction->getDataSurat($odf,$isi4,$connection,'dik');
/*$reportFunction->getSuratJaksa($odf,$_GET['id'],$connection);
$reportFunction->getTtdSuratJaksa($odf,$_GET['id'],$connection);
$reportFunction->getSuratJawaban($odf,$_GET['id'],$connection);*/
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
$odf->setVars('nama_hari', $row['nama_hari']);
$odf->setVars('tgl_surat_terbilang', $row['tgl_surat_terbilang']);
$odf->setVars('isi2', '');
$odf->setVars('isi3', '');
$odf->setVars('isi4', '');

// get info jaksa penyidik
$query="select * from pidsus.get_data_jaksa('".$isi2."');";//query to get form's basic setup
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
$jenisKapital = strtoupper($isi1);
$odf->setVars('ISI1', $jenisKapital);
//$umur = $reportFunction->getUmur($isi_6);
//$odf->setVars('umur', $umur);
$odf->exportAsAttachedFile('BA 10.odt');
 
?>