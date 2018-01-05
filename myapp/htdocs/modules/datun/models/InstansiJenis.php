<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class InstansiJenis extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.jenis_instansi';
    }

	public function search($get){
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$sql = "select * from datun.jenis_instansi where 1=1"; 
		if($q1)
			$sql .= " and (upper(kode_jenis_instansi) like '".strtoupper($q1)."%' or upper(deskripsi_jnsinstansi) like '%".strtoupper($q1)."%')";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by kode_jenis_instansi";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

	public function simpanData($post){
		$connection = Yii::$app->db;		
		$kode 		= htmlspecialchars($post['kode'], ENT_QUOTES);
		$deskripsi 	= htmlspecialchars($post['deskripsi'], ENT_QUOTES);
		
		$transaction = $connection->beginTransaction();
		try {
			$sql1 = "update datun.jenis_instansi set deskripsi_jnsinstansi = '".$deskripsi."' where kode_jenis_instansi = '".$kode."'";
			$connection->createCommand($sql1)->execute();
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
	}

}
