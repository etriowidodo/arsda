<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class Skks extends \yii\db\ActiveRecord{

    public static function tableName(){
        return 'datun.skk';
    }

    public function search($get){ 
		try{
			$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
			$sql = "
				with tbl_jpn as(
					 select no_register_skks, no_register_skk, tanggal_skk, no_register_perkara, no_surat, string_agg(nama_pegawai, '#') as nama_jpn
					 from datun.skks_anak
					 group by no_register_skks, no_register_skk, tanggal_skk, no_register_perkara, no_surat
				)
				select a.no_register_skk, a.tanggal_skk, a.no_register_skks, a.tanggal_ttd, c.nama_jpn, d.kode_jenis_instansi 
				from datun.skks a 
				join datun.skk b on a.no_register_skk = b.no_register_skk and a.tanggal_skk = b.tanggal_skk and a.no_register_perkara = b.no_register_perkara 
					and a.no_surat = b.no_surat
				join tbl_jpn c on a.no_register_skks = c.no_register_skks and a.no_register_skk = c.no_register_skk and a.tanggal_skk = c.tanggal_skk 
					and a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat
				join datun.permohonan d on a.no_register_perkara = d.no_register_perkara and a.no_surat = d.no_surat
				where a.no_register_skk = '".$_SESSION['no_register_skk']."' and a.tanggal_skk = '".$_SESSION['tanggal_skk']."' and a.no_surat = '".$_SESSION['no_surat']."' 
					and a.no_register_perkara = '".$_SESSION['no_register_perkara']."'";
			if($q1)
				$sql .= " and (upper(a.no_register_skks) like '%".strtoupper($q1)."%' or upper(a.no_register_skk) like '%".strtoupper($q1)."%' 
						  or upper(b.nama_jpn) like '%".strtoupper($q1)."%')";
			
			$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
			$count = $kueri->queryScalar();
			$sql .= " order by a.tanggal_ttd desc, a.created_date desc";
			$dataProvider = new SqlDataProvider([
				'sql' => $sql,
				'totalCount' => $count,
			]);
			return $dataProvider;
		} catch(\Exception $e){
			return false;
		}
    }

    public function getCreateSkk(){
		$sql = "
			with tbl_skks as (
				select a.tanggal_ttd as tanggal_skks, a.no_register_skks, a.kode_tk, a.kode_kejati, a.kode_kejari, a.kode_cabjari, a.penerima_kuasa, 
				b.no_register_skk, b.tanggal_skk, b.no_register_perkara, b.no_surat, b.nama_pegawai, b.jabatan_pegawai, b.alamat_instansi
				from datun.skks a
				join datun.skks_anak b on a.no_register_skks = b.no_register_skks and a.no_register_skk = b.no_register_skk and a.tanggal_skk = b.tanggal_skk 
					and a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat
				where a.penerima_kuasa != 'JPN' and a.no_register_skk = '".$_SESSION['no_register_skk']."' and a.tanggal_skk = '".$_SESSION['tanggal_skk']."' 
					and a.no_register_perkara = '".$_SESSION['no_register_perkara']."' and a.no_surat = '".$_SESSION['no_surat']."' 
				order by a.tanggal_ttd desc, a.created_date desc limit 1
			)
			select coalesce(h.no_register_skk, a.no_register_skk) as no_register_skk, coalesce(h.tanggal_skk, a.tanggal_skk) as tanggal_skk, 
			coalesce(h.no_register_perkara, a.no_register_perkara) as no_register_perkara, coalesce(h.no_surat, a.no_surat) as no_surat, 
			coalesce(h.no_register_skks, a.no_register_skk) as no_register_tmp, 
			coalesce(h.tanggal_skks, a.tanggal_skk) as tanggal_tmp, coalesce(h.kode_tk, a.kode_tk) as kode_tk, coalesce(h.kode_kejati, a.kode_kejati) as kode_kejati, 
			coalesce(h.kode_kejari, a.kode_kejari) as kode_kejari, coalesce(h.kode_cabjari, a.kode_cabjari) as kode_cabjari, 
			coalesce(h.penerima_kuasa, a.penerima_kuasa) as penerima_kuasa_tmp, coalesce(h.nama_pegawai, b.nama_pegawai) as nama_pemberi, 
			coalesce(h.jabatan_pegawai, b.jabatan_pegawai) as jabatan_pemberi, coalesce(h.alamat_instansi, b.alamat_instansi) as alamat_pemberi, 
			c.tanggal_panggilan_pengadilan, c.kode_jenis_instansi, c.pimpinan_pemohon, d.deskripsi_jnsinstansi as jns_instansi, c.permasalahan_pemohon,
			e.deskripsi_instansi as nama_instansi, f.deskripsi_inst_wilayah as wil_instansi, f.alamat as alamat_instansi, g.nama_pengadilan 
			from datun.skk a
			join datun.skk_anak b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat and a.no_register_skk = b.no_register_skk 
				and a.tanggal_skk = b.tanggal_skk
			join datun.permohonan c on a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat 
			join datun.jenis_instansi d on c.kode_jenis_instansi = d.kode_jenis_instansi
			join datun.instansi e on c.kode_jenis_instansi = e.kode_jenis_instansi and c.kode_instansi = e.kode_instansi and c.kode_tk = e.kode_tk
			join datun.instansi_wilayah f on c.kode_jenis_instansi = f.kode_jenis_instansi and c.kode_instansi = f.kode_instansi 
				and c.kode_provinsi = f.kode_provinsi and c.kode_kabupaten = f.kode_kabupaten and c.kode_tk = f.kode_tk and c.no_urut_wil = f.no_urut
			join datun.master_pengadilan g on c.kode_pengadilan_tk1 = g.kode_pengadilan_tk1 and c.kode_pengadilan_tk2 = g.kode_pengadilan_tk2 
			left join tbl_skks h on a.no_register_perkara = h.no_register_perkara and a.no_surat = h.no_surat and a.no_register_skk = h.no_register_skk 
				and a.tanggal_skk = h.tanggal_skk
			where a.no_register_skk = '".$_SESSION['no_register_skk']."' and a.tanggal_skk = '".$_SESSION['tanggal_skk']."' and a.no_surat = '".$_SESSION['no_surat']."' 
				and a.no_register_perkara = '".$_SESSION['no_register_perkara']."'"; 
		$res = $this->db->createCommand($sql)->queryOne();
		$res = ($res['no_register_perkara']?$res:array());
		return $res;
    }

    public function getPenerimaPusat($post){
		$tq1 = htmlspecialchars($post['q1'], ENT_QUOTES);
		$sql = "select a.peg_nip_baru as nip, a.nama, initcap(a.jabatan) as jabatan, b.inst_alamat as alamat 
				from kepegawaian.kp_pegawai a join kepegawaian.kp_inst_satker b on a.inst_satkerkd = b.inst_satkerkd 
				where a.jabat_jenisjabatan = 1 and a.is_verified = 1 and a.ref_jabatan_kd = 3 and unitkerja_kd = '1.5'";
		$res = $this->db->createCommand($sql)->queryOne();
		$res = ($res['nip']?$res:"");
		return $res;
    }

    public function getPegawai($get){
		$jns = htmlspecialchars($get['tipe'], ENT_QUOTES);
		$tq1 = htmlspecialchars($get['mpegq1'], ENT_QUOTES);
		$sql = "
			select a.unitkerja_kd, a.inst_satkerkd, a.peg_nip_baru as nip, a.nama, 
			case when a.jabat_jenisjabatan = 1 and a.ref_jabatan_kd in(12,21,29) then 'Kepala '||initcap(b.inst_nama) 
			else initcap(a.jabatan) end as jabatan_pegawai, b.inst_alamat as alamat 
			from kepegawaian.kp_pegawai a join kepegawaian.kp_inst_satker b on a.inst_satkerkd = b.inst_satkerkd 
			where 1=1";
		if($jns == 'KAJATI')
			$sql .= " and a.jabat_jenisjabatan = 1 and a.ref_jabatan_kd = 12";
		else if($jns == 'KAJARI')
			$sql .= " and a.jabat_jenisjabatan = 1 and a.ref_jabatan_kd = 21";
		else if($jns == 'KACABJARI')
			$sql .= " and a.jabat_jenisjabatan = 1 and a.ref_jabatan_kd = 29";
		if($tq1)
			$sql .= " and (upper(a.peg_nip_baru) like '".strtoupper($tq1)."%' or upper(a.nama) like '%".strtoupper($tq1)."%' or upper(a.jabatan) like '%".strtoupper($tq1)."%' 
					  or upper(b.inst_nama) like '%".strtoupper($tq1)."%')";

		$kueri = $this->db->createCommand("select count(*) from (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.ref_jabatan_kd, a.unitkerja_kd";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
        ]);
        return $dataProvider;
    }

    public function cekSkks($post){
		$helpernya	= Yii::$app->inspektur;
		$connection = $this->db;
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$skks  	= htmlspecialchars($post['nomor_skks'], ENT_QUOTES);
		$nomor 	= $_SESSION['no_register_perkara'];
		$surat  = $_SESSION['no_surat'];
		$skk  	= $_SESSION['no_register_skk'];
		$tglSkk = $_SESSION['tanggal_skk'];
		if(!$isNew) return true;
		else{
			$sql1 = "select count(*) from datun.skks where no_register_skks = '".$skks."' and no_register_skk = '".$skk."' and tanggal_skk = '".$tglSkk."' 
					 and no_register_perkara = '".$nomor."' and no_surat = '".$surat."'";
			$res1 = $connection->createCommand($sql1)->queryScalar();
			$sql2 = "select count(*) from datun.skks where no_register_skks = '".$skks."' and kode_tk = '".$_SESSION['kode_tk']."' and kode_kejati = '".$_SESSION['kode_kejati']."' 
					 and kode_kejari = '".$_SESSION['kode_kejari']."' and kode_cabjari = '".$_SESSION['kode_cabjari']."'";
			$res2 = $connection->createCommand($sql1)->queryScalar();
			return (!$res1 && !$res2);
		}
	}

	public function simpanData($post){
		$helpernya			= Yii::$app->inspektur;
		$connection 		= $this->db;

		$isNewRecord 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_register_skks 	= htmlspecialchars($post['nomor_skks'], ENT_QUOTES);
		$no_perkara 		= $_SESSION['no_register_perkara'];
		$no_surat  			= $_SESSION['no_surat'];
		$no_register_skk  	= $_SESSION['no_register_skk'];
		$tanggal_skk 		= $_SESSION['tanggal_skk'];
		$tanggal_ttd 		= htmlspecialchars($post['tanggal_ttd'], ENT_QUOTES);
		$penerima_kuasa		= htmlspecialchars($post['penerima_kuasa'], ENT_QUOTES);
		$pemberi_kuasa		= htmlspecialchars($post['nomor_tmp'], ENT_QUOTES);

		$created_user		= $_SESSION['username']; 
		$created_nip		= $_SESSION['nik_user'];
		$created_nama		= $_SESSION['nama_pegawai'];
		$created_ip			= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];  
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai']; 
		$updated_ip			= $_SERVER['REMOTE_ADDR'];
		$kode_tk 			= $_SESSION['kode_tk'];
		$kode_kejati 		= $_SESSION['kode_kejati'];
		$kode_kejari 		= $_SESSION['kode_kejari'];
		$kode_cabjari 		= $_SESSION['kode_cabjari'];

		$filePhoto 	= htmlspecialchars($_FILES['file_skks']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_skks']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_skks']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['skks'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_register_skks);
		$newPhoto 	= "skks_".$clean1.$extPhoto;

		$transaction = $connection->beginTransaction();
		try {
			$keyCek1 = "where no_register_skk = '".$no_register_skk."' and tanggal_skk = '".$tanggal_skk."' and no_surat = '".$no_surat."' 
						and no_register_perkara = '".$no_perkara."'";
			$sqlCek1 = "update datun.skks set is_active = 0 ".$keyCek1;
			$connection->createCommand($sqlCek1)->execute();

			if($isNewRecord){
				$sqlCek2 = "update datun.permohonan set status = 'SKKS' where no_register_perkara = '".$no_perkara."' and no_surat = '".$no_surat."'";
				$connection->createCommand($sqlCek2)->execute();
			
				$upl1 = false;
				$sql1 = "insert into datun.skks(no_register_skks, no_register_skk, tanggal_skk, no_register_perkara, no_surat, kode_tk, kode_kejati, kode_kejari, kode_cabjari, 
						tanggal_ttd, penerima_kuasa, pemberi_kuasa, created_user, created_nip, created_nama, created_ip, created_date, updated_user, updated_nip, 
						updated_nama, updated_ip, updated_date";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_skks";
				}
				$sql1 .= ") values('".$no_register_skks."', '".$no_register_skk."', '".$tanggal_skk."', '".$no_perkara."', '".$no_surat."', '".$kode_tk."', '".$kode_kejati."', 
						'".$kode_kejari."', '".$kode_cabjari."', '".$helpernya->tgl_db($tanggal_ttd)."', '".$penerima_kuasa."', '".$pemberi_kuasa."', '".$created_user."', 
						'".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW()";
				
				if($filePhoto != "") $sql1 .= ", '".$newPhoto."'";
				$sql1 .= ")";
			}else{
				$upl1 = false;
				$sql1 = "update datun.skks set penerima_kuasa = '".$penerima_kuasa."', tanggal_ttd = '".$helpernya->tgl_db($tanggal_ttd)."', updated_user = '".$updated_user."', 
						updated_nip = '".$updated_nip."', updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_skks = '".$newPhoto."'";
				}
				$sql1 .= " ".$keyCek1." and no_register_skks = '".$no_register_skks."'";
			}
			$connection->createCommand($sql1)->execute();

			$sqlCek3 = "
				with tbl_max as (
					select no_register_perkara, no_surat, no_register_skk, tanggal_skk, max(tanggal_ttd) as tgl_skks, max(created_date) as tgl_create 
					from datun.skks ".$keyCek1." 
					group by no_register_perkara, no_surat, no_register_skk, tanggal_skk
				)
				select no_register_skks from datun.skks a 
				join tbl_max b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat and a.no_register_skk = b.no_register_skk 
					and a.tanggal_skk = b.tanggal_skk and a.tanggal_ttd = b.tgl_skks and a.created_date = b.tgl_create";
			$nomSkks = $connection->createCommand($sqlCek3)->queryScalar();

			$sqlCek4 = "update datun.skks set is_active = 1 ".$keyCek1." and no_register_skks = '".$nomSkks."'";
			$connection->createCommand($sqlCek4)->execute();
			
			$sql2 = "delete from datun.skks_anak ".$keyCek1." and no_register_skks = '".$no_register_skks."'";
			$connection->createCommand($sql2)->execute();
			if($penerima_kuasa == "JPN"){
				if(count($post['jpnid']) > 0){
					foreach($post['jpnid'] as $idx=>$val){
						list($nip, $nama, $golpangkat, $gol, $pangkat, $jabatan) = explode("#", $val);
						$sql2 = "insert into datun.skks_anak(no_register_skks, no_register_skk, tanggal_skk, no_register_perkara, no_surat, nip_pegawai, nama_pegawai, 
								jabatan_pegawai, pangkat_pegawai, gol_pegawai, no_urut) values('".$no_register_skks."', '".$no_register_skk."', '".$tanggal_skk."', 
								'".$no_perkara."', '".$no_surat."', '".$nip."', '".$nama."', '".$jabatan."', '".$pangkat."', '".$gol."', '".($idx+1)."')";
						$connection->createCommand($sql2)->execute();
					}
				}
			} else{
				if(count($post['nama_penerima']) > 0){
					foreach($post['nama_penerima'] as $idx=>$val){
						$nip 	= htmlspecialchars($post['nip_penerima'][$idx], ENT_QUOTES);
						$nama 	= htmlspecialchars($post['nama_penerima'][$idx], ENT_QUOTES);
						$jbtn	= htmlspecialchars($post['jabatan_penerima'][$idx], ENT_QUOTES);
						$alamat	= htmlspecialchars($post['alamat_penerima'][$idx], ENT_QUOTES);
						$sql2 = "insert into datun.skks_anak(no_register_skks, no_register_skk, tanggal_skk, no_register_perkara, no_surat, nip_pegawai, nama_pegawai, 		
								jabatan_pegawai, alamat_instansi, no_urut) values('".$no_register_skks."', '".$no_register_skk."', '".$tanggal_skk."', '".$no_perkara."', 
								'".$no_surat."', '".$nip."', '".$nama."', '".$jbtn."', '".$alamat."', '".($idx+1)."')";
						$connection->createCommand($sql2)->execute();
					}
				}
			}
			
			if($upl1){
				$tmpPot = glob($pathfile."skks_".$clean1.".*");
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
		$connection = $this->db;
		$pathfile	= Yii::$app->params['skks'];
		$no_perkara = $_SESSION['no_register_perkara'];
		$no_surat  	= $_SESSION['no_surat'];
		$no_skk 	= $_SESSION['no_register_skk'];
		$tgl_skk 	= $_SESSION['tanggal_skk'];

		$transaction = $connection->beginTransaction();
		try {
			$keyCek1 = "where no_register_skk = '".$no_skk."' and tanggal_skk = '".$tgl_skk."' and no_surat = '".$no_surat."' and no_register_perkara = '".$no_perkara."'";
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$kue1 = "select file_skks, is_active from datun.skks ".$keyCek1." and no_register_skks = '".rawurldecode($val)."'";
					$res1 = $connection->createCommand($kue1)->queryOne();
					if(!$res1['is_active']){
						$transaction->rollBack();
						return false;
					} else{
						$file = $res1['file_skks'];
						if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);
	
						$sql1 = "delete from datun.skks ".$keyCek1." and no_register_skks = '".rawurldecode($val)."'";
						$connection->createCommand($sql1)->execute();
					}
				}
			}
			$sqlCek1 = "update datun.skks set is_active = 0 ".$keyCek1;
			$connection->createCommand($sqlCek1)->execute();

			$sqlCek2 = "select max(tanggal_ttd) from datun.skks ".$keyCek1;
			$sqlCek2 = "
				with tbl_max as (
					select no_register_perkara, no_surat, no_register_skk, tanggal_skk, max(tanggal_ttd) as tgl_skks, max(created_date) as tgl_create 
					from datun.skks ".$keyCek1." 
					group by no_register_perkara, no_surat, no_register_skk, tanggal_skk
				)
				select no_register_skks from datun.skks a 
				join tbl_max b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat and a.no_register_skk = b.no_register_skk 
					and a.tanggal_skk = b.tanggal_skk and a.tanggal_ttd = b.tgl_skks and a.created_date = b.tgl_create";
			$nomSkks = $connection->createCommand($sqlCek2)->queryScalar();

			$sqlCek3 = "update datun.skks set is_active = 1 ".$keyCek1." and no_register_skks = '".$nomSkks."'";
			$connection->createCommand($sqlCek3)->execute();

			if(!$nomSkks){
				$sql2 = "update datun.permohonan set status = 'SKK' where no_register_perkara = '".$no_perkara."' and no_surat = '".$no_surat."'";
				$connection->createCommand($sql2)->execute();
			}

			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }
}
