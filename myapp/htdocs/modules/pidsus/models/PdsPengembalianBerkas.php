<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsPengembalianBerkas extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p16';
    }

	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		
		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "
		with tbl_brks_tsk as(
			select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, string_agg(no_urut||'--'||nama, '#') as tersangka
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
		select a.no_berkas, a.tgl_berkas, b.tersangka, a.no_spdp, a.tgl_spdp, d.nama as inst_pelak_penyidikan, c.tgl_terima, f.no_surat, f.tgl_dikeluarkan 
		from pidsus.pds_terima_berkas a 
		join pidsus.pds_pengembalian_berkas f on a.id_kejati = f.id_kejati and a.id_kejari = f.id_kejari and a.id_cabjari = f.id_cabjari 
			and a.no_spdp = f.no_spdp and a.tgl_spdp = f.tgl_spdp and a.no_berkas = f.no_berkas
		left join tbl_brks_tsk b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas
		left join pidsus.pds_spdp c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari 
			and a.no_spdp = c.no_spdp and a.tgl_spdp = c.tgl_spdp
		left join pidsus.ms_inst_pelak_penyidikan d on c.id_asalsurat=d.kode_ip and c.id_penyidik=d.kode_ipp
		left join tbl_brks_uu e on a.id_kejati = e.id_kejati and a.id_kejari = e.id_kejari and a.id_cabjari = e.id_cabjari 
			and a.no_spdp = e.no_spdp and a.tgl_spdp = e.tgl_spdp and a.no_berkas = e.no_berkas
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
	
	public function getBerkas($get){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		
		$q1  = htmlspecialchars($get['mspdp_q1'], ENT_QUOTES);
		$sql = "
		with tbl_brks_tsk as(
			select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, string_agg(no_urut||'--'||nama, '#' order by no_urut) as tersangka
			from(
				select distinct id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_urut, nama 
				from pidsus.pds_terima_berkas_tersangka 
			) a
			group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas 
		), tbl_brks_uu as(
			select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, string_agg(no_urut||'--'||undang||'--'||pasal, '#') as undang_pasal
			from(
				select distinct id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_urut, undang, pasal 
				from pidsus.pds_terima_berkas_pengantar_uu 
			) a
			group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas 
		)
		select a.no_berkas, a.tgl_berkas, b.tersangka, a.no_spdp, a.tgl_spdp, d.nama as inst_pelak_penyidikan, c.tgl_terima
		from pidsus.pds_terima_berkas a 
		left join tbl_brks_tsk b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas
		left join pidsus.pds_spdp c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari 
			and a.no_spdp = c.no_spdp and a.tgl_spdp = c.tgl_spdp
		left join pidsus.ms_inst_pelak_penyidikan d on c.id_asalsurat=d.kode_ip and c.id_penyidik=d.kode_ipp
		left join tbl_brks_uu e on a.id_kejati = e.id_kejati and a.id_kejari = e.id_kejari and a.id_cabjari = e.id_cabjari 
			and a.no_spdp = e.no_spdp and a.tgl_spdp = e.tgl_spdp and a.no_berkas = e.no_berkas 
		left join pidsus.pds_pengembalian_berkas f on a.id_kejati = f.id_kejati and a.id_kejari = f.id_kejari and a.id_cabjari = f.id_cabjari 
			and a.no_spdp = f.no_spdp and a.tgl_spdp = f.tgl_spdp and a.no_berkas = f.no_berkas
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and f.no_berkas is null";
		if($q1)
			$sql .= " and (upper(a.no_berkas) like '%".strtoupper($q1)."%' or to_char(a.tgl_berkas, 'DD-MM-YYYY') = '".$q1."' 
					or upper(b.tersangka) like '%".strtoupper($q1)."%' or upper(a.no_spdp) like '%".strtoupper($q1)."%' or to_char(a.tgl_spdp, 'DD-MM-YYYY') = '".$q1."')";
		
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_berkas desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
        ]);
        return $dataProvider;
    }

    public function cekPengembalianBerkas($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];

		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$nom_spdp  	= htmlspecialchars($post['no_spdp'], ENT_QUOTES);
		$tgl_spdp 	= htmlspecialchars($post['tgl_spdp'], ENT_QUOTES);
		$no_berkas 	= htmlspecialchars($post['no_berkas'], ENT_QUOTES);
		$where 		= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$nom_spdp."' 
						and tgl_spdp = '".$helpernya->tgl_db($tgl_spdp)."' and no_berkas = '".$no_berkas."'";

		$sqlCek1 	= "select count(*) from pidsus.pds_pengembalian_berkas where ".$where;
		$count1 	= ($isNew)?$connection->createCommand($sqlCek1)->queryScalar():0;
		if($count > 0){
			$pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>* Maaf, pengembalian berkas hanya ada 1 kali saja</i></p>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_surat");
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
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_spdp			= htmlspecialchars($post['no_spdp'], ENT_QUOTES);
		$tgl_spdp			= htmlspecialchars($post['tgl_spdp'], ENT_QUOTES);
		$no_berkas			= htmlspecialchars($post['no_berkas'], ENT_QUOTES);
		$no_surat			= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$dikeluarkan		= htmlspecialchars($post['lokel'], ENT_QUOTES);
		$tgl_dikeluarkan	= htmlspecialchars($post['tgldittd'], ENT_QUOTES);
		$sifat				= htmlspecialchars($post['sifat'], ENT_QUOTES);
		$kepada				= htmlspecialchars($post['kepada'], ENT_QUOTES);
		$lampiran			= htmlspecialchars($post['lampiran'], ENT_QUOTES);
		$di_kepada			= htmlspecialchars($post['di_kepada'], ENT_QUOTES);
		$perihal			= htmlspecialchars($post['perihal'], ENT_QUOTES);
		$alasan				= str_replace(array("'"), array("&#039;"), $post['alasan']);
		
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

		
		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['pengembalian_berkas'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_spdp);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_spdp);
		$clean3 	= Yii::$app->inspektur->sanitize_filename($no_berkas);
		$newPhoto 	= "Pengembalian_berkas_".$clean1."-".$clean2."-".$clean3.$extPhoto;

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
				$sql1 = "insert into pidsus.pds_pengembalian_berkas(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_surat, dikeluarkan, tgl_dikeluarkan, sifat, 
						 kepada, lampiran, di_kepada, perihal, alasan, penandatangan_nama, penandatangan_nip, penandatangan_jabatan_pejabat, penandatangan_gol, 
						 penandatangan_pangkat, penandatangan_status_ttd, penandatangan_jabatan_ttd, file_upload_berkas_kembali, created_user, created_nip, created_nama, 
						 created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date)
						 values ('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$helpernya->tgl_db($tgl_spdp)."', '".$no_berkas."', '".$no_surat."', 
						 '".$dikeluarkan."', '".$helpernya->tgl_db($tgl_dikeluarkan)."', '".$sifat."', '".$kepada."', '".$lampiran."', '".$di_kepada."', '".$perihal."', 
						 '".$alasan."', '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', 
						 '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$newPhoto."', '".$created_user."', '".$created_nip."', '".$created_nama."', 
						 '".$created_ip."', NOW(), '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload_berkas_kembali = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_pengembalian_berkas set no_surat = '".$no_surat."', tgl_dikeluarkan = '".$helpernya->tgl_db($tgl_dikeluarkan)."', sifat = '".$sifat."', 
						 kepada = '".$kepada."', lampiran = '".$lampiran."', di_kepada = '".$di_kepada."', perihal = '".$perihal."', alasan = '".$alasan."', 
						 penandatangan_nama = '".$penandatangan_nama."', penandatangan_nip = '".$penandatangan_nip."', 
						 penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_berkas = '".$no_berkas."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql2 = "delete from pidsus.pds_pengembalian_berkas_tembusan where ".$whereDef." and no_berkas = '".$no_berkas."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql3 = "insert into pidsus.pds_pengembalian_berkas_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', 
								 '".$helpernya->tgl_db($tgl_spdp)."', '".$no_berkas."', '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql3)->execute();
					}
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."Pengembalian_berkas_".$clean1."-".$clean2."-".$clean3.".*");
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
        $id_kejati  = $_SESSION['kode_kejati'];
        $id_kejari  = $_SESSION['kode_kejari'];
        $id_cabjari = $_SESSION['kode_cabjari'];
        $helpernya	= Yii::$app->inspektur;
        $pathfile	= Yii::$app->params['pengembalian_berkas'];
        $transaction = $connection->beginTransaction();
        try {
            if(count($post['id']) > 0){
                foreach($post['id'] as $idx=>$val){
                    $tmp = explode("#", $val);
                    $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' 
								 and no_spdp = '".rawurldecode($tmp[0])."' and tgl_spdp = '".rawurldecode($tmp[1])."' and no_berkas = '".rawurldecode($tmp[2])."'";
					$kue = "select file_upload_berkas_kembali from pidsus.pds_pengembalian_berkas where ".$whereDef;
                    $file = $connection->createCommand($kue)->queryScalar();
                    if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);
                    
                    $sql = "delete from pidsus.pds_pengembalian_berkas where ".$whereDef;
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
