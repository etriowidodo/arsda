<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class GetKewarganegaraan extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'public.ms_warganegara';
    }

	public function searchNegara($get){
		$q1  = htmlspecialchars($get['mwgn_q1'], ENT_QUOTES);
		$sql = "select * from public.ms_warganegara where 1=1";
		if($q1)
			$sql .= " and (upper(nama) like '%".strtoupper($q1)."%')";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
        ]);
        return $dataProvider;
    }

}