<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;

class Pengadilan extends \yii\db\ActiveRecord{

    public static function tableName(){
        return 'datun.master_pengadilan';
    }

    public function search($get){
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$sql = "select * from datun.master_pengadilan where 1=1";
		if($q1)
			$sql .= " and upper(nama_pengadilan) like '%".strtoupper($q1)."%'";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

    public function getKabupaten($post){
		$tq1 	= htmlspecialchars($post['q1'], ENT_QUOTES);
		$sql 	= "select * from datun.m_kabupaten where id_prop = '".$tq1."'";
		$result	= $this->db->createCommand($sql)->queryAll();
		$answer	= array();
		$answer["items"][] = array("id"=>'', "text"=>'');
		if(count($result) > 0){
			foreach($result as $data){
				$answer["items"][] = array("id"=>$data['id_kabupaten_kota'], "text"=>$data['deskripsi_kabupaten_kota']);
			}
		}
		return $answer;
    }

    public function cekWilayah($post){
		$connection  = $this->db;
		$isNewRecord = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$q1 = htmlspecialchars($post['q1'], ENT_QUOTES);
		$q2 = htmlspecialchars($post['q2'], ENT_QUOTES);
		$q3 = htmlspecialchars($post['q3'], ENT_QUOTES);
		if($q1 == 1){
			$sql = "select count(*) from datun.pengadilan_tk1 where kode_pengadilan_tk1 = '".$q2."'";
		} else if($q1 == 2){
			$sql = "select count(*) from datun.pengadilan_tk2 where kode_pengadilan_tk1 = '".$q2."' and kode_pengadilan_tk2 = '".$q3."'";
		}
		$count = ($isNewRecord)?$connection->createCommand($sql)->queryScalar():0;
		return $count;
	}

    public function simpanData($post){
		$connection 	= $this->db;
		$isNewRecord 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$tingkat 		= htmlspecialchars($post['tingkat'], ENT_QUOTES);
		$propinsi 		= htmlspecialchars($post['propinsi'], ENT_QUOTES);
		$kabupaten 		= htmlspecialchars($post['kabupaten'], ENT_QUOTES);
		$deskripsi 		= htmlspecialchars($post['deskripsi'], ENT_QUOTES);
		$alamat 		= htmlspecialchars($post['alamat'], ENT_QUOTES);
		
		$transaction = $connection->beginTransaction();
		try {
			if($isNewRecord){
				if($tingkat == 1){
					$cek1 = "select deskripsi from datun.m_propinsi where id_prop = '".$propinsi."'";
					$prop = $connection->createCommand($cek1)->queryScalar();
					$sql1 = "insert into datun.pengadilan_tk1 values('".$propinsi."', 'Pengadilan Tinggi ".ucwords(strtolower($prop))."', '".$alamat."')";
				} else if($tingkat == 2){
					$cek1 = "select deskripsi_kabupaten_kota from datun.m_kabupaten where id_prop = '".$propinsi."' and id_kabupaten_kota = '".$kabupaten."'";
					$prop = $connection->createCommand($cek1)->queryScalar();
					$sql1 = "insert into datun.pengadilan_tk2 values('".$propinsi."', '".$kabupaten."', 'Pengadilan Negeri ".ucwords(strtolower($prop))."', '".$alamat."')";
				}
				$connection->createCommand($sql1)->execute();
			} else{
				if($kabupaten == '00'){
					$sql1 = "update datun.pengadilan_tk1 set deskripsi_tk1 = '".$deskripsi."', alamat = '".$alamat."' where kode_pengadilan_tk1 = '".$propinsi."'";
				} else{
					$sql1 = "update datun.pengadilan_tk2 set deskripsi_tk2 = '".$deskripsi."', alamat = '".$alamat."' where kode_pengadilan_tk1 = '".$propinsi."' 
							and kode_pengadilan_tk2 = '".$kabupaten."'";
				}
				$connection->createCommand($sql1)->execute();
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
					$tmp = explode(".", $val);
					if($tmp[1] == "00"){
						$sql1 = "delete from datun.pengadilan_tk1 where kode_pengadilan_tk1 = '".$tmp[0]."'";
					} else{
						$sql1 = "delete from datun.pengadilan_tk2 where kode_pengadilan_tk1 = '".$tmp[0]."' and kode_pengadilan_tk2 = '".$tmp[1]."'";
					}
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
