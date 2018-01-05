<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class TtdPejabat extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'pidsus.ms_penandatangan_pejabat';
    }

	public function search($get){
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['q2'], ENT_QUOTES);
                $id_kejati  = $_SESSION['kode_kejati'];
                $id_kejari  = $_SESSION['kode_kejari'];
                $id_cabjari = $_SESSION['kode_cabjari'];
                
                $whereDef = " a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."'";
                
		$sql = "select a.*, b.nama, b.jabatan, c.deskripsi as jabatan_ttd, 
				case when b.pns_jnsjbtfungsi = 0 then b.gol_kd||' '||b.gol_pangkatjaksa else b.gol_kd||' '||b.gol_pangkat2 end as pangkat 
				from pidsus.ms_penandatangan_pejabat a join kepegawaian.kp_pegawai b on a.nip = b.peg_nip_baru 
				join pidsus.ms_penandatangan c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari= c.id_cabjari and a.kode = c.kode where ".$whereDef;
		if($q1)
			$sql .= " and (a.nip like '%".$q1."%' or upper(b.nama) like '%".strtoupper($q1)."%' or upper(b.jabatan) like '%".strtoupper($q1)."%' 
					or upper(a.status) = '".strtoupper($q1)."' or upper(b.gol_kd) like '%".strtoupper($q1)."%' or upper(b.gol_pangkatjaksa) like '%".strtoupper($q1)."%' 
					or upper(b.gol_pangkat2) like '%".strtoupper($q1)."%')";	
		if($q2)
			$sql .= " and a.kode = '".$q2."'";	

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by id_kejati, id_kejari, id_cabjari, kode, nip";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);

        return $dataProvider;
    }

    public function cekTtdPejabat($post){
		$connection = $this->db;
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$kode	= htmlspecialchars($post['kode_ttd'], ENT_QUOTES);
		$nip 	= htmlspecialchars($post['peg_nip'], ENT_QUOTES);
                $id_kejati      = $_SESSION['kode_kejati'];
                $id_kejari      = $_SESSION['kode_kejari'];
                $id_cabjari     = $_SESSION['kode_cabjari'];
                $whereDef       = " id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."'";
		$sql 	= "select count(*) from pidsus.ms_penandatangan_pejabat where kode = '".$kode."' and nip = '".$nip."' and ".$whereDef;
		$count 	= ($isNew)?$this->db->createCommand($sql)->queryScalar():0;
		return $count;
	}

    public function simpanData($post){
		$connection = $this->db;
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$kode 		= htmlspecialchars($post['kode_ttd'], ENT_QUOTES);
		$nip 		= htmlspecialchars($post['peg_nip'], ENT_QUOTES);
		$status 	= htmlspecialchars($post['status'], ENT_QUOTES);
		$id_kejati      = $_SESSION['kode_kejati'];
                $id_kejari      = $_SESSION['kode_kejari'];
                $id_cabjari     = $_SESSION['kode_cabjari'];
		$whereDef       = " id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and kode = '".$kode."' and nip = '".$nip."'";
		$transaction = $connection->beginTransaction();
		try {
			if($isNew){
				$sql1 = "insert into pidsus.ms_penandatangan_pejabat values('".$id_kejati."','".$id_kejari."','".$id_cabjari."', '".$kode."', '".$nip."', '".$status."')";
                                echo $sql1;exit;
				$connection->createCommand($sql1)->execute();
			} else{
                            
				$sql1 = "update pidsus.ms_penandatangan_pejabat set status = '".$status."' where ".$whereDef;				
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
                $id_kejati      = $_SESSION['kode_kejati'];
                $id_kejari      = $_SESSION['kode_kejari'];
                $id_cabjari     = $_SESSION['kode_cabjari'];
		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$idny = explode("#", $val); 
					$sql1 = "delete from pidsus.ms_penandatangan_pejabat where kode = '".rawurldecode($idny[0])."' and nip = '".rawurldecode($idny[1])."' 
							 and id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."'";
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
