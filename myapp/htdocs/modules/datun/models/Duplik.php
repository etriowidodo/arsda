<?php

namespace app\modules\datun\models;

use Yii;
use yii\db\Query;
use yii\helpers\HtmlPurifier;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;
 
class Duplik extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'datun.s17';
    }

	public function simpanData($post){ 
		$connection 	= $this->db;
		$helpernya		= Yii::$app->inspektur;
		$isNewRecord	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		
		$no_permohonan				= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$no_register_perkara		= htmlspecialchars($post['no_reg'], ENT_QUOTES);
		$no_skks					= htmlspecialchars($post['no_skks'], ENT_QUOTES);
		$no_skk						= htmlspecialchars($post['no_skk'], ENT_QUOTES);
		$tgl_skk					= htmlspecialchars($post['tanggal_skk'], ENT_QUOTES);
		$tanggal_s17				= htmlspecialchars($post['tanggal_keluar'], ENT_QUOTES);
				
		$tanggal_replik				= htmlspecialchars($post['tanggal_replik'],ENT_QUOTES);
		$yth						= htmlspecialchars($post['isi'],ENT_QUOTES);
		$tempat						= htmlspecialchars($post['tempat'],ENT_QUOTES);
		$eksepsi					= str_replace(array("'"), array("&#039;"), $post['jawaban_eksepsi']);
		$provisi					= str_replace(array("'"), array("&#039;"), $post['jawaban_provisi']);
		$pokokperkara				= str_replace(array("'"), array("&#039;"), $post['jawaban_pokokperkara']);
		$rekonvensi					= str_replace(array("'"), array("&#039;"), $post['jawaban_rekonvensi']);
		
		$prim_eksepsi 				= str_replace(array("'"), array("&#039;"), $post['primair_primeksepsi']);
		$prim_provisi				= str_replace(array("'"), array("&#039;"), $post['primair_primprovisi']);
		$prim_pokokperkara			= str_replace(array("'"), array("&#039;"), $post['primair_primpokokperkara']);
		$prim_rekonvensi			= str_replace(array("'"), array("&#039;"), $post['primair_primrekonvensi']);
		$prim_konverensi_rekonvensi	= str_replace(array("'"), array("&#039;"), $post['primair_primkonvensi']);
		$subsidair					= str_replace(array("'"), array("&#039;"), $post['subsidair']);

		$kode_tk		= $_SESSION['kode_tk'];
		$kode_kejati	= $_SESSION['kode_kejati'];
		$kode_kejari	= $_SESSION['kode_kejari'];
		$kode_cabjari	= $_SESSION['kode_cabjari'];
		$create_user	= $_SESSION['username']; 
		$create_nip		= $_SESSION['nik_user'];
		$create_nama	= $_SESSION['nama_pegawai'];
		$create_ip		= $_SERVER['REMOTE_ADDR'];
		$update_user	= $_SESSION['username'];  
		$update_nip		= $_SESSION['nik_user'];
		$update_nama	= $_SESSION['nama_pegawai']; 
		$update_ip		= $_SERVER['REMOTE_ADDR'];
		

		$filePhoto17= htmlspecialchars($_FILES['file_s17']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_s17']['size'],ENT_QUOTES);
		$tempPhoto17= htmlspecialchars($_FILES['file_s17']['tmp_name'],ENT_QUOTES);
		$extPhoto17 = substr($filePhoto17,strrpos($filePhoto17,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile17	= Yii::$app->params['s17'];
		$clean117 	= Yii::$app->inspektur->sanitize_filename($no_skk);
		$clean217 	= Yii::$app->inspektur->sanitize_filename($tgl_skk);
		$file_s17 	= "s17_".$clean117."-".$clean217.$extPhoto17;
		
		$filePhoto 	= htmlspecialchars($_FILES['file_replik']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_replik']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_replik']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['s17'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_skk);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_skk);
		$file_replik 	= "Replik_s17_".$clean1."-".$clean2.$extPhoto;

		
		$transaction = $connection->beginTransaction();
		try {
			if($isNewRecord){
				$upl1 = false;
				$upl2 = false;

				$sqlUpdate = "UPDATE datun.permohonan set status='DUPLIK (S-17)' WHERE no_register_perkara='$no_register_perkara' and 	
								no_surat='$no_permohonan' ";
				$connection->createCommand($sqlUpdate)->execute();
				
				$sql1 = "INSERT into datun.s17
							(no_register_skk,no_register_perkara,no_surat,tanggal_skk,tanggal_s17,
							kode_tk,kode_kejati,kode_kejari,kode_cabjari,
							tanggal_replik,kepada_yth,tempat,eksepsi,provisi,pokokperkara,rekonvensi,prim_konvensi_rekonvensi,
							prim_eksepsi,prim_provisi,prim_pokokperkara,prim_rekonvensi,subsidair,
							created_user,created_nip,created_nama,created_ip,created_date,
							updated_user,updated_nip,updated_nama,updated_ip,updated_date,no_register_skks";
				if($filePhoto){
					$sql1 .= ", file_replik";
					$upl1 = true ;
				}
				if($filePhoto17){
					$sql1 .= ", file_s17";
					$upl2 = true ;
				}
				$sql1 .= ") values ('$no_skk','$no_register_perkara','$no_permohonan','".$helpernya->tgl_db($tgl_skk)."','".$helpernya->tgl_db($tanggal_s17)."',
							'$kode_tk','$kode_kejati','$kode_kejari','$kode_cabjari',
							'".$helpernya->tgl_db($tanggal_replik)."','$yth','$tempat', '$eksepsi','$provisi', '$pokokperkara', '$rekonvensi','$prim_konverensi_rekonvensi',
							'$prim_eksepsi', '$prim_provisi', '$prim_pokokperkara','$prim_rekonvensi', '$subsidair',
							'$create_user','$create_nip','$create_nama','$create_ip',now(),
							'$update_user','$update_nip','$update_nama','$update_ip',now(),'$no_skks'";	
				
				if($filePhoto) $sql1 .= ", '".$file_replik."'";
				if($filePhoto17) $sql1 .= ", '".$file_s17."'";
				$sql1 .= ")";
			} else{
				$upl1 = false;
				$upl2 = false;
				$sql1 = "UPDATE datun.s17 set tanggal_s17='".$helpernya->tgl_db($tanggal_s17)."',tanggal_replik='".$helpernya->tgl_db($tanggal_replik)."',kepada_yth='$yth',tempat='$tempat',
						eksepsi='$eksepsi',provisi='$provisi',pokokperkara='$pokokperkara',rekonvensi='$rekonvensi',
						prim_eksepsi='$prim_eksepsi',prim_provisi='$prim_provisi',prim_pokokperkara='$prim_pokokperkara',prim_rekonvensi='$prim_rekonvensi',
						prim_konvensi_rekonvensi='$prim_konverensi_rekonvensi',subsidair='$subsidair',
						updated_user='$update_user',updated_nip='$update_nip',updated_nama='$update_nama',
						updated_ip='$update_ip',updated_date=now() ";
				if($filePhoto){
					$sql1 .= ", file_replik='$file_replik'";
					$upl1 = true ;
				}
				if($filePhoto17){
					$sql1 .= ", file_s17='$file_s17'";
					$upl2 = true ;
				}				
				$sql1 .= " WHERE no_surat='$no_permohonan' and no_register_perkara='$no_register_perkara'";
			}
			$connection->createCommand($sql1)->execute();
		
			if($upl2){
				$tmpPot = glob($pathfile17."s17_".$clean117."-".$clean217.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
					if(file_exists($datj)) unlink($datj);
				}
				$tujuan17  = $pathfile17.$file_s17;
				$mantab  = move_uploaded_file($tempPhoto17, $tujuan17);
				if(file_exists($tempPhoto17)) unlink($tempPhoto17);
			}
							
			if($upl1){
				$tmpPot = glob($pathfile."Replik_s17_".$clean1."-".$clean2.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
					if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$file_replik;
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
