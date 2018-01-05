<?php

namespace app\modules\pengawasan\models;

// use Yii;
// use yii\base\Model;
// use yii\data\ActiveDataProvider;
// use app\modules\pengawasan\models\SPWas1Terlapor;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
/**
 * PemeriksaSearch represents the model behind the search form about `app\modules\pengawasan\models\Pemeriksa`.
 */
class SPWas1TerlaporSearch extends SPWas1Terlapor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','peg_instakhir','peg_nik','peg_nip','peg_nip_baru','peg_nama','gol_kd','pangkat','jabatan','inst_nama'], 'safe'],
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
        //$var=str_split(($_SESSION['is_inspektur_irmud_riksa']));
        // $query = SPWas1Terlapor::findBySql("select * from was.vw_pegawai_terlapor");

         $query = new Query;
        $query->select('*')
                ->from('was.vw_pegawai_terlapor');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
            'pageSize' => 15,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

   //      $query->andFilterWhere([
   //          'id' => $this->id,
   //          'peg_nip_baru' => $this->peg_nip_baru,
   //          'peg_nama' => $this->peg_nama,
   //          'pangkat' => $this->pangkat,
   //          'jabatan' => $this->jabatan,
			// 'gol_kd' => $this->gol_kd,
			// 'inst_nama' => $this->inst_nama,
            
   //      ]);

        $query->andFilterWhere(['like', 'id', strtoupper($this->id)])
            ->andFilterWhere(['like', 'peg_nip_baru', strtoupper($this->peg_nip_baru)])
            ->andFilterWhere(['like', 'peg_nama', strtoupper($this->peg_nama)])
            ->andFilterWhere(['like', 'pangkat', strtoupper($this->pangkat)])
			->andFilterWhere(['like', 'gol_kd', strtoupper($this->gol_kd)])
			->andFilterWhere(['like', 'inst_nama', strtoupper($this->inst_nama)])
            ->andFilterWhere(['like', 'jabatan', strtoupper($this->jabatan)]);

        return $dataProvider;
    }
}
