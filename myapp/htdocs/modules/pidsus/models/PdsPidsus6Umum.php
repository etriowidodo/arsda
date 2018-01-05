<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsPidsus6Umum extends \yii\db\ActiveRecord{
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
		with tbl_jaksa as(
			select id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus6_umum, string_agg(nip_jaksa||'--'||nama_jaksa, '#' order by no_urut) as jpunya 
			from pidsus.pds_pidsus6_umum_penelaah group by id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus6_umum 
		)
		select a.*, b.jpunya 
		from pidsus.pds_pidsus6_umum a 
		left join tbl_jaksa b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_p8_umum = b.no_p8_umum and a.no_pidsus6_umum = b.no_pidsus6_umum
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_p8_umum = '".$no_p8_umum."'";
		if($q1)
			$sql .= " and (upper(a.no_pidsus6_umum) like '%".strtoupper($q1)."%' or to_char(a.tgl_dikeluarkan, 'DD-MM-YYYY') = '".$q1."' 
					  or upper(b.jpunya) like '%".strtoupper($q1)."%')";
                
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_dikeluarkan desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
    public function cekPdsPidsus6Umum($post){
        $connection  = $this->db;
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $helpernya	= Yii::$app->inspektur;
        $isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $no_pidsus6_umum = htmlspecialchars($post['no_pidsus6_umum'], ENT_QUOTES);
        $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_pidsus6_umum = '".$no_pidsus6_umum."'";
        
        $sql 	= "select count(*) from pidsus.pds_pidsus6_umum where ".$whereDef;
		if($isNew){
			$count 	= $connection->createCommand($sql)->queryScalar();
		} else{
			$id1 	= $_SESSION["pidsus_no_pidsus6_umum"];
			$count 	= ($id1 == $no_pidsus6_umum)?0:$connection->createCommand($sql)->queryScalar();
		}
        
        if($count > 0){
            $pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>Pidsus-6 Umum dengan nomor '.$no_pidsus6_umum.' sudah ada</i></p>';
            return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_pidsus6_umum");
        } else{
            return array("hasil"=>true, "error"=>"", "element"=>"");
        }
	}

	public function simpanData($post){
		$helpernya	= Yii::$app->inspektur;
		$connection = $this->db;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_p8_umum				= htmlspecialchars($post['no_p8_umum'], ENT_QUOTES);
		$no_pidsus6_umum 		= htmlspecialchars($post['no_pidsus6_umum'], ENT_QUOTES);
		$tgl_dikeluarkan		= htmlspecialchars($post['tgl_dikeluarkan'], ENT_QUOTES);
		$tempat_dikeluarkan		= htmlspecialchars($post['tempat_dikeluarkan'], ENT_QUOTES);

		$penandatangan_nama     = htmlspecialchars($post['penandatangan_nama'], ENT_QUOTES);
		$penandatangan_nip      = htmlspecialchars($post['penandatangan_nip'], ENT_QUOTES);
		$penandatangan_jabatan  = htmlspecialchars($post['penandatangan_jabatan'], ENT_QUOTES);
		$penandatangan_gol      = htmlspecialchars($post['penandatangan_gol'], ENT_QUOTES);
		$penandatangan_pangkat  = htmlspecialchars($post['penandatangan_pangkat'], ENT_QUOTES);
		$penandatangan_status_ttd   = htmlspecialchars($post['penandatangan_status'], ENT_QUOTES);
		$penandatangan_jabatan_ttd  = htmlspecialchars($post['penandatangan_ttdjabat'], ENT_QUOTES);

		$created_user		= $_SESSION['username'];
		$created_nip		= $_SESSION['nik_user'];
		$created_nama		= $_SESSION['nama_pegawai'];
		$created_ip			= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai'];
		$updated_ip			= $_SERVER['REMOTE_ADDR'];

		$filePhoto1 = htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto1 = htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto1 = htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto1 	= substr($filePhoto1,strrpos($filePhoto1,'.'));

		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['pidsus_6umum'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_umum);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_pidsus6_umum);
		$newPhoto1 	= "pidsus_6umum_".$clean1."-".$clean2.$extPhoto1;
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
				$sql1 = "insert into pidsus.pds_pidsus6_umum(id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus6_umum, tempat_dikeluarkan, tgl_dikeluarkan, 
						 penandatangan_nama, penandatangan_nip, penandatangan_jabatan_pejabat, penandatangan_gol, penandatangan_pangkat, penandatangan_status_ttd, 
						 penandatangan_jabatan_ttd, file_upload, created_user, created_nip, created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, 
						 updated_ip, updated_date)  values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".$no_pidsus6_umum."', 
						 '".$tempat_dikeluarkan."', '".$helpernya->tgl_db($tgl_dikeluarkan)."', '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', 
						 '".$penandatangan_gol."', '".$penandatangan_pangkat."', '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$newPhoto1."', 
						 '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			} else{
				if($filePhoto1 != ""){
					$upl1 = true;
					$filenya1 = ", file_upload = '".$newPhoto1."'";
				} else{
					$upl1 = false;
					$filenya1 = "";
				}

				$sql1 = "update pidsus.pds_pidsus6_umum set no_pidsus6_umum = '".$no_pidsus6_umum."', tgl_dikeluarkan = '".$helpernya->tgl_db($tgl_dikeluarkan)."', 
						 tempat_dikeluarkan = '".$tempat_dikeluarkan."', penandatangan_nama = '".$penandatangan_nama."', 
						 penandatangan_nip = '".$penandatangan_nip."', penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_pidsus6_umum = '".$_SESSION['pidsus_no_pidsus6_umum']."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql2 = "delete from pidsus.pds_pidsus6_umum_penelaah where ".$whereDef." and no_pidsus6_umum = '".$no_pidsus6_umum."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['jpnid']) > 0){
				foreach($post['jpnid'] as $idx=>$val){
					list($nip_jaksa, $nama_jaksa, $pangkatgol, $gol_jaksa, $pangkat_jaksa, $jabatan_jaksa) = explode("#", $val);
					$sql3 = "insert into pidsus.pds_pidsus6_umum_penelaah values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".$no_pidsus6_umum."', 
							 '".($idx+1)."', '".$nip_jaksa."', '".$nama_jaksa."', '".$gol_jaksa."', '".$pangkat_jaksa."', '".$jabatan_jaksa."')";
					$connection->createCommand($sql3)->execute();
				}
			}

			$sql4 = "delete from pidsus.pds_pidsus6_umum_tembusan where ".$whereDef." and no_pidsus6_umum = '".$no_pidsus6_umum."'";
			$connection->createCommand($sql4)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql5 = "insert into pidsus.pds_pidsus6_umum_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', 
								 '".$no_pidsus6_umum."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql5)->execute();
					}
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."pidsus_6umum_".$clean1."-".$clean2.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto1;
				$mantab  = move_uploaded_file($tempPhoto1, $tujuan);
				if(file_exists($tempPhoto1)) unlink($tempPhoto1);
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
		$pathfile		= Yii::$app->params['pidsus_6umum'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";

		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload from pidsus.pds_pidsus6_umum where ".$whereDefault." and no_pidsus6_umum = '".rawurldecode($tmp[0])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from pidsus.pds_pidsus6_umum where ".$whereDefault." and no_pidsus6_umum = '".rawurldecode($tmp[0])."'";
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
