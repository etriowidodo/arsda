<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsPenyelesaianPratut extends \yii\db\ActiveRecord{
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
			with tbl_tsk_berkas as (
				select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, 
				string_agg(no_urut||'. '||nama, '<br />' order by no_urut) as nama_tersangka
				from(
					select distinct id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_urut, nama 
					from pidsus.pds_terima_berkas_tersangka 
				) a
				group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas 
			), tbl_pengantar as (
				select * from pidsus.pds_terima_berkas_pengantar 
				where(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, tgl_pengantar) in(
					select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, max(tgl_pengantar) as tgl_pengantar
					from pidsus.pds_terima_berkas_pengantar a
					where id_kejati = '".$_SESSION['kode_kejati']."' and id_kejari = '".$_SESSION['kode_kejari']."' and id_cabjari = '".$_SESSION['kode_cabjari']."' 
						and no_spdp = '".$_SESSION['no_spdp']."' and tgl_spdp = '".$_SESSION['tgl_spdp']."' and no_berkas = '".$_SESSION['no_berkas']."'
					group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas limit 1
				)
			)
			select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.tgl_berkas, b.tgl_terima as tgl_terima, 
			case when c.status = '1' then 'Lanjut Ke Penuntutan' when c.status = '2' then 'Diversi'  
				 when c.status = '3' then 'SP-3 (Dihentikan)'  when c.status = '4' then 'Optimal' 
				 else '' 
			end as status, d.nama_tersangka 
			from pidsus.pds_terima_berkas a 
			join tbl_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas 
			join tbl_tsk_berkas d on b.id_kejati = d.id_kejati and b.id_kejari = d.id_kejari and b.id_cabjari = d.id_cabjari 
				and b.no_spdp = d.no_spdp and b.tgl_spdp = d.tgl_spdp and b.no_berkas = d.no_berkas 
			left join pidsus.pds_penyelesaian_pratut c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari 
				and a.no_spdp = c.no_spdp and a.tgl_spdp = c.tgl_spdp and a.no_berkas = c.no_berkas 
			where a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."' and a.no_berkas = '".$_SESSION['no_berkas']."'";
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_berkas desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	
	public function simpanData($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];
		$no_berkas	= $_SESSION['no_berkas'];

		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$nomor		= htmlspecialchars($post['nomor'], ENT_QUOTES);
		$tgl_surat 	= htmlspecialchars($post['tgl_surat'], ENT_QUOTES);
		$status		= htmlspecialchars($post['status'], ENT_QUOTES);
		$sikap_jpu	= htmlspecialchars($post['sikap_jpu'], ENT_QUOTES);
		$tgl_surat 	= ($tgl_surat)?"'".$helpernya->tgl_db($tgl_surat)."'":"NULL";
		
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
		$pathfile	= Yii::$app->params['penyelesaian_pratut'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_spdp);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_spdp);
		$clean3 	= Yii::$app->inspektur->sanitize_filename($no_berkas);
		$newPhoto 	= "penyelesaian_pratut_".$clean1."-".$clean2."-".$clean3.$extPhoto;

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
				$sql1 = "insert into pidsus.pds_penyelesaian_pratut(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, nomor, tgl_surat, status, sikap_jpu, 
						 file_upload_penyelesaian_pratut, created_user, created_nip, created_nama, created_ip, created_date, updated_user, updated_nip, 
						 updated_nama, updated_ip, updated_date) values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$tgl_spdp."', '".$no_berkas."', 
						 '".$nomor."', ".$tgl_surat.", '".$status."', '".$sikap_jpu."', '".$newPhoto."', 
						 '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
						 '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload_penyelesaian_pratut = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_penyelesaian_pratut set nomor = '".$nomor."', tgl_surat = ".$tgl_surat.", status = '".$status."', 
						 sikap_jpu = '".$sikap_jpu."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', updated_nama = '".$updated_nama."', 
						 updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." where ".$whereDef." and no_berkas = '".$no_berkas."'";
			}
			$connection->createCommand($sql1)->execute();

			if($upl1){
				$tmpPot = glob($pathfile."penyelesaian_pratut_".$clean1."-".$clean2."-".$clean3.".*");
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
		$pathfile		= Yii::$app->params['penyelesaian_pratut'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload_penyelesaian_pratut from pidsus.pds_penyelesaian_pratut where ".$whereDefault." and no_berkas = '".rawurldecode($tmp[0])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from pidsus.pds_penyelesaian_pratut where ".$whereDefault." and no_berkas = '".rawurldecode($tmp[0])."'";
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
