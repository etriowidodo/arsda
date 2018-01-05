<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\modules\datun\models\MsWilayah;

class MsWilayahSearch extends MsWilayah{
	public function search($params){
        $query = MsWilayah::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'id_prop', $this->id_prop])
            ->andFilterWhere(['like', 'deskripsi', $this->deskripsi]);
        return $dataProvider;
    }

    public function searchCustom($params){
		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "select * from datun.m_propinsi where 1=1";
		if($q1)
			$sql .= " and (upper(deskripsi) like '%".strtoupper($q1)."%' or id_prop like '%".$q1."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by id_prop";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

    public function cekWilayah($post){
		$connection  = $this->db;
		$isNewRecord = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$q1  = htmlspecialchars($post['q1'], ENT_QUOTES);
		$sql = "select count(*) from datun.m_propinsi where id_prop = '".$q1."'";
		$count = ($isNewRecord)?$connection->createCommand($sql)->queryScalar():0;
		return $count;
	}

    public function simpanData($post){
		$connection 	= $this->db;
		$isNewRecord 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$kode 			= htmlspecialchars($post['kode'], ENT_QUOTES);
		$deskripsi 		= htmlspecialchars($post['deskripsi'], ENT_QUOTES);
		
		$transaction = $connection->beginTransaction();
		try {
			if($isNewRecord){
				$sql1 = "insert into datun.m_propinsi values('".$kode."', '".$deskripsi."')";
				$connection->createCommand($sql1)->execute();
			} else{
				$sql1 = "update datun.m_propinsi set deskripsi = '".$deskripsi."' where id_prop = '".$kode."'";				
				$connection->createCommand($sql1)->execute();
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    }

    public function hapusData($post){
		$connection = $this->db;
		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$sql1 = "delete from datun.m_propinsi where id_prop = '".$val."'";
					$connection->createCommand($sql1)->execute();
				}
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    }
}
