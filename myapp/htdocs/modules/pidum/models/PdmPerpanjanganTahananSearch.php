<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmPerpanjanganTahanan;
use yii\web\Session;
/**
 * PdmPerpanjanganTahananSearch represents the model behind the search form about `app\modules\pidum\models\PdmPerpanjanganTahanan`.
 */
class PdmPerpanjanganTahananSearch extends PdmPerpanjanganTahanan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perpanjangan', 'id_perkara', 'no_surat', 'tgl_surat', 'terima_dari'], 'safe'],
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
		$query = new \yii\db\Query;
		$session = new Session();
		$id_perkara = $session->get('id_perkara');
        
        $this->load($params);
        $lel = $this->id_perpanjangan;
        $lel = strtoupper($lel);
        $where2='';
        if($this->id_perpanjangan!==''){
                    $where2 = " and (upper(a.no_surat) like '%$lel%' or upper(b.nama) like '%$lel%')";
                }

		$query->select (['a.id_perpanjangan as id','a.no_surat','a.tgl_surat','a.tgl_terima','b.nama','f.akronim','c.tgl_dikeluarkan as tgl_t4', "case when d.no_surat<>''  then concat(d.no_surat,'^,DITOLAK') when c.no_surat<>''  then concat(c.no_surat,'^',c.tgl_mulai,'^',c.tgl_selesai) ELSE ''   end as stax",'a.lokasi_penahanan'])
				->from('pidum.pdm_perpanjangan_tahanan a')
				->join('LEFT JOIN', 'pidum.ms_tersangka_pt b', 'a.id_perpanjangan=b.id_perpanjangan and a.no_surat_penahanan=b.no_surat_penahanan')
                                ->join('left join', 'pidum.pdm_t4 c', 'a.id_perpanjangan=c.id_perpanjangan and a.no_surat_penahanan=c.no_surat_penahanan')
                                ->join('left join', 'pidum.pdm_t5 d', 'a.id_perpanjangan=d.id_perpanjangan and a.no_surat_penahanan=d.no_surat_penahanan')
                                ->join('left join', 'pidum.pdm_spdp e', 'a.id_perkara=e.id_perkara')
                                ->join('left join', 'pidum.ms_inst_pelak_penyidikan f', 'f.kode_ipp=e.id_penyidik')
				->where("a.id_perkara = '".$id_perkara."'$where2")


				->all();
        
   
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	
        ]);

        $this->load($params);

        if (!$this->validate()) {
				
            return $dataProvider;
        }
 
        

        return $dataProvider;
		
       
		

        
    }
}
