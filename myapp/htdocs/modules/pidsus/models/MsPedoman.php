<?php
namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class MsPedoman extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.ms_pasal';
    }

    public function searchPer($params){
            $q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
            $sql = "
            Select a.*,b.uu,c.pasal
            from pidsus.ms_pedoman a
            left join pidsus.ms_u_undang b on a.id=b.id
            left join pidsus.ms_pasal c on a.id_pasal=c.id_pasal
            where 1=1";
            if($q1)
                    $sql .= " and ( upper(b.uu) like '%".strtoupper($q1)."%' or upper(c.pasal) like '%".strtoupper($q1)."%' "
                    . "or upper(a.ancaman) like '%".strtoupper($q1)."%' "
                    . "or upper(a.tuntutan_pidana) like '%".strtoupper($q1)."%')";

            $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
            $count = $kueri->queryScalar();
            $sql .= " order by a.id,a.id_pasal,a.kategori";
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                            'totalCount' => $count,
            ]);
            return $dataProvider;
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
    
    public function cekTtdJabatan($post){
        $connection = $this->db;
        $isNew      = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $id         = htmlspecialchars($post['id'], ENT_QUOTES);
        $id_pasal   = htmlspecialchars($post['id_pasal'], ENT_QUOTES);
        $kategori   = htmlspecialchars($post['kategori'], ENT_QUOTES);
        
        $whereDef = "id = '".$id."' and id_pasal='".$id_pasal."' and kategori='".$kategori."'";
        
        $sql 	= "select count(*) from pidsus.ms_pedoman where ".$whereDef;
        $count 	= ($isNew)?$connection->createCommand($sql)->queryScalar():0;
        return $count;
    }
    
    public function simpanData($post){
        $connection = $this->db;
        $id         = htmlspecialchars($post['id'], ENT_QUOTES);
        $id_pasal   = htmlspecialchars($post['id_pasal'], ENT_QUOTES);
        $kategori   = htmlspecialchars($post['kategori'], ENT_QUOTES);
        $tuntutan_pidana = htmlspecialchars($post['tuntutan_pidana'], ENT_QUOTES);
        $ancaman    = htmlspecialchars($post['ancaman'], ENT_QUOTES);
        $denda      = htmlspecialchars($post['denda'], ENT_QUOTES);
        $isNew      = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $denda =($denda=="")?"null":"'".$denda."'";
        $transaction = $connection->beginTransaction();
        try{
            if($isNew){
                $sql1="insert into pidsus.ms_pedoman(id,id_pasal,kategori,tuntutan_pidana,ancaman,denda) values('".$id."','".$id_pasal."','".$kategori."','".$tuntutan_pidana."','".$ancaman."',".$denda.")";
            }else{
                $sql1 = "update pidsus.ms_pedoman set tuntutan_pidana='".$tuntutan_pidana."',ancaman='".$ancaman."',denda=".$denda."  where id='".$id."' and id_pasal='".$id_pasal."' and kategori='".$kategori."'";
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
                    $sql1 = "delete from pidsus.ms_pedoman where id = '".rawurldecode($tmp[0])."' and id_pasal='".rawurldecode($tmp[1])."' and kategori='".rawurldecode($tmp[2])."'";
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
