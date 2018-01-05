<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Session;
use app\components\InspekturComponent;


class Mediasi extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.mediasi';
    }
	
	public function simpanData($post){
		$connection = Yii::$app->db;

		$no_permohonan			= htmlspecialchars($post['no_surat'], ENT_QUOTES);//
		$no_register_perkara	= htmlspecialchars($post['no_reg'], ENT_QUOTES);//
		$no_skks				= ($post['no_skks'])?htmlspecialchars($post['no_skks'], ENT_QUOTES):'';//
		$no_skk					= htmlspecialchars($post['no_skk'], ENT_QUOTES);//
		$tgl_skk				= htmlspecialchars($post['tanggal_skk'], ENT_QUOTES);//
		
		$proses_mediasi			= htmlspecialchars($post['proses_mediasi'], ENT_QUOTES);//
		$file_mediasi			= htmlspecialchars($post['file_template'], ENT_QUOTES);//
		//$penggugat				= htmlspecialchars($post['penggugat'], ENT_QUOTES);//
		//$kuasa_penggugat		= htmlspecialchars($post['kuasa_penggugat'], ENT_QUOTES);//
		
		$isNew 					= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		
		$helpernya	= Yii::$app->inspektur;
		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['mediasi'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_skk);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_skk);
		$newPhoto 	= "mediasi_".$clean1."-".$clean2.$extPhoto;
		
		$create_user			= $_SESSION['username']; 
		$create_nip				= $_SESSION['nik_user'];
		$create_nama			= $_SESSION['nama_pegawai'];
		$create_ip				= $_SERVER['REMOTE_ADDR'];

		$update_user			= $_SESSION['username'];  
		$update_nip				= $_SESSION['nik_user'];
		$update_nama			= $_SESSION['nama_pegawai']; 
		$update_ip				= $_SERVER['REMOTE_ADDR'];

		//untuk update
		$berhasil = 0;
		$transaction = $connection->beginTransaction();
		try {
			
			
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 = "UPDATE datun.mediasi set proses_mediasi='$proses_mediasi',file_mediasi='$newPhoto',
							updated_user='$update_user',updated_nip='$update_nip',updated_nama='$update_nama',
							updated_ip='$update_ip',updated_date=now()
							WHERE no_surat='$no_permohonan' and no_register_perkara='$no_register_perkara'";
				} else{
					$upl1 = false;
					$sql1 = "UPDATE datun.mediasi set proses_mediasi='$proses_mediasi',
							updated_user='$update_user',updated_nip='$update_nip',updated_nama='$update_nama',
							updated_ip='$update_ip',updated_date=now()
							WHERE no_surat='$no_permohonan' and no_register_perkara='$no_register_perkara'";
				}
			
			$berhasil = $connection->createCommand($sql1)->execute();
			
			if($upl1){
				$tmpPot = glob($pathfile."mediasi_".$clean1."-".$clean2.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto;
				$mantab  = move_uploaded_file($tempPhoto, $tujuan);
				if(file_exists($tempPhoto)) unlink($tempPhoto);
			}
			$transaction->commit();			
		} catch (Exception $e) {
			$transaction->rollBack();
			$berhasil = 0;
		}
		
		//untuk insert
		if ($berhasil==0 ){
			$transaction = $connection->beginTransaction();
			
			try {
				
				$sqlUpdate = "UPDATE datun.permohonan set status='MEDIASI' WHERE no_register_perkara='$no_register_perkara' and 	
							  no_surat='$no_permohonan' ";
				$connection->createCommand($sqlUpdate)->execute();
				
				
					if($filePhoto != ""){
						$upl1 = true;
						$sql1 = "insert into datun.mediasi
							(no_register_skk,no_register_perkara,no_surat,tanggal_skk,proses_mediasi,
							file_mediasi,created_user,created_nip,created_nama,created_ip,
							created_date,updated_user,updated_nip,updated_nama,updated_ip,updated_date,no_register_skks) 
							
							values
							
							('$no_skk','$no_register_perkara','$no_permohonan','".$helpernya->tgl_db($tgl_skk)."','$proses_mediasi',
							'$newPhoto','$create_user','$create_nip','$create_nama','$create_ip',
							 now(),'$update_user','$update_nip','$update_nama','$update_ip',now(),'$no_skks')";
					} else{
						$upl1 = false;
						$sql1 = "insert into datun.mediasi
							(no_register_skk,no_register_perkara,no_surat,tanggal_skk,proses_mediasi,
							created_user,created_nip,created_nama,created_ip,created_date,
							updated_user,updated_nip,updated_nama,updated_ip,updated_date,no_register_skks) 
							
							values
							
							('$no_skk','$no_register_perkara','$no_permohonan','".$helpernya->tgl_db($tgl_skk)."','$proses_mediasi',
							'$create_user','$create_nip','$create_nama','$create_ip',now(),
							'$update_user','$update_nip','$update_nama','$update_ip',now(),'$no_skks')";
					}
				
				$berhasil = $connection->createCommand($sql1)->execute();
				
				
				if($upl1){
					$tmpPot = glob($pathfile."mediasi_".$clean1."-".$clean2.".*");
				}
				$transaction->commit();		
						
			} 
			catch (\Exception $e) {
				$transaction->rollBack();
				$berhasil = 0;				
			}
		}
		
		if ($berhasil==1){
			return true;
		} else {
			throw $e; exit();
			return false;
		}
    }
}