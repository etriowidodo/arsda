<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;
require_once('./function/tgl_indo.php');

class PdsPidsus16Umum extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p16';
    }
    
	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_p8_umum	= $_SESSION['pidsus_no_p8_umum'];

		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "select a.* from pidsus.pds_pidsus16_umum a 
				where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_p8_umum = '".$no_p8_umum."'";

		if($q1)
			$sql .= " and (to_char(a.tgl_pidsus16_umum, 'DD-MM-YYYY') = '".$q1."' or upper(a.nip_jaksa) like '%".strtoupper($q1)."%' 
			or upper(a.nama_jaksa) like '%".strtoupper($q1)."%' or upper(a.pangkat_jaksa) like '%".strtoupper($q1)."%' or upper(a.gol_jaksa) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_pidsus16_umum desc, a.created_date desc";
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
		$arrBln 		= array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$jam_sita 		= htmlspecialchars($post['modal_waktu_penggeledahan'][0], ENT_QUOTES);
		$menit_sita 	= htmlspecialchars($post['modal_waktu_penggeledahan'][1], ENT_QUOTES);
		$tanggal_sita 	= htmlspecialchars($post['modal_waktu_penggeledahan'][2], ENT_QUOTES);
		$bulan_sita 	= htmlspecialchars($post['modal_waktu_penggeledahan'][3], ENT_QUOTES);
		$tahun_sita 	= htmlspecialchars($post['modal_waktu_penggeledahan'][4], ENT_QUOTES);
		if($tahun_sita) $tanggal = 'Tahun '.$tahun_sita;
		if($tahun_sita && $bulan_sita) $tanggal = 'Bulan '.$arrBln[intval($bulan_sita)].' Tahun '.$tahun_sita;
		if($tahun_sita && $bulan_sita && $tanggal_sita) $tanggal = 'Tanggal '.$tanggal_sita.' '.$arrBln[intval($bulan_sita)].' '.$tahun_sita;
		if($jam_sita && $menit_sita) $waktu = ' Jam '.$jam_sita.':'.$menit_sita;
                
                $jam_penggeledahan  = htmlspecialchars($post['modal_jam_penggeledahan'], ENT_QUOTES);
                $tgl_penggeledahan  = htmlspecialchars($post['modal_tgl_penggeledahan'], ENT_QUOTES);
                $tgl_penggeledahan  = ($tgl_penggeledahan)?tgl_indo(date('d-m-Y',strtotime($tgl_penggeledahan))):'';
                
		$kolom5 = '';
		if(count($post['modal_jpngldhid']) > 0){
			$kolom5 = '<table cellpadding="0" cellspacing="0" border="0" width="100%">';
			foreach($post['modal_jpngldhid'] as $idx5=>$val5){
				$nomx = $idx5 + 1;
				list($nip_jaksa, $nama_jaksa, $gol_jaksa, $pangkat_jaksa, $jabatan_jaksa) = explode("|##|", $val5);
				$kolom5 .= '<tr><td width="25" valign="top">'.$nomx.'.</td><td>'.$nip_jaksa.'<br />'.$nama_jaksa.'</td></tr>';
			}
			$kolom5 .= '</table>';
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
		<td class="text-left">'.$ygDigeledah.'</td>
		<td class="text-left">Tanggal '.$tgl_penggeledahan.' Jam '.$jam_penggeledahan.'<br />'.$kolom5.'</td>
		<td class="text-left">'.$gldh_keperluan.'</td>
		<td class="text-left">'.$gldh_keterangan.'</td>';
		$hasilnya = ($isNew)?'<tr data-id="'.$newId.'" class="barisGeledahan">'.$kolomnya.'</tr>':$kolomnya;
		return $hasilnya;
	}

	public function searchListJaksaGldh($get){
		$q1  = htmlspecialchars($get['mjpngldh_q1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['mjpngldh_q2'], ENT_QUOTES);
		$sql = "select peg_nip_baru, nama, gol_kd, gol_pangkatjaksa, jabatan, gol_pangkatjaksa||' ('||gol_kd||')' as pangkatgol, inst_satkerkd 
				from pidsus.vw_jaksa_penuntut where inst_satkerkd = '".$_SESSION["inst_satkerkd"]."'";
		if($q1)
			$sql .= " and (upper(peg_nip_baru) like '".strtoupper($q1)."%' or upper(nama) like '%".strtoupper($q1)."%' or upper(jabatan) like '%".strtoupper($q1)."%' 
					or upper(gol_pangkatjaksa) like '%".strtoupper($q1)."%' or upper(gol_kd) like '%".strtoupper($q1)."%')";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
        ]);
        return $dataProvider;
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
		
		$arrBln 		= array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$jam_sita 		= htmlspecialchars($post['modal_waktu_pelaksanaan'][0], ENT_QUOTES);
		$menit_sita 	= htmlspecialchars($post['modal_waktu_pelaksanaan'][1], ENT_QUOTES);
		$tanggal_sita 	= htmlspecialchars($post['modal_waktu_pelaksanaan'][2], ENT_QUOTES);
		$bulan_sita 	= htmlspecialchars($post['modal_waktu_pelaksanaan'][3], ENT_QUOTES);
		$tahun_sita 	= htmlspecialchars($post['modal_waktu_pelaksanaan'][4], ENT_QUOTES);
		if($tahun_sita) $tanggal = 'Tahun '.$tahun_sita;
		if($tahun_sita && $bulan_sita) $tanggal = 'Bulan '.$arrBln[intval($bulan_sita)].' Tahun '.$tahun_sita;
		if($tahun_sita && $bulan_sita && $tanggal_sita) $tanggal = 'Tanggal '.$tanggal_sita.' '.$arrBln[intval($bulan_sita)].' '.$tahun_sita;
		if($jam_sita && $menit_sita) $waktu = ' Jam '.$jam_sita.':'.$menit_sita;
                
                $jam_penyitaan  = htmlspecialchars($post['modal_jam_penyitaan'], ENT_QUOTES);
                $tgl_penyitaan  = htmlspecialchars($post['modal_tgl_penyitaan'], ENT_QUOTES);
                $tgl_penyitaan  = ($tgl_penyitaan)?tgl_indo(date('d-m-Y',strtotime($tgl_penyitaan))):'';

		$kolom5 = '';
		if(count($post['modal_jpnsitaid']) > 0){
			$kolom5 = '<table cellpadding="0" cellspacing="0" border="0" width="100%">';
			foreach($post['modal_jpnsitaid'] as $idx5=>$val5){
				$nomx = $idx5 + 1;
				list($nip_jaksa, $nama_jaksa, $gol_jaksa, $pangkat_jaksa, $jabatan_jaksa) = explode("|##|", $val5);
				$kolom5 .= '<tr><td width="25" valign="top">'.$nomx.'.</td><td>'.$nip_jaksa.'<br />'.$nama_jaksa.'</td></tr>';
			}
			$kolom5 .= '</table>';
		}

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
		<td class="text-left">
			<a class="ubahPenyitaan" style="cursor:pointer">'.$nama_barang_disita.'</a><br />Jenis : '.$jenis_barang_disita.'<br />Jumlah : '.$jumlah_barang_disita.'
		</td>
		<td class="text-left">Dari : '.$disita_dari.'<br />Tempat : '.$tempat_penyitaan.'</td>
		<td class="text-left"> Tanggal '.$tgl_penyitaan.' Jam '.$jam_penyitaan.'<br />'.$kolom5.'</td>
		<td class="text-left">'.$sita_keperluan.'</td>
		<td class="text-left">'.$sita_keterangan.'</td>';
		$hasilnya = ($isNew)?'<tr data-id="'.$newId.'" class="barisSitaan">'.$kolomnya.'</tr>':$kolomnya;
		return $hasilnya;
	}

	public function searchListJaksaSita($get){
		$q1  = htmlspecialchars($get['mjpnsita_q1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['mjpnsita_q2'], ENT_QUOTES);
		$sql = "select peg_nip_baru, nama, gol_kd, gol_pangkatjaksa, jabatan, gol_pangkatjaksa||' ('||gol_kd||')' as pangkatgol, inst_satkerkd 
				from pidsus.vw_jaksa_penuntut where inst_satkerkd = '".$_SESSION["inst_satkerkd"]."'";
		if($q1)
			$sql .= " and (upper(peg_nip_baru) like '".strtoupper($q1)."%' or upper(nama) like '%".strtoupper($q1)."%' or upper(jabatan) like '%".strtoupper($q1)."%' 
					or upper(gol_pangkatjaksa) like '%".strtoupper($q1)."%' or upper(gol_kd) like '%".strtoupper($q1)."%')";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
        ]);
        return $dataProvider;
    }

	public function simpanData($post){
		$helpernya	= Yii::$app->inspektur;
		$connection = $this->db;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_p8_umum			= htmlspecialchars($post['no_p8_umum'], ENT_QUOTES);
		$no_pidsus16_umum 	= ($post['no_pidsus16_umum'])?htmlspecialchars($post['no_pidsus16_umum'], ENT_QUOTES):0;
		$tgl_pidsus16_umum	= htmlspecialchars($post['tgl_pidsus16_umum'], ENT_QUOTES);
		$lampiran			= htmlspecialchars($post['lampiran'], ENT_QUOTES);

		$nip_jaksa		= htmlspecialchars($post['nip_jaksa'], ENT_QUOTES);
		$nama_jaksa		= htmlspecialchars($post['nama_jaksa'], ENT_QUOTES);
		$gol_jaksa		= htmlspecialchars($post['gol_jaksa'], ENT_QUOTES);
		$pangkat_jaksa	= htmlspecialchars($post['pangkat_jaksa'], ENT_QUOTES);
		$jabatan_jaksa	= htmlspecialchars($post['jabatan_jaksa'], ENT_QUOTES);
		$jabatan_p8		= htmlspecialchars($post['jabatan_p8'], ENT_QUOTES);

		$created_user		= $_SESSION['username'];
		$created_nip		= $_SESSION['nik_user'];
		$created_nama		= $_SESSION['nama_pegawai'];
		$created_ip			= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai'];
		$updated_ip			= $_SERVER['REMOTE_ADDR'];

		$sql0 = "select coalesce(max(no_pidsus16_umum)+1,1) as nourut from pidsus.pds_pidsus16_umum 
				 where id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p8_umum = '".$no_p8_umum."'";
		$row0 = $connection->createCommand($sql0)->queryScalar();

		$filePhoto1 = htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto1 = htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto1 = htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto1 	= substr($filePhoto1,strrpos($filePhoto1,'.'));

		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['pidsus_16umum'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_umum);
		$clean2 	= ($isNew)?$row0:$no_pidsus16_umum;
		$newPhoto1 	= "pidsus_16_umum_".$clean1."-".$clean2.$extPhoto1;
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
				$sql1 = "insert into pidsus.pds_pidsus16_umum(id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus16_umum, tgl_pidsus16_umum, lampiran, nip_jaksa, nama_jaksa, 
						 gol_jaksa, pangkat_jaksa, jabatan_jaksa, jabatan_p8, file_upload, created_user, created_nip, created_nama, created_ip, created_date, updated_user, 
						 updated_nip, updated_nama, updated_ip, updated_date) values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".$row0."', 
						 '".$helpernya->tgl_db($tgl_pidsus16_umum)."', '".$lampiran."', '".$nip_jaksa."', '".$nama_jaksa."', '".$gol_jaksa."', '".$pangkat_jaksa."', 
						 '".$jabatan_jaksa."', '".$jabatan_p8."', '".$newPhoto1."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			} else{
				if($filePhoto1 != ""){
					$upl1 = true;
					$filenya1 = ", file_upload = '".$newPhoto1."'";
				} else{
					$upl1 = false;
					$filenya1 = "";
				}

				$sql1 = "update pidsus.pds_pidsus16_umum set tgl_pidsus16_umum = '".$helpernya->tgl_db($tgl_pidsus16_umum)."', lampiran = '".$lampiran."', 
						 nip_jaksa = '".$nip_jaksa."', nama_jaksa = '".$nama_jaksa."', gol_jaksa = '".$gol_jaksa."', pangkat_jaksa = '".$pangkat_jaksa."', 
						 jabatan_jaksa = '".$jabatan_jaksa."', jabatan_p8 = '".$jabatan_p8."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya1." 
						 where ".$whereDef." and no_pidsus16_umum = '".$no_pidsus16_umum."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql21 = "delete from pidsus.pds_pidsus16_umum_pengeledahan_jaksa where ".$whereDef." and no_pidsus16_umum = '".$no_pidsus16_umum."'";
			$connection->createCommand($sql21)->execute();

			$sql2 = "delete from pidsus.pds_pidsus16_umum_pengeledahan where ".$whereDef." and no_pidsus16_umum = '".$no_pidsus16_umum."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['penggeledahan_terhadap']) > 0){
				$no_urut_penggeledahan = 0;
				$no_pidsus16_umum = ($isNew)?$row0:$no_pidsus16_umum;
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
					$waktu1					= htmlspecialchars($post['waktu_penggeledahan'][$idx1][0], ENT_QUOTES);
					$waktu2					= htmlspecialchars($post['waktu_penggeledahan'][$idx1][1], ENT_QUOTES);
					$waktu3					= htmlspecialchars($post['waktu_penggeledahan'][$idx1][2], ENT_QUOTES);
					$waktu4					= htmlspecialchars($post['waktu_penggeledahan'][$idx1][3], ENT_QUOTES);
					$waktu5					= htmlspecialchars($post['waktu_penggeledahan'][$idx1][4], ENT_QUOTES);
					$keperluan				= htmlspecialchars($post['gldh_keperluan'][$idx1], ENT_QUOTES);
					$keterangan				= htmlspecialchars($post['gldh_keterangan'][$idx1], ENT_QUOTES);
					$waktu_penggeledahan 	= $waktu1."-".$waktu2."-".$waktu3."-".$waktu4."-".$waktu5;
                                        $jam_penggeledahan 		= htmlspecialchars($post['jam_penggeledahan'][$idx1], ENT_QUOTES);
                                        $tgl_penggeledahan 		= htmlspecialchars($post['tgl_penggeledahan'][$idx1], ENT_QUOTES);
					
					$sql3 = "insert into pidsus.pds_pidsus16_umum_pengeledahan(id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus16_umum, no_urut_penggeledahan, 
							 penggeledahan_terhadap, nama, jabatan, tempat_penggeledahan, alamat_penggeledahan, nama_pemilik, pekerjaan_pemilik, alamat_pemilik, keperluan, 
							 keterangan, waktu_penggeledahan, jam_penggeledahan, tgl_penggeledahan) values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', 
							 '".$no_pidsus16_umum."', '".$no_urut_penggeledahan."', '".$penggeledahan_terhadap."', '".$nama."', '".$jabatan."', '".$tempat_penggeledahan."', 
							 '".$alamat_penggeledahan."', '".$nama_pemilik."', '".$pekerjaan_pemilik."', '".$alamat_pemilik."', '".$keperluan."', '".$keterangan."', 
							 '".$waktu_penggeledahan."', '".$jam_penggeledahan."', '".$helpernya->tgl_db($tgl_penggeledahan)."')";
					$connection->createCommand($sql3)->execute();

					if(count($post['jpngldhid'][$idx1]) > 0){
						$no_urut = 0;
						foreach($post['jpngldhid'][$idx1] as $idx2=>$val2){
							$no_urut++;
							list($nip_jaksa, $nama_jaksa, $gol_jaksa, $pangkat_jaksa, $jabatan_jaksa) = explode("|##|", $val2);
							$sql31 = "insert into pidsus.pds_pidsus16_umum_pengeledahan_jaksa values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', 
									 '".$no_pidsus16_umum."', '".$no_urut_penggeledahan."', '".$no_urut."', '".$nip_jaksa."', '".$nama_jaksa."', '".$gol_jaksa."', 
									 '".$pangkat_jaksa."', '".$jabatan_jaksa."')";
							$connection->createCommand($sql31)->execute();
						}
					}
				}
			}

			$sql41 = "delete from pidsus.pds_pidsus16_umum_penyitaan_jaksa where ".$whereDef." and no_pidsus16_umum = '".$no_pidsus16_umum."'";
			$connection->createCommand($sql41)->execute();

			$sql4 = "delete from pidsus.pds_pidsus16_umum_penyitaan where ".$whereDef." and no_pidsus16_umum = '".$no_pidsus16_umum."'";
			$connection->createCommand($sql4)->execute();

			if(count($post['nama_barang_disita']) > 0){
				$no_urut_penyitaan = 0;
				$no_pidsus16_umum = ($isNew)?$row0:$no_pidsus16_umum;
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
					$waktu1					= htmlspecialchars($post['waktu_pelaksanaan'][$idx1][0], ENT_QUOTES);
					$waktu2					= htmlspecialchars($post['waktu_pelaksanaan'][$idx1][1], ENT_QUOTES);
					$waktu3					= htmlspecialchars($post['waktu_pelaksanaan'][$idx1][2], ENT_QUOTES);
					$waktu4					= htmlspecialchars($post['waktu_pelaksanaan'][$idx1][3], ENT_QUOTES);
					$waktu5					= htmlspecialchars($post['waktu_pelaksanaan'][$idx1][4], ENT_QUOTES);
					$keperluan				= htmlspecialchars($post['sita_keperluan'][$idx1], ENT_QUOTES);
					$keterangan				= htmlspecialchars($post['sita_keterangan'][$idx1], ENT_QUOTES);
					$waktu_penyitaan 		= $waktu1."-".$waktu2."-".$waktu3."-".$waktu4."-".$waktu5;
                                        $jam_penyitaan 		= htmlspecialchars($post['jam_penyitaan'][$idx1], ENT_QUOTES);
                                        $tgl_penyitaan 		= htmlspecialchars($post['tgl_penyitaan'][$idx1], ENT_QUOTES);
					
					$sql5 = "insert into pidsus.pds_pidsus16_umum_penyitaan(id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus16_umum, no_urut_penyitaan, nama_barang_disita, 
							 jenis_barang_disita, jumlah_barang_disita, disita_dari, tempat_penyitaan, nama_pemilik, pekerjaan_pemilik, alamat_pemilik, keperluan, keterangan, 
							 waktu_penyitaan, jam_penyitaan, tgl_penyitaan) values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".$no_pidsus16_umum."', '".$no_urut_penyitaan."', 
							 '".$nama_barang_disita."', '".$jenis_barang_disita."', '".$jumlah_barang_disita."', '".$disita_dari."', '".$tempat_penyitaan."', '".$nama_pemilik."', 
							 '".$pekerjaan_pemilik."', '".$alamat_pemilik."', '".$keperluan."', '".$keterangan."', '".$waktu_penyitaan."', '".$jam_penyitaan."', '".$helpernya->tgl_db($tgl_penyitaan)."')";
					$connection->createCommand($sql5)->execute();

					if(count($post['jpnsitaid'][$idx1]) > 0){
						$no_urut = 0;
						foreach($post['jpnsitaid'][$idx1] as $idx2=>$val2){
							$no_urut++;
							list($nip_jaksa, $nama_jaksa, $gol_jaksa, $pangkat_jaksa, $jabatan_jaksa) = explode("|##|", $val2);
							$sql51 = "insert into pidsus.pds_pidsus16_umum_penyitaan_jaksa values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', 
									 '".$no_pidsus16_umum."', '".$no_urut_penyitaan."', '".$no_urut."', '".$nip_jaksa."', '".$nama_jaksa."', '".$gol_jaksa."', 
									 '".$pangkat_jaksa."', '".$jabatan_jaksa."')";
							$connection->createCommand($sql51)->execute();
						}
					}
				}
			}

			$sql6 = "delete from pidsus.pds_pidsus16_umum_tembusan where ".$whereDef." and no_pidsus16_umum = '".$no_pidsus16_umum."'";
			$connection->createCommand($sql6)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				$no_pidsus16_umum = ($isNew)?$row0:$no_pidsus16_umum;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql7 = "insert into pidsus.pds_pidsus16_umum_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', 
								 '".$no_pidsus16_umum."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql7)->execute();
					}
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."pidsus_16_umum_".$clean1."-".$clean2.".*");
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
		$pathfile		= Yii::$app->params['pidsus_16umum'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload from pidsus.pds_pidsus16_umum where ".$whereDefault." and no_pidsus16_umum = '".rawurldecode($tmp[0])."'";
					$file = $connection->createCommand($kue)->queryOne();
					if($file['file_upload'] && file_exists($pathfile.$file['file_upload'])) unlink($pathfile.$file['file_upload']);

					$sql1 = "delete from pidsus.pds_pidsus16_umum where ".$whereDefault." and no_pidsus16_umum = '".rawurldecode($tmp[0])."'";
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
