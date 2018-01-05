<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Session;
use app\components\InspekturComponent;

class PutusanKontraBanding extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.pts_kontra_banding';
    }
	
   	public function cekPtsKontraBanding($post){
		$connection 			= $this->db;
		$isNew 	        		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_pts_kontrabanding  = htmlspecialchars($post['no_pts_kontrabanding'], ENT_QUOTES);
		if($isNew){
			$sqlCek = "select count(*) from datun.pts_kontra_banding where kode_tk = '".$_SESSION['kode_tk']."' and kode_kejati = '".$_SESSION['kode_kejati']."' 
				   and kode_kejari = '".$_SESSION['kode_kejari']."' and kode_cabjari = '".$_SESSION['kode_cabjari']."' and no_pts_kontrabanding = '".$no_pts_kontrabanding."'";
			$count 	= $connection->createCommand($sqlCek)->queryScalar();
			if($count > 0){
				$pesan = '<i style="color:#dd4b39; font-size:12px;">No putusan kontra banding <b>'.$no_pts_kontrabanding.'</b> sudah ada</i>';
				return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom5");
			} else{
				return array("hasil"=>true, "error"=>"", "element"=>"");
			}
		} else {
			return array("hasil"=>true, "error"=>"", "element"=>"");
		}
	}
	
	public function simpanData($post){
		$connection = Yii::$app->db;

		$isNewRecord				= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_putusan					= htmlspecialchars($post['no_putusan'], ENT_QUOTES);
		$tanggal_putusan			= htmlspecialchars($post['tanggal_putusan'], ENT_QUOTES);
		$no_register_skks			= htmlspecialchars($post['no_register_skks'], ENT_QUOTES);
		$no_pts_kontrabanding		= htmlspecialchars($post['no_pts_kontrabanding'], ENT_QUOTES);
		$tanggal_pts_kontrabanding	= htmlspecialchars($post['tanggal_pts_kontrabanding'], ENT_QUOTES);				
		$no_register_perkara		= htmlspecialchars($post['no_register_perkara'], ENT_QUOTES);
		$kode_jenis_instansi		= htmlspecialchars($post['kode_jenis_instansi'], ENT_QUOTES);
		$kode_instansi				= htmlspecialchars($post['kode_instansi'], ENT_QUOTES);
		$amar						= str_replace(array("'"), array("&#039;"), $post['tab_amar']); 
		$no_surat					= htmlspecialchars($post['no_surat'], ENT_QUOTES);		
		$created_user		= $_SESSION['username']; 
		$created_nip		= $_SESSION['nik_user'];
		$created_nama		= $_SESSION['nama_pegawai'];
		$created_ip			= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];  
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai']; 
		$updated_ip			= $_SERVER['REMOTE_ADDR'];
		$kode_tk 			= $_SESSION['kode_tk'];
		$kode_kejati 		= $_SESSION['kode_kejati'];
		$kode_kejari 		= $_SESSION['kode_kejari'];
		$kode_cabjari 		= $_SESSION['kode_cabjari'];

		$helpernya	= Yii::$app->inspektur;
		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['pts_kontra_banding'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_putusan);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_pts_kontrabanding);
		$newPhoto 	= "pts_kontra_bdg_".$clean1."-".$clean2.$extPhoto;
		
		$transaction = $connection->beginTransaction();
		try {
			
			$sqlUpdate = "update datun.permohonan set status = 'PUTUSAN KONTRA BANDING' where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
			$connection->createCommand($sqlUpdate)->execute();
			
			if($isNewRecord){
				$upl1 = false;
				$sql1 = "insert into datun.pts_kontra_banding(no_register_skks,no_pts_kontrabanding, tanggal_pts_kontrabanding,no_putusan, tanggal_putusan, no_register_perkara, kode_jenis_instansi, kode_instansi, kode_tk, 
						kode_kejati, kode_kejari, kode_cabjari, amar_pts_kontrabanding,
						created_user, created_nip, created_nama, created_ip,created_date, 
						updated_user, updated_nip, updated_nama, updated_date, updated_ip";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_pts_kontrabanding";
				}
			
				$sql1 .= ") values
						('".$no_register_skks."', '".$no_pts_kontrabanding."', '".$helpernya->tgl_db($tanggal_pts_kontrabanding)."', '".$no_putusan."', '".$helpernya->tgl_db($tanggal_putusan)."', '".$no_register_perkara."', '".$kode_jenis_instansi."', '".$kode_instansi."', '".$kode_tk."', 
						'".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."', '".$amar."',
						'".$created_user."', '".$created_nip."', '".$created_nama."','".$created_ip."', NOW(), 
						'".$updated_user."', '".$updated_nip."', '".$updated_nama."', NOW(), '".$updated_ip."'";

				if($filePhoto != "") $sql1 .= ", '".$newPhoto."'";
				$sql1 .= ")";

			}else{
				$upl1 = false;
				$sql1 = "update datun.pts_kontra_banding set  amar_pts_kontrabanding = '".$amar."',
						updated_user = '".$updated_user."', updated_nip = '".$updated_nip."',updated_nama = '".$updated_nama."', 
						updated_ip = '".$updated_ip."', updated_date = NOW()";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_pts_kontrabanding = '".$newPhoto."'";
				}
			
				$sql1 .= " where no_pts_kontrabanding = '".$no_pts_kontrabanding."' and no_putusan = '".$no_putusan."' and no_register_skks = '".$no_register_skks."' 
							and tanggal_putusan = '".$helpernya->tgl_db($tanggal_putusan)."' and tanggal_pts_kontrabanding = '".$helpernya->tgl_db($tanggal_pts_kontrabanding)."'";
			}
			$connection->createCommand($sql1)->execute();
			
							
			if($upl1){
				$tmpPot = glob($pathfile."pts_kontra_bdg_".$clean1."-".$clean2.".*");
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