<?php

namespace app\modules\datun\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\HtmlPurifier;
use app\components\InspekturComponent;
   
class S13 extends \yii\db\ActiveRecord {
	public static function tableName(){
        return 'datun.s13';
    }
 
    public function simpanDatas13($post){		
		$connection 			= Yii::$app->db; 			
		$isNewRecord			= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_register_perkara 	= $_SESSION['no_register_perkara'];	
		$no_surat 				= $_SESSION['no_surat'];		
		$kode_tk 				= $_SESSION['kode_tk'];
		$kode_kejati			= $_SESSION['kode_kejati'];
		$kode_kejari 			= $_SESSION['kode_kejari'];
		$kode_cabjari 			= $_SESSION['kode_cabjari'];	
		
		$no_register_skk 		= htmlspecialchars($post['no_skk'], ENT_QUOTES);
		$no_register_skks 		= htmlspecialchars($post['no_skks'], ENT_QUOTES);
		$tanggal_diterima 		= htmlspecialchars($post['tanggals13'], ENT_QUOTES);
		$tanggal_skk 			= htmlspecialchars($post['tanggal_skk'], ENT_QUOTES);
		$hlampiran 				= htmlspecialchars($post['hlampiran'], ENT_QUOTES);
		$kepada_yth 			= htmlspecialchars($post['untuk'], ENT_QUOTES);
		$tempat 				= htmlspecialchars($post['tempat'], ENT_QUOTES);
		$eksepsi				= str_replace(array("'"), array("&#039;"), $post['jeksepsi']);
		$provisi				= str_replace(array("'"), array("&#039;"), $post['jprovisi']);
		$pokokperkara			= str_replace(array("'"), array("&#039;"), $post['jpokok']);
		$rekonvensi				= str_replace(array("'"), array("&#039;"), $post['jrekonvensi']);
		$prim_eksepsi			= str_replace(array("'"), array("&#039;"), $post['peksepsi']);
		$prim_provisi			= str_replace(array("'"), array("&#039;"), $post['pprovisi']);
		$prim_pokokperkara		= str_replace(array("'"), array("&#039;"), $post['ppokok']);
		$prim_rekonvensi		= str_replace(array("'"), array("&#039;"), $post['prekonvensi']);
		$prim_konvensirekonvensi= str_replace(array("'"), array("&#039;"), $post['pkonvensirekonvensi']);
		$subsidair				= str_replace(array("'"), array("&#039;"), $post['subsidair']);
		
		
		$max_size				= 2 * 1024 * 1024;
		$allow_type				= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$helpernya				= Yii::$app->inspektur;
		$pathfile				= Yii::$app->params['s13'];

		$filePhoto1 			= htmlspecialchars($_FILES['file_s13']['name'],ENT_QUOTES);
		$sizePhoto1 			= htmlspecialchars($_FILES['file_s13']['size'],ENT_QUOTES);
		$tempPhoto1 			= htmlspecialchars($_FILES['file_s13']['tmp_name'],ENT_QUOTES);
		$extPhoto1 				= substr($filePhoto1,strrpos($filePhoto1,'.'));
		$clean1 				= Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean2 				= Yii::$app->inspektur->sanitize_filename($no_surat);
		$clean3 				= Yii::$app->inspektur->sanitize_filename($no_register_skks);
		$newPhoto1 				= "S13_".$clean1."-".$clean2."-".$clean3.$extPhoto1;	
	
		$create_user			= $_SESSION['username']; 
		$create_nip				= $_SESSION['nik_user'];
		$create_nama			= $_SESSION['nama_pegawai'];
		$create_ip				= $_SERVER['REMOTE_ADDR'];		
		$update_user			= $_SESSION['username'];  
		$update_nip				= $_SESSION['nik_user'];
		$update_nama			= $_SESSION['nama_pegawai']; 
		$update_ip				= $_SERVER['REMOTE_ADDR'];
		$helpernya				= Yii::$app->inspektur;
		
		$transaction = $connection->beginTransaction();
		try{		
			if($isNewRecord){
				$sql1 = "update datun.permohonan set status = 'S-13' where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
				$connection->createCommand($sql1)->execute();
				
				$upl1 = false;
				$sql1 = "insert into datun.s13(no_register_skk, tanggal_skk, no_surat, tanggal_diterima, no_register_perkara, kode_tk, kode_kejati, kode_kejari, kode_cabjari, 
						kepada_yth, tempat, eksepsi, provisi, pokokperkara, rekonvensi, prim_eksepsi, prim_provisi, prim_pokokperkara, prim_rekonvensi, prim_konvensirekonvensi, 
						subsidair, create_user, create_nama, create_nip, create_ip, create_date, update_user, update_nama, update_nip, update_ip, update_date, no_register_skks";
				if($filePhoto1 != ""){
					$upl1 = true;
					$sql1 .= ", file_s13";
				}
				$sql1 .= ") values('".$no_register_skk."', '".$helpernya->tgl_db($tanggal_skk)."', '".$no_surat."', '".$helpernya->tgl_db($tanggal_diterima)."', 
						'".$no_register_perkara."', '".$kode_tk."', '".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."', '".$kepada_yth."', '".$tempat."', '".$eksepsi."',
						'".$provisi."', '".$pokokperkara."', '".$rekonvensi."', '".$prim_eksepsi."', '".$prim_provisi."', '".$prim_pokokperkara."', '".$prim_rekonvensi."', 
						'".$prim_konvensirekonvensi."', '".$subsidair."', '".$create_user."', '".$create_nama."', '".$create_nip."', '".$create_ip."', NOW(), 
						'".$update_user."', '".$update_nama."', '".$update_nip."', '".$update_ip."', NOW(),'".$no_register_skks."'";				
				if($filePhoto1 != "") $sql1 .= ", '".$newPhoto1."'";
				$sql1 .= ")";
				$eksekusi = $connection->createCommand($sql1)->execute();
				
			} else{
				$upl1 = false;
				$sql1 = "update datun.s13 set tempat = '".$tempat."', eksepsi = '".$eksepsi."', provisi = '".$provisi."', pokokperkara = '".$pokokperkara."',				
						rekonvensi = '".$rekonvensi."', prim_eksepsi = '".$prim_eksepsi."', prim_provisi = '".$prim_provisi."', prim_pokokperkara = '".$prim_pokokperkara."', 
						prim_rekonvensi = '".$prim_rekonvensi."', subsidair = '".$subsidair."', prim_konvensirekonvensi = '".$prim_konvensirekonvensi."', 
						update_user = '".$update_user."', update_nip = '".$update_nip."', update_nama = '".$update_nama."', update_date = NOW(), update_ip = '".$update_ip."', 
						tanggal_diterima = '".$helpernya->tgl_db($tanggal_diterima)."', kepada_yth = '".$kepada_yth."'";
				if($filePhoto1 != ""){
					$upl1 = true;
					$sql1 .= ", file_s13 = '".$newPhoto1."'";
				}
				$sql1 .= " where no_register_perkara= '".$no_register_perkara."' and no_surat = '".$no_surat."'";
				$connection->createCommand($sql1)->execute();
			}
			if($upl1){
				$tmpPot = glob($pathfile."S13_".$clean1."-".$clean2."-".$clean3.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto1;
				$mantab  = move_uploaded_file($tempPhoto1, $tujuan);
				if(file_exists($tempPhoto1)) unlink($tempPhoto1);
			}
			$transaction->commit();
			return true;
			
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }	
	
	
	public function searchCustom($no_surat_telaah = ''){
		$no_register_perkara = $_SESSION['no_register_perkara'];	
		$no_surat = $_SESSION['no_surat'];		
		
		if(!$no_surat_telaah){
			$sql = "select * from datun.template_tembusan where kode_template_surat ='S-5.A'";		
			$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
			$count = $kueri->queryScalar();
			$sql .= " order by no_urut";
			$dataProvider = new SqlDataProvider([
				'sql' => $sql,
				'totalCount' => $count,
			]);
			return $dataProvider;	
		} else{ 
			$sql = "select no_surat_telaah as kode_template_surat ,no_temb_tt as no_urut,deskripsi_tembusan as tembusan from datun.keputusan_telaah_tembusan 
					where no_register_perkara= '$no_register_perkara' and no_surat='$no_surat' and no_surat_telaah ='$no_surat_telaah'";		
			$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
			$count = $kueri->queryScalar();
			$sql .= " order by no_temb_tt";
			$dataProvider = new SqlDataProvider([
				'sql' => $sql,
				'totalCount' => $count,
			]);
			return $dataProvider;
		}
    }

	public function searchTtd($params){
		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$id  = htmlspecialchars($params['id'], ENT_QUOTES);
		
		$connection = Yii::$app->db;	
		$kode_tk = Yii::$app->session->get('kode_tk');	
		
		$sql = "select distinct a.*, b.nama, b.jabatan, case when b.pns_jnsjbtfungsi = 0 then b.gol_kd||' '||b.gol_pangkatjaksa else b.gol_kd||' '||b.gol_pangkat2 end as pangkat 
				from datun.m_penandatangan_pejabat a join kepegawaian.kp_pegawai b on a.nip = b.peg_nip_baru 
				where a.kode_tk = '".$kode_tk."'";
		if($id)
			$sql .= " and a.status ='".$id."'";	
		if($q1)
			$sql .= " and (a.nip like '".$q1."%' or upper(b.nama) like '%".strtoupper($q1)."%' or upper(b.jabatan) like '%".strtoupper($q1)."%' 
					 or upper(a.status) = '".strtoupper($q1)."')";	

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProviderx = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
        ]);
        return $dataProviderx;
    }
}	
