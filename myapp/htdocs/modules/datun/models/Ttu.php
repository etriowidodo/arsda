<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class Ttu extends \yii\db\ActiveRecord{

    public static function tableName(){
        return 'datun.surat_tanda_terima_telaah';
    }

    public function search($get){
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$sql = "
			select a.*, b.tanggal_permohonan, b.status as status_data, c.deskripsi_tahap_bankum as bantuan_hukum
			from datun.skk a 
			join datun.permohonan b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
			join datun.tr_tahap_bankum c on a.kode_tahap_bankum = c.kode_tahap_bankum
			where 1=1";
		if($q1)
			$sql .= " and (upper(a.no_register_perkara) like '%".strtoupper($q1)."%' or upper(a.no_surat) like '%".strtoupper($q1)."%' 
					or upper(a.no_register_skk) like '%".strtoupper($q1)."%' or upper(c.deskripsi_tahap_bankum) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tanggal_skk desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 20],
        ]);

        return $dataProvider;
    }

    public function getPermohonan($get){
		$q1  = htmlspecialchars($get['m1q1'], ENT_QUOTES);
		$sql = "
			with tbl_lawan as(
				select no_register_perkara, no_surat, string_agg(nama_instansi, '#') as lawan_pemohon 
				from datun.lawan_pemohon group by no_register_perkara, no_surat 
			)
			select a.no_register_perkara, a.no_surat, a.pimpinan_pemohon, b.deskripsi_jnsinstansi, c.deskripsi_instansi, 
			d.deskripsi_inst_wilayah, d.alamat as alamat_instansi, e.inst_nama as diterima_satker, e.inst_lokinst, e.inst_alamat as alamat_penerima_kuasa, 
			f.nama_pengadilan, a.tanggal_panggilan_pengadilan, g.peg_nip_baru as nip_penerima_kuasa, g.nama as nama_penerima_kuasa, g.jabatan as jabatan_penerima_kuasa, 
			a.kode_jenis_instansi, a.kode_tk, i.lawan_pemohon, 'Terima'::character varying(10) as status_telaah 
			from datun.permohonan a
			join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
			join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi
			join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
				and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.no_urut_wil = d.no_urut
			join kepegawaian.kp_inst_satker e on a.kode_tk = e.kode_tk and a.kode_kejati = e.kode_kejati and a.kode_kejari = e.kode_kejari and a.kode_cabjari = e.kode_cabjari
			join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
			join tbl_lawan i on a.no_register_perkara = i.no_register_perkara and a.no_surat = i.no_surat
			left join kepegawaian.kp_pegawai g on g.jabat_jenisjabatan = 1 and g.ref_jabatan_kd in (1,12,21,29) 
				and g.inst_satkerkd = '".$_SESSION['inst_satkerkd']."' and g.is_verified = 1
			left join datun.keputusan_telaah h on a.no_register_perkara = h.no_register_perkara and a.no_surat = h.no_surat 
			where (h.is_approved = 1 or a.kode_jenis_instansi = '06')";
		if($q1)
			$sql .= " and (upper(a.no_register_perkara) like '%".strtoupper($q1)."%' or upper(a.no_surat) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("select count(*) from (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tanggal_diterima desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
        ]);
        return $dataProvider;
    }

    public function getPenerimaPusat($post){
		$tq1 = htmlspecialchars($post['q1'], ENT_QUOTES);
		$sql = "select a.peg_nip_baru as nip, a.nama, initcap(a.jabatan) as jabatan, b.inst_alamat as alamat 
					from kepegawaian.kp_pegawai a join kepegawaian.kp_inst_satker b on a.inst_satkerkd = b.inst_satkerkd 
					where a.inst_satkerkd = '".$_SESSION["inst_satkerkd"]."' and a.jabat_jenisjabatan = 1 and a.is_verified = 1";
		if($tq1 == "JA"){
			$sql .= " and a.ref_jabatan_kd = 1";
		} else if($tq1 == "JAMDATUN"){
			$sql .= " and a.ref_jabatan_kd = 3 and unitkerja_kd = '1.5'";
		}
		$res = $this->db->createCommand($sql)->queryOne();
		$res = ($res['nip']?$res:"");
		return $res;
    }

    public function getPegawai($get){
		$tq1 = htmlspecialchars($get['m2q1'], ENT_QUOTES);
		$sql = "select a.peg_nip_baru as nip, a.nama, initcap(a.jabatan) as jabatan, b.inst_alamat as alamat 
				from kepegawaian.kp_pegawai a join kepegawaian.kp_inst_satker b on a.inst_satkerkd = b.inst_satkerkd 
				where a.inst_satkerkd = '".$_SESSION["inst_satkerkd"]."'";
		if($tq1)
			$sql .= " and (upper(a.peg_nip_baru) like '".strtoupper($tq1)."%' or upper(a.nama) like '%".strtoupper($tq1)."%' or upper(a.jabatan) like '%".strtoupper($tq1)."%')";

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

    public function cekSkk($post){
		$helpernya	= Yii::$app->inspektur;
		$connection = $this->db;
		$isNew	= htmlspecialchars($post['isNew'], ENT_QUOTES);
		$q1  	= htmlspecialchars($post['q1'], ENT_QUOTES);
		$q2  	= htmlspecialchars($post['q2'], ENT_QUOTES);
		$q3  	= htmlspecialchars($post['q3'], ENT_QUOTES);
		$q4  	= htmlspecialchars($post['q4'], ENT_QUOTES);
		$sql 	= "select count(*) from datun.skk where no_register_skk = '".$q1."' and tanggal_skk = '".$helpernya->tgl_db($q2)."' 
				   and no_register_perkara = '".$q3."' and no_surat = '".$q4."'";
		$count 	= ($isNew)?$connection->createCommand($sql)->queryScalar():0;
		return $count;
	}

	public function simpanData($post){
		$helpernya			= Yii::$app->inspektur;
		$connection 		= $this->db;

		$isNewRecord 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_register_skk 	= htmlspecialchars($post['nomor_skk'], ENT_QUOTES);
		$tanggal_skk 		= htmlspecialchars($post['tanggal_skk'], ENT_QUOTES);
		$no_perkara 		= htmlspecialchars($post['no_perkara'], ENT_QUOTES);
		$no_surat 			= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$kode_tahap_bankum 	= htmlspecialchars($post['tahap_bankum'], ENT_QUOTES);
		$tanggal_diterima 	= htmlspecialchars($post['tanggal_diterima'], ENT_QUOTES);
		$tanggal_ttd 		= htmlspecialchars($post['tanggal_ttd'], ENT_QUOTES);
		$penerima_kuasa 	= htmlspecialchars($post['penerima_kuasa'], ENT_QUOTES);

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

		$filePhoto 	= htmlspecialchars($_FILES['file_skk']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_skk']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_skk']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['skk'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_register_skk);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tanggal_skk);
		$newPhoto 	= "skk_".$clean1."-".$clean2.$extPhoto;

		
		$transaction = $connection->beginTransaction();
		try {
			$sqlUpdate = "update datun.permohonan set status = 'SKK' where no_register_perkara = '".$no_perkara."' and no_surat = '".$no_surat."'";
			$connection->createCommand($sqlUpdate)->execute();
			
			if($isNewRecord){
				$upl1 = false;
				$sql1 = "insert into datun.skk(no_register_skk, tanggal_skk, no_register_perkara, no_surat, kode_tk, kode_kejati, kode_kejari, kode_cabjari, 
						kode_tahap_bankum, tanggal_diterima, tanggal_ttd, created_user, created_nip, created_nama, created_ip, created_date, updated_user, updated_nip, 
						updated_nama, updated_ip, updated_date, penerima_kuasa";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_skk";
				}
				$sql1 .= ") values('".$no_register_skk."', '".$helpernya->tgl_db($tanggal_skk)."', '".$no_perkara."', '".$no_surat."', '".$kode_tk."', '".$kode_kejati."', 
						'".$kode_kejari."', '".$kode_cabjari."', '".$kode_tahap_bankum."','".$helpernya->tgl_db($tanggal_diterima)."', 
						NULLIF('".$helpernya->tgl_db($tanggal_ttd)."', '')::date, '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						'".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW(), '".$penerima_kuasa."'";
				
				if($filePhoto != "") $sql1 .= ", '".$newPhoto."'";
				$sql1 .= ")";
			}else{
				$upl1 = false;
				$sql1 = "update datun.skk set penerima_kuasa = '".$penerima_kuasa."', kode_tahap_bankum = '".$kode_tahap_bankum."', 
						tanggal_diterima = '".$helpernya->tgl_db($tanggal_diterima)."', tanggal_ttd = NULLIF('".$helpernya->tgl_db($tanggal_ttd)."', '')::date, 
						updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', updated_nama = '".$updated_nama."', 
						updated_ip = '".$updated_ip."', updated_date = NOW()";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_skk = '".$newPhoto."'";
				}
				$sql1 .= " where no_register_skk = '".$no_register_skk."' and tanggal_skk = '".$helpernya->tgl_db($tanggal_skk)."' and no_surat = '".$no_surat."' 
							and no_register_perkara = '".$no_perkara."'";
			}
			$connection->createCommand($sql1)->execute();
			
			$sql2 = "delete from datun.skk_anak where no_register_skk = '".$no_register_skk."' and tanggal_skk = '".$helpernya->tgl_db($tanggal_skk)."' 
					and no_surat = '".$no_surat."' and no_register_perkara = '".$no_perkara."'";
			$connection->createCommand($sql2)->execute();
			if($penerima_kuasa == "JPN"){
				if(count($post['jpnid']) > 0){
					foreach($post['jpnid'] as $idx=>$val){
						list($nip, $nama, $golpangkat, $gol, $pangkat, $jabatan) = explode("#", $val);
						$sql2 = "insert into datun.skk_anak(no_register_skk, tanggal_skk, no_register_perkara, no_surat, nip_pegawai, nama_pegawai, jabatan_pegawai, 
								pangkat_pegawai, gol_pegawai) values('".$no_register_skk."', '".$helpernya->tgl_db($tanggal_skk)."', '".$no_perkara."', '".$no_surat."', 
								'".$nip."', '".$nama."', '".$jabatan."', '".$pangkat."', '".$gol."')";
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
						$sql2 = "insert into datun.skk_anak(no_register_skk, tanggal_skk, no_register_perkara, no_surat, nip_pegawai, nama_pegawai, jabatan_pegawai, 
								alamat_instansi) values('".$no_register_skk."', '".$helpernya->tgl_db($tanggal_skk)."', '".$no_perkara."', '".$no_surat."', 
								'".$nip."', '".$nama."', '".$jbtn."', '".$alamat."')";
						$connection->createCommand($sql2)->execute();
					}
				}
			}
			
			if($upl1){
				$tmpPot = glob($pathfile."skk_".$clean1."-".$clean2.".*");
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
			throw $e; exit();
			return false;
		}
    }

    public function hapusData($post){
		$connection = $this->db;
		$pathfile	= Yii::$app->params['skk'];

		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_skk from datun.skk where no_register_perkara = '".rawurldecode($tmp[0])."' and no_surat = '".rawurldecode($tmp[1])."' 
							and no_register_skk = '".rawurldecode($tmp[2])."' and tanggal_skk = '".rawurldecode($tmp[3])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from datun.skk where no_register_perkara = '".rawurldecode($tmp[0])."' and no_surat = '".rawurldecode($tmp[1])."' 
							and no_register_skk = '".rawurldecode($tmp[2])."' and tanggal_skk = '".rawurldecode($tmp[3])."'";
					$connection->createCommand($sql1)->execute();
				}
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			throw $e; exit;
			return false;
		}
    }
}
