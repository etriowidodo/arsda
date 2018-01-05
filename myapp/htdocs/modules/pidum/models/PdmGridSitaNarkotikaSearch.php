<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\VwGridPrapenuntutan;
use yii\data\SqlDataProvider;
/**
 * VwGridPrapenuntutanSearch represents the model behind the search form about `app\modules\pidum\models\VwGridPrapenuntutan`.
 */
class PdmGridSitaNarkotikaSearch extends PdmGridSitaNarkotika
{
    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['id_perkara', 'no_surat', 'tgl_surat', 'assurat', 'tgl_terima', 'no_p16', 'tgl_p16', 'jpu', 'tersangka', 'id_sys_menu', 'data_berkas'], 'safe'],
        ];
    }*/

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
        $query = PdmGridSitaNarkotika::find();

        //$this->load($params);
	

			//$query->andFilterWhere(['like','no_penetapan','le']);
			      //->orFilterWhere(['like', 'upper(no_surat)', strtoupper($this->id_perkara)])

		
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
}
