<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsPidsus7Umum extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p16';
    }
    
	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_p8_umum	= $_SESSION['pidsus_no_p8_umum'];

		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "
		select a.* from pidsus.pds_pidsus7_umum a 
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_p8_umum = '".$no_p8_umum."'";
		if($q1)
			$sql .= " and (to_char(a.tgl_pidsus7, 'DD-MM-YYYY') = '".$q1."' or to_char(a.ekspose, 'DD-MM-YYYY') = '".$q1."' 
					  or upper(a.nip_jaksa) like '%".strtoupper($q1)."%' or upper(a.nama_jaksa) like '%".strtoupper($q1)."%' or upper(a.gol_jaksa) like '%".strtoupper($q1)."%' 
					  or upper(a.pangkat_jaksa) like '%".strtoupper($q1)."%' or upper(a.jabatan_jaksa) like '%".strtoupper($q1)."%')";
                
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_pidsus7 desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
    public function getJaksaPenelaah($post){
		$tq1 	= htmlspecialchars($post['q1'], ENT_QUOTES);
		$sqlOpt = "
		select a.nip_jaksa as idnya, a.nama_jaksa as namanya, a.gol_jaksa||'#'||a.pangkat_jaksa||'#'||a.jabatan_jaksa as pangkatnya 
		from pidsus.pds_pidsus6_umum_penelaah a 
		where a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
			and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."' and a.no_pidsus6_umum = '".$tq1."'";
		$result	= $this->db->createCommand($sqlOpt)->queryAll();
		$answer	= '<option></option>';
		if(count($result) > 0){
			foreach($result as $datOpt1){
				$answer .= '<option value="'.$datOpt1['idnya'].'" data-pangkat="'.$datOpt1['pangkatnya'].'">'.$datOpt1['namanya'].'</option>';
			}
		}
		return $answer;
    }

	public function simpanData($post){
		$helpernya	= Yii::$app->inspektur;
		$connection = $this->db;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_p8_umum		= htmlspecialchars($post['no_p8_umum'], ENT_QUOTES);
		$no_pidsus7_umum = ($post['no_pidsus7_umum'])?htmlspecialchars($post['no_pidsus7_umum'], ENT_QUOTES):0;
		$tgl_pidsus7	= htmlspecialchars($post['tgl_pidsus7'], ENT_QUOTES);
		$tgl_ekspose	= htmlspecialchars($post['tgl_ekspose'], ENT_QUOTES);
		$di_tempat		= htmlspecialchars($post['di_tempat'], ENT_QUOTES);
		$no_pidsus6_umum = htmlspecialchars($post['no_pidsus6_umum'], ENT_QUOTES);
		$nip_jaksa		= htmlspecialchars($post['nip_jaksa'], ENT_QUOTES);
		$nama_jaksa		= htmlspecialchars($post['nama_jaksa'], ENT_QUOTES);
		$gol_jaksa		= htmlspecialchars($post['gol_jaksa'], ENT_QUOTES);
		$pangkat_jaksa	= htmlspecialchars($post['pangkat_jaksa'], ENT_QUOTES);
		$jabatan_jaksa	= htmlspecialchars($post['jabatan_jaksa'], ENT_QUOTES);

		$posisi_kasus		= str_replace(array("'"), array("&#039;"), $post['posisi_kasus']);
		$pendapat_pemapar	= str_replace(array("'"), array("&#039;"), $post['pendapat_pemapar']);
		$pendapat_pimpinan	= str_replace(array("'"), array("&#039;"), $post['pendapat_pimpinan']);
		$kesimpulan			= str_replace(array("'"), array("&#039;"), $post['kesimpulan']);
		$saran				= str_replace(array("'"), array("&#039;"), $post['saran']);
                
                $pemapar_dilanjutkan	= htmlspecialchars($post['pemapar_dilanjutkan'], ENT_QUOTES);
                $sita_geledah_pemapar	= htmlspecialchars($post['sita_geledah_pemapar'], ENT_QUOTES);
                $penetapan_tsk_pemapar	= htmlspecialchars($post['penetapan_tsk_pemapar'], ENT_QUOTES);
                $pimpinan_dilanjutkan	= htmlspecialchars($post['pimpinan_dilanjutkan'], ENT_QUOTES);
                $sita_geledah_pimpinan	= htmlspecialchars($post['sita_geledah_pimpinan'], ENT_QUOTES);
                $penetapan_tsk_pimpinan	= htmlspecialchars($post['penetapan_tsk_pimpinan'], ENT_QUOTES);
		
		$created_user		= $_SESSION['username'];
		$created_nip		= $_SESSION['nik_user'];
		$created_nama		= $_SESSION['nama_pegawai'];
		$created_ip			= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai'];
		$updated_ip			= $_SERVER['REMOTE_ADDR'];

		$sql0 = "select coalesce(max(no_pidsus7_umum)+1,1) as nourut from pidsus.pds_pidsus7_umum 
				 where id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p8_umum = '".$no_p8_umum."'";
		$row0 = $connection->createCommand($sql0)->queryScalar();

		$filePhoto1 = htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto1 = htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto1 = htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto1 	= substr($filePhoto1,strrpos($filePhoto1,'.'));

		$filePhoto2 = htmlspecialchars($_FILES['file_upload_posisi_kasus']['name'],ENT_QUOTES);
		$sizePhoto2 = htmlspecialchars($_FILES['file_upload_posisi_kasus']['size'],ENT_QUOTES);
		$tempPhoto2 = htmlspecialchars($_FILES['file_upload_posisi_kasus']['tmp_name'],ENT_QUOTES);
		$extPhoto2 	= substr($filePhoto2,strrpos($filePhoto2,'.'));

		$filePhoto3 = htmlspecialchars($_FILES['file_upload_pendapat_pemapar']['name'],ENT_QUOTES);
		$sizePhoto3 = htmlspecialchars($_FILES['file_upload_pendapat_pemapar']['size'],ENT_QUOTES);
		$tempPhoto3 = htmlspecialchars($_FILES['file_upload_pendapat_pemapar']['tmp_name'],ENT_QUOTES);
		$extPhoto3 	= substr($filePhoto3,strrpos($filePhoto3,'.'));

		$filePhoto4 = htmlspecialchars($_FILES['file_upload_pendapat_pimpinan']['name'],ENT_QUOTES);
		$sizePhoto4 = htmlspecialchars($_FILES['file_upload_pendapat_pimpinan']['size'],ENT_QUOTES);
		$tempPhoto4 = htmlspecialchars($_FILES['file_upload_pendapat_pimpinan']['tmp_name'],ENT_QUOTES);
		$extPhoto4 	= substr($filePhoto4,strrpos($filePhoto4,'.'));

		$filePhoto5 = htmlspecialchars($_FILES['file_kesimpulan']['name'],ENT_QUOTES);
		$sizePhoto5 = htmlspecialchars($_FILES['file_kesimpulan']['size'],ENT_QUOTES);
		$tempPhoto5 = htmlspecialchars($_FILES['file_kesimpulan']['tmp_name'],ENT_QUOTES);
		$extPhoto5 	= substr($filePhoto5,strrpos($filePhoto5,'.'));

		$filePhoto6 = htmlspecialchars($_FILES['file_saran']['name'],ENT_QUOTES);
		$sizePhoto6 = htmlspecialchars($_FILES['file_saran']['size'],ENT_QUOTES);
		$tempPhoto6 = htmlspecialchars($_FILES['file_saran']['tmp_name'],ENT_QUOTES);
		$extPhoto6 	= substr($filePhoto6,strrpos($filePhoto6,'.'));

		$max_size	= 5 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['pidsus_7umum'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_umum);
		$clean2 	= ($isNew)?$row0:$no_pidsus7_umum;
		$newPhoto1 	= "pidsus_7umum_".$clean1."-".$clean2.$extPhoto1;
		$newPhoto2 	= "pidsus_7umum_posisi_kasus_".$clean1."-".$clean2.$extPhoto2;
		$newPhoto3 	= "pidsus_7umum_pendapat_pemapar_".$clean1."-".$clean2.$extPhoto3;
		$newPhoto4 	= "pidsus_7umum_pendapat_pimpinan_".$clean1."-".$clean2.$extPhoto4;
		$newPhoto5 	= "pidsus_7umum_kesimpulan_".$clean1."-".$clean2.$extPhoto5;
		$newPhoto6 	= "pidsus_7umum_saran_".$clean1."-".$clean2.$extPhoto6;
		$whereDef 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p8_umum = '".$no_p8_umum."'";

		$transaction = $connection->beginTransaction();
		try{
			if($isNew){
				if($filePhoto1 != ""){
					$upl1 = true;
					$newPhoto1 = $newPhoto1;
				} else{
					$upl1 = false;
					$newPhoto1 = "";
				}

				if($filePhoto2 != ""){
					$upl2 = true;
					$newPhoto2 = $newPhoto2;
				} else{
					$upl2 = false;
					$newPhoto2 = "";
				}

				if($filePhoto3 != ""){
					$upl3 = true;
					$newPhoto3 = $newPhoto3;
				} else{
					$upl3 = false;
					$newPhoto3 = "";
				}

				if($filePhoto4 != ""){
					$upl4 = true;
					$newPhoto4 = $newPhoto4;
				} else{
					$upl4 = false;
					$newPhoto4 = "";
				}

				if($filePhoto5 != ""){
					$upl5 = true;
					$newPhoto5 = $newPhoto5;
				} else{
					$upl5 = false;
					$newPhoto5 = "";
				}

				if($filePhoto6 != ""){
					$upl6 = true;
					$newPhoto6 = $newPhoto6;
				} else{
					$upl6 = false;
					$newPhoto6 = "";
				}

				$sql1 = "insert into pidsus.pds_pidsus7_umum(id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus7_umum, tgl_pidsus7, tgl_ekspose, di_tempat, no_pidsus6_umum, 
						 nip_jaksa, nama_jaksa, gol_jaksa, pangkat_jaksa, jabatan_jaksa, posisi_kasus, pendapat_pemapar, pendapat_pimpinan, kesimpulan, saran, file_upload, 
						 file_upload_posisi_kasus, file_upload_pendapat_pemapar, file_upload_pendapat_pimpinan, file_upload_kesimpulan, file_saran, created_user, 
						 created_nip, created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date, pemapar_dilanjutkan, 
                                                 sita_geledah_pemapar, penetapan_tsk_pemapar, pimpinan_dilanjutkan, sita_geledah_pimpinan, penetapan_tsk_pimpinan) values('".$id_kejati."', 
						 '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".$row0."', '".$helpernya->tgl_db($tgl_pidsus7)."', '".$helpernya->tgl_db($tgl_ekspose)."', 
						 '".$di_tempat."', '".$no_pidsus6_umum."', '".$nip_jaksa."', '".$nama_jaksa."', '".$gol_jaksa."', '".$pangkat_jaksa."', '".$jabatan_jaksa."', 
						 '".$posisi_kasus."', '".$pendapat_pemapar."', '".$pendapat_pimpinan."', '".$kesimpulan."', '".$saran."', 
						 '".$newPhoto1."', '".$newPhoto2."', '".$newPhoto3."', '".$newPhoto4."', '".$newPhoto5."', '".$newPhoto6."', 
						 '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW(), '".$pemapar_dilanjutkan."', '".$sita_geledah_pemapar."', "
                                             . " '".$penetapan_tsk_pemapar."', '".$pimpinan_dilanjutkan."', '".$sita_geledah_pimpinan."', '".$penetapan_tsk_pimpinan."')";
			} else{
				if($filePhoto1 != ""){
					$upl1 = true;
					$filenya1 = ", file_upload = '".$newPhoto1."'";
				} else{
					$upl1 = false;
					$filenya1 = "";
				}

				if($filePhoto2 != ""){
					$upl2 = true;
					$filenya2 = ", file_upload_posisi_kasus = '".$newPhoto2."'";
				} else{
					$upl2 = false;
					$filenya2 = "";
				}

				if($filePhoto3 != ""){
					$upl3 = true;
					$filenya3 = ", file_upload_pendapat_pemapar = '".$newPhoto3."'";
				} else{
					$upl3 = false;
					$filenya3 = "";
				}

				if($filePhoto4 != ""){
					$upl4 = true;
					$filenya4 = ", file_upload_pendapat_pimpinan = '".$newPhoto4."'";
				} else{
					$upl4 = false;
					$filenya4 = "";
				}

				if($filePhoto5 != ""){
					$upl5 = true;
					$filenya5 = ", file_upload_kesimpulan = '".$newPhoto5."'";
				} else{
					$upl5 = false;
					$filenya5 = "";
				}

				if($filePhoto6 != ""){
					$upl6 = true;
					$filenya6 = ", file_saran = '".$newPhoto6."'";
				} else{
					$upl6 = false;
					$filenya6 = "";
				}

				$sql1 = "update pidsus.pds_pidsus7_umum set tgl_pidsus7 = '".$helpernya->tgl_db($tgl_pidsus7)."', tgl_ekspose = '".$helpernya->tgl_db($tgl_ekspose)."', 
						 di_tempat = '".$di_tempat."', no_pidsus6_umum = '".$no_pidsus6_umum."', nip_jaksa = '".$nip_jaksa."', nama_jaksa = '".$nama_jaksa."', 
						 gol_jaksa = '".$gol_jaksa."', pangkat_jaksa = '".$pangkat_jaksa."', jabatan_jaksa = '".$jabatan_jaksa."', posisi_kasus = '".$posisi_kasus."', 
						 pendapat_pemapar = '".$pendapat_pemapar."', pendapat_pimpinan = '".$pendapat_pimpinan."', kesimpulan = '".$kesimpulan."', saran = '".$saran."', 
						 updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', 
						 updated_date = NOW(), pemapar_dilanjutkan = '".$pemapar_dilanjutkan."', sita_geledah_pemapar = '".$sita_geledah_pemapar."', penetapan_tsk_pemapar = '".$penetapan_tsk_pemapar."', "
                                                . " pimpinan_dilanjutkan = '".$pimpinan_dilanjutkan."', sita_geledah_pimpinan = '".$sita_geledah_pimpinan."', penetapan_tsk_pimpinan = '".$penetapan_tsk_pimpinan."' "
                                                .$filenya1.$filenya2.$filenya3.$filenya4.$filenya5.$filenya6." where ".$whereDef." and no_pidsus7_umum = '".$no_pidsus7_umum."'";
			}
			$connection->createCommand($sql1)->execute();

			if($upl1){
				$tmpPot = glob($pathfile."pidsus_7umum_".$clean1."-".$clean2.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto1;
				$mantab  = move_uploaded_file($tempPhoto1, $tujuan);
				if(file_exists($tempPhoto1)) unlink($tempPhoto1);
			}

			if($upl2){
				$tmpPot = glob($pathfile."pidsus_7umum_posisi_kasus_".$clean1."-".$clean2.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto2;
				$mantab  = move_uploaded_file($tempPhoto2, $tujuan);
				if(file_exists($tempPhoto2)) unlink($tempPhoto2);
			}

			if($upl3){
				$tmpPot = glob($pathfile."pidsus_7umum_pendapat_pemapar_".$clean1."-".$clean2.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto3;
				$mantab  = move_uploaded_file($tempPhoto3, $tujuan);
				if(file_exists($tempPhoto3)) unlink($tempPhoto3);
			}

			if($upl4){
				$tmpPot = glob($pathfile."pidsus_7umum_pendapat_pimpinan_".$clean1."-".$clean2.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto4;
				$mantab  = move_uploaded_file($tempPhoto4, $tujuan);
				if(file_exists($tempPhoto4)) unlink($tempPhoto4);
			}

			if($upl5){
				$tmpPot = glob($pathfile."pidsus_7umum_kesimpulan_".$clean1."-".$clean2.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto5;
				$mantab  = move_uploaded_file($tempPhoto5, $tujuan);
				if(file_exists($tempPhoto5)) unlink($tempPhoto5);
			}

			if($upl6){
				$tmpPot = glob($pathfile."pidsus_7umum_saran_".$clean1."-".$clean2.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto6;
				$mantab  = move_uploaded_file($tempPhoto6, $tujuan);
				if(file_exists($tempPhoto6)) unlink($tempPhoto6);
			}

			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }

    public function hapusData($post){
		$connection 	= $this->db;
		$pathfile		= Yii::$app->params['pidsus_7umum'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload, file_upload_posisi_kasus, file_upload_pendapat_pemapar, file_upload_pendapat_pimpinan, file_upload_kesimpulan, file_saran 
							from pidsus.pds_pidsus7_umum where ".$whereDefault." and no_pidsus7_umum = '".rawurldecode($tmp[0])."'";
					$file = $connection->createCommand($kue)->queryOne();
					if($file['file_upload'] && file_exists($pathfile.$file['file_upload'])) unlink($pathfile.$file['file_upload']);
					if($file['file_upload_posisi_kasus'] && file_exists($pathfile.$file['file_upload_posisi_kasus'])) unlink($pathfile.$file['file_upload_posisi_kasus']);
					if($file['file_upload_pendapat_pemapar'] && file_exists($pathfile.$file['file_upload_pendapat_pemapar'])) 
						unlink($pathfile.$file['file_upload_pendapat_pemapar']);
					if($file['file_upload_pendapat_pimpinan'] && file_exists($pathfile.$file['file_upload_pendapat_pimpinan'])) 
						unlink($pathfile.$file['file_upload_pendapat_pimpinan']);
					if($file['file_upload_kesimpulan'] && file_exists($pathfile.$file['file_upload_kesimpulan'])) unlink($pathfile.$file['file_upload_kesimpulan']);
					if($file['file_saran'] && file_exists($pathfile.$file['file_saran'])) unlink($pathfile.$file['file_saran']);

					$sql1 = "delete from pidsus.pds_pidsus7_umum where ".$whereDefault." and no_pidsus7_umum = '".rawurldecode($tmp[0])."'";
					$connection->createCommand($sql1)->execute();
				}
			}

			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }

}
