<?php 

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsT4 extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_t4';
    }

	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];
		$sql = "
		select a.nama, b.*
		from pidsus.pds_minta_perpanjang a 
		join pidsus.pds_t4 b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_minta_perpanjang = b.no_minta_perpanjang 
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_spdp = '".$no_spdp."' 
			and a.tgl_spdp = '".$tgl_spdp."'";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by b.tgl_dikeluarkan desc, a.created_date desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
    public function getTersangka($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
		$nom_spdp  	= $_SESSION['no_spdp'];
		$tgl_spdp 	= $_SESSION['tgl_spdp'];
		$nomornya  	= htmlspecialchars($post['idnya'], ENT_QUOTES);
		$where 		= "a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_spdp = '".$nom_spdp."' 
						and a.tgl_spdp = '".$tgl_spdp."'";
		$sqlCek1 	= "
		select case when a.jenis_penahanan = 1 then 'Rutan' when a.jenis_penahanan = 2 then 'Rumah' when a.jenis_penahanan = 3 then 'Kota' end as jenis_thn, 
		a.lokasi_penahanan as lokasi_thn, to_char(a.tgl_mulai_penahanan, 'DD-MM-YYYY') as tgl_mulai_thn, 
		to_char(a.tgl_selesai_penahanan, 'DD-MM-YYYY') as tgl_selesai_thn, to_char(d.tgl_nota, 'DD-MM-YYYY') as tgl_nota, a.nama,
                to_char(d.tgl_awal_permintaan_perpanjangan, 'DD-MM-YYYY') as tgl_awal_permintaan_perpanjangan,
                to_char(d.tgl_akhir_permintaan_perpanjangan, 'DD-MM-YYYY') as tgl_akhir_permintaan_perpanjangan
		from pidsus.pds_minta_perpanjang a
                left join pidsus.pds_nota_pendapat_t4 d on a.id_kejati = d.id_kejati and a.id_kejari = d.id_kejari and a.id_cabjari = d.id_cabjari 
                        and a.no_spdp = d.no_spdp and a.tgl_spdp = d.tgl_spdp and a.no_minta_perpanjang = d.no_minta_perpanjang
		where ".$where." and a.no_minta_perpanjang = '".$nomornya."'";
		$rowCek1 = $connection->createCommand($sqlCek1)->queryOne();
		return $rowCek1;
	}

    public function cekT4($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
		$nom_spdp  	= $_SESSION['no_spdp'];
		$tgl_spdp 	= $_SESSION['tgl_spdp'];

		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$no_mp  	= htmlspecialchars($post['no_minta_perpanjang'], ENT_QUOTES);
		$no_t4 		= htmlspecialchars($post['no_t4'], ENT_QUOTES);
		$where 		= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$nom_spdp."' 
						and tgl_spdp = '".$tgl_spdp."'";

		$sqlCek1 	= "select count(*) from pidsus.pds_t4 where ".$where." and no_t4 = '".$no_t4."'";
		$count1 	= ($isNew)?$connection->createCommand($sqlCek1)->queryScalar():0;

		if($count1 > 0){
			$pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>No Surat dengan nomor '.$no_t4.' sudah ada</i></p>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_t4");
		} else{
			return array("hasil"=>true, "error"=>"", "element"=>"");
		}
	}

	public function simpanData($post){
		$connection 		= $this->db;
		$id_kejati			= $_SESSION['kode_kejati'];
		$id_kejari			= $_SESSION['kode_kejari'];
		$id_cabjari			= $_SESSION['kode_cabjari'];
		$no_spdp			= $_SESSION['no_spdp'];
		$tgl_spdp			= $_SESSION['tgl_spdp'];
		$no_t4_sess			= $_SESSION['t4'];

		$no_minta_perpanjang		= htmlspecialchars($post['no_minta_perpanjang'], ENT_QUOTES);
		$no_t4						= htmlspecialchars($post['no_t4'], ENT_QUOTES);
		$dikeluarkan				= htmlspecialchars($post['lokel'], ENT_QUOTES);
		$tgl_dikeluarkan			= htmlspecialchars($post['tgldittd'], ENT_QUOTES);
		$jenis_penahanan			= htmlspecialchars($post['jenis_penahanan'], ENT_QUOTES);
		$tgl_mulai_penahanan		= htmlspecialchars($post['tgl_mulai_penahanan'], ENT_QUOTES);
		$tgl_selesai_penahanan		= htmlspecialchars($post['tgl_selesai_penahanan'], ENT_QUOTES);
		$lokasi_penahanan			= htmlspecialchars($post['lokasi_penahanan'], ENT_QUOTES);
		
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
		$pathfile	= Yii::$app->params['pdsT4'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_spdp);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_spdp);
		$clean3 	= Yii::$app->inspektur->sanitize_filename($no_t4);
		$newPhoto 	= "t4_".$clean1."-".$clean2."-".$clean3.$extPhoto;
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$no_spdp."' and tgl_spdp = '".$tgl_spdp."'";
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
				$sql1 = "insert into pidsus.pds_t4(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_minta_perpanjang, no_t4, jenis_penahanan, tgl_mulai_penahanan, 
						 tgl_selesai_penahanan, lokasi_penahanan, tgl_dikeluarkan, dikeluarkan, penandatangan_nama, penandatangan_nip, 
						 penandatangan_jabatan_pejabat, penandatangan_gol, penandatangan_pangkat, penandatangan_status_ttd, penandatangan_jabatan_ttd, file_upload_t4, 
						 created_user, created_nip, created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date) values
						 ('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$no_minta_perpanjang."', '".$no_t4."', '".$jenis_penahanan."', 
						 '".$helpernya->tgl_db($tgl_mulai_penahanan)."', '".$helpernya->tgl_db($tgl_selesai_penahanan)."', '".$lokasi_penahanan."', 
						 '".$helpernya->tgl_db($tgl_dikeluarkan)."', '".$dikeluarkan."', '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', 
						 '".$penandatangan_gol."', '".$penandatangan_pangkat."', '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$newPhoto."', 
						 '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload_t4 = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_t4 set no_t4 = '".$no_t4."', jenis_penahanan = '".$jenis_penahanan."', tgl_mulai_penahanan = '".$helpernya->tgl_db($tgl_mulai_penahanan)."', 
						 tgl_selesai_penahanan = '".$helpernya->tgl_db($tgl_selesai_penahanan)."', lokasi_penahanan = '".$lokasi_penahanan."', 
						 tgl_dikeluarkan = '".$helpernya->tgl_db($tgl_dikeluarkan)."', dikeluarkan = '".$dikeluarkan."', penandatangan_nama = '".$penandatangan_nama."', 
						 penandatangan_nip = '".$penandatangan_nip."', penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_minta_perpanjang = '".$no_minta_perpanjang."' and no_t4 = '".$no_t4_sess."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql4 = "delete from pidsus.pds_t4_tembusan where ".$whereDef." and no_minta_perpanjang = '".$no_minta_perpanjang."' and no_t4 = '".$no_t4."'";
			$connection->createCommand($sql4)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql5 = "insert into pidsus.pds_t4_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', 
								'".$no_minta_perpanjang."', '".$no_t4."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql5)->execute();
					}
				}
			}

			//$sqlStatusSpdp = "update pidsus.pds_spdp set status_spdp = 'P-16' where ".$whereDef;
			//$connection->createCommand($sqlStatusSpdp)->execute();

			if($upl1){
				$tmpPot = glob($pathfile."t4_".$clean1."-".$clean2."-".$clean3.".*");
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
		$pathfile		= Yii::$app->params['pdsT4'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload_t4 from pidsus.pds_t4 where ".$whereDefault." and no_minta_perpanjang = '".rawurldecode($tmp[0])."' 
							and no_t4 = '".rawurldecode($tmp[1])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from pidsus.pds_t4 where ".$whereDefault." and no_minta_perpanjang = '".rawurldecode($tmp[0])."' and no_t4 = '".rawurldecode($tmp[1])."'";
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
