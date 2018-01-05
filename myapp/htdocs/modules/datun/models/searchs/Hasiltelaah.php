<?php

namespace app\modules\datun\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\HtmlPurifier;
use app\components\InspekturComponent;

 
class Hasiltelaah extends \yii\db\ActiveRecord {
	public static function tableName(){
        return 'datun.keputusan_telaah';
    }
	
    public function cekTelaah($post){
		$connection = $this->db;
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$nomor	= htmlspecialchars($post['no_reg_perkara'], ENT_QUOTES);
		$surat	= htmlspecialchars($post['no_permohonan'], ENT_QUOTES);
		$sp5 	= htmlspecialchars($post['no_surat_telaah'], ENT_QUOTES);
		$temp 	= "select no_surat_telaah from datun.keputusan_telaah where no_register_perkara = '".$nomor."' and no_surat = '".$surat."'";
		$dbSp5 	= $connection->createCommand($temp)->queryScalar();
		$sqlCek = "select count(*) from datun.keputusan_telaah where kode_tk = '".$_SESSION['kode_tk']."' and kode_kejati = '".$_SESSION['kode_kejati']."' 
				   and kode_kejari = '".$_SESSION['kode_kejari']."' and kode_cabjari = '".$_SESSION['kode_cabjari']."' and no_surat_telaah = '".$sp5."'";
		$count 	= ($sp5 != $dbSp5)?$connection->createCommand($sqlCek)->queryScalar():0;
		if($count > 0){
			$pesan = '<i style="color:#dd4b39; font-size:12px;">No Surat sudah ada</i>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom1");
		} else{
			return array("hasil"=>true, "error"=>"", "element"=>"");
		}
	}

    public function simpanDatahasiltelaah($post){
		$connection 			= Yii::$app->db; 			
		$isNewRecord			= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_sp1					= htmlspecialchars($post['no_sp1'], ENT_QUOTES);
		$no_surat				= htmlspecialchars($post['no_permohonan'], ENT_QUOTES);
		$no_register_perkara	= htmlspecialchars($post['no_reg_perkara'], ENT_QUOTES);
		$kode_tk				= $_SESSION['kode_tk'];
		$kode_kejati			= $_SESSION['kode_kejati'];
		$kode_kejari			= $_SESSION['kode_kejari'];
		$kode_cabjari			= $_SESSION['kode_cabjari'];
		
		$keputusan 				= htmlspecialchars($post['cb_keputusan'], ENT_QUOTES);
		$penandatangan_nip		= htmlspecialchars($post['penandatangan_nip'], ENT_QUOTES);
		$penandatangan_nama		= htmlspecialchars($post['penandatangan_nama'], ENT_QUOTES);
		$penandatangan_jabatan	= htmlspecialchars($post['penandatangan_jabatan'], ENT_QUOTES);
		$penandatangan_status	= htmlspecialchars($post['penandatangan_status'], ENT_QUOTES);
		$penandatangan_gol		= htmlspecialchars($post['penandatangan_gol'], ENT_QUOTES);
		$penandatangan_pangkat	= htmlspecialchars($post['penandatangan_pangkat'], ENT_QUOTES);
		$penandatangan_ttdjabat	= htmlspecialchars($post['penandatangan_ttdjabat'], ENT_QUOTES);
		$petunjuk 				= htmlspecialchars($post['petunjuk'], ENT_QUOTES);		
		$is_approved 			= ($petunjuk == $keputusan)?1:0; 
		
		if($is_approved){
			$no_surat_telaah 		= '';
			$sifat 					= '0';
			$lampiran_keputusan 	= '';
			$perihal 				= '';
			$tanggal_telaah 		= '';
			$untuk 					= '';
			$tempat 				= '';
			$alasan1				= '';
			$alasan2				= '';
		} else {
			$no_surat_telaah 		= htmlspecialchars($post['no_surat_telaah'], ENT_QUOTES);
			$sifat 					= ($post['cb_sifat'])?htmlspecialchars($post['cb_sifat'], ENT_QUOTES):'0';
			$lampiran_keputusan 	= htmlspecialchars($post['lampiran_keputusan'], ENT_QUOTES);
			$perihal 				= htmlspecialchars($post['perihal'], ENT_QUOTES);
			$tanggal_telaah 		= htmlspecialchars($post['tanggal_telaah'], ENT_QUOTES);
			$untuk 					= htmlspecialchars($post['untuk'], ENT_QUOTES);
			$tempat 				= htmlspecialchars($post['tempat'], ENT_QUOTES);
			$alasan1				= str_replace(array("'"), array("&#039;"), $post['alasan1']);
			$alasan2				= str_replace(array("'"), array("&#039;"), $post['alasan2']);
		}
		
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$helpernya	= Yii::$app->inspektur;
		$pathfile	= Yii::$app->params['hasiltelaah'];

		$filePhoto1 	= htmlspecialchars($_FILES['file_disposisi']['name'],ENT_QUOTES);
		$sizePhoto1 	= htmlspecialchars($_FILES['file_disposisi']['size'],ENT_QUOTES);
		$tempPhoto1 	= htmlspecialchars($_FILES['file_disposisi']['tmp_name'],ENT_QUOTES);
		$extPhoto1 		= substr($filePhoto1,strrpos($filePhoto1,'.'));
		$clean11 		= Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean21 		= Yii::$app->inspektur->sanitize_filename($no_surat);
		$newPhoto1 		= "Disposisi_".$clean11."-".$clean21.$extPhoto1;


		$filePhoto2 	= htmlspecialchars($_FILES['file_telaah']['name'],ENT_QUOTES);
		$sizePhoto2 	= htmlspecialchars($_FILES['file_telaah']['size'],ENT_QUOTES);
		$tempPhoto2 	= htmlspecialchars($_FILES['file_telaah']['tmp_name'],ENT_QUOTES);
		$extPhoto2 		= substr($filePhoto2,strrpos($filePhoto2,'.'));
		$clean12 		= Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean22 		= Yii::$app->inspektur->sanitize_filename($no_surat);
		$newPhoto2 		= "TelaahS5_".$clean12."-".$clean22.$extPhoto2;
		
		$filePhoto3 	= htmlspecialchars($_FILES['file_terimatolak']['name'],ENT_QUOTES);
		$sizePhoto3 	= htmlspecialchars($_FILES['file_terimatolak']['size'],ENT_QUOTES);
		$tempPhoto3 	= htmlspecialchars($_FILES['file_terimatolak']['tmp_name'],ENT_QUOTES);
		$extPhoto3 		= substr($filePhoto3,strrpos($filePhoto3,'.'));
		$clean13 		= Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean23 		= Yii::$app->inspektur->sanitize_filename($no_surat);
		$newPhoto3 		= "Terimatolak_".$clean13."-".$clean23.$extPhoto3;

		$created_user			= $_SESSION['username']; 
		$created_nip			= $_SESSION['nik_user'];
		$created_nama			= $_SESSION['nama_pegawai'];
		$created_ip				= $_SERVER['REMOTE_ADDR'];
		$updated_user			= $_SESSION['username'];  
		$updated_nip			= $_SESSION['nik_user'];
		$updated_nama			= $_SESSION['nama_pegawai']; 
		$updated_ip				= $_SERVER['REMOTE_ADDR'];

		$transaction = $connection->beginTransaction();
		try {
			if($isNewRecord){
				$sql0 = "update datun.permohonan set status = 'DISPOSISI PIMPINAN' where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
				$connection->createCommand($sql0)->execute();	
				
				$upl1 = false;
				$upl2 = false;
				$upl3 = false;
				$sql1 = "insert into datun.keputusan_telaah(no_register_perkara, no_surat, no_surat_telaah, kode_tk, kode_kejati, kode_kejari, kode_cabjari, keputusan, sifat, 
						lampiran_keputusan, perihal, untuk, tempat, alasan1, alasan2, penandatangan_nama, penandatangan_nip, penandatangan_jabatan, create_user, 
						create_nip, create_nama, create_date, create_ip, update_user, update_nip, update_nama, update_date, update_ip, penandatangan_status, is_approved, 
						penandatangan_gol, penandatangan_pangkat, penandatangan_ttdjabat";
				
				if($tanggal_telaah){
					$sql1 .= ", tanggal_telaah";
				}
				
				if($filePhoto1){
					$sql1 .= ", file_disposisi";
					$upl1 = true ;
				}
				if($filePhoto2){
					$sql1 .= ", file_telaah";
					$upl2 = true ;
				}

				if($filePhoto3){
					$sql1 .= ", file_terimatolak";
					$upl3 = true ;
				}
				$sql1 .= ") values('".$no_register_perkara."', '".$no_surat."', '".$no_surat_telaah."', '".$kode_tk."', '".$kode_kejati."', '".$kode_kejari."', 
						'".$kode_cabjari."', '".$keputusan."', '".$sifat."', '".$lampiran_keputusan."', '".$perihal."', '".$untuk."', 
						'".$tempat."', '".$alasan1."', '".$alasan2."', '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', '".$created_user."', 
						'".$created_nip."', '".$created_nama."', NOW(), '".$created_ip."', '".$updated_user."', '".$updated_nip."', '".$updated_nama."', NOW(), '".$updated_ip."', 
						'".$penandatangan_status."', '".$is_approved."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', '".$penandatangan_ttdjabat."'";
					
				if($tanggal_telaah) $sql1 .= ", '".$helpernya->tgl_db($tanggal_telaah)."'";
				if($filePhoto1) $sql1 .= ", '".$newPhoto1."'";
				if($filePhoto2) $sql1 .= ", '".$newPhoto2."'";
				if($filePhoto3) $sql1 .= ", '".$newPhoto3."'";
				$sql1 .= ")";
			} else{
				$upl1 = false;
				$upl2 = false;
				$upl3 = false;
				$sql1 = "update datun.keputusan_telaah set keputusan = '".$keputusan."', sifat = '".$sifat."', lampiran_keputusan = '".$lampiran_keputusan."', 
						perihal = '".$perihal."', untuk = '".$untuk."', tempat = '".$tempat."', 
						alasan1 = '".$alasan1."', alasan2 = '".$alasan2."', penandatangan_nama = '".$penandatangan_nama."', penandatangan_nip = '".$penandatangan_nip."', 
						penandatangan_jabatan = '".$penandatangan_jabatan."', penandatangan_status = '".$penandatangan_status."', penandatangan_gol = '".$penandatangan_gol."', 
						penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_ttdjabat = '".$penandatangan_ttdjabat."', update_user = '".$updated_user."', 
						update_nip = '".$updated_nip."', update_nama = '".$updated_nama."', update_date = NOW(), update_ip = '".$updated_ip."', 
						no_surat_telaah = '".$no_surat_telaah."', is_approved = '".$is_approved."'"; 	
				if($tanggal_telaah){
					$sql1 .= ", tanggal_telaah = '".$helpernya->tgl_db($tanggal_telaah)."'";
				}
				if($filePhoto1){
					$sql1 .= ", file_disposisi = '".$newPhoto1."'";
					$upl1 = true ;
				}
				if($filePhoto2){
					$sql1 .= ", file_telaah = '".$newPhoto2."'";
					$upl2 = true ;
				}
				if($filePhoto3){
					$sql1 .= ", file_terimatolak = '".$newPhoto3."'";
					$upl3 = true ;
				}				
				$sql1 .= " where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql2 = "delete from datun.keputusan_telaah_tembusan where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
			$connection->createCommand($sql2)->execute();

			if(!$is_approved){
				if(count($post['tembusan']) > 0){
					$nomor = 0;
					foreach($post['tembusan'] as $idx=>$nilai){
						$tembus = htmlspecialchars($post['tembusan'][$idx], ENT_QUOTES);
						if($tembus){
							$nomor++;
							$sql3 	= "insert into datun.keputusan_telaah_tembusan values('".$no_register_perkara."', '".$no_surat."', '".$nomor."', '".$tembus."')";
							$connection->createCommand($sql3)->execute();
						}
					}
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."Disposisi_".$clean11."-".$clean21.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto1;
				$mantab  = move_uploaded_file($tempPhoto1, $tujuan);
				if(file_exists($tempPhoto1)) unlink($tempPhoto1);
			}

			if($upl2){
				$tmpPot = glob($pathfile."TelaahS5_".$clean12."-".$clean22.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto2;
				$mantab  = move_uploaded_file($tempPhoto2, $tujuan);
				if(file_exists($tempPhoto2)) unlink($tempPhoto2);
			}

			if($upl3){
				$tmpPot = glob($pathfile."Terimatolak_".$clean13."-".$clean23.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto3;
				$mantab  = move_uploaded_file($tempPhoto3, $tujuan);
				if(file_exists($tempPhoto3)) unlink($tempPhoto3);
			}

			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}    	
    }	
	
      public function searchCustom($no_surat_telaah = ''){
		$no_register_perkara = $_SESSION['no_register_perkara'];	
		$no_surat = $_SESSION['no_surat'];		
		
		if(!$no_surat_telaah){
			$sql = "select * from datun.template_tembusan where kode_template_surat = 'S-5.A'";		
			$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
			$count = $kueri->queryScalar();
			$sql .= " order by no_urut";
			$dataProvider = new SqlDataProvider(['sql'=>$sql, 'pagination'=>false]);
			return $dataProvider;			
		}else{ 
			$sql = "select no_temb_tt as no_urut, deskripsi_tembusan as tembusan from datun.keputusan_telaah_tembusan 
					where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
			$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
			$count = $kueri->queryScalar();
			$sql .= " order by no_temb_tt";
			$dataProvider = new SqlDataProvider(['sql'=>$sql, 'pagination'=>false]);
			return $dataProvider;			
		}
    }

}	
