<?php 
namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsB2Umum extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_b2_umum';
    }
    
    public function searchPer($params){
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $no_p8_umum	= $_SESSION['pidsus_no_p8_umum'];

        $q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
        $sql = "
        select a.* 
        from pidsus.pds_b2_umum a 
        where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_p8_umum = '".$no_p8_umum."'";
        if($q1)
                $sql .= " and (upper(a.no_b2_umum) like '%".strtoupper($q1)."%' or to_char(a.tgl_dikeluarkan, 'DD-MM-YYYY') = '".$q1."') ";

        $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
        $count = $kueri->queryScalar();
        $sql .= " order by a.tgl_dikeluarkan desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
    
    public function getPenggeledahan($post){
		$index = htmlspecialchars($post['arr_id'], ENT_QUOTES);
		$model = array();
		if(count($post) > 0){
			foreach($post as $idx1=>$val1){
				$model[$idx1] = $val1[$index];
			}
		} 
		return $model;
	}
        
        public function listPenggeledahan($params){
            $id_kejati	= $_SESSION['kode_kejati'];
            $id_kejari	= $_SESSION['kode_kejari'];
            $id_cabjari	= $_SESSION['kode_cabjari'];
            $no_p8_umum	= $_SESSION['pidsus_no_p8_umum'];
            $q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
            $no_b4  = htmlspecialchars($params['id1'], ENT_QUOTES);
            $sql = "
            select a.*
            from pidsus.pds_b4_umum_pengeledahan a
            where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_p8_umum = '".$no_p8_umum."'";
            if($q1)
                    $sql .= " and (upper(a.keperluan) like '%".strtoupper($q1)."%' or upper(a.keterangan) like '%".strtoupper($q1)."%' "
                    . "or upper(a.nama) like '%".strtoupper($q1)."%' or upper(a.jabatan) like '%".strtoupper($q1)."%' or upper(a.tempat_penggeledahan) like '%".strtoupper($q1)."%' or upper(a.alamat_penggeledahan) like '%".strtoupper($q1)."%')";
            $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
            $count = $kueri->queryScalar();
            $sql .= " order by a.no_urut_penggeledahan";
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                            'totalCount' => $count,
            ]);
            return $dataProvider;
        }
        
        public function listPenyitaan($params){
            $id_kejati	= $_SESSION['kode_kejati'];
            $id_kejari	= $_SESSION['kode_kejari'];
            $id_cabjari	= $_SESSION['kode_cabjari'];
            $no_p8_umum	= $_SESSION['pidsus_no_p8_umum'];
            $q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
            $no_b4  = htmlspecialchars($params['id1'], ENT_QUOTES);
            $sql = "
            select a.*
            from pidsus.pds_b4_umum_penyitaan a
            where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_p8_umum = '".$no_p8_umum."'";
            if($q1)
                    $sql .= " and ( upper(a.jenis_barang_disita) like '%".strtoupper($q1)."%' or upper(a.jumlah_barang_disita) like '%".strtoupper($q1)."%' or upper(a.nama_barang_disita) like '%".strtoupper($q1)."%')";
            $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
            $count = $kueri->queryScalar();
            $sql .= " order by a.no_urut_penyitaan";
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                            'totalCount' => $count,
            ]);
            return $dataProvider;
        }

	public function setPenggeledahan($post){
		$arrPas = array("arr_id", "evt_penggeledahan_sukses", "tr_id_penggeledahan", "nurec_penggeledahan");
		$newId	= htmlspecialchars($post['arr_id'], ENT_QUOTES);
		$trIdp	= htmlspecialchars($post['tr_id_penggeledahan'], ENT_QUOTES);
		$isNew	= htmlspecialchars($post['nurec_penggeledahan'], ENT_QUOTES);

		$penggeledahan_terhadap	= htmlspecialchars($post['modal_penggeledahan_terhadap'], ENT_QUOTES);
		$gldh_nama				= htmlspecialchars($post['modal_gldh_nama'], ENT_QUOTES);
		$gldh_jabatan			= htmlspecialchars($post['modal_gldh_jabatan'], ENT_QUOTES);
		$tempat_penggeledahan	= htmlspecialchars($post['modal_tempat_penggeledahan'], ENT_QUOTES);
		$alamat_penggeledahan	= htmlspecialchars($post['modal_alamat_penggeledahan'], ENT_QUOTES);
		$gldh_keperluan			= htmlspecialchars($post['modal_gldh_keperluan'], ENT_QUOTES);
		$gldh_keterangan		= htmlspecialchars($post['modal_gldh_keterangan'], ENT_QUOTES);
		
		if($penggeledahan_terhadap == 'Subyek'){
			$ygDigeledah = '<a style="cursor:pointer" class="ubahPenggeledahan">'.$gldh_nama.'</a><br />'.$gldh_jabatan;
		} else if($penggeledahan_terhadap == 'Obyek'){
			$ygDigeledah = '<a style="cursor:pointer" class="ubahPenggeledahan">'.$tempat_penggeledahan.'</a><br />'.$alamat_penggeledahan;
		}

		$kolom0 = '';
		if(count($post) > 0){
			foreach($post as $idx1=>$val1){
				if(!in_array($idx1, $arrPas)){
					$nama = str_replace("modal_","",$idx1);
					if(is_array($val1)){
						foreach($val1 as $idx2=>$val2){
							$extCls = ($nama == "waktu_kejadian")?' waktu_kejadian'.$idx2:'';
							$kolom0 .= '<input type="hidden" name="'.$nama.'['.$newId.']['.$idx2.']" class="geledahan'.$extCls.'" value="'.$val2.'" />';
						}
					} else{
						$extCls = ($nama == "tmp_kejadian")?' tmp_kejadian':'';
						$kolom0 .= '<input type="hidden" name="'.$nama.'['.$newId.']" class="geledahan'.$extCls.'" value="'.$val1.'" />';
					}
				}	
			}
		}

		$kolomnya = '
		<td class="text-center">
			'.$kolom0.'<input type="checkbox" name="cekGldh['.$newId.']" id="cekGldh'.$newId.'" class="hRowCekGldh" value="'.$newId.'" />
		</td>
		<td class="text-center"><span class="frmnogldh" data-row-count="'.$newId.'"></span></td>
		<td class="text-left">'.$ygDigeledah.'</td>';
		$hasilnya = ($isNew)?'<tr data-id="'.$newId.'" class="barisGeledahan">'.$kolomnya.'</tr>':$kolomnya;
		return $hasilnya;
	}

	public function getPenyitaan($post){
		$index = htmlspecialchars($post['arr_id'], ENT_QUOTES);
		$model = array();
		if(count($post) > 0){
			foreach($post as $idx1=>$val1){
				$model[$idx1] = $val1[$index];
			}
		} 
		return $model;
	}

	public function setPenyitaan($post){
		$arrPas = array("arr_id", "evt_penyitaan_sukses", "tr_id_penyitaan", "nurec_penyitaan");
		$newId	= htmlspecialchars($post['arr_id'], ENT_QUOTES);
		$trIdp	= htmlspecialchars($post['tr_id_penyitaan'], ENT_QUOTES);
		$isNew	= htmlspecialchars($post['nurec_penyitaan'], ENT_QUOTES);

		$nama_barang_disita		= htmlspecialchars($post['modal_nama_barang_disita'], ENT_QUOTES);
		$jenis_barang_disita	= htmlspecialchars($post['modal_jenis_barang_disita'], ENT_QUOTES);
		$jumlah_barang_disita	= htmlspecialchars($post['modal_jumlah_barang_disita'], ENT_QUOTES);
		$disita_dari			= htmlspecialchars($post['modal_disita_dari'], ENT_QUOTES);
		$tempat_penyitaan		= htmlspecialchars($post['modal_tempat_penyitaan'], ENT_QUOTES);
		$sita_keperluan			= htmlspecialchars($post['modal_sita_keperluan'], ENT_QUOTES);
		$sita_keterangan		= htmlspecialchars($post['modal_sita_keterangan'], ENT_QUOTES);
		
		if(count($post) > 0){
			foreach($post as $idx1=>$val1){
				if(!in_array($idx1, $arrPas)){
					$nama = str_replace("modal_","",$idx1);
					if(is_array($val1)){
						foreach($val1 as $idx2=>$val2){
							$extCls = ($nama == "waktu_kejadian")?' waktu_kejadian'.$idx2:'';
							$kolom0 .= '<input type="hidden" name="'.$nama.'['.$newId.']['.$idx2.']" class="sitaan'.$extCls.'" value="'.$val2.'" />';
						}
					} else{
						$extCls = ($nama == "tmp_kejadian")?' tmp_kejadian':'';
						$kolom0 .= '<input type="hidden" name="'.$nama.'['.$newId.']" class="sitaan'.$extCls.'" value="'.$val1.'" />';
					}
				}	
			}
		}

		$kolomnya = '
		<td class="text-center">
			'.$kolom0.'<input type="checkbox" name="cekSita['.$newId.']" id="cekSita'.$newId.'" class="hRowCekSita" value="'.$newId.'" />
		</td>
		<td class="text-center"><span class="frmnosita" data-row-count="'.$newId.'"></span></td>
		<td class="text-left"><a class="ubahPenyitaan" style="cursor:pointer">'.$nama_barang_disita.'</a></td>
		<td class="text-left">'.$jenis_barang_disita.'</td>
		<td class="text-left">'.$jumlah_barang_disita.'</td>';
		$hasilnya = ($isNew)?'<tr data-id="'.$newId.'" class="barisSitaan">'.$kolomnya.'</tr>':$kolomnya;
		return $hasilnya;
	}
    
    public function searchb4($params){
        $q1  = htmlspecialchars($params['mb4_q1'], ENT_QUOTES);
        $whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        $sql = "Select a.no_b4_umum, a.tgl_dikeluarkan from pidsus.pds_b4_umum a where ".$whereDefault;
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

    public function cekB2Umum($post){
        $connection = $this->db;
        $helpernya	= Yii::$app->inspektur;
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
        $no_b2_umum = htmlspecialchars($post['no_b2_umum'], ENT_QUOTES);
        $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_b2_umum = '".$no_b2_umum."'";
        
        $sql 	= "select count(*) from pidsus.pds_b2_umum where ".$whereDef;
		if($isNew){
			$count 	= $connection->createCommand($sql)->queryScalar();
		} else{
			$id1 	= $_SESSION["pidsus_no_b2_umum"];
			$count 	= ($id1 == $no_b2_umum)?0:$connection->createCommand($sql)->queryScalar();
		}
        
        if($count > 0){
            $pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>B-2 Umum dengan nomor '.$no_b2_umum.' sudah ada</i></p>';
            return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_b2_umum");
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

		$no_p8_umum		= htmlspecialchars($post['no_p8_umum'], ENT_QUOTES);
		$no_b2_umum 	= htmlspecialchars($post['no_b2_umum'], ENT_QUOTES);
		$sifat   		= htmlspecialchars($post['sifat'], ENT_QUOTES);
		$lampiran   	= htmlspecialchars($post['lampiran'], ENT_QUOTES);
		$kepada   		= htmlspecialchars($post['kepada'], ENT_QUOTES);
		$di_tempat   	= htmlspecialchars($post['di_tempat'], ENT_QUOTES);
		$no_b4_umum 	= htmlspecialchars($post['no_b4_umum'], ENT_QUOTES);
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
		$pathfile	= Yii::$app->params['b2_umum'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_umum);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_b2_umum);
		$newPhoto1 	= "b2_umum_".$clean1."-".$clean2.$extPhoto1;
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
				$sql1 = "insert into pidsus.pds_b2_umum(id_kejati, id_kejari, id_cabjari, no_p8_umum, no_b2_umum, sifat, lampiran, dikeluarkan, tgl_dikeluarkan, kepada, di_tempat, 
						 penandatangan_nama, penandatangan_nip, penandatangan_jabatan_pejabat, penandatangan_gol, penandatangan_pangkat, penandatangan_status_ttd, 
						 penandatangan_jabatan_ttd, file_upload, created_user, created_nip, created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, 
						 updated_ip, updated_date, no_b4_umum) values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".$no_b2_umum."', '".$sifat."', 
						 '".$lampiran."', '".$tempat_dikeluarkan."', '".$helpernya->tgl_db($tgl_dikeluarkan)."', '".$kepada."', '".$di_tempat."', '".$penandatangan_nama."', 
						 '".$penandatangan_nip."', '".$penandatangan_jabatan."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', '".$penandatangan_status_ttd."', 
						 '".$penandatangan_jabatan_ttd."', '".$newPhoto1."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW(), '".$no_b4_umum."')";
			} else{
				if($filePhoto1 != ""){
					$upl1 = true;
					$filenya1 = ", file_upload = '".$newPhoto1."'";
				} else{
					$upl1 = false;
					$filenya1 = "";
				}

				$sql1 = "update pidsus.pds_b2_umum set no_b2_umum = '".$no_b2_umum."', tgl_dikeluarkan = '".$helpernya->tgl_db($tgl_dikeluarkan)."', 
						 dikeluarkan = '".$tempat_dikeluarkan."', sifat = '".$sifat."', lampiran = '".$lampiran."', kepada = '".$kepada."', di_tempat = '".$di_tempat."', 
						 no_b4_umum = '".$no_b4_umum."', penandatangan_nama = '".$penandatangan_nama."', penandatangan_nip = '".$penandatangan_nip."', 
						 penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_b2_umum = '".$_SESSION['pidsus_no_b2_umum']."'";
			}
			$connection->createCommand($sql1)->execute();
                        
			$sql2 = "delete from pidsus.pds_b2_umum_tembusan where ".$whereDef." and no_b2_umum = '".$no_b2_umum."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql3 = "insert into pidsus.pds_b2_umum_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', 
								 '".$no_b2_umum."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql3)->execute();
					}
				}
			}
                        
			$sql4 = "delete from pidsus.pds_b2_umum_pengeledahan where ".$whereDef." and no_b2_umum = '".$no_b2_umum."'";
			$connection->createCommand($sql4)->execute();
                        if(count($post['penggeledahan_terhadap']) > 0){
				$no_urut_penggeledahan = 0;
				foreach($post['penggeledahan_terhadap'] as $idx1=>$val1){
					$no_urut_penggeledahan++;
					$penggeledahan_terhadap	= htmlspecialchars($post['penggeledahan_terhadap'][$idx1], ENT_QUOTES);
					$nama					= htmlspecialchars($post['gldh_nama'][$idx1], ENT_QUOTES);
					$jabatan				= htmlspecialchars($post['gldh_jabatan'][$idx1], ENT_QUOTES);
					$tempat_penggeledahan 	= htmlspecialchars($post['tempat_penggeledahan'][$idx1], ENT_QUOTES);
					$alamat_penggeledahan	= htmlspecialchars($post['alamat_penggeledahan'][$idx1], ENT_QUOTES);
					$nama_pemilik			= htmlspecialchars($post['gldh_nama_pemilik'][$idx1], ENT_QUOTES);
					$pekerjaan_pemilik 		= htmlspecialchars($post['gldh_pekerjaan_pemilik'][$idx1], ENT_QUOTES);
					$alamat_pemilik			= htmlspecialchars($post['gldh_alamat_pemilik'][$idx1], ENT_QUOTES);
					$keperluan				= htmlspecialchars($post['gldh_keperluan'][$idx1], ENT_QUOTES);
					$keterangan				= htmlspecialchars($post['gldh_keterangan'][$idx1], ENT_QUOTES);
					
					$sql5 = "insert into pidsus.pds_b2_umum_pengeledahan(id_kejati, id_kejari, id_cabjari, no_p8_umum, no_b2_umum, no_urut_penggeledahan, 
							 penggeledahan_terhadap, nama, jabatan, tempat_penggeledahan, alamat_penggeledahan, nama_pemilik, pekerjaan_pemilik, alamat_pemilik) values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".$no_b2_umum."', '".$no_urut_penggeledahan."', 
							 '".$penggeledahan_terhadap."', '".$nama."', '".$jabatan."', '".$tempat_penggeledahan."', '".$alamat_penggeledahan."', '".$nama_pemilik."', 
							 '".$pekerjaan_pemilik."', '".$alamat_pemilik."')";
					$connection->createCommand($sql5)->execute();
				}
			}
                        
			$sql6 = "delete from pidsus.pds_b2_umum_penyitaan where ".$whereDef." and no_b2_umum = '".$no_b2_umum."'";
			$connection->createCommand($sql6)->execute();
			if(count($post['nama_barang_disita']) > 0){
				$no_urut_penyitaan = 0;
				foreach($post['nama_barang_disita'] as $idx1=>$val1){
					$no_urut_penyitaan++;
					$nama_barang_disita		= htmlspecialchars($post['nama_barang_disita'][$idx1], ENT_QUOTES);
					$disita_dari			= htmlspecialchars($post['disita_dari'][$idx1], ENT_QUOTES);
					$jenis_barang_disita	= htmlspecialchars($post['jenis_barang_disita'][$idx1], ENT_QUOTES);
					$tempat_penyitaan 		= htmlspecialchars($post['tempat_penyitaan'][$idx1], ENT_QUOTES);
					$jumlah_barang_disita	= htmlspecialchars($post['jumlah_barang_disita'][$idx1], ENT_QUOTES);
					$nama_pemilik			= htmlspecialchars($post['nama_pemilik'][$idx1], ENT_QUOTES);
					$pekerjaan_pemilik 		= htmlspecialchars($post['pekerjaan_pemilik'][$idx1], ENT_QUOTES);
					$alamat_pemilik			= htmlspecialchars($post['alamat_pemilik'][$idx1], ENT_QUOTES);
					$keperluan				= htmlspecialchars($post['sita_keperluan'][$idx1], ENT_QUOTES);
					$keterangan				= htmlspecialchars($post['sita_keterangan'][$idx1], ENT_QUOTES);
					
					$sql7 = "insert into pidsus.pds_b2_umum_penyitaan(id_kejati, id_kejari, id_cabjari, no_p8_umum, no_b2_umum, no_urut_penyitaan, nama_barang_disita, 
							 jenis_barang_disita, jumlah_barang_disita) 
							 values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".$no_b2_umum."', '".$no_urut_penyitaan."', 
							 '".$nama_barang_disita."', '".$jenis_barang_disita."', '".$jumlah_barang_disita."')";
					$connection->createCommand($sql7)->execute();
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."b2_umum_".$clean1."-".$clean2.".*");
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
		$pathfile	= Yii::$app->params['b2_umum'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload from pidsus.pds_b2_umum where ".$whereDefault." and no_b2_umum = '".rawurldecode($tmp[0])."'";
					$file = $connection->createCommand($kue)->queryOne();
					if($file['file_upload'] && file_exists($pathfile.$file['file_upload'])) unlink($pathfile.$file['file_upload']);

					$sql1 = "delete from pidsus.pds_b2_umum where ".$whereDefault." and no_b2_umum = '".rawurldecode($tmp[0])."'";
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
