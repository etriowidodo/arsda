<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\DugaanPelanggaran;
use app\modules\pengawasan\models\VDugaanPelanggaranIndex;
use yii\data\SqlDataProvider;

/**
 * DugaanPelanggaranSearch represents the model behind the search form about `app\models\DugaanPelanggaran`.
 */
class DugaanPelanggaranSearch extends DugaanPelanggaran
{
    public $terlapor;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_register', 'wilayah', 'inspektur', 'sumber_dugaan', 'sumber_pelapor', 'status', 'created_by', 'updated_by'], 'integer'],
            [['no_register', 'inst_satkerkd', 'tgl_dugaan', 'tgl_surat', 'perihal', 'ringkasan', 'upload_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time','terlapor'], 'safe'],
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

        public function searchIndex($params)
    {
        $query = VDugaanPelanggaranIndex::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
			'pageSize' => 3,
		],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

         $query->andFilterWhere(['like', 'no_register', $this->no_register])
            ->andFilterWhere(['like', 'terlapor', $params['terlapor']])
            ->andFilterWhere(['inst_satkerkd'=> $this->inst_satkerkd]);
           
      //   print_r($query);
        return $dataProvider;
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
        /*
		if(!empty($this->id_register)){
		$query = "select a.id_register,a.no_register, a.wilayah, a.inspektur, b.inst_nama,a.tgl_dugaan,f.peg_nip||' - '||f.peg_nama||' dkk' as terlapor from was.dugaan_pelanggaran a
		inner join kepegawaian.kp_inst_satker b on (a.inst_satkerkd=b.inst_satkerkd)
		inner join (
		select c.id_terlapor,c.id_register,c.id_h_jabatan,e.peg_nama,e.peg_nip from was.terlapor c
		inner join kepegawaian.kp_h_jabatan d on (c.id_h_jabatan=d.id)
		inner join kepegawaian.kp_pegawai e on (c.peg_nik=e.peg_nik)where c.id_register='".$this->id_register."' order by 1 asc limit 1)f
        on (a.id_register=f.id_register) where a.id_register='".$this->id_register."' order by a.tgl_dugaan desc";
		}
		else{
		*/
		$query = "select a.id_register,a.no_register,b.inst_nama,a.tgl_dugaan,tgl_surat,f.peg_nip_baru||' - '||f.peg_nama||case when f.jml_terlapor > 1 then ' dkk' else '' end as terlapor,g.name as status from was.dugaan_pelanggaran a
		inner join kepegawaian.kp_inst_satker b on (a.inst_satkerkd=b.inst_satkerkd)
		inner join public.menu g on (a.status=g.id)
		inner join (
		select c.id_terlapor,c.id_register,c.id_h_jabatan,e.peg_nama,e.peg_nip,e.peg_nip_baru,y.jml_terlapor from was.terlapor c
		inner join kepegawaian.kp_h_jabatan d on (c.id_h_jabatan=d.id)
		inner join kepegawaian.kp_pegawai e on (c.peg_nik=e.peg_nik)
        inner join (select z.id_register,min(z.id_terlapor)as id_terlapor,
        count(*) as jml_terlapor from was.terlapor z group by 1)y on (c.id_terlapor=y.id_terlapor)order by 1 asc)f
        on (a.id_register=f.id_register) where flag != '3' order by a.tgl_dugaan desc";
		//}
		
		$dataProvider = new SqlDataProvider([
		'sql' => $query,
		//'params' => [':status' => 1],
		'totalCount' => $count,
		'pagination' => [
			'pageSize' => 10,
		],
		'sort' => [
			'attributes' => [
				'title',
				'view_count',
				'created_at',
			],
		],
	]);
		/*
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		*/
		
		/*
        $query->andFilterWhere([
            'id_register' => $this->id_register,
            'wilayah' => $this->wilayah,
            'inspektur' => $this->inspektur,
            'tgl_dugaan' => $this->tgl_dugaan,
            'sumber_dugaan' => $this->sumber_dugaan,
            'sumber_pelapor' => $this->sumber_pelapor,
            'status' => $this->status,
            'flag' => $this->flag,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register', $this->no_register])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'perihal', $this->perihal])
            ->andFilterWhere(['like', 'ringkasan', $this->ringkasan])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);
		*/
		
        return $dataProvider;
    }
}
                                   