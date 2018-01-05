<?php

namespace app\modules\datun\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\modules\datun\models\Instansi as InstansiModel;

/**
 * Menu represents the model behind the search form about [[\mdm\admin\models\Menu]].
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
  
 
 
//class Instansi extends InstansiModel
class Instansi extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
	 
	 public static function tableName()
    {
        return 'datun.jenis_instansi';
    } 
	 
	 
    public function rules()
    {
        return [
            [['kode_jenis_instansi', 'deskripsi_jnsinstansi'], 'required']
            
        ];
    }

	
	 public function attributeLabels()
    {
        return [
            'kode_jenis_instansi' => 'kode jenis instansi',
            'deskripsi_jnsinstansi' => 'deskripsi jnsinstansi',
            
        ];
    }
	

    public function searchCustomjenis($get)
    {
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['q2'], ENT_QUOTES);
		$sql = "select * from datun.jenis_instansi where 1=1";
		if($q1)
			$sql .= " and (upper(kode_jenis_instansi) like '%".strtoupper($q1)."%' or upper(deskripsi_jnsinstansi) like '%".strtoupper($q1)."%')";
		
		if($q2)
			$sql .= " and module = '".$q2."'";

		
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProviderJenis = new SqlDataProvider([
            'sql' => $sql ." order by CAST(coalesce(kode_jenis_instansi, '0') AS integer) ",
			'totalCount' => $count,
			'pagination' => ['pageSize' => 10],
        ]);

        return $dataProviderJenis;
    }

	    public function cekRolejenis($post){
		$q1 = htmlspecialchars($post['q1'], ENT_QUOTES);		
		$sql = "select count(*) from datun.jenis_instansi where kode_jenis_instansi = :kode_jenis_instansi";
		$kueri = $this->db->createCommand($sql)->bindValues([':kode_jenis_instansi'=>$q1]);
		$count = $kueri->queryScalar();
		return $count;
    }
				 
 public function searchCustominstansi($get)
    {
		$q1  = htmlspecialchars($get['i1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['i2'], ENT_QUOTES);
		$id  = htmlspecialchars($get['id'], ENT_QUOTES);
	//	$kode1  = htmlspecialchars($get['ijns'], ENT_QUOTES);

		$sql = "select * from datun.instansi  where 1=1 and kode_jenis_instansi = '".$id."' ";		
		if($q1)
			$sql .= " and (upper(kode_instansi) like '%".strtoupper($q1)."%' or upper(deskripsi_instansi) like '%".strtoupper($q1)."%')";
	//	if($q2)
		//	$sql .= " and kode_jenis_instansi = '".$q2."'";
	

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProviderinstansi = new SqlDataProvider([
            'sql' => $sql ." order by CAST(coalesce(kode_instansi, '0') AS integer) " ,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 10],
        ]);

        return $dataProviderinstansi;
    }

	
	    public function cekRoleinstansi($post){
		$q1 = htmlspecialchars($post['q1'], ENT_QUOTES);
		//$q2 = htmlspecialchars($post['q2'], ENT_QUOTES);
		$sql = "select count(*) from datun.instansi where kode_jenis_instansi=:kode_jenis_instansi and kode_instansi = :kode_instansi";
		$kueri = $this->db->createCommand($sql)->bindValues([':kode_instansi'=>$q1]);
		$count = $kueri->queryScalar();
		return $count;
    }


    public function searchCustomwilayah($get)
    {
		
		$id  = htmlspecialchars($get['id'], ENT_QUOTES);		
		$cid  	= htmlspecialchars($id, ENT_QUOTES);
		list($kdjns,$kdins) = explode("/", $cid);
				
		$q1  = htmlspecialchars($get['w1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['w2'], ENT_QUOTES);
		$q3  = htmlspecialchars($get['w3'], ENT_QUOTES);
		$q4  = htmlspecialchars($get['w4'], ENT_QUOTES);

		$connection = Yii::$app->db;	
		$kode_tk = Yii::$app->session->get('kode_tk');
		
		
		$sql = "select a.*,b.deskripsi_instansi as nama_instansi from datun.instansi_wilayah  a
inner join datun.instansi b on a.kode_jenis_instansi=b.kode_jenis_instansi
and a.kode_instansi=b.kode_instansi where 1=1 and a.kode_jenis_instansi='$kdjns' and a.kode_instansi='$kdins' and  a.kode_tk='$kode_tk'";
		if($q1)
			$sql .= " and (upper(a.deskripsi_inst_wilayah) like '%".strtoupper($q1)."%' or upper(b.deskripsi_instansi) like '%".strtoupper($q1)."%' or upper(a.alamat) like '%".strtoupper($q1)."%' or upper(a.nama) like '%".strtoupper($q1)."%')";
		if($q2)
			$sql .= " and a.kode_instansi = '".$q2."'";
		if($q3)
			$sql .= " and a.kode_provinsi = '".$q3."'";
		if($q4)
			$sql .= " and a.kode_kabupaten = '".$q4."'";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProviderwilayah = new SqlDataProvider([
          //  'sql' => $sql." order by CAST(coalesce(a.kode_jenis_instansi, '0') AS integer),CAST(coalesce(a.kode_instansi, '0') AS integer),CAST(coalesce(a.kode_provinsi, '0') AS integer),CAST(coalesce(a.kode_kabupaten, '0') AS integer),CAST(coalesce(a.kode_tk, '0') AS integer),CAST(coalesce(a.no_urut, '0') AS integer)  " ,
			  'sql' => $sql." order by CAST(coalesce(a.kode_jenis_instansi, '0') AS integer),CAST(coalesce(a.kode_instansi, '0') AS integer),a.kode_provinsi,a.kode_kabupaten,CAST(coalesce(a.kode_tk, '0') AS integer),CAST(coalesce(a.no_urut, '0') AS integer)  " ,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 10],
        ]);

        return $dataProviderwilayah;
    }

	    public function cekRole($post){
		$q1 = htmlspecialchars($post['q1'], ENT_QUOTES);
		//$q2 = htmlspecialchars($post['q2'], ENT_QUOTES);
		$sql = "select count(*) from datun.instansi_wilayah where kode_jenis_instansi=:kode_jenis_instansi and kode_instansi = :kode_instansi";
		$kueri = $this->db->createCommand($sql)->bindValues([':kode_instansi'=>$q1]);
		$count = $kueri->queryScalar();
		return $count;
    }


	
    public function cekInstansi($post){
		$q1 = htmlspecialchars($post['q1'], ENT_QUOTES);
	//	$q2 = htmlspecialchars($post['q2'], ENT_QUOTES);
		$sql = "select count(*) from datun.jenis_instansi where deskripsi_jnsinstansi = :deskripsi_jnsinstansi";
		$kueri = $this->db->createCommand($sql)->bindValues([':deskripsi_jnsinstansi'=>$q1]);	
		$count = $kueri->queryScalar();
		return $count;
    }

	
	    public function simpanDataJenis($post){					
		$connection = Yii::$app->db;		
		$kode_jenis_instansi 	= htmlspecialchars($post['kode_jenis_instansi'], ENT_QUOTES);
		$deskripsi_jnsinstansi 	= htmlspecialchars($post['deskripsi_jnsinstansi'], ENT_QUOTES);
		$cstatus 	= htmlspecialchars($post['status'], ENT_QUOTES);

		$transaction = $connection->beginTransaction();
		try {
		
		if($cstatus=='0'){
					$sql1 = "insert into datun.jenis_instansi(kode_jenis_instansi,deskripsi_jnsinstansi)  
							 values('".$kode_jenis_instansi."', '".$deskripsi_jnsinstansi."')";
					$connection->createCommand($sql1)->execute();
		}else{
		
					$sql1 = "update datun.jenis_instansi set deskripsi_jnsinstansi='$deskripsi_jnsinstansi' where kode_jenis_instansi='$kode_jenis_instansi'";
					$connection->createCommand($sql1)->execute();
		
		}
					
		
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    	
			
			
		}

		
		
	 public function cekDataJenis($post){					
		$connection = Yii::$app->db;		
		$kode_jenis_instansi 	= htmlspecialchars($post['kode_jenis_instansi'], ENT_QUOTES);		
		$cstatus 	= htmlspecialchars($post['status'], ENT_QUOTES);
		$transaction = $connection->beginTransaction();
		try {
		
		if($cstatus=='0'){
			
					$sql1 = "SELECT count(*) FROM datun.jenis_instansi where kode_jenis_instansi='$kode_jenis_instansi'";
					$connection->createCommand($sql1)->execute();
		}
					
		
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    	
			
			
		}	
		
		
	    public function simpanDatainstansi($post){					
		$connection = Yii::$app->db;		
		$kode_jenis_instansi 	= htmlspecialchars($post['kode_jenis_instansi'], ENT_QUOTES);
		$kode_instansi 	= htmlspecialchars($post['kode_instansi'], ENT_QUOTES);
		$deskripsi_instansi 	= htmlspecialchars($post['deskripsi_instansi'], ENT_QUOTES);
		$cstatus 	= htmlspecialchars($post['status_instansi'], ENT_QUOTES);

		$transaction = $connection->beginTransaction();
		try {
		
		if($cstatus=='0'){
					$sql1 = "insert into datun.instansi(kode_jenis_instansi,kode_instansi,deskripsi_instansi)  
							 values('".$kode_jenis_instansi."', '".$kode_instansi."', '".$deskripsi_instansi."')";
					$connection->createCommand($sql1)->execute();
		}else{
		
					$sql1 = "update datun.instansi set deskripsi_instansi='$deskripsi_instansi' where kode_jenis_instansi='$kode_jenis_instansi' and kode_instansi='$kode_instansi'";
					$connection->createCommand($sql1)->execute();		
		}
					
		
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    	
			
			
		}		

		
	    public function simpanDatawilayah($post){					
		$connection = Yii::$app->db;	
		$kode_tk = Yii::$app->session->get('kode_tk');		
			
		$kode_jenis_instansi 	= htmlspecialchars($post['kode_jenis_instansi'], ENT_QUOTES);
		$kode_instansi 	= htmlspecialchars($post['kode_instansi'], ENT_QUOTES);
		$kode_provinsi 	= htmlspecialchars($post['id_prop'], ENT_QUOTES);
		$ukode_provinsi 	= htmlspecialchars($post['uid_prop'], ENT_QUOTES);	
		$kode_kabupaten = htmlspecialchars($post['id_kabupaten_kota'], ENT_QUOTES);
		$ukode_kabupaten = htmlspecialchars($post['uid_kabupaten_kota'], ENT_QUOTES);			
		$nama 	= htmlspecialchars($post['nama'], ENT_QUOTES);		
		$alamat 	= htmlspecialchars($post['alamat'], ENT_QUOTES);		
		$no_tlp 	= htmlspecialchars($post['no_tlp'], ENT_QUOTES);		
		$deskripsi_inst 	= htmlspecialchars($post['deskripsi_inst_wilayah'], ENT_QUOTES);
		$uno_urut 	= htmlspecialchars($post['no_urut'], ENT_QUOTES);

		$cstatus 	= htmlspecialchars($post['status_wil'], ENT_QUOTES);
		
/* 		echo($kode_jenis_instansi);
		echo($kode_instansi);
		echo($ukode_provinsi);
		echo($ukode_kabupaten);
		echo($kode_tk);
		echo($uno_urut);

		exit; */
		
		
		
		$query = " select max(CAST(coalesce(no_urut, '0') AS integer)+1) from datun.instansi_wilayah where kode_jenis_instansi='$kode_jenis_instansi' and kode_instansi='$kode_instansi' and kode_provinsi='$kode_provinsi' and kode_kabupaten='$kode_kabupaten' and kode_tk='$kode_tk' ";		
		$xcurut = Yii::$app->db->createCommand($query)->queryScalar();		
		
		if($xcurut==0){
			$dkode=1;							 
		}else{
			$dkode=$xcurut;
		}
		$no_urut = sprintf("%04d", $dkode);

		$transaction = $connection->beginTransaction();
		try {
		
		if($cstatus=='0'){
					$sql1 = "insert into datun.instansi_wilayah(kode_jenis_instansi,kode_instansi,kode_provinsi,kode_kabupaten,kode_tk,no_urut,nama,alamat,no_tlp,deskripsi_inst_wilayah)  
							 values('".$kode_jenis_instansi."', '".$kode_instansi."', '".$kode_provinsi."', '".$kode_kabupaten."', '".$kode_tk."', '".$no_urut."', '".$nama."', '".$alamat."',
							  '".$no_tlp."', '".$deskripsi_inst."')";
					$connection->createCommand($sql1)->execute();
		}else{
		
					$sql1 = "update datun.instansi_wilayah set nama='$nama',alamat='$alamat',no_tlp='$no_tlp',deskripsi_inst_wilayah='$deskripsi_inst' where kode_jenis_instansi='$kode_jenis_instansi' and kode_instansi='$kode_instansi' and kode_provinsi='$ukode_provinsi' and kode_kabupaten='$ukode_kabupaten' and kode_tk='$kode_tk' and no_urut='$uno_urut'";
					$connection->createCommand($sql1)->execute();
		
		}
					
		
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    	
			
			
		}
		
	
    public function hapusDatajenis($post){
		$connection = $this->db;
		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$sql1 = "delete from datun.jenis_instansi where kode_jenis_instansi = '".$val."'";
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

	
	public function hapusDatainstansi($post){		
		$connection 	 = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
					foreach($post['id'] as $idx=>$val){
						$ckd  = htmlspecialchars($val, ENT_QUOTES);
						list($kode1, $kode2) = explode("/", $ckd);

						$sql1 = "delete from datun.instansi where kode_jenis_instansi = '".$kode1."' and kode_instansi = '".$kode2."'";
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
		
	public function hapusDatawilayah($post){		
		$connection 	 = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
					foreach($post['id'] as $idx=>$val){
						$ckd  = htmlspecialchars($val, ENT_QUOTES);						
						list($kode1, $kode2, $kode3, $kode4, $kode5, $kode6) = explode("/", $ckd);

						$sql1 = "delete from datun.instansi_wilayah where kode_jenis_instansi = '".$kode1."' and kode_instansi = '".$kode2."' and kode_provinsi = '".$kode3."' and kode_kabupaten = '".$kode4."' and kode_tk = '".$kode5."' and no_urut = '".$kode6."' ";
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

	
/* 	    public function getJenis($post){
		$tq1 	= htmlspecialchars($post['q1'], ENT_QUOTES);
		$sql 	= "select * from datun.jenis_instansi where kode_jenis_instansi = '".$tq1."'";
		$result	= $this->db->createCommand($sql)->queryAll();
		$answer	= array();
		$answer["items"][] = array("id"=>'', "text"=>'');
		if(count($result) > 0){
			foreach($result as $data){
				$answer["items"][] = array("id"=>$data['kode_jenis_instansi'], "text"=>$data['deskripsi_jnsinstansi']);
			}
		}
		return $answer;
    } */

	
	    public function getJenis($post){ 
			$tq1 	= htmlspecialchars($post['q1'], ENT_QUOTES);					
			$sql 	= "select deskripsi_jnsinstansi from datun.jenis_instansi where kode_jenis_instansi = '".$tq1."' ";	
			$result	= $this->db->createCommand($sql)->queryScalar();					
			return $result;		
				
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

	

	
}	
