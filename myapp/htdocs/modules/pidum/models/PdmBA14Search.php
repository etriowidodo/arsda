<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmBa14;
use yii\db\Query;

/**
 * PdmBA14Search represents the model behind the search form about `app\modules\pidum\models\PdmBA14`.
 */
class PdmBa14Search extends PdmBa14
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba14', 'id_t8', 'id_tersangka', 'tgl_pembuatan'], 'safe'],
            [['id_ms_loktahanan'], 'integer'],
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
    public function search($id, $params)
    {
        // $query = PdmBA14::find();

        $query = new Query();
        $query->select('*')
            ->from('pidum.pdm_ba14')
            ->innerJoin('pidum.vw_terdakwa', 'pidum.vw_terdakwa.id_tersangka = pidum.pdm_ba14.id_tersangka')
            ->where('pidum.pdm_ba14.id_perkara=:id_perkara AND pidum.pdm_ba14.flag<>:flag',[':id_perkara'=>$id,':flag'=>'3']);


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
            'tgl_pembuatan' => $this->tgl_pembuatan,
            'id_ms_loktahanan' => $this->id_ms_loktahanan,
            
        ]);

        $query->andFilterWhere(['like', 'id_ba14', $this->id_ba14])
            ->andFilterWhere(['like', 'id_t8', $this->id_t8])
            ->andFilterWhere(['like', 'tgl_pembuatan', $this->tgl_pembuatan])
            ->andFilterWhere(['like', 'no_reg_perkara', $this->no_reg_perkara])
            ->andFilterWhere(['like', 'no_reg_tahanan', $this->no_reg_tahanan])
            ->andFilterWhere(['like', 'tgl_mulai_tahan', $this->tgl_mulai_tahan]);

        return $dataProvider;
    }
	
	 
}
