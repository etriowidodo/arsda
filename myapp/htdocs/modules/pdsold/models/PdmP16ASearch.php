<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\modules\pdsold\models\PdmP16a;
use yii\db\Query;

/**
 * PdmP16ASearch represents the model behind the search form about `app\modules\pidum\models\PdmP16A`.
 */
class PdmP16ASearch extends PdmP16a {

    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p16a', 'dikeluarkan', 'tgl_dikeluarkan', 'id_penandatangan'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($no_register, $params) {
        $query = PdmP16a::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
//        $query->andWhere(['=', 'no_register_perkara', $no_register]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['tgl_dikeluarkan' => $this->tgl_dikeluarkan, ]);
        
        $query->andFilterWhere(['like', 'no_surat_p16a', $this->no_surat_p16a])
           ->andFilterWhere(['=', 'no_register_perkara', $no_register])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan]);

        return $dataProvider;
    }
    public function search2($no_register_perkara,$params) {
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_jaksa_p16')
                ->where("id_perkara='".$no_register_perkara."'");


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        return $dataProvider;
    }

    


}
