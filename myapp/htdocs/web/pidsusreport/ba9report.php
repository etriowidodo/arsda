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

$odf = new odf("ba9report.odt");


$reportFunction=new reportFunction();
$connection=$reportFunction->openConnection();
$reportFunction->getSuratIsiTut($odf,$_GET['id'],$connection);
$reportFunction->getTersangkaTut($odf,$isi5,$connection);
$reportFunction->getSuratJaksaSaksiTut($odf,$_GET['id'],$connection);
$reportFunction->getSuratJaksaSaksiTutNoJabatan($odf,$_GET['id'],$connection,'t');
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
$query="Select * from pidsus.rpt_pds_tut_surat('".$_GET['id']."');";//query to get form's basic setup
//echo $query;
$row = $connection->createCommand($query)->queryOne();

$odf->setVars('nama_satker', $row['nama_satker']);
$odf->setVars('nama_hari', $row['nama_hari']);
$odf->setVars('tgl_surat_terbilang', $row['tgl_surat_terbilang']);
$odf->setVars('jam_surat', $row['jam_surat']);
$odf->setVars('isi1','');
$odf->setVars('isi5','');

// get info jaksa penyidik
$query="select * from pidsus.get_data_jaksa('".$isi1."');";//query to get form's basic setup
//echo $query;
$row = $connection->createCommand($query)->queryOne();
$odf->setVars('nama', $row['nama']);
$odf->setVars('nip', $row['nip']);
$odf->setVars('pangkat',$row['pangkat']);
$odf->setVars('jabatan',$row['jabatan']);
$connection->close();
// end

// untuk surat isi yang pakai format khusus bisa diubah disini
//$isi1 = $isi1.'tes';
//$odf->setVars('isi1', $isi1);
//echo $i;
//echo $isi1;
//print_r($row);
// We export the file
$odf->exportAsAttachedFile('BA 9.odt');
 
?>