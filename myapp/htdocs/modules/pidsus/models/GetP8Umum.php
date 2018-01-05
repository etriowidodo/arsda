<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class GetP8Umum extends \yii\db\ActiveRecord{
	
    public static function tableName(){
        return 'pidsus.vw_jaksa_penuntut';
    }

    public function searchP8($params){
            $id_kejati	= $_SESSION['kode_kejati'];
            $id_kejari	= $_SESSION['kode_kejari'];
            $id_cabjari	= $_SESSION['kode_cabjari'];
            $q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
            $sql = "
            select *
            from pidsus.pds_p8_umum 
            where id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' ";
            if($q1)
                    $sql .= " and ( to_char(tgl_p8_umum, 'DD-MM-YYYY') = '".$q1."' or upper(no_p8_umum) like '%".strtoupper($q1)."%' )";
            $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
            $count = $kueri->queryScalar();
            $sql .= " order by tgl_p8_umum desc";
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                            'totalCount' => $count,
            ]);
            return $dataProvider;
    }

}