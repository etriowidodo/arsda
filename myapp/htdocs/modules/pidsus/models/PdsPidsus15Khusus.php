<?php 
namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsPidsus15Khusus extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p16';
    }
    
	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_pidsus18	= $_SESSION['pidsus_no_pidsus18'];
		$no_p8_khusus	= $_SESSION['pidsus_no_p8_khusus'];
		$sql = "select a.* from pidsus.pds_pidsus15_khusus a 
			where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_pidsus18 = '".$no_pidsus18."' and a.no_p8_khusus = '".$no_p8_khusus."'";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_pidsus15_khusus desc, a.created_date desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
    public function getSaksi($params){
        $q0  = htmlspecialchars(rawurldecode($params['keperluan']), ENT_QUOTES);
		$q1  = htmlspecialchars($params['mb4_q1'], ENT_QUOTES);
        $def = "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
		and a.no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."' and a.no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'";
        $sql = "select a.* from pidsus.pds_pidsus14_khusus_saksi_tersangka a where ".$def;
        if($q0 == 'Pemeriksaan Saksi')
			$sql .= " and a.status_keperluan = 'Saksi'";
        else 
			$sql .= " and a.status_keperluan = 'Tersangka'";

		if($q1){
			$sql .= " and (to_char(a.waktu_pelaksanaan, 'DD-MM-YYYY') = '".$q1."' or upper(a.nama) like '%".strtoupper($q1)."%' or upper(a.jabatan) like '%".strtoupper($q1)."%' 
						or upper(a.nip_jaksa) like '%".strtoupper($q1)."%' or upper(a.nama_jaksa) like '%".strtoupper($q1)."%' or upper(a.gol_jaksa) like '%".strtoupper($q1)."%' 
						or upper(a.pangkat_jaksa) like '%".strtoupper($q1)."%' or upper(a.jabatan_jaksa) like '%".strtoupper($q1)."%' 
						or upper(a.keperluan) like '%".strtoupper($q1)."%')";
		}
        $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
        $count = $kueri->queryScalar();
        $sql .= " order by a.waktu_pelaksanaan asc";
        $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                'totalCount' => $count,
        ]);
        return $dataProvider;
    }

    public function cekPdsPidsus15Khusus($post){
        $connection  = $this->db;
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $helpernya	= Yii::$app->inspektur;
        $isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $no_pidsus15_khusus = htmlspecialchars($post['no_pidsus15_khusus'], ENT_QUOTES);
        $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_pidsus15_khusus = '".$no_pidsus15_khusus."'";
        
        $sql 	= "select count(*) from pidsus.pds_pidsus15_khusus where ".$whereDef;
		if($isNew){
			$count 	= $connection->createCommand($sql)->queryScalar();
		} else{
			$id1 	= $_SESSION["pidsus_no_pidsus15_khusus"];
			$count 	= ($id1 == $no_pidsus15_khusus)?0:$connection->createCommand($sql)->queryScalar();
		}
        
        if($count > 0){
            $pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>Pidsus-15 Khusus dengan nomor '.$no_pidsus15_khusus.' sudah ada</i></p>';
            return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_pidsus15_khusus");
        } else{
            return array("hasil"=>true, "error"=>"", "element"=>"");
        }
	}

	public function simpanData($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_pidsus18	= $_SESSION['pidsus_no_pidsus18'];
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_p8_khusus		= htmlspecialchars($post['no_p8_khusus'], ENT_QUOTES);
		$no_pidsus15_khusus	= htmlspecialchars($post['no_pidsus15_khusus'], ENT_QUOTES);
		$tgl_pidsus15_khusus	= htmlspecialchars($post['tgl_pidsus15_khusus'], ENT_QUOTES);
		$perihal 		= htmlspecialchars($post['perihal'], ENT_QUOTES);
		$kepada 		= htmlspecialchars($post['kepada'], ENT_QUOTES);
		$di_kepada 		= htmlspecialchars($post['di_kepada'], ENT_QUOTES);
		$sifat 			= htmlspecialchars($post['sifat'], ENT_QUOTES);
		$lampiran		= htmlspecialchars($post['lampiran'], ENT_QUOTES);
		$keperluan		= htmlspecialchars($post['keperluan'], ENT_QUOTES);
		$posisi_kasus		= htmlspecialchars($post['posisi_kasus'], ENT_QUOTES);
		$ijin			= htmlspecialchars($post['ijin'], ENT_QUOTES);
		$alasan			= htmlspecialchars($post['alasan'], ENT_QUOTES);
		$nama_saksi		= htmlspecialchars($post['nama_saksi'], ENT_QUOTES);
		$jabatan_saksi		= htmlspecialchars($post['jabatan_saksi'], ENT_QUOTES);
		$berdasarkan_uu		= htmlspecialchars($post['berdasarkan_uu'], ENT_QUOTES);
		$uraian_penanganan_perkara	= htmlspecialchars($post['uraian_penanganan_perkara'], ENT_QUOTES);

		$penandatangan_nama		= htmlspecialchars($post['penandatangan_nama'], ENT_QUOTES);
		$penandatangan_nip		= htmlspecialchars($post['penandatangan_nip'], ENT_QUOTES);
		$penandatangan_jabatan		= htmlspecialchars($post['penandatangan_jabatan'], ENT_QUOTES);
		$penandatangan_gol		= htmlspecialchars($post['penandatangan_gol'], ENT_QUOTES);
		$penandatangan_pangkat		= htmlspecialchars($post['penandatangan_pangkat'], ENT_QUOTES);
		$penandatangan_status_ttd	= htmlspecialchars($post['penandatangan_status'], ENT_QUOTES);
		$penandatangan_jabatan_ttd	= htmlspecialchars($post['penandatangan_ttdjabat'], ENT_QUOTES);
		
		$created_user		= $_SESSION['username'];
		$created_nip		= $_SESSION['nik_user'];
		$created_nama		= $_SESSION['nama_pegawai'];
		$created_ip		= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai'];
		$updated_ip		= $_SERVER['REMOTE_ADDR'];

		$helpernya	= Yii::$app->inspektur;
		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['pidsus_15khusus'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_khusus);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_pidsus15_khusus);
		$newPhoto 	= "pidsus15khusus_".$clean1."-".$clean2.$extPhoto;
		$whereDef 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_pidsus18 = '".$no_pidsus18."' and no_p8_khusus = '".$no_p8_khusus."'";

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
				$sql1 = "insert into pidsus.pds_pidsus15_khusus(id_kejati, id_kejari, id_cabjari, no_pidsus18, no_p8_khusus, no_pidsus15_khusus, tgl_pidsus15_khusus, keperluan, sifat, lampiran, 
						 nama_saksi, jabatan_saksi, posisi_kasus, ijin, alasan, penandatangan_nama, penandatangan_nip, penandatangan_jabatan_pejabat, penandatangan_gol, 
						 penandatangan_pangkat, penandatangan_status_ttd, penandatangan_jabatan_ttd, file_upload, created_user, created_nip, created_nama, created_ip, 
						 created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date, kepada, di_kepada, perihal, berdasarkan_uu, uraian_penanganan_perkara) 
						 values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_pidsus18."', '".$no_p8_khusus."', '".$no_pidsus15_khusus."', '".$helpernya->tgl_db($tgl_pidsus15_khusus)."', 
						 '".$keperluan."', '".$sifat."', '".$lampiran."', '".$nama_saksi."', '".$jabatan_saksi."', '".$posisi_kasus."', '".$ijin."', '".$alasan."', 
						 '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', 
						 '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$newPhoto."', '".$created_user."', '".$created_nip."', '".$created_nama."', 
						 '".$created_ip."', NOW(), '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW(), '".$kepada."', 
						 '".$di_kepada."', '".$perihal."', '".$berdasarkan_uu."', '".$uraian_penanganan_perkara."')";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_pidsus15_khusus set no_pidsus15_khusus = '".$no_pidsus15_khusus."', tgl_pidsus15_khusus = '".$helpernya->tgl_db($tgl_pidsus15_khusus)."', 
						 keperluan = '".$keperluan."', sifat = '".$sifat."', lampiran = '".$lampiran."', nama_saksi = '".$nama_saksi."', jabatan_saksi = '".$jabatan_saksi."', 
						 posisi_kasus = '".$posisi_kasus."', ijin = '".$ijin."', alasan = '".$alasan."', kepada = '".$kepada."', di_kepada = '".$di_kepada."', 
						 perihal = '".$perihal."', berdasarkan_uu = '".$berdasarkan_uu."', uraian_penanganan_perkara = '".$uraian_penanganan_perkara."', 
						 penandatangan_nama = '".$penandatangan_nama."', penandatangan_nip = '".$penandatangan_nip."', 
						 penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_pidsus15_khusus = '".$_SESSION['pidsus_no_pidsus15_khusus']."'";
			}
			$connection->createCommand($sql1)->execute();

			/*$sql2 = "delete from pidsus.pds_pidsus15_khusus_uu_pasal where ".$whereDef." and no_pidsus15_khusus = '".$no_pidsus15_khusus."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['undang_uu']) > 0){
				$nom1 = 0;
				foreach($post['undang_uu'] as $idx1=>$val1){
					$nom1++;
					$undang	= htmlspecialchars($post['undang_uu'][$idx1], ENT_QUOTES);
					$pasal	= htmlspecialchars($post['pasal'][$idx1], ENT_QUOTES);
					$dakwaan= ($post['dakwaan'][$idx1])?htmlspecialchars($post['dakwaan'][$idx1], ENT_QUOTES):0;
					$sql3 = "
						insert into pidsus.pds_pidsus15_khusus_uu_pasal(id_kejati, id_kejari, id_cabjari, no_p8_khusus, no_pidsus15_khusus, id_uu_pasal, undang, pasal, dakwaan) 
						values ('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_khusus."', '".$no_pidsus15_khusus."', '".$nom1."', '".$undang."', '".$pasal."', 
						'".$dakwaan."')";
					$connection->createCommand($sql3)->execute();
					
				}
			}*/

			$sql4 = "delete from pidsus.pds_pidsus15_khusus_tembusan where ".$whereDef." and no_pidsus15_khusus = '".$no_pidsus15_khusus."'";
			$connection->createCommand($sql4)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan = htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql5 = "insert into pidsus.pds_pidsus15_khusus_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_pidsus18."', '".$no_p8_khusus."', 
								 '".$no_pidsus15_khusus."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql5)->execute();
					}
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."pidsus15khusus_".$clean1."-".$clean2.".*");
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

    public function hapusData($post){
		$connection 	= $this->db;
		$pathfile	= Yii::$app->params['pidsus_15khusus'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
					and no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."' and no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'";

		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload from pidsus.pds_pidsus15_khusus where ".$whereDefault." and no_pidsus15_khusus = '".rawurldecode($tmp[0])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from pidsus.pds_pidsus15_khusus where ".$whereDefault." and no_pidsus15_khusus = '".rawurldecode($tmp[0])."'";
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
