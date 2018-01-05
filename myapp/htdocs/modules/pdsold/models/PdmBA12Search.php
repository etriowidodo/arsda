<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmBa12;
use yii\db\Query;

/**
 * PdmBA12Search represents the model behind the search form about `app\modules\pidum\models\PdmBA12`.
 */
class PdmBa12Search extends PdmBa12
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba12', 'id_t8', 'tgl_pembuatan', 'id_tersangka', 'no_reg_perkara', 'no_reg_tahanan','tgl_penahanan','no_sp','tgl_sp','tindakan','id_ms_loktahanan','tgl_mulai','kepala_rutan','id_perkara'], 'safe'],
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
        $query = PdmBa12::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andWhere(['=', 'id_perkara', $id]);
        $query->andWhere(['<>', 'flag', '3']);

        $query->andFilterWhere([
            'tgl_penahanan' => $this->tgl_penahanan,
            'tgl_sp' => $this->tgl_sp,
        ]);

        $query->andFilterWhere(['like', 'id_ba12', $this->id_ba12])
            ->andFilterWhere(['like', 'id_t8', $this->id_t8])
            ->andFilterWhere(['like', 'tgl_pembuatan', $this->tgl_pembuatan])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'kepala_rutan', $this->kepala_rutan]);

        return $dataProvider;
    }
}
