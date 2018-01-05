<?php

namespace app\modules\datun\models\searchs;

use Yii;
use yii\db\Query;
use yii\helpers\HtmlPurifier;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

 
class Laporanbulanan extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'datun.s11';
    }



	public function searchTtd($get){
		$q1  = htmlspecialchars($get['mttd_q1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['mttd_q2'], ENT_QUOTES);
		$q3  = htmlspecialchars($get['mttd_q3'], ENT_QUOTES);
		
		$sql = "select a.*, b.nama, b.jabatan, b.gol_kd, case when b.pns_jnsjbtfungsi = 0 then b.gol_pangkatjaksa else b.gol_pangkat2 end as pangkat, 
				c.deskripsi as ttd_jabat from datun.m_penandatangan_pejabat a join kepegawaian.kp_pegawai b on a.nip = b.peg_nip_baru 
				join datun.m_penandatangan c on a.kode_tk = c.kode_tk and a.kode = c.kode where a.kode_tk = '".$_SESSION['kode_tk']."'";
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
