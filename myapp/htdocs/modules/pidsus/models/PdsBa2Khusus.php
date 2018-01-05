<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsBa2Khusus extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p16';
    }
    
	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_pidsus18	= $_SESSION['pidsus_no_pidsus18'];
		$no_p8_khusus	= $_SESSION['pidsus_no_p8_khusus'];

		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "select a.* from pidsus.pds_ba2_khusus a 
				where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_pidsus18 = '".$no_pidsus18."' and a.no_p8_khusus = '".$no_p8_khusus."'";

		if($q1)
			$sql .= " and (to_char(a.tgl_ba2_khusus, 'DD-MM-YYYY') = '".$q1."' or upper(a.nip_jaksa) like '%".strtoupper($q1)."%' 
			or upper(a.nama_jaksa) like '%".strtoupper($q1)."%' or upper(a.pangkat_jaksa) like '%".strtoupper($q1)."%' or upper(a.nama) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_ba2_khusus desc, a.created_date desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
	public function searchSaksi($get){
		$q1  = htmlspecialchars($get['mjpn_q1'], ENT_QUOTES);
		$sql = "select peg_nip_baru, nama, gol_pangkat, jabatan from kepegawaian.kp_pegawai where inst_satkerkd = '".$_SESSION["inst_satkerkd"]."'";
		if($q1)
			$sql .= " and (upper(peg_nip_baru) like '".strtoupper($q1)."%' or upper(nama) like '%".strtoupper($q1)."%' or upper(gol_pangkat) like '%".strtoupper($q1)."%' 
					or upper(jabatan) like '%".strtoupper($q1)."%')";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by ref_jabatan_kd, unitkerja_kd";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
        ]);
        return $dataProvider;
	}

	public function searchBa1Khusus($get){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_pidsus18	= $_SESSION['pidsus_no_pidsus18'];
		$no_p8_khusus	= $_SESSION['pidsus_no_p8_khusus'];

		$q1  = htmlspecialchars($params['mba1u_q1'], ENT_QUOTES);
		$sql = "
		select a.*, b.nama as kebangsaan, c.nama as pendidikan, d.nama as agama 
		from pidsus.pds_ba1_khusus a 
		left join public.ms_warganegara b on a.warganegara = b.id 
		left join public.ms_pendidikan c on a.id_pendidikan = c.id_pendidikan  
		left join public.ms_agama d on a.id_agama = d.id_agama  
		where a.status = 'Saksi' and a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' 
		and a.no_pidsus18 = '".$no_pidsus18."' and a.no_p8_khusus = '".$no_p8_khusus."'";

		if($q1)
			$sql .= " and (to_char(a.tgl_ba1_khusus, 'DD-MM-YYYY') = '".$q1."' or upper(a.nip_jaksa) like '%".strtoupper($q1)."%' 
			or upper(a.nama_jaksa) like '%".strtoupper($q1)."%' or upper(a.pangkat_jaksa) like '%".strtoupper($q1)."%' or upper(a.nama) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_ba1_khusus desc, a.created_date desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
	}

	public function simpanData($post){
		$helpernya	= Yii::$app->inspektur;
		$connection = $this->db;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_pidsus18	= $_SESSION['pidsus_no_pidsus18'];
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_p8_khusus	= htmlspecialchars($post['no_p8_khusus'], ENT_QUOTES);
		$no_ba2_khusus 	= ($post['no_ba2_khusus'])?htmlspecialchars($post['no_ba2_khusus'], ENT_QUOTES):0;
		$tgl_ba2_khusus	= htmlspecialchars($post['tgl_ba2_khusus'], ENT_QUOTES);
		$jam_ba2_khusus	= htmlspecialchars($post['jam_ba2_khusus'], ENT_QUOTES);

  		$tempat			= htmlspecialchars($post['tempat'], ENT_QUOTES);
		$nip_jaksa		= htmlspecialchars($post['nip_jaksa'], ENT_QUOTES);
		$nama_jaksa		= htmlspecialchars($post['nama_jaksa'], ENT_QUOTES);
		$pangkat_jaksa          = htmlspecialchars($post['pangkat_jaksa'], ENT_QUOTES);
		$nama			= htmlspecialchars($post['nama'], ENT_QUOTES);
		$tmpt_lahir		= htmlspecialchars($post['tmpt_lahir'], ENT_QUOTES);
		$tgl_lahir		= htmlspecialchars($post['tgl_lahir'], ENT_QUOTES);
		$id_jkl			= htmlspecialchars($post['id_jkl'], ENT_QUOTES);
		$warganegara            = htmlspecialchars($post['warganegara'], ENT_QUOTES);
		$alamat			= htmlspecialchars($post['alamat'], ENT_QUOTES);
		$id_agama		= htmlspecialchars($post['id_agama'], ENT_QUOTES);
		$pekerjaan		= htmlspecialchars($post['pekerjaan'], ENT_QUOTES);
		$id_pendidikan          = htmlspecialchars($post['pendidikan'], ENT_QUOTES);
		$umur			= htmlspecialchars($post['umur'], ENT_QUOTES);
		$tgl_keterangan         = htmlspecialchars($post['tgl_ba1_khusus'], ENT_QUOTES);

		$id_jkl			= ($id_jkl)?$id_jkl:'0';
		$warganegara            = ($warganegara)?$warganegara:'0';
		$id_agama		= ($id_agama)?$id_agama:'0';
		$id_pendidikan          = ($id_pendidikan)?$id_pendidikan:'-1';
		$umur			= ($umur)?$umur:'0';

		$created_user		= $_SESSION['username'];
		$created_nip		= $_SESSION['nik_user'];
		$created_nama		= $_SESSION['nama_pegawai'];
		$created_ip		= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai'];
		$updated_ip		= $_SERVER['REMOTE_ADDR'];

		$sql0 = "select coalesce(max(no_ba2_khusus)+1,1) as nourut from pidsus.pds_ba2_khusus 
				 where id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_pidsus18 = '".$no_pidsus18."' and no_p8_khusus = '".$no_p8_khusus."'";
		$row0 = $connection->createCommand($sql0)->queryScalar();

		$filePhoto1 = htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto1 = htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto1 = htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto1  = substr($filePhoto1,strrpos($filePhoto1,'.'));

		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['ba2_khusus'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_khusus);
		$clean2 	= ($isNew)?$row0:$no_ba2_khusus;
		$newPhoto1 	= "ba2_khusus_".$clean1."-".$clean2.$extPhoto1;
		$whereDef 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_pidsus18 = '".$no_pidsus18."' and no_p8_khusus = '".$no_p8_khusus."'";

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
				$sql1 = "insert into pidsus.pds_ba2_khusus(id_kejati, id_kejari, id_cabjari, no_pidsus18, no_p8_khusus, no_ba2_khusus, tgl_ba2_khusus, tempat, nip_jaksa, nama_jaksa, pangkat_jaksa, 
						 nama, tmpt_lahir, tgl_lahir, umur, id_jkl, warganegara, alamat, id_agama, pekerjaan, id_pendidikan, tgl_keterangan, file_upload, created_user, 
						 created_nip, created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date, jam_ba2_khusus) 
						 values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_pidsus18."', '".$no_p8_khusus."', '".$row0."', '".$helpernya->tgl_db($tgl_ba2_khusus)."', '".$tempat."', 
						 '".$nip_jaksa."', '".$nama_jaksa."', '".$pangkat_jaksa."', '".$nama."', '".$tmpt_lahir."', '".$helpernya->tgl_db($tgl_lahir)."', 
						 '".$umur."', '".$id_jkl."', '".$warganegara."', '".$alamat."', '".$id_agama."', '".$pekerjaan."', '".$id_pendidikan."', 
						 '".$helpernya->tgl_db($tgl_keterangan)."', '".$newPhoto1."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW(), '".$jam_ba2_khusus."')";
			}else{
				if($filePhoto1 != ""){
					$upl1 = true;
					$filenya1 = ", file_upload = '".$newPhoto1."'";
				} else{
					$upl1 = false;
					$filenya1 = "";
				}

				$sql1 = "update pidsus.pds_ba2_khusus set tgl_ba2_khusus = '".$helpernya->tgl_db($tgl_ba2_khusus)."', tempat = '".$tempat."', nip_jaksa = '".$nip_jaksa."', 
						 nama_jaksa = '".$nama_jaksa."', pangkat_jaksa = '".$pangkat_jaksa."', nama = '".$nama."', tmpt_lahir = '".$tmpt_lahir."', 
						 tgl_lahir = '".$helpernya->tgl_db($tgl_lahir)."', umur = '".$umur."', id_jkl = '".$id_jkl."', warganegara = '".$warganegara."', alamat = '".$alamat."', 
						 id_agama = '".$id_agama."', pekerjaan = '".$pekerjaan."', id_pendidikan = '".$id_pendidikan."', jam_ba2_khusus = '".$jam_ba2_khusus."', 
						 tgl_keterangan = '".$helpernya->tgl_db($tgl_keterangan)."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya1." 
						 where ".$whereDef." and no_ba2_khusus = '".$no_ba2_khusus."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql2 = "delete from pidsus.pds_ba2_khusus_saksi where ".$whereDef." and no_ba2_khusus = '".$no_ba2_khusus."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['jpnid']) > 0){
				$nourut = ($isNew)?$row0:$no_ba2_khusus;
				foreach($post['jpnid'] as $idx=>$val){
					list($nip, $nama, $pangkat, $jabatan) = explode("#", $val);
					$sql3 = "insert into pidsus.pds_ba2_khusus_saksi values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_pidsus18."', '".$no_p8_khusus."', '".$nourut."', 
							 '".$helpernya->tgl_db($tgl_ba2_khusus)."', '".($idx+1)."', '".$nip."', '".$nama."', '".$pangkat."', '".$jabatan."')";
					$connection->createCommand($sql3)->execute();
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."ba2_khusus_".$clean1."-".$clean2.".*");
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
		$pathfile		= Yii::$app->params['ba2_khusus'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."' and no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload from pidsus.pds_ba2_khusus where ".$whereDefault." and no_ba2_khusus = '".rawurldecode($tmp[0])."'";
					$file = $connection->createCommand($kue)->queryOne();
					if($file['file_upload'] && file_exists($pathfile.$file['file_upload'])) unlink($pathfile.$file['file_upload']);

					$sql1 = "delete from pidsus.pds_ba2_khusus where ".$whereDefault." and no_ba2_khusus = '".rawurldecode($tmp[0])."'";
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
