<?php

namespace app\modules\datun\models;

use Yii;
use yii\db\Query;
use yii\helpers\HtmlPurifier;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

/**
 * This is the model class for table "datun.m_propinsi".
 *
 * @property string $id_prop
 * @property string $deskripsi
 */
 
class HarianSidang extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'datun.s11';
    }

    function  tanggal_indonesia($tgl){
        $tanggal  = explode('-',$tgl); 
        $bulan  = getBulan($tanggal[1]);
        $tahun  = $tanggal[2];
        $lctgl = $tanggal[0];
        return  $lctgl.' '.$bulan.' '.$tahun;
    }	
	
    public function searchHarian($params){
		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "
		with tbl_jpn as(
			select b.no_register_skk, b.tanggal_skk, b.no_register_perkara, b.no_surat, string_agg(b.nama_pegawai, '#' order by b.no_urut) as jpnnya 
			from datun.skk a 
			join datun.skk_anak b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat and a.no_register_skk = b.no_register_skk 
				and a.tanggal_skk = b.tanggal_skk 
			where a.penerima_kuasa = 'JPN'
			group by b.no_register_skk, b.tanggal_skk, b.no_register_perkara, b.no_surat
			UNION ALL 
			select b.no_register_skk, b.tanggal_skk, b.no_register_perkara, b.no_surat, string_agg(b.nama_pegawai, '#' order by b.no_urut) as jpnnya 
			from datun.skks a 
			join datun.skks_anak b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat and a.no_register_skk = b.no_register_skk 
				and a.tanggal_skk = b.tanggal_skk 
			where a.penerima_kuasa = 'JPN' and a.is_active = 1 
			group by b.no_register_skk, b.tanggal_skk, b.no_register_perkara, b.no_surat 
		)
		select a.*, d.kode_jenis_instansi, h.jpnnya 
		from datun.s11 a
		join datun.skk b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat and a.no_register_skk = b.no_register_skk and a.tanggal_skk = b.tanggal_skk
		join datun.permohonan c on a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat 
		join datun.jenis_instansi d on c.kode_jenis_instansi = d.kode_jenis_instansi
		join datun.instansi e on c.kode_jenis_instansi = e.kode_jenis_instansi and c.kode_instansi = e.kode_instansi and c.kode_tk = e.kode_tk
		join datun.instansi_wilayah f on c.kode_jenis_instansi = f.kode_jenis_instansi and c.kode_instansi = f.kode_instansi 
			and c.kode_provinsi = f.kode_provinsi and c.kode_kabupaten = f.kode_kabupaten and c.kode_tk = f.kode_tk and c.no_urut_wil = f.no_urut
		join tbl_jpn h on a.no_register_perkara = h.no_register_perkara and a.no_surat = h.no_surat and a.no_register_skk = h.no_register_skk and a.tanggal_skk = h.tanggal_skk
		left join datun.skks g on a.no_register_perkara = g.no_register_perkara and a.no_surat = g.no_surat and a.no_register_skk = g.no_register_skk 
			and a.tanggal_skk = g.tanggal_skk and a.no_register_skks = g.no_register_skks
		where a.no_register_skk is not null and a.no_surat = '".$_SESSION['no_surat']."' and a.no_register_perkara = '".$_SESSION['no_register_perkara']."'";

		if($q1)
			$sql .= " and (upper(a.no_register_skk) like '%".strtoupper($q1)."%' or to_char(a.tanggal_skk, 'DD-MM-YYYY') = '".$q1."' 
					or upper(h.jpnnya) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tanggal_s11 desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);

        return $dataProvider;
    }
	
	public function simpanData($post){
		$connection 			= $this->db;
		$helpernya				= Yii::$app->inspektur;
		$no_register_skks		= ($post['no_skks']?"'".htmlspecialchars($post['no_skks'],ENT_QUOTES)."'":'NULL');
		$no_register_skk		= htmlspecialchars($post['no_skk'],ENT_QUOTES);
		$tanggal_skk			= htmlspecialchars($post['tanggal_skk'],ENT_QUOTES);
		$no_register_perkara	= htmlspecialchars($post['no_perkara_perdata'],ENT_QUOTES);
		$no_surat				= htmlspecialchars($post['no_surat'],ENT_QUOTES);
		$kode_jenis_instansi	= htmlspecialchars($post['kode_jenis_instansi'],ENT_QUOTES);
		$kode_instansi			= htmlspecialchars($post['kode_instansi'],ENT_QUOTES);
		$kode_tk				= $_SESSION['kode_tk'];
		$kode_kejati			= $_SESSION['kode_kejati'];
		$kode_kejari			= $_SESSION['kode_kejari'];
		$kode_cabjari			= $_SESSION['kode_cabjari'];
				
		$no_urut_majelis		= 1;//htmlspecialchars($post['no_urut_majelis'],ENT_QUOTES);
		$no_urut_kuasa_penggugat= 1;//htmlspecialchars($post['no_urut_kuasa_penggugat'],ENT_QUOTES);
		
		
		$waktu_tanggal			= htmlspecialchars($post['waktu_tanggal'],ENT_QUOTES);
		$waktu_hari				= htmlspecialchars($post['waktu_hari'],ENT_QUOTES);
		$waktu_sidang			= htmlspecialchars($post['waktu_sidang'],ENT_QUOTES);
		$tempat_sidang			= htmlspecialchars($post['kode_kabupaten'],ENT_QUOTES);
		$panitera_pengganti		= htmlspecialchars($post['panitera_pengganti'],ENT_QUOTES);
		$kuasa_penggugat		= 1;//	= htmlspecialchars($post['kode_kabupaten'],ENT_QUOTES);
		$agenda_sidang			= htmlspecialchars($post['agenda_sidang'],ENT_QUOTES);
		
		$kasus_posisi			= str_replace(array("'"), array("&#039;"), $post['tab_kasus']);
		$isi_laporan			= str_replace(array("'"), array("&#039;"), $post['tab_laporan']);
		$analisa_laporan		= str_replace(array("'"), array("&#039;"), $post['tab_analisa']);
		$kesimpulan				= str_replace(array("'"), array("&#039;"), $post['tab_kesimpulan']);
		$resume					= str_replace(array("'"), array("&#039;"), $post['tab_resume']);
		
		$tanggal_ttd 			= htmlspecialchars($post['tanggal_ditandatangani'],ENT_QUOTES);
		//$file_s11 				= htmlspecialchars($post['file_s11'],ENT_QUOTES);
		
		$filePhoto 	= htmlspecialchars($_FILES['file_s11']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_s11']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_s11']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['s11'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_surat);
		$file_s11 	= "s11_".$clean1."-".$clean2.$extPhoto;
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		
		$created_user			= $_SESSION['username'];
		$created_nama			= $_SESSION['nama_pegawai'];
		$created_nip			= $_SESSION['nik_user'];
		$created_ip				= $_SERVER['REMOTE_ADDR'];
		$update_user			= $_SESSION['username'];
		$update_nama			= $_SESSION['nama_pegawai'];
		$update_nip				= $_SESSION['nik_user'];
		$update_ip				= $_SERVER['REMOTE_ADDR'];
		
		$sqlku = Yii::$app->db->createCommand("SELECT max(no_sidang) as kode from datun.s11 
		where no_register_skk='$no_register_skk' and tanggal_skk='".$helpernya->tgl_db($tanggal_skk)."' and no_register_perkara='$no_register_perkara' and no_surat='$no_surat' ");
		$kode = $sqlku->queryOne();
		
		$transaction = $connection->beginTransaction();
		try{
			
			if($isNew){
				if($filePhoto != ""){
					$upl1 = true;
					$no_sidang = sprintf("%02d",$kode['kode']+1); 
					$sql1 = "insert into datun.s11 (no_register_skk, tanggal_skk, no_register_perkara, no_surat,
					kode_jenis_instansi, kode_instansi, kode_tk, kode_kejati, kode_kejari, kode_cabjari, hari, waktu_sidang,
					tempat_sidang, panitera, kuasa_penggugat, agenda_sidang, kasus_posisi, isi_laporan, analisa_laporan, kesimpulan, resume, tanggal_ttd, file_s11, 
					created_user, created_nama, created_nip, created_date, created_ip, update_user, update_nama, update_nip, update_date, update_ip, no_sidang, tanggal_s11,no_register_skks)
					values ('$no_register_skk','".$helpernya->tgl_db($tanggal_skk)."','$no_register_perkara','$no_surat',
					'$kode_jenis_instansi','$kode_instansi','$kode_tk','$kode_kejati','$kode_kejari', '$kode_cabjari', '$waktu_hari', '$waktu_sidang', 
					'$tempat_sidang', '$panitera_pengganti', '$kuasa_penggugat', '$agenda_sidang', '$kasus_posisi', '$isi_laporan', '$analisa_laporan',
					'$kesimpulan', '$resume', '".$helpernya->tgl_db($tanggal_ttd)."', '$file_s11',
					'$created_user', '$created_nama', '$created_nip', NOW(), '$created_ip', '$update_user',
					'$update_nama', '$update_nip', NOW(), '$update_ip', '$no_sidang', '".$helpernya->tgl_db($waktu_tanggal)."',
					$no_register_skks )";
				} else{
					$upl1 = false;
					$no_sidang = sprintf("%02d",$kode['kode']+1); 
					$sql1 = "insert into datun.s11 (no_register_skk, tanggal_skk, no_register_perkara, no_surat, kode_jenis_instansi, kode_instansi, kode_tk, kode_kejati, 
					kode_kejari, kode_cabjari, hari, waktu_sidang, tempat_sidang, panitera, kuasa_penggugat, agenda_sidang, kasus_posisi, isi_laporan, analisa_laporan, 
					kesimpulan, resume, tanggal_ttd, created_user, created_nama, created_nip, created_date, created_ip, update_user, update_nama, update_nip, update_date, 
					update_ip, no_sidang, tanggal_s11,no_register_skks)
					values ('$no_register_skk','".$helpernya->tgl_db($tanggal_skk)."','$no_register_perkara','$no_surat',
					'$kode_jenis_instansi','$kode_instansi','$kode_tk','$kode_kejati','$kode_kejari', '$kode_cabjari', '$waktu_hari', '$waktu_sidang', 
					'$tempat_sidang', '$panitera_pengganti', '$kuasa_penggugat', '$agenda_sidang', '$kasus_posisi', '$isi_laporan', '$analisa_laporan',
					'$kesimpulan', '$resume', '".$helpernya->tgl_db($tanggal_ttd)."', '$created_user', '$created_nama', '$created_nip', NOW(), '$created_ip', '$update_user',
					'$update_nama', '$update_nip', NOW(), '$update_ip', '$no_sidang', '".$helpernya->tgl_db($waktu_tanggal)."',
					$no_register_skks )";
				}
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$no_sidang = htmlspecialchars($post['no_sidang'], ENT_QUOTES); 
					$sql1 = "update datun.s11 set 
					kode_jenis_instansi='$kode_jenis_instansi',kode_instansi='$kode_instansi',kode_tk='$kode_tk',kode_kejati='$kode_kejati',kode_kejari='$kode_kejari',
					kode_cabjari='$kode_cabjari',hari='$waktu_hari',waktu_sidang='$waktu_sidang',
					tempat_sidang='$tempat_sidang',panitera='$panitera_pengganti',kuasa_penggugat='$kuasa_penggugat',agenda_sidang='$agenda_sidang',kasus_posisi='$kasus_posisi',
					isi_laporan='$isi_laporan',analisa_laporan='$analisa_laporan',kesimpulan='$kesimpulan',resume='$resume',tanggal_ttd='".$helpernya->tgl_db($tanggal_ttd)."',file_s11='$file_s11',
					update_user='$update_user',update_nama='$update_nama',update_nip='$update_nip',update_date=NOW(),update_ip='$update_ip',no_sidang='$no_sidang'
					where no_register_perkara='$no_register_perkara' and no_surat='$no_surat' and tanggal_s11='".$helpernya->tgl_db($waktu_tanggal)."' ";
				} else{
					$upl1 = false;
					$no_sidang = htmlspecialchars($post['no_sidang'], ENT_QUOTES);
					$sql1 = "update datun.s11 set 
					kode_jenis_instansi='$kode_jenis_instansi',kode_instansi='$kode_instansi',kode_tk='$kode_tk',kode_kejati='$kode_kejati',kode_kejari='$kode_kejari',
					kode_cabjari='$kode_cabjari',hari='$waktu_hari',waktu_sidang='$waktu_sidang',
					tempat_sidang='$tempat_sidang',panitera='$panitera_pengganti',kuasa_penggugat='$kuasa_penggugat',agenda_sidang='$agenda_sidang',kasus_posisi='$kasus_posisi',
					isi_laporan='$isi_laporan',analisa_laporan='$analisa_laporan',kesimpulan='$kesimpulan',resume='$resume',tanggal_ttd='".$helpernya->tgl_db($tanggal_ttd)."',
					update_user='$update_user',update_nama='$update_nama',update_nip='$update_nip',update_date=NOW(),update_ip='$update_ip',no_sidang='$no_sidang',tanggal_s11='".$helpernya->tgl_db($waktu_tanggal)."'
					where no_register_perkara='$no_register_perkara' and no_surat='$no_surat' and tanggal_s11='".$helpernya->tgl_db($waktu_tanggal)."'";
				}
			}
			
			$connection->createCommand($sql1)->execute();
			
			$sql2 = "delete from datun.s11_majelis_hakim where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."' and tanggal_s11='".$helpernya->tgl_db($waktu_tanggal)."' ";
			$connection->createCommand($sql2)->execute();
			
			if(count($post['majelis_hakim']) > 0){
				$noauto	 = 0;
				foreach($post['majelis_hakim'] as $idx=>$val){
					$majelis_hakim	 = htmlspecialchars($post['majelis_hakim'][$idx], ENT_QUOTES);
					$status_majelis	 = htmlspecialchars($post['status_majelis'][$idx], ENT_QUOTES);
					if($majelis_hakim && $status_majelis){
						$noauto++;
						$sql2x = "insert into datun.s11_majelis_hakim 
						(no_register_perkara,no_surat,no_urut_majelis,majelis_hakim,status_majelis,tanggal_s11)
						values('".$no_register_perkara."', '".$no_surat."', '".$noauto."','".$majelis_hakim."', '".$status_majelis."', '".$helpernya->tgl_db($waktu_tanggal)."')";
						$connection->createCommand($sql2x)->execute();
					}				
				}
			}
			
			$sql3 = "delete from datun.s11_kuasa_penggugat where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."' and tanggal_s11='".$helpernya->tgl_db($waktu_tanggal)."' ";
			$connection->createCommand($sql3)->execute();
			if(count($post['kuasa_penggugat']) > 0){
				$noauto	 = 0;
				foreach($post['kuasa_penggugat'] as $idx=>$val){
					$kuasa_penggugat = htmlspecialchars($post['kuasa_penggugat'][$idx], ENT_QUOTES);
					
					if($kuasa_penggugat){
						$noauto++;
						$sql3x = "insert into datun.s11_kuasa_penggugat 
						(no_register_perkara,no_surat,no_urut_kuasa_penggugat,kuasa_penggugat,tanggal_s11)
						values('".$no_register_perkara."', '".$no_surat."', '".$noauto."','".$kuasa_penggugat."', '".$helpernya->tgl_db($waktu_tanggal)."')";
						$connection->createCommand($sql3x)->execute();
					}
				}
			}
			
			if($upl1){
				$tmpPot = glob($pathfile."s11_".$clean1."-".$clean2.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$file_s11;
				$mantab  = move_uploaded_file($tempPhoto, $tujuan);
				if(file_exists($tempPhoto)) unlink($tempPhoto);
			}
			
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			throw $e; exit;
			//return false;
		}
		
	}
	
	
	public function hapusData($post){
		$connection = $this->db;
		$pathfile	= Yii::$app->params['s11'];

		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_s11 from datun.s11 where no_register_perkara = '".rawurldecode($tmp[0])."' and no_surat = '".rawurldecode($tmp[3])."' and tanggal_s11 = '".rawurldecode($tmp[5])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from datun.s11 where no_register_perkara = '".rawurldecode($tmp[0])."' and no_surat = '".rawurldecode($tmp[3])."' and tanggal_s11 = '".rawurldecode($tmp[5])."'";
					$h = $connection->createCommand($sql1)->execute();
				}
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			throw $e; exit;
			//return false;
		}
    }
	
	//awal tambahan combo skk n skks========
	 public function getSkks($post){
		$tq1 	= htmlspecialchars($post['q1'], ENT_QUOTES);
		/* $sql 	= "select * from datun.skks where no_register_perkara = '".$_SESSION['no_register_perkara']."' 
				  and no_surat = '".$_SESSION['no_surat']."' and no_register_skk = '".$tq1."' order by tanggal_ttd DESC"; */
		$sql 	= "select b.no_register_skks, b.tanggal_ttd as tanggal_skks, a.tanggal_skk, a.tanggal_diterima from datun.skk a
				  left join datun.skks b on a.no_register_perkara=b.no_register_perkara and a.no_surat=b.no_surat 
				  and a.no_register_skk=b.no_register_skk and a.tanggal_skk=b.tanggal_skk and b.penerima_kuasa='JPN'
				  where a.no_register_perkara = '".$_SESSION['no_register_perkara']."'  
				  and a.no_surat = '".$_SESSION['no_surat']."' and a.no_register_skk = '".$tq1."' order by a.tanggal_skk DESC";
		$result	= $this->db->createCommand($sql)->queryAll();
		$answer	= array();
		$answer["items"][] = array("id"=>'', "text"=>'');
		$tgl	= "";
		$tgl_tr	= "";
		if(count($result) > 0){
			foreach($result as $data){
				$answer["items"][] = array("id"=>$data['no_register_skks'], "text"=>$data['no_register_skks']);
				$tgl 	= $data['tanggal_skk'];
				$tgl_tr = $data['tanggal_terima'];
			}
		}
		//return $answer;
		return array("opt"=>$answer, "tgl"=>$tgl, "tgl_tr"=>$tgl_tr);
    }
	
	public function getTglSkks($post){
		$tq1 = htmlspecialchars($post['q1'], ENT_QUOTES);
		$sql="Select no_register_skks, tanggal_ttd as tanggal_skks from datun.skks 
			  where no_register_perkara = '".$_SESSION['no_register_perkara']."' and no_surat = '".$_SESSION['no_surat']."' 
			  and no_register_skks = '".$tq1."'";
		$res = $this->db->createCommand($sql)->queryOne();
		$res = ($res['no_register_skks']?$res:"");
		return $res;
    }
	//akhir tambahan combo skk n skks========
		
  public function cekS11($post){
		$helpernya	= Yii::$app->inspektur;
		$connection = $this->db;
		$noauto	 = 0;
		if(count($post['majelis_hakim']) > 0){
			foreach($post['majelis_hakim'] as $idx=>$val){
				$majelis_hakim	 = htmlspecialchars($post['majelis_hakim'][$idx], ENT_QUOTES);
				$status_majelis	 = htmlspecialchars($post['status_majelis'][$idx], ENT_QUOTES);
				if($majelis_hakim && $status_majelis){
					$noauto++;
				}				
			}
		}
		if($noauto < 1){
			
			$pesan = '<i style="color:#dd4b39; font-size:12px;">*Majelis Hakim minimal 1 orang.</i>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom1");
		} else{
			return array("hasil"=>true, "error"=>"", "element"=>"");
		}
	}	
	

	public function searchTtd($get){
		$q1  = htmlspecialchars($get['mttd_q1'], ENT_QUOTES);
		$q2  = htmlspecialchars($get['mttd_q2'], ENT_QUOTES);
		$q3  = htmlspecialchars($get['mttd_q3'], ENT_QUOTES);
		
		$sql = "select a.*, b.nama, b.jabatan, b.gol_kd, case when b.pns_jnsjbtfungsi = 0 then b.gol_pangkatjaksa else b.gol_pangkat2 end as pangkat, 
				c.deskripsi as ttd_jabat from datun.m_penandatangan_pejabat a join kepegawaian.kp_pegawai b on a.nip = b.peg_nip_baru 
				join datun.m_penandatangan c on a.kode_tk = c.kode_tk and a.kode = c.kode where a.kode_tk = '".$_SESSION['kode_tk']."'";
		if($q1)
			$sql .= " and (upper(a.nip) like '".strtoupper($q1)."%' or upper(a.status) like '%".strtoupper($q1)."%' or upper(b.nama) like '%".strtoupper($q1)."%' 
					or upper(b.jabatan) like '%".strtoupper($q1)."%' or upper(b.gol_kd) like '%".strtoupper($q1)."%' or upper(b.gol_pangkatjaksa) like '%".strtoupper($q1)."%' 
					or upper(b.gol_pangkat2) like '%".strtoupper($q1)."%' or upper(c.deskripsi) like '%".strtoupper($q1)."%')";
		if($q2)
			$sql .= " and a.status = '".$q2."'";
		if($q3)
			$sql .= " and a.kode = '".$q3."'";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
        ]);
	
		return $dataProvider;
    }

	
	
    /**
     * @inheritdoc
     * @return MsInstPenyidikQuery the active query used by this AR class.
     */
 
}
