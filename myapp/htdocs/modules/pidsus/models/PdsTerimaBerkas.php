<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsTerimaBerkas extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_terima_berkas';
    }
    
    public $tgl_kejadian_perkara;
    public $nama_inst_penyidik;
    public $nama_inst_pelaksana;
    public $tgl_p16;
    public $tempat_kejadian;
    public $tgl_terima;
    public $statusnya;
    
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
    
    public function searchWarga($get){
		$nama  = htmlspecialchars($get['nama'], ENT_QUOTES);
		$sql = "select * from public.ms_warganegara where upper(nama) like '%".strtoupper($nama)."%'";
                $kueri = $this->db->createCommand("select count(*) from (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by id";
		$dataProvider = new SqlDataProvider([
			'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
		]);
		return $dataProvider;
	}
        
	public function searchTersangka($get){
		$nama       = htmlspecialchars($get['mDataTskq1'], ENT_QUOTES);
		$id_kejati  = $_SESSION['kode_kejati'];
		$id_kejari  = $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
		$no_spdp    = $_SESSION['no_spdp'];
		$tgl_spdp   = $_SESSION['tgl_spdp'];
        $condition 	= "";
		$whereDef 	= "a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_spdp = '".$no_spdp."' 
						and a.tgl_spdp = '".$tgl_spdp."'";
		if($nama){
			$condition = " and (upper(a.nama) like '%".strtoupper($nama)."%' or upper(a.tmpt_lahir) like '%".strtoupper($nama)."%' 
							or to_char(a.tgl_lahir, 'DD-MM-YYYY') = '".strtoupper($nama)."')";
		}
		
		$sql = "
		select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_urut, a.nama, a.tmpt_lahir, a.tgl_lahir, a.umur, a.warganegara, a.suku, a.id_identitas, 
		a.no_identitas, a.id_jkl, a.id_agama, a.alamat, a.no_hp, a.id_pendidikan, a.pekerjaan, b.nama as kebangsaan, 'SPDP' as tsk_dari 
		from pidsus.pds_spdp_tersangka a 
		left join public.ms_warganegara b on a.warganegara = b.id
		where ".$whereDef.$condition." 
		UNION ALL 
		select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, 1 as no_urut, a.nama, a.tmpt_lahir, a.tgl_lahir, a.umur, a.warganegara, a.suku, a.id_identitas, 
		a.no_identitas, a.id_jkl, a.id_agama, a.alamat, a.no_hp, a.id_pendidikan, a.pekerjaan, b.nama as kebangsaan, 'Perpanjangan Tahanan' as tsk_dari 
		from pidsus.pds_minta_perpanjang a 
		left join public.ms_warganegara b on a.warganegara = b.id
		where ".$whereDef.$condition;
                
		$kueri = $this->db->createCommand("select count(*) from (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by no_urut";
		$dataProvider = new SqlDataProvider([
			'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
		]);
		return $dataProvider;
	}
	
	public function setPengantar($post){
		$arrPas = array("arr_id", "evt_pengantar_sukses", "tr_id_pengantar", "nurec_pengantar");
		$newId	= htmlspecialchars($post['arr_id'], ENT_QUOTES);
		$trIdp	= htmlspecialchars($post['tr_id_pengantar'], ENT_QUOTES);
		$isNew	= htmlspecialchars($post['nurec_pengantar'], ENT_QUOTES);

		$kolom0	= '';
		$kolom1	= htmlspecialchars($post['modal1_no_pengantar'], ENT_QUOTES);
		$kolom2	= htmlspecialchars($post['modal1_tgl_pengantar'], ENT_QUOTES);
		$kolom3	= htmlspecialchars($post['modal1_tgl_terima'], ENT_QUOTES);
		if(count($post['modal1_nama']) > 0){
			$kolom4 = '';
			foreach($post['modal1_nama'] as $idx4=>$val4){
				$tempo1 = htmlspecialchars($post['modal1_no_urut'][$idx4], ENT_QUOTES);
				$tempo2 = htmlspecialchars($post['modal1_nama'][$idx4], ENT_QUOTES);
				$kolom4 .= '<p style="margin-bottom:2px;">'.$tempo1.'. '.$tempo2.'</p>';
			}
		}

		if(count($post['modal1_undang_uu']) > 0){
			$kolom5 = '';
			foreach($post['modal1_undang_uu'] as $idx5=>$val5){
				$tempi1 = htmlspecialchars($post['modal1_undang_uu'][$idx5], ENT_QUOTES);
				$tempi2 = htmlspecialchars($post['modal1_pasal'][$idx5], ENT_QUOTES);
				$tempi3 = htmlspecialchars($post['modal1_dakwaan'][$idx5], ENT_QUOTES);
				$arrTem = array("", "Juncto", "Dan", "Atau", "Subsider");
				$kolom5 .= $tempi2.' '.$tempi1.' '.$arrTem[$tempi3].' ';
			}
		}

		if(count($post) > 0){
			foreach($post as $idx1=>$val1){
				if(!in_array($idx1, $arrPas)){
					$nama = str_replace("modal1_","",$idx1);
					if(is_array($val1)){
						foreach($val1 as $idx2=>$val2){
							$extCls = ($nama == "waktu_kejadian")?' waktu_kejadian'.$idx2:'';
							$kolom0 .= '<input type="hidden" name="'.$nama.'['.$newId.']['.$idx2.']" class="pntBrks'.$extCls.'" value="'.$val2.'" />';
						}
					} else{
						$extCls = ($nama == "tmp_kejadian")?' tmp_kejadian':'';
						$kolom0 .= '<input type="hidden" name="'.$nama.'['.$newId.']" class="pntBrks'.$extCls.'" value="'.$val1.'" />';
					}
				}	
			}
		}
		$kolomnya = '
		<td>'.$kolom0.'<a class="ubahPengantar" style="cursor:pointer">'.$kolom1.'</a></td><td class="text-center">'.$kolom2.'</td>
		<td class="text-center">'.$kolom3.'</td><td>'.$kolom4.'</td><td>'.$kolom5.'</td>
		<td class="text-center"><input type="checkbox" name="chk_del_pnt['.$newId.']" id="chk_del_pnt'.$newId.'" class="hRowJpn" value="'.$newId.'"></td>';
		$hasilnya = ($isNew)?'<tr data-id="'.$newId.'">'.$kolomnya.'</tr>':$kolomnya;
		return $hasilnya;
	}

	public function getPengantar($post){
		$index	= htmlspecialchars($post['arr_id'], ENT_QUOTES);
		$model1 = array();
		$model2 = array();
		$model3 = array();
		$arrTmp = array("undang_id", "undang_uu", "id_pasal", "pasal", "dakwaan");
		if(count($post) > 0){
			foreach($post as $idx1=>$val1){
				if(!is_array($val1[$index]) || $idx1 == 'waktu_kejadian')
					$model1[$idx1] = $val1[$index];
				else if(in_array($idx1, $arrTmp)){
					foreach($val1[$index] as $idx2=>$val2){
						$model2[$idx2][$idx1] = $val2;
					}
				} else{
					foreach($val1[$index] as $idx3=>$val3){
						$model3[$idx3][$idx1] = $val3;
					}
				}
			}
		}
		return array($model1, $model2, $model3);
	}

	public function explodeTersangka($post){
		$data = array();
		$trid = htmlspecialchars($post['tr_id'], ENT_QUOTES);
		$data['no_urut'] 		= htmlspecialchars($post['modal1_no_urut'][$trid], ENT_QUOTES);
		$data['nama'] 			= htmlspecialchars($post['modal1_nama'][$trid], ENT_QUOTES);
		$data['tmpt_lahir']		= htmlspecialchars($post['modal1_tmpt_lahir'][$trid], ENT_QUOTES);
		$data['tgl_lahir']		= htmlspecialchars($post['modal1_tgl_lahir'][$trid], ENT_QUOTES);                
		$data['umur']			= htmlspecialchars($post['modal1_umur'][$trid], ENT_QUOTES);                
		$data['warganegara'] 	= htmlspecialchars($post['modal1_warganegara'][$trid], ENT_QUOTES);                
		$data['kebangsaan'] 	= htmlspecialchars($post['modal1_kebangsaan'][$trid], ENT_QUOTES);                
		$data['suku'] 			= htmlspecialchars($post['modal1_suku'][$trid], ENT_QUOTES);                
		$data['id_identitas'] 	= htmlspecialchars($post['modal1_id_identitas'][$trid], ENT_QUOTES);                
		$data['no_identitas'] 	= htmlspecialchars($post['modal1_no_identitas'][$trid], ENT_QUOTES);                
		$data['id_jkl'] 		= htmlspecialchars($post['modal1_id_jkl'][$trid], ENT_QUOTES);                
		$data['id_agama'] 		= htmlspecialchars($post['modal1_id_agama'][$trid], ENT_QUOTES);                
		$data['alamat'] 		= htmlspecialchars($post['modal1_alamat'][$trid], ENT_QUOTES);                
		$data['no_hp'] 			= htmlspecialchars($post['modal1_no_hp'][$trid], ENT_QUOTES);                
		$data['id_pendidikan'] 	= htmlspecialchars($post['modal1_id_pendidikan'][$trid], ENT_QUOTES);                
		$data['pekerjaan'] 		= htmlspecialchars($post['modal1_pekerjaan'][$trid], ENT_QUOTES);
		return $data;
	}

	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		
		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "
		with tbl_brks_tsk as(
			select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, string_agg(no_urut||'--'||nama, '#' order by no_urut) as tersangka
			from(
				select distinct id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_urut, nama 
				from pidsus.pds_terima_berkas_tersangka 
			) a
			group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas 
		),
                tbl_brks_uu as(
			select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, string_agg(no_urut||'--'||undang||'--'||pasal, '#') as undang_pasal
			from(
				select distinct id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_urut, undang, pasal 
				from pidsus.pds_terima_berkas_pengantar_uu 
			) a
			group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas 
		)
		select a.no_berkas, a.tgl_berkas, b.tersangka, a.no_spdp, a.tgl_spdp, d.nama as inst_pelak_penyidikan, c.tgl_terima, f.statusnya
		from pidsus.pds_terima_berkas a 
		left join tbl_brks_tsk b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas
		left join pidsus.pds_spdp c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari 
			and a.no_spdp = c.no_spdp and a.tgl_spdp = c.tgl_spdp
		left join pidsus.ms_inst_pelak_penyidikan d on c.id_asalsurat=d.kode_ip and c.id_penyidik=d.kode_ipp
		left join tbl_brks_uu e on a.id_kejati = e.id_kejati and a.id_kejari = e.id_kejari and a.id_cabjari = e.id_cabjari 
			and a.no_spdp = e.no_spdp and a.tgl_spdp = e.tgl_spdp and a.no_berkas = e.no_berkas 
		left join pidsus.vw_pds_status_berkas_dikeks f on a.id_kejati = f.id_kejati and a.id_kejari = f.id_kejari and a.id_cabjari = f.id_cabjari and a.no_spdp = f.no_spdp 
			and a.tgl_spdp = f.tgl_spdp and a.no_berkas = f.no_berkas 
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."'";
		if($q1)
			$sql .= " and (upper(a.no_berkas) like '%".strtoupper($q1)."%' or to_char(a.tgl_berkas, 'DD-MM-YYYY') = '".$q1."' 
					or upper(b.tersangka) like '%".strtoupper($q1)."%' or upper(a.no_spdp) like '%".strtoupper($q1)."%' or to_char(a.tgl_spdp, 'DD-MM-YYYY') = '".$q1."')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_berkas desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
    
    public function cekBerkas($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
		$nom_spdp  	= $_SESSION['no_spdp'];
		$tgl_spdp 	= $_SESSION['tgl_spdp'];

		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_berkas  = htmlspecialchars($post['no_berkas'], ENT_QUOTES);
		$where 		= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$nom_spdp."' 
						and tgl_spdp = '".$tgl_spdp."'";

		$sqlCek1 	= "select count(*) from pidsus.pds_terima_berkas where ".$where." and no_berkas = '".$no_berkas."'";
		$count1 	= ($isNew)?$connection->createCommand($sqlCek1)->queryScalar():0;

		if($count1 > 0){
			$pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>Nomor Berkas dengan nomor '.$no_berkas.' sudah ada</i></p>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_berkas");
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
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];
		$no_berkas_sess	= $_SESSION['no_berkas'];

		$no_berkas		= htmlspecialchars($post['no_berkas'], ENT_QUOTES);
		$tgl_berkas		= htmlspecialchars($post['tgl_berkas'], ENT_QUOTES);
		$tmpP16			= htmlspecialchars($post['no_p16'], ENT_QUOTES);
		$arrP16			= explode("|#|", $tmpP16);

		$isNew      	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$created_user	= $_SESSION['username'];
		$created_nip	= $_SESSION['nik_user'];
		$created_nama	= $_SESSION['nama_pegawai'];
		$created_ip		= $_SERVER['REMOTE_ADDR'];
		$updated_user	= $_SESSION['username'];
		$updated_nip	= $_SESSION['nik_user'];
		$updated_nama	= $_SESSION['nama_pegawai'];
		$updated_ip		= $_SERVER['REMOTE_ADDR'];

		$whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$no_spdp."' and tgl_spdp = '".$tgl_spdp."'";
		$transaction = $connection->beginTransaction();
		try{
			if($isNew){
				$sql1 = "
				insert into pidsus.pds_terima_berkas(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, tgl_berkas, no_p16) values 
				('".$id_kejati."','".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$no_berkas."', '".$helpernya->tgl_db($tgl_berkas)."','".$arrP16[0]."')";
			}else{
				$sql1 = "
				update pidsus.pds_terima_berkas set no_berkas = '".$no_berkas."',tgl_berkas = '".$helpernya->tgl_db($tgl_berkas)."', no_p16 = '".$arrP16[0]."' 
				where ".$whereDef." and no_berkas = '".$no_berkas_sess."'";
			}
			$connection->createCommand($sql1)->execute();
			
			$arrPnt = array();
			if(count($post['no_pengantar']) > 0){
				foreach($post['no_pengantar'] as $idx1=>$val11){
					$no_pengantar	= htmlspecialchars($post['no_pengantar'][$idx1], ENT_QUOTES);
					$tgl_pengantar	= htmlspecialchars($post['tgl_pengantar'][$idx1], ENT_QUOTES);
					$tgl_terima		= htmlspecialchars($post['tgl_terima'][$idx1], ENT_QUOTES);
					$wkt_kejadian0  = ($post['waktu_kejadian'][$idx1][0])?htmlspecialchars($post['waktu_kejadian'][$idx1][0], ENT_QUOTES):"";
					$wkt_kejadian1  = ($post['waktu_kejadian'][$idx1][1])?htmlspecialchars($post['waktu_kejadian'][$idx1][1], ENT_QUOTES):"";
					$wkt_kejadian2  = ($post['waktu_kejadian'][$idx1][2])?htmlspecialchars($post['waktu_kejadian'][$idx1][2], ENT_QUOTES):"";
					$wkt_kejadian3  = ($post['waktu_kejadian'][$idx1][3])?htmlspecialchars($post['waktu_kejadian'][$idx1][3], ENT_QUOTES):"";
					$wkt_kejadian4  = ($post['waktu_kejadian'][$idx1][4])?htmlspecialchars($post['waktu_kejadian'][$idx1][4], ENT_QUOTES):"";
					$tmp_kejadian 	= htmlspecialchars($post['tmp_kejadian'][$idx1], ENT_QUOTES);
					$tgl_kejadian 	= $wkt_kejadian0."-".$wkt_kejadian1."-".$wkt_kejadian2."-".$wkt_kejadian3."-".$wkt_kejadian4;
					
					$cekPnt = "select count(*) from pidsus.pds_terima_berkas_pengantar where ".$whereDef." and no_berkas = '".$no_berkas."' and no_pengantar = '".$no_pengantar."'";
					$jumPnt = $connection->createCommand($cekPnt)->queryScalar();
					array_push($arrPnt, $no_pengantar);
					if($jumPnt == 0){
						$sql3 = "insert into pidsus.pds_terima_berkas_pengantar values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', 
								'".$no_berkas."', '".$no_pengantar."', '".$helpernya->tgl_db($tgl_pengantar)."', '".$helpernya->tgl_db($tgl_terima)."', '')";
						$connection->createCommand($sql3)->execute();
					} else{
						$sql3 = "update pidsus.pds_terima_berkas_pengantar set tgl_pengantar = '".$helpernya->tgl_db($tgl_pengantar)."', 
								 tgl_terima = '".$helpernya->tgl_db($tgl_terima)."' 
								 where ".$whereDef." and no_berkas = '".$no_berkas."' and no_pengantar = '".$no_pengantar."'";
						$connection->createCommand($sql3)->execute();
					}
					
					$sql0 = "update pidsus.pds_spdp set tgl_kejadian_perkara = '".$tgl_kejadian."', tempat_kejadian = '".$tmp_kejadian."' where ".$whereDef;
					$connection->createCommand($sql0)->execute();
					
					$sql4 = "delete from pidsus.pds_terima_berkas_tersangka where ".$whereDef." and no_berkas = '".$no_berkas."' and no_pengantar = '".$no_pengantar."'";
					$connection->createCommand($sql4)->execute();
					if(count($post['no_urut'][$idx1]) > 0){
						foreach($post['no_urut'][$idx1] as $idx2=>$val2){
							$no_urut		= htmlspecialchars($post['no_urut'][$idx1][$idx2], ENT_QUOTES);
							$nama			= htmlspecialchars($post['nama'][$idx1][$idx2], ENT_QUOTES);
							$tmpt_lahir		= htmlspecialchars($post['tmpt_lahir'][$idx1][$idx2], ENT_QUOTES);
							$tgl_lahir		= htmlspecialchars($post['tgl_lahir'][$idx1][$idx2], ENT_QUOTES);
							$umur			= htmlspecialchars($post['umur'][$idx1][$idx2], ENT_QUOTES);
							$warganegara	= htmlspecialchars($post['warganegara'][$idx1][$idx2], ENT_QUOTES);
							$suku			= htmlspecialchars($post['suku'][$idx1][$idx2], ENT_QUOTES);
							$id_identitas	= htmlspecialchars($post['id_identitas'][$idx1][$idx2], ENT_QUOTES);
							$no_identitas	= htmlspecialchars($post['no_identitas'][$idx1][$idx2], ENT_QUOTES);
							$id_jkl			= htmlspecialchars($post['id_jkl'][$idx1][$idx2], ENT_QUOTES);
							$id_agama		= htmlspecialchars($post['id_agama'][$idx1][$idx2], ENT_QUOTES);
							$alamat			= htmlspecialchars($post['alamat'][$idx1][$idx2], ENT_QUOTES);
							$no_hp			= htmlspecialchars($post['no_hp'][$idx1][$idx2], ENT_QUOTES);
							$id_pendidikan	= htmlspecialchars($post['id_pendidikan'][$idx1][$idx2], ENT_QUOTES);
							$pekerjaan		= htmlspecialchars($post['pekerjaan'][$idx1][$idx2], ENT_QUOTES);
							$sql5 = "
								insert into pidsus.pds_terima_berkas_tersangka(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_pengantar, no_urut, nama, 
								tmpt_lahir, tgl_lahir, umur, warganegara, suku, id_identitas, no_identitas, id_jkl, id_agama, alamat, no_hp, id_pendidikan, pekerjaan) values 
								('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$no_berkas."', '".$no_pengantar."', '".$no_urut."', 
								'".$nama."', '".$tmpt_lahir."', '".$helpernya->tgl_db($tgl_lahir)."', '".$umur."', '".$warganegara."', '".$suku."', '".$id_identitas."', 
								'".$no_identitas."', '".$id_jkl."', '".$id_agama."', '".$alamat."', '".$no_hp."', '".$id_pendidikan."', '".$pekerjaan."')";
							$connection->createCommand($sql5)->execute();
							
						}
					}

					$sql6 = "delete from pidsus.pds_terima_berkas_pengantar_uu where ".$whereDef." and no_berkas = '".$no_berkas."' and no_pengantar = '".$no_pengantar."'";
					$connection->createCommand($sql6)->execute();
					if(count($post['undang_uu'][$idx1]) > 0){
						$nom1 = 0;
						foreach($post['undang_uu'][$idx1] as $idx2=>$val2){
							$nom1++;
							$undang_uu	= htmlspecialchars($post['undang_uu'][$idx1][$idx2], ENT_QUOTES);
							$pasal		= htmlspecialchars($post['pasal'][$idx1][$idx2], ENT_QUOTES);
							$dakwaan	= htmlspecialchars($post['dakwaan'][$idx1][$idx2], ENT_QUOTES);
							$sql7 = "
								insert into pidsus.pds_terima_berkas_pengantar_uu(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_pengantar, no_urut, undang, 
								pasal, dakwaan) values ('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$no_berkas."', 
								'".$no_pengantar."', '".$nom1."', '".$undang_uu."', '".$pasal."', '".$dakwaan."')";
							$connection->createCommand($sql7)->execute();
							
						}
					}
				}
			}
			$strnya = "'', ";
			foreach($arrPnt as $val){
				$strnya .= "'".$val."', ";
			}
			$sql2 = "delete from pidsus.pds_terima_berkas_pengantar where ".$whereDef." and no_berkas = '".$no_berkas."' and no_pengantar not in (".substr($strnya,0,-2).")";
			$connection->createCommand($sql2)->execute();

			$sql21 = "
				update pidsus.pds_terima_berkas_pengantar set is_akhir = 1 
				where (id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, tgl_pengantar) in 
				(
					select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, max(tgl_pengantar)  
					from pidsus.pds_terima_berkas_pengantar 
					where ".$whereDef." and no_berkas = '".$no_berkas."'
					group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas
				)";
			$connection->createCommand($sql21)->execute();

			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }

    public function hapusData($post){
		$connection 	= $this->db;
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
                                        $tmp = explode("#", $val);
					$sql1 = "delete from pidsus.pds_terima_berkas where ".$whereDefault." and no_spdp = '".rawurldecode($tmp[0])."' and tgl_spdp = '".rawurldecode($tmp[1])."' and no_berkas='".rawurldecode($tmp[2])."'";
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
    
    public function getSpdp($get){
		$q1  = htmlspecialchars($get['mspdp_q1'], ENT_QUOTES);
		$sql = "
		select a.*,b.nama as nama_inst_penyidik, c.nama as nama_inst_pelaksana
		from pidsus.pds_spdp a
                Left Join pidsus.ms_inst_penyidik b on a.id_asalsurat=b.kode_ip
                Left Join pidsus.ms_inst_pelak_penyidikan c on a.id_asalsurat=c.kode_ip and a.id_penyidik=c.kode_ipp
		where 1=1"; 
		if($q1)
			$sql .= " and (upper(no_spdp) like '%".strtoupper($q1)."%' or to_char(tgl_spdp, 'DD-MM-YYYY') = '".$q1."')";
		$kueri = $this->db->createCommand("select count(*) from (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_terima desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
        ]);

        return $dataProvider;
    }
    
    public function searchGetnop16($post){
		$connection = $this->db;
        $helpernya	= Yii::$app->inspektur;
		$q1 = htmlspecialchars($post['q1'], ENT_QUOTES);
		$tmp = explode("|#|", $q1);
		$_SESSION['no_spdp'] = $tmp[0];
		$_SESSION['tgl_spdp'] = $helpernya->tgl_db($tmp[1]);
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
					and no_spdp = '".$tmp[0]."' and tgl_spdp = '".$helpernya->tgl_db($tmp[1])."'";
		$sql 	= "select no_p16,to_char(tgl_dikeluarkan, 'DD-MM-YYYY') as tgl_p16 from pidsus.pds_p16 where ".$whereDefault;
		$answer	= array();
		$answer["items"][] = array("id"=>'', "text"=>'');
		$result 	= $connection->createCommand($sql)->queryAll();
		if(count($result) > 0){
			foreach($result as $data){
				$answer["items"][] = array("id"=>$data['no_p16'].'|#|'.$data['tgl_p16'], "text"=>$data['no_p16']);
			}
		}
		return $answer;

	}

}
