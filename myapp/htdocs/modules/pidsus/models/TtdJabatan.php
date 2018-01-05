<?php
namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class TtdJabatan extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.ms_penandatangan';
    }

    public function searchPer($params){
            $q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
            $id_kejati  = $_SESSION['kode_kejati'];
            $id_kejari  = $_SESSION['kode_kejari'];
            $id_cabjari = $_SESSION['kode_cabjari'];
            $whereDef = " and id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."'";
            $sql = "
            select a.*
            from pidsus.ms_penandatangan a
            where 1=1".$whereDef;
            if($q1)
                    $sql .= " and (upper(a.kode) like '%".strtoupper($q1)."%' or upper(a.deskripsi) like '%".strtoupper($q1)."%')";

            $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
            $count = $kueri->queryScalar();
            $sql .= " order by a.kode";
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                            'totalCount' => $count,
            ]);
            return $dataProvider;
    }
    
    public function cekTtdJabatan($post){
        $connection  = $this->db;
        $id_kejati  = $_SESSION['kode_kejati'];
        $id_kejari  = $_SESSION['kode_kejari'];
        $id_cabjari = $_SESSION['kode_cabjari'];
        $isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $kode 	= htmlspecialchars($post['kode'], ENT_QUOTES);
        $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and kode = '".$kode."'";
        $sql 	= "select count(*) from pidsus.ms_penandatangan where ".$whereDef;
        $count 	= ($isNew)?$connection->createCommand($sql)->queryScalar():0;
        return $count;
    }
    
    public function simpanData($post){
        $connection = $this->db;
        $id_kejati  = $_SESSION['kode_kejati'];
        $id_kejari  = $_SESSION['kode_kejari'];
        $id_cabjari = $_SESSION['kode_cabjari'];
        $kode       = htmlspecialchars($post['kode'], ENT_QUOTES);
        $deskripsi  = htmlspecialchars($post['deskripsi'], ENT_QUOTES);
        $isNew      = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

        $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and kode = '".rawurldecode($kode)."'";
        $transaction = $connection->beginTransaction();
        try{
            if($isNew){
                $sql1="insert into pidsus.ms_penandatangan values('".$id_kejati."','".$id_kejari."','".$id_cabjari."','".rawurldecode($kode)."','".rawurldecode($deskripsi)."')";
            }else{
                $sql1 = "update pidsus.ms_penandatangan set deskripsi='".rawurldecode($deskripsi)."' where ".$whereDef;
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
        $id_kejati  = $_SESSION['kode_kejati'];
        $id_kejari  = $_SESSION['kode_kejari'];
        $id_cabjari = $_SESSION['kode_cabjari'];
        
        $transaction = $connection->beginTransaction();
        try {
            if(count($post['id']) > 0){
                foreach($post['id'] as $idx=>$val){
                    $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and kode = '".rawurldecode($val)."'";
                    $sql1 = "delete from pidsus.ms_penandatangan where ".$whereDef;
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
