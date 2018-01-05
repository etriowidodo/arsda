<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\pidsus\models;
use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;
/**
 * Description of GetPasal
 *
 * @author Oka
 */
class GetPasal extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'pidsus.ms_pasal';
    }
    
    public function searchPasal($params){
            $q1  = htmlspecialchars($params['jnsins_q1'], ENT_QUOTES);
            $id  = htmlspecialchars($params['id'], ENT_QUOTES);
            $sql = "
            select a.*
            from pidsus.ms_pasal a
            where 1=1 and a.id='".$id."'";
            if($q1)
                    $sql .= "  and (upper(a.pasal) like '%".strtoupper($q1)."%' or upper(a.bunyi) like '%".strtoupper($q1)."%') ";

            $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
            $count = $kueri->queryScalar();
            $sql .= " order by a.id,a.id_pasal";
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                            'totalCount' => $count,
            ]);
            return $dataProvider;
    }
}
