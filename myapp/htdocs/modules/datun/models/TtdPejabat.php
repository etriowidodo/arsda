<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class TtdPejabat extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.m_penandatangan_pejabat';
    }

	public function search($get){
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['q2'], ENT_QUOTES);
		$sql = "select a.*, b.nama, b.jabatan, c.deskripsi as jabatan_ttd, 
				case when b.pns_jnsjbtfungsi = 0 then b.gol_kd||' '||b.gol_pangkatjaksa else b.gol_kd||' '||b.gol_pangkat2 end as pangkat 
				from datun.m_penandatangan_pejabat a join kepegawaian.kp_pegawai b on a.nip = b.peg_nip_baru 
				join datun.m_penandatangan c on a.kode_tk = c.kode_tk and a.kode = c.kode where a.kode_tk = '".$_SESSION['kode_tk']."'";
		if($q1)
			$sql .= " and (a.nip like '%".$q1."%' or upper(b.nama) like '%".strtoupper($q1)."%' or upper(b.jabatan) like '%".strtoupper($q1)."%' 
					or upper(a.status) = '".strtoupper($q1)."' or upper(b.gol_kd) like '%".strtoupper($q1)."%' or upper(b.gol_pangkatjaksa) like '%".strtoupper($q1)."%' 
					or upper(b.gol_pangkat2) like '%".strtoupper($q1)."%')";	
		if($q2)
			$sql .= " and a.kode = '".$q2."'";	

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by kode_tk, kode, nip";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);

        return $dataProvider;
    }

    public function cekTtdPejabat($post){
		$connection = $this->db;
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$kode	= htmlspecialchars($post['kode_ttd'], ENT_QUOTES);
		$nip 	= htmlspecialchars($post['peg_nip'], ENT_QUOTES);
		$kodeTk = $_SESSION['kode_tk'];
		$sql 	= "select count(*) from datun.m_penandatangan_pejabat where kode = '".$kode."' and kode_tk = '".$kodeTk."' and nip = '".$nip."'";
		$count 	= ($isNew)?$this->db->createCommand($sql)->queryScalar():0;
		return $count;
	}

    public function simpanData($post){
		$connection = $this->db;
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$kode 		= htmlspecialchars($post['kode_ttd'], ENT_QUOTES);
		$nip 		= htmlspecialchars($post['peg_nip'], ENT_QUOTES);
		$status 	= htmlspecialchars($post['status'], ENT_QUOTES);
		$kode_tk 	= $_SESSION['kode_tk'];
		
		$transaction = $connection->beginTransaction();
		try {
			if($isNew){
				$sql1 = "insert into datun.m_penandatangan_pejabat values('".$kode_tk."', '".$kode."', '".$nip."', '".$status."')";
				$connection->createCommand($sql1)->execute();
			} else{
				$sql1 = "update datun.m_penandatangan_pejabat set status = '".$status."' where kode_tk = '".$kode_tk."' and kode = '".$kode."' and nip = '".$nip."'";				
				$connection->createCommand($sql1)->execute();
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }

    public function hapusData($post){
		$connection = $this->db;
		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$idny = explode("#", $val); 
					$sql1 = "delete from datun.m_penandatangan_pejabat where kode = '".rawurldecode($idny[0])."' and nip = '".rawurldecode($idny[1])."' 
							 and kode_tk = '".rawurldecode($idny[2])."'";
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
