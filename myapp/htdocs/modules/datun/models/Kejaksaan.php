<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class Kejaksaan extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'kepegawaian.kp_inst_satker';
    }

	public function searchCustom($get){

		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$q2  = Yii::$app->user->identity->kode_tk;
		$q3  = Yii::$app->user->identity->kode_kejati;
		$q4  = Yii::$app->user->identity->kode_kejari;
		$q5  = Yii::$app->user->identity->kode_cabjari;
		$sql = "select inst_satkerkd, inst_nama, inst_lokinst, inst_alamat from kepegawaian.kp_inst_satker where 1=1"; 
		if($q2 == '1')
			$sql .= " and kode_kejati = '".$q3."'";
		else if($q2 == '2')
			$sql .= " and kode_kejati = '".$q3."' and kode_kejari = '".$q4."'";
		else if($q2 == '3')
			$sql .= " and kode_kejati = '".$q3."' and kode_kejari = '".$q4."' and kode_cabjari = '".$q5."'";
		if($q1)
			$sql .= " and (upper(inst_satkerkd) like '".strtoupper($q1)."%' or upper(inst_nama) like '%".strtoupper($q1)."%' or upper(inst_lokinst) like '%".strtoupper($q1)."%' 
					or upper(inst_alamat) like '%".strtoupper($q1)."%')";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by inst_satkerkd";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

}