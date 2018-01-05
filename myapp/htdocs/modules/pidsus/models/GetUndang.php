<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class GetUndang extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'pidsus.ms_u_undang';
    }
    
    public function searchUndang($params){
            $q1  = htmlspecialchars($params['undang_q1'], ENT_QUOTES);
            $sql = "
            select a.*
            from pidsus.ms_u_undang a
            where 1=1";
            if($q1)
                    $sql .= " and (upper(a.uu) like '%".strtoupper($q1)."%' or upper(a.deskripsi) like '%".strtoupper($q1)."%' or upper(a.tentang) like '%".strtoupper($q1)."%')";
           
            $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
            $count = $kueri->queryScalar();
            $sql .= " order by a.id";
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                            'totalCount' => $count,
            ]);
            return $dataProvider;
    }
}
