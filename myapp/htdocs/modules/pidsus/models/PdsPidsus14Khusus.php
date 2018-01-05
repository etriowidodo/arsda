<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsPidsus14Khusus extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p16';
    }
    
	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_pidsus18	= $_SESSION['pidsus_no_pidsus18'];
		$no_p8_khusus	= $_SESSION['pidsus_no_p8_khusus'];
		$sql = "
		with tbl_saksi as(
			select id_kejati, id_kejari, id_cabjari, no_pidsus18, no_p8_khusus, no_urut_pidsus14_khusus, 
			string_agg(nama||'#'||jabatan||'#'||waktu_pelaksanaan||'#'||status_keperluan, '|#|' order by no_urut_saksi_tsk) as saksinya 
			from pidsus.pds_pidsus14_khusus_saksi_tersangka 
			group by id_kejati, id_kejari, id_cabjari, no_pidsus18, no_p8_khusus, no_urut_pidsus14_khusus 
		)
		select b.saksinya, a.*  
		from pidsus.pds_pidsus14_khusus a 
		left join tbl_saksi b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_pidsus18 = b.no_pidsus18 and a.no_p8_khusus = b.no_p8_khusus and a.no_urut_pidsus14_khusus = b.no_urut_pidsus14_khusus 
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_pidsus18 = '".$no_pidsus18."' and a.no_p8_khusus = '".$no_p8_khusus."'";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.no_urut_pidsus14_khusus desc";//echo $sql;exit;
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
	/*public function explodeSaksi($post){
		$a 	= htmlspecialchars($post['saksi_ahli'],ENT_QUOTES);
		$e 	= explode("|#|", $a);
		$data = [];
		$data['nama'] 		= htmlspecialchars($e[0], ENT_QUOTES);
		$data['jabatan'] 	= htmlspecialchars($e[1], ENT_QUOTES);
		$data['waktu_pelaksanaan'] = htmlspecialchars($e[2], ENT_QUOTES);
		$data['jaksa']		= htmlspecialchars($e[3], ENT_QUOTES);
		$data['keperluan']	= htmlspecialchars($e[4], ENT_QUOTES);
		return $data;
	}*/

	public function explodeSaksi($post){
		return $post['saksi_ahli'];
	}

	public function simpanData($post){
		$helpernya	= Yii::$app->inspektur;
		$connection = $this->db;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_pidsus18	= $_SESSION['pidsus_no_pidsus18'];
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_p8_khusus			= htmlspecialchars($post['no_p8_khusus'], ENT_QUOTES);
		$no_urut_pidsus14_khusus 	= ($post['no_urut_pidsus14_khusus'])?htmlspecialchars($post['no_urut_pidsus14_khusus'], ENT_QUOTES):0;
		$tgl_pidsus14_khusus		= htmlspecialchars($post['tgl_pidsus14_khusus'], ENT_QUOTES);
		$lampiran			= htmlspecialchars($post['lampiran'], ENT_QUOTES);
		
		$penandatangan_nama		= htmlspecialchars($post['penandatangan_nama'], ENT_QUOTES);
		$penandatangan_nip		= htmlspecialchars($post['penandatangan_nip'], ENT_QUOTES);
		$penandatangan_jabatan		= htmlspecialchars($post['penandatangan_jabatan'], ENT_QUOTES);
		$penandatangan_gol		= htmlspecialchars($post['penandatangan_gol'], ENT_QUOTES);
		$penandatangan_pangkat		= htmlspecialchars($post['penandatangan_pangkat'], ENT_QUOTES);
		$penandatangan_status_ttd	= htmlspecialchars($post['penandatangan_status'], ENT_QUOTES);
		$penandatangan_jabatan_ttd	= htmlspecialchars($post['penandatangan_ttdjabat'], ENT_QUOTES);
		
		$created_user		= $_SESSION['username'];
		$created_nip		= $_SESSION['nik_user'];
		$created_nama		= $_SESSION['nama_pegawai'];
		$created_ip		= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai'];
		$updated_ip		= $_SERVER['REMOTE_ADDR'];

		$sql0 = "select coalesce(max(no_urut_pidsus14_khusus)+1,1) as nourut from pidsus.pds_pidsus14_khusus 
				 where id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_pidsus18 = '".$no_pidsus18."' and no_p8_khusus = '".$no_p8_khusus."'";
		$row0 = $connection->createCommand($sql0)->queryScalar();

		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['pidsus_14khusus'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_khusus);
		$clean2 	= ($isNew)?$row0:$no_urut_pidsus14_khusus;
		$newPhoto 	= "pidsus14khusus_".$clean1."-".$clean2.$extPhoto;
		$whereDef 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_pidsus18 = '".$no_pidsus18."' and no_p8_khusus = '".$no_p8_khusus."'";

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
				$sql1 = "insert into pidsus.pds_pidsus14_khusus(id_kejati, id_kejari, id_cabjari, no_pidsus18, no_p8_khusus, no_urut_pidsus14_khusus, tgl_pidsus14_khusus, lampiran, 
						 penandatangan_nama, penandatangan_nip, penandatangan_jabatan_pejabat, penandatangan_gol, penandatangan_pangkat, penandatangan_status_ttd, 
						 penandatangan_jabatan_ttd, file_upload, created_user, created_nip, created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, 
						 updated_ip, updated_date) values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_pidsus18."', '".$no_p8_khusus."', '".$row0."', 
						 '".$helpernya->tgl_db($tgl_pidsus14_khusus)."', '".$lampiran."', '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', 
						 '".$penandatangan_gol."', '".$penandatangan_pangkat."', '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$newPhoto."', 
						 '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_pidsus14_khusus set tgl_pidsus14_khusus = '".$helpernya->tgl_db($tgl_pidsus14_khusus)."', lampiran = '".$lampiran."', 
						 penandatangan_nama = '".$penandatangan_nama."', penandatangan_nip = '".$penandatangan_nip."', 
						 penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_urut_pidsus14_khusus = '".$no_urut_pidsus14_khusus."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql2 = "delete from pidsus.pds_pidsus14_khusus_saksi_tersangka where ".$whereDef." and no_urut_pidsus14_khusus = '".$no_urut_pidsus14_khusus."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['saksi_ahli']) > 0){
				$nourut = ($isNew)?$row0:$no_urut_pidsus14_khusus;
				foreach($post['saksi_ahli'] as $idx=>$val){
					$datanya 	= json_decode($val, true);
					$nama		= htmlspecialchars($datanya['nama'], ENT_QUOTES);
					$jabatan 	= htmlspecialchars($datanya['jabatan'], ENT_QUOTES);
					$alamat		= htmlspecialchars($datanya['alamat'], ENT_QUOTES);
					$waktu 		= htmlspecialchars($datanya['waktu_pelaksanaan'], ENT_QUOTES);
					$jaksa 		= htmlspecialchars($datanya['jaksa'], ENT_QUOTES);
					$status 	= htmlspecialchars($datanya['status_keperluan'], ENT_QUOTES);
					$keperluan 	= htmlspecialchars($datanya['keperluan'], ENT_QUOTES);
					$keterangan = htmlspecialchars($datanya['keterangan'], ENT_QUOTES);
					list($nip_jaksa, $nama_jaksa, $gol_jaksa, $pangkat_jaksa, $jabatan_jaksa) = explode("#", $jaksa);
					$sql3 = "insert into pidsus.pds_pidsus14_khusus_saksi_tersangka(id_kejati, id_kejari, id_cabjari, no_pidsus18, no_p8_khusus, no_urut_pidsus14_khusus, no_urut_saksi_tsk, nama, jabatan, 
							 waktu_pelaksanaan, nip_jaksa, nama_jaksa, gol_jaksa, pangkat_jaksa, jabatan_jaksa, keperluan, status_keperluan, alamat, keterangan) values 
							 ('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_pidsus18."', '".$no_p8_khusus."', '".$nourut."', '".($idx+1)."', '".$nama."', '".$jabatan."', 
							 '".$helpernya->tgl_db($waktu)."', '".$nip_jaksa."', '".$nama_jaksa."', '".$gol_jaksa."', '".$pangkat_jaksa."', '".$jabatan_jaksa."', 
							 '".$keperluan."', '".$status."', '".$alamat."', '".$keterangan."')";
					$connection->createCommand($sql3)->execute();
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."pidsus14khusus_".$clean1."-".$clean2.".*");
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
		$pathfile		= Yii::$app->params['pidsus_14khusus'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."' and no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload from pidsus.pds_pidsus14_khusus where ".$whereDefault." and no_urut_pidsus14_khusus = '".rawurldecode($tmp[0])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from pidsus.pds_pidsus14_khusus where ".$whereDefault." and no_urut_pidsus14_khusus = '".rawurldecode($tmp[0])."'";
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
