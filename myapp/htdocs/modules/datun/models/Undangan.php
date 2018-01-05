<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\HtmlPurifier;
use app\components\InspekturComponent;

class Undangan extends \yii\db\ActiveRecord{

    public static function tableName(){
        return 'datun.surat_undangan_telaah';
    }

    public function search($get){
		$q1  	= htmlspecialchars($get['q1'], ENT_QUOTES);
		$where 	= "";
		if($q1)
			$where = "and (upper(a.no_surat_undangan) like '%".strtoupper($q1)."%' or upper(a.acara) like '%".strtoupper($q1)."%' or upper(a.hari) like '%".strtoupper($q1)."%' or upper(a.tempat) like '%".strtoupper($q1)."%' or upper(a.bertemu) like '%".strtoupper($q1)."%')";
		$sql = "
			select a.no_surat_undangan, a.tanggal_surat_undangan, a.hari, a.tanggal, a.tempat, a.waktu, a.acara, a.bertemu, a.created_date, '1' as tahap_undangan
			from datun.surat_undangan_telaah a 
			where no_register_perkara = '".$_SESSION['no_register_perkara']."' and no_surat = '".$_SESSION['no_surat']."' ".$where." 
			union all
			select a.no_surat_undangan, a.tanggal_surat_undangan, a.hari, a.tanggal, a.tempat, a.waktu, a.acara, a.bertemu, a.created_date, '2' as tahap_undangan
			from datun.surat_undangan_sidang a 
			where no_register_perkara = '".$_SESSION['no_register_perkara']."' and no_surat = '".$_SESSION['no_surat']."' 
				and no_register_skk = '".$_SESSION['no_register_skk']."' and tanggal_skk = NULLIF ('".$_SESSION['tanggal_skk']."', '')::date ".$where;

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by tanggal_surat_undangan desc, created_date desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

    public function getUndangan($post){
		$tq1 = htmlspecialchars($post['q1'], ENT_QUOTES);
		if($tq1 == 1){
			$sql = "
				with tbl_sp1 as(
					 select a.no_register_perkara, a.no_surat, a.tanggal_ttd as tanggal_sp1, b.nama||' Dkk' as bertemu 
					 from datun.sp1 a join datun.sp1_timjpn b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
					 where a.no_register_perkara = '".$_SESSION['no_register_perkara']."' and a.no_surat = '".$_SESSION['no_surat']."' limit 1
				), 
				tbl_lawan as(
					 select no_register_perkara, no_surat, string_agg(nama_instansi, '#') as penggugat
					 from datun.lawan_pemohon group by no_register_perkara, no_surat
				)
				select a.no_register_perkara, a.no_surat, to_char(a.tanggal_permohonan, 'DD-MM-YYYY') as tgl_permohonan, to_char(a.tanggal_diterima, 'DD-MM-YYYY') as tgl_diterima, 
				b.deskripsi_jnsinstansi as jns_instansi, c.deskripsi_instansi as nama_instansi, d.deskripsi_inst_wilayah as wil_instansi, e.penggugat, f.tanggal_sp1, f.bertemu, 
				b.kode_jenis_instansi 
				from datun.permohonan a 
				join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
				join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk
				join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
					and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut 
				join tbl_lawan e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat
				left join tbl_sp1 f on a.no_register_perkara = f.no_register_perkara and a.no_surat = f.no_surat
				where a.no_register_perkara = '".$_SESSION['no_register_perkara']."' and a.no_surat = '".$_SESSION['no_surat']."'";
		} else if($tq1 == 2){
			$sql = "
				with tbl_lawan as(
					 select no_register_perkara, no_surat, string_agg(nama_instansi, '#') as penggugat
					 from datun.lawan_pemohon group by no_register_perkara, no_surat
				)
				select f.no_register_perkara, f.no_surat, to_char(a.tanggal_permohonan, 'DD-MM-YYYY') as tgl_permohonan, to_char(a.tanggal_diterima, 'DD-MM-YYYY') as tgl_diterima, 
				b.deskripsi_jnsinstansi as jns_instansi, c.deskripsi_instansi as nama_instansi, d.deskripsi_inst_wilayah as wil_instansi, e.penggugat, f.no_register_skk, 
				to_char(f.tanggal_skk, 'DD-MM-YYYY') as tgl_skk, g.no_register_skks, to_char(g.tanggal_ttd, 'DD-MM-YYYY') as tgl_skks, 
				coalesce(i.nama_pegawai, h.nama_pegawai) as bertemu, b.kode_jenis_instansi 
				from datun.permohonan a 
				join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
				join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk
				join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
					and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut 
				join tbl_lawan e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat 
				join datun.skk f on a.no_register_perkara = f.no_register_perkara and a.no_surat = f.no_surat
				join datun.skk_anak h on f.no_register_perkara = h.no_register_perkara and f.no_surat = h.no_surat and f.no_register_skk = h.no_register_skk 
					and f.tanggal_skk = h.tanggal_skk
				left join datun.skks g on f.no_register_perkara = g.no_register_perkara and f.no_surat = g.no_surat and f.no_register_skk = g.no_register_skk 
					and f.tanggal_skk = g.tanggal_skk and g.is_active = 1 
				left join datun.skks_anak i on g.no_register_perkara = i.no_register_perkara and g.no_surat = i.no_surat and g.no_register_skk = i.no_register_skk 
					and g.tanggal_skk = i.tanggal_skk and g.no_register_skks = i.no_register_skks 
				where f.no_register_perkara = '".$_SESSION['no_register_perkara']."' and f.no_surat = '".$_SESSION['no_surat']."' 
					and f.no_register_skk = '".$_SESSION['no_register_skk']."' and f.tanggal_skk = '".$_SESSION['tanggal_skk']."'";
		}
		$res = $this->db->createCommand($sql)->queryOne();
		$res = ($res['no_register_perkara']?$res:"");
		return $res;
    }

    public function cekUndangan($post){
		$helpernya	= Yii::$app->inspektur;
		$connection = $this->db;
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$jenis  = htmlspecialchars($post['tahap_undangan'], ENT_QUOTES);
		$nomor  = htmlspecialchars($post['no_perkara'], ENT_QUOTES);
		$surat  = htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$skk  	= htmlspecialchars($post['no_skk'], ENT_QUOTES);
		$tglSkk = htmlspecialchars($post['tanggal_skk'], ENT_QUOTES);
		$undang = htmlspecialchars($post['no_und'], ENT_QUOTES);
		if($jenis == 1){
			$sql = "select count(*) from datun.surat_undangan_telaah where no_register_perkara = '".$nomor."' and no_surat = '".$surat."' and no_surat_undangan = '".$undang."'";
		} else if($jenis == 2){
			$sql = "select count(*) from datun.surat_undangan_sidang where no_register_skk = '".$skk."' and tanggal_skk = '".$helpernya->tgl_db($tglSkk)."' and 
					no_register_perkara = '".$nomor."' and no_surat = '".$surat."' and no_surat_undangan = '".$undang."'";
		}
		$count 	= ($isNew)?$connection->createCommand($sql)->queryScalar():0;
		return $count;
	}

	public function simpanData($post){
		$helpernya			= Yii::$app->inspektur;
		$connection 		= $this->db;

		$isNewRecord 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_surat_undangan 	= htmlspecialchars($post['no_und'], ENT_QUOTES);
		$no_perkara 		= htmlspecialchars($post['no_perkara'], ENT_QUOTES);
		$no_surat  			= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$no_register_skk  	= htmlspecialchars($post['no_skk'], ENT_QUOTES);
		$tanggal_skk 		= htmlspecialchars($post['tanggal_skk'], ENT_QUOTES);
		$jenis  			= htmlspecialchars($post['tahap_undangan'], ENT_QUOTES);
		$sifat 				= htmlspecialchars($post['sifat_und'], ENT_QUOTES);
		$tanggal_undangan 	= htmlspecialchars($post['tanggal_surat_und'], ENT_QUOTES);
		$lampiran 			= htmlspecialchars($post['lampiran_und'], ENT_QUOTES);
		$perihal 			= htmlspecialchars($post['perihal'], ENT_QUOTES);
		$kepada_yth 		= htmlspecialchars($post['untuk'], ENT_QUOTES);
		$di 				= htmlspecialchars($post['tempat'], ENT_QUOTES);
		$hari 				= htmlspecialchars($post['hari_und'], ENT_QUOTES);
		$tanggal 			= htmlspecialchars($post['tgl_und'], ENT_QUOTES);
		$waktu 				= htmlspecialchars($post['jam_und'], ENT_QUOTES);
		$acara 				= htmlspecialchars($post['acara_und'], ENT_QUOTES); 
		$tempat 			= htmlspecialchars($post['tempat_und'], ENT_QUOTES);
		$bertemu 			= htmlspecialchars($post['bertemu'], ENT_QUOTES);
		$penandatangan_status 	= htmlspecialchars($post['penandatangan_status'], ENT_QUOTES);
		$penandatangan_nip 		= htmlspecialchars($post['penandatangan_nip'], ENT_QUOTES);
		$penandatangan_nama 	= htmlspecialchars($post['penandatangan_nama'], ENT_QUOTES);
		$penandatangan_jabatan 	= htmlspecialchars($post['penandatangan_jabatan'], ENT_QUOTES);
		$penandatangan_gol 		= htmlspecialchars($post['penandatangan_gol'], ENT_QUOTES);
		$penandatangan_pangkat 	= htmlspecialchars($post['penandatangan_pangkat'], ENT_QUOTES);
		$penandatangan_ttdjabat = htmlspecialchars($post['penandatangan_ttdjabat'], ENT_QUOTES);

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

		$filePhoto 	= htmlspecialchars($_FILES['file_undangan']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_undangan']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_undangan']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= ($jenis == 1)?Yii::$app->params['s3_siap']:Yii::$app->params['s3_sidang'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_perkara);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_surat);
		$clean3 	= Yii::$app->inspektur->sanitize_filename($no_surat_undangan);
		$newPhoto 	= "S3_".$clean1."-".$clean2."-".$clean3.$extPhoto;

		$transaction = $connection->beginTransaction();
		try {
			$keyCek1 = "where no_register_perkara = '".$no_perkara."' and no_surat = '".$no_surat."'";
			$keyCek2 = " and no_register_skk = '".$no_register_skk."' and tanggal_skk = '".$helpernya->tgl_db($tanggal_skk)."'";
			$arr_tbl = array(1=>"datun.surat_undangan_telaah", "datun.surat_undangan_sidang");

			if($isNewRecord){
				$upl1 = false;
				$sql1 = "insert into ".$arr_tbl[$jenis]."(no_surat_undangan, no_register_perkara, no_surat, kode_tk, kode_kejati, kode_kejari, kode_cabjari, 
						 tanggal_surat_undangan, sifat, lampiran, perihal, kepada_yth, di, hari, tanggal, waktu, tempat, acara, penandatangan_status, penandatangan_nama, 
						 penandatangan_nip, penandatangan_jabatan, penandatangan_gol, penandatangan_pangkat, penandatangan_ttdjabat, bertemu, created_user, created_nip, 
						 created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date";
				if($jenis == "2") $sql1 .= ", no_register_skk, tanggal_skk";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_undangan";
				}
				$sql1 .= ") values('".$no_surat_undangan."', '".$no_perkara."', '".$no_surat."', '".$kode_tk."', '".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."', 
						'".$helpernya->tgl_db($tanggal_undangan)."', '".$sifat."', '".$lampiran."', '".$perihal."', '".$kepada_yth."', '".$di."', '".$hari."', 
						'".$helpernya->tgl_db($tanggal)."', '".$waktu."', '".$tempat."', '".$acara."', '".$penandatangan_status."', '".$penandatangan_nama."', 
						'".$penandatangan_nip."', '".$penandatangan_jabatan."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', '".$penandatangan_ttdjabat."', 
						'".$bertemu."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), '".$updated_user."', '".$updated_nip."', 
						'".$updated_nama."', '".$updated_ip."', NOW()";
				
				if($jenis == "2") $sql1 .= ", '".$no_register_skk."', '".$helpernya->tgl_db($tanggal_skk)."'";
				if($filePhoto != "") $sql1 .= ", '".$newPhoto."'";
				$sql1 .= ")";
			}else{
				$upl1 = false;
				$sql1 = "update ".$arr_tbl[$jenis]." set tanggal_surat_undangan = '".$helpernya->tgl_db($tanggal_undangan)."', sifat = '".$sifat."', lampiran = '".$lampiran."', 
						perihal = '".$perihal."', kepada_yth = '".$kepada_yth."', di = '".$di."', hari = '".$hari."', tanggal = '".$helpernya->tgl_db($tanggal)."', 
						waktu = '".$waktu."', tempat = '".$tempat."', penandatangan_status = '".$penandatangan_status."', penandatangan_nama = '".$penandatangan_nama."', 
						penandatangan_nip = '".$penandatangan_nip."', penandatangan_jabatan = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_ttdjabat = '".$penandatangan_ttdjabat."', bertemu = '".$bertemu."', 
						acara = '".$acara."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', updated_nama = '".$updated_nama."', 
						updated_ip = '".$updated_ip."', updated_date = NOW()";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_undangan = '".$newPhoto."'";
				}
				$sql1 .= " ".$keyCek1." and no_surat_undangan = '".$no_surat_undangan."'";
				if($jenis == "2") $sql1 .= " ".$keyCek2;
			}
			$connection->createCommand($sql1)->execute();
			
			if($jenis == 1)
				$asg3 = "delete from datun.surat_undangan_telaah_tembusan ".$keyCek1." and no_surat_undangan = '".$no_surat_undangan."'";
			else if($jenis ==2)
				$asg3 = "delete from datun.surat_undangan_sidang_tembusan ".$keyCek1." ".$keyCek2." and no_surat_undangan = '".$no_surat_undangan."'";
			$connection->createCommand($asg3)->execute();
			
			if(count($post['nama_tembusan']) > 0){
				$noauto	= 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan = htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){
						$noauto++;
						if($jenis == 1)
							$sql3 = "insert into datun.surat_undangan_telaah_tembusan values('".$no_surat_undangan."', '".$no_perkara."', '".$no_surat."', '".$noauto."', 
							'".$nama_tembusan."')";
						else if($jenis ==2)
							$sql3 = "insert into datun.surat_undangan_sidang_tembusan values('".$no_surat_undangan."', '".$no_perkara."', '".$no_surat."', '".$no_register_skk."', 
							'".$helpernya->tgl_db($tanggal_skk)."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql3)->execute();
					}
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."S3_".$clean1."-".$clean2."-".$clean3.".*");
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
		$no_perkara = $_SESSION['no_register_perkara'];
		$no_surat  	= $_SESSION['no_surat'];
		$no_skk 	= $_SESSION['no_register_skk'];
		$tgl_skk 	= $_SESSION['tanggal_skk'];

		$transaction = $connection->beginTransaction();
		try {
			$keyCek1 = "where no_register_perkara = '".$no_perkara."' and no_surat = '".$no_surat."'";
			$keyCek2 = " and no_register_skk = '".$no_skk."' and tanggal_skk = '".$tgl_skk."'";
			$arrTbl1 = array(1=>"datun.surat_undangan_telaah", "datun.surat_undangan_sidang");
			$arrTbl2 = array(1=>"datun.surat_tanda_terima_telaah", "datun.surat_tanda_terima_sidang");

			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					list($undangan, $tipe) = explode("#", $val);

					$pathfile = (rawurldecode($tipe) == 1)?Yii::$app->params['s3_siap']:Yii::$app->params['s3_sidang'];
					$sqlHapus = "select file_undangan from ".$arrTbl1[rawurldecode($tipe)]." ".$keyCek1." and no_surat_undangan = '".rawurldecode($undangan)."'";
					if(rawurldecode($tipe) == 2) $sqlHapus .= $keyCek2;
					$file = $connection->createCommand($sqlHapus)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$pathfile2 = (rawurldecode($tipe) == 1)?Yii::$app->params['s4_siap']:Yii::$app->params['s4_sidang'];
					$sqlHapus2 = "select file_ttd from ".$arrTbl2[rawurldecode($tipe)]." ".$keyCek1." and no_surat_undangan = '".rawurldecode($undangan)."'";
					if(rawurldecode($tipe) == 2) $sqlHapus2 .= $keyCek2;
					$file2 = $connection->createCommand($sqlHapus2)->queryScalar();
					if($file2 && file_exists($pathfile2.$file2)) unlink($pathfile2.$file2);

					$sql1 = "delete from ".$arrTbl1[rawurldecode($tipe)]." ".$keyCek1." and no_surat_undangan = '".rawurldecode($undangan)."'";
					if(rawurldecode($tipe) == 2) $sql1 .= " ".$keyCek2;
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

	public function simpanDataTtd($post){
		$helpernya			= Yii::$app->inspektur;
		$connection 		= $this->db;

		$isNewRecord 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$jenis  			= htmlspecialchars($post['jns_undangan'], ENT_QUOTES);
		$no_surat_undangan 	= htmlspecialchars($post['no_surat_undangan'], ENT_QUOTES);
		$no_perkara 		= $_SESSION['no_register_perkara'];
		$no_surat  			= $_SESSION['no_surat'];
		$no_register_skk  	= $_SESSION['no_register_skk'];
		$tanggal_skk 		= $_SESSION['tanggal_skk'];
		$nama 				= htmlspecialchars($post['nama'], ENT_QUOTES);
		$pekerjaan 			= htmlspecialchars($post['pekerjaan'], ENT_QUOTES);
		$hubungan_dengan_su = htmlspecialchars($post['hubungan'], ENT_QUOTES);
		$alamat 			= htmlspecialchars($post['alamat'], ENT_QUOTES);
		$hari 				= htmlspecialchars($post['hari'], ENT_QUOTES);
		$jam 				= htmlspecialchars($post['jam'], ENT_QUOTES);
		$tanggal 			= htmlspecialchars($post['tanggal_tanda_terima'], ENT_QUOTES);

		$filePhoto 	= htmlspecialchars($_FILES['file_ttd']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_ttd']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_ttd']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= ($jenis == 1)?Yii::$app->params['s4_siap']:Yii::$app->params['s4_sidang'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_perkara);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_surat);
		$clean3 	= Yii::$app->inspektur->sanitize_filename($no_surat_undangan);
		$newPhoto 	= "S4_".$clean1."-".$clean2."-".$clean3.$extPhoto;

		$transaction = $connection->beginTransaction();
		try {
			$keyCek1 = "where no_register_perkara = '".$no_perkara."' and no_surat = '".$no_surat."'";
			$keyCek2 = " and no_register_skk = '".$no_register_skk."' and tanggal_skk = '".$tanggal_skk."'";
			$arr_tbl = array(1=>"datun.surat_tanda_terima_telaah", "datun.surat_tanda_terima_sidang");

			if($isNewRecord){
				$upl1 = false;
				$sql1 = "insert into ".$arr_tbl[$jenis]."(no_surat_undangan, no_register_perkara, no_surat, nama, pekerjaan, hubungan_dengan_su, alamat, hari, 
						jam, tanggal_tanda_terima";
				if($jenis == "2") $sql1 .= ", no_register_skk, tanggal_skk";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_ttd";
				}
				$sql1 .= ") values('".$no_surat_undangan."', '".$no_perkara."', '".$no_surat."', '".$nama."', '".$pekerjaan."', '".$hubungan_dengan_su."', '".$alamat."', 
						'".$hari."', '".$jam."', '".$helpernya->tgl_db($tanggal)."'";				
				if($jenis == "2") $sql1 .= ", '".$no_register_skk."', '".$tanggal_skk."'";
				if($filePhoto != "") $sql1 .= ", '".$newPhoto."'";
				$sql1 .= ")";
			}else{
				$upl1 = false;
				$sql1 = "update ".$arr_tbl[$jenis]." set tanggal_tanda_terima = '".$helpernya->tgl_db($tanggal)."', nama = '".$nama."', pekerjaan = '".$pekerjaan."', 
						hubungan_dengan_su = '".$hubungan_dengan_su."', alamat = '".$alamat."', hari = '".$hari."', jam = '".$jam."'";
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 .= ", file_ttd = '".$newPhoto."'";
				}
				$sql1 .= " ".$keyCek1." and no_surat_undangan = '".$no_surat_undangan."'";
				if($jenis == "2") $sql1 .= " ".$keyCek2;
			}
			$connection->createCommand($sql1)->execute();
			
			if($upl1){
				$tmpPot = glob($pathfile."S4_".$clean1."-".$clean2."-".$clean3.".*");
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
