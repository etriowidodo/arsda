<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class GetTtd extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'pidsus.ms_penandatangan';
    }

	public function searchTtd($get){
		$q1  = htmlspecialchars($get['mttd_q1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['mttd_q2'], ENT_QUOTES);
		$q3  = htmlspecialchars($get['mttd_q3'], ENT_QUOTES);
		
		$sql = "select a.*, b.nama, b.jabatan, b.gol_kd, case when b.pns_jnsjbtfungsi = 0 then b.gol_pangkatjaksa else b.gol_pangkat2 end as pangkat, 
				c.deskripsi as ttd_jabat from pidsus.ms_penandatangan_pejabat a join kepegawaian.kp_pegawai b on a.nip = b.peg_nip_baru 
				join pidsus.ms_penandatangan c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari and a.kode = c.kode 
				where a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."'";
		if($q1)
			$sql .= " and (upper(a.nip) like '".strtoupper($q1)."%' or upper(a.status) like '%".strtoupper($q1)."%' or upper(b.nama) like '%".strtoupper($q1)."%' 
					or upper(b.jabatan) like '%".strtoupper($q1)."%' or upper(b.gol_kd) like '%".strtoupper($q1)."%' or upper(b.gol_pangkatjaksa) like '%".strtoupper($q1)."%' 
					or upper(b.gol_pangkat2) like '%".strtoupper($q1)."%' or upper(c.deskripsi) like '%".strtoupper($q1)."%')";
		if($q2)
			$sql .= " and a.status = '".$q2."'";
		if($q3)
			$sql .= " and a.kode = '".$q3."'";

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