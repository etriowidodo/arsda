<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\HtmlPurifier;
use app\components\InspekturComponent;


class Eksepsi extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.s14';
    }
	
	public function simpanData($post){
		$connection = Yii::$app->db;
		$no_permohonan			= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$no_register_perkara	= htmlspecialchars($post['no_reg'], ENT_QUOTES);
		$no_skk					= htmlspecialchars($post['no_skk'], ENT_QUOTES);
		$tgl_skk				= htmlspecialchars($post['tanggal_skk'], ENT_QUOTES);
		$no_register_skks		= htmlspecialchars($post['no_skks'], ENT_QUOTES);

		$tgl_eksepsi	= htmlspecialchars($post['tgl_eksepsi'], ENT_QUOTES);
		$yth			= htmlspecialchars($post['untuk'], ENT_QUOTES);
		$tempat			= htmlspecialchars($post['tempat'], ENT_QUOTES);
		
		$kode_tk		= $_SESSION['kode_tk'];
		$kode_kejati	= $_SESSION['kode_kejati'];
		$kode_kejari	= $_SESSION['kode_kejari'];
		$kode_cabjari	= $_SESSION['kode_cabjari'];
		
		$alasan			= str_replace(array("'"), array("&#039;"), $post['alasan']);
		$primair		= str_replace(array("'"), array("&#039;"), $post['primair']);
		$subsidair		= str_replace(array("'"), array("&#039;"), $post['subsidair']);
		$isNewRecord	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		
		$create_user	= $_SESSION['username']; 
		$create_nip		= $_SESSION['nik_user'];
		$create_nama	= $_SESSION['nama_pegawai'];
		$create_ip		= $_SERVER['REMOTE_ADDR'];
		$update_user	= $_SESSION['username'];  
		$update_nip		= $_SESSION['nik_user'];
		$update_nama	= $_SESSION['nama_pegawai']; 
		$update_ip		= $_SERVER['REMOTE_ADDR'];

		$helpernya	= Yii::$app->inspektur;
		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['s14'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_skk);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_skk);
		$newPhoto 	= "eksepsi_".$clean1."-".$clean2.$extPhoto;
		
		$transaction = $connection->beginTransaction();
		try {
			if($isNewRecord){
				$sqlUpdate = "update datun.permohonan set status = 'EKSEPSI (S-14)' where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_permohonan."'";
				$connection->createCommand($sqlUpdate)->execute();

				if($filePhoto != ""){
					$upl1 = true;
					$newPhoto = $newPhoto1;
				} else{
					$upl1 = false;
					$newPhoto = "";
				}
				$sql1 = "insert into datun.s14(kode_tk, kode_kejati, kode_kejari, kode_cabjari, no_register_perkara, no_surat, no_register_skk, tanggal_skk, no_register_skks, 
						 tanggal_diterima_s14, kepada_yth, tempat, alasan, primair, subsidair, file_s14, created_user, created_nip, created_nama, created_ip, created_date, 
						 updated_user, updated_nip, updated_nama, updated_ip, updated_date)  
						 values('".$kode_tk."', '".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."', '".$no_register_perkara."', '".$no_permohonan."', '".$no_skk."', 
						 '".$helpernya->tgl_db($tgl_skk)."', '".$no_register_skks."', '".$helpernya->tgl_db($tgl_eksepsi)."', '".$yth."', '".$tempat."', '".$alasan."', 
						 '".$primair."', '".$subsidair."', '".$newPhoto."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			} else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_s14 = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				$sql1 = "update datun.s14 set tanggal_diterima_s14 = '".$helpernya->tgl_db($tgl_eksepsi)."', kepada_yth = '".$yth."', tempat = '".$tempat."', 
						 alasan = '".$alasan."', primair = '".$primair."', subsidair = '".$subsidair."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where no_surat = '".$no_permohonan."' and no_register_perkara = '".$no_register_perkara."'";
			}
			$connection->createCommand($sql1)->execute();

			if($upl1){
				$tmpPot = glob($pathfile."eksepsi_".$clean1."-".$clean2.".*");
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
			throw $e; exit();
			return false;
		}
	}
}