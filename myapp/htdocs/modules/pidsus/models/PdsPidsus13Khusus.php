<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsPidsus13Khusus extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p16';
    }
    public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_pidsus18	= $_SESSION['pidsus_no_pidsus18'];
		
		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "
		select a.*
		from pidsus.pds_pidsus13_khusus a 
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_pidsus18 = '".$no_pidsus18."'";
                if($q1)
                    $sql .= " and (upper(a.no_pidsus13_khusus) like '%".strtoupper($q1)."%' or to_char(a.tgl_pidsus13_khusus, 'DD-MM-YYYY') = '".$q1.
                        "' or upper(c.penandatangan_nama) like '%".strtoupper($q1)."%' or upper(c.penandatangan_nip) like '%".strtoupper($q1)."%')";
                
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_pidsus13_khusus desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
    
    public function cekpidsus13khusus($post){
        $connection = $this->db;
        $helpernya	= Yii::$app->inspektur;
        $id_kejati 	= $_SESSION['kode_kejati'];
        $id_kejari 	= $_SESSION['kode_kejari'];
        $id_cabjari = $_SESSION['kode_cabjari'];
        $no_pidsus18    = $_SESSION['pidsus_no_pidsus18'];
        $no_p8_khusus	= htmlspecialchars($post['no_p8_khusus'], ENT_QUOTES);
        $no_pidsus13_khusus = htmlspecialchars($post['no_pidsus13_khusus'], ENT_QUOTES);
        $isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $whereDef 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_pidsus18 = '".$no_pidsus18.
                            "' and no_p8_khusus = '".$no_p8_khusus."' and no_pidsus13_khusus = '".$no_pidsus13_khusus."'";

        $sqlCek = "select count(*) from pidsus.pds_pidsus13_khusus where ".$whereDef;
        
        if($isNew){
            $count 	= $connection->createCommand($sqlCek)->queryScalar();
        } else{
            $id1 	= $_SESSION["pidsus_no_pidsus13_khusus"];
            $count 	= ($id1 == $no_pidsus13_khusus)?0:$connection->createCommand($sqlCek)->queryScalar();
        }
        
        if($count > 0){
            $pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>Maaf Nomor Pidsus 13 Khusus dengan nomor '.$no_pidsus13_khusus.' sudah ada</i></p>';
            return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_pidsus13_khusus");
        } else{
            return array("hasil"=>true, "error"=>"", "element"=>"");
        }
    }

	public function simpanData($post){
		$helpernya	= Yii::$app->inspektur;
		$connection = $this->db;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
                $no_pidsus18	= $_SESSION['pidsus_no_pidsus18'];
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_p8_khusus			= htmlspecialchars($post['no_p8_khusus'], ENT_QUOTES);
		$no_pidsus13_khusus	= htmlspecialchars($post['no_pidsus13_khusus'], ENT_QUOTES);
		$tgl_pidsus13_khusus	= htmlspecialchars($post['tgl_pidsus13_khusus'], ENT_QUOTES);
		$sifat 				= htmlspecialchars($post['sifat'], ENT_QUOTES);
		$lampiran			= htmlspecialchars($post['lampiran'], ENT_QUOTES);
		
		$penandatangan_nama     = htmlspecialchars($post['penandatangan_nama'], ENT_QUOTES);
		$penandatangan_nip      = htmlspecialchars($post['penandatangan_nip'], ENT_QUOTES);
		$penandatangan_jabatan  = htmlspecialchars($post['penandatangan_jabatan'], ENT_QUOTES);
		$penandatangan_gol      = htmlspecialchars($post['penandatangan_gol'], ENT_QUOTES);
		$penandatangan_pangkat  = htmlspecialchars($post['penandatangan_pangkat'], ENT_QUOTES);
		$penandatangan_status_ttd   = htmlspecialchars($post['penandatangan_status'], ENT_QUOTES);
		$penandatangan_jabatan_ttd  = htmlspecialchars($post['penandatangan_ttdjabat'], ENT_QUOTES);
		
		$created_user 	= $_SESSION['username'];
		$created_nip	= $_SESSION['nik_user'];
		$created_nama	= $_SESSION['nama_pegawai'];
		$created_ip 	= $_SERVER['REMOTE_ADDR'];
		$updated_user 	= $_SESSION['username'];
		$updated_nip 	= $_SESSION['nik_user'];
		$updated_nama 	= $_SESSION['nama_pegawai'];
		$updated_ip 	= $_SERVER['REMOTE_ADDR'];

		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['pidsus_13khusus'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_khusus);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_pidsus13_khusus);
		$newPhoto 	= "pidsus13khusus_".$clean1."-".$clean2.$extPhoto;
		$whereDef 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_pidsus18 = '".$no_pidsus18."' and no_p8_khusus = '".$no_p8_khusus."'";

		$transaction = $connection->beginTransaction();
		try{
			if($isNew){
				if($filePhoto != ""){
					$upl1 = true;
					$newPhoto = $newPhoto;
				} else{
					$upl1 = false;
					$newPhoto = "";
				}
				$sql1 = "insert into pidsus.pds_pidsus13_khusus(id_kejati, id_kejari, id_cabjari, no_pidsus18, no_p8_khusus, no_pidsus13_khusus, tgl_pidsus13_khusus, sifat, lampiran, 
						 penandatangan_nama, penandatangan_nip, penandatangan_jabatan_pejabat, penandatangan_gol, penandatangan_pangkat, penandatangan_status_ttd, 
						 penandatangan_jabatan_ttd, created_user, created_nip, created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, 
						 updated_date, file_upload) values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_pidsus18."', '".$no_p8_khusus."', '".$no_pidsus13_khusus."', 
						 '".$helpernya->tgl_db($tgl_pidsus13_khusus)."', '".$sifat."', '".$lampiran."', '".$penandatangan_nama."', '".$penandatangan_nip."', 
						 '".$penandatangan_jabatan."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', 
						 '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW(), '".$newPhoto."')";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_pidsus13_khusus set no_pidsus13_khusus = '".$no_pidsus13_khusus."', tgl_pidsus13_khusus = '".$helpernya->tgl_db($tgl_pidsus13_khusus)."', 
						 sifat = '".$sifat."', lampiran = '".$lampiran."', penandatangan_nama = '".$penandatangan_nama."', penandatangan_nip = '".$penandatangan_nip."', 
						 penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_pidsus13_khusus = '".$_SESSION['pidsus_no_pidsus13_khusus']."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql4 = "delete from pidsus.pds_pidsus13_khusus_tembusan where ".$whereDef." and no_pidsus13_khusus = '".$no_pidsus13_khusus."'";
			$connection->createCommand($sql4)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql5 = "insert into pidsus.pds_pidsus13_khusus_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_pidsus18."', '".$no_p8_khusus."', 
								'".$no_pidsus13_khusus."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql5)->execute();
					}
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."pidsus13khusus_".$clean1."-".$clean2.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto;
				$mantab  = move_uploaded_file($tempPhoto, $tujuan);
				if(file_exists($tempPhoto)) unlink($tempPhoto);
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }

    public function hapusData($id1, $id2, $id3){
		$connection 	= $this->db;
		$pathfile	= Yii::$app->params['pidsus_13khusus'];
                $id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$transaction 	= $connection->beginTransaction();
		$whereDef 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_pidsus18 = '".rawurldecode($id1)."'";
		try {
                       $kue = "select file_upload from pidsus.pds_pidsus13_khusus where ".$whereDef." and no_p8_khusus = '".rawurldecode($id2)."' 
                            and no_pidsus13_khusus = '".rawurldecode($id3)."'";
                        $file = $connection->createCommand($kue)->queryOne();
                        if($file['file_upload'] && file_exists($pathfile.$file['file_upload'])) unlink($pathfile.$file['file_upload']);

                        $sql1 = "delete from pidsus.pds_pidsus13_khusus where ".$whereDef." and no_p8_khusus = '".rawurldecode($id2)."' 
                            and no_pidsus13_khusus = '".rawurldecode($id3)."'";
                        $connection->createCommand($sql1)->execute();
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }

}
