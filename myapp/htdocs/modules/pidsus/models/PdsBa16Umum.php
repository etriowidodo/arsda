<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class PdsBa16Umum extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'pidsus.pds_ba16_umum';
    }
    
    public function searchPer($params){
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $no_p8_umum	= $_SESSION['pidsus_no_p8_umum'];

        $q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
        $sql = "
        with tbl_saksi as(
			select id_kejati, id_kejari, id_cabjari, no_p8_umum, no_ba16_umum, tgl_ba16_umum,
			string_agg(nama||'#'||umur||'#'||pekerjaan, '|#|' order by no_urut_saksi) as saksinya 
			from pidsus.pds_ba16_umum_saksi 
			group by id_kejati, id_kejari, id_cabjari, no_p8_umum, no_ba16_umum, tgl_ba16_umum
		)
        select b.saksinya,a.* 
        from pidsus.pds_ba16_umum a 
        left join tbl_saksi b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_p8_umum = b.no_p8_umum and a.no_ba16_umum = b.no_ba16_umum and a.tgl_ba16_umum = b.tgl_ba16_umum
        where a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_p8_umum = '".$no_p8_umum."'";
        if($q1)
                $sql .= " and ( to_char(a.tgl_ba16_umum, 'DD-MM-YYYY') = '".$q1."' or upper(b.saksinya) like '%".strtoupper($q1)."%') ";

        $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
        $count = $kueri->queryScalar();
        $sql .= " order by a.tgl_ba16_umum desc";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }
    
    public function searchB4Jaksa($post){
        $id =   htmlspecialchars($post['id'], ENT_QUOTES);
        $whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
                            and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        $sqlJaksa = "select a.nip_jaksa, a.nama_jaksa, a.gol_jaksa, a.pangkat_jaksa, a.jabatan_jaksa 
                     from pidsus.pds_b4_umum_jaksa a where ".$whereDefault." and a.no_b4_umum = '".$id."' order by no_urut";
        $resJaksa = PdsBa16Umum::findBySql($sqlJaksa)->asArray()->all();
        if(count($resJaksa) == 0){
            $hasil= '<tr><td colspan="4">Data tidak ditemukan</td></tr>';
         } else{
             $nom = 0;
             foreach($resJaksa as $data){
                 $nom++;	
                 $idJpn = $data['nip_jaksa']."#".$data['nama_jaksa']."#".$data['test']."#".$data['gol_jaksa']."#".$data['pangkat_jaksa']."#".$data['jabatan_jaksa'];					
                 $hasil.= '
                 <tr data-id="'.$data['nip_jaksa'].'">
                         <td class="text-center">
                                 <span class="frmnojpn" data-row-count="'.$nom.'">'.$nom.'</span><input type="hidden" name="jpnid[]" value="'.$idJpn.'" />
                         </td>
                         <td class="text-left">'.$data['nip_jaksa'].'<br />'.$data['nama_jaksa'].'</td>
                         <td class="text-left">'.$data['jabatan_jaksa'].'<br />'.$data['pangkat_jaksa'].' ('.$data['gol_jaksa'].')</td>
                 </tr>';
             }
         }
        return $hasil;
    }
    
    public function listB4Jaksa($post){
        $id =   htmlspecialchars($post['id'], ENT_QUOTES);
        $whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
                            and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        $sqlJaksa = "select a.nip_jaksa, a.nama_jaksa, a.gol_jaksa, a.pangkat_jaksa, a.jabatan_jaksa 
                     from pidsus.pds_b4_umum_jaksa a where ".$whereDefault." and a.no_b4_umum = '".$id."' order by no_urut";
       
        $answer	= array();
        $answer["items"][] = array("id"=>'', "text"=>'');
        $result = PdsBa16Umum::findBySql($sqlJaksa)->asArray()->all();
        if(count($result) > 0){
                foreach($result as $data){
                    $prmnya = $data['nama_jaksa']."#".$data['nip_jaksa']."#".$data['jabatan_jaksa']."#".$data['gol_jaksa']."#".$data['pangkat_jaksa'];
                    $answer["items"][] = array("id"=>$prmnya, "text"=>$data['nama_jaksa']);
                }
        }
        return $answer;
    }
    
    public function searchB4Geledah($post){
        $id =   htmlspecialchars($post['id'], ENT_QUOTES);
        $whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
                            and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        $sql = "select a.* 
                     from pidsus.pds_b4_umum_pengeledahan a where ".$whereDefault." and a.no_b4_umum = '".$id."' order by no_urut_penggeledahan";
        $res = PdsBa16Umum::findBySql($sql)->asArray()->all();
        if(count($res) == 0){
            $hasil= '<tr><td colspan="5">Data tidak ditemukan</td></tr>';
         } else{
             $nom = 0;
             foreach($res as $data){
                 $nom++;	
                 if($data['penggeledahan_terhadap'] == 'Subyek'){
                        $ygDigeledah = $data['nama'].'<br />'.$data['jabatan'];
                } else if($data['penggeledahan_terhadap'] == 'Obyek'){
                        $ygDigeledah = $data['tempat_penggeledahan'].'<br />'.$data['alamat_penggeledahan'];
                }
                 
               $hasil.= '
                 <tr>
                         <td class="text-center"><span>'.$nom.'</span></td>
                         <td class="text-left">'.$ygDigeledah.'</td>
                         <td class="text-left">'.$data['nama_pemilik'].'</td>
                         <td class="text-left">'.$data['alamat_pemilik'].'</td>
                         <td class="text-left">'.$data['pekerjaan_pemilik'].'</td>
                 </tr>';
             }
         }
        return $hasil;
    }
    
    public function searchB4Sita($post){
        $id =   htmlspecialchars($post['id'], ENT_QUOTES);
        $whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
                            and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        $sql = "select a.* 
                     from pidsus.pds_b4_umum_penyitaan a where ".$whereDefault." and a.no_b4_umum = '".$id."' order by no_urut_penyitaan";
        $res = PdsBa16Umum::findBySql($sql)->asArray()->all();
        if(count($res) == 0){
            $hasil= '<tr><td colspan="5">Data tidak ditemukan</td></tr>';
         } else{
             $nom = 0;
             foreach($res as $data){
                $nom++;
                $hasil.= '
                 <tr>
                         <td class="text-center"><span>'.$nom.'</span></td>
                         <td class="text-left">'.$data['nama_barang_disita'].'</td>
                         <td class="text-left">'.$data['nama_pemilik'].'</td>
                         <td class="text-left">'.$data['alamat_pemilik'].'</td>
                         <td class="text-left">'.$data['pekerjaan_pemilik'].'</td>
                 </tr>';
             }
         }
        return $hasil;
    }
    
    public function searchb4($params){
        
        $q1  = htmlspecialchars($params['mb4_q1'], ENT_QUOTES);
        $whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        $sql = "Select a.no_b4_umum, a.tgl_dikeluarkan from pidsus.pds_b4_umum a where ".$whereDefault;
        if($q1)
                $sql .= " and (to_char(a.tgl_dikeluarkan, 'DD-MM-YYYY') = '".$q1."' or upper(a.no_b4_umum) like '%".strtoupper($q1)."%')";
        $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
        $count = $kueri->queryScalar();
        $sql .= " order by a.tgl_dikeluarkan desc";
        $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                'totalCount' => $count,
        ]);
        return $dataProvider;
    }

	public function simpanData($post){
		$helpernya	= Yii::$app->inspektur;
		$connection     = $this->db;
		$id_kejati 	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$no_p8_umum		= htmlspecialchars($post['no_p8_umum'], ENT_QUOTES);
                
		$no_ba16_umum           = ($post['no_ba16_umum'])?htmlspecialchars($post['no_ba16_umum'], ENT_QUOTES):0;
		$tgl_ba16_umum   	= htmlspecialchars($post['tgl_ba16_umum'], ENT_QUOTES);
		$no_b4_umum   		= htmlspecialchars($post['no_b4_umum'], ENT_QUOTES);
		$tgl_b4_umum  		= htmlspecialchars($post['tgl_b4_umum'], ENT_QUOTES);
		$no_surat_pn   		= htmlspecialchars($post['no_surat_pn'], ENT_QUOTES);
		$tgl_surat_pn 		= htmlspecialchars($post['tgl_surat_pn'], ENT_QUOTES);

		$penandatangan_nama     = htmlspecialchars($post['penandatangan_nama'], ENT_QUOTES);
		$penandatangan_nip      = htmlspecialchars($post['penandatangan_nip'], ENT_QUOTES);
		$penandatangan_jabatan  = htmlspecialchars($post['penandatangan_jabatan'], ENT_QUOTES);
		$penandatangan_gol      = htmlspecialchars($post['penandatangan_gol'], ENT_QUOTES);
		$penandatangan_pangkat  = htmlspecialchars($post['penandatangan_pangkat'], ENT_QUOTES);
		$penandatangan_status_ttd   = htmlspecialchars($post['penandatangan_status'], ENT_QUOTES);
		$penandatangan_jabatan_ttd  = htmlspecialchars($post['penandatangan_ttdjabat'], ENT_QUOTES);

		$created_user		= $_SESSION['username'];
		$created_nip		= $_SESSION['nik_user'];
		$created_nama		= $_SESSION['nama_pegawai'];
		$created_ip		= $_SERVER['REMOTE_ADDR'];
		$updated_user		= $_SESSION['username'];
		$updated_nip		= $_SESSION['nik_user'];
		$updated_nama		= $_SESSION['nama_pegawai'];
		$updated_ip		= $_SERVER['REMOTE_ADDR'];
                
                $sql0 = "select coalesce(max(no_ba16_umum)+1,1) as nourut from pidsus.pds_ba16_umum 
				 where id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p8_umum = '".$no_p8_umum."'";
		$row0 = $connection->createCommand($sql0)->queryScalar();

		$filePhoto1 = htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto1 = htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto1 = htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto1  = substr($filePhoto1,strrpos($filePhoto1,'.'));

		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['ba16_umum'];
		$clean1 	= Yii::$app->inspektur->sanitize_filename($no_p8_umum);
		$clean2 	= ($isNew)?$row0:$no_ba16_umum;
		$newPhoto1 	= "ba16_umum_".$clean1."-".$clean2.$extPhoto1;
		$whereDef 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p8_umum = '".$no_p8_umum."'";

		$transaction = $connection->beginTransaction();
		try{
			if($isNew){
				if($filePhoto1 != ""){
					$upl1 = true;
					$newPhoto1 = $newPhoto1;
				} else{
					$upl1 = false;
					$newPhoto1 = "";
				}
				$sql1 = "insert into pidsus.pds_ba16_umum(id_kejati, id_kejari, id_cabjari, no_p8_umum, no_ba16_umum, tgl_ba16_umum, no_b4_umum, tgl_b4_umum, no_surat_pn,
                                         tgl_surat_pn, penandatangan_nama, penandatangan_nip, penandatangan_jabatan_pejabat, 
                                         penandatangan_gol, penandatangan_pangkat, penandatangan_status_ttd, penandatangan_jabatan_ttd, file_upload, created_user, created_nip, 
                                         created_nama, created_ip, created_date, updated_user, updated_nip, updated_nama, updated_ip, updated_date)  
                                         values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', '".$row0."', '".$helpernya->tgl_db($tgl_ba16_umum)."', 
                                         '".$no_b4_umum."', '".$helpernya->tgl_db($tgl_b4_umum)."', '".$no_surat_pn."', '".$helpernya->tgl_db($tgl_surat_pn)."', '".$penandatangan_nama."', '".$penandatangan_nip."', '".$penandatangan_jabatan."', 
                                         '".$penandatangan_gol."', '".$penandatangan_pangkat."', '".$penandatangan_status_ttd."', '".$penandatangan_jabatan_ttd."', '".$newPhoto1."', 
                                         '".$created_user."', '".$created_nip."', '".$created_nama."', '".$created_ip."', NOW(), 
                                         '".$updated_user."', '".$updated_nip."', '".$updated_nama."', '".$updated_ip."', NOW())";
			} else{
				if($filePhoto1 != ""){
					$upl1 = true;
					$filenya1 = ", file_upload = '".$newPhoto1."'";
				} else{
					$upl1 = false;
					$filenya1 = "";
				}

				$sql1 = "update pidsus.pds_ba16_umum set tgl_ba16_umum = '".$helpernya->tgl_db($tgl_ba16_umum)."', no_b4_umum = '".$no_b4_umum."', 
                                         tgl_b4_umum = '".$helpernya->tgl_db($tgl_b4_umum)."', no_surat_pn = '".$no_surat_pn."', tgl_surat_pn = '".$helpernya->tgl_db($tgl_surat_pn)."', penandatangan_nama = '".$penandatangan_nama."', 
                                         penandatangan_nip = '".$penandatangan_nip."', penandatangan_jabatan_pejabat = '".$penandatangan_jabatan."', penandatangan_gol = '".$penandatangan_gol."', 
                                         penandatangan_pangkat = '".$penandatangan_pangkat."', penandatangan_status_ttd = '".$penandatangan_status_ttd."', 
                                         penandatangan_jabatan_ttd = '".$penandatangan_jabatan_ttd."', updated_user = '".$updated_user."', updated_nip = '".$updated_nip."', 
                                         updated_nama = '".$updated_nama."', updated_ip = '".$updated_ip."', updated_date = NOW()".$filenya." 
                                         where ".$whereDef." and no_ba16_umum = '".$no_ba16_umum."' and tgl_ba16_umum = '".$_SESSION['pidsus_tgl_ba16_umum']."'";
			}
			$connection->createCommand($sql1)->execute();
                        
			$sql2 = "delete from pidsus.pds_ba16_umum_saksi where ".$whereDef." and no_ba16_umum = '".$no_ba16_umum."' and tgl_ba16_umum = '".$helpernya->tgl_db($tgl_ba16_umum)."'";
			$connection->createCommand($sql2)->execute();
			if(count($post['no_urut_saksi']) > 0){
				$noauto = 0;
                                $no_ba16_umum = ($isNew)?$row0:$no_ba16_umum;
				foreach($post['no_urut_saksi'] as $idx=>$val){
					$nama_saksi         = htmlspecialchars($post['nama_saksi'][$idx], ENT_QUOTES);
					$umur_saksi         = (htmlspecialchars($post['umur_saksi'][$idx], ENT_QUOTES))?htmlspecialchars($post['umur_saksi'][$idx], ENT_QUOTES):0;
					$pekerjaan_saksi    = htmlspecialchars($post['pekerjaan_saksi'][$idx], ENT_QUOTES);
					if($nama_saksi){ 
						$noauto++; 
						$sql3 = "insert into pidsus.pds_ba16_umum_saksi(id_kejati,id_kejari,id_cabjari,no_p8_umum,no_ba16_umum,tgl_ba16_umum,no_urut_saksi,nama,umur,pekerjaan) "
                                                        . " values('".$id_kejati."', '".$id_kejari."', '".$id_cabjari."', '".$no_p8_umum."', 
								 '".$no_ba16_umum."', '".$helpernya->tgl_db($tgl_ba16_umum)."', '".$noauto."', '".$nama_saksi."', '".$umur_saksi."', '".$pekerjaan_saksi."')";
						$connection->createCommand($sql3)->execute();
					}
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile."ba16_umum_".$clean1."-".$clean2.".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto1;
				$mantab  = move_uploaded_file($tempPhoto1, $tujuan);
				if(file_exists($tempPhoto1)) unlink($tempPhoto1);
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
		$pathfile	= Yii::$app->params['ba16_umum'];
		$transaction 	= $connection->beginTransaction();
		$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
							and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$tmp = explode("#", $val);
					$kue = "select file_upload from pidsus.pds_ba16_umum where ".$whereDefault." and no_ba16_umum = '".rawurldecode($tmp[0])."' and tgl_ba16_umum = '".rawurldecode($tmp[1])."'";
					$file = $connection->createCommand($kue)->queryOne();
					if($file['file_upload'] && file_exists($pathfile.$file['file_upload'])) unlink($pathfile.$file['file_upload']);

					$sql1 = "delete from pidsus.pds_ba16_umum where ".$whereDefault." and no_ba16_umum = '".rawurldecode($tmp[0])."' and tgl_ba16_umum = '".rawurldecode($tmp[1])."'";
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
