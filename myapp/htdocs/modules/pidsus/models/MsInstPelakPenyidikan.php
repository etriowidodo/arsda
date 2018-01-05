<?php
namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class MsInstPelakPenyidikan extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.ms_inst_pelak_penyidikan';
    }
    
    public function cekTtdJabatan($post){
        $connection  = $this->db;
        $isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $kode_ip  = htmlspecialchars($post['instansi_pdk'], ENT_QUOTES);
        $kode_ipp  = htmlspecialchars($post['kode_ipp'], ENT_QUOTES);
        $whereDef = "kode_ip = '".$kode_ip."' and kode_ipp='".$kode_ipp."'";
        
        $sql 	= "select count(*) from pidsus.ms_inst_pelak_penyidikan where ".$whereDef;
        $count 	= ($isNew)?$connection->createCommand($sql)->queryScalar():0;
        return $count;
    }

    public function searchPer($params){
            $q1  = htmlspecialchars($params['q1'], ENT_QUOTES);

            $sql = "
            select a.*,b.nama as nama_inst_penyidik
            from pidsus.ms_inst_pelak_penyidikan a 
            join pidsus.ms_inst_penyidik b on a.kode_ip = b.kode_ip
            where 1=1";

            if($q1)
                    $sql .= " and (upper(a.nama) like '%".strtoupper($q1)."%' or upper(a.akronim) like '%".strtoupper($q1)."%' or upper(b.nama) like '%".strtoupper($q1)."%' or upper(b.akronim) like '%".strtoupper($q1)."%')";

            $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
            $count = $kueri->queryScalar();
            $sql .= " order by a.kode_ip";
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                            'totalCount' => $count,
            ]);
            return $dataProvider;
    }
    
    public function simpanData($post){
        $connection     = $this->db;
        $kode_ip        = htmlspecialchars($post['instansi_pdk'], ENT_QUOTES);
        $kode_ipp       = htmlspecialchars($post['kode_ipp'], ENT_QUOTES);
        $nama           = htmlspecialchars($post['nama'], ENT_QUOTES);
        $akronim        = htmlspecialchars($post['akronim'], ENT_QUOTES);
        $isNew          = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

        $whereDef = "kode_ip = '".$kode_ip."' and kode_ipp = '".$kode_ipp."'";
        $transaction = $connection->beginTransaction();
        try{
            if($isNew){
                $sql1="insert into pidsus.ms_inst_pelak_penyidikan values('".$kode_ip."','".$kode_ipp."','".$nama."','".$akronim."')";
            }else{
                $sql1 = "update pidsus.ms_inst_pelak_penyidikan set nama='".$nama."',akronim='".$akronim."' where ".$whereDef;
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
                    $sql1 = "delete from pidsus.ms_inst_pelak_penyidikan where kode_ip = '".rawurldecode($tmp[0])."' and kode_ipp = '".rawurldecode($tmp[1])."'";
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
