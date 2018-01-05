<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsB7Umum extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p16';
    }
    
	public function searchPer($params){
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $no_p8_umum	= $_SESSION['pidsus_no_p8_umum'];

        $q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "
		with tbl_sitaan as(
			select id_kejati, id_kejari, id_cabjari, no_p8_umum, no_b4_umum, string_agg(nama_barang_disita, '#' order by no_urut_penyitaan) as sitaan 
			from pidsus.pds_b4_umum_penyitaan group by id_kejati, id_kejari, id_cabjari, no_p8_umum, no_b4_umum 
		)
		select a.*, b.tgl_dikeluarkan as tgl_b4_umum, c.sitaan 
		from pidsus.pds_b7_umum a 
		join pidsus.pds_b4_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_p8_umum = b.no_p8_umum and a.no_b4_umum = b.no_b4_umum 
		left join tbl_sitaan c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
			and b.no_p8_umum = c.no_p8_umum and b.no_b4_umum = c.no_b4_umum 
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_p8_umum = '".$no_p8_umum."'";

        if($q1)
			$sql .= " and (upper(a.no_b7_umum) like '%".strtoupper($q1)."%' or to_char(a.tgl_dikeluarkan, 'DD-MM-YYYY') = '".$q1."' or 
					upper(b.no_b4_umum) like '%".strtoupper($q1)."%' or to_char(b.tgl_dikeluarkan, 'DD-MM-YYYY') = '".$q1."' or upper(c.sitaan) like '%".strtoupper($q1)."%')";
		
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_dikeluarkan desc, a.created_date desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

    public function searchB4Sita($post){
        $connection 	= $this->db;
		$id 			=   htmlspecialchars($post['id'], ENT_QUOTES);
        $whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
			and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        
		$sql = "select a.* from pidsus.pds_b4_umum_penyitaan a where ".$whereDefault." and a.no_b4_umum = '".$id."' order by a.no_urut_penyitaan";
        $res = $connection->createCommand($sql)->queryAll();
        if(count($res) == 0){
            $hasil= '<tr><td colspan="5">Data tidak ditemukan</td></tr>';
         } else{
             $nom = 0;
             foreach($res as $data){
                $nom++;
                $hasil.= '
                 <tr>
					 <td class="text-center"><span>'.$nom.'</span></td>
					 <td class="text-left">'.$data['nama_barang_disita'].'</td>
                 </tr>';
             }
         }
        return $hasil;
    }
    
    public function searchb4($params){
        $q1  = htmlspecialchars($params['mb4_q1'], ENT_QUOTES);
        $whereDefault = "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
			and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        $sql = "select a.no_b4_umum, a.tgl_dikeluarkan from pidsus.pds_b4_umum a where ".$whereDefault;
        if($q1)
			$sql .= " and (to_char(a.tgl_dikeluarkan, 'DD-MM-YYYY') = '".$q1."' or upper(a.no_b4_umum) like '%".strtoupper($q1)."%')";
        $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
        $count = $kueri->queryScalar();
        $sql .= " order by a.tgl_dikeluarkan desc";
        $dataProvider = new SqlDataProvider([
			'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

    public function cekPdsB7Umum($post){
        $connection = $this->db;
        $helpernya	= Yii::$app->inspektur;
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $no_b7_umum = htmlspecialchars($post['no_b7_umum'], ENT_QUOTES);
        $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_b7_umum = '".$no_b7_umum."'";
        
        $sql 	= "select count(*) from pidsus.pds_b7_umum where ".$whereDef;
		if($isNew){
			$count 	= $connection->createCommand($sql)->queryScalar();
		} else{
			$id1 	= $_SESSION["pidsus_no_b7_umum"];
			$count 	= ($id1 == $no_b7_umum)?0:$connection->createCommand($sql)->queryScalar();
		}
        
        if($count > 0){
            $pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>B-7 Umum dengan nomor '.$no_b7_umum.' sudah ada</i></p>';
            return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_b7_umum");
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

		$no_p8_umum			= htmlspecialchars($post['no_p8_umum'], ENT_QUOTES);
		$no_b7_umum 		= htmlspecialchars($post['no_b7_umum'], ENT_QUOTES);
		$sifat   			= htmlspecialchars($post['sifat'], ENT_QUOTES);
		$lampiran   		= htmlspecialchars($post['lampiran'], ENT_QUOTES);
		$no_b4_umum 		= htmlspecialchars($post['no_b4_umum'], ENT_QUOTES);
		$dikeluarkan		= htmlspecialchars($post['dikeluarkan'], ENT_QUOTES);
		$tgl_dikeluarkan 	= htmlspecialchars($post['tgl_dikeluarkan'], ENT_QUOTES);
		$kepada   			= htmlspecialchars($post['kepada'], ENT_QUOTES);
		$di_tempat   		= htmlspecialchars($post['di_tempat'], ENT_QUOTES);
		$perkara   			= htmlspecialchars($post['perkara'], ENT_QUOTES);
		$hal_dilakukan   	= htmlspecialchars($post['hal_dilakukan'], ENT_QUOTES);

		$penandatangan_nama     = htmlspecialchars($post['penandatangan_nama'], ENT_QUOTES);
		$penandatangan_nip      = htmlspecialchars($post['penandatangan_nip'], ENT_QUOTES);
		$penandatangan_jabatan  = htmlspecialchars($post['penandatangan_jabatan'], ENT_QUOTES);
		$penandatangan_gol      = htmlspecialchars($post['penandatangan_gol'], ENT_QUOTES);
		$penandatangan_pangkat  = htmlspecialchars($post['penandatangan_pangkat'], ENT_QUOTES);
		$penandatangan_status_ttd   = htmlspecialchars($post['penandatangan_status'], ENT_QUOTES);
		$penandatangan_jabatan_ttd  = htmlspecialchars($post['penandatangan_ttdjabat'], ENT_QUOTES);

		$created_user		= $_SESSION['username'];
		$created_nip		= $_SESSION['nik_user'];
		$created_nama		= $_SESSION['nama_pegawai'];
		$created_ip			= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai'];
		$updated_ip			= $_SERVER['REMOTE_ADDR'];

		$filePhoto1 = htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto1 = htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto1 = htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto1  = substr($filePhoto1,strrpos($filePhoto1,'.'));

		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['b7_umum'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_umum);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_b7_umum);
		$newPhoto1 	= "b7_umum_".$clean1."-".$clean2.$extPhoto1;
		$whereDef 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p8_umum = '".$no_p8_umum."'";

		$transaction = $connection->beginTransaction();
		try{
			if($isNew){
				if($filePhoto1 != ""){
					$upl1 = true;
					$newPhoto1 = $newPhoto1;
				} else{
					$upl1 = false;
					$newPhoto1 = "";
				}
				$sql1 = "insert into pidsus.pds_b7_umum(id_kejati, id_kejari, id_cabjari, no_p8_umum, no_b7_umum, sifat, lampiran, no_b4_umum, dikeluarkan, tgl_dikeluarkan, 
						 kepada, di_tempat, perkara, hal_dilakukan, penandatangan_nama, penandatangan_nip, penandatangan_jabatan_pejabat, penandatangan_gol, penandatangan_pangkat, 
						 penandatangan_status_ttd, penandatangan_jabatan_ttd, file_upload, created_user, created_nip, created_nama, created_ip, created_date, updated_user, 
						 updated_nip, updated_nama, updated_ip, updated_date) values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".$no_b7_umum."', 
						 '".$sifat."', '".$lampiran."', '".$no_b4_umum."', '".$dikeluarkan."', '".$helpernya->tgl_db($tgl_dikeluarkan)."', '".$kepada."', 
						 '".$di_tempat."', '".$perkara."', '".$hal_dilakukan."', '".$penandatangan_nama."', '".$penandatangan_nip."', 
						 '".$penandatangan_jabatan."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', '".$penandatangan_status_ttd."', 
						 '".$penandatangan_jabatan_ttd."', '".$newPhoto1."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			} else{
				if($filePhoto1 != ""){
					$upl1 = true;
					$filenya1 = ", file_upload = '".$newPhoto1."'";
				} else{
					$upl1 = false;
					$filenya1 = "";
				}

				$sql1 = "update pidsus.pds_b7_umum set no_b7_umum = '".$no_b7_umum."', sifat = '".$sifat."', lampiran = '".$lampiran."', no_b4_umum = '".$no_b4_umum."', 
						 dikeluarkan = '".$dikeluarkan."', tgl_dikeluarkan = '".$helpernya->tgl_db($tgl_dikeluarkan)."', kepada = '".$kepada."', di_tempat = '".$di_tempat."', 
						 perkara = '".$perkara."', hal_dilakukan = '".$hal_dilakukan."', 
						 penandatangan_nama = '".$penandatangan_nama."', penandatangan_nip = '".$penandatangan_nip."', 
						 penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_b7_umum = '".$_SESSION['pidsus_no_b7_umum']."'";
			}
			$connection->createCommand($sql1)->execute();
                        
			$sql2 = "delete from pidsus.pds_b7_umum_tembusan where ".$whereDef." and no_b7_umum = '".$no_b7_umum."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql3 = "insert into pidsus.pds_b7_umum_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', 
								 '".$no_b7_umum."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql3)->execute();
					}
				}
			}
                        
			if($upl1){
				$tmpPot = glob($pathfile."b7_umum_".$clean1."-".$clean2.".*");
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

    public function hapusData($post){
		$connection 	= $this->db;
		$pathfile		= Yii::$app->params['b7_umum'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload from pidsus.pds_b7_umum where ".$whereDefault." and no_b7_umum = '".rawurldecode($tmp[0])."'";
					$file = $connection->createCommand($kue)->queryOne();
					if($file['file_upload'] && file_exists($pathfile.$file['file_upload'])) unlink($pathfile.$file['file_upload']);

					$sql1 = "delete from pidsus.pds_b7_umum where ".$whereDefault." and no_b7_umum = '".rawurldecode($tmp[0])."'";
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
