<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsNotaPendapatPratut extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_nota_pendapat_t4';
    }
    public $tgl_minta_perpanjang;
    public function getJaksap16(){
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $no_spdp	= $_SESSION['no_spdp'];
        $tgl_spdp	= $_SESSION['tgl_spdp'];
        $sql = "
        select a.* 
        from pidsus.pds_p16_jaksa a 
        where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_spdp = '".$no_spdp."' 
                and a.tgl_spdp = '".$tgl_spdp."'";

        $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
        $count = $kueri->queryScalar();
        $sql .= " order by a.nama";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];
                $q1             = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "
                with tbl_jaksa as(
			select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_minta_perpanjang, string_agg(nama_jaksa_p16, '#') as jpunya 
			from pidsus.pds_nota_pendapat_t4_jaksa group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_minta_perpanjang 
		)
		select a.*, b.jpunya
		from pidsus.pds_nota_pendapat_t4 a 
                left join tbl_jaksa b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_minta_perpanjang = b.no_minta_perpanjang
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_spdp = '".$no_spdp."' 
			and a.tgl_spdp = '".$tgl_spdp."' ";
                if($q1)
                    $sql .= " and (to_char(a.tgl_nota, 'DD-MM-YYYY') = '".$q1."' or upper(a.no_minta_perpanjang) like '%".strtoupper($q1)."%' "
                        . "or upper(b.jpunya) like '%".strtoupper($q1)."%')";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_nota desc";
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
                $helpernya	= Yii::$app->inspektur;
                
		$no_minta_perpanjang                = htmlspecialchars($post['no_minta_perpanjang'], ENT_QUOTES);
		$tgl_nota                           = htmlspecialchars($post['tgl_nota'], ENT_QUOTES);
                $persetujuan                        = htmlspecialchars($post['persetujuan'], ENT_QUOTES);
                $tgl_awal_penahanan_oleh_penyidik   = htmlspecialchars($post['tgl_awal_penahanan_oleh_penyidik'], ENT_QUOTES);
                $tgl_akhir_penahanan_oleh_penyidik  = htmlspecialchars($post['tgl_akhir_penahanan_oleh_penyidik'], ENT_QUOTES);
                $tgl_awal_permintaan_perpanjangan   = htmlspecialchars($post['tgl_awal_permintaan_perpanjangan'], ENT_QUOTES);
                $tgl_akhir_permintaan_perpanjangan  = htmlspecialchars($post['tgl_akhir_permintaan_perpanjangan'], ENT_QUOTES);
                $kota                               = htmlspecialchars($post['kota'], ENT_QUOTES);
                
                $persetujuan                        = $persetujuan?$persetujuan:'0';
                $tgl_awal_penahanan_oleh_penyidik   = $tgl_awal_penahanan_oleh_penyidik?"'".$helpernya->tgl_db($tgl_awal_penahanan_oleh_penyidik)."'":'NULL';
                $tgl_akhir_penahanan_oleh_penyidik  = $tgl_akhir_penahanan_oleh_penyidik?"'".$helpernya->tgl_db($tgl_akhir_penahanan_oleh_penyidik)."'":'NULL';
                $tgl_awal_permintaan_perpanjangan   = $tgl_awal_permintaan_perpanjangan?"'".$helpernya->tgl_db($tgl_awal_permintaan_perpanjangan)."'":'NULL';
                $tgl_akhir_permintaan_perpanjangan  = $tgl_akhir_permintaan_perpanjangan?"'".$helpernya->tgl_db($tgl_akhir_permintaan_perpanjangan)."'":'NULL';
                $tgl_nota                           = $tgl_nota?"'".$helpernya->tgl_db($tgl_nota)."'":'NULL';
		
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
				$sql1 = "insert into pidsus.pds_nota_pendapat_t4(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_minta_perpanjang, tgl_nota, persetujuan, 
						 tgl_awal_penahanan_oleh_penyidik, tgl_akhir_penahanan_oleh_penyidik, tgl_awal_permintaan_perpanjangan, tgl_akhir_permintaan_perpanjangan, kota, created_user, created_nip, 
						 created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date) values('".$id_kejati."', 
						 '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$no_minta_perpanjang."', 
						 ".$tgl_nota.", '".$persetujuan."', ".$tgl_awal_penahanan_oleh_penyidik.", ".$tgl_akhir_penahanan_oleh_penyidik.", 
						 ".$tgl_awal_permintaan_perpanjangan.", ".$tgl_akhir_permintaan_perpanjangan.", '".$kota."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			}else{				
				$sql1 = "update pidsus.pds_nota_pendapat_t4 set tgl_nota = ".$tgl_nota.", persetujuan = '".$persetujuan."', 
						 tgl_awal_penahanan_oleh_penyidik = ".$tgl_awal_penahanan_oleh_penyidik.", tgl_akhir_penahanan_oleh_penyidik = ".$tgl_akhir_penahanan_oleh_penyidik.", tgl_awal_permintaan_perpanjangan = ".$tgl_awal_permintaan_perpanjangan.", 
						 tgl_akhir_permintaan_perpanjangan = ".$tgl_akhir_permintaan_perpanjangan.", kota = '".$kota."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW() 
						 where ".$whereDef." and no_minta_perpanjang = '".$no_minta_perpanjang."'";
			}
			$connection->createCommand($sql1)->execute();
                        
                        $sql2 = "delete from pidsus.pds_nota_pendapat_t4_jaksa where ".$whereDef." and no_minta_perpanjang = '".$no_minta_perpanjang."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['jaksa']) > 0){
				foreach($post['jaksa'] as $idx=>$val){
					list($nip_jaksa_p16, $nama_jaksa_p16, $jabatan_jaksa_p16, $pangkat_jaksa_p16) = explode("#", $val);
					$sql3 = "insert into pidsus.pds_nota_pendapat_t4_jaksa values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$no_minta_perpanjang."', 
							 '".($idx+1)."', '".$nip_jaksa_p16."',  '".$nama_jaksa_p16."', '".$jabatan_jaksa_p16."', '".$pangkat_jaksa_p16."')";
					$connection->createCommand($sql3)->execute();
				}
			}

			$sqlStatusSpdp = "update pidsus.pds_spdp set status_spdp = 'Nota Pendapat' where ".$whereDef;
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
					$sql1 = "delete from pidsus.pds_nota_pendapat_t4 where ".$whereDefault." and no_minta_perpanjang = '".rawurldecode($tmp[0])."'";
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
    
    public function cekMintaPerpanjangan($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari     = $_SESSION['kode_cabjari'];
		$nom_spdp  	= $_SESSION['no_spdp'];
		$tgl_spdp 	= $_SESSION['tgl_spdp'];

		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_minta_perpanjang= htmlspecialchars($post['no_minta_perpanjang'], ENT_QUOTES);
		$where 		= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$nom_spdp."' 
						and tgl_spdp = '".$tgl_spdp."'";

		$sqlCek1 	= "select count(*) from pidsus.pds_nota_pendapat_t4 where ".$where." and no_minta_perpanjang = '".$no_minta_perpanjang."'";
		$count1 	= ($isNew)?$connection->createCommand($sqlCek1)->queryScalar():0;

		if($count1 > 0){
			$pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>Nota Pendapat dengan Nomor Permintaan '.$no_minta_perpanjang.' sudah ada</i></p>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_perpanjangan");
		} else{
			return array("hasil"=>true, "error"=>"", "element"=>"");
		}
	}
        
        public function searchTglmintaperpanjang($post){
		$connection = $this->db;
		$q1         = htmlspecialchars($post['q1'], ENT_QUOTES);
                $id_kejati  = $_SESSION['kode_kejati'];
		$id_kejari  = $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
		$nom_spdp   = $_SESSION['no_spdp'];
		$tgl_spdp   = $_SESSION['tgl_spdp'];
                $where      = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$nom_spdp."' 
						and tgl_spdp = '".$tgl_spdp."'";
		$sql        = "select to_char(tgl_minta_perpanjang, 'DD-MM-YYYY')as tgl_minta_perpanjang from pidsus.pds_minta_perpanjang where ".$where." and no_minta_perpanjang='".$q1."'";
		
		$result     = $connection->createCommand($sql)->queryOne();
                $answer     = $result['tgl_minta_perpanjang'];
		return $answer;
	}

}
