<?php
namespace app\modules\datun\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class Permohonan extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'datun.permohonan';
    }

	public function searchPer($params){
		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);

		$sql = "
			with tbl_lawan as(
				select no_register_perkara, no_surat, string_agg(nama_instansi, '#') as lawan_pemohon 
				from datun.lawan_pemohon group by no_register_perkara, no_surat 
			)
			select a.no_register_perkara, a.no_surat, a.tanggal_permohonan, a.status, b.deskripsi_jnsinstansi, c.deskripsi_instansi, d.deskripsi_inst_wilayah, e.lawan_pemohon, 
			a.kode_jenis_instansi  
			from datun.permohonan a 
			join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
			join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk
			join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
				and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut 
			join tbl_lawan e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat
			where 1=1";
		if($q1)
			$sql .= " and (upper(a.no_register_perkara) like '%".strtoupper($q1)."%' or upper(a.no_surat) like '%".strtoupper($q1)."%' 
					  or upper(d.deskripsi_inst_wilayah) like '%".strtoupper($q1)."%' or upper(e.lawan_pemohon) like '%".strtoupper($q1)."%' 
					  or upper(a.status) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tanggal_permohonan desc, a.create_date desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
	public function searchInta($get){
		$id  = htmlspecialchars($get['id'], ENT_QUOTES);
		$q1  = htmlspecialchars($get['jnsins_q1'], ENT_QUOTES);
		$sql = "select a.* from datun.instansi a join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi where a.kode_tk = '".$_SESSION["kode_tk"]."' 
				and a.kode_jenis_instansi = '".$id."'";
		if($q1)
			$sql .= " and (upper(a.deskripsi_instansi) like '%".strtoupper($q1)."%' or a.kode_instansi = '".$q1."')";
		$kueri = $this->db->createCommand("select count(*) from (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.kode_instansi";
		$dataProvider = new SqlDataProvider([
			'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
		]);
		return $dataProvider;
	}

	 public function searchWil($get){
		$id  = htmlspecialchars($get['id'], ENT_QUOTES);
		$ins = htmlspecialchars($get['idins'], ENT_QUOTES);
		$q1  = htmlspecialchars($get['wilins_q1'], ENT_QUOTES);
		$sql = "select a.* from datun.instansi_wilayah a
				join datun.instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi and a.kode_instansi = b.kode_instansi and a.kode_tk = b.kode_tk
				join datun.m_kabupaten c on a.kode_provinsi = c.id_prop and a.kode_kabupaten = c.id_kabupaten_kota
				where a.kode_jenis_instansi = '".$id."' and a.kode_instansi = '".$ins."' and a.kode_tk = '".$_SESSION["kode_tk"]."'";
		if($q1)
			$sql .= " and (upper(a.deskripsi_inst_wilayah) like '%".strtoupper($q1)."%')";
		$kueri = $this->db->createCommand("select count(*) from (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.no_urut";
		$dataProvider = new SqlDataProvider([
			'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
		]);
		return $dataProvider;
    }
	
	public function searchPeng($get){
		$q1  = htmlspecialchars($get['peng_q1'], ENT_QUOTES);
		$sql = "select * from datun.master_pengadilan where 1=1";
		if($q1)
			$sql .= " and (upper(nama_pengadilan) like '%".strtoupper($q1)."%')";
		$kueri = $this->db->createCommand("select count(*) from (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by kode_pengadilan";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
        ]);

        return $dataProvider;
    }

    public function cekPermohonan($post){
		$connection = $this->db;
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$surat  = htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$nomor 	= htmlspecialchars($post['no_reg_perkara'], ENT_QUOTES);
		$status = htmlspecialchars($post['status_pemohon'], ENT_QUOTES);
		$urutan = htmlspecialchars($post['num_status'], ENT_QUOTES);
		$sql 	= "select count(*) from datun.permohonan where no_register_perkara = '".$nomor."' and no_surat = '".$surat."'";
		$count 	= ($isNew)?$connection->createCommand($sql)->queryScalar():0;
		$arrSts = array($status.$urutan);
		$cekSts = true;
		if(count($post['nm_ins']) > 0){
			foreach($post['nm_ins'] as $idx=>$val){
				$nm_ins	 = htmlspecialchars($post['nm_ins'][$idx], ENT_QUOTES);
				$sts 	 = htmlspecialchars($post['sts'][$idx], ENT_QUOTES);
				$urut 	 = htmlspecialchars($post['urut'][$idx], ENT_QUOTES);
				if($nm_ins && $sts && $urut){
					if(!in_array($sts.$urut, $arrSts)) array_push($arrSts, $sts.$urut); 
					else $cekSts = false;
				}
			}
		}
		if($count > 0){
			$pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>* Permohonan dengan nomor '.$surat.' dan nomor perkara '.$nomor.' sudah ada</i></p>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom0");
		} else if(!$cekSts){
			$pesan = '<i style="color:#dd4b39; font-size:12px;">* Data pada tabel tergugat/turut tergugat ada yang sama</i>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom10");
		} else{
			return array("hasil"=>true, "error"=>"", "element"=>"");
		}
	}

	public function simpanData($post){ 
		$connection 			= $this->db;
		$no_register_perkara	= htmlspecialchars($post['no_reg_perkara'], ENT_QUOTES);
		$no_surat				= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$kode_jenis_instansi	= htmlspecialchars($post['jns_instansi'], ENT_QUOTES);
		$kode_instansi			= htmlspecialchars($post['kode_instansi'], ENT_QUOTES);
		$kode_tk				= $_SESSION['kode_tk'];
		$kode_kejati			= $_SESSION['kode_kejati'];
		$kode_kejari			= $_SESSION['kode_kejari'];
		$kode_cabjari			= $_SESSION['kode_cabjari'];
		$kode_provinsi			= htmlspecialchars($post['kode_prop'], ENT_QUOTES);
		$kode_kabupaten			= htmlspecialchars($post['kode_wilayah'], ENT_QUOTES);
		$pimpinan_pemohon		= htmlspecialchars($post['nm_pemimpin'], ENT_QUOTES);
		$status_pemohon			= htmlspecialchars($post['status_pemohon'], ENT_QUOTES);
		$no_status_pemohon		= htmlspecialchars($post['num_status'], ENT_QUOTES);
		$kode_pengadilan_tk1	= htmlspecialchars($post['kode_pengadilan_tk1'], ENT_QUOTES);
		$kode_pengadilan_tk2	= htmlspecialchars($post['kode_pengadilan_tk2'], ENT_QUOTES);
		$tanggal_permohonan		= htmlspecialchars($post['tgl_permohonan'], ENT_QUOTES);
		$nama_pic				= htmlspecialchars($post['nm_pic'], ENT_QUOTES);
		$jabatan_pic			= htmlspecialchars($post['jabatan_pic'], ENT_QUOTES);
		$no_handphone_pic		= htmlspecialchars($post['no_telepon_pic'], ENT_QUOTES);
		$permasalahan_pemohon	= htmlspecialchars($post['permasalahan'], ENT_QUOTES);
		$tanggal_diterima		= htmlspecialchars($post['tgl_diterima'], ENT_QUOTES);
		$no_urut_wil			= htmlspecialchars($post['no_urut_wil'], ENT_QUOTES);
		$tanggal_panggilan_pengadilan	= htmlspecialchars($post['tgl_panggilan'], ENT_QUOTES);
		
		$create_user			= $_SESSION['username'];
		$create_nip				= $_SESSION['nik_user'];
		$create_nama			= $_SESSION['nama_pegawai'];
		$create_ip				= $_SERVER['REMOTE_ADDR'];
		$update_user			= $_SESSION['username'];
		$update_nip				= $_SESSION['nik_user'];
		$update_nama			= $_SESSION['nama_pegawai'];
		$update_ip				= $_SERVER['REMOTE_ADDR'];

		$helpernya	= Yii::$app->inspektur;
		$filePhoto 	= htmlspecialchars($_FILES['file_permohonan']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_permohonan']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_permohonan']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['permohonan'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_register_perkara);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($no_surat);
		$newPhoto 	= "permohonan_".$clean1."-".$clean2.$extPhoto;
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		if(in_array($kode_jenis_instansi,array("01","06")) && $isNew){
			$tm_surat = "select '".$kode_tk.$kode_kejati.$kode_kejari.$kode_cabjari."'||nextval('datun.no_surat_permohonan') as no_urut";
			$no_surat = $connection->createCommand($tm_surat)->queryScalar();
		}

		$transaction = $connection->beginTransaction();
		try{
			if($isNew){
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 = "insert into datun.permohonan(no_register_perkara, no_surat, kode_jenis_instansi, kode_instansi, kode_tk, kode_kejati, kode_kejari, kode_cabjari, kode_provinsi, kode_kabupaten, pimpinan_pemohon, status_pemohon, no_status_pemohon, kode_pengadilan_tk1, kode_pengadilan_tk2, tanggal_permohonan, nama_pic, jabatan_pic, no_handphone_pic, permasalahan_pemohon, tanggal_diterima, tanggal_panggilan_pengadilan, create_user, create_nip, create_nama, create_ip, create_date, update_user, update_nip, update_nama, update_ip, update_date, no_urut_wil, status, file_pemohon) values('".$no_register_perkara."', '".$no_surat."', '".$kode_jenis_instansi."', '".$kode_instansi."', '".$kode_tk."', '".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."', '".$kode_provinsi."', '".$kode_kabupaten."', '".$pimpinan_pemohon."', '".$status_pemohon."', '".$no_status_pemohon."', '".$kode_pengadilan_tk1."', '".$kode_pengadilan_tk2."', '".$helpernya->tgl_db($tanggal_permohonan)."', '".$nama_pic."', '".$jabatan_pic."', '".$no_handphone_pic."', '".$permasalahan_pemohon."', '".$helpernya->tgl_db($tanggal_diterima)."', '".$helpernya->tgl_db($tanggal_panggilan_pengadilan)."', '".$create_user."', '".$create_nip."', '".$create_nama."', '".$create_ip."', NOW(), '".$update_user."', '".$update_nip."', '".$update_nama."', '".$update_ip."', NOW(), '".$no_urut_wil."', 'Permohonan', '".$newPhoto."')";
				} else{
					$upl1 = false;
					$sql1 = "insert into datun.permohonan(no_register_perkara, no_surat, kode_jenis_instansi, kode_instansi, kode_tk, kode_kejati, kode_kejari, kode_cabjari, kode_provinsi, kode_kabupaten, pimpinan_pemohon, status_pemohon, no_status_pemohon, kode_pengadilan_tk1, kode_pengadilan_tk2, tanggal_permohonan, nama_pic, jabatan_pic, no_handphone_pic, permasalahan_pemohon, tanggal_diterima, tanggal_panggilan_pengadilan, create_user, create_nip, create_nama, create_ip, create_date, update_user, update_nip, update_nama, update_ip, update_date, no_urut_wil, status) values('".$no_register_perkara."', '".$no_surat."', '".$kode_jenis_instansi."', '".$kode_instansi."', '".$kode_tk."', '".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."', '".$kode_provinsi."', '".$kode_kabupaten."', '".$pimpinan_pemohon."', '".$status_pemohon."', '".$no_status_pemohon."', '".$kode_pengadilan_tk1."', '".$kode_pengadilan_tk2."', '".$helpernya->tgl_db($tanggal_permohonan)."', '".$nama_pic."', '".$jabatan_pic."', '".$no_handphone_pic."', '".$permasalahan_pemohon."', '".$helpernya->tgl_db($tanggal_diterima)."', '".$helpernya->tgl_db($tanggal_panggilan_pengadilan)."', '".$create_user."', '".$create_nip."', '".$create_nama."', '".$create_ip."', NOW(), '".$update_user."', '".$update_nip."', '".$update_nama."', '".$update_ip."', NOW(), '".$no_urut_wil."', 'Permohonan')";
				}
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 = "update datun.permohonan set kode_jenis_instansi = '".$kode_jenis_instansi."', kode_instansi = '".$kode_instansi."', kode_tk = '".$kode_tk."', kode_kejati = '".$kode_kejati."', kode_kejari = '".$kode_kejari."', kode_cabjari = '".$kode_cabjari."', kode_provinsi = '".$kode_provinsi."', kode_kabupaten = '".$kode_kabupaten."', pimpinan_pemohon = '".$pimpinan_pemohon."', status_pemohon = '".$status_pemohon."', no_status_pemohon = '".$no_status_pemohon."', kode_pengadilan_tk1 = '".$kode_pengadilan_tk1."', kode_pengadilan_tk2 = '".$kode_pengadilan_tk2."', tanggal_permohonan = '".$helpernya->tgl_db($tanggal_permohonan)."', nama_pic = '".$nama_pic."', jabatan_pic = '".$jabatan_pic."', no_handphone_pic = '".$no_handphone_pic."', permasalahan_pemohon = '".$permasalahan_pemohon."', tanggal_diterima = '".$helpernya->tgl_db($tanggal_diterima)."', tanggal_panggilan_pengadilan = '".$helpernya->tgl_db($tanggal_panggilan_pengadilan)."', update_user = '".$update_user."', update_nip = '".$update_nip."', update_nama = '".$update_nama."', update_ip = '".$update_ip."', update_date = NOW(), no_urut_wil = '".$no_urut_wil."', file_pemohon = '".$newPhoto."' where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
				} else{
					$upl1 = false;
					$sql1 = "update datun.permohonan set kode_jenis_instansi = '".$kode_jenis_instansi."', kode_instansi = '".$kode_instansi."', kode_tk = '".$kode_tk."', kode_kejati = '".$kode_kejati."', kode_kejari = '".$kode_kejari."', kode_cabjari = '".$kode_cabjari."', kode_provinsi = '".$kode_provinsi."', kode_kabupaten = '".$kode_kabupaten."', pimpinan_pemohon = '".$pimpinan_pemohon."', status_pemohon = '".$status_pemohon."', no_status_pemohon = '".$no_status_pemohon."', kode_pengadilan_tk1 = '".$kode_pengadilan_tk1."', kode_pengadilan_tk2 = '".$kode_pengadilan_tk2."', tanggal_permohonan = '".$helpernya->tgl_db($tanggal_permohonan)."', nama_pic = '".$nama_pic."', jabatan_pic = '".$jabatan_pic."', no_handphone_pic = '".$no_handphone_pic."', permasalahan_pemohon = '".$permasalahan_pemohon."', tanggal_diterima = '".$helpernya->tgl_db($tanggal_diterima)."', tanggal_panggilan_pengadilan = '".$helpernya->tgl_db($tanggal_panggilan_pengadilan)."', update_user = '".$update_user."', update_nip = '".$update_nip."', update_nama = '".$update_nama."', update_ip = '".$update_ip."', update_date = NOW(), no_urut_wil = '".$no_urut_wil."' where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
				}
			}
			$connection->createCommand($sql1)->execute();

			$sql2 = "delete from datun.turut_tergugat where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['nm_ins']) > 0){
				$noauto	= 0;
				foreach($post['nm_ins'] as $idx=>$val){
					$nm_ins	 = htmlspecialchars($post['nm_ins'][$idx], ENT_QUOTES);
					$sts 	 = htmlspecialchars($post['sts'][$idx], ENT_QUOTES);
					$urut 	 = htmlspecialchars($post['urut'][$idx], ENT_QUOTES);
					if($nm_ins && $sts && $urut){
						$noauto++;
						$sql3 = "insert into datun.turut_tergugat values('".$no_register_perkara."', '".$no_surat."', '".$sts."', '".$urut."', '".$noauto."', '".$nm_ins."')";
						$connection->createCommand($sql3)->execute();
					}
				}
			}

			$sql4 = "delete from datun.lawan_pemohon where no_register_perkara = '".$no_register_perkara."' and no_surat = '".$no_surat."'";
			$connection->createCommand($sql4)->execute();
			if(count($post['nm_lawan']) > 0){
				$noauto	= 0;
				foreach($post['nm_lawan'] as $idx=>$val){
					$nm_lawan= htmlspecialchars($post['nm_lawan'][$idx], ENT_QUOTES);
					if($nm_lawan){
						$noauto++;
						$sql5 = "insert into datun.lawan_pemohon values('".$no_register_perkara."', '".$no_surat."', '".$noauto."', '".$nm_lawan."')";
						$connection->createCommand($sql5)->execute();
					}
				}
			}


			if($upl1){
				$tmpPot = glob($pathfile."permohonan_".$clean1."-".$clean2.".*");
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
		$pathfile	= Yii::$app->params['permohonan'];

		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_pemohon from datun.permohonan where no_register_perkara = '".rawurldecode($tmp[0])."' and no_surat = '".rawurldecode($tmp[1])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from datun.permohonan where no_register_perkara = '".rawurldecode($tmp[0])."' and no_surat = '".rawurldecode($tmp[1])."'";
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

	/* START CRUD DI MODAL INSTANSI */
	public function simpanDataFinstansi($post){
		$connection 	= $this->db;
		$kd_jns			= htmlspecialchars($post['m1_jenis'], ENT_QUOTES);
		$kode_instansi	= htmlspecialchars($post['m1_instansi'], ENT_QUOTES);
		$desc_instansi	= htmlspecialchars($post['m1_deskripsi'], ENT_QUOTES);
		$isNewRecord	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		if($kode_instansi == "" || $desc_instansi == ""){
			return array("hasil"=>false, "error"=>"* Kode dan deskripsi instansi harus diisi");
		} else{
			if($isNewRecord){
				$sqlCek	= "select count(*) as jumlah from datun.instansi where kode_jenis_instansi = '".$kd_jns."' and kode_instansi = '".$kode_instansi."' 
							and kode_tk = '".$_SESSION["kode_tk"]."'";
				$jumlah = $connection->createCommand($sqlCek)->queryScalar();
				if($jumlah > 0){
					return array("hasil"=>false, "error"=>"* Maaf, kode instansi sudah ada");
				} else{
					$sql 	= "insert into datun.instansi values('".$kd_jns."', '".$kode_instansi."', '".$desc_instansi."', '".$_SESSION['kode_tk']."')";
					$hasil 	= $connection->createCommand($sql)->execute();
					return array("hasil"=>$hasil, "error"=>"Maaf, data gagal disimpan");
				}
			} else{
				$sql 	= "update datun.instansi set deskripsi_instansi = '".$desc_instansi."' where kode_jenis_instansi = '".$kd_jns."' and kode_instansi = '".$kode_instansi."' 
							and kode_tk = '".$_SESSION['kode_tk']."'";
				$hasil 	= $connection->createCommand($sql)->execute();
				return array("hasil"=>$hasil, "error"=>"* Maaf, data gagal disimpan");
			}
		}
	}

    public function hapusIns($post){
		$connection = $this->db;
		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
				list($kdins, $desc, $kd) = explode("#", $val);
					$sql1 = "delete from datun.instansi where kode_jenis_instansi = '".$kd."' and kode_instansi='".$kdins."' and kode_tk='".$_SESSION['kode_tk']."'";
					$connection->createCommand($sql1)->execute();
				}
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    }
	/* END CRUD DI MODAL INSTANSI */
	

	/* START CRUD DI MODAL INSTANSI WILAYAH */
    public function getKabupaten($post){
		$tq1 	= htmlspecialchars($post['q1'], ENT_QUOTES);
		$sql 	= "select * from datun.m_kabupaten where id_prop = '".$tq1."'";
		$result	= $this->db->createCommand($sql)->queryAll();
		$answer	= array();
		$answer["items"][] = array("id"=>'', "text"=>'');
		if(count($result) > 0){
			foreach($result as $data){
				$answer["items"][] = array("id"=>$data['id_kabupaten_kota'], "text"=>$data['deskripsi_kabupaten_kota']);
			}
		}
		return $answer;
    }

	public function simpanDataFwilinstansi($post){
		$connection 	= $this->db;
		$kode_tk		= $_SESSION['kode_tk'];
		$m2_jenis		= htmlspecialchars($post['m2_jenis'], ENT_QUOTES);
		$m2_instansi	= htmlspecialchars($post['m2_instansi'], ENT_QUOTES);
		$m2_prop		= htmlspecialchars($post['m2_prop'], ENT_QUOTES);
		$m2_kab			= htmlspecialchars($post['m2_kab'], ENT_QUOTES);
		$m2_inst_wilayah= htmlspecialchars($post['m2_inst_wilayah'], ENT_QUOTES);
		$m2_pimpinan	= htmlspecialchars($post['m2_pimpinan'], ENT_QUOTES);
		$m2_telp		= htmlspecialchars($post['m2_telp'], ENT_QUOTES);
		$m2_alamat		= htmlspecialchars($post['m2_alamat'], ENT_QUOTES);
		$noUrut			= htmlspecialchars($post['no_urut'], ENT_QUOTES);
		$isNewRecord	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		if($m2_jenis == "" || $m2_instansi == "" || $m2_prop == "" || $m2_kab == "" || $m2_inst_wilayah == ""){
			return array("hasil"=>false, "error"=>"* Provinsi, kabupaten, dan nama instansi harus diisi");
		} else{
			if($isNewRecord){
				$sqlCek	= "select max(no_urut) as jumlah from datun.instansi_wilayah where kode_jenis_instansi = '".$m2_jenis."' and kode_instansi = '".$m2_instansi."' 
							and kode_provinsi = '".$m2_prop."' and kode_kabupaten = '".$m2_kab."' and kode_tk = '".$kode_tk."'";
				$jumlah = $connection->createCommand($sqlCek)->queryScalar();
				$noUrut = ($jumlah)?str_pad((intval($jumlah)+1), 4, '0', STR_PAD_LEFT):'0001';

				$sql 	= "insert into datun.instansi_wilayah values('".$m2_jenis."', '".$m2_instansi."', '".$m2_prop."', '".$m2_kab."', '".$kode_tk."', '".$noUrut."', '".$m2_pimpinan."', '".$m2_alamat."', '".$m2_telp."', '".$m2_inst_wilayah."')";
				$hasil 	= $connection->createCommand($sql)->execute();
				return array("hasil"=>$hasil, "error"=>"Maaf, data gagal disimpan");
			} else{
				$sql 	= "update datun.instansi_wilayah set nama = '".$m2_pimpinan."', alamat = '".$m2_alamat."', no_tlp = '".$m2_telp."', deskripsi_inst_wilayah = '".$m2_inst_wilayah."' where kode_jenis_instansi = '".$m2_jenis."' and kode_instansi = '".$m2_instansi."' and kode_provinsi = '".$m2_prop."' and kode_kabupaten = '".$m2_kab."' and kode_tk = '".$kode_tk."' and no_urut = '".$noUrut."'";
				$hasil 	= $connection->createCommand($sql)->execute();
				return array("hasil"=>$hasil, "error"=>$sql);
			}
		}
	}
	
    public function hapusWilIns($post){
		$connection = $this->db;
		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					list($q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9) = explode("#", $val);	
					$sql1 = "delete from datun.instansi_wilayah where kode_jenis_instansi = '".$q8."' and kode_instansi='".$q9."' and kode_provinsi = '".$q1."' 
							 and kode_kabupaten = '".$q2."' and kode_tk = '".$_SESSION['kode_tk']."' and no_urut = '".$q3."'";
					$connection->createCommand($sql1)->execute();
				}
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    }
	/* END CRUD DI MODAL INSTANSI WILAYAH */

	/* START CRUD DI MODAL PENGADILAN */
	public function simpanDataPengadilan($post){
		$connection 	= $this->db;
		$isNewRecord 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$tingkat 		= htmlspecialchars($post['tingkat'], ENT_QUOTES);
		$propinsi 		= htmlspecialchars($post['propinsi'], ENT_QUOTES);
		$kabupaten 		= htmlspecialchars($post['kabupaten'], ENT_QUOTES);
		$deskripsi 		= htmlspecialchars($post['deskripsi'], ENT_QUOTES);
		$alamat 		= htmlspecialchars($post['alamat'], ENT_QUOTES);
		
		if($tingkat == "" || $propinsi == ""){
			return array("hasil"=>false, "error"=>"* Tingkat pengadilan, dan provinsi harus diisi");
		} else if($tingkat == "2" && ($propinsi == "" || $kabupaten == "")){
			return array("hasil"=>false, "error"=>"* Tingkat pengadilan, provinsi, dan kabupaten harus diisi");
		} else{
			$transaction = $connection->beginTransaction();
			try {
				if($isNewRecord){
					if($tingkat == 1){
						$cek1 = "select deskripsi from datun.m_propinsi where id_prop = '".$propinsi."'";
						$prop = $connection->createCommand($cek1)->queryScalar();
						$sql1 = "insert into datun.pengadilan_tk1 values('".$propinsi."', 'Pengadilan Tinggi ".ucwords(strtolower($prop))."', '".$alamat."')";
					} else if($tingkat == 2){
						$cek1 = "select deskripsi_kabupaten_kota from datun.m_kabupaten where id_prop = '".$propinsi."' and id_kabupaten_kota = '".$kabupaten."'";
						$prop = $connection->createCommand($cek1)->queryScalar();
						$sql1 = "insert into datun.pengadilan_tk2 values('".$propinsi."', '".$kabupaten."', 'Pengadilan Negeri ".ucwords(strtolower($prop))."', '".$alamat."')";
					}
				} else{
					if($kabupaten == '00'){
						$sql1 = "update datun.pengadilan_tk1 set deskripsi_tk1 = '".$deskripsi."', alamat = '".$alamat."' where kode_pengadilan_tk1 = '".$propinsi."'";
					} else{
						$sql1 = "update datun.pengadilan_tk2 set deskripsi_tk2 = '".$deskripsi."', alamat = '".$alamat."' where kode_pengadilan_tk1 = '".$propinsi."' 
								and kode_pengadilan_tk2 = '".$kabupaten."'";
					}
				}
				$connection->createCommand($sql1)->execute();
				$transaction->commit();
				return array("hasil"=>true, "error"=>"Maaf, data gagal disimpan");
			} catch (\Exception $e) {
				$transaction->rollBack();
				return array("hasil"=>false, "error"=>"Maaf, data gagal disimpan");
			}
		}
	}
	
    public function hapusPengadilan($post){
		$connection = $this->db;
		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					if($tmp[1] == "00"){
						$sql1 = "delete from datun.pengadilan_tk1 where kode_pengadilan_tk1 = '".$tmp[0]."'";
					} else{
						$sql1 = "delete from datun.pengadilan_tk2 where kode_pengadilan_tk1 = '".$tmp[0]."' and kode_pengadilan_tk2 = '".$tmp[1]."'";
					}
					$connection->createCommand($sql1)->execute();
				}
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    }
	/* END CRUD DI MODAL PENGADILAN */
}
