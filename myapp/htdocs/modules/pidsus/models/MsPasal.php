<?php
namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class MsPasal extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.ms_pasal';
    }

    public function searchPer($params){
            $q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
            $sql = "
            select a.*,b.uu
            from pidsus.ms_pasal a
            join pidsus.ms_u_undang b on a.id=b.id
            where 1=1";
            if($q1)
                    $sql .= " and ( upper(b.uu) like '%".strtoupper($q1)."%' or upper(a.pasal) like '%".strtoupper($q1)."%' or upper(a.bunyi) like '%".strtoupper($q1)."%')";

            $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
            $count = $kueri->queryScalar();
            $sql .= " order by a.id,a.id_pasal";
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                            'totalCount' => $count,
            ]);
            return $dataProvider;
    }
    
    public function searchUndang($params){
            $q1  = htmlspecialchars($params['jnsins_q1'], ENT_QUOTES);
            $sql = "
            select a.*
            from pidsus.ms_u_undang a
            where 1=1";
            if($q1)
                    $sql .= " and (upper(a.uu) like '%".strtoupper($q1)."%' or upper(a.deskripsi) like '%".strtoupper($q1)."%' or to_char(a.tanggal, 'DD-MM-YYYY') = '".$q1."')";

            $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
            $count = $kueri->queryScalar();
            $sql .= " order by a.id";
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                            'totalCount' => $count,
            ]);
            return $dataProvider;
    }
    
    public function cekTtdJabatan($post){
        $connection = $this->db;
        $isNew      = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $id         = htmlspecialchars($post['id'], ENT_QUOTES);
        $id_pasal   = htmlspecialchars($post['id_pasal'], ENT_QUOTES);
        $whereDef = "id = '".$id."' and id_pasal='".$id_pasal."'";
        
        $sql 	= "select count(*) from pidsus.ms_pasal where ".$whereDef;
        $count 	= ($isNew)?$connection->createCommand($sql)->queryScalar():0;
        return $count;
    }
    
    public function simpanData($post){
        $connection = $this->db;
        $id         = htmlspecialchars($post['id'], ENT_QUOTES);
        $id_pasal   = htmlspecialchars($post['id_pasal'], ENT_QUOTES);
        $pasal      = htmlspecialchars($post['pasal'], ENT_QUOTES);
        $bunyi      = htmlspecialchars($post['bunyi'], ENT_QUOTES);
        $isNew      = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $transaction = $connection->beginTransaction();
        try{
            if($isNew){
                $sql1="insert into pidsus.ms_pasal values('".$id."','".$id_pasal."','".$pasal."','".$bunyi."')";
            }else{
                $sql1 = "update pidsus.ms_pasal set pasal='".$pasal."',bunyi='".$bunyi."'  where id='".$id."' and id_pasal='".$id_pasal."'";
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
                    $tmp = explode("|#|", $val);
                    $sql1 = "delete from pidsus.ms_pasal where id = '".rawurldecode($tmp[0])."' and id_pasal='".rawurldecode($tmp[1])."'";
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
