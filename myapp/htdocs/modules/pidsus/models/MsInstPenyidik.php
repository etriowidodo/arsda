<?php
namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class MsInstPenyidik extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.ms_inst_pelak_penyidikan';
    }

    public function searchPer($params){
            $q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
            $sql = "
            select a.*
            from pidsus.ms_inst_penyidik a
            where 1=1";
            if($q1)
                    $sql .= " and (upper(a.nama) like '%".strtoupper($q1)."%' or upper(a.akronim) like '%".strtoupper($q1)."%')";

            $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
            $count = $kueri->queryScalar();
            $sql .= " order by a.kode_ip";
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                            'totalCount' => $count,
            ]);
            return $dataProvider;
    }
    
    public function cekTtdJabatan($post){
        $connection  = $this->db;
        $isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $kode_ip  = htmlspecialchars($post['kode_ip'], ENT_QUOTES);
        $whereDef = "kode_ip = '".$kode_ip."'";
        
        $sql 	= "select count(*) from pidsus.ms_inst_penyidik where ".$whereDef;
        $count 	= ($isNew)?$connection->createCommand($sql)->queryScalar():0;
        return $count;
    }
    
    public function simpanData($post){
        $connection     = $this->db;
        $kode_ip       = htmlspecialchars($post['kode_ip'], ENT_QUOTES);
        $nama           = htmlspecialchars($post['nama'], ENT_QUOTES);
        $akronim        = htmlspecialchars($post['akronim'], ENT_QUOTES);
        $isNew          = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

        $whereDef = "kode_ip = '".rawurldecode($kode_ip)."'";
        $transaction = $connection->beginTransaction();
        try{
            if($isNew){
                $sql1="insert into pidsus.ms_inst_penyidik values('".$kode_ip."','".$nama."','".$akronim."')";
            }else{
                $sql1 = "update pidsus.ms_inst_penyidik set nama='".$nama."',akronim='".$akronim."' where ".$whereDef;
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
                    $sql1 = "delete from pidsus.ms_inst_penyidik where kode_ip = '".rawurldecode($val)."'";
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
