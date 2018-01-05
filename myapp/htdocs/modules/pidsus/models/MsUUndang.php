<?php
namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class MsUUndang extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.ms_u_undang';
    }

    public function searchPer($params){
            $q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
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
        $connection  = $this->db;
        $isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $id  = htmlspecialchars($post['id'], ENT_QUOTES);
        $whereDef = "id = '".$id."'";
        
        $sql 	= "select count(*) from pidsus.ms_u_undang where ".$whereDef;
        $count 	= ($isNew)?$connection->createCommand($sql)->queryScalar():0;
        return $count;
    }
    
    public function simpanData($post){
        $connection = $this->db;
        $helpernya	= Yii::$app->inspektur;
        $id         = htmlspecialchars($post['id'], ENT_QUOTES);
        $uu         = htmlspecialchars($post['uu'], ENT_QUOTES);
        $deskripsi  = htmlspecialchars($post['deskripsi'], ENT_QUOTES);
        $tentang    = htmlspecialchars($post['tentang'], ENT_QUOTES);
        $tanggal    = htmlspecialchars($post['tanggal'], ENT_QUOTES);
        $isNew      = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $tanggal= ($tanggal)?"'".$helpernya->tgl_db($tanggal)."'":'NULL';
        $transaction = $connection->beginTransaction();
        try{
            if($isNew){
                $sql1="insert into pidsus.ms_u_undang values('".$id."','".$uu."','".$deskripsi."','".$tentang."',".$tanggal.")";
            }else{
                $sql1 = "update pidsus.ms_u_undang set uu='".$uu."',deskripsi='".$deskripsi."', tentang='".$tentang."', tanggal=".$tanggal."  where id='".$id."'";
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
                    $sql1 = "delete from pidsus.ms_u_undang where id = '".rawurldecode($val)."'";
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
