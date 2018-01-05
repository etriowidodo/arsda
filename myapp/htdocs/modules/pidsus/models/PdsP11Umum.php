<?php 
namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsP11Umum extends \yii\db\ActiveRecord{
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
		with tbl_saksi as(
			select id_kejati, id_kejari, id_cabjari, no_p8_umum, no_p11_umum, string_agg(nama, '#' order by no_urut_saksi) as saksinya 
			from pidsus.pds_p11_umum_saksi group by id_kejati, id_kejari, id_cabjari, no_p8_umum, no_p11_umum 
		)
		select a.no_p11_umum, a.tgl_p11_umum, a.kepada_nama, a.perihal, b.saksinya 
		from pidsus.pds_p11_umum a 
		left join tbl_saksi b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_p8_umum = b.no_p8_umum and a.no_p11_umum = b.no_p11_umum 
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_p8_umum = '".$no_p8_umum."'";

		if($q1)
			$sql .= " and (upper(a.no_p11_umum) like '%".strtoupper($q1)."%' or to_char(a.tgl_p11_umum, 'DD-MM-YYYY') = '".$q1."' 
				or upper(a.kepada_nama) like '%".strtoupper($q1)."%' or upper(b.saksinya) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_p11_umum desc, a.created_date desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
	public function getSaksi($post){
		$index = htmlspecialchars($post['arr_id'], ENT_QUOTES);
		$model = array();
		if(count($post) > 0){
			foreach($post as $idx1=>$val1){
				$model[$idx1] = $val1[$index];
			}
		} 
		return $model;
	}

	public function setSaksi($post){
		$arrPas = array("arr_id", "evt_penggeledahan_sukses", "tr_id_penggeledahan", "nurec_penggeledahan");
		$newId	= htmlspecialchars($post['arr_id'], ENT_QUOTES);
		$trIdp	= htmlspecialchars($post['tr_id_penggeledahan'], ENT_QUOTES);
		$isNew	= htmlspecialchars($post['nurec_penggeledahan'], ENT_QUOTES);

		$nama_saksi			= htmlspecialchars($post['modal_nama_saksi'], ENT_QUOTES);
		$alamat_saksi		= htmlspecialchars($post['modal_alamat_saksi'], ENT_QUOTES);
		$keterangan_saksi	= htmlspecialchars($post['modal_keterangan_saksi'], ENT_QUOTES);
		$status_saksi		= htmlspecialchars($post['modal_status_saksi'], ENT_QUOTES);
		$kolomSaksi 		= '<a style="cursor:pointer" class="ubahListSaksi">'.$nama_saksi.'</a>';

		$kolom0 = '';
		if(count($post) > 0){
			foreach($post as $idx1=>$val1){
				if(!in_array($idx1, $arrPas)){
					$nama = str_replace("modal_","",$idx1);
					if(is_array($val1)){
						foreach($val1 as $idx2=>$val2){
							$extCls = ($nama == "waktu_kejadian")?' waktu_kejadian'.$idx2:'';
							$kolom0 .= '<input type="hidden" name="'.$nama.'['.$newId.']['.$idx2.']" class="list-saksi'.$extCls.'" value="'.$val2.'" />';
						}
					} else{
						$extCls = ($nama == "tmp_kejadian")?' tmp_kejadian':'';
						$kolom0 .= '<input type="hidden" name="'.$nama.'['.$newId.']" class="list-saksi'.$extCls.'" value="'.$val1.'" />';
					}
				}	
			}
		}

		$kolomnya = '
		<td class="text-center">'.$kolom0.'<input type="checkbox" name="chk_del_saksi['.$newId.']" id="chk_del_saksi'.$newId.'" class="hRowSaksi" value="'.$newId.'" /></td>
		<td class="text-center"><span class="frmnosaksi" data-row-count="'.$newId.'"></span></td>
		<td class="text-left">'.$kolomSaksi.'</td>
		<td class="text-left">'.$alamat_saksi.'</td>
		<td class="text-left">'.$keterangan_saksi.'</td>';
		$hasilnya = ($isNew)?'<tr data-id="'.$newId.'" class="barisListSaksi">'.$kolomnya.'</tr>':$kolomnya;
		return $hasilnya;
	}


	public function getListSaksi($params){
        $q0  = htmlspecialchars($params['perihal'], ENT_QUOTES);
		$q1  = htmlspecialchars($params['mpds14u_q1'], ENT_QUOTES);
        $def = "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
					and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
		$sql = "select a.*, b.tgl_pidsus14_umum from pidsus.pds_pidsus14_umum_saksi a 
				join pidsus.pds_pidsus14_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
					and a.no_p8_umum = b.no_p8_umum and a.no_urut_pidsus14_umum = b.no_urut_pidsus14_umum 
				where ".$def;
        if($q0)
			$sql .= " and a.status_keperluan = '".$q0."'";

		if($q1){
			$sql .= " and (to_char(a.waktu_pelaksanaan, 'DD-MM-YYYY') = '".$q1."' or upper(a.nama) like '%".strtoupper($q1)."%' or upper(a.jabatan) like '%".strtoupper($q1)."%' 
						or upper(a.nip_jaksa) like '%".strtoupper($q1)."%' or upper(a.nama_jaksa) like '%".strtoupper($q1)."%' or upper(a.gol_jaksa) like '%".strtoupper($q1)."%' 
						or upper(a.pangkat_jaksa) like '%".strtoupper($q1)."%' or upper(a.jabatan_jaksa) like '%".strtoupper($q1)."%' 
						or upper(a.keperluan) like '%".strtoupper($q1)."%')";
		}
        $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
        $count = $kueri->queryScalar();
        $sql .= " order by a.waktu_pelaksanaan asc";
        $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
    public function cekPdsP11Umum($post){
        $connection  = $this->db;
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $helpernya	= Yii::$app->inspektur;
        $isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $no_p11_umum = htmlspecialchars($post['no_p11_umum'], ENT_QUOTES);
        $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p11_umum = '".$no_p11_umum."'";
        
        $sql 	= "select count(*) from pidsus.pds_p11_umum where ".$whereDef;
		if($isNew){
			$count 	= $connection->createCommand($sql)->queryScalar();
		} else{
			$id1 	= $_SESSION["pidsus_no_p11_umum"];
			$count 	= ($id1 == $no_p11_umum)?0:$connection->createCommand($sql)->queryScalar();
		}
        
        if($count > 0){
            $pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>P-11 Umum dengan nomor '.$no_p11_umum.' sudah ada</i></p>';
            return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_p11_umum");
        } else{
            return array("hasil"=>true, "error"=>"", "element"=>"");
        }
	}

	public function simpanData($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_p8_umum		= htmlspecialchars($post['no_p8_umum'], ENT_QUOTES);
		$no_p11_umum	= htmlspecialchars($post['no_p11_umum'], ENT_QUOTES);
		$tgl_p11_umum	= htmlspecialchars($post['tgl_p11_umum'], ENT_QUOTES);

		$sifat 			= htmlspecialchars($post['sifat'], ENT_QUOTES);
		$perihal		= htmlspecialchars($post['perihal'], ENT_QUOTES);
		$lampiran		= htmlspecialchars($post['lampiran'], ENT_QUOTES);
		$kepada_nama 	= htmlspecialchars($post['kepada_nama'], ENT_QUOTES);
		$di_tempat 		= htmlspecialchars($post['di_tempat'], ENT_QUOTES);

		$penandatangan_nama			= htmlspecialchars($post['penandatangan_nama'], ENT_QUOTES);
		$penandatangan_nip			= htmlspecialchars($post['penandatangan_nip'], ENT_QUOTES);
		$penandatangan_jabatan		= htmlspecialchars($post['penandatangan_jabatan'], ENT_QUOTES);
		$penandatangan_gol			= htmlspecialchars($post['penandatangan_gol'], ENT_QUOTES);
		$penandatangan_pangkat		= htmlspecialchars($post['penandatangan_pangkat'], ENT_QUOTES);
		$penandatangan_status_ttd	= htmlspecialchars($post['penandatangan_status'], ENT_QUOTES);
		$penandatangan_jabatan_ttd	= htmlspecialchars($post['penandatangan_ttdjabat'], ENT_QUOTES);
		
		$created_user		= $_SESSION['username'];
		$created_nip		= $_SESSION['nik_user'];
		$created_nama		= $_SESSION['nama_pegawai'];
		$created_ip			= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai'];
		$updated_ip			= $_SERVER['REMOTE_ADDR'];

		$helpernya	= Yii::$app->inspektur;
		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['p11_umum'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_umum);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_p11_umum);
		$newPhoto 	= "p11umum_".$clean1."-".$clean2.$extPhoto;
		$whereDef 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p8_umum = '".$no_p8_umum."'";

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
				$sql1 = "insert into pidsus.pds_p11_umum(id_kejati, id_kejari, id_cabjari, no_p8_umum, no_p11_umum, tgl_p11_umum, sifat, perihal, lampiran, kepada_nama, di_tempat, 
						 penandatangan_nama, penandatangan_nip, penandatangan_jabatan_pejabat, penandatangan_gol, penandatangan_pangkat, penandatangan_status_ttd, 
						 penandatangan_jabatan_ttd, file_upload, created_user, created_nip, created_nama, created_ip, created_date, updated_user, 
						 updated_nip, updated_nama, updated_ip, updated_date) values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".$no_p11_umum."', 
						 '".$helpernya->tgl_db($tgl_p11_umum)."', '".$sifat."', '".$perihal."', '".$lampiran."', '".$kepada_nama."', '".$di_tempat."', 
						 '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', 
						 '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$newPhoto."', '".$created_user."', '".$created_nip."', '".$created_nama."', 
						 '".$created_ip."', NOW(), '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_p11_umum set no_p11_umum = '".$no_p11_umum."', tgl_p11_umum = '".$helpernya->tgl_db($tgl_p11_umum)."', 
						 sifat = '".$sifat."', lampiran = '".$lampiran."', kepada_nama = '".$kepada_nama."', di_tempat = '".$di_tempat."', 
						 perihal = '".$perihal."', penandatangan_nama = '".$penandatangan_nama."', penandatangan_nip = '".$penandatangan_nip."', 
						 penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_p11_umum = '".$_SESSION['pidsus_no_p11_umum']."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql4 = "delete from pidsus.pds_p11_umum_saksi where ".$whereDef." and no_p11_umum = '".$no_p11_umum."'";
			$connection->createCommand($sql4)->execute();
			if(count($post['nama_saksi']) > 0){
				$noauto = 0;
				foreach($post['nama_saksi'] as $idx=>$val){
					$nama 		= htmlspecialchars($post['nama_saksi'][$idx], ENT_QUOTES);
					$alamat 	= htmlspecialchars($post['alamat_saksi'][$idx], ENT_QUOTES);
					$keterangan = htmlspecialchars($post['keterangan_saksi'][$idx], ENT_QUOTES);
					$status 	= htmlspecialchars($post['status_saksi'][$idx], ENT_QUOTES);
					if($nama){ 
						$noauto++; 
						$sql5 = "insert into pidsus.pds_p11_umum_saksi values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', 
								 '".$no_p11_umum."', '".$noauto."', '".$nama."', '".$alamat."', '".$keterangan."', '".$status."')";
						$connection->createCommand($sql5)->execute();
					}
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."p11umum_".$clean1."-".$clean2.".*");
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
		$pathfile		= Yii::$app->params['p11_umum'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";

		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload from pidsus.pds_p11_umum where ".$whereDefault." and no_p11_umum = '".rawurldecode($tmp[0])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from pidsus.pds_p11_umum where ".$whereDefault." and no_p11_umum = '".rawurldecode($tmp[0])."'";
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
