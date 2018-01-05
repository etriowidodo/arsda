<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class GetSkks extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.m_penandatangan';
    }

	 public function getSkks($post){
		$helpernya	= Yii::$app->inspektur;
		$tq1 = htmlspecialchars($post['q1'], ENT_QUOTES);
		$tq2 = htmlspecialchars($post['q2'], ENT_QUOTES);
		$sql = "select a.no_register_skks, a.tanggal_ttd as tanggal_skks from datun.skks a 
				where a.no_register_perkara = '".$_SESSION['no_register_perkara']."' and a.no_surat = '".$_SESSION['no_surat']."' 
					and a.no_register_skk = '".$tq1."' and a.tanggal_skk = '".$helpernya->tgl_db($tq2)."' and a.penerima_kuasa = 'JPN' 
				order by a.is_active desc";
		$result = $this->db->createCommand($sql)->queryAll();
		$answer	= "";
		if(count($result) > 0){
			foreach($result as $data){
				$answer .= '<option data-tgl="'.date("d-m-Y", strtotime($data['tanggal_skks'])).'">'.$data['no_register_skks'].'</option>';
			}
		}
		return $answer;
    }

}