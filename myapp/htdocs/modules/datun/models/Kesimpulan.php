<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\HtmlPurifier;
use app\components\InspekturComponent;


class Kesimpulan extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'datun.s22';
    }
	
	public function simpanData($post){
		$helpernya		= Yii::$app->inspektur;
		$connection 	= Yii::$app->db;
		$isNewRecord	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_permohonan			= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$no_register_perkara	= htmlspecialchars($post['no_reg'], ENT_QUOTES);
		$no_skk					= htmlspecialchars($post['no_skk'], ENT_QUOTES);
		$tgl_skk				= htmlspecialchars($post['tanggal_skk'], ENT_QUOTES);
		
		$no_register_skks		= htmlspecialchars($post['no_skks'], ENT_QUOTES);
		$tgl_kesimpulan			= htmlspecialchars($post['tgl_kesimpulan'], ENT_QUOTES);
		$file_kesimpulan		= htmlspecialchars($post['file_kesimpulan'], ENT_QUOTES);
		$penggugat				= htmlspecialchars($post['penggugat'], ENT_QUOTES);
		$kuasa_penggugat		= htmlspecialchars($post['kuasa_penggugat'], ENT_QUOTES);
		$yth					= htmlspecialchars($post['isi'], ENT_QUOTES);
		$tempat					= htmlspecialchars($post['tempat'], ENT_QUOTES);
		
		$pokok					= str_replace(array("'"), array("&#039;"), $post['pokok']);
		$tanggapan				= str_replace(array("'"), array("&#039;"), $post['tanggapan']);
		$penjelasan				= str_replace(array("'"), array("&#039;"), $post['penjelasan']);
		$kesimpulan				= str_replace(array("'"), array("&#039;"), $post['kesimpulan']);
		
		$eksepsi				= str_replace(array("'"), array("&#039;"), $post['eksepsi']);
		$provisi				= str_replace(array("'"), array("&#039;"), $post['provisi']);
		$perkara				= str_replace(array("'"), array("&#039;"), $post['perkara']);
		$rekonpensi				= str_replace(array("'"), array("&#039;"), $post['rekonpensi']);
		$konpensi				= str_replace(array("'"), array("&#039;"), $post['konpensi']);
		
		$subsidair				= str_replace(array("'"), array("&#039;"), $post['subsidair']);
		
		$kode_tk				= $_SESSION['kode_tk'];
		$kode_kejati			= $_SESSION['kode_kejati'];
		$kode_kejari			= $_SESSION['kode_kejari'];
		$kode_cabjari			= $_SESSION['kode_cabjari'];
		$create_user			= $_SESSION['username']; 
		$create_nip				= $_SESSION['nik_user'];
		$create_nama			= $_SESSION['nama_pegawai'];
		$create_ip				= $_SERVER['REMOTE_ADDR'];
		$update_user			= $_SESSION['username'];  
		$update_nip				= $_SESSION['nik_user'];
		$update_nama			= $_SESSION['nama_pegawai']; 
		$update_ip				= $_SERVER['REMOTE_ADDR'];
		
		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['s22'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_skk);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_skk);
		$newPhoto 	= "kesimpulan_".$clean1."-".$clean2.$extPhoto;
		
		$transaction = $connection->beginTransaction();
		try {
			
			if($isNewRecord){
				$sqlUpdate = "UPDATE datun.permohonan set status='KESIMPULAN (S-22)' WHERE no_register_perkara='$no_register_perkara' and no_surat='$no_permohonan'";
				$connection->createCommand($sqlUpdate)->execute();
			
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 = "insert into datun.s22
							(no_register_skk,no_register_perkara,no_surat,tanggal_skk,tanggal_s22,
							file_s22,kode_tk,kode_kejati,kode_kejari,kode_cabjari,
							kepada_yth,tempat,hal_pokok,tanggapan,penjelasan_alatbukti,kesimpulan,
							prim_eksepsi,prim_provisi,prim_pokokperkara,prim_rekonvensi,prim_konvensi_rekonvensi,prim_subsidair,
							created_user,created_nip,created_nama,created_ip,created_date,
							updated_user,updated_nip,updated_nama,updated_ip,updated_date,no_register_skks) 
							
							values
							
							('$no_skk','$no_register_perkara','$no_permohonan','".$helpernya->tgl_db($tgl_skk)."','".$helpernya->tgl_db($tgl_kesimpulan)."',
							'$newPhoto','$kode_tk','$kode_kejati','$kode_kejari','$kode_cabjari',
							'$yth','$tempat','$pokok','$tanggapan','$penjelasan','$kesimpulan',
							'$eksepsi','$provisi','$perkara','$rekonpensi','$konpensi','$subsidair',
							'$create_user','$create_nip','$create_nama','$create_ip',now(),
							'$update_user','$update_nip','$update_nama','$update_ip',now(),'$no_register_skks')";
				} else{
					$upl1 = false;
					$sql1 = "insert into datun.s22
							(no_register_skk,no_register_perkara,no_surat,tanggal_skk,tanggal_s22,
							kode_tk,kode_kejati,kode_kejari,kode_cabjari,
							kepada_yth,tempat,hal_pokok,tanggapan,penjelasan_alatbukti,kesimpulan,
							prim_eksepsi,prim_provisi,prim_pokokperkara,prim_rekonvensi,prim_konvensi_rekonvensi,prim_subsidair,
							created_user,created_nip,created_nama,created_ip,created_date,
							updated_user,updated_nip,updated_nama,updated_ip,updated_date,no_register_skks) 
							
							values
							
							('$no_skk','$no_register_perkara','$no_permohonan','".$helpernya->tgl_db($tgl_skk)."','".$helpernya->tgl_db($tgl_kesimpulan)."',
							'$kode_tk','$kode_kejati','$kode_kejari','$kode_cabjari',
							'$yth','$tempat','$pokok','$tanggapan','$penjelasan','$kesimpulan',
							'$eksepsi','$provisi','$perkara','$rekonpensi','$konpensi','$subsidair',
							'$create_user','$create_nip','$create_nama','$create_ip',now(),
							'$update_user','$update_nip','$update_nama','$update_ip',now(),'$no_register_skks')";
				}
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 = "UPDATE datun.s22 set tanggal_s22='".$helpernya->tgl_db($tgl_kesimpulan)."',file_s22='$newPhoto',
							kepada_yth='$yth',tempat='$tempat',hal_pokok='$pokok',tanggapan='$tanggapan',penjelasan_alatbukti='$penjelasan',kesimpulan='$kesimpulan',
							prim_eksepsi='$eksepsi',prim_provisi='$provisi',prim_pokokperkara='$perkara',prim_rekonvensi='$rekonpensi',prim_konvensi_rekonvensi='$konpensi',prim_subsidair='$subsidair',
							updated_user='$update_user',updated_nip='$update_nip',updated_nama='$update_nama',
							updated_ip='$update_ip',updated_date=now()
							WHERE no_surat='$no_permohonan' and no_register_perkara='$no_register_perkara'";
				} else{
					$upl1 = false;
					$sql1 = "UPDATE datun.s22 set tanggal_s22='".$helpernya->tgl_db($tgl_kesimpulan)."',
							kepada_yth='$yth',tempat='$tempat',hal_pokok='$pokok',tanggapan='$tanggapan',penjelasan_alatbukti='$penjelasan',kesimpulan='$kesimpulan',
							prim_eksepsi='$eksepsi',prim_provisi='$provisi',prim_pokokperkara='$perkara',prim_rekonvensi='$rekonpensi',prim_konvensi_rekonvensi='$konpensi',prim_subsidair='$subsidair',
							updated_user='$update_user',updated_nip='$update_nip',updated_nama='$update_nama',
							updated_ip='$update_ip',updated_date=now()
							WHERE no_surat='$no_permohonan' and no_register_perkara='$no_register_perkara'";
				}
			}
		$connection->createCommand($sql1)->execute();
		if($upl1){
			$tmpPot = glob($pathfile."kesimpulan_".$clean1."-".$clean2.".*");
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