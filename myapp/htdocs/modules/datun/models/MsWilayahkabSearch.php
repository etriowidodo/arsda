<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\modules\datun\models\MsWilayahkab;

class MsWilayahkabSearch extends MsWilayahkab{
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
		$id  = htmlspecialchars($params['id'], ENT_QUOTES);
		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "select * from datun.m_kabupaten where id_prop = '".$id."'";
		if($q1)
			$sql .= " and (upper(deskripsi_kabupaten_kota) like '%".strtoupper($q1)."%' or id_kabupaten_kota = '%".$q1."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by id_kabupaten_kota";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

    public function cekKabupaten($post){
		$connection  = $this->db;
		$isNewRecord = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$q1  = htmlspecialchars($post['q1'], ENT_QUOTES);
		$q2  = htmlspecialchars($post['q2'], ENT_QUOTES);
		$sql = "select count(*) from datun.m_kabupaten where id_prop = '".$q1."' and id_kabupaten_kota = '".$q2."'";
		$count = ($isNewRecord)?$connection->createCommand($sql)->queryScalar():0;
		return $count;
	}

    public function simpanData($post){
		$connection 	= $this->db;
		$isNewRecord 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$kode 			= htmlspecialchars($post['kode'], ENT_QUOTES);
		$kode_kab 		= htmlspecialchars($post['kode_kab'], ENT_QUOTES);
		$deskripsi 		= htmlspecialchars($post['deskripsi'], ENT_QUOTES);
		
		$transaction = $connection->beginTransaction();
		try {
			if($isNewRecord){
				$sql1 = "insert into datun.m_kabupaten values('".$kode_kab."', '".$kode."', '".$deskripsi."')";
				$connection->createCommand($sql1)->execute();
			} else{
				$sql1 = "update datun.m_kabupaten set deskripsi_kabupaten_kota = '".$deskripsi."' where id_prop = '".$kode."' and id_kabupaten_kota = '".$kode_kab."'";				
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
					$idny = explode(".", $val); 
					$sql1 = "delete from datun.m_kabupaten where id_prop = '".$idny[0]."' and id_kabupaten_kota = '".$idny[1]."'";
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
