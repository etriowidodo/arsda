<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmTetapHakim;
use yii\db\Query;

/**
 * pdmTetapHakimSearch represents the model behind the search form about `app\modules\pidum\models\PdmTetapHakim`.
 */
class pdmTetapHakimSearch extends PdmTetapHakim
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_thakim', 'id_perkara', 'no_surat', 'tgl_surat', 'tgl_terima', 'lokasi', 'uraian', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['id_msstatusdata', 'created_by', 'updated_by'], 'integer'],
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
    public function search($id_perkara,$params)
    {
        // $query = PdmTetapHakim::find();
		$query = new Query();
        $query->select('a.no_surat,a.tgl_surat, a.tgl_terima, a.lokasi,a.id_thakim')
              ->from('pidum.pdm_tetap_hakim a')
              ->where('a.id_perkara=:id_perkara AND a.flag<>:flag',[':id_perkara'=>$id_perkara,':flag'=>'3']);

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
            'tgl_surat' => $this->tgl_surat,
            'tgl_terima' => $this->tgl_terima,
            'id_msstatusdata' => $this->id_msstatusdata,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_thakim', $this->id_thakim])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'lokasi', $this->lokasi])
            ->andFilterWhere(['like', 'uraian', $this->uraian])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
