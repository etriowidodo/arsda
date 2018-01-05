<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsBa1 extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p16';
    }
    
    public function explodeTersangka($post){
		$a 	= htmlspecialchars($post['tersangka'],ENT_QUOTES);
		$e 	= explode("|#|", $a);
		$data = [];
		$data['no_urut'] 		= htmlspecialchars($e[0], ENT_QUOTES);
		$data['nama'] 			= htmlspecialchars($e[1], ENT_QUOTES);
		$data['tmpt_lahir']		= htmlspecialchars($e[2], ENT_QUOTES);
		$data['tgl_lahir']		= htmlspecialchars($e[3], ENT_QUOTES);                
		$data['umur']			= htmlspecialchars($e[4], ENT_QUOTES);                
		$data['id_warganegara'] = htmlspecialchars($e[5], ENT_QUOTES);                
		$data['kebangsaan'] 	= htmlspecialchars($e[6], ENT_QUOTES);                
		$data['suku'] 			= htmlspecialchars($e[7], ENT_QUOTES);                
		$data['id_identitas'] 	= htmlspecialchars($e[8], ENT_QUOTES);                
		$data['no_identitas'] 	= htmlspecialchars($e[9], ENT_QUOTES);                
		$data['id_jkl'] 		= htmlspecialchars($e[10], ENT_QUOTES);                
		$data['id_agama'] 		= htmlspecialchars($e[11], ENT_QUOTES);                
		$data['alamat'] 		= htmlspecialchars($e[12], ENT_QUOTES);                
		$data['no_hp'] 			= htmlspecialchars($e[13], ENT_QUOTES);                
		$data['id_pendidikan'] 	= htmlspecialchars($e[14], ENT_QUOTES);                
		$data['pekerjaan'] 		= htmlspecialchars($e[15], ENT_QUOTES);
		return $data;
	}

	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];
		$sql = "
		with tbl_jaksa as(
			select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_p16, string_agg(nama, '#') as jpunya 
			from pidsus.pds_p16_jaksa group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_p16 
		)
		select a.no_p16, a.tgl_dikeluarkan, a.file_upload_p16, b.jpunya 
		from pidsus.pds_p16 a 
		left join tbl_jaksa b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_p16 = b.no_p16
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_spdp = '".$no_spdp."' 
			and a.tgl_spdp = '".$tgl_spdp."'";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_dikeluarkan desc, a.created_date desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
    public function cekPdsBa1($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
		$nom_spdp  	= $_SESSION['no_spdp'];
		$tgl_spdp 	= $_SESSION['tgl_spdp'];

		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$nom_p16  	= htmlspecialchars($post['no_p16'], ENT_QUOTES);
		$tgl_p16 	= htmlspecialchars($post['tgldittd'], ENT_QUOTES);
		$where 		= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$nom_spdp."' 
						and tgl_spdp = '".$tgl_spdp."'";

		$sqlCek1 	= "select count(*) from pidsus.pds_p16 where ".$where." and no_p16 = '".$nom_p16."'";
		$count1 	= ($isNew)?$connection->createCommand($sqlCek1)->queryScalar():0;

		$sqlCek2 	= "select count(*) from pidsus.pds_p16 where ".$where." and tgl_dikeluarkan = '".$helpernya->tgl_db($tgl_p16)."'";
		$count2 	= ($isNew)?$connection->createCommand($sqlCek1)->queryScalar():0;

		if($count1 > 0){
			$pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>No PdsBa1 dengan nomor '.$nom_p16.' sudah ada</i></p>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_p16");
		} else if($count2 > 0){
			$pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>Tanggal dikeluarkan sudah ada</i></p>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_tgldittd");
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

		$no_p16				= htmlspecialchars($post['no_p16'], ENT_QUOTES);
		$dikeluarkan		= htmlspecialchars($post['lokel'], ENT_QUOTES);
		$tgl_dikeluarkan	= htmlspecialchars($post['tgldittd'], ENT_QUOTES);
		
		$penandatangan_nama			= htmlspecialchars($post['penandatangan_nama'], ENT_QUOTES);
		$penandatangan_nip			= htmlspecialchars($post['penandatangan_nip'], ENT_QUOTES);
		$penandatangan_jabatan		= htmlspecialchars($post['penandatangan_jabatan'], ENT_QUOTES);
		$penandatangan_gol			= htmlspecialchars($post['penandatangan_gol'], ENT_QUOTES);
		$penandatangan_pangkat		= htmlspecialchars($post['penandatangan_pangkat'], ENT_QUOTES);
		$penandatangan_status_ttd	= htmlspecialchars($post['penandatangan_status'], ENT_QUOTES);
		$penandatangan_jabatan_ttd	= htmlspecialchars($post['penandatangan_ttdjabat'], ENT_QUOTES);
		
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
		$pathfile	= Yii::$app->params['p16'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_spdp);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_spdp);
		$clean3 	= Yii::$app->inspektur->sanitize_filename($no_p16);
		$newPhoto 	= "p16_".$clean1."-".$clean2."-".$clean3.$extPhoto;
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
				$sql1 = "insert into pidsus.pds_p16(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_p16, tgl_dikeluarkan, penandatangan_nama, penandatangan_nip, 
						 penandatangan_jabatan_pejabat, penandatangan_gol, penandatangan_pangkat, penandatangan_status_ttd, penandatangan_jabatan_ttd, created_user, created_nip, 
						 created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date, file_upload_p16) values('".$id_kejati."', 
						 '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$no_p16."', '".$helpernya->tgl_db($tgl_dikeluarkan)."', 
						 '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', 
						 '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW(), '".$newPhoto."')";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload_p16 = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_p16 set tgl_dikeluarkan = '".$helpernya->tgl_db($tgl_dikeluarkan)."', penandatangan_nama = '".$penandatangan_nama."', 
						 penandatangan_nip = '".$penandatangan_nip."', penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_p16 = '".$no_p16."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql2 = "delete from pidsus.pds_p16_jaksa where ".$whereDef." and no_p16 = '".$no_p16."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['jpnid']) > 0){
				foreach($post['jpnid'] as $idx=>$val){
					list($nip, $nama, $golpangkat, $gol, $pangkat, $jabatan) = explode("#", $val);
					$sql3 = "insert into pidsus.pds_p16_jaksa values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$no_p16."', 
							 '".$nip."', '".($idx+1)."', '".$nama."', '".$gol."', '".$pangkat."', '".$jabatan."')";
					$connection->createCommand($sql3)->execute();
				}
			}

			$sql4 = "delete from pidsus.pds_p16_tembusan where ".$whereDef." and no_p16 = '".$no_p16."'";
			$connection->createCommand($sql4)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql5 = "insert into pidsus.pds_p16_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$no_p16."', 
								 '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql5)->execute();
					}
				}
			}

			$sqlStatusSpdp = "update pidsus.pds_spdp set status_spdp = 'P-16' where ".$whereDef;
			$connection->createCommand($sqlStatusSpdp)->execute();

			if($upl1){
				$tmpPot = glob($pathfile."p16_".$clean1."-".$clean2."-".$clean3.".*");
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
		$pathfile		= Yii::$app->params['p16'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload_p16 from pidsus.pds_p16 where ".$whereDefault." and no_p16 = '".rawurldecode($tmp[0])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from pidsus.pds_p16 where ".$whereDefault." and no_p16 = '".rawurldecode($tmp[0])."'";
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

	public function explodeUpload($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
		$nom_spdp  	= $_SESSION['no_spdp'];
		$tgl_spdp 	= $_SESSION['tgl_spdp'];
		$nom_p16 	= htmlspecialchars($post['id'], ENT_QUOTES);
		$where 		= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$nom_spdp."' 
						and tgl_spdp = '".$tgl_spdp."'";
		$sql1 = "select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_p16, file_upload_p16 from pidsus.pds_p16 where ".$where." and no_p16 = '".$nom_p16."'";
		$row1 = $connection->createCommand($sql1)->queryOne();
		$data = array();
		$data['id_kejati'] 	= $row1['id_kejati'];
		$data['id_kejari'] 	= $row1['id_kejari'];
		$data['id_cabjari']	= $row1['id_cabjari'];
		$data['no_spdp']	= $row1['no_spdp'];
		$data['tgl_spdp']	= $row1['tgl_spdp'];
		$data['no_p16'] 	= $row1['no_p16'];
		$data['file_upload_p16'] = $row1['file_upload_p16'];
		return $data;
	}

	public function simpanUpload($post){
		$connection 	= $this->db;
		$id_kejati		= htmlspecialchars($post['id_kejati'], ENT_QUOTES);
		$id_kejari		= htmlspecialchars($post['id_kejari'], ENT_QUOTES);
		$id_cabjari		= htmlspecialchars($post['id_cabjari'], ENT_QUOTES);
		$no_spdp		= htmlspecialchars($post['no_spdp'], ENT_QUOTES);
		$tgl_spdp		= htmlspecialchars($post['tgl_spdp'], ENT_QUOTES);
		$no_p16			= htmlspecialchars($post['no_p16'], ENT_QUOTES);
		$updated_user	= $_SESSION['username'];
		$updated_nip	= $_SESSION['nik_user'];
		$updated_nama	= $_SESSION['nama_pegawai'];
		$updated_ip		= $_SERVER['REMOTE_ADDR'];

		$helpernya	= Yii::$app->inspektur;
		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['p16'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_spdp);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_spdp);
		$clean3 	= Yii::$app->inspektur->sanitize_filename($no_p16);
		$newPhoto 	= "p16_".$clean1."-".$clean2."-".$clean3.$extPhoto;

		$transaction = $connection->beginTransaction();
		try{
			if($filePhoto != ""){
				$filenya = ", file_upload_p16 = '".$newPhoto."'";
				$sql1 = "update pidsus.pds_p16 set file_upload_p16 = '".$newPhoto."' where id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and 
						 id_cabjari = '".$id_cabjari."' and no_spdp = '".$no_spdp."' and tgl_spdp = '".$tgl_spdp."' and no_p16 = '".$no_p16."'";
				$connection->createCommand($sql1)->execute();

				$tmpPot = glob($pathfile."p16_".$clean1."-".$clean2."-".$clean3.".*");
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