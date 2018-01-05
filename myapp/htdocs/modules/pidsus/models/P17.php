<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class P17 extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p17';
    }

    public function cekP17($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari     = $_SESSION['kode_cabjari'];

		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$nom_spdp  	= $_SESSION["no_spdp"];
		$tgl_spdp 	= htmlspecialchars($post['tgl_spdp'], ENT_QUOTES);
		$surat 		= htmlspecialchars($post['no_p17'], ENT_QUOTES);
		$tgl_p17 	= htmlspecialchars($post['tgldittd'], ENT_QUOTES);
                
		$where 		= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$nom_spdp."' 
						and tgl_spdp = '".$helpernya->tgl_db($tgl_spdp)."'";

		$sqlCek1 	= "select count(*) from pidsus.pds_p17 where ".$where;
		$count1 	= ($isNew)?$connection->createCommand($sqlCek1)->queryScalar():0;
                
                $sqlCek2 	= "select tgl_dikeluarkan from pidsus.pds_p16 where ".$where." and is_akhir=1";
                $res            = $connection->createCommand($sqlCek2)->queryOne();
                $tgl_p16        = ($res['tgl_dikeluarkan'])?date("d-m-Y", strtotime($res['tgl_dikeluarkan'])):'';
                
		if($count1 > 0){
			$pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>* Nomor surat dengan nomor '.$surat.' sudah ada</i></p>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_p17");
		}else if(strtotime($tgl_p17) < strtotime($tgl_p16)){
			$pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>* Tanggal dikeluarkan lebih kecil dari tanggal P-16 : '.$tgl_p16.' </i></p>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_tgldittd");
		} else{
			return array("hasil"=>true, "error"=>"", "element"=>"");
		}
	}

	public function simpanData($post){
		$connection 		= $this->db;
		$id_kejati			= $_SESSION['kode_kejati'];
		$id_kejari			= $_SESSION['kode_kejari'];
		$id_cabjari			= $_SESSION['kode_cabjari'];
		$no_spdp			= $_SESSION['no_spdp'];
		$tgl_spdp			= $_SESSION['tgl_spdp'];

		$no_p17				= htmlspecialchars($post['no_p17'], ENT_QUOTES);
		$dikeluarkan		= htmlspecialchars($post['lokel'], ENT_QUOTES);
		$tgl_dikeluarkan	= htmlspecialchars($post['tgldittd'], ENT_QUOTES);
		$sifat				= htmlspecialchars($post['sifat'], ENT_QUOTES);
		$kepada				= htmlspecialchars($post['kepada'], ENT_QUOTES);
		$lampiran			= htmlspecialchars($post['lampiran'], ENT_QUOTES);
		$di_kepada			= htmlspecialchars($post['di_kepada'], ENT_QUOTES);
		$perihal			= htmlspecialchars($post['perihal'], ENT_QUOTES);
		
		$penandatangan_nama			= htmlspecialchars($post['penandatangan_nama'], ENT_QUOTES);
		$penandatangan_nip			= htmlspecialchars($post['penandatangan_nip'], ENT_QUOTES);
		$penandatangan_jabatan		= htmlspecialchars($post['penandatangan_jabatan'], ENT_QUOTES);
		$penandatangan_gol			= htmlspecialchars($post['penandatangan_gol'], ENT_QUOTES);
		$penandatangan_pangkat		= htmlspecialchars($post['penandatangan_pangkat'], ENT_QUOTES);
		$penandatangan_status_ttd	= htmlspecialchars($post['penandatangan_status'], ENT_QUOTES);
		$penandatangan_jabatan_ttd	= htmlspecialchars($post['penandatangan_ttdjabat'], ENT_QUOTES);
		
		$created_user		= $_SESSION['username'];
		$created_nip		= $_SESSION['nik_user'];
		$created_nama		= $_SESSION['nama_pegawai'];
		$created_ip			= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai'];
		$updated_ip			= $_SERVER['REMOTE_ADDR'];

		$helpernya	= Yii::$app->inspektur;
		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['p17'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_spdp);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_spdp);
		$clean3 	= Yii::$app->inspektur->sanitize_filename($no_p17);
		$newPhoto 	= "p17_".$clean1."-".$clean2."-".$clean3.$extPhoto;
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$no_spdp."' and tgl_spdp = '".$tgl_spdp."'";
		$transaction = $connection->beginTransaction();
		try{
			if($isNew){
				if($filePhoto != ""){
					$upl1 = true;
					$newPhoto = $newPhoto;
				} else{
					$upl1 = false;
					$newPhoto = "";
				}
				$sql1 = "insert into pidsus.pds_p17(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_p17, dikeluarkan, tgl_dikeluarkan, sifat, kepada, 
						 lampiran, di_kepada, penandatangan_nama, penandatangan_nip, penandatangan_jabatan_pejabat, penandatangan_gol, penandatangan_pangkat, 
						 penandatangan_status_ttd, penandatangan_jabatan_ttd, file_upload_p17, created_user, created_nip, created_nama, created_ip, created_date, 
						 updated_user, updated_nip, updated_nama, updated_ip, updated_date)
						 values ('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$no_p17."', 
						 '".$dikeluarkan."', '".$helpernya->tgl_db($tgl_dikeluarkan)."', '".$sifat."', '".$kepada."', '".$lampiran."', '".$di_kepada."', 
						 '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', 
						 '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$newPhoto."', '".$created_user."', '".$created_nip."', '".$created_nama."', 
						 '".$created_ip."', NOW(), '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload_p17 = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_p17 set no_p17 = '".$no_p17."', tgl_dikeluarkan = '".$helpernya->tgl_db($tgl_dikeluarkan)."', sifat = '".$sifat."', kepada = '".$kepada."', 
						 lampiran = '".$lampiran."', di_kepada = '".$di_kepada."', penandatangan_nama = '".$penandatangan_nama."', 
						 penandatangan_nip = '".$penandatangan_nip."', penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef;
			}
			$connection->createCommand($sql1)->execute();

			$sql2 = "delete from pidsus.pds_p17_tembusan where ".$whereDef." and no_p17 = '".$no_p17."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql3 = "insert into pidsus.pds_p17_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', 
								 '".$tgl_spdp."', '".$no_p17."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql3)->execute();
					}
				}
			}


			if($upl1){
				$tmpPot = glob($pathfile."p17_".$clean1."-".$clean2."-".$clean3.".*");
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

    public function hapusData($get){
		$connection 	= $this->db;
		$pathfile		= Yii::$app->params['p17'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
		try {
			$tmp = $get["id"];
			$kue = "select file_upload_p17 from pidsus.pds_p17 where ".$whereDefault." and no_p17 = '".rawurldecode($tmp)."'";
			$file = $connection->createCommand($kue)->queryScalar();
			if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

			$sql1 = "delete from pidsus.pds_p17 where ".$whereDefault." and no_p17 = '".rawurldecode($tmp)."'";
			$connection->createCommand($sql1)->execute();

			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }

}
