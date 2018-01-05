<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class Provinsi extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.m_propinsi';
    }

	public function search($get){
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$sql = "select * from datun.m_propinsi where 1=1"; 
		if($q1)
			$sql .= " and (upper(id_prop) like '".strtoupper($q1)."%' or upper(deskripsi) like '%".strtoupper($q1)."%')";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by id_prop";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

    public function cekPropinsi($post){
		$connection  = $this->db;
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$kode 	= htmlspecialchars($post['kode'], ENT_QUOTES);
		$sql 	= "select count(*) from datun.m_propinsi where id_prop = '".$kode."'";
		$count 	= ($isNew)?$connection->createCommand($sql)->queryScalar():0;
		return $count;
	}

    public function simpanData($post){
		$connection 	= $this->db;
		$isNewRecord 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$id_prop 		= htmlspecialchars($post['kode'], ENT_QUOTES);
		$deskripsi		= htmlspecialchars($post['deskripsi'], ENT_QUOTES);
		
		$transaction = $connection->beginTransaction();
		try {
			if($isNewRecord){
				$sql1 = "insert into datun.m_propinsi values('".$id_prop."', '".$deskripsi."')";
			} else{
				$sql1 = "update datun.m_propinsi set deskripsi = '".$deskripsi."' where id_prop = '".$id_prop."'";
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
					$sql1 = "delete from datun.m_propinsi where id_prop = '".rawurldecode($val)."'";
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
