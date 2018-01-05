<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\datun\models\PermohonanSearch;
use yii\db\Query;
use yii\data\SqlDataProvider;

/**
 * VwGridPrapenuntutanSearch represents the model behind the search form about `app\modules\pidum\models\VwGridPrapenuntutan`.
 */
//faiz jkt 03/11/2016 
class PermohonanSearch extends Permohonan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara','no_surat','kode_jenis_instansi','kode_instansi','kode_tk','kode_kejati','kode_kejari','kode_cabjari','kode_provinsi','kode_kabupaten',
			'pimpinan_pemohon','status_pemohon','no_status_pemohon','kode_pengadilan_tk1','kode_pengadilan_tk2','tanggal_permohonan',
			'nama_pic','jabatan_pic','no_handphone_pic','permasalahan_pemohon','tanggal_diterima','tanggal_panggilan_pengadilan','file_pemohon','create_user','create_nip','create_nama','create_ip','create_date','update_user','update_nip','update_nama','update_ip','update_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Permohonan::find();
        $this->load($params);
	
        $query->andFilterWhere([
            'tanggal_permohonan' => $this->tanggal_permohonan,
            'tanggal_diterima' => $this->tanggal_diterima,
            'tanggal_panggilan_pengadilan' => $this->tanggal_panggilan_pengadilan,
        ]);

		
		 $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		 if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
	
	
    public function searchPer($params)
    {
        $query = new Query;
		$where = "";
		if($this->no_register_perkara != ""){
			$where = " AND upper(a.no_register_perkara) LIKE '%".strtoupper($this->no_register_perkara)."%' ";
		}

		/* if($this->deskripsi_instansi != ""){
			$where = " AND upper(b.deskripsi_instansi) LIKE '%".strtoupper($this->deskripsi_instansi)."%' ";
		} */
		
        $query = "select a.no_register_perkara,a.no_surat,concat(a.no_surat,'/',a.tanggal_permohonan) as no_tgl,
					b.deskripsi_instansi,a.status
					from datun.permohonan a 
					INNER JOIN datun.instansi b on a.kode_instansi=b.kode_instansi 
					and a.kode_jenis_instansi=b.kode_jenis_instansi 
					where a.no_register_perkara is not null $where";
		
        $this->load($params);
	
    $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();	

	$dataProvider =	new SqlDataProvider([
      'sql' => $query,
	  'totalCount' => (int)$jml,
      'pagination' => [
          'pageSize' => 10,
      ]
	]);

        return $dataProvider;
    }
	
	public function hapusData($post){
		$no_reg 			= htmlspecialchars($post['no_reg'], ENT_QUOTES);
		$no_surat 			= htmlspecialchars($post['no_surat'], ENT_QUOTES);
		$connection = $this->db;
		$transaction = $connection->beginTransaction();
		try {
			$sql1 = "delete from datun.permohonan 
			where no_register_perkara = '".$no_reg."' and no_surat='".$no_surat."'";
			$hasil = $connection->createCommand($sql1)->execute();
				
				if($hasil){
				$sql2 = "delete from datun.turut_tergugat 
						where no_register_perkara = '".$no_reg."' and no_surat='".$no_surat."'";
						$connection->createCommand($sql2)->execute();

				}
			
				if($hasil){
				$sql3 = "delete from datun.lawan_pemohon 
						where no_register_perkara = '".$no_reg."' and no_surat='".$no_surat."'";
						$connection->createCommand($sql3)->execute();

				}
			
			
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    }
	
	
		
	function ubahpermohon($post){
		$connection = Yii::$app->db;
$no_register_perkara	= htmlspecialchars($post['no_reg_perkara'], ENT_QUOTES);//
$no_surat				= htmlspecialchars($post['no_surat'], ENT_QUOTES);//
$kode_jenis_instansi	= htmlspecialchars($post['jns_instansi'], ENT_QUOTES);//
$kode_instansi			= htmlspecialchars($post['kode_instansi'], ENT_QUOTES);

$kode_tk				= $_SESSION['kode_tk'];
$kode_kejati			= $_SESSION['kode_kejati'];
$kode_kejari			= $_SESSION['kode_kejari'];
$kode_cabjari			= $_SESSION['kode_cabjari'];

$kode_provinsi			= htmlspecialchars($post['kode_prop'], ENT_QUOTES);
$kode_kabupaten			= htmlspecialchars($post['kode_wilayah'], ENT_QUOTES);//

$pimpinan_pemohon		= htmlspecialchars($post['nm_pemimpin'], ENT_QUOTES);
$status_pemohon			= htmlspecialchars($post['status_pemohon'], ENT_QUOTES);
$no_status_pemohon		= htmlspecialchars($post['num_status'], ENT_QUOTES);


$kode_pengadilan_tk1	= htmlspecialchars($post['kode_pengadilan_tk1'], ENT_QUOTES);
$kode_pengadilan_tk2	= htmlspecialchars($post['kode_pengadilan_tk2'], ENT_QUOTES);

$tanggal_permohonan		= htmlspecialchars($post['tgl_permohonan'], ENT_QUOTES);//

$nama_pic				= htmlspecialchars($post['nm_pic'], ENT_QUOTES);//
$jabatan_pic			= htmlspecialchars($post['jabatan_pic'], ENT_QUOTES);//
$no_handphone_pic		= htmlspecialchars($post['no_telepon_pic'], ENT_QUOTES);

$permasalahan_pemohon	= htmlspecialchars($post['permasalahan'], ENT_QUOTES);//

$tanggal_diterima		= htmlspecialchars($post['tgl_diterima'], ENT_QUOTES);//
$tanggal_panggilan_pengadilan	= htmlspecialchars($post['tgl_panggilan'], ENT_QUOTES);//

$file_pemohon			= '12'; //htmlspecialchars($post['file_pemohon'], ENT_QUOTES);
$create_user			= $_SESSION['username']; //htmlspecialchars($post['create_user'], ENT_QUOTES);
$create_nip				= $_SESSION['nik_user'];  //htmlspecialchars($post['create_nip'], ENT_QUOTES);
$create_nama			= $_SESSION['nama_pegawai'];  //htmlspecialchars($post['create_nama'], ENT_QUOTES);
$create_ip				= $_SERVER['REMOTE_ADDR'];  //htmlspecialchars($post['create_ip'], ENT_QUOTES);
$create_date			=  '12';//'2016-01-12'; //htmlspecialchars($post['create_date'], ENT_QUOTES);

$update_user			= $_SESSION['username'];  //htmlspecialchars($post['update_user'], ENT_QUOTES);
$update_nip				= $_SESSION['nik_user']; //htmlspecialchars($post['update_nip'], ENT_QUOTES);
$update_nama			= $_SESSION['nama_pegawai']; //htmlspecialchars($post['update_nama'], ENT_QUOTES);
$update_ip				= $_SERVER['REMOTE_ADDR']; //htmlspecialchars($post['update_ip'], ENT_QUOTES);
$update_date			= '12';//htmlspecialchars($post['update_date'], ENT_QUOTES);
$no_urut_wil			= htmlspecialchars($post['no_urut_wil'], ENT_QUOTES);
		
				$transaction = $connection->beginTransaction();
		try {
					
					$sql1 = "update datun.permohonan set 
					kode_jenis_instansi='$kode_jenis_instansi',kode_instansi='$kode_instansi',
					kode_tk='$kode_tk',kode_kejati='$kode_kejati',kode_kejari='$kode_kejari',
					kode_cabjari='$kode_cabjari',kode_provinsi='$kode_provinsi',
					kode_kabupaten='$kode_kabupaten',pimpinan_pemohon='$pimpinan_pemohon',
					status_pemohon='$status_pemohon',no_status_pemohon='$no_status_pemohon',
					kode_pengadilan_tk1='$kode_pengadilan_tk1',kode_pengadilan_tk2='$kode_pengadilan_tk2',
					tanggal_permohonan='$tanggal_permohonan',nama_pic='$nama_pic',jabatan_pic='$jabatan_pic',
					no_handphone_pic='$no_handphone_pic',
					permasalahan_pemohon='$permasalahan_pemohon',tanggal_diterima='$tanggal_diterima',
					tanggal_panggilan_pengadilan='$tanggal_panggilan_pengadilan',file_pemohon='$file_pemohon',
					update_user='$update_user',update_nip='$update_nip',update_nama='$update_nama',
					update_ip='$update_ip',update_date=now(),no_urut_wil='$no_urut_wil' 
					where no_register_perkara='$no_register_perkara' and no_surat='$no_surat'";
					
		$hasil=$connection->createCommand($sql1)->execute();
				if($hasil){
						$sql2 = "delete from datun.turut_tergugat 
								where no_register_perkara = '".$no_register_perkara."' and no_surat='".$no_surat."'";
								$connection->createCommand($sql2)->execute();

						}
					
						if($hasil){
						$sql3 = "delete from datun.lawan_pemohon 
								where no_register_perkara = '".$no_register_perkara."' and no_surat='".$no_surat."'";
								$connection->createCommand($sql3)->execute();

						}
					if(count($post['nm_ins']) > 0){
							foreach($post['nm_ins'] as $idx=>$val){
								$noauto	 = $idx+1;
								$nm_ins	 = htmlspecialchars($post['nm_ins'][$idx], ENT_QUOTES);
								$sts 	 = htmlspecialchars($post['sts'][$idx], ENT_QUOTES);
								$urut 	 = htmlspecialchars($post['urut'][$idx], ENT_QUOTES);
								$sql2 = "insert into datun.turut_tergugat values('".$no_register_perkara."', '".$no_surat."', '".$sts."', '".$urut."', '$noauto', '".$nm_ins."', 'xx', 'xx', 'xx', 'xx')";
								$connection->createCommand($sql2)->execute();
							}
						}
						
					if(count($post['nm_lawan']) > 0){
						foreach($post['nm_lawan'] as $idx=>$val){
							$noauto	 = $idx+1;
							$nm_lawan= htmlspecialchars($post['nm_lawan'][$idx], ENT_QUOTES);
							$sql3 = "insert into datun.lawan_pemohon values('".$no_register_perkara."', '".$no_surat."', '".$noauto."', '".$nm_lawan."')";
							$connection->createCommand($sql3)->execute();
						}
					}
						
		$transaction->commit();
		return true;
			
		} catch (\Exception $e) {
			$transaction->rollBack();
			throw $e; exit();
			return false;
		}
	


	}
	
	
}
