<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class Kabupaten extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.m_kabupaten';
    }

	public function search($get){
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['q2'], ENT_QUOTES);
		$sql = "select a.*, b.deskripsi from datun.m_kabupaten a join datun.m_propinsi b on a.id_prop = b.id_prop where 1=1"; 
		if($q1)
			$sql .= " and (upper(a.id_kabupaten_kota) like '".strtoupper($q1)."%' or upper(a.deskripsi_kabupaten_kota) like '%".strtoupper($q1)."%' 
					or upper(b.deskripsi) like '%".strtoupper($q1)."%')";
		if($q2)
			$sql .= " and a.id_prop = '".$q2."'";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.id_prop, a.id_kabupaten_kota";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

    public function cekWilayah($post){
		$connection  = $this->db;
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$kode1 	= htmlspecialchars($post['kode'], ENT_QUOTES);
		$kode2 	= htmlspecialchars($post['kode_kab'], ENT_QUOTES);
		$sql 	= "select count(*) from datun.m_kabupaten where id_prop = '".$kode1."' and id_kabupaten_kota = '".$kode2."'";
		$count 	= ($isNew)?$connection->createCommand($sql)->queryScalar():0;
		return $count;
	}

    public function simpanData($post){
		$connection 	= $this->db;
		$isNewRecord 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$id_prop 		= htmlspecialchars($post['kode'], ENT_QUOTES);
		$id_kab 		= htmlspecialchars($post['kode_kab'], ENT_QUOTES);
		$deskripsi_kab	= htmlspecialchars($post['deskripsi'], ENT_QUOTES);
		
		$transaction = $connection->beginTransaction();
		try {
			if($isNewRecord){
				$sql1 = "insert into datun.m_kabupaten values('".$id_kab."', '".$id_prop."', '".$deskripsi_kab."')";
			} else{
				$sql1 = "update datun.m_kabupaten set deskripsi_kabupaten_kota = '".$deskripsi_kab."' where id_prop = '".$id_prop."' and id_kabupaten_kota = '".$id_kab."'";
			}
			$connection->createCommand($sql1)->execute();
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
					$tmp  = explode("#", $val);
					$sql1 = "delete from datun.m_kabupaten where id_prop = '".rawurldecode($tmp[0])."' and id_kabupaten_kota = '".rawurldecode($tmp[1])."'";
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
