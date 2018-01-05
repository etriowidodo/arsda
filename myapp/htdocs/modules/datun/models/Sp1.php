<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Session;
use app\components\InspekturComponent;

class Sp1 extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.sp1';
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
		$no_sp1					= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$no_permohonan			= htmlspecialchars($post['npemohon'], ENT_QUOTES);
		$no_register_perkara	= htmlspecialchars($post['noreg'], ENT_QUOTES);
		$ttd_nama				= htmlspecialchars($post['penandatangan_nama'], ENT_QUOTES);
		$ttd_nip				= htmlspecialchars($post['penandatangan_nip'], ENT_QUOTES);
		$ttd_jabatan			= htmlspecialchars($post['penandatangan_jabatan'], ENT_QUOTES);
		$ttd_status				= htmlspecialchars($post['penandatangan_status'], ENT_QUOTES);
		$ttd_gol				= htmlspecialchars($post['penandatangan_gol'], ENT_QUOTES);
		$ttd_pangkat			= htmlspecialchars($post['penandatangan_pangkat'], ENT_QUOTES);
		$ttd_jabatannya			= htmlspecialchars($post['penandatangan_ttdjabat'], ENT_QUOTES);
		$ctgl_ttd				= htmlspecialchars($post['tgldittd'], ENT_QUOTES);
		
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
		$pathfile	= Yii::$app->params['sp1'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_permohonan);
		$newPhoto 	= "sp1_".$clean1."-".$clean2.$extPhoto;
		
		$transaction = $connection->beginTransaction();
		try {
			
			if($isNewRecord){
				$sqlUpdate = "update datun.permohonan set status = 'SP-1' where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_permohonan."'";
				$connection->createCommand($sqlUpdate)->execute();
				
				$upl1 = false;
				$sql1 = "insert into datun.sp1(no_sp1, no_register_perkara, no_surat, kode_tk, kode_kejati, kode_kejari, kode_cabjari, 
						tanggal_ttd, penandatangan_nama, penandatangan_nip, penandatangan_jabatan, created_user, created_nip, created_nama, created_ip, created_date, 
						updated_user, updated_nip, updated_nama, updated_ip, updated_date, penandatangan_status, penandatangan_gol, penandatangan_pangkat, penandatangan_ttdjabat";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_sp1";
				}
				$sql1 .= ") values
						('".$no_sp1."', '".$no_register_perkara."', '".$no_permohonan."', '".$kode_tk."', '".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."', 
						'".$helpernya->tgl_db($ctgl_ttd)."', '".$ttd_nama."', '".$ttd_nip."', '".$ttd_jabatan."', '".$created_user."', '".$created_nip."', '".$created_nama."', 
						'".$created_ip."', NOW(), '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW(), '".$ttd_status."', '".$ttd_gol."', 
						'".$ttd_pangkat."', '".$ttd_jabatannya."'";

				if($filePhoto != "") $sql1 .= ", '".$newPhoto."'";
				$sql1 .= ")";

			}else{
				$upl1 = false;
				$sql1 = "update datun.sp1 set  no_sp1 = '".$no_sp1."', tanggal_ttd = '".$helpernya->tgl_db($ctgl_ttd)."', penandatangan_nama = '".$ttd_nama."', 
						penandatangan_nip = '".$ttd_nip."', penandatangan_jabatan = '".$ttd_jabatan."', penandatangan_status = '".$ttd_status."', 
						penandatangan_gol = '".$ttd_gol."', penandatangan_pangkat = '".$ttd_pangkat."', penandatangan_ttdjabat = '".$ttd_jabatannya."', 
						updated_user = '".$updated_user."', updated_nip = '".$updated_nip."',updated_nama = '".$updated_nama."', 
						updated_ip = '".$updated_ip."', updated_date = NOW()";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_sp1 = '".$newPhoto."'";
				}
				$sql1 .= " where no_surat = '".$no_permohonan."' and no_register_perkara = '".$no_register_perkara."'";
			}
			$connection->createCommand($sql1)->execute();
			
			$asg2 = "delete from datun.sp1_timjpn where no_surat = '".$no_permohonan."' and no_register_perkara = '".$no_register_perkara."'";
			$connection->createCommand($asg2)->execute();
			if(count($post['jpnid']) > 0){
				foreach($post['jpnid'] as $idx=>$val){
					list($nip, $nama, $golpangkat, $gol, $pangkat, $jabatan) = explode("#", $val);
					$sql2 = "insert into datun.sp1_timjpn values('".$nip."', '".$nama."', '".$gol."', '".$pangkat."', '".$jabatan."', '".$no_register_perkara."', 
							'".$no_permohonan."', '".($idx+1)."')";
					$connection->createCommand($sql2)->execute();
				}
			}
				
			$asg3 = "delete from datun.sp1_tembusan where no_surat = '".$no_permohonan."' and no_register_perkara = '".$no_register_perkara."'";
			$connection->createCommand($asg3)->execute();
				
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql3 = "insert into datun.sp1_tembusan values('".$noauto."', '".$nama_tembusan."', '".$no_register_perkara."', '".$no_permohonan."')";
						$connection->createCommand($sql3)->execute();
					}
				}
			}
			
			if($upl1){
				$tmpPot = glob($pathfile."sp1_".$clean1."-".$clean2.".*");
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