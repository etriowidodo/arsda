<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsPengembalianSpdp extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_spdp_kembali';
    }

	public function searchPer($params){
		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$arr 	= array("JANUARI"=>"01", "FEBRUARI"=>"02", "MARET"=>"03", "APRIL"=>"04", "MEI"=>"05", "JUNI"=>"06", "JULI"=>"07", "AGUSTUS"=>"08", "SEPTEMBER"=>"09", 
				"OKTOBER"=>"10", "NOVEMBER"=>"11", "DESEMBER"=>"12");
		$tmp1 	= str_replace(array("/", " "), array("-","-"), strtoupper($q1));
		$tmp2 	= str_replace(array_keys($arr), $arr, strtoupper($tmp1));

		$sql = "
		with tbl_tersangka as(
				select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, string_agg(no_urut||'. '||nama, '<br />' order by no_urut) as tersangka 
				from pidsus.pds_spdp_tersangka group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp
		), tbl_tersangka_berkas as(
			select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, string_agg(no_urut||'. '||nama, '<br />' order by no_urut) as tersangka_berkas
			from(
				select distinct id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_urut, nama 
				from pidsus.pds_terima_berkas_tersangka 
			) a
			group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp
		)
		select a.*, b.nama as inst_penyidik, c.nama as inst_pelak_penyidikan, e.tersangka, d.tersangka_berkas, f.no_spdp_kembali, f.tgl_dikeluarkan as tgl_spdp_kembali 
		from pidsus.pds_spdp a 
		join pidsus.ms_inst_penyidik b on a.id_asalsurat = b.kode_ip
		join pidsus.ms_inst_pelak_penyidikan c on a.id_asalsurat = c.kode_ip and a.id_penyidik = c.kode_ipp 
		join pidsus.pds_spdp_kembali f on a.id_kejati = f.id_kejati and a.id_kejari = f.id_kejari and a.id_cabjari = f.id_cabjari and a.no_spdp = f.no_spdp 
			and a.tgl_spdp = f.tgl_spdp 
		left join tbl_tersangka e on a.id_kejati = e.id_kejati and a.id_kejari = e.id_kejari and a.id_cabjari = e.id_cabjari and a.no_spdp = e.no_spdp and a.tgl_spdp = e.tgl_spdp 
		left join tbl_tersangka_berkas d on a.id_kejati = d.id_kejati and a.id_kejari = d.id_kejari and a.id_cabjari = d.id_cabjari and a.no_spdp = d.no_spdp 
			and a.tgl_spdp = d.tgl_spdp 
		where 1=1";
		
		if($q1)
			$sql .= " and (upper(c.nama) like '%".strtoupper($q1)."%' or upper(a.no_spdp) like '%".strtoupper($q1)."%' or to_char(a.tgl_spdp, 'DD-MM-YYYY') = '".$q1."' 
					  or to_char(a.tgl_terima, 'DD-MM-YYYY') = '".$q1."' or upper(e.tersangka) like '%".strtoupper($q1)."%' or upper(a.undang_pasal) like '%".strtoupper($q1)."%' 
					  or upper(d.tersangka_berkas) like '%".strtoupper($q1)."%' or upper(a.tempat_kejadian) like '%".strtoupper($q1)."%' 
					  or upper(a.tgl_kejadian_perkara) like '%-".$tmp2."%' or upper(f.no_spdp_kembali) like '%".strtoupper($q1)."%' 
					  or to_char(f.tgl_dikeluarkan, 'DD-MM-YYYY') = '".$q1."')";//echo $sql; exit;

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_terima desc, a.tgl_spdp desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

	public function getSpdp($get){
		$q1  = htmlspecialchars($get['mspdp_q1'], ENT_QUOTES);
		$sql = "
		with tbl_tersangka as(
				select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, string_agg(nama, '#' order by no_urut) as tersangka 
				from pidsus.pds_spdp_tersangka group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp
		), tbl_tersangka_berkas as(
			select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, string_agg(nama, '#' order by no_urut) as tersangka_berkas
			from(
				select distinct id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_urut, nama 
				from pidsus.pds_terima_berkas_tersangka 
			) a
			group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp
		)
		select a.*, e.tersangka, d.tersangka_berkas 
		from pidsus.pds_spdp a
		join tbl_tersangka e on a.id_kejati = e.id_kejati and a.id_kejari = e.id_kejari and a.id_cabjari = e.id_cabjari and a.no_spdp = e.no_spdp and a.tgl_spdp = e.tgl_spdp 
		left join tbl_tersangka_berkas d on a.id_kejati = d.id_kejati and a.id_kejari = d.id_kejari and a.id_cabjari = d.id_cabjari and a.no_spdp = d.no_spdp 
			and a.tgl_spdp = d.tgl_spdp 
		left join pidsus.pds_spdp_kembali f on a.id_kejati = f.id_kejati and a.id_kejari = f.id_kejari and a.id_cabjari = f.id_cabjari and a.no_spdp = f.no_spdp 
			and a.tgl_spdp = f.tgl_spdp 
		where 1=1 and f.no_spdp is null"; 
		if($q1)
			$sql .= " and (upper(a.no_spdp) like '%".strtoupper($q1)."%' or to_char(a.tgl_spdp, 'DD-MM-YYYY') = '".$q1."')";
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

    public function cekSpdpKembali($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];

		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$nom_spdp  	= htmlspecialchars($post['no_spdp'], ENT_QUOTES);
		$tgl_spdp 	= htmlspecialchars($post['tgl_spdp'], ENT_QUOTES);
		$surat 		= htmlspecialchars($post['no_spdp_kembali'], ENT_QUOTES);
		$where 		= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$nom_spdp."' 
						and tgl_spdp = '".$helpernya->tgl_db($tgl_spdp)."'";

		$sqlCek1 	= "select count(*) from pidsus.pds_spdp_kembali where ".$where." and no_spdp_kembali = '".$surat."'";
		$count1 	= ($isNew)?$connection->createCommand($sqlCek1)->queryScalar():0;
		if($count > 0){
			$pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>* Nomor surat dengan nomor '.$surat.' sudah ada</i></p>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_spdp_kembali");
		} else{
			return array("hasil"=>true, "error"=>"", "element"=>"");
		}
	}

	public function simpanData($post){
		$connection 		= $this->db;
		$id_kejati			= $_SESSION['kode_kejati'];
		$id_kejari			= $_SESSION['kode_kejari'];
		$id_cabjari			= $_SESSION['kode_cabjari'];
		$no_spdp			= htmlspecialchars($post['no_spdp'], ENT_QUOTES);
		$tgl_spdp			= htmlspecialchars($post['tgl_spdp'], ENT_QUOTES);

		$no_spdp_kembali	= htmlspecialchars($post['no_spdp_kembali'], ENT_QUOTES);
		$dikeluarkan		= htmlspecialchars($post['lokel'], ENT_QUOTES);
		$tgl_dikeluarkan	= htmlspecialchars($post['tgldittd'], ENT_QUOTES);
		$sifat				= htmlspecialchars($post['sifat'], ENT_QUOTES);
		$kepada				= htmlspecialchars($post['kepada'], ENT_QUOTES);
		$lampiran			= htmlspecialchars($post['lampiran'], ENT_QUOTES);
		$di_kepada			= htmlspecialchars($post['di_kepada'], ENT_QUOTES);
		$perihal			= htmlspecialchars($post['perihal'], ENT_QUOTES);
		$alasan                         = htmlspecialchars($post['alasan'], ENT_QUOTES);
		
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
		$pathfile	= Yii::$app->params['spdp_kembali'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_spdp);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_spdp);
		$clean3 	= Yii::$app->inspektur->sanitize_filename($no_spdp_kembali);
		$newPhoto 	= "Pengembalian_SPDP_".$clean1."-".$clean2."-".$clean3.$extPhoto;
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$no_spdp."' 
					 and tgl_spdp = '".$helpernya->tgl_db($tgl_spdp)."'";
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
				$sql1 = "insert into pidsus.pds_spdp_kembali(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_spdp_kembali, dikeluarkan, tgl_dikeluarkan, sifat, kepada, 
						 lampiran, di_kepada, perihal, penandatangan_nama, penandatangan_nip, penandatangan_jabatan_pejabat, penandatangan_gol, penandatangan_pangkat, 
						 penandatangan_status_ttd, penandatangan_jabatan_ttd, file_upload_spdp_kembali, created_user, created_nip, created_nama, created_ip, created_date, 
						 updated_user, updated_nip, updated_nama, updated_ip, updated_date, alasan)
						 values ('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$helpernya->tgl_db($tgl_spdp)."', '".$no_spdp_kembali."', 
						 '".$dikeluarkan."', '".$helpernya->tgl_db($tgl_dikeluarkan)."', '".$sifat."', '".$kepada."', '".$lampiran."', '".$di_kepada."', '".$perihal."', 
						 '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', 
						 '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$newPhoto."', '".$created_user."', '".$created_nip."', '".$created_nama."', 
						 '".$created_ip."', NOW(), '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW(), '".$alasan."')";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload_spdp_kembali = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_spdp_kembali set no_spdp_kembali = '".$no_spdp_kembali."', tgl_dikeluarkan = '".$helpernya->tgl_db($tgl_dikeluarkan)."', sifat = '".$sifat."', kepada = '".$kepada."', 
						 lampiran = '".$lampiran."', di_kepada = '".$di_kepada."', perihal = '".$perihal."', penandatangan_nama = '".$penandatangan_nama."', 
						 penandatangan_nip = '".$penandatangan_nip."', penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya.", alasan = '".$alasan."' 
						 where ".$whereDef;
			}
			$connection->createCommand($sql1)->execute();

			$sql2 = "delete from pidsus.pds_spdp_kembali_tembusan where ".$whereDef." and no_spdp_kembali = '".$no_spdp_kembali."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql3 = "insert into pidsus.pds_spdp_kembali_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', 
								 '".$helpernya->tgl_db($tgl_spdp)."', '".$no_spdp_kembali."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql3)->execute();
					}
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."Pengembalian_SPDP_".$clean1."-".$clean2."-".$clean3.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto;
				$mantab  = move_uploaded_file($tempPhoto, $tujuan);
				if(file_exists($tempPhoto)) unlink($tempPhoto);
			}
			$transaction->commit();
			return array("hasil"=>1, "no_spdp"=>$no_spdp, "tgl_spdp"=>$helpernya->tgl_db($tgl_spdp));
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return array("hasil"=>0);}
		}
    }

    public function hapusData($post){
        $connection = $this->db;
        $id_kejati  = $_SESSION['kode_kejati'];
        $id_kejari  = $_SESSION['kode_kejari'];
        $id_cabjari = $_SESSION['kode_cabjari'];
        $helpernya	= Yii::$app->inspektur;
        $pathfile	= Yii::$app->params['spdp_kembali'];
        $transaction = $connection->beginTransaction();
        try {
            if(count($post['id']) > 0){
                foreach($post['id'] as $idx=>$val){
                    $tmp = explode("|#|", $val);
                    $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' 
								 and no_spdp = '".rawurldecode($tmp[0])."' and tgl_spdp = '".$helpernya->tgl_db(date("d-m-Y", strtotime(rawurldecode($tmp[1]))))."'";
                    
                    $kue = "select file_upload_spdp_kembali from pidsus.pds_spdp_kembali where ".$whereDef;
                    $file = $connection->createCommand($kue)->queryScalar();
                    if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);
                    
                    $sql = "delete from pidsus.pds_spdp_kembali where ".$whereDef;
                    $connection->createCommand($sql)->execute();
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
