<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmP24;

/**
 * PdmP24Search represents the model behind the search form about `app\modules\pidum\models\PdmP24`.
 */
class PdmP24Search extends PdmP24
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p24', 'id_berkas',  'ket_saksi', 'ket_ahli', 'alat_bukti', 'benda_sitaan', 'ket_tersangka', 'fakta_hukum', 'yuridis', 'kesimpulan', 'pendapat', 'saran', 'petunjuk'], 'safe'],
            [['status_berkas'], 'boolean'],
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
    public function search($id_perkara, $params)
    {
        $query = PdmP24::find();		
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
          $query->andWhere(['!=', 'flag', '3']);
          $query->andwhere(['=', 'id_perkara', $id_perkara]);
          
        $query->andFilterWhere([
            
            'status_berkas' => $this->status_berkas,
        ]);

        $query->andFilterWhere(['like', 'id_p24', $this->id_p24])
            ->andFilterWhere(['like', 'id_berkas', $this->id_berkas])
            ->andFilterWhere(['like', 'ket_saksi', $this->ket_saksi])
            ->andFilterWhere(['like', 'ket_ahli', $this->ket_ahli])
            ->andFilterWhere(['like', 'alat_bukti', $this->alat_bukti])
            ->andFilterWhere(['like', 'benda_sitaan', $this->benda_sitaan])
            ->andFilterWhere(['like', 'ket_tersangka', $this->ket_tersangka])
            ->andFilterWhere(['like', 'fakta_hukum', $this->fakta_hukum])
            ->andFilterWhere(['like', 'yuridis', $this->yuridis])
            ->andFilterWhere(['like', 'kesimpulan', $this->kesimpulan])
            ->andFilterWhere(['like', 'pendapat', $this->pendapat])
            ->andFilterWhere(['like', 'saran', $this->saran])
			         ->andFilterWhere(['!=', 'flag', 3])
            ->andFilterWhere(['like', 'petunjuk', $this->petunjuk]);

        return $dataProvider;
    }
}
