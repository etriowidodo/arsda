<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Tun;
use yii\db\Query;

/**
 * TunSearch represents the model behind the search form about `app\modules\pengawasan\models\Tun`.
 */
class TunSearch extends Tun
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tun', 'no_tun', 'id_register', 'inst_satkerkd', 'tgl_tun', 'id_terlapor', 'upload_file', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['hasil_putusan', 'created_by', 'updated_by'], 'integer'],
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
        //$query = Tun::find();

        $query = new Query();
        $query->select(['a.peg_nama','a.peg_nip','a.jabatan','c.id_tun','c.no_tun'])
            ->from(['was.v_terlapor a'])
            ->innerJoin(['was.tun c'],'a.id_terlapor=c.id_terlapor')
            ->where('c.id_register=:id_register AND c.flag<>:flag',[':id_register'=>$params,':flag'=>'3']);

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
            'tgl_tun' => $this->tgl_tun,
            'hasil_putusan' => $this->hasil_putusan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_tun', $this->id_tun])
            ->andFilterWhere(['like', 'no_tun', $this->no_tun])
            ->andFilterWhere(['like', 'id_register', $this->id_register])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'id_terlapor', $this->id_terlapor])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
