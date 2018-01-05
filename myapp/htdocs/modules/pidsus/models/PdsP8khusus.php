<?php 

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsP8Khusus extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_p8_khusus';
    }

    public function searchpidsus18($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
                
                $q1  = htmlspecialchars($params['mpidsus18_q1'], ENT_QUOTES);
                
		$sql = "
		with tbl_tsk as(
			select id_kejati, id_kejari, id_cabjari, no_pidsus18, string_agg(nama||'--'||tgl_lahir, '#' order by no_urut_tersangka) as tsk 
			from pidsus.pds_pidsus18_tersangka group by id_kejati, id_kejari, id_cabjari, no_pidsus18
		)
		select a.*, b.tsk, c.tgl_p8_umum 
		from pidsus.pds_pidsus18 a 
		left join tbl_tsk b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_pidsus18 = b.no_pidsus18
                left join pidsus.pds_p8_umum c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari 
			and a.no_p8_umum = c.no_p8_umum
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."'";
                
                if($q1)
                    $sql .= " and (upper(a.no_p8_umum) like '%".strtoupper($q1)."%' or to_char(c.tgl_p8_umum, 'DD-MM-YYYY') = '".$q1."' or upper(b.tsk) like '%".strtoupper($q1).
                        "%' or upper(a.no_pidsus18) like '%".strtoupper($q1)."%' or to_char(a.tgl_pidsus18, 'DD-MM-YYYY') = '".$q1."')";
                
                $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_pidsus18 desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
	public function searchPer($params){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_pidsus18	= $_SESSION['pidsus_no_pidsus18'];
		
		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "
		with tbl_jaksa as(
			select id_kejati, id_kejari, id_cabjari, no_p8_umum, string_agg(nama_jaksa, '#') as jpunya 
			from pidsus.pds_p8_umum_jaksa group by id_kejati, id_kejari, id_cabjari, no_p8_umum 
		),
                tbl_tsk as(
			select id_kejati, id_kejari, id_cabjari, no_pidsus18, string_agg(nama, '#') as tsknya 
			from pidsus.pds_pidsus18_tersangka group by id_kejati, id_kejari, id_cabjari, no_pidsus18 
		)
		select a.no_p8_khusus, a.tgl_p8_khusus, c.jpunya, e.tsknya, b.no_p8_umum, a.no_pidsus18 
		from pidsus.pds_p8_khusus a 
                left join pidsus.pds_pidsus18 b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_pidsus18 = b.no_pidsus18
		left join tbl_jaksa c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
			and b.no_p8_umum = c.no_p8_umum
		left join tbl_tsk e on a.id_kejati = e.id_kejati and a.id_kejari = e.id_kejari and a.id_cabjari = e.id_cabjari 
			and a.no_pidsus18 = e.no_pidsus18
		where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."'";
                if($q1)
                    $sql .= " and (upper(a.no_p8_khusus) like '%".strtoupper($q1)."%' or to_char(a.tgl_p8_khusus, 'DD-MM-YYYY') = '".$q1."' or upper(c.jpunya) like '%".strtoupper($q1)."%')";
                
		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by a.tgl_p8_khusus desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
    	
    public function cekPdsP8Khusus($post){
		$connection = $this->db;
		$helpernya	= Yii::$app->inspektur;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari 	= $_SESSION['kode_kejari'];
		$id_cabjari     = $_SESSION['kode_cabjari'];
		$no_pidsus18    = $_SESSION['pidsus_no_pidsus18'];
		$no_p8_khusus	= htmlspecialchars($post['no_p8_khusus'], ENT_QUOTES);
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$whereDef  	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_pidsus18 = '".$no_pidsus18."' and no_p8_khusus = '".$no_p8_khusus."'";

        $sqlCek = "select count(*) from pidsus.pds_p8_khusus where ".$whereDef;
		if($isNew){
			$count 	= $connection->createCommand($sqlCek)->queryScalar();
		} else{
			$id1 	= $_SESSION["pidsus_no_p8_khusus"];
			$count 	= ($id1 == $no_p8_khusus)?0:$connection->createCommand($sqlCek)->queryScalar();
		}
        
        if($count > 0){
            $pesan = '<p style="color:#dd4b39; font-size:12px; margin-bottom:20px;"><i>P-8 Khusus dengan nomor '.$no_p8_khusus.' sudah ada</i></p>';
            return array("hasil"=>false, "error"=>$pesan, "element"=>"error_custom_no_p8_khusus");
        } else{
            return array("hasil"=>true, "error"=>"", "element"=>"");
        }
	}
        
        public function getTersangka($post){
            $no_pidsus18    = htmlspecialchars($post['no_pidsus18'], ENT_QUOTES);
            $id_kejati      = $_SESSION['kode_kejati'];
            $id_kejari      = $_SESSION['kode_kejari'];
            $id_cabjari     = $_SESSION['kode_cabjari'];
            $whereDef       = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."'";
            $sqlTsk = "
                    select a.*, b.nama as kebangsaan from pidsus.pds_pidsus18_tersangka a
                    left join public.ms_warganegara b on a.warganegara = b.id
                    where ".$whereDef." and a.no_pidsus18 = '".$no_pidsus18."' order by a.no_urut_tersangka";
            $hasil = PdsP8Khusus::findBySql($sqlTsk)->asArray()->all();
            if(count($hasil) == 0){
                $kolom= '<tr><td colspan="3">Data tidak ditemukan</td></tr>';
            }else{
                foreach($hasil as $val){
                    $kolom .= '<tr data-id="'.$val['no_urut_tersangka'].'" class="barisTsk">
                            <td class="text-center"><span class="frmnotsk" data-row-count="'.$val['no_urut_tersangka'].'">'.$val['no_urut_tersangka'].'</span></td>
                            <td class="text-left">'.$val['nama'].'</td>
                            <td class="text-left">'.$val['tmpt_lahir'].'/ '.date('d-m-Y',strtotime($val['tgl_lahir'])).'</td>
                        </tr>';
                }
            }
            return $kolom;
	}
        
        public function getJaksa($post){
            $no_p8_umum    = htmlspecialchars($post['no_p8_umum'], ENT_QUOTES);
            $id_kejati      = $_SESSION['kode_kejati'];
            $id_kejari      = $_SESSION['kode_kejari'];
            $id_cabjari     = $_SESSION['kode_cabjari'];
            $whereDef       = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."'";
            $sqlnya = "select * from pidsus.pds_p8_umum_jaksa a where ".$whereDef." and a.no_p8_umum = '".$no_p8_umum."' order by no_urut";
                    $hasil 	= PdsP8Khusus::findBySql($sqlnya)->asArray()->all();
                    if(count($hasil) == 0)
                        echo '<tr><td colspan="5">Data tidak ditemukan</td></tr>';
                    else{
                        $nom = 0;
                        $jabatanp8 = array(1=>'Koordinator', 'Ketua Tim', 'Wakil Ketua', 'Sekretaris', 'Anggota');
                        foreach($hasil as $data){
                            $nom++;	
                            $nipnya = $data['nip_jaksa'];
                            $idJpn 	= $data['nip_jaksa']."|#|".$data['gol_jaksa']."|#|".$data['pangkat_jaksa']."|#|".$data['jabatan_jaksa']."|#|".
                                          $data['nama_jaksa']."|#|".$data['jabatan_p8']."|#|";
                            $kolom .= '<tr data-id="'.$nipnya.'">
                                        <td class="text-center">
                                            <input type="checkbox" name="chk_del_jaksa[]" id="chk_del_jaksa'.$nom.'" class="hRowJpn" value="'.$nipnya.'" />
                                        </td>
                                        <td class="text-center"><span class="frmnojpn" data-row-count="'.$nom.'">'.$nom.'</span></td>
                                        <td class="text-left">'.$data['nip_jaksa'].'<br />'.$data['nama_jaksa'].'</td>
                                        <td class="text-left">'.$data['jabatan_jaksa'].'<br />'.$data['pangkat_jaksa'].' ('.$data['gol_jaksa'].')'.'</td>
                                        <td class="text-left">'.$jabatanp8[$data['jabatan_p8']].'<input type="hidden" name="jaksa[]" value="'.$idJpn.'" /></td>
                                     </tr>';
                            
                        }
                    }
            return $kolom;
	}

	public function simpanData($post){
		$helpernya	= Yii::$app->inspektur;
		$connection     = $this->db;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
                $no_p8_umum	= $_SESSION['pidsus_no_p8_umum'];
		$no_pidsus18	= htmlspecialchars($post['no_pidsus18'], ENT_QUOTES);
		$no_p8_khusus	= htmlspecialchars($post['no_p8_khusus'], ENT_QUOTES);
		$tgl_p8_khusus	= htmlspecialchars($post['tgl_p8_khusus'], ENT_QUOTES);
		$tindak_pidana	= htmlspecialchars($post['tindak_pidana'], ENT_QUOTES);
		$laporan_pidana	= htmlspecialchars($post['laporan_pidana'], ENT_QUOTES);

		$penandatangan_nama     = htmlspecialchars($post['penandatangan_nama'], ENT_QUOTES);
		$penandatangan_nip      = htmlspecialchars($post['penandatangan_nip'], ENT_QUOTES);
		$penandatangan_jabatan  = htmlspecialchars($post['penandatangan_jabatan'], ENT_QUOTES);
		$penandatangan_gol      = htmlspecialchars($post['penandatangan_gol'], ENT_QUOTES);
		$penandatangan_pangkat  = htmlspecialchars($post['penandatangan_pangkat'], ENT_QUOTES);
		$penandatangan_status_ttd   = htmlspecialchars($post['penandatangan_status'], ENT_QUOTES);
		$penandatangan_jabatan_ttd  = htmlspecialchars($post['penandatangan_ttdjabat'], ENT_QUOTES);
		
		$created_user 	= $_SESSION['username'];
		$created_nip	= $_SESSION['nik_user'];
		$created_nama	= $_SESSION['nama_pegawai'];
		$created_ip 	= $_SERVER['REMOTE_ADDR'];
		$updated_user 	= $_SESSION['username'];
		$updated_nip 	= $_SESSION['nik_user'];
		$updated_nama 	= $_SESSION['nama_pegawai'];
		$updated_ip 	= $_SERVER['REMOTE_ADDR'];

		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['p8khusus'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_khusus);
		$newPhoto 	= "p8_khusus".$clean1.$extPhoto;

		$whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_pidsus18 = '".$no_pidsus18."'";
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
				$sql1 = "insert into pidsus.pds_p8_khusus(id_kejati, id_kejari, id_cabjari, no_pidsus18, no_p8_khusus, tgl_p8_khusus, laporan_pidana, penandatangan_nama, penandatangan_nip, 
						 penandatangan_jabatan_pejabat, penandatangan_gol, penandatangan_pangkat, penandatangan_status_ttd, penandatangan_jabatan_ttd, created_user, created_nip, 
						 created_nama, created_ip, created_date, tindak_pidana) 
						 values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_pidsus18."', '".$no_p8_khusus."', '".$helpernya->tgl_db($tgl_p8_khusus)."', '".$laporan_pidana."',
						 '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', '".$penandatangan_gol."', '".$penandatangan_pangkat."', 
						 '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), '".$tindak_pidana."')";
			} else{
				if($filePhoto != ""){
					$upl1 = true;
					$filenya = ", file_upload = '".$newPhoto."'";
				} else{
					$upl1 = false;
					$filenya = "";
				}
				
				$sql1 = "update pidsus.pds_p8_khusus set no_p8_khusus = '".$no_p8_khusus."', tgl_p8_khusus = '".$helpernya->tgl_db($tgl_p8_khusus)."', 
						 laporan_pidana = '".$laporan_pidana."', tindak_pidana = '".$tindak_pidana."', penandatangan_nama = '".$penandatangan_nama."', 
						 penandatangan_nip = '".$penandatangan_nip."', penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
						 penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
						 penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
						 updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
						 where ".$whereDef." and no_p8_khusus = '".$_SESSION['pidsus_no_p8_khusus']."'";
			}
			$connection->createCommand($sql1)->execute();

			$sql2 = "delete from pidsus.pds_p8_khusus_jaksa where ".$whereDef." and no_p8_khusus = '".$no_p8_khusus."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['jaksa']) > 0){
				foreach($post['jaksa'] as $idx=>$val){
					list($nip, $gol, $pangkat, $jabatan, $nama, $jabatan_p8) = explode("|#|", $val);
					$sql3 = "insert into pidsus.pds_p8_khusus_jaksa values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_pidsus18."', '".$no_p8_khusus."', '".($idx+1)."', 
							 '".$nip."', '".$nama."', '".$gol."', '".$pangkat."', '".$jabatan."', '".$jabatan_p8."')";
					$connection->createCommand($sql3)->execute();
				}
			}

			$sql4 = "delete from pidsus.pds_p8_khusus_tembusan where ".$whereDef." and no_p8_khusus = '".$no_p8_khusus."'";
			$connection->createCommand($sql4)->execute();
			if(count($post['nama_tembusan']) > 0){
				$noauto = 0;
				foreach($post['nama_tembusan'] as $idx=>$val){
					$nama_tembusan= htmlspecialchars($post['nama_tembusan'][$idx], ENT_QUOTES);
					if($nama_tembusan){ 
						$noauto++; 
						$sql5 = "insert into pidsus.pds_p8_khusus_tembusan values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_pidsus18."', '".$no_p8_khusus."', 
								 '".$noauto."', '".$nama_tembusan."')";
						$connection->createCommand($sql5)->execute();
					}
				}
			}
                        
                        if($isNew){
				$sqlP = "insert into pidsus.pds_trx_pemrosesan(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, id_menu, id_user_login, durasi, no_p8_umum, no_pidsus18, no_p8_khusus)
						(
							select '".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '-', '1970-01-01', id, 'trigger', NOW(), '".$no_p8_umum."', '".$no_pidsus18."', '".$no_p8_khusus."' 
							from menu where module = 'PIDSUS' and (tipe_menu = 'FLOW2' or tipe_menu = 'FLOW3')
						)";
				$connection->createCommand($sqlP)->execute();
			}
			if(!$isNew && ($no_p8_umum != $_SESSION['pidsus_no_p8_umum'] || $no_pidsus18 != $_SESSION['pidsus_no_pidsus18'] || $no_p8_khusus != $_SESSION['pidsus_no_p8_khusus'])){
				$sqlup = "update pidsus.pds_trx_pemrosesan set no_p8_umum = '".$no_p8_umum."', no_pidsus18 = '".$no_pidsus18."', no_p8_khusus = '".$no_p8_khusus."' where ".$whereDef." and no_p8_umum = '".$_SESSION['pidsus_no_p8_umum']."' and no_pidsus18 = '".$_SESSION['pidsus_no_pidsus18']."' and no_p8_khusus = '".$_SESSION['pidsus_no_p8_khusus']."'";
				$connection->createCommand($sqlup)->execute();
			}

			if($upl1){
				$tmpPot = glob($pathfile."p8_khusus".$clean1.".*");
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
		$pathfile	= Yii::$app->params['p8khusus'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload from pidsus.pds_p8_khusus where ".$whereDefault." and no_pidsus18 = '".rawurldecode($tmp[1])."' 
							and no_p8_khusus = '".rawurldecode($tmp[2])."'";
					$file = $connection->createCommand($kue)->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from pidsus.pds_p8_khusus where ".$whereDefault." and no_pidsus18 = '".rawurldecode($tmp[1])."' and no_p8_khusus = '".rawurldecode($tmp[2])."'";
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
