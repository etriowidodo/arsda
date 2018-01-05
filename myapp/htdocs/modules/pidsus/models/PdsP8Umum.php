<?php 

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsP8Umum extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p8_umum';
    }

	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		
		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "
		with tbl_jaksa as(
			select id_kejati, id_kejari, id_cabjari, no_p8_umum, string_agg(nama_jaksa, '#') as jpunya 
			from pidsus.pds_p8_umum_jaksa group by id_kejati, id_kejari, id_cabjari, no_p8_umum 
		)
		select a.no_p8_umum, a.tgl_p8_umum, b.jpunya 
		from pidsus.pds_p8_umum a 
		left join tbl_jaksa b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_p8_umum = b.no_p8_umum
                join pidsus.pds_p6 c on a.no_urut_p6=c.no_urut_p6 and a.tgl_p6=c.tgl_p6
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' ";
                if($q1)
                    $sql .= " and (upper(a.no_p8_umum) like '%".strtoupper($q1)."%' or to_char(a.tgl_p8_umum, 'DD-MM-YYYY') = '".$q1."')";
                
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_p8_umum desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
    
    public function searchp6($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$q1  = htmlspecialchars($params['mp6_q1'], ENT_QUOTES);
		$sql = "select a.* from pidsus.pds_p6 a 
				left join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
					and a.no_urut_p6 = b.no_urut_p6 and a.tgl_p6 = b.tgl_p6  
				where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and b.tgl_p6 is null";
		if($q1)
			$sql .= " and (to_char(a.tgl_p6, 'DD-MM-YYYY') = '".$q1."' or upper(a.nip_jaksa) like '%".strtoupper($q1)."%' or upper(a.nama_jaksa) like '%".strtoupper($q1)."%' or upper(a.pangkat_jaksa) like '%".strtoupper($q1)."%' or upper(a.tindak_pidana) like '%".strtoupper($q1)."%' or upper(a.dilakukan_oleh) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_p6 desc, a.no_urut_p6 desc";
		$dataProvider = new SqlDataProvider([
			'sql' => $sql,
			'totalCount' => $count,
		]);
		return $dataProvider;
    }
	
    public function cekPdsP8Umum($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
		$no_p8_umum	= htmlspecialchars($post['no_p8_umum'], ENT_QUOTES);
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$whereDef  	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p8_umum = '".$no_p8_umum."'";

        $sqlCek = "select count(*) from pidsus.pds_p8_umum where ".$whereDef;
		if($isNew){
			$count 	= $connection->createCommand($sqlCek)->queryScalar();
		} else{
			$id1 	= $_SESSION["pidsus_no_p8_umum"];
			$count 	= ($id1 == $no_p8_umum)?0:$connection->createCommand($sqlCek)->queryScalar();
		}
        
        if($count > 0){
            $pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>P-8 Umum dengan nomor '.$no_p8_umum.' sudah ada</i></p>';
            return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_p8_umum");
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
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_urut_p6		= htmlspecialchars($post['no_urut_p6'], ENT_QUOTES);
		$tgl_p6         = htmlspecialchars($post['tgl_p6'], ENT_QUOTES);
		$no_p8_umum		= htmlspecialchars($post['no_p8_umum'], ENT_QUOTES);
		$tgl_p8_umum	= htmlspecialchars($post['tgl_p8_umum'], ENT_QUOTES);
		$tindak_pidana	= htmlspecialchars($post['tindak_pidana'], ENT_QUOTES);
		$laporan_pidana	= htmlspecialchars($post['laporan_pidana'], ENT_QUOTES);

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
		$pathfile	= Yii::$app->params['p8umum'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_umum);
		$newPhoto 	= "p8_umum".$clean1.$extPhoto;

		$whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."'";
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
				$sql1 = "insert into pidsus.pds_p8_umum(id_kejati, id_kejari, id_cabjari, no_p8_umum, tgl_p8_umum, laporan_pidana, penandatangan_nama, penandatangan_nip, 
						 penandatangan_jabatan_pejabat, penandatangan_gol, penandatangan_pangkat, penandatangan_status_ttd, penandatangan_jabatan_ttd, created_user, created_nip, 
						 created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date, file_upload, no_urut_p6, tgl_p6, tindak_pidana) 
						 values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".$helpernya->tgl_db($tgl_p8_umum)."', '".$laporan_pidana."',
						 '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', 
						 '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW(), '".$newPhoto."', 
						 '".$no_urut_p6."', '".$helpernya->tgl_db($tgl_p6)."', '".$tindak_pidana."')";
			} else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_p8_umum set no_p8_umum = '".$no_p8_umum."', tgl_p8_umum = '".$helpernya->tgl_db($tgl_p8_umum)."', 
						 laporan_pidana = '".$laporan_pidana."', tindak_pidana = '".$tindak_pidana."', penandatangan_nama = '".$penandatangan_nama."', 
						 penandatangan_nip = '".$penandatangan_nip."', penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_p8_umum = '".$_SESSION['pidsus_no_p8_umum']."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql2 = "delete from pidsus.pds_p8_umum_jaksa where no_p8_umum = '".$no_p8_umum."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['jaksa']) > 0){
				foreach($post['jaksa'] as $idx=>$val){
					list($nip, $gol, $pangkat, $jabatan, $nama, $jabatan_p8) = explode("|#|", $val);
					$sql3 = "insert into pidsus.pds_p8_umum_jaksa values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".($idx+1)."', 
							 '".$nip."', '".$nama."', '".$gol."', '".$pangkat."', '".$jabatan."', '".$jabatan_p8."')";
					$connection->createCommand($sql3)->execute();
				}
			}

			$sql4 = "delete from pidsus.pds_p8_umum_tembusan where no_p8_umum = '".$no_p8_umum."'";
			$connection->createCommand($sql4)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql5 = "insert into pidsus.pds_p8_umum_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', 
								 '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql5)->execute();
					}
				}
			}

			if($isNew){
				$sqlP = "insert into pidsus.pds_trx_pemrosesan(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, id_menu, id_user_login, durasi, no_p8_umum)
						(
							select '".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '-', '1970-01-01', id, 'trigger', NOW(), '".$no_p8_umum."' 
							from menu where module = 'PIDSUS' and tipe_menu = 'FLOW2'
						)";
				$connection->createCommand($sqlP)->execute();
			}
			if(!$isNew && $no_p8_umum != $_SESSION['pidsus_no_p8_umum']){
				$sqlup = "update pidsus.pds_trx_pemrosesan set no_p8_umum = '".$no_p8_umum."' where ".$whereDef." and no_p8_umum = '".$_SESSION['pidsus_no_p8_umum']."'";
				$connection->createCommand($sqlup)->execute();
			}

			if($upl1){
				$tmpPot = glob($pathfile."p8_umum".$clean1.".*");
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

    public function hapusData($post){
		$connection 	= $this->db;
		$pathfile	= Yii::$app->params['p8umum'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$kue = "select file_upload from pidsus.pds_p8_umum where ".$whereDefault." and no_p8_umum = '".rawurldecode($val)."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from pidsus.pds_p8_umum where ".$whereDefault." and no_p8_umum = '".rawurldecode($val)."'";
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

	public function explodeUpload($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
		$nom_spdp  	= $_SESSION['no_spdp'];
		$tgl_spdp 	= $_SESSION['tgl_spdp'];
		$nom_p16 	= htmlspecialchars($post['id'], ENT_QUOTES);
		$where 		= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$nom_spdp."' 
						and tgl_spdp = '".$tgl_spdp."'";
		$sql1 = "select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_p16, file_upload_p16 from pidsus.pds_p16 where ".$where." and no_p16 = '".$nom_p16."'";
		$row1 = $connection->createCommand($sql1)->queryOne();
		$data = array();
		$data['id_kejati'] 	= $row1['id_kejati'];
		$data['id_kejari'] 	= $row1['id_kejari'];
		$data['id_cabjari']	= $row1['id_cabjari'];
		$data['no_spdp']	= $row1['no_spdp'];
		$data['tgl_spdp']	= $row1['tgl_spdp'];
		$data['no_p16'] 	= $row1['no_p16'];
		$data['file_upload_p16'] = $row1['file_upload_p16'];
		return $data;
	}

	public function simpanUpload($post){
		$connection 	= $this->db;
		$id_kejati		= htmlspecialchars($post['id_kejati'], ENT_QUOTES);
		$id_kejari		= htmlspecialchars($post['id_kejari'], ENT_QUOTES);
		$id_cabjari		= htmlspecialchars($post['id_cabjari'], ENT_QUOTES);
		$no_spdp		= htmlspecialchars($post['no_spdp'], ENT_QUOTES);
		$tgl_spdp		= htmlspecialchars($post['tgl_spdp'], ENT_QUOTES);
		$no_p16			= htmlspecialchars($post['no_p16'], ENT_QUOTES);
		$updated_user	= $_SESSION['username'];
		$updated_nip	= $_SESSION['nik_user'];
		$updated_nama	= $_SESSION['nama_pegawai'];
		$updated_ip		= $_SERVER['REMOTE_ADDR'];

		$helpernya	= Yii::$app->inspektur;
		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['p16'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_spdp);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_spdp);
		$clean3 	= Yii::$app->inspektur->sanitize_filename($no_p16);
		$newPhoto 	= "p16_".$clean1."-".$clean2."-".$clean3.$extPhoto;

		$transaction = $connection->beginTransaction();
		try{
			if($filePhoto != ""){
				$filenya = ", file_upload_p16 = '".$newPhoto."'";
				$sql1 = "update pidsus.pds_p16 set file_upload_p16 = '".$newPhoto."' where id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and 
						 id_cabjari = '".$id_cabjari."' and no_spdp = '".$no_spdp."' and tgl_spdp = '".$tgl_spdp."' and no_p16 = '".$no_p16."'";
				$connection->createCommand($sql1)->execute();

				$tmpPot = glob($pathfile."p16_".$clean1."-".$clean2."-".$clean3.".*");
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

}
