<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsCeklistTahap1 extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_ceklist_tahap1';
    }

	public function searchPer(){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];
		$no_berkas	= $_SESSION['no_berkas'];

		$sql = "
			with tbl_tsk_berkas as (
				select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, string_agg(no_urut||'. '||nama, '<br />' order by no_urut) as nama_tersangka
				from(
					select distinct id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_urut, nama 
					from pidsus.pds_terima_berkas_tersangka 
				) a
				group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas 
			)
			select distinct a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.tgl_berkas, c.nama_tersangka 
			from pidsus.pds_terima_berkas a 
			join pidsus.pds_terima_berkas_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas
			join tbl_tsk_berkas c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
				and b.no_spdp = c.no_spdp and b.tgl_spdp = c.tgl_spdp and b.no_berkas = c.no_berkas
			where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_spdp = '".$no_spdp."' 
				and a.tgl_spdp = '".$tgl_spdp."' and a.no_berkas='".$no_berkas."'";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_berkas desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
	public function getPengantar($post){
		$connection = $this->db;
		$index		= htmlspecialchars(rawurldecode($post['id1']), ENT_QUOTES);
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];
		
		$sql = "
			with tbl_tsk_pengantar as (
				select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_pengantar, string_agg(no_urut||'. '||nama, '<br />' order by no_urut) as nama_tersangka
				from pidsus.pds_terima_berkas_tersangka 
				group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_pengantar
			)
			select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.tgl_berkas, b.no_pengantar,
			to_char(b.tgl_pengantar, 'DD-MM-YYYY') as tgl_pengantar, to_char(b.tgl_terima, 'DD-MM-YYYY') as tgl_terima, c.nama_tersangka, d.no_pengantar as id_p24, 
			case when (e.pendapat_jaksa is null or e.pendapat_jaksa = '') THEN '-' else 'Jaksa Sudah Memberikan Pendapat' end as keterangan, 
			coalesce(to_char(e.tgl_selesai, 'DD-MM-YYYY'), '-') as tgl_selesai, coalesce(e.no_pengantar, '') as id_ceklist
			from pidsus.pds_terima_berkas a 
			join pidsus.pds_terima_berkas_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas
			join tbl_tsk_pengantar c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
				and b.no_spdp = c.no_spdp and b.tgl_spdp = c.tgl_spdp and b.no_berkas = c.no_berkas and b.no_pengantar = c.no_pengantar
			left join pidsus.pds_p24 d on b.id_kejati = d.id_kejati and b.id_kejari = d.id_kejari and b.id_cabjari = d.id_cabjari 
				and b.no_spdp = d.no_spdp and b.tgl_spdp = d.tgl_spdp and b.no_berkas = d.no_berkas and b.no_pengantar = d.no_pengantar
			left join pidsus.pds_ceklist_tahap1 e on b.id_kejati = e.id_kejati and b.id_kejari = e.id_kejari and b.id_cabjari = e.id_cabjari 
				and b.no_spdp = e.no_spdp and b.tgl_spdp = e.tgl_spdp and b.no_berkas = e.no_berkas and b.no_pengantar = e.no_pengantar
			where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_spdp = '".$no_spdp."' 
				and a.tgl_spdp = '".$tgl_spdp."' and a.no_berkas = '".$index."'";
		$hasil = $connection->createCommand($sql)->queryAll();
		return $hasil;
	}

	public function simpanData($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_berkas		= htmlspecialchars($post['no_berkas'], ENT_QUOTES);
		$no_pengantar	= htmlspecialchars($post['no_pengantar'], ENT_QUOTES);
		$nip_ttd		= htmlspecialchars($post['nip_ttd'], ENT_QUOTES);
		$nama_ttd		= htmlspecialchars($post['nama_ttd'], ENT_QUOTES);
		$gol_ttd		= htmlspecialchars($post['gol_ttd'], ENT_QUOTES);
		$pangkat_ttd	= htmlspecialchars($post['pangkat_ttd'], ENT_QUOTES);
		$jabatan_ttd	= htmlspecialchars($post['jabatan_ttd'], ENT_QUOTES);
		$tgl_mulai		= htmlspecialchars($post['tgl_mulai'], ENT_QUOTES);
		$tgl_selesai 	= htmlspecialchars($post['tgl_selesai'], ENT_QUOTES);
		$pendapat_jaksa	= htmlspecialchars($post['pendapat_jaksa'], ENT_QUOTES);
		$pendapat_jaksa_tdk_lngkp		= htmlspecialchars($post['pendapat_jaksa_tdk_lngkp'], ENT_QUOTES);
		$pendapat_jaksa_tdk_lngkp_temp	= (count($post['pendapat_jaksa_tdk_lngkp_alsn']) > 0)?$post['pendapat_jaksa_tdk_lngkp_alsn']:array();
		$pendapat_jaksa_tdk_lngkp_alsn	= implode(",", $pendapat_jaksa_tdk_lngkp_temp);

		$created_user		= $_SESSION['username'];
		$created_nip		= $_SESSION['nik_user'];
		$created_nama		= $_SESSION['nama_pegawai'];
		$created_ip			= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai'];
		$updated_ip			= $_SERVER['REMOTE_ADDR'];

		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['ceklist'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_spdp);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_spdp);
		$clean3 	= Yii::$app->inspektur->sanitize_filename($no_berkas);
		$clean4 	= Yii::$app->inspektur->sanitize_filename($no_pengantar);
		$newPhoto 	= "ceklist_tahap1_".$clean1."-".$clean2."-".$clean3."-".$clean4.$extPhoto;

		$whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$no_spdp."' and tgl_spdp = '".$tgl_spdp."'";
		$transaction = $connection->beginTransaction();
		try{
			$tgl_mulai 		= ($tgl_mulai)?"'".$helpernya->tgl_db($tgl_mulai)."'":"NULL";
			$tgl_selesai 	= ($tgl_selesai)?"'".$helpernya->tgl_db($tgl_selesai)."'":"NULL";

			if($isNew){
				if($filePhoto != ""){
					$upl1 = true;
					$newPhoto = $newPhoto;
				} else{
					$upl1 = false;
					$newPhoto = "";
				}
				$sql1 = "insert into pidsus.pds_ceklist_tahap1(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_pengantar, nip_ttd, nama_ttd, gol_ttd, 
						 pangkat_ttd, jabatan_ttd, tgl_mulai, tgl_selesai, pendapat_jaksa, pendapat_jaksa_tdk_lngkp, pendapat_jaksa_tdk_lngkp_alsn, file_upload_ceklist) values
						 ('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$no_berkas."', '".$no_pengantar."', '".$nip_ttd."', 
						 '".$nama_ttd."', '".$gol_ttd."', '".$pangkat_ttd."', '".$jabatan_ttd."', ".$tgl_mulai.", ".$tgl_selesai.", 
						 '".$pendapat_jaksa."', '".$pendapat_jaksa_tdk_lngkp."', '".$pendapat_jaksa_tdk_lngkp_alsn."', '".$newPhoto."')";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload_ceklist = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_ceklist_tahap1 set nip_ttd = '".$nip_ttd."', nama_ttd = '".$nama_ttd."', gol_ttd = '".$gol_ttd."', pangkat_ttd = '".$pangkat_ttd."', 
						 jabatan_ttd = '".$jabatan_ttd."', tgl_mulai = ".$tgl_mulai.", tgl_selesai = ".$tgl_selesai.", 
						 pendapat_jaksa = '".$pendapat_jaksa."', pendapat_jaksa_tdk_lngkp = '".$pendapat_jaksa_tdk_lngkp."', 
						 pendapat_jaksa_tdk_lngkp_alsn = '".$pendapat_jaksa_tdk_lngkp_alsn."'".$filenya." 
						 where ".$whereDef." and no_berkas = '".$no_berkas."' and no_pengantar = '".$no_pengantar."'";
			}
			$connection->createCommand($sql1)->execute();

			if($upl1){
				$tmpPot = glob($pathfile."ceklist_tahap1_".$clean1."-".$clean2."-".$clean3."-".$clean4.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto;
				$mantab  = move_uploaded_file($tempPhoto, $tujuan);
				if(file_exists($tempPhoto)) unlink($tempPhoto);
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }

}
