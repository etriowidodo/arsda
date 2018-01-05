<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Session;
use app\components\InspekturComponent;

class S24 extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.s24';
    }
	
    public function cekS24($post){ 
		$connection = $this->db;
		$isNew 	                = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_putusan             = htmlspecialchars($post['no_putusan'], ENT_QUOTES);
		$no_register_perkara 	= htmlspecialchars($post['no_register_perkara'], ENT_QUOTES);
		$no_register_skks 	    = htmlspecialchars($post['no_register_skks'], ENT_QUOTES);
		$nomor			 	    = htmlspecialchars($post['nomor'], ENT_QUOTES);
			
		if($isNew){
			$sqlCek = "select count(*) from datun.s24 where kode_tk = '".$_SESSION['kode_tk']."' and kode_kejati = '".$_SESSION['kode_kejati']."' 
				   and kode_kejari = '".$_SESSION['kode_kejari']."' and kode_cabjari = '".$_SESSION['kode_cabjari']."' and nomor = '".$nomor."'";
			$count 	= $connection->createCommand($sqlCek)->queryScalar();
			if($count > 0){
				$pesan = '<i style="color:#dd4b39; font-size:12px;">Nomor <b>'.$nomor.'</b> sudah ada</i>';
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

		$isNewRecord			= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$nomor					= htmlspecialchars($post['nomor'], ENT_QUOTES);
		$no_register_skks		= htmlspecialchars($post['no_register_skks'], ENT_QUOTES);
		$no_register_perkara	= htmlspecialchars($post['no_register_perkara'], ENT_QUOTES);
		$no_surat				= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$kode_jenis_instansi	= htmlspecialchars($post['kode_jenis_instansi'], ENT_QUOTES);
		$kode_instansi			= htmlspecialchars($post['kode_instansi'], ENT_QUOTES);
		$no_register_skks		= htmlspecialchars($post['no_register_skks'], ENT_QUOTES);
		$no_putusan				= htmlspecialchars($post['no_putusan'], ENT_QUOTES);
		$tanggal_putusan		= htmlspecialchars($post['tanggal_putusan'], ENT_QUOTES);
		$perihal				= htmlspecialchars($post['perihal'], ENT_QUOTES);
		$tanggal_s24			= htmlspecialchars($post['tanggal_s24'], ENT_QUOTES); 
		$kepada_yth_s24			= htmlspecialchars($post['kepada_yth'], ENT_QUOTES);
		$di_s24					= htmlspecialchars($post['di_s24'], ENT_QUOTES); 
		$alasan_penundaan_s24	= str_replace(array("'"), array("&#039;"), $post['tab_alasan']);
		
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
		$pathfile	= Yii::$app->params['s24'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($nomor);
		$newPhoto 	= "s24_".$clean1."-".$clean2.$extPhoto;
		
		$filePhoto2 	= htmlspecialchars($_FILES['file_template2']['name'],ENT_QUOTES);
		$sizePhoto2 	= htmlspecialchars($_FILES['file_template2']['size'],ENT_QUOTES);
		$tempPhoto2 	= htmlspecialchars($_FILES['file_template2']['tmp_name'],ENT_QUOTES);
		$extPhoto2 	= substr($filePhoto2,strrpos($filePhoto2,'.'));
		$max_size2	= 2 * 1024 * 1024;
		$allow_type2	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile2	= Yii::$app->params['s24_putusan'];
		$clean12 	= Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean22 	= Yii::$app->inspektur->sanitize_filename($nomor);
		$newPhoto2 	= "s24_putusan_".$clean12."-".$clean22.$extPhoto2;
		
		$transaction = $connection->beginTransaction();
		try {
			
			$sqlUpdate = "update datun.permohonan set status = 'S24' where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
			$connection->createCommand($sqlUpdate)->execute();
			
			if($isNewRecord){
				$upl1 = false;
				$upl2 = false;
				$sql1 = "insert into datun.s24(no_register_skks, no_putusan, tanggal_putusan, tanggal_s24, no_register_perkara, kode_jenis_instansi, kode_instansi, kode_tk, 
						kode_kejati, kode_kejari, kode_cabjari, di_s24, kepada_yth_s24, perihal, amar_putusan, alasan_penundaan_s24, nomor,
						created_user, created_nip, created_nama, created_ip,created_date, 
						updated_user, updated_nip, updated_nama, updated_date, updated_ip";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_s24";
				}
				if($filePhoto2 != ""){
					$upl2 = true;
					$sql1 .= ", file_s24_putusan ";
				}
				$sql1 .= ") values
						('".$no_register_skks."', '".$no_putusan."', '".$helpernya->tgl_db($tanggal_putusan)."', '".$helpernya->tgl_db($tanggal_s24)."', '".$no_register_perkara."', '".$kode_jenis_instansi."', '".$kode_instansi."', '".$kode_tk."', 
						'".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."', '".$di_s24."', '".$kepada_yth_s24."', '".$perihal."', '', '".$alasan_penundaan_s24."','".$nomor."',
						'".$created_user."', '".$created_nip."', '".$created_nama."','".$created_ip."', NOW(), 
						'".$updated_user."', '".$updated_nip."', '".$updated_nama."', NOW(), '".$updated_ip."'";

				if($filePhoto != "") $sql1 .= ", '".$newPhoto."'";
				if($filePhoto2 != "") $sql1 .= ", '".$newPhoto2."'";
				$sql1 .= ")";

			}else{
				$upl1 = false;
				$upl2 = false;
				$sql1 = "update datun.s24 set  perihal = '".$perihal."', kepada_yth_s24 = '".$kepada_yth_s24."', 
						di_s24 = '".$di_s24."', alasan_penundaan_s24 = '".$alasan_penundaan_s24."', amar_putusan = '', 
						updated_user = '".$updated_user."', updated_nip = '".$updated_nip."',updated_nama = '".$updated_nama."', tanggal_s24='".$helpernya->tgl_db($tanggal_s24)."',
						updated_ip = '".$updated_ip."', updated_date = NOW()";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_s24 = '".$newPhoto."'";
				}
				if($filePhoto2 != ""){
					$upl2 = true;
					$sql1 .= ", file_s24_putusan = '".$newPhoto2."'";
				}
				$sql1 .= " where nomor = '".$nomor."' and no_register_perkara = '".$no_register_perkara."' and no_putusan = '".$no_putusan."' and no_register_skks = '".$no_register_skks."' and tanggal_putusan = '".$helpernya->tgl_db($tanggal_putusan)."'
						and tanggal_s24 = '".$helpernya->tgl_db($tanggal_s24)."'";
			}
			$connection->createCommand($sql1)->execute();
			
			$asg3 = "delete from datun.s24_tembusan where nomor = '".$nomor."' and no_register_perkara = '".$no_register_perkara."' and no_putusan = '".$no_putusan."' and no_register_skks = '".$no_register_skks."' and tanggal_putusan = '".$helpernya->tgl_db($tanggal_putusan)."'
					and tanggal_s24 = '".$helpernya->tgl_db($tanggal_s24)."'";
			$connection->createCommand($asg3)->execute();
				
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						//$sql3 = "insert into datun.s24_tembusan values('".$noauto."', '".$nama_tembusan."', '".$no_register_perkara."', '".$nomor."', '".$no_putusan."')";
						$sql3 = "insert into datun.s24_tembusan values('".$no_putusan."', '".$helpernya->tgl_db($tanggal_putusan)."', '".$nomor."', '".$helpernya->tgl_db($tanggal_s24)."'
								, '".$no_register_skks."', '".$no_register_perkara."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql3)->execute();
					}
				}
			}
			
			if($upl1){
				$tmpPot = glob($pathfile."s24_".$clean1."-".$clean2.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto;
				$mantab  = move_uploaded_file($tempPhoto, $tujuan);
				if(file_exists($tempPhoto)) unlink($tempPhoto);
			}
			
			if($upl2){
				$tmpPot2 = glob($pathfile2."s24_putusan_".$clean12."-".$clean22.".*");
				if(count($tmpPot2) > 0){
					foreach($tmpPot2 as $datj2)
						if(file_exists($datj2)) unlink($datj2);
				}
				$tujuan2  = $pathfile2.$newPhoto2;
				$mantab  = move_uploaded_file($tempPhoto2, $tujuan2);
				if(file_exists($tempPhoto2)) unlink($tempPhoto2);
			}
			
			$transaction->commit();
			return true;
			
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }
	
}