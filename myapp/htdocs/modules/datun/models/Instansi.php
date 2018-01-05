<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class Instansi extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.instansi';
    }

	public function search($get){
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['q2'], ENT_QUOTES);
		$sql = "select a.*, b.deskripsi_jnsinstansi from datun.instansi a join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi 
				where kode_tk = '".$_SESSION['kode_tk']."'"; 
		if($q1)
			$sql .= " and (upper(a.kode_instansi) like '".strtoupper($q1)."%' or upper(a.deskripsi_instansi) like '%".strtoupper($q1)."%')";
		if($q2)
			$sql .= " and a.kode_jenis_instansi = '".$q2."'";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.kode_tk, a.kode_instansi, a.kode_jenis_instansi";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

    public function cekInstansi($post){
		$connection = $this->db;
		$kode 	= Yii::$app->user->identity->kode_tk;
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$jns  	= htmlspecialchars($post['kode_jns'], ENT_QUOTES);
		$ins 	= htmlspecialchars($post['kode_ins'], ENT_QUOTES);
		$sql 	= "select count(*) from datun.instansi where kode_jenis_instansi = '".$jns."' and kode_instansi = '".$ins."' and kode_tk = '".$kode."'";
		$count 	= ($isNew)?$connection->createCommand($sql)->queryScalar():0;
		return $count;
	}

	public function simpanData($post){
		$connection 			= $this->db;
		$isNewRecord 			= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$kode_jenis_instansi	= htmlspecialchars($post['kode_jns'], ENT_QUOTES);
		$kode_instansi			= htmlspecialchars($post['kode_ins'], ENT_QUOTES);
		$deskripsi_instansi		= htmlspecialchars($post['deskripsi'], ENT_QUOTES);
		$kode_tk				= $_SESSION['kode_tk'];

		$transaction = $connection->beginTransaction();
		try{
			if($isNewRecord){
				$sql1 = "insert into datun.instansi(kode_jenis_instansi, kode_instansi, deskripsi_instansi, kode_tk) values('".$kode_jenis_instansi."', '".$kode_instansi."', 
						'".$deskripsi_instansi."', '".$kode_tk."')";
			}else{
				$sql1 = "update datun.instansi set deskripsi_instansi = '".$deskripsi_instansi."' where kode_jenis_instansi = '".$kode_jenis_instansi."' 
						 and kode_instansi = '".$kode_instansi."' and kode_tk = '".$kode_tk."'";
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
					$sql1 = "delete from datun.instansi where kode_jenis_instansi = '".rawurldecode($tmp[0])."' and kode_instansi = '".rawurldecode($tmp[1])."' 
							 and kode_tk = '".$_SESSION['kode_tk']."'";
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
