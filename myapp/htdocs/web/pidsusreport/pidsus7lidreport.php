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

$odf = new odf("pidsus7lidreport.odt");


$reportFunction=new reportFunction();
$connection=$reportFunction->openConnection();
$reportFunction->getSuratIsi($odf,$_GET['id'],$connection);
$reportFunction->getSuratDetail($odf,$_GET['id'],'Saran',$connection);
//$reportFunction->getSuratTembusanDik($odf,$_GET['id'],$connection);
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
//$query="Select * from pidsus.rpt_pds_lid_surat('".$_GET['id']."');";//query to get form's basic setup

//CMS_PIDSUS001_2#bowo
$query="select  i.inst_nama nama_satker ,initcap(i.inst_nama)::varchar nama_satker2,i.inst_lokinst lokasi_satker,initcap(i.inst_lokinst)::varchar  lokasi_satker2, s.no_surat , pd.nama_detail,
s.lampiran_surat,s.perihal_lap perihal_surat ,  initcap(s.lokasi_surat)::varchar  ,pidsus.tanggal_tulisan(s.tgl_surat) tgl_surat, pidsus.tanggal_terbilang(s.tgl_surat) tgl_surat_terbilang,s.kepada , initcap(s.kepada_lokasi)::varchar 
,replace(s.jabatan,s.jabatan,'JABATAN KOSONG') jabatan_ttd
,peg_nama nama_ttd, coalesce(pangkat_jaksa,pangkat) pangkat_ttd,peg_nip_baru nip_ttd,to_char(s.jam_surat, 'HH24:MI')::varchar,s.dari,l.flag_dirahasiakan
,initcap(replace(replace(s.jabatan2, 'KEPALA KEJAKSAAN NEGERI B KEJAKSAAN NEGERI', 'Kepala Kejaksaan Negeri'),'KEPALA KEJAKSAAN NEGERI A','Kepala Kejaksaan Negeri')::varchar)::varchar  jabatan_ttd2
,s.peg_nama2,pidsus.get_pangkat_jaksa(s.peg_nik2),s.peg_nip_baru2,replace(replace (replace(i.inst_nama,'CABANG KEJAKSAAN NEGERI ',''),'KEJAKSAAN TINGGI ',''),'KEJAKSAAN NEGERI ','')::varchar 
,initcap(replace(replace (replace(i.inst_nama,'CABANG KEJAKSAAN NEGERI ',''),'KEJAKSAAN TINGGI ',''),'KEJAKSAAN NEGERI ','')::varchar)::varchar ,s.status_lap	
from pidsus.pds_lid_surat s 
inner join pidsus.pds_lid l on s.id_pds_lid = l.id_pds_lid
left join kepegawaian.kp_inst_satker i on i.inst_satkerkd = l.id_satker
left join pidsus.parameter_detail pd on s.sifat_surat = pd.id_detail where s.id_pds_lid_surat = '".$_GET['id']."'";

//echo $query;
$row = $connection->createCommand($query)->queryOne();

//CMS_PIDSUS001_2#bowo tanggal 13 mei 2016
$sts_lap=$row['status_lap'];
switch ($sts_lap)
{
case '1':
	$odf->setVars('flag','');
	$odf->setVars('jabatan_ttd','');
	break;
case '2':
	$odf->setVars('flag','An. ');
	$odf->setVars('jabatan_ttd',$row['jabatan_ttd']);
	break;
case '3':
	$odf->setVars('flag','PLH. ');
	$odf->setVars('jabatan_ttd','');
	break;
case '4':
	$odf->setVars('flag','PLT. ');
	$odf->setVars('jabatan_ttd','');
	break;	
} //=== end bowo tanggal 13 mei 2016

$odf->setVars('nama_satker', $row['nama_satker']);
//$odf->setVars('no_surat', $row['no_surat']);
//$odf->setVars('sifat_surat',$row['sifat_surat']);
$odf->setVars('lampiran_surat', $row['lampiran_surat']);
$odf->setVars('perihal_surat', $row['perihal_surat']);
//$odf->setVars('lokasi_surat', $row['lokasi_surat']);
$odf->setVars('tgl_surat', $row['tgl_surat']);
$odf->setVars('kepada', $row['kepada']);
//$odf->setVars('dari', $row['dari']);
//$odf->setVars('kepada_lokasi', $row['kepada_lokasi']);
//$odf->setVars('jabatan_ttd', $row['jabatan_ttd']);
$odf->setVars('nama_ttd', $row['nama_ttd']);
$odf->setVars('pangkat_ttd', $row['pangkat_ttd']);
$odf->setVars('nip_ttd', $row['nip_ttd']);

//MSM Change Code CMS_PIDSUS001_06
// ~~~~~ QR Code by Danar 11 mei 2016 ~~~~~~
$qrtemplate = $PNG_TEMP_DIR.'QR_'.md5($row['no_surat']).'.png';	
QRcode::png(($row['id_satker'].'.PDS.Pidsus-7.'.$row['no_surat']), $qrtemplate, $errorCorrectionLevel, $matrixPointSize, 2);
$odf->setImage('QRCODE',$locationTempQR.md5($row['no_surat']).'.png');
// ~~~~~ end barcode ~~~~~~~~~~~

// untuk surat isi yang pakai format khusus bisa diubah disini
//$isi1 = $isi1.'tes';
//$odf->setVars('isi1', $isi1);
//echo $i;
//echo $isi1;
//print_r($row);
// We export the file
$odf->exportAsAttachedFile('Pidsus 7 - Tahap Penyelidikan.odt');
 
 //MSM Change Code CMS_PIDSUS001_06
// ~~~~~ QR Code by Danar 11 mei 2016 ~~~~~~
if(file_exists($locationTempQR.md5($row['no_surat']).'.png'))
unlink($locationTempQR.md5($row['no_surat']).'.png');
//End
?>