<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Penandatangan;
use yii\db\Query;

/**
 * PenandatanganSearch represents the model behind the search form about `app\modules\pengawasan\models\Penandatangan`.
 */
class PenandatanganSearch extends Penandatangan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nip', 'nama_penandatangan', 'pangkat_penandatangan','golongan_penandatangan','id_tingkat_wilayah','jabatan_penandatangan'], 'safe'],
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
        $query = Penandatangan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['nama_penandatangan' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'upper(nip)',strtoupper($this->nip)])
            ->andFilterWhere(['like', 'nama_penandatangan',$this->nama_penandatangan])
            ->andFilterWhere(['like', 'pangkat_penandatangan', strtoupper($this->pangkat_penandatangan)])
            ->andFilterWhere(['like', 'golongan_penandatangan', $this->golongan_penandatangan])
            ->andFilterWhere(['like', 'id_tingkat_wilayah', $this->id_tingkat_wilayah])
            ->andFilterWhere(['like', 'jabatan_penandatangan', $this->jabatan_penandatangan]);

        return $dataProvider;
    }

    
}
