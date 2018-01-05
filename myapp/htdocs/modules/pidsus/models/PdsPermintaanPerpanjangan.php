<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsPermintaanPerpanjangan extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_minta_perpanjang';
    }

	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];
		$sql = "
		select b.nama as nama_instansi_pelaksana, c.*, d.no_t4, d.tgl_dikeluarkan as tgl_t4, d.tgl_mulai_penahanan as tgl_mulai_t4, d.tgl_selesai_penahanan as tgl_selesai_t4, 
		d.jenis_penahanan as jns_thn_t4, d.lokasi_penahanan as lokasi_thn_t4, e.no_t5, e.tgl_dikeluarkan as tgl_t5 
		from pidsus.pds_spdp a 
		join pidsus.ms_inst_pelak_penyidikan b on a.id_asalsurat = b.kode_ip and a.id_penyidik = b.kode_ipp 
		join pidsus.pds_minta_perpanjang c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari 
			and a.no_spdp = c.no_spdp and a.tgl_spdp = c.tgl_spdp 
		left join pidsus.pds_t4 d on d.id_kejati = c.id_kejati and d.id_kejari = c.id_kejari and d.id_cabjari = c.id_cabjari 
			and d.no_spdp = c.no_spdp and d.tgl_spdp = c.tgl_spdp and d.no_minta_perpanjang = c.no_minta_perpanjang 
		left join pidsus.pds_t5 e on e.id_kejati = c.id_kejati and e.id_kejari = c.id_kejari and e.id_cabjari = c.id_cabjari 
			and e.no_spdp = c.no_spdp and e.tgl_spdp = c.tgl_spdp and e.no_minta_perpanjang = c.no_minta_perpanjang 
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_spdp = '".$no_spdp."' 
			and a.tgl_spdp = '".$tgl_spdp."'";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by c.tgl_minta_perpanjang desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
	public function explodeTersangka($post){
		$data  = array();
		$data['nama'] 			= htmlspecialchars($post['nama'], ENT_QUOTES);
		$data['tmpt_lahir']		= htmlspecialchars($post['tmpt_lahir'], ENT_QUOTES);
		$data['tgl_lahir']		= htmlspecialchars($post['tgl_lahir'], ENT_QUOTES);                
		$data['umur']			= htmlspecialchars($post['umur'], ENT_QUOTES);                
		$data['warganegara'] 	= htmlspecialchars($post['warganegara'], ENT_QUOTES);                
		$data['kebangsaan'] 	= htmlspecialchars($post['kebangsaan'], ENT_QUOTES);                
		$data['suku'] 			= htmlspecialchars($post['suku'], ENT_QUOTES);                
		$data['id_identitas'] 	= htmlspecialchars($post['id_identitas'], ENT_QUOTES);                
		$data['no_identitas'] 	= htmlspecialchars($post['no_identitas'], ENT_QUOTES);                
		$data['id_jkl'] 		= htmlspecialchars($post['id_jkl'], ENT_QUOTES);                
		$data['id_agama'] 		= htmlspecialchars($post['id_agama'], ENT_QUOTES);                
		$data['alamat'] 		= htmlspecialchars($post['alamat'], ENT_QUOTES);                
		$data['no_hp'] 			= htmlspecialchars($post['no_hp'], ENT_QUOTES);                
		$data['id_pendidikan'] 	= htmlspecialchars($post['id_pendidikan'], ENT_QUOTES);                
		$data['pekerjaan'] 		= htmlspecialchars($post['pekerjaan'], ENT_QUOTES);
		$data['jenis_penahanan'] 		= htmlspecialchars($post['jenis_penahanan'], ENT_QUOTES);                
		$data['tgl_mulai_penahanan'] 	= htmlspecialchars($post['tgl_mulai_penahanan'], ENT_QUOTES);                
		$data['tgl_selesai_penahanan'] 	= htmlspecialchars($post['tgl_selesai_penahanan'], ENT_QUOTES);                
		$data['lokasi_penahanan'] 		= htmlspecialchars($post['lokasi_penahanan'], ENT_QUOTES);
		return $data;
	}

	public function searchTersangkaSpdp(){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];

		$sql = "select a.*, b.nama as kebangsaan from pidsus.pds_spdp_tersangka a left join public.ms_warganegara b on a.warganegara = b.id 
				where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_spdp = '".$no_spdp."' 
					and a.tgl_spdp = '".$tgl_spdp."'";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 10],
        ]);
        return $dataProvider;
    }

    public function cekMintaPerpanjang($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
		$nom_spdp  	= $_SESSION['no_spdp'];
		$tgl_spdp 	= $_SESSION['tgl_spdp'];

		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$nom_p16  	= htmlspecialchars($post['no_minta_perpanjang'], ENT_QUOTES);
		$where 		= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$nom_spdp."' 
						and tgl_spdp = '".$tgl_spdp."'";

		$sqlCek1 	= "select count(*) from pidsus.pds_minta_perpanjang where ".$where." and no_minta_perpanjang = '".$nom_p16."'";
		$count1 	= ($isNew)?$connection->createCommand($sqlCek1)->queryScalar():0;

		if($count1 > 0){
			$pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>Nomor Surat Permintaan dengan nomor '.$nom_p16.' sudah ada</i></p>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_minta_perpanjang");
		} else{
			return array("hasil"=>true, "error"=>"", "element"=>"");
		}
	}

	public function simpanData($post){
		$connection 		= $this->db;
		$id_kejati			= $_SESSION['kode_kejati'];
		$id_kejari			= $_SESSION['kode_kejari'];
		$id_cabjari			= $_SESSION['kode_cabjari'];
		$no_spdp			= $_SESSION['no_spdp'];
		$tgl_spdp			= $_SESSION['tgl_spdp'];
		$no_minta_perpanjang_sess	= $_SESSION['no_minta_perpanjang'];

		$no_minta_perpanjang		= htmlspecialchars($post['no_minta_perpanjang'], ENT_QUOTES);
		$tgl_minta_perpanjang		= htmlspecialchars($post['tgl_minta_perpanjang'], ENT_QUOTES);
		$no_surat_penahanan			= htmlspecialchars($post['no_surat_penahanan'], ENT_QUOTES);
		$tgl_surat_penahanan		= htmlspecialchars($post['tgl_surat_penahanan'], ENT_QUOTES);
		$tgl_terima					= htmlspecialchars($post['tgl_terima'], ENT_QUOTES);
		$jenis_penahanan			= htmlspecialchars($post['jenis_penahanan'], ENT_QUOTES);
		$tgl_mulai_penahanan		= htmlspecialchars($post['tgl_mulai_penahanan'], ENT_QUOTES);
		$tgl_selesai_penahanan		= htmlspecialchars($post['tgl_selesai_penahanan'], ENT_QUOTES);
		$lokasi_penahanan			= htmlspecialchars($post['lokasi_penahanan'], ENT_QUOTES);
		
		$nama			= htmlspecialchars($post['nama'], ENT_QUOTES);
		$tmpt_lahir		= htmlspecialchars($post['tmpt_lahir'], ENT_QUOTES);
		$tgl_lahir		= htmlspecialchars($post['tgl_lahir'], ENT_QUOTES);
		$umur			= htmlspecialchars($post['umur'], ENT_QUOTES);
		$warganegara	= htmlspecialchars($post['warganegara'], ENT_QUOTES);
		$suku			= htmlspecialchars($post['suku'], ENT_QUOTES);
		$id_identitas	= htmlspecialchars($post['id_identitas'], ENT_QUOTES);
		$no_identitas	= htmlspecialchars($post['no_identitas'], ENT_QUOTES);
		$id_jkl			= htmlspecialchars($post['id_jkl'], ENT_QUOTES);
		$id_agama		= htmlspecialchars($post['id_agama'], ENT_QUOTES);
		$alamat			= htmlspecialchars($post['alamat'], ENT_QUOTES);
		$no_hp			= htmlspecialchars($post['no_hp'], ENT_QUOTES);
		$id_pendidikan	= htmlspecialchars($post['id_pendidikan'], ENT_QUOTES);
		$pekerjaan		= htmlspecialchars($post['pekerjaan'], ENT_QUOTES);
		
		$created_user		= $_SESSION['username'];
		$created_nip		= $_SESSION['nik_user'];
		$created_nama		= $_SESSION['nama_pegawai'];
		$created_ip			= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai'];
		$updated_ip			= $_SERVER['REMOTE_ADDR'];

		$helpernya	= Yii::$app->inspektur;
		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['minta_perpanjang'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_spdp);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_spdp);
		$clean3 	= Yii::$app->inspektur->sanitize_filename($no_minta_perpanjang);
		$newPhoto 	= "Permintaan_perpanjangan_tahanan_".$clean1."-".$clean2."-".$clean3.$extPhoto;
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$no_spdp."' and tgl_spdp = '".$tgl_spdp."'";
		$transaction = $connection->beginTransaction();
		try{
			if($isNew){
				if($filePhoto != ""){
					$upl1 = true;
					$newPhoto = $newPhoto;
				} else{
					$upl1 = false;
					$newPhoto = "";
				}
				$sql1 = "insert into pidsus.pds_minta_perpanjang(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_minta_perpanjang, tgl_minta_perpanjang, 
						 no_surat_penahanan, tgl_surat_penahanan, tgl_terima, jenis_penahanan, tgl_mulai_penahanan, tgl_selesai_penahanan, lokasi_penahanan, nama, tmpt_lahir, 
						 tgl_lahir, umur, warganegara, suku, id_identitas, no_identitas, id_jkl, id_agama, alamat, no_hp, id_pendidikan, pekerjaan, file_upload_minta_perpanjang, 
						 created_user, created_nip, created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date) values
						 ('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$no_minta_perpanjang."', 
						 '".$helpernya->tgl_db($tgl_minta_perpanjang)."', '".$no_surat_penahanan."', '".$helpernya->tgl_db($tgl_surat_penahanan)."', 
						 '".$helpernya->tgl_db($tgl_terima)."', '".$jenis_penahanan."', '".$helpernya->tgl_db($tgl_mulai_penahanan)."', 
						 '".$helpernya->tgl_db($tgl_selesai_penahanan)."', '".$lokasi_penahanan."', '".$nama."', '".$tmpt_lahir."', '".$helpernya->tgl_db($tgl_lahir)."', 
						 '".$umur."', '".$warganegara."', '".$suku."', '".$id_identitas."', '".$no_identitas."', '".$id_jkl."', '".$id_agama."', '".$alamat."', '".$no_hp."', 
						 '".$id_pendidikan."', '".$pekerjaan."', '".$newPhoto."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload_minta_perpanjang = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_minta_perpanjang set no_minta_perpanjang = '".$no_minta_perpanjang."', tgl_minta_perpanjang = '".$helpernya->tgl_db($tgl_minta_perpanjang)."', 
						 no_surat_penahanan = '".$no_surat_penahanan."', tgl_surat_penahanan = '".$helpernya->tgl_db($tgl_surat_penahanan)."', 
						 tgl_terima = '".$helpernya->tgl_db($tgl_terima)."', jenis_penahanan = '".$jenis_penahanan."', 
						 tgl_mulai_penahanan = '".$helpernya->tgl_db($tgl_mulai_penahanan)."', tgl_selesai_penahanan = '".$helpernya->tgl_db($tgl_selesai_penahanan)."', 
						 lokasi_penahanan = '".$lokasi_penahanan."', nama = '".$nama."', tmpt_lahir = '".$tmpt_lahir."', tgl_lahir = '".$helpernya->tgl_db($tgl_lahir)."', 
						 umur = '".$umur."', warganegara = '".$warganegara."', suku = '".$suku."', id_identitas = '".$id_identitas."', no_identitas = '".$no_identitas."', 
						 id_jkl = '".$id_jkl."', id_agama = '".$id_agama."', alamat = '".$alamat."', no_hp = '".$no_hp."', id_pendidikan = '".$id_pendidikan."', 
						 pekerjaan = '".$pekerjaan."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_minta_perpanjang = '".$no_minta_perpanjang_sess."'";
			}
			$connection->createCommand($sql1)->execute();

			//$sqlStatusSpdp = "update pidsus.pds_spdp set status_spdp = 'P-16' where ".$whereDef;
			//$connection->createCommand($sqlStatusSpdp)->execute();

			if($upl1){
				$tmpPot = glob($pathfile."Permintaan_perpanjangan_tahanan_".$clean1."-".$clean2."-".$clean3.".*");
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

    public function hapusData($post){
		$connection 	= $this->db;
		$pathfile		= Yii::$app->params['minta_perpanjang'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload_minta_perpanjang from pidsus.pds_minta_perpanjang where ".$whereDefault." and no_minta_perpanjang = '".rawurldecode($tmp[0])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from pidsus.pds_minta_perpanjang where ".$whereDefault." and no_minta_perpanjang = '".rawurldecode($tmp[0])."'";
					$connection->createCommand($sql1)->execute();
				}
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }
}
