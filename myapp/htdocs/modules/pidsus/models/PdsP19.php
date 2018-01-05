<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsP19 extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p16';
    }

	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];
		$no_berkas	= $_SESSION['no_berkas'];

		$sql = "
			select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, to_char(a.tgl_berkas, 'DD-MM-YYYY') as tgl_berkas, 
			b.no_pengantar, to_char(b.tgl_terima, 'DD-MM-YYYY') as tgl_terima, f.no_surat as no_p18, to_char(f.tgl_dikeluarkan, 'DD-MM-YYYY') as tgl_p18, h.nama as instansi_ip, 
			i.no_surat as no_p19, to_char(i.tgl_dikeluarkan, 'DD-MM-YYYY') as tgl_p19
			from pidsus.pds_terima_berkas a
			join pidsus.pds_spdp g on a.id_kejati = g.id_kejati and a.id_kejari = g.id_kejari and a.id_cabjari = g.id_cabjari 
				and a.no_spdp = g.no_spdp and a.tgl_spdp = g.tgl_spdp 
			join pidsus.ms_inst_penyidik h on g.id_asalsurat = h.kode_ip 
			join pidsus.pds_terima_berkas_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas 
			join pidsus.pds_ceklist_tahap1 c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
				and b.no_spdp = c.no_spdp and b.tgl_spdp = c.tgl_spdp and b.no_berkas = c.no_berkas and b.no_pengantar = c.no_pengantar
			join pidsus.pds_ceklist_tahap1 d on b.id_kejati = d.id_kejati and b.id_kejari = d.id_kejari and b.id_cabjari = d.id_cabjari 
				and b.no_spdp = d.no_spdp and b.tgl_spdp = d.tgl_spdp and b.no_berkas = d.no_berkas and b.no_pengantar = d.no_pengantar 
			join pidsus.pds_p24 e on b.id_kejati = e.id_kejati and b.id_kejari = e.id_kejari and b.id_cabjari = e.id_cabjari 
				and b.no_spdp = e.no_spdp and b.tgl_spdp = e.tgl_spdp and b.no_berkas = e.no_berkas and b.no_pengantar = e.no_pengantar and e.id_hasil = 2 
			join pidsus.pds_p18 f on e.id_kejati = f.id_kejati and e.id_kejari = f.id_kejari and e.id_cabjari = f.id_cabjari 
				and e.no_spdp = f.no_spdp and e.tgl_spdp = f.tgl_spdp and e.no_berkas = f.no_berkas and e.no_pengantar = f.no_pengantar 
			join pidsus.pds_p19 i on f.id_kejati = i.id_kejati and f.id_kejari = i.id_kejari and f.id_cabjari = i.id_cabjari 
				and f.no_spdp = i.no_spdp and f.tgl_spdp = i.tgl_spdp and f.no_berkas = i.no_berkas and f.no_pengantar = i.no_pengantar 
			where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_spdp = '".$no_spdp."' 
				and a.tgl_spdp = '".$tgl_spdp."' and a.no_berkas = '".$no_berkas."'";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by i.tgl_dikeluarkan desc, i.created_date desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
    public function cekP19($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
		$nom_spdp  	= $_SESSION['no_spdp'];
		$tgl_spdp 	= $_SESSION['tgl_spdp'];

		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$nom_p16  	= htmlspecialchars($post['no_berkas'], ENT_QUOTES);
		$nom_p19  	= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$tgldittd  	= htmlspecialchars($post['tgldittd'], ENT_QUOTES);
		$tgl_p18  	= htmlspecialchars($post['tgl_p18'], ENT_QUOTES);
		$where 		= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$nom_spdp."' 
						and tgl_spdp = '".$tgl_spdp."'";

		$sqlCek1 	= "select count(*) from pidsus.pds_p19 where ".$where." and no_berkas = '".$nom_p16."' and no_surat = '".$nom_p19."'";
		$count1 	= ($isNew)?$connection->createCommand($sqlCek1)->queryScalar():0;

		if($count1 > 0){
			$pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>Maaf nomor sudah dipakai</i></p>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_surat");
		} else{
			return array("hasil"=>true, "error"=>"", "element"=>"");
		}
	}

	public function simpanData($post){
		$connection = $this->db;
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];
		$no_surat_sess	= $_SESSION['no_surat'];
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_berkas			= htmlspecialchars($post['no_berkas'], ENT_QUOTES);
		$no_p18				= htmlspecialchars($post['no_p18'], ENT_QUOTES);
		$no_pengantar		= htmlspecialchars($post['no_pengantar'], ENT_QUOTES);
		$no_surat			= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$dikeluarkan		= htmlspecialchars($post['lokel'], ENT_QUOTES);
		$tgl_dikeluarkan	= htmlspecialchars($post['tgldittd'], ENT_QUOTES);
		$sifat				= htmlspecialchars($post['sifat'], ENT_QUOTES);
		$kepada				= htmlspecialchars($post['kepada'], ENT_QUOTES);
		$lampiran			= htmlspecialchars($post['lampiran'], ENT_QUOTES);
		$di_kepada			= htmlspecialchars($post['di_kepada'], ENT_QUOTES);
		$perihal			= htmlspecialchars($post['perihal'], ENT_QUOTES);
		$petunjuk 			= str_replace(array("'"), array("&#039;"), $post['petunjuk']);
		
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
		$pathfile	= Yii::$app->params['p19'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_spdp);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_spdp);
		$clean3 	= Yii::$app->inspektur->sanitize_filename($no_surat);
		$newPhoto 	= "p19_".$clean1."-".$clean2."-".$clean3.$extPhoto;

		$NextProcces = array("1384", "1421");

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
				$sql1 = "insert into pidsus.pds_p19(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_p18, no_surat, sifat, lampiran, tgl_dikeluarkan, 
						 dikeluarkan, kepada, di_kepada, no_pengantar, petunjuk, penandatangan_nama, penandatangan_nip, penandatangan_jabatan_pejabat, penandatangan_gol, 
						 penandatangan_pangkat, penandatangan_status_ttd, penandatangan_jabatan_ttd, file_upload_p19, created_user, created_nip, created_nama, created_ip, 
						 created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date) values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', 
						 '".$no_spdp."', '".$tgl_spdp."', '".$no_berkas."', '".$no_p18."', '".$no_surat."', '".$sifat."', '".$lampiran."', 
						 '".$helpernya->tgl_db($tgl_dikeluarkan)."', '".$dikeluarkan."', '".$kepada."', '".$di_kepada."', '".$no_pengantar."', '".$petunjuk."', 
						 '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', 
						 '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$newPhoto."', 
						 '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload_p19 = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_p19 set no_surat = '".$no_surat."', tgl_dikeluarkan = '".$helpernya->tgl_db($tgl_dikeluarkan)."', sifat = '".$sifat."', kepada = '".$kepada."', 
						 lampiran = '".$lampiran."', di_kepada = '".$di_kepada."', penandatangan_nama = '".$penandatangan_nama."', 
						 penandatangan_nip = '".$penandatangan_nip."', penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_berkas = '".$no_berkas."' and no_surat = '".$no_surat_sess."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql4 = "delete from pidsus.pds_p19_tembusan where ".$whereDef." and no_berkas = '".$no_berkas."' and no_surat = '".$no_surat."'";
			$connection->createCommand($sql4)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql5 = "insert into pidsus.pds_p19_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', 
								 '".$no_berkas."', '".$no_surat."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql5)->execute();
					}
				}
			}

			foreach($NextProcces as $idmenu){
				if($idmenu){
					$sqlP = "insert into pidsus.pds_trx_pemrosesan(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, id_menu, id_user_login, durasi)
							 values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$idmenu."', 'trigger', NOW())";
					$connection->createCommand($sqlP)->execute();
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."p19_".$clean1."-".$clean2."-".$clean3.".*");
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
		$pathfile		= Yii::$app->params['p19'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload_p19 from pidsus.pds_p19 where ".$whereDefault." and no_berkas = '".rawurldecode($tmp[0])."' 
							and no_surat = '".rawurldecode($tmp[1])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from pidsus.pds_p19 where ".$whereDefault." and no_berkas = '".rawurldecode($tmp[0])."' and no_surat = '".rawurldecode($tmp[1])."'";
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
