<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class GetJpu extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'pidsus.vw_jaksa_penuntut';
    }

	public function searchJpu($get){

		$q1  = htmlspecialchars($get['mjpn_q1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['mjpn_q2'], ENT_QUOTES);
		$sql = "select peg_nip_baru, nama, gol_kd, gol_pangkatjaksa, jabatan, gol_pangkatjaksa||' ('||gol_kd||')' as pangkatgol, inst_satkerkd 
				from pidsus.vw_jaksa_penuntut where inst_satkerkd = '".$_SESSION["inst_satkerkd"]."'";
		if($q1)
			$sql .= " and (upper(peg_nip_baru) like '".strtoupper($q1)."%' or upper(nama) like '%".strtoupper($q1)."%' or upper(jabatan) like '%".strtoupper($q1)."%' 
					or upper(gol_pangkatjaksa) like '%".strtoupper($q1)."%' or upper(gol_kd) like '%".strtoupper($q1)."%')";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
        ]);
        return $dataProvider;
    }

	public function searchJpp($get){

		$q1  = htmlspecialchars($get['mjpnp_q1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['mjpn_q2'], ENT_QUOTES);
		$sql = "select peg_nip_baru, nama, gol_kd, gol_pangkatjaksa, jabatan, gol_pangkatjaksa||' ('||gol_kd||')' as pangkatgol, inst_satkerkd 
				from pidsus.vw_jaksa_penuntut where inst_satkerkd = '".$_SESSION["inst_satkerkd"]."'";
		if($q1)
			$sql .= " and (upper(peg_nip_baru) like '".strtoupper($q1)."%' or upper(nama) like '%".strtoupper($q1)."%' or upper(jabatan) like '%".strtoupper($q1)."%' 
					or upper(gol_pangkatjaksa) like '%".strtoupper($q1)."%' or upper(gol_kd) like '%".strtoupper($q1)."%')";
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