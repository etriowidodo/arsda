<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Session;
use app\components\InspekturComponent;

class PutusanPK extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.putusan_pk';
    }
	
	public function cekPutusan($post){
		$connection = $this->db;
		$isNew 	                = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_pts_pk	            = htmlspecialchars($post['no_pts_pk'], ENT_QUOTES);
		if($isNew){
			$sqlCek = "select count(*) from datun.putusan_pk where kode_tk = '".$_SESSION['kode_tk']."' and kode_kejati = '".$_SESSION['kode_kejati']."' 
				   and kode_kejari = '".$_SESSION['kode_kejari']."' and kode_cabjari = '".$_SESSION['kode_cabjari']."' and no_pts_pk = '".$no_pts_pk."'";
			$count 	= $connection->createCommand($sqlCek)->queryScalar();
			if($count > 0){
				$pesan = '<i style="color:#dd4b39; font-size:12px;">No Putusan PK <b>'.$no_pts_pk.'</b> sudah ada</i>';
				return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom4");
			} else{
				return array("hasil"=>true, "error"=>"", "element"=>"");
			}
		} else {
			return array("hasil"=>true, "error"=>"", "element"=>"");
		}
	}
	
	public function simpanData($post){
		$connection             = Yii::$app->db;
		$isNewRecord			= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_surat				= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$no_register_perkara	= htmlspecialchars($post['no_register_perkara'], ENT_QUOTES);
		$kode_jenis_instansi	= htmlspecialchars($post['kode_jenis_instansi'], ENT_QUOTES);
		$kode_instansi			= htmlspecialchars($post['kode_instansi'], ENT_QUOTES);
		$no_register_skk		= htmlspecialchars($post['no_skk'], ENT_QUOTES);
		$tanggal_skk			= htmlspecialchars($post['tanggal_skk'], ENT_QUOTES);
		$no_register_skks		= htmlspecialchars($post['no_skks'], ENT_QUOTES);
		$no_pts_pk				= htmlspecialchars($post['no_pts_pk'], ENT_QUOTES);
		$tanggal_pts_pk			= htmlspecialchars($post['tanggal_pts_pk'], ENT_QUOTES);
		$tanggal_terima_jpn		= htmlspecialchars($post['tanggal_terima_jpn'], ENT_QUOTES);
		$amar_putusan			= str_replace(array("'"), array("&#039;"), $post['tab_amar']);
		$isInkrah				= htmlspecialchars($post['inkrah'], ENT_QUOTES);		
				
		$created_user		    = $_SESSION['username']; 
		$created_nip		    = $_SESSION['nik_user'];
		$created_nama		    = $_SESSION['nama_pegawai'];
		$created_ip			    = $_SERVER['REMOTE_ADDR'];
		$updated_user		    = $_SESSION['username'];  
		$updated_nip		    = $_SESSION['nik_user'];
		$updated_nama		    = $_SESSION['nama_pegawai']; 
		$updated_ip			    = $_SERVER['REMOTE_ADDR'];
		$kode_tk 			    = $_SESSION['kode_tk'];
		$kode_kejati 		    = $_SESSION['kode_kejati'];
		$kode_kejari 		    = $_SESSION['kode_kejari'];
		$kode_cabjari 		    = $_SESSION['kode_cabjari'];

		$helpernya	            = Yii::$app->inspektur;
		$filePhoto 	            = htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	            = htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	            = htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	            = substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	            = 2 * 1024 * 1024;
		$allow_type	            = array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	            = Yii::$app->params['putusan_pk'];
		$clean1 	            = Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean2 	            = Yii::$app->inspektur->sanitize_filename($no_pts_pk);
		$newPhoto 	            = "pts_pk_".$clean1."-".$clean2.$extPhoto;
		
		$transaction            = $connection->beginTransaction();
		try {
			
			if($isNewRecord){
				$sqlUpdate = "update datun.permohonan set status = 'PUTUSAN PK' where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
				$connection->createCommand($sqlUpdate)->execute();
				$upl1 = false;
				$sql1 = "insert into datun.putusan_pk(no_pts_pk,tanggal_pts_pk, tanggal_terima_jpn, no_register_skks, no_register_perkara,kode_jenis_instansi, kode_instansi, kode_tk, 
						kode_kejati, kode_kejari, kode_cabjari, amar_pts_pk, created_user, created_nip, created_nama, created_ip,created_date, 
						updated_user, updated_nip, updated_nama, updated_date, updated_ip, no_register_skk, tanggal_skk, is_inkrah, no_surat";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_pts_pk";
				}
				$sql1 .= ") values
						('".$no_pts_pk."', '".$helpernya->tgl_db($tanggal_pts_pk)."', '".$helpernya->tgl_db($tanggal_terima_jpn)."', '".$no_register_skks."', '".$no_register_perkara."', '".$kode_jenis_instansi."', '".$kode_instansi."', '".$kode_tk."', 
						'".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."', '".$amar_putusan."', '".$created_user."', '".$created_nip."', '".$created_nama."','".$created_ip."', NOW(), 
						'".$updated_user."', '".$updated_nip."', '".$updated_nama."', NOW(), '".$updated_ip."', '".$no_register_skk."', '".$helpernya->tgl_db($tanggal_skk)."','".$isInkrah."','".$no_surat."'";

				if($filePhoto != "") $sql1 .= ", '".$newPhoto."'";
				$sql1 .= ")";

			} else{
				$upl1 = false;
				$sql1 = "update datun.putusan_pk set tanggal_pts_pk = '".$helpernya->tgl_db($tanggal_pts_pk)."',
						tanggal_terima_jpn = '".$helpernya->tgl_db($tanggal_terima_jpn)."', no_pts_pk = '".$no_pts_pk."',
						updated_user = '".$updated_user."', updated_nip = '".$updated_nip."',updated_nama = '".$updated_nama."', 
						updated_ip = '".$updated_ip."', updated_date = NOW(), is_inkrah = '".$isInkrah."'";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_pts_pk = '".$newPhoto."'";
				}
				$sql1 .= " where no_register_perkara='".$no_register_perkara."' and no_surat = '".$no_surat."'";
			}
			$connection->createCommand($sql1)->execute();
			
			if($upl1){
				$tmpPot = glob($pathfile."pts_pk_".$clean1."-".$clean2.".*");
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