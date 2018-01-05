<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Session;
use app\components\InspekturComponent;

class S25 extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.s25';
    }
	
    public function cekSp1($post){
		$connection = $this->db;
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$nomor  = htmlspecialchars($post['noreg'], ENT_QUOTES);
		$surat 	= htmlspecialchars($post['npemohon'], ENT_QUOTES);
		$sp1 	= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$dbSp1 	= $connection->createCommand("select no_sp1 from datun.sp1 where no_register_perkara = '".$nomor."' and no_surat = '".$surat."'")->queryScalar();
		$sqlCek = "select count(*) from datun.sp1 where kode_tk = '".$_SESSION['kode_tk']."' and kode_kejati = '".$_SESSION['kode_kejati']."' 
				   and kode_kejari = '".$_SESSION['kode_kejari']."' and kode_cabjari = '".$_SESSION['kode_cabjari']."' and no_sp1 = '".$sp1."'";
		$count 	= ($sp1 != $dbSp1)?$connection->createCommand($sqlCek)->queryScalar():0;
		if($count > 0){
			$pesan = '<i style="color:#dd4b39; font-size:12px;">No SP1 sudah ada</i>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom4");
		} else{
			return array("hasil"=>true, "error"=>"", "element"=>"");
		}
	}
	
	public function simpanData($post){
		$connection = Yii::$app->db;

		$isNewRecord			= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_register_perkara	= htmlspecialchars($post['no_register_perkara'], ENT_QUOTES);
		$no_register_skk		= htmlspecialchars($post['no_skk'], ENT_QUOTES);
		$tanggal_skk			= htmlspecialchars($post['tanggal_skk'], ENT_QUOTES);
		$no_register_skks		= htmlspecialchars($post['no_skks'], ENT_QUOTES);
		$tanggal_s25			= htmlspecialchars($post['tanggal_s25'], ENT_QUOTES);
		$no_putusan				= $no_register_perkara;
		$tanggal_putusan		= htmlspecialchars($post['tanggal_putusan'], ENT_QUOTES);
		$no_surat				= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$kode_jenis_instansi	= htmlspecialchars($post['kode_jenis_instansi'], ENT_QUOTES);
		$kode_instansi			= htmlspecialchars($post['kode_instansi'], ENT_QUOTES);
		$kepada_yth_s25			= htmlspecialchars($post['kepada_yth_s25'], ENT_QUOTES);
		$di_s25					= htmlspecialchars($post['di_s25'], ENT_QUOTES); 
		$alasan_banding			= str_replace(array("'"), array("&#039;"), $post['tab_alasan']);
		$isi_petitum_primer		= str_replace(array("'"), array("&#039;"), $post['tab_primair']);		
		$isi_petitum_subsider	= str_replace(array("'"), array("&#039;"), $post['tab_subsidair']);
		$melalui				= htmlspecialchars($post['melalui'], ENT_QUOTES);
		$no_permohonan_banding	= htmlspecialchars($post['no_permohonan_banding'], ENT_QUOTES);		
		$tgl_permohonan_banding	= htmlspecialchars($post['tgl_permohonan_banding'], ENT_QUOTES);
		$isInkrah				= htmlspecialchars($post['inkrah'], ENT_QUOTES);
		
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
		$pathfile	= Yii::$app->params['s25'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_register_skks);
		$newPhoto 	= "s25_".$clean1."-".$clean2.$extPhoto;
		
		$filePhoto2 	= htmlspecialchars($_FILES['file_template2']['name'],ENT_QUOTES);
		$sizePhoto2 	= htmlspecialchars($_FILES['file_template2']['size'],ENT_QUOTES);
		$tempPhoto2 	= htmlspecialchars($_FILES['file_template2']['tmp_name'],ENT_QUOTES);
		$extPhoto2 	= substr($filePhoto2,strrpos($filePhoto2,'.'));
		$max_size2	= 2 * 1024 * 1024;
		$allow_type2	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile2	= Yii::$app->params['permohonan_banding'];
		$clean12 	= Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean22 	= Yii::$app->inspektur->sanitize_filename($no_permohonan_banding);
		$newPhoto2 	= "p_banding".$clean12."-".$clean22.$extPhoto2;
		
		$filePhoto3 	= htmlspecialchars($_FILES['file_template3']['name'],ENT_QUOTES);
		$sizePhoto3 	= htmlspecialchars($_FILES['file_template3']['size'],ENT_QUOTES);
		$tempPhoto3 	= htmlspecialchars($_FILES['file_template3']['tmp_name'],ENT_QUOTES);
		$extPhoto3 	= substr($filePhoto3,strrpos($filePhoto3,'.'));
		$max_size3	= 2 * 1024 * 1024;
		$allow_type3	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile3	= Yii::$app->params['relas_s25'];
		$clean13 	= Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean23 	= Yii::$app->inspektur->sanitize_filename($no_register_skks);
		$newPhoto3 	= "relas_s25_".$clean13."-".$clean23.$extPhoto3;
		
		$transaction = $connection->beginTransaction();
		try {
			
			if($isNewRecord){
				$sqlUpdate = "update datun.permohonan set status = 'S25' where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
				$connection->createCommand($sqlUpdate)->execute();
				
				$upl1 = false;
				$upl2 = false;
				$upl3 = false;
				$sql1 = "insert into datun.s25(no_register_skks, no_putusan, no_register_perkara, kode_jenis_instansi, kode_instansi, kode_tk, 
						kode_kejati, kode_kejari, kode_cabjari, di_s25, kepada_yth_s25, nama_jpn, alasan_banding, isi_petitum_primer, isi_petitum_subsider,
						melalui,no_permohonan_banding,
						created_user, created_nip, created_nama, created_ip,created_date, 
						updated_user, updated_nip, updated_nama, updated_date, updated_ip, no_register_skk, tanggal_skk, is_inkrah, no_surat";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_s25";
				}
				if($filePhoto2 != ""){
					$upl2 = true;
					$sql1 .= ", file_permohonan_banding ";
				}
				if($filePhoto3 != ""){
					$upl3 = true;
					$sql1 .= ", file_akta_penyerahan_banding ";
				}
				if ($tanggal_s25) $sql1 .=", tanggal_s25";
				if ($tgl_permohonan_banding) $sql1 .=", tgl_permohonan_banding";
				if ($tanggal_putusan) $sql1 .=", tanggal_putusan";
				
				$sql1 .= ") values
						('".$no_register_skks."', '".$no_putusan."', '".$no_register_perkara."', '".$kode_jenis_instansi."', '".$kode_instansi."', '".$kode_tk."', 
						'".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."', '".$di_s25."', '".$kepada_yth_s25."', '', '".$alasan_banding."', '".$isi_petitum_primer."','".$isi_petitum_subsider."',
						'".$melalui."', '".$no_permohonan_banding."',  
						'".$created_user."', '".$created_nip."', '".$created_nama."','".$created_ip."', NOW(), 
						'".$updated_user."', '".$updated_nip."', '".$updated_nama."', NOW(), '".$updated_ip."','".$no_register_skk."', '".$helpernya->tgl_db($tanggal_skk)."','".$isInkrah."','".$no_surat."'";

				if($filePhoto != "") $sql1 .= ", '".$newPhoto."'";
				if($filePhoto2 != "") $sql1 .= ", '".$newPhoto2."'";
				if($filePhoto3 != "") $sql1 .= ", '".$newPhoto3."'";
				if ($tanggal_s25) $sql1 .=", '".$helpernya->tgl_db($tanggal_s25)."'";
				if ($tgl_permohonan_banding) $sql1 .=", '".$helpernya->tgl_db($tgl_permohonan_banding)."'";
				if ($tanggal_putusan) $sql1 .=", '".$helpernya->tgl_db($tanggal_putusan)."'";
				$sql1 .= ")";

			}else{
				$upl1 = false;
				$upl2 = false;
				$upl3 = false;
				$sql1 = "update datun.s25 set  di_s25 = '".$di_s25."', kepada_yth_s25 = '".$kepada_yth_s25."', melalui = '".$melalui."', is_inkrah = '".$isInkrah."', no_permohonan_banding = '".$no_permohonan_banding."',  
						alasan_banding = '".$alasan_banding."', isi_petitum_primer = '".$isi_petitum_primer."', isi_petitum_subsider = '".$isi_petitum_subsider."', 
						updated_user = '".$updated_user."', updated_nip = '".$updated_nip."',updated_nama = '".$updated_nama."', 
						updated_ip = '".$updated_ip."', updated_date = NOW()";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_s25 = '".$newPhoto."'";
				}
				if($filePhoto2 != ""){
					$upl2 = true;
					$sql1 .= ", file_permohonan_banding = '".$newPhoto2."'";
				}
				if($filePhoto3 != ""){
					$upl3 = true;
					$sql1 .= ", file_akta_penyerahan_banding = '".$newPhoto3."'";
				} 
				if ($tanggal_s25) {
					$sql1 .=", tanggal_s25 = '".$helpernya->tgl_db($tanggal_s25)."'";
				} else {
					$sql1 .=", tanggal_s25 = NULL";
				}
				if ($tgl_permohonan_banding) {
					$sql1 .=", tgl_permohonan_banding = '".$helpernya->tgl_db($tgl_permohonan_banding)."'";
				} else {
					$sql1 .=", tgl_permohonan_banding = NULL";
				}
				if ($tanggal_putusan) {
					$sql1 .=", tanggal_putusan = '".$helpernya->tgl_db($tanggal_putusan)."'";
				} else {
					$sql1 .=", tanggal_putusan = NULL";
				}
				$sql1 .= " where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
			}
			$connection->createCommand($sql1)->execute();
			
			$asg2 = "delete from datun.s25_anak where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
			$connection->createCommand($asg2)->execute();
			if(count($post['jpnid']) > 0){
				foreach($post['jpnid'] as $idx=>$val){
					list($nip, $nama, $golpangkat, $gol, $pangkat, $jabatan) = explode("#", $val);
					$sql2 = "insert into datun.s25_anak (nip,nama,jabatan,pangkat, golongan,no_register_perkara,no_surat)
							values('".$nip."', '".$nama."', '".$jabatan."','".$pangkat."','".$gol."', '".$no_register_perkara."', '".$no_surat."')";
					$connection->createCommand($sql2)->execute();
				}
			}
					
			if($upl1){
				$tmpPot = glob($pathfile."s25_".$clean1."-".$clean2.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto;
				$mantab  = move_uploaded_file($tempPhoto, $tujuan);
				if(file_exists($tempPhoto)) unlink($tempPhoto);
			}
			
			if($upl2){
				$tmpPot2 = glob($pathfile2."p_banding".$clean12."-".$clean22.".*");
				if(count($tmpPot2) > 0){
					foreach($tmpPot2 as $datj2)
						if(file_exists($datj2)) unlink($datj2);
				}
				$tujuan2  = $pathfile2.$newPhoto2;
				$mantab  = move_uploaded_file($tempPhoto2, $tujuan2);
				if(file_exists($tempPhoto2)) unlink($tempPhoto2);
			}	
			if($upl3){
				$tmpPot3 = glob($pathfile3."relas_s25_".$clean13."-".$clean23.".*");
				if(count($tmpPot3) > 0){
					foreach($tmpPot3 as $datj3)
						if(file_exists($datj3)) unlink($datj3);
				}
				$tujuan3  = $pathfile3.$newPhoto3;
				$mantab  = move_uploaded_file($tempPhoto3, $tujuan3);
				if(file_exists($tempPhoto3)) unlink($tempPhoto3);
			}
			$transaction->commit();
			return true; 
			
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }
	
}