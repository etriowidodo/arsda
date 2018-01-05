<?php 

use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use app\models\Satker;
use app\models\TemplateSuratIsi;
use yii\helpers\Html;

	class reportFunction{
		function openConnection(){
			
			$db = require(__DIR__ . '/../../config/db.php');
			$connection = new \yii\db\Connection([
			'dsn' => $db['dsn'],
			'username' => $db['username'],
			'password' => $db['password'],
			]);
			$connection->open();
			return $connection;
		}
		
		function closeConnection($connection){
			$connection->close();
		}
		
		public function getSuratIsi($odf,$id,$connection){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			$query="Select * from pidsus.rpt_pds_lid_surat_isi('".$id."');";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			foreach($rows as $currentRow) {
				$no =$currentRow['no_urut'];
				$odf->setVars('isi'.$no,$currentRow['isi_surat2']);
				global ${'isi'.$no};
				${'isi'.$no} = $currentRow['isi_surat2'];
				//echo ${'isi'.$i};
				//echo 'tes';

				$i++;
			}							
		}
		public function getSuratIsi2($odf,$id,$connection){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			$query="Select * from pidsus.rpt_pds_lid_surat_isi('".$id."');";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			foreach($rows as $currentRow) {
				//$odf->setVars('isi'.$i,$currentRow['isi_surat2']);
				$no =$currentRow['no_urut'];
				global ${'isi'.$no};
				${'isi'.$no} = $currentRow['isi_surat2'];
				//echo ${'isi'.$i};
				//echo 'tes';

				$i++;
			}
		}

		public function getSuratIsiDik($odf,$id,$connection){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			$query="Select * from pidsus.rpt_pds_dik_surat_isi('".$id."');";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			foreach($rows as $currentRow) {
				$no =$currentRow['no_urut'];
				$odf->setVars('isi'.$no,$currentRow['isi_surat2']);
				global ${'isi'.$no};
				${'isi'.$no} = $currentRow['isi_surat2'];
				global ${'isi_'.$no};
				${'isi_'.$no} = $currentRow['isi_surat'];
				//echo ${'isi'.$i};
				//echo 'tes';

				$i++;
			}
		}
		public function getSuratIsiDik2($odf,$id,$connection){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			$query="Select * from pidsus.rpt_pds_dik_surat_isi('".$id."');";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			foreach($rows as $currentRow) {
				//$odf->setVars('isi'.$i,$currentRow['isi_surat2']);
				$no =$currentRow['no_urut'];
				global ${'isi'.$no};
				${'isi'.$no} = $currentRow['isi_surat2'];
				global ${'isi_'.$no};
				${'isi_'.$no} = $currentRow['isi_surat'];
				//echo ${'isi'.$i};
				//echo 'tes';

				$i++;
			}
		}
		public function getSuratIsiTut($odf,$id,$connection){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			$query="Select * from pidsus.rpt_pds_tut_surat_isi('".$id."');";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			foreach($rows as $currentRow) {
				$no =$currentRow['no_urut'];
				$odf->setVars('isi'.$no,$currentRow['isi_surat2']);
				global ${'isi'.$no};
				${'isi'.$no} = $currentRow['isi_surat2'];
				global ${'isi_'.$no};
				${'isi_'.$no} = $currentRow['isi_surat'];
				//echo ${'isi_'.$i}.",";
				//echo 'tes';

				$i++;
			}
		}
		public function getSuratIsiTut2($odf,$id,$connection){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			$query="Select * from pidsus.rpt_pds_tut_surat_isi('".$id."');";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			foreach($rows as $currentRow) {
				//$odf->setVars('isi'.$i,$currentRow['isi_surat2']);
				$no =$currentRow['no_urut'];
				global ${'isi'.$no};
				${'isi'.$no} = $currentRow['isi_surat2'];
				global ${'isi_'.$no};
				${'isi_'.$no} = $currentRow['isi_surat'];
				//echo ${'isi'.$i};
				//echo 'tes';

				$i++;
			}
		}

		public function getSuratSaksiLid($odf,$id,$connection){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			$query="select nama_saksi,tempat_lahir,pidsus.get_umur(tgl_lahir) umur, pidsus.tanggal_tulisan(tgl_lahir) tgl_lahir,pidsus.get_nama_detail(jenis_kelamin)
					as jenis_kelamin,kewarganegaraan,alamat,pidsus.get_nama_detail(agama) agama,pekerjaan,pidsus.get_nama_detail(pendidikan) pendidikan
					from pidsus.pds_lid_saksi s inner join pidsus.pds_lid_surat_saksi ss
					on s.id_pds_lid_saksi = ss.id_saksi where ss.id_pds_lid_surat = '".$id."'limit 1;";
			$row = $connection->createCommand($query)->queryOne();
			$odf->setVars('nama_saksi', $row['nama_saksi']);
			$odf->setVars('tempat_lahir', $row['tempat_lahir']);
			$odf->setVars('umur', $row['umur']);
			$odf->setVars('tgl_lahir', $row['tgl_lahir']);
			$odf->setVars('jenis_kelamin', $row['jenis_kelamin']);
			$odf->setVars('kewarganegaraan', $row['kewarganegaraan']);
			$odf->setVars('alamat', $row['alamat']);
			$odf->setVars('agama', $row['agama']);
			$odf->setVars('pekerjaan', $row['pekerjaan']);
			$odf->setVars('pendidikan', $row['pendidikan']);
		}
		
		public function getSuratSaksiDik($odf,$id,$connection){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			$query="select nama_saksi,tempat_lahir,pidsus.get_umur(tgl_lahir) umur, pidsus.tanggal_tulisan(tgl_lahir) tgl_lahir,pidsus.get_nama_detail(jenis_kelamin)
					as jenis_kelamin,kewarganegaraan,alamat,pidsus.get_nama_detail(agama) agama,pekerjaan,pidsus.get_nama_detail(pendidikan) pendidikan
					from pidsus.pds_dik_saksi s inner join pidsus.pds_dik_surat_saksi ss
					on s.id_pds_dik_saksi = ss.id_saksi where ss.id_pds_dik_surat = '".$id."'limit 1;";
			$row = $connection->createCommand($query)->queryOne();
			$odf->setVars('nama_saksi', $row['nama_saksi']);
			$odf->setVars('tempat_lahir', $row['tempat_lahir']);
			$odf->setVars('umur', $row['umur']);
			$odf->setVars('tgl_lahir', $row['tgl_lahir']);
			$odf->setVars('jenis_kelamin', $row['jenis_kelamin']);
			$odf->setVars('kewarganegaraan', $row['kewarganegaraan']);
			$odf->setVars('alamat', $row['alamat']);
			$odf->setVars('agama', $row['agama']);
			$odf->setVars('pekerjaan', $row['pekerjaan']);
			$odf->setVars('pendidikan', $row['pendidikan']);
			
		}
		
		public function getSuratPanggilanDik($odf,$id,$connection){
				$query="select nama_lengkap,alamat,keterangan from  pidsus.pds_dik_surat_panggilan where
					id_pds_dik_surat =  '".$id."' order by no_urut asc";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$panggilan = $odf->setSegment('pgln');
			foreach($rows as $currentRow) {
				$panggilan->no($i.".  ");
				$panggilan->nama($currentRow['nama_lengkap']);
				$panggilan->alamat($currentRow['alamat']);
				$panggilan->ket($currentRow['keterangan']);
				$panggilan->merge();
				$i++;	
			}
			$odf->mergeSegment($panggilan);
		}
		
		public function getSuratPenyitaanDik($odf,$id,$connection){
				$query="SELECT id_pds_dik_surat, no_urut, nama_jabatan, 
       tempat_lokasi, dari_dan_tempat, id_jaksa_pelaksana, pidsus.tanggal_jam_tulisan(waktu_pelaksanaan) waktu_pelaksanaan,
       peg_nik, peg_nip_baru, peg_nama, jabatan, pangkat, pangkat_jaksa, 
       golongan, instansi, keperluan, keterangan
	   FROM pidsus.pds_dik_surat_penyitaan where coalesce(flag,'1') <> '3' and id_pds_dik_surat =  '".$id."' order by no_urut asc";
						
					
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$panggilan = $odf->setSegment('Sita');
			foreach($rows as $currentRow) {
				$panggilan->no($currentRow['no_urut']);
				$panggilan->nama_jabatan($currentRow['nama_jabatan']);
				$panggilan->tempat_lokasi($currentRow['tempat_lokasi']);
				$panggilan->dari_dan_tempat($currentRow['dari_dan_tempat']);
				$panggilan->nama($currentRow['peg_nama']);
				$panggilan->pangkat($currentRow['pangkat_jaksa']);
				$panggilan->nip($currentRow['peg_nip_baru']);
				$panggilan->waktu($currentRow['waktu_pelaksanaan']);
				$panggilan->kep($currentRow['keperluan']);
				$panggilan->ket($currentRow['keterangan']);
				$panggilan->merge();
				$i++;	
			}
			$odf->mergeSegment($panggilan);
		}
		
		public function getSuratTargetPemanggilanDik($odf,$id,$connection){
				$query="SELECT  no_urut, nama_jabatan, tempat_lokasi,
        peg_nama, pangkat_jaksa, peg_nip_baru,pidsus.tanggal_jam_tulisan(waktu_pelaksanaan) waktu_pelaksanaan,
        keperluan, keterangan, 
        id_jaksa_pelaksana 
         FROM pidsus.pds_dik_surat_target_pemanggilan
         where coalesce(flag,'1') <> '3' and id_pds_dik_surat =  '".$id."' order by no_urut asc";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$panggilan = $odf->setSegment('Geledah');
			foreach($rows as $currentRow) {
				$panggilan->no($currentRow['no_urut']);
				$panggilan->nama_jabatan($currentRow['nama_jabatan']);
				$panggilan->tempat_lokasi($currentRow['tempat_lokasi']);
				$panggilan->nama($currentRow['peg_nama']);
				$panggilan->pangkat($currentRow['pangkat_jaksa']);
				$panggilan->nip($currentRow['peg_nip_baru']);
				$panggilan->waktu($currentRow['waktu_pelaksanaan']);
				$panggilan->kep($currentRow['keperluan']);
				$panggilan->ket($currentRow['keterangan']);
				$panggilan->merge();
				$i++;	
			}
			$odf->mergeSegment($panggilan);
		}
		
public function getSuratSaksiTut($odf,$id,$connection){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			$query="select nama_saksi,tempat_lahir,pidsus.get_umur(tgl_lahir) umur, pidsus.tanggal_tulisan(tgl_lahir) tgl_lahir,pidsus.get_nama_detail(jenis_kelamin)
					as jenis_kelamin,kewarganegaraan,alamat,pidsus.get_nama_detail(agama) agama,pekerjaan,pidsus.get_nama_detail(pendidikan) pendidikan
					from pidsus.pds_tut_saksi s inner join pidsus.pds_tut_surat_saksi ss
					on s.id_pds_tut_saksi = ss.id_saksi where ss.id_pds_tut_surat = '".$id."'limit 1;";
			$row = $connection->createCommand($query)->queryOne();
			$odf->setVars('nama_saksi', $row['nama_saksi']);
			$odf->setVars('tempat_lahir', $row['tempat_lahir']);
			$odf->setVars('umur', $row['umur']);
			$odf->setVars('tgl_lahir', $row['tgl_lahir']);
			$odf->setVars('jenis_kelamin', $row['jenis_kelamin']);
			$odf->setVars('kewarganegaraan', $row['kewarganegaraan']);
			$odf->setVars('alamat', $row['alamat']);
			$odf->setVars('agama', $row['agama']);
			$odf->setVars('pekerjaan', $row['pekerjaan']);
			$odf->setVars('pendidikan', $row['pendidikan']);
		}
		//tambahini ini
			public function getTersangkaDik($odf,$id,$connection){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			$query="SELECT id_pds_dik_tersangka, id_pds_dik, nama_tersangka, tempat_lahir, 
				   pidsus.tanggal_tulisan(tgl_lahir) tgl_lahir, pidsus.get_umur(tgl_lahir) umur,pidsus.get_nama_detail(jenis_kelamin) jenis_kelamin, kewarganegaraan, alamat,
					pidsus.get_nama_detail(agama) agama, pekerjaan, 
				   pidsus.get_nama_detail(pendidikan) pendidikan, pidsus.get_nama_detail(jenis_id)  jenis_id, 
				   nomor_id, suku, flag
					FROM pidsus.pds_dik_tersangka where id_pds_dik_tersangka ='".$id."' limit 1;";
						
			$row = $connection->createCommand($query)->queryOne();
			$odf->setVars('nama_tersangka', $row['nama_tersangka']);
			$odf->setVars('tempat_lahir', $row['tempat_lahir']);
			$odf->setVars('umur', $row['umur']);
			$odf->setVars('tgl_lahir', $row['tgl_lahir']);
			$odf->setVars('jenis_kelamin', $row['jenis_kelamin']);
			$odf->setVars('kewarganegaraan', $row['kewarganegaraan']);
			$odf->setVars('alamat', $row['alamat']);
			$odf->setVars('agama', $row['agama']);
			$odf->setVars('pekerjaan', $row['pekerjaan']);
			$odf->setVars('pendidikan', $row['pendidikan']);
		}

		public function getTersangkaDikSurat($odf,$id,$connection){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			$query="SELECT t.id_pds_dik_tersangka, t.id_pds_dik, t.nama_tersangka, t.tempat_lahir,
pidsus.tanggal_tulisan(t.tgl_lahir) tgl_lahir, pidsus.get_umur(t.tgl_lahir) umur,pidsus.get_nama_detail(t.jenis_kelamin) jenis_kelamin,
t.kewarganegaraan, t.alamat,pidsus.get_nama_detail(t.agama) agama, t.pekerjaan,pidsus.get_nama_detail(t.pendidikan) pendidikan,
pidsus.get_nama_detail(t.jenis_id)  jenis_id,t.nomor_id, t.suku, t.flag
FROM pidsus.pds_dik_surat_tersangka s inner join pidsus.pds_dik_tersangka t on s.id_tersangka = t.id_pds_dik_tersangka
where s.id_pds_dik_surat ='".$id."' and coalesce(t.flag,'1') <> '3';";

			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$TDS = $odf->setSegment('TDS');
			foreach($rows as $currentRow) {
				$TDS->noUrut($i.".  ");
				$TDS->nama_tersangka($currentRow['nama_tersangka']);
				$TDS->tempat_lahir($currentRow['tempat_lahir']);
				$TDS->umur($currentRow['umur']);
				$TDS->tgl_lahir($currentRow['tgl_lahir']);
				$TDS->jenis_kelamin($currentRow['jenis_kelamin']);
				$TDS->kewarganegaraan($currentRow['kewarganegaraan']);
				$TDS->alamat($currentRow['alamat']);
				$TDS->agama($currentRow['agama']);
				$TDS->pekerjaan($currentRow['pekerjaan']);
				$TDS->pendidikan($currentRow['pendidikan']);
				$TDS->merge();
				$i++;
			}
			$odf->mergeSegment($TDS);
		}

public function getSaksiDikSurat($odf,$id,$connection){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			$query="SELECT t.id_pds_dik_saksi, t.id_pds_dik, t.nama_saksi, t.tempat_lahir,
pidsus.tanggal_tulisan(t.tgl_lahir) tgl_lahir, pidsus.get_umur(t.tgl_lahir) umur,pidsus.get_nama_detail(t.jenis_kelamin) jenis_kelamin,
t.kewarganegaraan, t.alamat,pidsus.get_nama_detail(t.agama) agama, t.pekerjaan,pidsus.get_nama_detail(t.pendidikan) pendidikan,
pidsus.get_nama_detail(t.jenis_id)  jenis_id,t.nomor_id, t.suku, t.flag
FROM pidsus.pds_dik_surat_saksi s inner join pidsus.pds_dik_saksi t on s.id_saksi = t.id_pds_dik_saksi
where s.id_pds_dik_surat ='".$id."' and coalesce(t.flag,'1') <> '3';";

			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$TDS = $odf->setSegment('TDS');
			foreach($rows as $currentRow) {
				$TDS->noUrut($i.".  ");
				$TDS->nama_saksi($currentRow['nama_saksi']);
				$TDS->tempat_lahir($currentRow['tempat_lahir']);
				$TDS->umur($currentRow['umur']);
				$TDS->tgl_lahir($currentRow['tgl_lahir']);
				$TDS->jenis_kelamin($currentRow['jenis_kelamin']);
				$TDS->kewarganegaraan($currentRow['kewarganegaraan']);
				$TDS->alamat($currentRow['alamat']);
				$TDS->agama($currentRow['agama']);
				$TDS->pekerjaan($currentRow['pekerjaan']);
				$TDS->pendidikan($currentRow['pendidikan']);
				$TDS->merge();
				$i++;
			}
			$odf->mergeSegment($TDS);
		}

		public function getTersangkaTut($odf,$id,$connection){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			$query="SELECT id_pds_tut_tersangka, id_pds_tut, nama_tersangka, tempat_lahir, 
				   pidsus.tanggal_tulisan(tgl_lahir) tgl_lahir, pidsus.get_umur(tgl_lahir) umur,pidsus.get_nama_detail(jenis_kelamin) jenis_kelamin, kewarganegaraan, alamat,
					pidsus.get_nama_detail(agama) agama, pekerjaan, 
				   pidsus.get_nama_detail(pendidikan) pendidikan, pidsus.get_nama_detail(jenis_id)  jenis_id, 
				   nomor_id, suku, flag
					FROM pidsus.pds_tut_tersangka where id_pds_tut_tersangka ='".$id."' limit 1;";

			$row = $connection->createCommand($query)->queryOne();
			$odf->setVars('nama_tersangka', $row['nama_tersangka']);
			$odf->setVars('tempat_lahir', $row['tempat_lahir']);
			$odf->setVars('umur', $row['umur']);
			$odf->setVars('tgl_lahir', $row['tgl_lahir']);
			$odf->setVars('jenis_kelamin', $row['jenis_kelamin']);
			$odf->setVars('kewarganegaraan', $row['kewarganegaraan']);
			$odf->setVars('alamat', $row['alamat']);
			$odf->setVars('agama', $row['agama']);
			$odf->setVars('pekerjaan', $row['pekerjaan']);
			$odf->setVars('pendidikan', $row['pendidikan']);
		}
		function getSuratJawaban($odf,$id,$connection){
			$query="select no_urut,pertanyaan,jawaban from  pidsus.pds_lid_surat_keterangan where
					id_pds_lid_surat =  '".$id."' order by no_urut asc";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$jawaban = $odf->setSegment('JWB');
			foreach($rows as $currentRow) {
				$jawaban->no_urut($currentRow['no_urut']);
				$jawaban->pertanyaan($currentRow['pertanyaan']);
				$jawaban->jawaban($currentRow['jawaban']);
				$jawaban->merge();
				$i++;	
			}
			$odf->mergeSegment($jawaban);
		}

function getSuratDetail($odf,$id,$type,$connection){
			$query="Select isi_surat_detail from pidsus.pds_lid_surat_detail where id_pds_lid_surat='$id' and tipe_surat_detail='$type' order by no_urut,sub_no_urut asc";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$detail = $odf->setSegment($type);
			foreach($rows as $currentRow) {
				$detail->nourut($i.".  ");
				$detail->isidetail($currentRow['isi_surat_detail']);
				$detail->merge();
				$i++;
			}
			$odf->mergeSegment($detail);
		}
		
		function getSuratDetailDik($odf,$id,$type,$connection){
			$query="Select isi_surat_detail from pidsus.pds_dik_surat_detail where id_pds_dik_surat='$id' and tipe_surat_detail='$type' order by no_urut,sub_no_urut asc";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$detail = $odf->setSegment($type);
			foreach($rows as $currentRow) {
				$detail->nourut($i.".  ");
				$detail->isidetail($currentRow['isi_surat_detail']);
				$detail->merge();
				$i++;
			}
			$odf->mergeSegment($detail);
		}
		
		function getSuratDetailTut($odf,$id,$type,$connection){
			$query="Select isi_surat_detail from pidsus.pds_tut_surat_detail where id_pds_tut_surat='$id' and tipe_surat_detail='$type' order by no_urut,sub_no_urut asc";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$detail = $odf->setSegment($type);
			foreach($rows as $currentRow) {
				$detail->nourut($i.".  ");
				$detail->isidetail($currentRow['isi_surat_detail']);
				$detail->merge();
				$i++;
			}
			$odf->mergeSegment($detail);
		}
		
		
		function getSuratDetailTutnoNomor($odf,$id,$type,$connection){
			$query="Select isi_surat_detail from pidsus.pds_tut_surat_detail where id_pds_tut_surat='$id' and tipe_surat_detail='$type' order by no_urut,sub_no_urut asc";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$detail = $odf->setSegment($type);
			foreach($rows as $currentRow) {
				//$detail->nourut($i.".  ");
				$detail->isidetail($currentRow['isi_surat_detail']);
				$detail->merge();
				$i++;
			}
			$odf->mergeSegment($detail);
		}
		function getSuratDetailDiknoNomor($odf,$id,$type,$connection,$segment=null){
			$query="Select isi_surat_detail from pidsus.pds_dik_surat_detail where id_pds_dik_surat='$id' and tipe_surat_detail='$type' order by no_urut,sub_no_urut asc";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			if ($segment == null)
			{$segment=$type;
			}
			$detail = $odf->setSegment($segment);
			foreach($rows as $currentRow) {
				//$detail->nourut($i.".  ");
				$detail->isidetail($currentRow['isi_surat_detail']);
				$detail->merge();
				$i++;
			}
			$odf->mergeSegment($detail);
		}
		function getSuratDetailDikHurupFromJenisSurat($odf,$id,$type,$connection,$jenis_surat){
			$query="Select  pidsus.no_to_hurup(cast((row_number() over (ORDER BY no_urut,sub_no_urut)) as smallint)) as nomor,isi_surat_detail from pidsus.pds_dik_surat_detail
 					where id_pds_dik_surat= (select pidsus.get_string_pds_dik_surat('$id','$jenis_surat','id_pds_dik_surat'))
 					and tipe_surat_detail='$type' order by no_urut asc";
			//echo $query;
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$detail = $odf->setSegment($type);

			foreach($rows as $currentRow) {

				 	$detail->nourut($currentRow['nomor'].". ");
			//	 echo 	$currentRow['nomor'];


				$detail->isidetail($currentRow['isi_surat_detail']);
				$detail->merge();
				$i++;
			}
			$odf->mergeSegment($detail);
		}
		function getSuratDetailDikHurup($odf,$id,$type,$connection,$segment = null){
			$query="Select  pidsus.no_to_hurup(cast((row_number() over (ORDER BY no_urut,sub_no_urut)) as smallint)) as nomor,isi_surat_detail from pidsus.pds_dik_surat_detail where id_pds_dik_surat='$id' and tipe_surat_detail='$type' order by no_urut asc";
			//echo $query;
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			if ($segment == null)
			{$segment=$type;
			}
			//echo $segment;
		$detail = $odf->setSegment($segment);

			foreach($rows as $currentRow) {

				$detail->nourut($currentRow['nomor'].". ");
				//echo 	$currentRow['nomor'];


				$detail->isidetail($currentRow['isi_surat_detail']);
				$detail->merge();
				$i++;
			}
			$odf->mergeSegment($detail);
		}
		
		function getSuratDetailUraian($odf,$id,$type,$connection,$segment = null){
			$query="Select  pidsus.no_to_hurup(cast((row_number() over (ORDER BY no_urut,sub_no_urut)) as smallint)) as nomor,isi_surat_detail from pidsus.pds_dik_surat_detail where id_pds_dik_surat='$id' and tipe_surat_detail='$type' order by no_urut asc";
			//echo $query;
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			if ($segment == null)
			{$segment=$type;
			}
			//echo $segment;
		$detail = $odf->setSegment($segment);

			foreach($rows as $currentRow) {

				//$detail->nourut($currentRow['nomor'].". ");
				//echo 	$currentRow['nomor'];


				$detail->isidetail($currentRow['isi_surat_detail']);
				$detail->merge();
				$i++;
			}
			$odf->mergeSegment($detail);
		}
		
		function getSuratJaksa($odf,$id,$connection){
		$query=" select distinct  peg_nip_baru nip,peg_nama nama,jabatan ,COALESCE(pangkat_jaksa,pangkat) pangkat from pidsus.pds_lid_surat_jaksa
			     where id_pds_lid_surat='$id' and coalesce(flag,'1')<>'3'";

		$rows = $connection->createCommand($query)->queryAll();
		$i=1;
		$jaksa = $odf->setSegment('Jaksa');
		foreach($rows as $currentRow) {
			$jaksa->noUrut($i.".  ");
			$jaksa->namaJaksa($currentRow['nama']);
			$jaksa->nipJaksa($currentRow['nip']);
			$jaksa->pangkatJaksa($currentRow['pangkat']);
			$jaksa->jabatanJaksa($currentRow['jabatan']);
			$jaksa->merge();
			$i++;
		}
		$odf->mergeSegment($jaksa);
	}


		function getTtdSuratJaksa($odf,$id,$connection){
		$query=" select distinct  kp.peg_nip_baru nip,kp.peg_nama nama,j.ref_jabatan_desc jabatan,g.gol_pangkatjaksa pangkat from pidsus.pds_lid_surat_jaksa plsj left join kepegawaian.kp_pegawai kp on plsj.id_jaksa=kp.peg_nik
  				     LEFT JOIN kepegawaian.kp_r_jabatan j ON kp.peg_jbtakhirstk = j.ref_jabatan_kd
   					 LEFT JOIN kepegawaian.kp_r_golpangkat g ON kp.peg_golakhir::text = g.gol_kd::text where plsj.id_pds_lid_surat='$id'";

		$rows = $connection->createCommand($query)->queryAll();
		$i=1;
		$jaksa = $odf->setSegment('ttdJaksa');
		foreach($rows as $currentRow) {
			//$jaksa->noUrut($i.".  ");
			$jaksa->namaJaksa($currentRow['nama']);
			$jaksa->nipJaksa($currentRow['nip']);
			$jaksa->pangkatJaksa($currentRow['pangkat']);
			//$jaksa->jabatanJaksa($currentRow['jabatan']);
			$jaksa->merge();
			$i++;
		}
		$odf->mergeSegment($jaksa);
	}
		function getSuratJaksaDik($odf,$id,$connection,$segment=null){
			$query=" select distinct  peg_nip_baru nip,peg_nama nama,jabatan ,COALESCE(pangkat_jaksa,pangkat) pangkat from pidsus.pds_dik_surat_jaksa
			     where id_pds_dik_surat='$id' and coalesce(flag,'1') <>'3'";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			if ($segment == null)
			{$segment="Jaksa";
			}

			$jaksa = $odf->setSegment($segment);
			foreach($rows as $currentRow) {
				$jaksa->noUrut($i.".  ");
				$jaksa->namaJaksa($currentRow['nama']);
				$jaksa->nipJaksa($currentRow['nip']);
				$jaksa->pangkatJaksa($currentRow['pangkat']);
				$jaksa->jabatanJaksa($currentRow['jabatan']);
				$jaksa->merge();
				$i++;
			}
			$odf->mergeSegment($jaksa);
		}
		
		
function getTtdSuratJaksaTut($odf,$id,$connection){
	$query=" select distinct  peg_nip_baru nip,peg_nama nama,jabatan ,COALESCE(pangkat_jaksa,pangkat) pangkat from pidsus.pds_tut_surat_jaksa
			     where id_pds_tut_surat='$id' and coalesce(flag,'1') <>'3'";

		$rows = $connection->createCommand($query)->queryAll();
		$i=1;
		$jaksa = $odf->setSegment('ttdJaksa');
		foreach($rows as $currentRow) {
			//$jaksa->noUrut($i.".  ");
			$jaksa->namaJaksa($currentRow['nama']);
			$jaksa->nipJaksa($currentRow['nip']);
			$jaksa->pangkatJaksa($currentRow['pangkat']);
			//$jaksa->jabatanJaksa($currentRow['jabatan']);
			$jaksa->merge();
			$i++;
		}
		$odf->mergeSegment($jaksa);
	}

		function getSuratJaksaSaksiDikJabatan($odf,$id,$connection,$segment=null){

			$query= "select  * from pidsus.get_data_jaksa_saksi_dik('".$id."')";
			$rows = $connection->createCommand($query)->queryAll();
			if ($segment == null)
			{$segment="sks";
			}

			$i=1;
			$jaksaSaksi = $odf->setSegment($segment);
			foreach($rows as $currentRow) {
				$jaksaSaksi->nourut($i.".  ");
				$jaksaSaksi->namasks($currentRow['nama']);
				$jaksaSaksi->nipsks($currentRow['nip']);
				$jaksaSaksi->pangkatsks($currentRow['pangkat']);
				$jaksaSaksi->jabatansks($currentRow['jabatan']);
				$jaksaSaksi->merge();
				$i++;
			}
			$odf->mergeSegment($jaksaSaksi);
		}
		function getSuratJaksaDikNoJabatan($odf,$id,$connection){
			$query=" select distinct  kp.peg_nip_baru nip,kp.peg_nama nama,j.ref_jabatan_desc jabatan,g.gol_pangkatjaksa pangkat from pidsus.pds_dik_surat_jaksa plsj left join kepegawaian.kp_pegawai kp on plsj.id_jaksa=kp.peg_nik
  				     LEFT JOIN kepegawaian.kp_r_jabatan j ON kp.peg_jbtakhirstk = j.ref_jabatan_kd
   					 LEFT JOIN kepegawaian.kp_r_golpangkat g ON kp.peg_golakhir::text = g.gol_kd::text where plsj.id_pds_dik_surat='$id'";

			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$jaksa = $odf->setSegment('Jaksa');
			foreach($rows as $currentRow) {
				$jaksa->noUrut($i.".  ");
				$jaksa->namaJaksa($currentRow['nama']);
				$jaksa->nipJaksa($currentRow['nip']);
				$jaksa->pangkatJaksa($currentRow['pangkat']);
			//	$jaksa->jabatanJaksa($currentRow['jabatan']);
				$jaksa->merge();
				$i++;
			}
			$odf->mergeSegment($jaksa);
		}

		function getSuratJaksaSaksiDikNoJabatan($odf,$id,$connection,$segment=null){

			$query= "select  * from pidsus.get_data_jaksa_saksi_dik('".$id."')";
			$rows = $connection->createCommand($query)->queryAll();
			if ($segment == null)
			{$segment="sks";
			}
		 
			$i=1;
			$jaksaSaksi2 = $odf->setSegment($segment);
			foreach($rows as $currentRow) {
				$jaksaSaksi2->nourut($i.".  ");
				$jaksaSaksi2->namasks($currentRow['nama']);
				$jaksaSaksi2->nipsks($currentRow['nip']);
				$jaksaSaksi2->pangkatsks($currentRow['pangkat']);
				$jaksaSaksi2->merge();
				$i++;
			}
			$odf->mergeSegment($jaksaSaksi2);
		}

		function getSuratJaksaSaksiTutNoJabatan($odf,$id,$connection,$segment=null){

			$query= "select  * from pidsus.get_data_jaksa_saksi_tut('".$id."')";
			$rows = $connection->createCommand($query)->queryAll();
			if ($segment == null)
			{$segment="sks";
			}

			$i=1;
			$jaksaSaksi2 = $odf->setSegment($segment);
			foreach($rows as $currentRow) {
				$jaksaSaksi2->nourut($i.".  ");
				$jaksaSaksi2->namasks($currentRow['nama']);
				$jaksaSaksi2->nipsks($currentRow['nip']);
				$jaksaSaksi2->pangkatsks($currentRow['pangkat']);
				$jaksaSaksi2->merge();
				$i++;
			}
			$odf->mergeSegment($jaksaSaksi2);
		}


		function getSuratDetailDikTest($odf,$id,$type,$connection){
			//$query="Select isi_surat_detail from pidsus.pds_dik_surat_detail where id_pds_dik_surat='$id' and tipe_surat_detail='$type' order by no_urut,sub_no_urut asc";
			$query= "select  * from pidsus.get_data_jaksa_saksi_dik('".$id."')";
			$rows = $connection->createCommand($query)->queryAll();
			$type = "sks";
			$i=1;
			$jaksaSaksi = $odf->setSegment($type);
			foreach($rows as $currentRow) {
				$jaksaSaksi->nourut($i.".  ");
				$jaksaSaksi->nama($currentRow['nama']);
				$jaksaSaksi->nip($currentRow['nip']);
				$jaksaSaksi->pangkat($currentRow['pangkat']);
				$jaksaSaksi->merge();
				$i++;
			}
			$odf->mergeSegment($jaksaSaksi);
		}
		function getSuratDetailDikTest2($odf,$id,$type,$connection){
			//$query="Select isi_surat_detail from pidsus.pds_dik_surat_detail where id_pds_dik_surat='$id' and tipe_surat_detail='$type' order by no_urut,sub_no_urut asc";
			$query= "select  * from pidsus.get_data_jaksa_saksi_dik('".$id."')";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$detail = $odf->setSegment($type);
			foreach($rows as $currentRow) {
				$detail->nourut($i.".  ");
				$detail->nama($currentRow['nama']);
				$detail->merge();
				$i++;
			}
			$odf->mergeSegment($detail);
		}
		function getSuratJaksaSaksiDik($odf,$id,$connection,$segment=null){
			$query= "select  * from pidsus.get_data_jaksa_saksi_dik('".$id."')";
			$rows = $connection->createCommand($query)->queryAll();
			if ($segment == null)
			{$segment="Sksi";
			}

			$i=1;
			$jaksaSaksi = $odf->setSegment($segment);
			foreach($rows as $currentRow) {
				$jaksaSaksi->nourut($i.".  ");
				$jaksaSaksi->namasks($currentRow['nama']);
				$jaksaSaksi->nipsks($currentRow['nip']);
				$jaksaSaksi->pangkatsks($currentRow['pangkat']);
				$jaksaSaksi->jabatansks($currentRow['jabatan']);
				$jaksaSaksi->merge();
				$i++;
			}
			$odf->mergeSegment($jaksaSaksi);
		}
		function getSuratJaksaSaksiTut($odf,$id,$connection,$segment=null){
			$query= "select  * from pidsus.get_data_jaksa_saksi_tut('".$id."')";
			$rows = $connection->createCommand($query)->queryAll();
			if ($segment == null)
			{$segment="Sksi";
			}

			$i=1;
			$jaksaSaksi = $odf->setSegment($segment);
			foreach($rows as $currentRow) {
				$jaksaSaksi->nourut($i.".  ");
				$jaksaSaksi->namasks($currentRow['nama']);
				$jaksaSaksi->nipsks($currentRow['nip']);
				$jaksaSaksi->pangkatsks($currentRow['pangkat']);
				$jaksaSaksi->jabatansks($currentRow['jabatan']);
				$jaksaSaksi->merge();
				$i++;
			}
			$odf->mergeSegment($jaksaSaksi);
		}

function getSuratJaksaTut($odf,$id,$connection){
			$query=" select distinct  kp.peg_nip_baru nip,kp.peg_nama nama,j.ref_jabatan_desc jabatan,g.gol_pangkatjaksa pangkat from pidsus.pds_tut_surat_jaksa plsj left join kepegawaian.kp_pegawai kp on plsj.id_jaksa=kp.peg_nik
  				     LEFT JOIN kepegawaian.kp_r_jabatan j ON kp.peg_jbtakhirstk = j.ref_jabatan_kd
   					 LEFT JOIN kepegawaian.kp_r_golpangkat g ON kp.peg_golakhir::text = g.gol_kd::text where plsj.id_pds_tut_surat='$id'";

			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$jaksa = $odf->setSegment('Jaksa');
			foreach($rows as $currentRow) {
				$jaksa->noUrut($i.".  ");
				$jaksa->namaJaksa($currentRow['nama']);
				$jaksa->nipJaksa($currentRow['nip']);
				$jaksa->pangkatJaksa($currentRow['pangkat']);
				$jaksa->jabatanJaksa($currentRow['jabatan']);
				$jaksa->merge();
				$i++;
			}
			$odf->mergeSegment($jaksa);
		}
		
		function getSuratJaksaTutNoJabatan($odf,$id,$connection){
			$query=" select distinct  kp.peg_nip_baru nip,kp.peg_nama nama,j.ref_jabatan_desc jabatan,g.gol_pangkatjaksa pangkat from pidsus.pds_tut_surat_jaksa plsj left join kepegawaian.kp_pegawai kp on plsj.id_jaksa=kp.peg_nik
  				     LEFT JOIN kepegawaian.kp_r_jabatan j ON kp.peg_jbtakhirstk = j.ref_jabatan_kd
   					 LEFT JOIN kepegawaian.kp_r_golpangkat g ON kp.peg_golakhir::text = g.gol_kd::text where plsj.id_pds_tut_surat='$id'";

			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$jaksa = $odf->setSegment('jks');
			foreach($rows as $currentRow) {
				$jaksa->noUrut($i.".  ");
				$jaksa->namaJaksa($currentRow['nama']);
				$jaksa->nipJaksa($currentRow['nip']);
				$jaksa->pangkatJaksa($currentRow['pangkat']);
				$jaksa->merge();
				$i++;
			}
			$odf->mergeSegment($jaksa);
		}
		
		function getRenLid($odf,$id,$connection){
			$query=" SELECT id_pds_lid_renlid, id_pds_lid_surat, no_urut, laporan, kasus_posisi,
    		  		 dugaan_pasal, alat_bukti, sumber, pelaksana, tindakan_hukum,
      				 waktu_tempat, koor_dan_dal, keterangan, create_by, create_date,
      				 update_by, update_date
  					FROM pidsus.pds_lid_renlid  where id_pds_lid_surat='$id'and coalesce(flag,'1') <> '3' order by no_urut asc";

			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$renlid = $odf->setSegment('Renlid');
			foreach($rows as $currentRow) {
				$renlid->noUrut($i.".  ");
			$renlid->laporan($currentRow['laporan']);
					$renlid->kasusPosisi($currentRow['kasus_posisi']);
                    $renlid->pasal($currentRow['dugaan_pasal']);
                    $renlid->alatBukti($currentRow['alat_bukti']);
                    $renlid->sumber($currentRow['sumber']);
                    $renlid->pelaksana($currentRow['pelaksana']);
                    $renlid->tindakanHukum($currentRow['tindakan_hukum']);
                    $renlid->waktuTempat($currentRow['waktu_tempat']);
                    $renlid->koorDal($currentRow['koor_dan_dal']);
                    $renlid->keterangan($currentRow['keterangan']);
				$renlid->merge();
				$i++;
			}
			$odf->mergeSegment($renlid);
		}

		function getRenDik($odf,$id,$connection){
			$query=" SELECT id_pds_dik_rendik, id_pds_dik_surat, no_urut, kasus_posisi, pasal_disangkakan,
     			  	alat_bukti, tindakan_hukum, waktu_tempat, koor_dan_dal, keterangan,
       				create_by, create_date, update_by, update_date
  					FROM pidsus.pds_dik_rendik  where id_pds_dik_surat='$id' and  coalesce(flag,'1') <> '3' order by no_urut asc";

			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$rendik = $odf->setSegment('Rendik');
			foreach($rows as $currentRow) {
				$rendik->noUrut($i.".  ");
				$rendik->kasusPosisi($currentRow['kasus_posisi']);
				$rendik->pasal($currentRow['pasal_disangkakan']);
				$rendik->alatBukti($currentRow['alat_bukti']);
				$rendik->tindakanHukum($currentRow['tindakan_hukum']);
				$rendik->waktuTempat($currentRow['waktu_tempat']);
				$rendik->koorDal($currentRow['koor_dan_dal']);
				$rendik->keterangan($currentRow['keterangan']);
				$rendik->merge();
				$i++;
			}
			$odf->mergeSegment($rendik);
		}

		function getPermintaanDataLid($odf,$id,$connection){
			$query=" SELECT id_pds_lid_permintaan_data, id_pds_lid_surat, jenis_permintaan_data,
       nama_tindakan_lain, nama_instansi, jaksa_pelaksaan, tempat_pelaksanaan,
       tgl_pelaksanaan, jam_pelaksanaan, keperluan, create_by, create_date,
       update_by, update_date, jabatan
  FROM pidsus.pds_lid_permintaan_data where id_pds_lid_surat='$id' order by id_pds_lid_permintaan_data asc";

			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$PermintaaDataLid = $odf->setSegment('dalid');
			foreach($rows as $currentRow) {
				$PermintaaDataLid->noUrut($i.".  ");
				$PermintaaDataLid->nama($currentRow['nama_tindakan_lain']);
				$PermintaaDataLid->jabatan($currentRow['jabatan']);
				$PermintaaDataLid->instansi($currentRow['instansi']);
				$PermintaaDataLid->tindakanHukum($currentRow['tindakan_hukum']);
				$PermintaaDataLid->waktuTempat($currentRow['jaksa_pelaksaan']);
				$PermintaaDataLid->koorDal($currentRow['koor_dan_dal']);
				$PermintaaDataLid->keterangan($currentRow['keterangan']);
				$PermintaaDataLid->merge();
				$i++;
			}
			$odf->mergeSegment($PermintaaDataLid);
		}

		function getUsulanPermintaan($odf,$id,$connection){
			$query=" SELECT u.id_pds_lid_usulan_permintaan_data, u.id_pds_lid_surat, u.nama, pidsus.tanggal_jam_tulisan(u.waktu_pelaksanaan) waktu_pelaksanaan,
      			 	u.jaksa_pelaksanaan, u.keperluan,  u.jabatan, u.nama_instansi,p.peg_nama peg_nama
  					FROM pidsus.pds_lid_usulan_permintaan_data u inner join kepegawaian.kp_pegawai p
  					on u.jaksa_pelaksanaan = p.peg_nik
  					where id_pds_lid_surat ='$id' and  coalesce(flag,'1') <> '3' order by id_pds_lid_usulan_permintaan_data asc";

			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$UsulanData = $odf->setSegment('usda');
			foreach($rows as $currentRow) {
				$UsulanData->noUrut($i.".  ");
				$UsulanData->nama($currentRow['nama']);
				$UsulanData->jabatan($currentRow['jabatan']);
				$UsulanData->instansi($currentRow['nama_instansi']);
				$UsulanData->waktuPelaksanaan($currentRow['waktu_pelaksanaan']);
				$UsulanData->jaksaPelaksanaan($currentRow['jaksa_pelaksanaan']);
				$UsulanData->peg_nama($currentRow['peg_nama']);
				$UsulanData->keperluan($currentRow['keperluan']);

				$UsulanData->merge();
				$i++;
			}
			$odf->mergeSegment($UsulanData);
		}
		
		function getBantuanPemanggilan($odf,$id,$connection){
			$query=" select * from pidsus.pds_lid_permintaan_data where id_pds_lid_surat = '$id' order by id_pds_lid_permintaan_data asc";

			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$UsulanData = $odf->setSegment('bantuan');
			foreach($rows as $currentRow) {
				$UsulanData->noUrut($i.".  ");
				$UsulanData->nama($currentRow['nama_tindakan_lain']);

				$UsulanData->merge();
				$i++;
			}
			$odf->mergeSegment($UsulanData);
		}




		function getSuratTembusan($odf,$id,$connection){
			$query="Select tembusan, row_number() OVER () as no_urut from pidsus.pds_lid_tembusan where id_pds_lid_surat='$id'  and tembusan <>'Arsip.'
					union select cast('Arsip.' as varchar),999999 as no_urut	order by no_urut asc";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$tembusan = $odf->setSegment('tembusan');
			foreach($rows as $currentRow) {

				$tembusan->isiTembusan($i.".	".$currentRow['tembusan']);
				$tembusan->merge();
				$i++;
			}
			$odf->mergeSegment($tembusan);
		}
		function getSuratTembusanDik($odf,$id,$connection){
			$query="Select tembusan, row_number() OVER () as no_urut from pidsus.pds_dik_tembusan where id_pds_dik_surat='$id'  and tembusan <>'Arsip.'
					union select cast('Arsip.' as varchar),999999 as no_urut	order by no_urut asc";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$tembusan = $odf->setSegment('tembusan');
			foreach($rows as $currentRow) {
				$tembusan->isiTembusan($i.".	".$currentRow['tembusan']);
				$tembusan->merge();
				$i++;
			}
			$odf->mergeSegment($tembusan);
		}
		
		function getSuratTembusanTut($odf,$id,$connection){
			$query="Select tembusan, row_number() OVER () as no_urut from pidsus.pds_tut_tembusan where id_pds_tut_surat='$id'  and tembusan <>'Arsip.'
					union select cast('Arsip.' as varchar),999999 as no_urut	order by no_urut asc";
			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$tembusan = $odf->setSegment('tembusan');
			foreach($rows as $currentRow) {
				$tembusan->isiTembusan($i.".	".$currentRow['tembusan']);
				$tembusan->merge();
				$i++;
			}
			$odf->mergeSegment($tembusan);
		}


		function getUsulanPemanggilanDik($odf,$id,$connection){
			$query="SELECT distinct id_pds_dik_usulan_permintaan_data, id_pds_dik_surat, nama,jabatan_nama jabatan, waktu_pelaksanaan,p.peg_nama,
      			 jaksa_pelaksanaan peg_nik, pidsus.get_nama_detail(cast(keperluan as smallint)) keperluan, create_by, create_date, update_by, update_date
       			FROM pidsus.pds_dik_usulan_permintaan_data d --inner join kepegawaian.kp_h_jabatan j on d.jaksa_pelaksanaan = j.peg_nik
       			inner join kepegawaian.kp_pegawai p on p.peg_nik = d.jaksa_pelaksanaan
  				where id_pds_dik_surat ='".$id."'
  				--and j.jabat_stsakhir = '1'
  				order by create_date asc";
;

			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$usulanPemanggilanDik = $odf->setSegment('UPD');
			foreach($rows as $currentRow) {
				$usulanPemanggilanDik->noUrut($i.".  ");
				$usulanPemanggilanDik->nama($currentRow['nama']);
				$usulanPemanggilanDik->jabatan($currentRow['jabatan']);
				$usulanPemanggilanDik->waktu($currentRow['waktu_pelaksanaan']);
				$usulanPemanggilanDik->peg_nama($currentRow['peg_nama']);
				$usulanPemanggilanDik->peg_nik($currentRow['peg_nik']);
				$usulanPemanggilanDik->keperluan($currentRow['keperluan']);
				$usulanPemanggilanDik->merge();
				$i++;
			}
			$odf->mergeSegment($usulanPemanggilanDik);
		}


		//mendapatkan data surat
		public function getDataSurat($odf,$id,$connection,$type){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			//echo $type;
			if ($type=='lid') {
				$query = "SELECT no_surat,pidsus.tanggal_tulisan(tgl_surat) tgl_surat
					FROM pidsus.pds_lid_surat where id_pds_lid_surat ='" . $id . "' limit 1;";

				$row = $connection->createCommand($query)->queryOne();
				$odf->setVars('no_srt', $row['no_surat']);
				$odf->setVars('tgl_srt', $row['tgl_surat']);
			//	echo 'tes1';
			}
			elseif($type == 'dik')
			{
				$query = "SELECT no_surat,pidsus.tanggal_tulisan(tgl_surat) tgl_surat
					FROM pidsus.pds_dik_surat where id_pds_dik_surat ='" . $id . "' limit 1;";

				$row = $connection->createCommand($query)->queryOne();
				$odf->setVars('no_srt', $row['no_surat']);
				$odf->setVars('tgl_srt', $row['tgl_surat']);
				//echo 'tes2';
			}
			elseif($type == 'tut')
			{
				$query = "SELECT no_surat,pidsus.tanggal_tulisan(tgl_surat) tgl_surat
					FROM pidsus.pds_tut_surat where id_pds_tut_surat ='" . $id . "' limit 1;";

				$row = $connection->createCommand($query)->queryOne();
				$odf->setVars('no_srt', $row['no_surat']);
				$odf->setVars('tgl_srt', $row['tgl_surat']);
			//	echo 'tes3';
			}
			//$connection->close();

		}
		function getParameterValue($id,$connection){
			$query="Select nama_detail from pidsus.parameter_detail where id_detail='".$id."'";
			$rows = $connection->createCommand($query)->queryOne();
			return $row['nama_detail'];	
		}
		
		function getIdDate($tgl){
			$tgl=date('d F Y',strtotime($tgl));
			$engM=array("January","February","March","April","May","June","July","August","September","October","November","December");
			$idM=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
			$tgl=str_ireplace($engM,$idM,$tgl);
			return $tgl;
		}
		
		function getIdTextDate($tgl){
			$tglD=date('d',strtotime($tgl));
			$tglM=date('F',strtotime($tgl));
			$tglY=date('Y',strtotime($tgl));
			$engM=array("January","February","March","April","May","June","July","August","September","October","November","December");
			$idM=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
			$tglM=str_ireplace($engM,$idM,$tglM);
			return "tanggal ".$this->convert_number_to_words($tglD)." bulan ".$tglM." tahun ".$this->convert_number_to_words($tglY);
		}

		function getNamaHari($tgl){
		$tgl=date('d F Y',strtotime($tgl));
			//echo 'tes'.date("D", $tgl);

			$hari = date('D', strtotime($tgl));
		//	echo 'hari -='.$hari;
			switch($hari){
				case 'Sun' : {
					$hari='Minggu';
				}break;
				case 'Mon' : {
					$hari='Senin';
				}break;
				case 'Tue' : {
					$hari='Selasa';
				}break;
				case 'Wed' : {
					$hari='Rabu';
				}break;
				case 'Thu' : {
					$hari='Kamis';
				}break;
				case 'Fri' : {
					$hari="Jum'at";
				}break;
				case 'Sat' : {
					$hari='Sabtu';
				}break;
				default: {
					$hari='Minggu';
				}break;
			}
		//	echo 'hari'.$hari;
			return $hari;
		}

		function getUmur($tgl){
			$from = new DateTime($tgl);
			$to   = new DateTime('today');
			return $from->diff($to)->y;
		}

	public function no_to_hurup($no){
			$nomor = string($no);
			switch($nomor){
				case '1' : {
					$nomor='a';
				}break;
				case '2' : {
					$nomor='b';
				}break;
				case '3' : {
					$nomor='c';
				}break;
				case '4' : {
					$nomor='d';
				}break;
				case '5' : {
					$nomor='e';
				}break;
				case '6' : {
					$nomor="f";
				}break;
				case '7' : {
					$nomor='g';
				}break;
				case '8' : {
					$nomor='h';
				}break;
				case '9' : {
					$nomor='i';
				}break;
				case '10' : {
					$nomor='j';
				}break;
				case '11' : {
					$nomor='k';
				}break;
				case '12' : {
					$nomor='l';
				}break;
				case '13' : {
					$nomor="m";
				}break;
				case '14' : {
					$nomor='n';
				}break;
				case '15' : {
					$nomor='o';
				}break;
				case '16' : {
					$nomor='p';
				}break;
				case '17' : {
					$nomor='q';
				}break;
				case '18' : {
					$nomor='r';
				}break;
				case '19' : {
					$nomor='s';
				}break;
				case '20' : {
					$nomor="t";
				}break;
				case '21' : {
					$nomor='u';
				}break;
				case '22' : {
					$nomor='v';
				}break;
				case '23' : {
					$nomor='w';
				}break;
				case '24' : {
					$nomor='x';
				}break;
				case '25' : {
					$nomor="y";
				}break;
				case '26' : {
					$nomor='z';
				}break;
				default: {
					$nomor='z';
				}break;
			}
			//	echo 'hari'.$hari;
			return $nomor;
		}


		function convert_number_to_words($number) {
			 
			$hyphen      = '-';
			$conjunction = ' ';
			$separator   = ' ';
			$negative    = 'negative ';
			$decimal     = ' point ';
			$dictionary  = array(
					0                   => 'nol',
					1                   => 'satu',
					2                   => 'dua',
					3                   => 'tiga',
					4                   => 'empat',
					5                   => 'lima',
					6                   => 'enam',
					7                   => 'tujuh',
					8                   => 'delapan',
					9                   => 'sembilan',
					10                  => 'sepuluh',
					11                  => 'sebelas',
					12                  => 'dua belas',
					13                  => 'tiga belas',
					14                  => 'empat belas',
					15                  => 'lima belas',
					16                  => 'enam belas',
					17                  => 'tujuh belas',
					18                  => 'delapan belas',
					19                  => 'sembilan belas',
					20                  => 'dua puluh',
					30                  => 'tiga puluh',
					40                  => 'empat puluh',
					50                  => 'lima puluh',
					60                  => 'enam puluh',
					70                  => 'tujuh puluh',
					80                  => 'delapan puluh',
					90                  => 'sembilan puluh',
					100                 => 'ratus',
					1000                => 'ribu'
			);
			 
			if (!is_numeric($number)) {
				return false;
			}
			 
			if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
				// overflow
				trigger_error(
						'$this->convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
						E_USER_WARNING
				);
				return false;
			}
		
			if ($number < 0) {
				return $negative . $this->convert_number_to_words(abs($number));
			}
			 
			$string = $fraction = null;
			 
			if (strpos($number, '.') !== false) {
				list($number, $fraction) = explode('.', $number);
			}
			 
			switch (true) {
				case $number < 21:
					$string = $dictionary[$number];
					break;
				case $number < 100:
					$tens   = ((int) ($number / 10)) * 10;
					$units  = $number % 10;
					$string = $dictionary[$tens];
					if ($units) {
						$string .= $hyphen . $dictionary[$units];
					}
					break;
				case $number < 1000:
					$hundreds  = $number / 100;
					$remainder = $number % 100;
					$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
					if ($remainder) {
						$string .= $conjunction . $this->convert_number_to_words($remainder);
					}
					break;
				default:
					$baseUnit = pow(1000, floor(log($number, 1000)));
					$numBaseUnits = (int) ($number / $baseUnit);
					$remainder = $number % $baseUnit;
					$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
					if ($remainder) {
						$string .= $remainder < 100 ? $conjunction : $separator;
						$string .= $this->convert_number_to_words($remainder);
					}
					break;
			}
			 
			if (null !== $fraction && is_numeric($fraction)) {
				$string .= $decimal;
				$words = array();
				foreach (str_split((string) $fraction) as $number) {
					$words[] = $dictionary[$number];
				}
				$string .= implode(' ', $words);
			}
			 
			return $string;
		}

		public function getTersangkaDikAll($odf,$id,$connection){
			//$query="Select * from pidsus.pds_lid_surat_isi where id_pds_lid_surat='$id' order by no_urut";
			$query="SELECT  nama_tersangka, tempat_lahir, pidsus.get_umur(tgl_lahir) umur,tgl_lahir,
        	jk.nama_detail jenis_kelamin, kewarganegaraan, alamat, ag.nama_detail agama, pekerjaan,pd.nama_detail pendidikan
			FROM pidsus.pds_dik_tersangka left join pidsus.parameter_detail jk on jenis_kelamin = jk.id_detail
			left join pidsus.parameter_detail ag on agama = ag.id_detail
			left join pidsus.parameter_detail pd on pendidikan = pd.id_detail
			where id_pds_dik = '".$id."';";

			$rows = $connection->createCommand($query)->queryAll();
			$i=1;
			$TersangkaDik = $odf->setSegment('T');
			foreach($rows as $currentRow) {
				$TersangkaDik->n($i.".  ");
				$TersangkaDik->nama($currentRow['nama']);
				$TersangkaDik->waktu($currentRow['tempat_lahir']);
				$TersangkaDik->peg_nama($currentRow['umur']);
				$TersangkaDik->peg_nama($currentRow['tgl_lahir']);
				$TersangkaDik->peg_nama($currentRow['jenis_kelamin']);
				$TersangkaDik->peg_nik($currentRow['alamat']);
				$TersangkaDik->peg_nik($currentRow['kewarganegaraan']);
				$TersangkaDik->keperluan($currentRow['agama']);
				$TersangkaDik->keperluan($currentRow['pekerjaan']);
				$TersangkaDik->peg_nik($currentRow['pendidikan']);
				$TersangkaDik->merge();
				$i++;
			}
			$odf->mergeSegment($TersangkaDik);
		}
		}

?>
