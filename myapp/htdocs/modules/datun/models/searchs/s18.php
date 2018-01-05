<?php

namespace app\modules\datun\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\HtmlPurifier;
use yii\web\Session;
use app\components\InspekturComponent;
   
class S18 extends \yii\db\ActiveRecord {
	public static function tableName(){
        return 'datun.s18';
    }
 
    public function simpanDatas18($post){
		$helpernya		= Yii::$app->inspektur;		
		$connection 	= Yii::$app->db; 			
		$isNewRecord	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_surat				= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$no_register_perkara	= htmlspecialchars($post['no_reg'], ENT_QUOTES);
		$no_register_skk 		= htmlspecialchars($post['no_skk'], ENT_QUOTES);
		$no_register_skks 		= htmlspecialchars($post['no_skks'], ENT_QUOTES);
		$no_s18 				= htmlspecialchars($post['no_s18'], ENT_QUOTES);
		$tanggal_s18 			= htmlspecialchars($post['tanggal_s18'], ENT_QUOTES);
		$tanggal_skk 			= htmlspecialchars($post['tanggal_skk'], ENT_QUOTES);

		$kepada_yth 			= htmlspecialchars($post['untuk'], ENT_QUOTES);
		$tempat 				= htmlspecialchars($post['tempat'], ENT_QUOTES);
		$nomor_sita_jaminan 	= htmlspecialchars($post['nomor_sita_jaminan'], ENT_QUOTES);
		$tanggal_sita_jaminan 	= htmlspecialchars($post['tanggal_sita_jaminan'], ENT_QUOTES);
		$tanggal_sita_jaminan 	= ($tanggal_sita_jaminan)?"'".$helpernya->tgl_db($tanggal_sita_jaminan)."'":'NULL';
		$hlampiran 				= htmlspecialchars($post['hlampiran'], ENT_QUOTES);
		
		
		$alasan			= str_replace(array("'"), array("&#039;"), $post['alasan']);
		$primair		= str_replace(array("'"), array("&#039;"), $post['primair']);
		$subsidair		= str_replace(array("'"), array("&#039;"), $post['subsidair']);
				
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

		$max_size		= 2 * 1024 * 1024;
		$allow_type		= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$helpernya		= Yii::$app->inspektur;
		$pathfile		= Yii::$app->params['s18'];

		$filePhoto1 	= htmlspecialchars($_FILES['file_s18']['name'],ENT_QUOTES);
		$sizePhoto1 	= htmlspecialchars($_FILES['file_s18']['size'],ENT_QUOTES);
		$tempPhoto1 	= htmlspecialchars($_FILES['file_s18']['tmp_name'],ENT_QUOTES);
		$extPhoto1 		= substr($filePhoto1,strrpos($filePhoto1,'.'));
		$clean1 		= Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean2 		= Yii::$app->inspektur->sanitize_filename($no_surat);
		$clean3 		= Yii::$app->inspektur->sanitize_filename($no_s18);
		$newPhoto1 		= "S18_".$clean1."-".$clean2."-".$clean3.$extPhoto1;	
		
		$transaction = $connection->beginTransaction();
		try{
			if($isNewRecord){
				$sql1 = "update datun.permohonan set status = 'S-18' where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
				$connection->createCommand($sql1)->execute();	
					
				$upl1 = false;
				$sql1 = "insert into datun.s18(no_register_skk, tanggal_skk, no_register_perkara, no_surat, no_s18, tanggal_s18, kode_tk, kode_kejati,
						kode_kejari, kode_cabjari, kepada_yth, tempat, nomor_sita_jaminan, tanggal_sita_jaminan, alasan, primair, subsidair, created_user,
						created_nama, created_nip, created_ip, created_date, updated_user, updated_nama, updated_nip, updated_ip, updated_date, no_register_skks";
				if($filePhoto1 != ""){
					$upl1 = true;
					$sql1 .= ", file_s18";
				}
				$sql1 .= ") values('".$no_register_skk."', '".$helpernya->tgl_db($tanggal_skk)."', '".$no_register_perkara."', '".$no_surat."', '".$no_s18."', 
						'".$helpernya->tgl_db($tanggal_s18)."', '".$kode_tk."', '".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."', '".$kepada_yth."', '".$tempat."', 
						'".$nomor_sita_jaminan."', ".$tanggal_sita_jaminan.", '".$alasan."', '".$primair."', '".$subsidair."', '".$created_user."',
						'".$created_nama."', '".$created_nip."', '".$created_ip."', NOW(), '".$updated_user."', '".$updated_nama."', '".$updated_nip."', '".$updated_ip."', NOW(), '".$no_register_skks."'";				
				if($filePhoto1 != "") $sql1 .= ", '".$newPhoto1."'";
				$sql1 .= ")";
				$eksekusi = $connection->createCommand($sql1)->execute();
				
			}else{
				$upl1 = false;
				$sql1 = "update datun.s18 set nomor_sita_jaminan = '".$nomor_sita_jaminan."', tanggal_sita_jaminan = ".$tanggal_sita_jaminan.", 
						tanggal_s18 = '".$helpernya->tgl_db($tanggal_s18)."', kepada_yth = '".$kepada_yth."', alasan = '".$alasan."', primair = '".$primair."', 
						subsidair = '".$subsidair."', tempat = '".$tempat."', updated_user = '".$update_user."', updated_nip = '".$update_nip."', 
						updated_nama = '".$update_nama."', updated_date = NOW(), updated_ip = '".$update_ip."',
						no_s18 = '".$no_s18."'";
				if($filePhoto1){
					$sql1 .= ", file_s18 = '".$newPhoto1."'";
					$upl1 = true ;
				}						
				$sql1 .= " where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
				$connection->createCommand($sql1)->execute();						
			}

			if($upl1){				
				$tmpPot = glob($pathfile."S18_".$clean1."-".$clean2."-".$clean3.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto1;
				$mantab  = move_uploaded_file($tempPhoto1, $tujuan);
				if(file_exists($tempPhoto1)) unlink($tempPhoto1);
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }	

}