<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class TtdJabatan extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.m_penandatangan';
    }

	public function search($get){
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$sql = "select * from datun.m_penandatangan where kode_tk = '".$_SESSION['kode_tk']."'"; 
		if($q1)
			$sql .= " and (upper(kode) like '".strtoupper($q1)."%' or upper(deskripsi) like '%".strtoupper($q1)."%')";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by kode";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

    public function cekTtdJabatan($post){
		$connection  = $this->db;
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$kode 	= htmlspecialchars($post['kode'], ENT_QUOTES);
		$sql 	= "select count(*) from datun.m_penandatangan where kode = '".$kode."' and kode_tk = '".$_SESSION['kode_tk']."'";
		$count 	= ($isNew)?$connection->createCommand($sql)->queryScalar():0;
		return $count;
	}

    public function simpanData($post){
		$connection 	= $this->db;
		$isNewRecord 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$kode 			= htmlspecialchars($post['kode'], ENT_QUOTES);
		$deskripsi		= htmlspecialchars($post['deskripsi'], ENT_QUOTES);
		$kode_tk 		= $_SESSION['kode_tk'];
		
		$transaction = $connection->beginTransaction();
		try {
			if($isNewRecord){
				$sql1 = "insert into datun.m_penandatangan values('".$kode_tk."', '".$kode."', '".$deskripsi."')";
			} else{
				$sql1 = "update datun.m_penandatangan set deskripsi = '".$deskripsi."' where kode = '".$kode."' and kode_tk = '".$kode_tk."'";
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
					$tmp = explode("#", $val);
					$sql1 = "delete from datun.m_penandatangan where kode = '".rawurldecode($tmp[0])."' and kode_tk = '".rawurldecode($tmp[1])."'";
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
