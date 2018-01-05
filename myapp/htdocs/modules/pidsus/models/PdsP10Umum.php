<?php 
namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsP10Umum extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p16';
    }
    
	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_p8_umum	= $_SESSION['pidsus_no_p8_umum'];

		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "select a.* from pidsus.pds_p10_umum a 
				where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_p8_umum = '".$no_p8_umum."'";

		if($q1)
			$sql .= " and (upper(a.no_p10_umum) like '%".strtoupper($q1)."%' or to_char(a.tgl_p10_umum, 'DD-MM-YYYY') = '".$q1."' 
				or upper(a.kepada_nama) like '%".strtoupper($q1)."%' or upper(a.keterangan_ahli) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_p10_umum desc, a.created_date desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
    public function cekPdsP10Umum($post){
        $connection  = $this->db;
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $helpernya	= Yii::$app->inspektur;
        $isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $no_p10_umum = htmlspecialchars($post['no_p10_umum'], ENT_QUOTES);
        $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p10_umum = '".$no_p10_umum."'";
        
        $sql 	= "select count(*) from pidsus.pds_p10_umum where ".$whereDef;
		if($isNew){
			$count 	= $connection->createCommand($sql)->queryScalar();
		} else{
			$id1 	= $_SESSION["pidsus_no_p10_umum"];
			$count 	= ($id1 == $no_p10_umum)?0:$connection->createCommand($sql)->queryScalar();
		}
        
        if($count > 0){
            $pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>P-10 Umum dengan nomor '.$no_p10_umum.' sudah ada</i></p>';
            return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_p10_umum");
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
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_p8_umum		= htmlspecialchars($post['no_p8_umum'], ENT_QUOTES);
		$no_p10_umum	= htmlspecialchars($post['no_p10_umum'], ENT_QUOTES);
		$tgl_p10_umum	= htmlspecialchars($post['tgl_p10_umum'], ENT_QUOTES);

		$sifat 				= htmlspecialchars($post['sifat'], ENT_QUOTES);
		$lampiran			= htmlspecialchars($post['lampiran'], ENT_QUOTES);
		$kepada_nama		= htmlspecialchars($post['kepada_nama'], ENT_QUOTES);
		$di_tempat 			= htmlspecialchars($post['di_tempat'], ENT_QUOTES);
		$keterangan_ahli	= htmlspecialchars($post['keterangan_ahli'], ENT_QUOTES);

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
		$pathfile	= Yii::$app->params['p10_umum'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_umum);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_p10_umum);
		$newPhoto 	= "p10umum_".$clean1."-".$clean2.$extPhoto;
		$whereDef 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p8_umum = '".$no_p8_umum."'";

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
				$sql1 = "insert into pidsus.pds_p10_umum(id_kejati, id_kejari, id_cabjari, no_p8_umum, no_p10_umum, tgl_p10_umum, sifat, lampiran, kepada_nama, di_tempat, 
						 keterangan_ahli, penandatangan_nama, penandatangan_nip, penandatangan_jabatan_pejabat, penandatangan_gol, penandatangan_pangkat, 
						 penandatangan_status_ttd, penandatangan_jabatan_ttd, file_upload, created_user, created_nip, created_nama, created_ip, created_date, updated_user, 
						 updated_nip, updated_nama, updated_ip, updated_date) values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".$no_p10_umum."', 
						 '".$helpernya->tgl_db($tgl_p10_umum)."', '".$sifat."', '".$lampiran."', '".$kepada_nama."', '".$di_tempat."', '".$keterangan_ahli."', 
						 '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', 
						 '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$newPhoto."', '".$created_user."', '".$created_nip."', '".$created_nama."', 
						 '".$created_ip."', NOW(), '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_p10_umum set no_p10_umum = '".$no_p10_umum."', tgl_p10_umum = '".$helpernya->tgl_db($tgl_p10_umum)."', 
						 sifat = '".$sifat."', lampiran = '".$lampiran."', kepada_nama = '".$kepada_nama."', di_tempat = '".$di_tempat."', 
						 keterangan_ahli = '".$keterangan_ahli."', penandatangan_nama = '".$penandatangan_nama."', penandatangan_nip = '".$penandatangan_nip."', 
						 penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_p10_umum = '".$_SESSION['pidsus_no_p10_umum']."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql4 = "delete from pidsus.pds_p10_umum_tembusan where ".$whereDef." and no_p10_umum = '".$no_p10_umum."'";
			$connection->createCommand($sql4)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan = htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql5 = "insert into pidsus.pds_p10_umum_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', 
								 '".$no_p10_umum."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql5)->execute();
					}
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."p10umum_".$clean1."-".$clean2.".*");
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
		$pathfile		= Yii::$app->params['p10_umum'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";

		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload from pidsus.pds_p10_umum where ".$whereDefault." and no_p10_umum = '".rawurldecode($tmp[0])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from pidsus.pds_p10_umum where ".$whereDefault." and no_p10_umum = '".rawurldecode($tmp[0])."'";
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
