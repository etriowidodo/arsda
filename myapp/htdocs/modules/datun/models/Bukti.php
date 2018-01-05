<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\HtmlPurifier;
use app\components\InspekturComponent;


class Bukti extends \yii\db\ActiveRecord{

    public static function tableName(){
        return 'datun.s19a';
    }
	
	public function simpanData($post){
		$connection = Yii::$app->db;
		$helpernya	= Yii::$app->inspektur;
		$isNewRecord = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_surat 			= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$no_register_skk 	= htmlspecialchars($post['no_skk'], ENT_QUOTES);
		$tanggal_skk 		= htmlspecialchars($post['tanggal_skk'], ENT_QUOTES);
		$no_register_skks 	= htmlspecialchars($post['no_skks'], ENT_QUOTES);
		$no_register_perkara = htmlspecialchars($post['no_reg'], ENT_QUOTES);

		$tanggal_s19a 	= htmlspecialchars($post['tgl_s19a'], ENT_QUOTES);
		$kepada_yth		= htmlspecialchars($post['isi'], ENT_QUOTES);
		$tempat			= htmlspecialchars($post['tempat'], ENT_QUOTES);
		
		$kode_tk		= $_SESSION['kode_tk'];
		$kode_kejati	= $_SESSION['kode_kejati'];
		$kode_kejari	= $_SESSION['kode_kejari'];
		$kode_cabjari	= $_SESSION['kode_cabjari'];
		$created_user 	= $_SESSION['username'];
		$created_nip	= $_SESSION['nik_user'];
		$created_nama	= $_SESSION['nama_pegawai'];
		$created_ip 	= $_SERVER['REMOTE_ADDR'];
		$updated_user 	= $_SESSION['username'];
		$updated_nip 	= $_SESSION['nik_user'];
		$updated_nama 	= $_SESSION['nama_pegawai'];
		$updated_ip 	= $_SERVER['REMOTE_ADDR'];

		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['s19a'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_skk);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_skk);
		$newPhoto 	= "s19a_".$clean1."-".$clean2.$extPhoto;

		$transaction = $connection->beginTransaction();
		try {
			$sqlUpdate = "UPDATE datun.permohonan set status='KESIMPULAN (S-22)' WHERE no_register_perkara='$no_register_perkara' and no_surat='$no_surat' ";
			$connection->createCommand($sqlUpdate)->execute();
			if($isNewRecord){
				if($filePhoto != ""){
					$upl1 = true;
					$newPhoto = $newPhoto;
				} else{
					$upl1 = false;
					$newPhoto = "";
				}
				$sql1 = "insert into datun.s19a(kode_tk, kode_kejati, kode_kejari, kode_cabjari, no_surat, no_register_perkara, no_register_skk, tanggal_skk, no_register_skks, 
						 tanggal_s19a, kepada_yth, tempat, file_s19a, created_user, created_nip, created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, 
						 updated_ip, updated_date) values('".$kode_tk."', '".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."', '".$no_surat."', '".$no_register_perkara."', 
						 '".$no_register_skk."', '".$helpernya->tgl_db($tanggal_skk)."', '".$no_register_skks."', '".$helpernya->tgl_db($tanggal_s19a)."', '".$kepada_yth."',
						 '".$tempat."', '".$newPhoto."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			} else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_s19a = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update datun.s19a set tanggal_s19a = '".$helpernya->tgl_db($tanggal_s19a)."', kepada_yth = '".$kepada_yth."', 
						 tempat = '".$tempat."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
			}
			$connection->createCommand($sql1)->execute();
			
			$sql2 = "delete from datun.bukti_tertulis where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['no_tergugat']) > 0){
				foreach($post['no_tergugat'] as $idx=>$val){
					$kode_bukti		= htmlspecialchars($post['no_tergugat'][$idx], ENT_QUOTES);
					$jenis_bukti	= htmlspecialchars($post['jenis_bukti'][$idx], ENT_QUOTES);
					$keterangan		= htmlspecialchars($post['keterangan'][$idx], ENT_QUOTES);
					$penjelasan		= str_replace(array("'"), array("&#039;"), $post['penjelasan'][$idx]);
					$sql3 = "insert into datun.bukti_tertulis(no_surat, no_register_perkara, kode_bukti, jenis_bukti, keterangan, penjelasan) values('".$no_surat."', 
							'".$no_register_perkara."', '".$kode_bukti."', '".$jenis_bukti."', '".$keterangan."', '".$penjelasan."')";
					$connection->createCommand($sql3)->execute();
				}
			}	
			
			if($upl1){
				$tmpPot = glob($pathfile."s19a_".$clean1."-".$clean2.".*");
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
		} catch(\Exception $e) {
			$transaction->rollBack();
			throw $e; exit();
			return false;
		}
	}

}