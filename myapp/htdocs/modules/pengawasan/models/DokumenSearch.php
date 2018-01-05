<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Dokumen;

/**
 * DokumenSearch represents the model behind the search form about `app\models\Dokumen`.
 */
class DokumenSearch extends Dokumen
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_dokumen', 'parent', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['kd_dokumen', 'nm_dokumen', 'url', 'proses', 'keterangan', 'upload_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
        $query = Dokumen::find();

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
            'id_dokumen' => $this->id_dokumen,
            'parent' => $this->parent,
            'is_deleted' => $this->is_deleted,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'kd_dokumen', $this->kd_dokumen])
            ->andFilterWhere(['like', 'nm_dokumen', $this->nm_dokumen])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'proses', $this->proses])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
