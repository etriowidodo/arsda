<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class BaKonsultasi extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p16';
    }

	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];
                $q1             = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "
		select a.* 
		from pidsus.pds_ba_konsultasi a 
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_spdp = '".$no_spdp."' 
			and a.tgl_spdp = '".$tgl_spdp."'";
                if($q1)
                    $sql .= " and (to_char(a.tgl_pelaksanaan, 'DD-MM-YYYY') = '".$q1."' or upper(a.nama_jaksa) like '%".strtoupper($q1)."%' or upper(a.nama_penyidik) like '%".strtoupper($q1)."%')";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_pelaksanaan desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

	public function simpanData($post){
		$connection 	= $this->db;
		$id_kejati      = $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];

		$id_ba_konsultasi   = htmlspecialchars($post['id_ba_konsultasi'], ENT_QUOTES);
		$tgl_pelaksanaan    = htmlspecialchars($post['tgl_pelaksanaan'], ENT_QUOTES);
		$jaksa              = htmlspecialchars($post['jaksa'], ENT_QUOTES);
		list($nip_jaksa, $nama_jaksa, $golpangkat, $gol, $jabatan_jaksa) = explode("|#|", $jaksa);
                $nip_penyidik       = htmlspecialchars($post['nip_penyidik'], ENT_QUOTES);
                $nama_penyidik      = htmlspecialchars($post['nama_penyidik'], ENT_QUOTES);
                $jabatan_penyidik   = htmlspecialchars($post['jabatan_penyidik'], ENT_QUOTES);
                $konsultasi_formil  = htmlspecialchars($post['konsultasi_formil'], ENT_QUOTES);
                $konsultasi_materil = htmlspecialchars($post['konsultasi_materil'], ENT_QUOTES);
                $kesimpulan         = htmlspecialchars($post['kesimpulan'], ENT_QUOTES);
		
                $helpernya	= Yii::$app->inspektur;
		$created_user	= $_SESSION['username'];
		$created_nip	= $_SESSION['nik_user'];
		$created_nama	= $_SESSION['nama_pegawai'];
		$created_ip	= $_SERVER['REMOTE_ADDR'];
		$updated_user	= $_SESSION['username'];
		$updated_nip	= $_SESSION['nik_user'];
		$updated_nama	= $_SESSION['nama_pegawai'];
		$updated_ip	= $_SERVER['REMOTE_ADDR'];

		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$no_spdp."' and tgl_spdp = '".$tgl_spdp."'";
		$transaction = $connection->beginTransaction();
		try{
			if($isNew){
				$sql1 = "insert into pidsus.pds_ba_konsultasi(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, id_ba_konsultasi, tgl_pelaksanaan, nip_jaksa, nama_jaksa, 
						 jabatan_jaksa, nip_penyidik, nama_penyidik, jabatan_penyidik, konsultasi_formil, konsultasi_materil, kesimpulan, created_user, created_nip, 
						 created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date) values('".$id_kejati."', 
						 '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$id_ba_konsultasi."', '".$helpernya->tgl_db($tgl_pelaksanaan)."', 
						 '".$nip_jaksa."', '".$nama_jaksa."', '".$jabatan_jaksa."', '".$nip_penyidik."', '".$nama_penyidik."', 
						 '".$jabatan_penyidik."', '".$konsultasi_formil."', '".$konsultasi_materil."', '".$kesimpulan."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			}else{				
				$sql1 = "update pidsus.pds_ba_konsultasi set tgl_pelaksanaan = '".$helpernya->tgl_db($tgl_pelaksanaan)."', nip_jaksa = '".$nip_jaksa."', 
						 nama_jaksa = '".$nama_jaksa."', jabatan_jaksa = '".$jabatan_jaksa."', nip_penyidik = '".$nip_penyidik."', 
						 nama_penyidik = '".$nama_penyidik."', jabatan_penyidik = '".$jabatan_penyidik."', 
						 konsultasi_formil = '".$konsultasi_formil."', konsultasi_materil = '".$konsultasi_materil."', kesimpulan = '".$kesimpulan."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW() 
						 where ".$whereDef." and id_ba_konsultasi = '".$id_ba_konsultasi."'";
			}
			$connection->createCommand($sql1)->execute();

			$sqlStatusSpdp = "update pidsus.pds_spdp set status_spdp = 'BA-Konsultasi' where ".$whereDef;
			$connection->createCommand($sqlStatusSpdp)->execute();

			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }

    public function hapusData($post){
		$connection 	= $this->db;
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
				and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$sql1 = "delete from pidsus.pds_ba_konsultasi where ".$whereDefault." and id_ba_konsultasi = '".rawurldecode($tmp[0])."'";
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
    
    public function cekBa($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
		$nom_spdp  	= $_SESSION['no_spdp'];
		$tgl_spdp 	= $_SESSION['tgl_spdp'];

		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$tgl_pelaksanaan= htmlspecialchars($post['tgl_pelaksanaan'], ENT_QUOTES);
		$where 		= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$nom_spdp."' 
						and tgl_spdp = '".$tgl_spdp."'";
                
                $sqlCek 	= "select tgl_terima from pidsus.pds_spdp where ".$where;
                $res            = $connection->createCommand($sqlCek)->queryOne();
                $tgl_terima     = ($res['tgl_terima'])?date("d-m-Y", strtotime($res['tgl_terima'])):'';
                
		if(strtotime($tgl_terima) > strtotime($tgl_pelaksanaan)){
			$pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>* Tanggal pelaksanaan lebih kecil dari tanggal terima SPDP</i></p>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_tglpelaksanaan");
		} else{
			return array("hasil"=>true, "error"=>"", "element"=>"");
		}
	}

}
