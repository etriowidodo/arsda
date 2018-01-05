<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class Spdp extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_spdp';
    }

	public function searchPer($params){
		$q1  	= htmlspecialchars($params['q1'], ENT_QUOTES);
		$arr 	= array("JANUARI"=>"01", "FEBRUARI"=>"02", "MARET"=>"03", "APRIL"=>"04", "MEI"=>"05", "JUNI"=>"06", "JULI"=>"07", "AGUSTUS"=>"08", "SEPTEMBER"=>"09", 
				"OKTOBER"=>"10", "NOVEMBER"=>"11", "DESEMBER"=>"12");
		$tmp1 	= str_replace(array("/", " "), array("-","-"), strtoupper($q1));
		$tmp2 	= str_replace(array_keys($arr), $arr, strtoupper($tmp1));

		$sql = "
		with tbl_jaksa as(
				select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_p16, string_agg(no_urut||'|'||nama, '#') as jaksanya 
				from pidsus.pds_p16_jaksa group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_p16
		), tbl_tersangka as(
				select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, string_agg(no_urut||'|'||nama, '#') as tersangka 
				from pidsus.pds_spdp_tersangka group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp
		), tbl_berkas as(
				select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, string_agg(no_berkas||'|'||tgl_berkas, '#') as berkas_thp1 
				from pidsus.pds_terima_berkas group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp
		)
		select a.*, b.nama as inst_penyidik, c.nama as inst_pelak_penyidikan, e.tersangka, f.no_p16, f.tgl_dikeluarkan as tgl_p16, g.jaksanya, h.berkas_thp1, i.statusnya 
		from pidsus.pds_spdp a 
		join pidsus.ms_inst_penyidik b on a.id_asalsurat = b.kode_ip
		join pidsus.ms_inst_pelak_penyidikan c on a.id_asalsurat = c.kode_ip and a.id_penyidik = c.kode_ipp
		left join tbl_tersangka e on a.id_kejati = e.id_kejati and a.id_kejari = e.id_kejari and a.id_cabjari = e.id_cabjari and a.no_spdp = e.no_spdp and a.tgl_spdp = e.tgl_spdp 
		left join pidsus.pds_p16 f on a.id_kejati = f.id_kejati and a.id_kejari = f.id_kejari and a.id_cabjari = f.id_cabjari and a.no_spdp = f.no_spdp and a.tgl_spdp = f.tgl_spdp 
			and f.is_akhir = 1
		left join tbl_jaksa g on f.id_kejati = g.id_kejati and f.id_kejari = g.id_kejari and f.id_cabjari = g.id_cabjari and f.no_spdp = g.no_spdp and f.tgl_spdp = g.tgl_spdp 
			and f.no_p16 = g.no_p16 
		left join tbl_berkas h on a.id_kejati = h.id_kejati and a.id_kejari = h.id_kejari and a.id_cabjari = h.id_cabjari and a.no_spdp = h.no_spdp and a.tgl_spdp = h.tgl_spdp 
		left join pidsus.vw_pds_status_spdp_dikeks i on a.id_kejati = i.id_kejati and a.id_kejari = i.id_kejari and a.id_cabjari = i.id_cabjari and a.no_spdp = i.no_spdp 
			and a.tgl_spdp = i.tgl_spdp 
		where 1=1";
		
		if($q1)
			$sql .= " and (upper(c.nama) like '%".strtoupper($q1)."%' or upper(a.no_spdp) like '%".strtoupper($q1)."%' or to_char(a.tgl_spdp, 'DD-MM-YYYY') = '".$q1."' 
					  or to_char(a.tgl_terima, 'DD-MM-YYYY') = '".$q1."' or upper(e.tersangka) like '%".strtoupper($q1)."%' 
					  or upper(a.tempat_kejadian) like '%".strtoupper($q1)."%' or upper(i.statusnya) like '%".strtoupper($q1)."%' 
					  or upper(a.tgl_kejadian_perkara) like '%-".$tmp2."%')";//echo $sql; exit;

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_terima desc, a.tgl_spdp desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
    
    public function searchWarga($get){
		$nama  = htmlspecialchars($get['nama'], ENT_QUOTES);
		$sql = "select * from public.ms_warganegara where upper(nama) like '%".strtoupper($nama)."%'";
                $kueri = $this->db->createCommand("select count(*) from (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by id";
		$dataProvider = new SqlDataProvider([
			'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
		]);
		return $dataProvider;
	}
	
	public function explodeTersangka($post){
		$a 	= htmlspecialchars($post['tersangka'],ENT_QUOTES);
		$e 	= explode("|#|", $a);
		$data = [];
		$data['no_urut'] 		= htmlspecialchars($e[0], ENT_QUOTES);
		$data['nama'] 			= htmlspecialchars($e[1], ENT_QUOTES);
		$data['tmpt_lahir']		= htmlspecialchars($e[2], ENT_QUOTES);
		$data['tgl_lahir']		= htmlspecialchars($e[3], ENT_QUOTES);                
		$data['umur']			= htmlspecialchars($e[4], ENT_QUOTES);                
		$data['id_warganegara'] = htmlspecialchars($e[5], ENT_QUOTES);                
		$data['kebangsaan'] 	= htmlspecialchars($e[6], ENT_QUOTES);                
		$data['suku'] 			= htmlspecialchars($e[7], ENT_QUOTES);                
		$data['id_identitas'] 	= htmlspecialchars($e[8], ENT_QUOTES);                
		$data['no_identitas'] 	= htmlspecialchars($e[9], ENT_QUOTES);                
		$data['id_jkl'] 		= htmlspecialchars($e[10], ENT_QUOTES);                
		$data['id_agama'] 		= htmlspecialchars($e[11], ENT_QUOTES);                
		$data['alamat'] 		= htmlspecialchars($e[12], ENT_QUOTES);                
		$data['no_hp'] 			= htmlspecialchars($e[13], ENT_QUOTES);                
		$data['id_pendidikan'] 	= htmlspecialchars($e[14], ENT_QUOTES);                
		$data['pekerjaan'] 		= htmlspecialchars($e[15], ENT_QUOTES);
		return $data;
	}


    public function cekSpdp($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
		
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$nomor  = htmlspecialchars($post['no_spdp'], ENT_QUOTES);
		$tglny 	= htmlspecialchars($post['tgl_spdp'], ENT_QUOTES);

		$where 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".$nomor."' 
					and tgl_spdp = '".$helpernya->tgl_db($tglny)."'";
		$sql 	= "select count(*) from pidsus.pds_spdp where ".$where;
		$count 	= ($isNew)?$connection->createCommand($sql)->queryScalar():0;
		$cekSts = true;
		if($count > 0){
			$pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>* SPDP dengan nomor '.$nomor.' Tanggal '.$tglny.' sudah ada</i></p>';
			return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_head");
		} else{
			return array("hasil"=>true, "error"=>"", "element"=>"");
		}
	}
	
	public function searchInstansiplkpydk($post){
		$connection = $this->db;
		$q1 	= htmlspecialchars($post['q1'], ENT_QUOTES);
		$sql 	= "select * from pidsus.ms_inst_pelak_penyidikan where kode_ip = '".$q1."'";
		$answer	= array();
		$answer["items"][] = array("id"=>'', "text"=>'');
		$result 	= $connection->createCommand($sql)->queryAll();
		if(count($result) > 0){
			foreach($result as $data){
				$answer["items"][] = array("id"=>$data['kode_ipp'], "text"=>$data['nama']);
			}
		}
		return $answer;

	}
        
	public function simpanData($post){
		$connection             = $this->db;
		$id_kejati              = $_SESSION['kode_kejati'];
		$id_kejari              = $_SESSION['kode_kejari'];
		$id_cabjari             = $_SESSION['kode_cabjari'];
		$no_spdp                = htmlspecialchars($post['no_spdp'], ENT_QUOTES);
		$tgl_spdp               = htmlspecialchars($post['tgl_spdp'], ENT_QUOTES);
		$no_sprindik 		= htmlspecialchars($post['no_sprindik'], ENT_QUOTES);
		$tgl_sprindik 		= htmlspecialchars($post['tgl_sprindik'], ENT_QUOTES);
		$id_asalsurat           = htmlspecialchars($post['instansi_pdk'], ENT_QUOTES);
		$id_penyidik            = htmlspecialchars($post['instansi_plk_pydk'], ENT_QUOTES);
		$tgl_terima             = htmlspecialchars($post['tgl_terima'], ENT_QUOTES);
		$kejadian_perkara0   	= ($post['waktu_kejadian'][0])?htmlspecialchars($post['waktu_kejadian'][0], ENT_QUOTES):"";
		$kejadian_perkara1   	= ($post['waktu_kejadian'][1])?htmlspecialchars($post['waktu_kejadian'][1], ENT_QUOTES):"";
		$kejadian_perkara2   	= ($post['waktu_kejadian'][2])?htmlspecialchars($post['waktu_kejadian'][2], ENT_QUOTES):"";
		$kejadian_perkara3   	= ($post['waktu_kejadian'][3])?htmlspecialchars($post['waktu_kejadian'][3], ENT_QUOTES):"";
		$kejadian_perkara4   	= ($post['waktu_kejadian'][4])?htmlspecialchars($post['waktu_kejadian'][4], ENT_QUOTES):"";
		$kejadian_perkara5   	= ($post['waktu_kejadian'][5])?htmlspecialchars($post['waktu_kejadian'][5], ENT_QUOTES):"";
		$tempat_kejadian        = htmlspecialchars($post['tmp_kejadian'], ENT_QUOTES);
		$ket_kasus              = htmlspecialchars($post['uraian'], ENT_QUOTES);
		$undang_pasal           = htmlspecialchars($post['uu'], ENT_QUOTES);
		
		$created_user   = $_SESSION['username'];
		$created_nip    = $_SESSION['nik_user'];
		$created_nama   = $_SESSION['nama_pegawai'];
		$created_ip     = $_SERVER['REMOTE_ADDR'];
		$updated_user   = $_SESSION['username'];
		$updated_nip    = $_SESSION['nik_user'];
		$updated_nama   = $_SESSION['nama_pegawai'];
		$updated_ip     = $_SERVER['REMOTE_ADDR'];
		
		$helpernya	= Yii::$app->inspektur;
		$filePhoto 	= htmlspecialchars($_FILES['file_permohonan']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_permohonan']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_permohonan']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['spdp'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_spdp);
		$clean2 	= Yii::$app->inspektur->sanitize_filename($tgl_spdp);
		$newPhoto 	= "spdp_".$clean1."-".$clean2.$extPhoto;
		$isNew      = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$tgl_kejadian_perkara = $kejadian_perkara0."-".$kejadian_perkara1."-".$kejadian_perkara2."-".$kejadian_perkara3."-".$kejadian_perkara4."-".$kejadian_perkara5;
		
		$whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."'";
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
				$sql1="insert into pidsus.pds_spdp(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, id_asalsurat, id_penyidik, tgl_terima, tgl_kejadian_perkara, 
					tempat_kejadian, ket_kasus, undang_pasal, file_upload_spdp, no_sprindik, tgl_sprindik, created_user, created_nip, 
					created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date) values('".$id_kejati."', 
					'".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', '".$helpernya->tgl_db($tgl_spdp)."', '".$id_asalsurat."', '".$id_penyidik."', 
					'".$helpernya->tgl_db($tgl_terima)."', '".$tgl_kejadian_perkara."', '".$tempat_kejadian."', '".$ket_kasus."', '".$undang_pasal."', '".$newPhoto."', 
					'".$no_sprindik."', '".$helpernya->tgl_db($tgl_sprindik)."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
					'".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload_spdp = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
			
				$sql1 = "update pidsus.pds_spdp set no_spdp = '".$no_spdp."', tgl_spdp = '".$helpernya->tgl_db($tgl_spdp)."', id_asalsurat = '".$id_asalsurat."', id_penyidik = '".$id_penyidik."', no_sprindik = '".$no_sprindik."', 
						tgl_sprindik = '".$helpernya->tgl_db($tgl_sprindik)."', tgl_terima = '".$helpernya->tgl_db($tgl_terima)."', 
						tgl_kejadian_perkara = '".$tgl_kejadian_perkara."', tempat_kejadian = '".$tempat_kejadian."', 
						ket_kasus = '".$ket_kasus."', undang_pasal = '".$undang_pasal."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						where ".$whereDef." and no_spdp = '".$_SESSION['no_spdp']."' and tgl_spdp = '".$_SESSION['tgl_spdp']."'";
			}
			$connection->createCommand($sql1)->execute();
                        
                        if(!$isNew && ($no_spdp!=$_SESSION['no_spdp'] || $helpernya->tgl_db($tgl_spdp)!=str_replace('-','/',$_SESSION['tgl_spdp']))){
                            $sqlTrx = "update pidsus.pds_trx_pemrosesan set no_spdp = '".$no_spdp."', tgl_spdp = '".$helpernya->tgl_db($tgl_spdp)."' "
                                    . "where ".$whereDef." and no_spdp = '".$_SESSION['no_spdp']."' and tgl_spdp = '".$_SESSION['tgl_spdp']."'";
                            $connection->createCommand($sqlTrx)->execute();
                        }
                        
			$sql2 = "delete from pidsus.pds_spdp_tersangka where ".$whereDef." and no_spdp = '".$no_spdp."' and tgl_spdp = '".$helpernya->tgl_db($tgl_spdp)."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['tersangka']) > 0){
				foreach($post['tersangka'] as $idx=>$val){
					list($no_urut, $nama, $tmpt_lahir, $tgl_lahir, $umur, $warganegara, $warganegara_nama, $suku, $id_identitas, $no_identitas, $id_jkl, $id_agama, $alamat, $no_hp, $id_pendidikan, $pekerjaan) = explode("|#|", $val);
					$tgl_lahir= ($tgl_lahir)?"'".$helpernya->tgl_db($tgl_lahir)."'":'NULL';
					$umur = ($umur)?$umur:'0';
					$warganegara = ($warganegara)?$warganegara:'0';
					$id_identitas = ($id_identitas)?$id_identitas:'0';
					$id_jkl = ($id_jkl)?$id_jkl:'0';
					$id_agama = ($id_agama)?$id_agama:'0';
					$id_pendidikan = ($id_pendidikan !== "")?$id_pendidikan:'-1';
					$sql3 = "insert into pidsus.pds_spdp_tersangka values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_spdp."', 
							'".$helpernya->tgl_db($tgl_spdp)."', '".$no_urut."', '".$nama."', '".$tmpt_lahir."', ".$tgl_lahir.", '".$umur."', '".$warganegara."', 
							'".$suku."', '".$id_identitas."', '".$no_identitas."', '".$id_jkl."', '".$id_agama."', '".$alamat."', '".$no_hp."', '".$id_pendidikan."', 
							'".$pekerjaan."')";
					$connection->createCommand($sql3)->execute();
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."spdp".$clean1."-".$clean2.".*");
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
        $id_kejati              = $_SESSION['kode_kejati'];
        $id_kejari              = $_SESSION['kode_kejari'];
        $id_cabjari             = $_SESSION['kode_cabjari'];
        $helpernya	= Yii::$app->inspektur;
        $pathfile	= Yii::$app->params['spdp'];
        $transaction = $connection->beginTransaction();
        try {
            if(count($post['id']) > 0){
                foreach($post['id'] as $idx=>$val){
                    $tmp = explode("|#|", $val);
                    $whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_spdp = '".rawurldecode($tmp[0])."' and tgl_spdp = '".$helpernya->tgl_db(date("d-m-Y", strtotime(rawurldecode($tmp[1]))))."'";
                    
                    $kue = "select file_upload_spdp from pidsus.pds_spdp where ".$whereDef;
                    $file = $connection->createCommand($kue)->queryScalar();
                    if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);
                    
                    $sql = "delete from pidsus.pds_spdp_tersangka where ".$whereDef;
                    $connection->createCommand($sql)->execute();
                    
                    $sql1 = "delete from pidsus.pds_spdp where ".$whereDef;
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
