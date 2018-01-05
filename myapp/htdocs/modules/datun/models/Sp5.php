<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\HtmlPurifier;
use app\components\InspekturComponent;

class Sp5 extends \yii\db\ActiveRecord{

    public static function tableName(){
        return 'datun.s5';
    }

    public function cekSp5($post){
		$connection = $this->db;
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$nomor  = htmlspecialchars($post['no_reg_perkara'], ENT_QUOTES);
		$surat 	= htmlspecialchars($post['no_permohonan'], ENT_QUOTES);
		$ptnjk 	= htmlspecialchars($post['petunjuk_jpn'], ENT_QUOTES);
		$sqlCek = "select count(*) from datun.keputusan_telaah where no_register_perkara = '".$nomor."' and no_surat = '".$surat."'";
		$count 	= $connection->createCommand($sqlCek)->queryScalar();
		if($isNew){
			return array("hasil"=>true, "error"=>"", "element"=>"");
		} else{
			$dbData = $connection->createCommand("select petunjuk from datun.s5 where no_register_perkara = '".$nomor."' and no_surat = '".$surat."'")->queryScalar();
			if($count > 0 && ($dbData != $ptnjk)){
				return array("hasil"=>false, "error"=>"", "element"=>"");				
			} else{
				return array("hasil"=>true, "error"=>"", "element"=>"");
			}
		}
	}
	
	public function simpanData($post){
		$connection = Yii::$app->db;

		$isNewRecord			= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_sp1					= htmlspecialchars($post['no_sp1'], ENT_QUOTES);
		$no_surat				= htmlspecialchars($post['no_permohonan'], ENT_QUOTES);
		$no_register_perkara	= htmlspecialchars($post['no_reg_perkara'], ENT_QUOTES);
		$kode_tk				= $_SESSION['kode_tk'];
		$kode_kejati			= $_SESSION['kode_kejati'];
		$kode_kejari			= $_SESSION['kode_kejari'];
		$kode_cabjari			= $_SESSION['kode_cabjari'];

		$tanggal_ttd			= htmlspecialchars($post['tanggal_ttd'], ENT_QUOTES);
		$posisi_kasus_dt		= str_replace(array("'"), array("&#039;"), $post['posisi_data']);
		$posisi_kasus_ft		= str_replace(array("'"), array("&#039;"), $post['posisi_fakta']);
		$permasalahan			= str_replace(array("'"), array("&#039;"), $post['permasalahan']);
		$analisa				= str_replace(array("'"), array("&#039;"), $post['analisa']);		
		$kesimpulan				= str_replace(array("'"), array("&#039;"), $post['kesimpulan']);
		$saran					= str_replace(array("'"), array("&#039;"), $post['saran']);
		$petunjuk				= htmlspecialchars($post['petunjuk_jpn'], ENT_QUOTES);

		$created_user			= $_SESSION['username']; 
		$created_nip			= $_SESSION['nik_user'];
		$created_nama			= $_SESSION['nama_pegawai'];
		$created_ip				= $_SERVER['REMOTE_ADDR'];
		$updated_user			= $_SESSION['username'];  
		$updated_nip			= $_SESSION['nik_user'];
		$updated_nama			= $_SESSION['nama_pegawai']; 
		$updated_ip				= $_SERVER['REMOTE_ADDR'];
		
		$helpernya	= Yii::$app->inspektur;
		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['s5'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_surat);
		$newPhoto 	= "s5_".$clean1."-".$clean2.$extPhoto;
		
		$transaction = $connection->beginTransaction();
		try {
			
			if($isNewRecord){
				$sqlUpdate = "update datun.permohonan set status = 'S5' where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
				$connection->createCommand($sqlUpdate)->execute();
			
				$upl1 = false;
				$sql1 = "insert into datun.s5(no_register_perkara, no_surat, kode_tk, kode_kejati, kode_kejari, kode_cabjari, tanggal_ttd, posisi_kasus_dt, 
						posisi_kasus_ft, permasalahan, analisa, kesimpulan, saran, petunjuk, created_user, created_nip, created_nama, created_ip, created_date, 
						updated_user, updated_nip, updated_nama, updated_ip, updated_date";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_s5";
				}
				$sql1 .= ") values('".$no_register_perkara."', '".$no_surat."', '".$kode_tk."', '".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."', 
						'".$helpernya->tgl_db($tanggal_ttd)."', '".$posisi_kasus_dt."', '".$posisi_kasus_ft."', '".$permasalahan."', '".$analisa."', '".$kesimpulan."', 
						'".$saran."', '".$petunjuk."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), '".$updated_user."', 
						'".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW()";
				
				if($filePhoto != "") $sql1 .= ", '".$newPhoto."'";
				$sql1 .= ")";
			}else{
				$upl1 = false;
				$sql1 = "update datun.s5 set tanggal_ttd = '".$helpernya->tgl_db($tanggal_ttd)."', posisi_kasus_dt = '".$posisi_kasus_dt."', 
						posisi_kasus_ft = '".$posisi_kasus_ft."', permasalahan = '".$permasalahan."', analisa = '".$analisa."', kesimpulan = '".$kesimpulan."', 
						saran = '".$saran."', petunjuk = '".$petunjuk."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', updated_nama = '".$updated_nama."', 
						updated_ip = '".$updated_ip."', updated_date = NOW()";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_s5 = '".$newPhoto."'";
				}
				$sql1 .= " where no_surat = '".$no_surat."' and no_register_perkara = '".$no_register_perkara."'";
			}
			$connection->createCommand($sql1)->execute();
			
			if($upl1){
				$tmpPot = glob($pathfile."s5_".$clean1."-".$clean2.".*");
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
