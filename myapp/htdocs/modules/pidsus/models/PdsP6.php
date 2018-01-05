<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsP6 extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p6';
    }

    public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);

		$sql = "
		select * from pidsus.pds_p6
		where id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' ";

		if($q1)
			$sql .= " and (to_char(tgl_p6, 'DD-MM-YYYY') = '".$q1."' or upper(nip_jaksa) like '%".strtoupper($q1)."%' or upper(nama_jaksa) like '%".strtoupper($q1)."%' or upper(pangkat_jaksa) like '%".strtoupper($q1)."%' or upper(melaporkan_dari) like '%".strtoupper($q1)."%' or upper(dilakukan_oleh) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by tgl_p6 desc, no_urut_p6 desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
    
    public function cekp6($post){
        $connection  = $this->db;
        $isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $helpernya	= Yii::$app->inspektur;
        $no_urut_p6	= htmlspecialchars($post['no_urut_p6'], ENT_QUOTES);
        $tgl_p6 	= htmlspecialchars($post['tgl_p6'], ENT_QUOTES);
        $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_urut_p6 = '".$no_urut_p6."' 
		and tgl_p6 = '".$helpernya->tgl_db($tgl_p6)."'";
        
        $sql 	= "select count(*) from pidsus.pds_p6 where ".$whereDef;
		if($isNew){
			$count 	= $connection->createCommand($sql)->queryScalar();
		} else{
			$id1 	= $_SESSION["pidsus_no_urut_p6"];
			$id2 	= str_replace("-","/",$_SESSION["pidsus_tgl_p6"]);
			$count 	= ($id1 == $no_urut_p6 && $id2 == $helpernya->tgl_db($tgl_p6))?0:$connection->createCommand($sql)->queryScalar();
		}
        
        if($count > 0){
            $pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>P-6 dengan nomor urut '.$no_urut_p6.' tanggal '.$tgl_p6.' sudah ada</i></p>';
            return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_urut_p6");
        } else{
            return array("hasil"=>true, "error"=>"", "element"=>"");
        }
    }

    public function simpanData($post){
		$connection = $this->db;
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$helpernya	= Yii::$app->inspektur;
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$tgl_p6 			= htmlspecialchars($post['tgl_p6'], ENT_QUOTES);
		$nip_jaksa      	= htmlspecialchars($post['nip_jaksa'], ENT_QUOTES);
		$nama_jaksa     	= htmlspecialchars($post['nama_jaksa'], ENT_QUOTES);
		$gol_jaksa      	= htmlspecialchars($post['gol_jaksa'], ENT_QUOTES);
		$pangkat_jaksa  	= htmlspecialchars($post['pangkat_jaksa'], ENT_QUOTES);
		$jabatan_jaksa  	= htmlspecialchars($post['jabatan_jaksa'], ENT_QUOTES);
		$melaporkan_kepada  = htmlspecialchars($post['melaporkan_kepada'], ENT_QUOTES);
		$melaporkan_dari 	= htmlspecialchars($post['melaporkan_dari'], ENT_QUOTES);
		$tindak_pidana 		= htmlspecialchars($post['tindak_pidana'], ENT_QUOTES);
		$dilakukan_oleh    	= htmlspecialchars($post['dilakukan_oleh'], ENT_QUOTES);
		$kasus_posisi    	= htmlspecialchars($post['kasus_posisi'], ENT_QUOTES);

		$created_user	= $_SESSION['username'];
		$created_nip	= $_SESSION['nik_user'];
		$created_nama	= $_SESSION['nama_pegawai'];
		$created_ip		= $_SERVER['REMOTE_ADDR'];
		$updated_user	= $_SESSION['username'];
		$updated_nip	= $_SESSION['nik_user'];
		$updated_nama	= $_SESSION['nama_pegawai'];
		$updated_ip		= $_SERVER['REMOTE_ADDR'];

        $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."'";
		$transaction = $connection->beginTransaction();
		try{
			if($isNew){
				$sql1 = "insert into pidsus.pds_p6(id_kejati, id_kejari, id_cabjari, tgl_p6, nip_jaksa, nama_jaksa, gol_jaksa, pangkat_jaksa, 
						 jabatan_jaksa, melaporkan_kepada, melaporkan_dari, tindak_pidana, dilakukan_oleh, kasus_posisi, created_user, created_nip, 
						 created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date) values('".$id_kejati."', 
						 '".$id_kejari."', '".$id_cabjari."', '".$helpernya->tgl_db($tgl_p6)."', '".$nip_jaksa."', '".$nama_jaksa."', 
						 '".$gol_jaksa."', '".$pangkat_jaksa."', '".$jabatan_jaksa."', '".$melaporkan_kepada."', '".$melaporkan_dari."', 
						 '".$tindak_pidana."', '".$dilakukan_oleh."', '".$kasus_posisi."', 
						 '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			} else{
				$sql1 = "update pidsus.pds_p6 set tgl_p6 = '".$helpernya->tgl_db($tgl_p6)."', 
						 nip_jaksa = '".$nip_jaksa."', nama_jaksa = '".$nama_jaksa."', gol_jaksa = '".$gol_jaksa."', 
						 pangkat_jaksa = '".$pangkat_jaksa."', jabatan_jaksa = '".$jabatan_jaksa."', melaporkan_kepada = '".$melaporkan_kepada."', 
						 melaporkan_dari = '".$melaporkan_dari."', tindak_pidana = '".$tindak_pidana."', dilakukan_oleh = '".$dilakukan_oleh."', 
						 kasus_posisi = '".$kasus_posisi."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW() 
						 where ".$whereDef." and no_urut_p6 = '".$_SESSION['pidsus_no_urut_p6']."' and tgl_p6 = '".$_SESSION['pidsus_tgl_p6']."'";
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
        $connection 	= $this->db;
        $id_kejati		= $_SESSION['kode_kejati'];
        $id_kejari		= $_SESSION['kode_kejari'];
        $id_cabjari		= $_SESSION['kode_cabjari'];

        $transaction 	= $connection->beginTransaction();
        $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."'";
        try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("|#|", $val);
					$sql1 = "delete from pidsus.pds_p6 where ".$whereDef." and no_urut_p6 = '".rawurldecode($tmp[0])."' and tgl_p6 = '".rawurldecode($tmp[1])."'";
	
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
