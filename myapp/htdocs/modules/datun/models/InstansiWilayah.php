<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class InstansiWilayah extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'datun.instansi_wilayah';
    }

	public function search($get){
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['q2'], ENT_QUOTES);
		$q3  = htmlspecialchars($get['q3'], ENT_QUOTES);
		$sql = "select a.*, b.deskripsi_jnsinstansi, c.deskripsi_instansi 
				from datun.instansi_wilayah a join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi 
				join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk 
				where a.kode_tk = '".$_SESSION['kode_tk']."'"; 
		if($q1)
			$sql .= " and (upper(a.deskripsi_inst_wilayah) like '".strtoupper($q1)."%' or upper(b.deskripsi_jnsinstansi) like '".strtoupper($q1)."%' or upper(c.deskripsi_instansi) like '".strtoupper($q1)."%')";
		if($q2)
			$sql .= " and a.kode_jenis_instansi = '".$q2."'";
		if($q3)
			$sql .= " and a.kode_instansi = '".$q3."'";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.kode_tk, a.no_urut, a.kode_instansi, a.kode_jenis_instansi";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

    public function getInstansi($post){
		$tq1 	= htmlspecialchars($post['q1'], ENT_QUOTES);
		$sql 	= "select * from datun.instansi where kode_jenis_instansi = '".$tq1."' and kode_tk = '".$_SESSION['kode_tk']."'";
		$result	= $this->db->createCommand($sql)->queryAll();
		$answer	= array();
		$answer["items"][] = array("id"=>'', "text"=>'');
		if(count($result) > 0){
			foreach($result as $data){
				$answer["items"][] = array("id"=>$data['kode_instansi'], "text"=>$data['deskripsi_instansi']);
			}
		}
		return $answer;
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

	public function simpanData($post){
		$connection 			= $this->db;
		$isNewRecord 			= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$kode_jenis_instansi	= htmlspecialchars($post['kode_jns'], ENT_QUOTES);
		$kode_instansi			= htmlspecialchars($post['kode_ins'], ENT_QUOTES);
		$kode_provinsi			= htmlspecialchars($post['propinsi'], ENT_QUOTES);
		$kode_kabupaten			= htmlspecialchars($post['kabupaten'], ENT_QUOTES);
		$kode_tk				= $_SESSION['kode_tk'];
		$noUrut					= htmlspecialchars($post['no_urut'], ENT_QUOTES);
		$nama					= htmlspecialchars($post['nama'], ENT_QUOTES);
		$alamat					= htmlspecialchars($post['alamat'], ENT_QUOTES);
		$no_tlp					= htmlspecialchars($post['no_tlp'], ENT_QUOTES);
		$deskripsi_wilayah		= htmlspecialchars($post['deskripsi'], ENT_QUOTES);

		$transaction = $connection->beginTransaction();
		try{
			if($isNewRecord){
				$sqlCek	= "select max(no_urut) as jumlah from datun.instansi_wilayah where kode_jenis_instansi = '".$kode_jenis_instansi."' and kode_tk = '".$kode_tk."' 
							and kode_instansi = '".$kode_instansi."' and kode_provinsi = '".$kode_provinsi."' and kode_kabupaten = '".$kode_kabupaten."'";
				$jumlah = $connection->createCommand($sqlCek)->queryScalar();
				$noUrut = ($jumlah)?str_pad((intval($jumlah)+1), 4, '0', STR_PAD_LEFT):'0001';

				$sql1 = "insert into datun.instansi_wilayah(kode_jenis_instansi, kode_instansi, kode_provinsi, kode_kabupaten, kode_tk, no_urut, nama, alamat, no_tlp, 
						deskripsi_inst_wilayah) values('".$kode_jenis_instansi."', '".$kode_instansi."', '".$kode_provinsi."', '".$kode_kabupaten."', '".$kode_tk."', 
						'".$noUrut."', '".$nama."', '".$alamat."', '".$no_tlp."', '".$deskripsi_wilayah."')";
			}else{
				$sql1 = "update datun.instansi_wilayah set nama = '".$nama."', alamat = '".$alamat."', no_tlp = '".$no_tlp."', deskripsi_inst_wilayah = '".$deskripsi_wilayah."' 
						where kode_jenis_instansi = '".$kode_jenis_instansi."' and kode_instansi = '".$kode_instansi."' and kode_provinsi = '".$kode_provinsi."' 
						and kode_kabupaten = '".$kode_kabupaten."' and kode_tk = '".$kode_tk."' and no_urut = '".$noUrut."'";
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
					$sql1 = "delete from datun.instansi_wilayah where kode_jenis_instansi = '".rawurldecode($tmp[0])."' and kode_instansi = '".rawurldecode($tmp[1])."' 
							and kode_provinsi = '".rawurldecode($tmp[2])."' and kode_kabupaten = '".rawurldecode($tmp[3])."' and kode_tk = '".rawurldecode($tmp[4])."' 
							and no_urut = '".rawurldecode($tmp[5])."'";
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
