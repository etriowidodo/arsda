<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class GetP8Khusus extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'pidsus.pds_p8_khusus';
    }

    public function searchp8($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_pidsus18	= $_SESSION['pidsus_no_pidsus18'];
		$q1  = htmlspecialchars($params['mp8_q1'], ENT_QUOTES);
		$sql = "
                with tbl_jaksa as(
			select id_kejati, id_kejari, id_cabjari, no_pidsus18, no_p8_khusus, string_agg(nama_jaksa, '#') as jpunya 
			from pidsus.pds_p8_khusus_jaksa group by id_kejati, id_kejari, id_cabjari, no_pidsus18, no_p8_khusus 
		)    
                select a.*,b.jpunya from pidsus.pds_p8_khusus a 
                left join tbl_jaksa b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and
			a.no_pidsus18 = b.no_pidsus18 and a.no_p8_khusus = b.no_p8_khusus
			where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_pidsus18 = '".$no_pidsus18."'";
		if($q1)
			$sql .= " and (to_char(a.tgl_p8_khusus, 'DD-MM-YYYY') = '".$q1."' or upper(a.no_p8_khusus) like '%".strtoupper($q1)."%' or upper(b.jpunya) like '%".strtoupper($q1)."%' or upper(b.laporan_pidana) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_p8_khusus desc";
		$dataProvider = new SqlDataProvider([
			'sql' => $sql,
			'totalCount' => $count,
		]);
		return $dataProvider;
    }

}