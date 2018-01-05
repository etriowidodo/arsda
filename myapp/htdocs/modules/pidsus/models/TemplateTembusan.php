<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class Templatetembusan extends \yii\db\ActiveRecord{

    public static function tableName(){
        return 'pidsus.ms_template_surat_tembusan';
    }

    public function searchCustom($get){
		$id  = htmlspecialchars(rawurldecode($get['id']), ENT_QUOTES);
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		
		$sql = "select * from pidsus.ms_template_surat_tembusan where kode_template_surat = '".$id."'";
		if($q1)
			$sql .= " and (upper(tembusan) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $sql .= " order by no_urut";
		$dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => false,
        ]);
        return $dataProvider;
    }

    public function simpanData($post){
		$connection = $this->db;
		$kode = htmlspecialchars(rawurldecode($post['hdnId']), ENT_QUOTES);
		$transaction = $connection->beginTransaction();
		try{
			$sql1 = "delete from pidsus.ms_template_surat_tembusan where kode_template_surat = '".$kode."'";
			$connection->createCommand($sql1)->execute();
			foreach($post['tembusan'] as $idx=>$nilai){
				$tembus = htmlspecialchars($nilai, ENT_QUOTES);
				$nomor	= $idx+1;
				$sql2 	= "insert into pidsus.ms_template_surat_tembusan values('".$kode."', '".$nomor."', '".$tembus."')";
				if($tembus) $connection->createCommand($sql2)->execute();
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
					$temp = explode("#", $val);
					$sql1 = "delete from pidsus.ms_template_surat_tembusan where kode_template_surat = '".$temp[0]."' and no_urut = '".$temp[1]."'";
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
