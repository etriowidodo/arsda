<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was16a;
use yii\db\Query;


/**
 * Was16aSearch represents the model behind the search form about `app\modules\pengawasan\models\Was16a`.
 */
class Was16aSearch extends Was16a
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was_16a', 'no_was_16a', 'id_register', 'inst_satkerkd', 'id_terlapor', 'tgl_was_16a', 'perihal', 'ttd_peg_nik', 'ttd_id_jabatan', 'upload_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['kpd_was_16a', 'sifat_surat', 'jml_lampiran', 'satuan_lampiran', 'ttd_was_16a', 'created_by', 'updated_by'], 'integer'],
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
        $query = Was16a::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'kpd_was_16a' => $this->kpd_was_16a,
            'tgl_was_16a' => $this->tgl_was_16a,
            'sifat_surat' => $this->sifat_surat,
            'jml_lampiran' => $this->jml_lampiran,
            'satuan_lampiran' => $this->satuan_lampiran,
            'ttd_was_16a' => $this->ttd_was_16a,
            'flag' => $this->flag,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_was_16a', $this->id_was_16a])
            ->andFilterWhere(['like', 'no_was_16a', $this->no_was_16a])
            ->andFilterWhere(['like', 'id_register', $this->id_register])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'id_terlapor', $this->id_terlapor])
            ->andFilterWhere(['like', 'perihal', $this->perihal])
            ->andFilterWhere(['like', 'ttd_peg_nik', $this->ttd_peg_nik])
            ->andFilterWhere(['like', 'ttd_id_jabatan', $this->ttd_id_jabatan])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
    public function searchPelapor(){
        $query = new Query;
        $query->select('b.nama, b.alamat')
                ->from('was.dugaan_pelanggaran a')
                ->innerJoin('was.pelapor b on (a.id_register=b.id_register)')
                ->where('a.id_register = :idRegister')
                ->addParams([':idRegister' => '1']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!$this->validate()) {
            return $dataProvider;
        }
        return $dataProvider;
    }
    public function searchDataWas16a($id_register){
        $query = new Query;
        $query ->select('a.peg_nama,a.peg_nip_baru, a.jabatan, c.no_was_16a,c.id_was_16a,c.id_register')
                ->from('was.v_riwayat_jabatan a')
                 ->innerjoin('was.terlapor b','a.id=b.id_h_jabatan')
                 ->innerjoin('was.was_16a c','b.id_terlapor=c.id_terlapor')
                 ->where(['c.id_register' =>$id_register])
                 ->andWhere(['c.flag'=>'1'])
                 ->all();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            return $dataProvider;
        }
        return $dataProvider;    
    }
	public function searchKejaksaan($id){
        $query = new Query;
		$query->select('dugaan_pelanggaran.inst_satkerkd,kp_inst_satker.inst_nama')
			->from('was.dugaan_pelanggaran')
			->innerjoin('kepegawaian.kp_inst_satker', 'dugaan_pelanggaran.inst_satkerkd = kp_inst_satker.inst_satkerkd')
			->where(['length(dugaan_pelanggaran.inst_satkerkd)'=> 2])
			->andWhere(['dugaan_pelanggaran.id_register' => $id])
			->andWhere(['kp_inst_satker.is_active' => '1'])
			->all();
                //->where(['peg_nik' => $peg_nik]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!$this->validate()) {
            return $dataProvider;
        }
        return $dataProvider;
    }
}
