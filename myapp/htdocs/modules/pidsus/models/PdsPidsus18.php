<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsPidsus18 extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_pidsus18';
    }
    
    public function searchUndang($params){
		$q1  = htmlspecialchars($params['undang_q1'], ENT_QUOTES);
		$sql = "select a.* from pidsus.ms_u_undang a where 1=1";
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
		$id  = htmlspecialchars($params['jnsins_id'], ENT_QUOTES);
		$sql = "select a.* from pidsus.ms_pasal a where a.id = '".$id."'";
		if($q1)
			$sql .= " and (upper(a.pasal) like '%".strtoupper($q1)."%' or upper(a.bunyi) like '%".strtoupper($q1)."%') ";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.id,a.id_pasal";
		$dataProvider = new SqlDataProvider([
			'sql' => $sql,
			'totalCount' => $count,
		]);
		return $dataProvider;
    }
    
    public function getTersangka($post){
		$index = htmlspecialchars($post['arr_id'], ENT_QUOTES);
		$model = array();
		if(count($post) > 0){
			foreach($post as $idx1=>$val1){
				$model[$idx1] = $val1[$index];
			}
		} 
		return $model;
	}
        
        public function setTersangka($post){
		$arrPas = array("arr_id", "evt_tersangka_sukses", "tr_id_tersangka", "nurec_tersangka");
		$newId	= htmlspecialchars($post['arr_id'], ENT_QUOTES);
		$trIdp	= htmlspecialchars($post['tr_id_tersangka'], ENT_QUOTES);
		$isNew	= htmlspecialchars($post['nurec_tersangka'], ENT_QUOTES);

		$nama_tsk   = htmlspecialchars($post['modal_nama'], ENT_QUOTES);
		$tmp_lahir  = htmlspecialchars($post['modal_tmpt_lahir'], ENT_QUOTES);
		$tgl_lahir  = htmlspecialchars($post['modal_tgl_lahir'], ENT_QUOTES);
		
		$kolom0 = '';
		if(count($post) > 0){
			foreach($post as $idx1=>$val1){
				if(!in_array($idx1, $arrPas)){
					$nama = str_replace("modal_","",$idx1);
					if(is_array($val1)){
						foreach($val1 as $idx2=>$val2){
							$extCls = ($nama == "waktu_kejadian")?' waktu_kejadian'.$idx2:'';
							$kolom0 .= '<input type="hidden" name="'.$nama.'['.$newId.']['.$idx2.']" class="tersangka'.$extCls.'" value="'.$val2.'" />';
						}
					} else{
						$extCls = ($nama == "tmp_kejadian")?' tmp_kejadian':'';
						$kolom0 .= '<input type="hidden" name="'.$nama.'['.$newId.']" class="tersangka'.$extCls.'" value="'.$val1.'" />';
					}
				}	
			}
		}

		$kolomnya = '
		<td class="text-center">
			'.$kolom0.'<input type="checkbox" name="cekTsk['.$newId.']" id="cekTsk'.$newId.'" class="hRowCekTsk" value="'.$newId.'" />
		</td>
		<td class="text-center"><span class="frmnotsk" data-row-count="'.$newId.'"></span></td>
		<td class="text-left"><a style="cursor:pointer" class="ubahTersangka">'.$nama_tsk.'</a></td>'.
                '<td class="text-left">'.$tmp_lahir.'/ '.$tgl_lahir.'</td>';
		$hasilnya = ($isNew)?'<tr data-id="'.$newId.'" class="barisTsk">'.$kolomnya.'</tr>':$kolomnya;
		return $hasilnya;
	}
        
	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
                $no_p8_umum	= $_SESSION['pidsus_no_p8_umum'];
                
		$sql = "
		with tbl_tsk as(
			select id_kejati, id_kejari, id_cabjari, no_pidsus18, string_agg(nama||'--'||tgl_lahir, '#' order by no_urut_tersangka) as tsk 
			from pidsus.pds_pidsus18_tersangka group by id_kejati, id_kejari, id_cabjari, no_pidsus18
		)
		select a.*, b.tsk 
		from pidsus.pds_pidsus18 a 
		left join tbl_tsk b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_pidsus18 = b.no_pidsus18
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."'";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_pidsus18 desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
    
    public function searchp8($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$q1  = htmlspecialchars($params['mp8_q1'], ENT_QUOTES);
		$sql = "select a.*,b.tgl_p8_umum,b.laporan_pidana from pidsus.pds_pidsus7_umum a 
			left join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
					and a.no_p8_umum = b.no_p8_umum
			where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.pimpinan_dilanjutkan = '1'";
		if($q1)
			$sql .= " and (to_char(a.tgl_p8_umum, 'DD-MM-YYYY') = '".$q1."' or upper(a.no_p8_umum) like '%".strtoupper($q1)."%' or upper(a.nama_jaksa) like '%".strtoupper($q1)."%' or upper(a.pangkat_jaksa) like '%".strtoupper($q1)."%' or upper(b.laporan_pidana) like '%".strtoupper($q1)."%' or upper(a.dilakukan_oleh) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by b.tgl_p8_umum desc";
		$dataProvider = new SqlDataProvider([
			'sql' => $sql,
			'totalCount' => $count,
		]);
		return $dataProvider;
    }
	
    public function cekPidsus18($post){
        $connection = $this->db;
        $helpernya	= Yii::$app->inspektur;
        $id_kejati 	= $_SESSION['kode_kejati'];
        $id_kejari 	= $_SESSION['kode_kejari'];
        $id_cabjari     = $_SESSION['kode_cabjari'];
        $no_pidsus18	= htmlspecialchars($post['no_pidsus18'], ENT_QUOTES);
        $isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $whereDef  	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_pidsus18 = '".$no_pidsus18."'";

        $sqlCek = "select count(*) from pidsus.pds_pidsus18 where ".$whereDef;
		if($isNew){
			$count 	= $connection->createCommand($sqlCek)->queryScalar();
		} else{
			$id1 	= $_SESSION["pidsus_no_pidsus18"];
			$count 	= ($id1 == $no_pidsus18)?0:$connection->createCommand($sqlCek)->queryScalar();
		}
        
        if($count > 0){
            $pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>Pidsus-18 dengan nomor '.$no_pidsus18.' sudah ada</i></p>';
            return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_pidsus18");
        } else{
            return array("hasil"=>true, "error"=>"", "element"=>"");
        }
    }

	public function simpanData($post){
		$helpernya	= Yii::$app->inspektur;
		$connection     = $this->db;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_p8_umum		= htmlspecialchars($post['no_p8_umum'], ENT_QUOTES);
		$no_pidsus18 		= htmlspecialchars($post['no_pidsus18'], ENT_QUOTES);
		$tgl_dikeluarkan	= htmlspecialchars($post['tgl_dikeluarkan'], ENT_QUOTES);
		$tempat_dikeluarkan	= htmlspecialchars($post['tempat_dikeluarkan'], ENT_QUOTES);

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
		$created_ip		= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai'];
		$updated_ip		= $_SERVER['REMOTE_ADDR'];

		$filePhoto1 = htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto1 = htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto1 = htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto1 	= substr($filePhoto1,strrpos($filePhoto1,'.'));

		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['pidsus_18'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_umum);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_pidsus18);
		$newPhoto1 	= "pidsus_18_".$clean1."-".$clean2.$extPhoto1;
		$whereDef 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' ";

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
				$sql1 = "insert into pidsus.pds_pidsus18(id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus18, tempat_dikeluarkan, tgl_pidsus18, penandatangan_nama, 
						 penandatangan_nip, penandatangan_jabatan_pejabat, penandatangan_gol, penandatangan_pangkat, penandatangan_status_ttd, penandatangan_jabatan_ttd, 
						 file_upload, created_user, created_nip, created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date)  
						 values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".$no_pidsus18."', '".$tempat_dikeluarkan."', 
						 '".$helpernya->tgl_db($tgl_dikeluarkan)."', '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', 
						 '".$penandatangan_gol."', '".$penandatangan_pangkat."', '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$newPhoto1."', 
						 '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			} else{
				if($filePhoto1 != ""){
					$upl1 = true;
					$filenya1 = ", file_upload = '".$newPhoto1."'";
				} else{
					$upl1 = false;
					$filenya1 = "";
				}

				$sql1 = "update pidsus.pds_pidsus18 set no_pidsus18 = '".$no_pidsus18."', tgl_pidsus18 = '".$helpernya->tgl_db($tgl_dikeluarkan)."', 
						 tempat_dikeluarkan = '".$tempat_dikeluarkan."', penandatangan_nama = '".$penandatangan_nama."', 
						 penandatangan_nip = '".$penandatangan_nip."', penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_p8_umum = '".$no_p8_umum."' and no_pidsus18 = '".$_SESSION['pidsus_no_pidsus18']."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql4 = "delete from pidsus.pds_pidsus18_tersangka where ".$whereDef." and no_pidsus18 = '".$no_pidsus18."'";
			$connection->createCommand($sql4)->execute();
			if(count($post['nama']) > 0){
				$no_urut_penggeledahan = 0;
				foreach($post['nama'] as $idx1=>$val1){
					$no_urut_tersangka++;
					$nama                   = htmlspecialchars($post['nama'][$idx1], ENT_QUOTES);
					$tmpt_lahir		= htmlspecialchars($post['tmpt_lahir'][$idx1], ENT_QUOTES);
					$tgl_lahir		= htmlspecialchars($post['tgl_lahir'][$idx1], ENT_QUOTES);
					$umur                   = htmlspecialchars($post['umur'][$idx1], ENT_QUOTES);
					$warganegara            = ($post['warganegara'][$idx1]!='')?htmlspecialchars($post['warganegara'][$idx1], ENT_QUOTES):'0';
					$suku                   = htmlspecialchars($post['suku'][$idx1], ENT_QUOTES);
					$id_identitas           = ($post['id_identitas'][$idx1]!='')?htmlspecialchars($post['id_identitas'][$idx1], ENT_QUOTES):'0';
					$no_identitas		= htmlspecialchars($post['no_identitas'][$idx1], ENT_QUOTES);
					$id_agama		= ($post['id_agama'][$idx1]!='')?htmlspecialchars($post['id_agama'][$idx1], ENT_QUOTES):'0';
					$id_jkl                 = ($post['id_jkl'][$idx1])?htmlspecialchars($post['id_jkl'][$idx1], ENT_QUOTES):'0';
					$alamat                 = htmlspecialchars($post['alamat'][$idx1], ENT_QUOTES);
					$no_hp                  = htmlspecialchars($post['no_hp'][$idx1], ENT_QUOTES);
					$id_pendidikan          = ($post['id_pendidikan'][$idx1]!='')?htmlspecialchars($post['id_pendidikan'][$idx1], ENT_QUOTES):'-1';
					$pekerjaan              = htmlspecialchars($post['pekerjaan'][$idx1], ENT_QUOTES);
					
					$sql5 = "insert into pidsus.pds_pidsus18_tersangka(id_kejati, id_kejari, id_cabjari, no_pidsus18, no_urut_tersangka, nama, 
							 tmpt_lahir, tgl_lahir, umur, warganegara, suku, id_identitas, no_identitas, id_jkl, id_agama, 
							 alamat, no_hp, id_pendidikan, pekerjaan) values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_pidsus18."', '".$no_urut_tersangka."', '".$nama."', 
							 '".$tmpt_lahir."', '".$helpernya->tgl_db($tgl_lahir)."', '".$umur."', '".$warganegara."', '".$suku."', '".$id_identitas."', 
							 '".$no_identitas."', '".$id_jkl."', '".$id_agama."', '".$alamat."', '".$no_hp."', '".$id_pendidikan."', '".$pekerjaan."')";
					$connection->createCommand($sql5)->execute();
				}
			}

			$sql6 = "delete from pidsus.pds_pidsus18_uu_pasal where ".$whereDef." and no_pidsus18 = '".$no_pidsus18."'";
                        $connection->createCommand($sql6)->execute();
                        if(count($post['undang_uu']) > 0){
                                $nom1 = 0;
                                foreach($post['undang_uu'] as $idx2=>$val2){
                                    if($post['undang_uu'][$idx2]!=''){
                                        $nom1++;
                                        $undang_uu	= htmlspecialchars($post['undang_uu'][$idx2], ENT_QUOTES);
                                        $pasal		= htmlspecialchars($post['pasal'][$idx2], ENT_QUOTES);
                                        $dakwaan	= ($post['dakwaan'][$idx2])?htmlspecialchars($post['dakwaan'][$idx2], ENT_QUOTES):'0';
                                        $sql7 = "
                                                insert into pidsus.pds_pidsus18_uu_pasal(id_kejati, id_kejari, id_cabjari, no_pidsus18, id_uu_pasal, undang, 
                                                pasal, dakwaan) values ('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_pidsus18."', '".$nom1."', '".$undang_uu."', '".$pasal."', '".$dakwaan."')";
                                        $connection->createCommand($sql7)->execute();
                                    }
                                }
                        }

			$sql8 = "delete from pidsus.pds_pidsus18_tembusan where ".$whereDef." and no_pidsus18 = '".$no_pidsus18."'";
			$connection->createCommand($sql8)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql9 = "insert into pidsus.pds_pidsus18_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_pidsus18."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql9)->execute();
					}
				}
			}
                        
			if($upl1){
				$tmpPot = glob($pathfile."pidsus_18_".$clean1."-".$clean2.".*");
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
		$pathfile	= Yii::$app->params['pidsus_18'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload from pidsus.pds_pidsus18 where ".$whereDefault." and no_pidsus18 = '".rawurldecode($tmp[0])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from pidsus.pds_pidsus18 where ".$whereDefault." and no_pidsus18 = '".rawurldecode($tmp[0])."'";
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
