<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Session;
use app\components\InspekturComponent;

class LaporanPrincipal extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.prinsipal_utama';
    }
	
   	public function cekLapPrinsipal($post){
		$connection 		= $this->db;
		$isNew 	        	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$nomor_prinsipal  	= htmlspecialchars($post['nomor_prinsipal'], ENT_QUOTES);
		if($isNew){
			$sqlCek = "select count(*) from datun.prinsipal_utama where kode_tk = '".$_SESSION['kode_tk']."' and kode_kejati = '".$_SESSION['kode_kejati']."' 
				   and kode_kejari = '".$_SESSION['kode_kejari']."' and kode_cabjari = '".$_SESSION['kode_cabjari']."' and nomor_prinsipal = '".$nomor_prinsipal."'";
			$count 	= $connection->createCommand($sqlCek)->queryScalar();
			if($count > 0){
				$pesan = '<i style="color:#dd4b39; font-size:12px;">No prinsipal <b>'.$nomor_prinsipal.'</b> sudah ada</i>';
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
		$no_register_skk		= htmlspecialchars($post['no_skk'], ENT_QUOTES);
		$tanggal_skk			= htmlspecialchars($post['tanggal_skk'], ENT_QUOTES);
		$no_register_skks		= htmlspecialchars($post['no_skks'], ENT_QUOTES);
		$nomor_prinsipal		= htmlspecialchars($post['nomor_prinsipal'], ENT_QUOTES);
				
		$no_surat				= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$no_register_perkara	= htmlspecialchars($post['no_register_perkara'], ENT_QUOTES);
		$no_putusan				= $no_register_perkara;
		$tanggal_putusan		= htmlspecialchars($post['tanggal_putusan'], ENT_QUOTES);
		$kode_jenis_instansi	= htmlspecialchars($post['kode_jenis_instansi'], ENT_QUOTES);
		$kode_instansi			= htmlspecialchars($post['kode_instansi'], ENT_QUOTES);
		$tanggal_prinsipal		= htmlspecialchars($post['tanggal_prinsipal'], ENT_QUOTES);
		$kepada_yth				= htmlspecialchars($post['kepada'], ENT_QUOTES);
		$di						= htmlspecialchars($post['di'], ENT_QUOTES);
		$sifat					= htmlspecialchars($post['sifat'], ENT_QUOTES);
		$lampiran				= htmlspecialchars($post['lampiran'], ENT_QUOTES); 
		$perihal				= htmlspecialchars($post['perihal'], ENT_QUOTES); 
		$pihak					= str_replace(array("'"), array("&#039;"), $post['tab_para']); 
		$kasus_posisi			= str_replace(array("'"), array("&#039;"), $post['tab_kasus']); 
		$penanganan_perkara		= str_replace(array("'"), array("&#039;"), $post['tab_penanganan']); 
		$resume					= str_replace(array("'"), array("&#039;"), $post['tab_resume']); 
		$isInkrah				= htmlspecialchars($post['inkrah'], ENT_QUOTES);
		
		$ttd_nama				= htmlspecialchars($post['penandatangan_nama'], ENT_QUOTES);
		$ttd_nip				= htmlspecialchars($post['penandatangan_nip'], ENT_QUOTES);
		$ttd_jabatan			= htmlspecialchars($post['penandatangan_jabatan'], ENT_QUOTES);
		$ttd_status				= htmlspecialchars($post['penandatangan_status'], ENT_QUOTES);
		$ttd_gol				= htmlspecialchars($post['penandatangan_gol'], ENT_QUOTES);
		$ttd_pangkat			= htmlspecialchars($post['penandatangan_pangkat'], ENT_QUOTES);
		$ttd_jabatannya			= htmlspecialchars($post['penandatangan_ttdjabat'], ENT_QUOTES);
		
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
		$pathfile	= Yii::$app->params['laporan_prinsipal'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_register_skks);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_putusan);
		$newPhoto 	= "laporan_prinsipal_".$clean1."-".$clean2.$extPhoto;
		
		$transaction = $connection->beginTransaction();
		try {
			
			if($isNewRecord){
				$sqlUpdate = "update datun.permohonan set status = 'LAPORAN PRINSIPAL' where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
				$connection->createCommand($sqlUpdate)->execute();
			
				$upl1 = false;
				$upl2 = false;
				$upl3 = false;
				$sql1 = "insert into datun.prinsipal_utama(no_register_skks, no_putusan, no_register_perkara, kode_jenis_instansi, kode_instansi, kode_tk, 
						kode_kejati, kode_kejari, kode_cabjari, nomor_prinsipal, di, kepada_yth, sifat, lampiran, perihal, pihak, kasus_posisi, penanganan_perkara, resume,
						created_user, created_nip, created_nama, created_ip,created_date, 
						updated_user, updated_nip, updated_nama, updated_date, updated_ip,
						penandatangan_nama, penandatangan_nip, penandatangan_jabatan, penandatangan_status, penandatangan_gol, penandatangan_pangkat, penandatangan_ttdjabat, no_register_skk, tanggal_skk, is_inkrah, no_surat";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_prinsipal";
				}
				if ($tanggal_prinsipal) $sql1 .=", tanggal_prinsipal";
				if ($tanggal_putusan) $sql1 .=", tanggal_putusan";
				
				$sql1 .= ") values
						('".$no_register_skks."', '".$no_putusan."', '".$no_register_perkara."', '".$kode_jenis_instansi."', '".$kode_instansi."', '".$kode_tk."', 
						'".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."', '".$nomor_prinsipal."', '".$di."', '".$kepada_yth."', '".$sifat."','".$lampiran."', '".$perihal."', '".$pihak."','".$kasus_posisi."', '".$penanganan_perkara."','".$resume."',
						'".$created_user."', '".$created_nip."', '".$created_nama."','".$created_ip."', NOW(), 
						'".$updated_user."', '".$updated_nip."', '".$updated_nama."', NOW(), '".$updated_ip."',
						'".$ttd_nama."', '".$ttd_nip."', '".$ttd_jabatan."', '".$ttd_status."', '".$ttd_gol."', '".$ttd_pangkat."', '".$ttd_jabatannya."','".$no_register_skk."', '".$helpernya->tgl_db($tanggal_skk)."','".$isInkrah."','".$no_surat."'";

				if($filePhoto != "") $sql1 .= ", '".$newPhoto."'";
				if ($tanggal_prinsipal) $sql1 .=", '".$helpernya->tgl_db($tanggal_prinsipal)."'";
				if ($tanggal_putusan) $sql1 .=", '".$helpernya->tgl_db($tanggal_putusan)."'";
				$sql1 .= ")";

			}else{
				$upl1 = false;
				$upl2 = false;
				$upl3 = false;
				$sql1 = "update datun.prinsipal_utama set nomor_prinsipal = '".$nomor_prinsipal."', sifat = '".$sifat."', lampiran = '".$lampiran."', perihal = '".$perihal."', 
						kepada_yth = '".$kepada_yth."', di = '".$di."', pihak='".$pihak."', kasus_posisi='".$kasus_posisi."', penanganan_perkara='".$penanganan_perkara."', resume='".$resume."',
						updated_user = '".$updated_user."', updated_nip = '".$updated_nip."',updated_nama = '".$updated_nama."', 
						updated_ip = '".$updated_ip."', updated_date = NOW(),
						penandatangan_nama = '".$ttd_nama."', 
						penandatangan_nip = '".$ttd_nip."', penandatangan_jabatan = '".$ttd_jabatan."', penandatangan_status = '".$ttd_status."', 
						penandatangan_gol = '".$ttd_gol."', penandatangan_pangkat = '".$ttd_pangkat."', penandatangan_ttdjabat = '".$ttd_jabatannya."', is_inkrah = '".$isInkrah."'";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_prinsipal = '".$newPhoto."'";
				}
				if ($tanggal_prinsipal) {
					$sql1 .=", tanggal_prinsipal = '".$helpernya->tgl_db($tanggal_prinsipal)."'";
				} else {
					$sql1 .=", tanggal_prinsipal = NULL";
				}
				if ($tanggal_putusan) {
					$sql1 .=", tanggal_putusan = '".$helpernya->tgl_db($tanggal_putusan)."'";
				} else {
					$sql1 .=", tanggal_putusan = NULL";
				}
				
				$sql1 .= " where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
			}
			$connection->createCommand($sql1)->execute();
			
			$asg2 = "delete from datun.prinsipal_utama_anak where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
			$connection->createCommand($asg2)->execute();
			if(count($post['jpnid']) > 0){
				foreach($post['jpnid'] as $idx=>$val){
					list($nip, $nama, $golpangkat, $gol, $pangkat, $jabatan) = explode("#", $val); 
					$sql2 = "insert into datun.prinsipal_utama_anak (nip, nama, jabatan, pangkat, golongan, no_register_perkara,no_surat)
							values('".$nip."', '".$nama."', '".$jabatan."', '".$pangkat."','".$gol."', '".$no_register_perkara."',	'".$no_surat."')";
					$connection->createCommand($sql2)->execute();
				}
			} 
			
			$sql3 = "delete from datun.laporan_prinsipal_tembusan where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
			$connection->createCommand($sql3)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto	= 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan	 = htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){
						$noauto++;
						$sql4 = "insert into datun.laporan_prinsipal_tembusan values('".$no_register_perkara."', '".$noauto."', '".$nama_tembusan."', '".$no_surat."')";
						$connection->createCommand($sql4)->execute();
					}
				}
			}
					
			if($upl1){
				$tmpPot = glob($pathfile."laporan_prinsipal_".$clean1."-".$clean2.".*");
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