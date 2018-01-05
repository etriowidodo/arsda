<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\MkjBapeg;
use yii\db\Query;

/**
 * MkjBapegSearch represents the model behind the search form about `app\modules\pengawasan\models\MkjBapeg`.
 */
class MkjBapegSearch extends MkjBapeg
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_mkj_bapeg', 'no_mkj_bapeg', 'id_register', 'inst_satkerkd', 'tgl_mkj_bapeg', 'id_terlapor', 'tingkat_kd', 'upload_file', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['hasil_putusan', 'id_peraturan', 'created_by', 'updated_by'], 'integer'],
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
        //$query = MkjBapeg::find();

        $query = new Query();
        $query->select(['a.peg_nama','a.peg_nip','a.jabatan','c.no_mkj_bapeg','c.id_mkj_bapeg'])
            ->from(['was.v_terlapor a'])
            ->innerJoin(['was.mkj_bapeg c'],'a.id_terlapor=c.id_terlapor')
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
            'tgl_mkj_bapeg' => $this->tgl_mkj_bapeg,
            'hasil_putusan' => $this->hasil_putusan,
            'id_peraturan' => $this->id_peraturan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_mkj_bapeg', $this->id_mkj_bapeg])
            ->andFilterWhere(['like', 'no_mkj_bapeg', $this->no_mkj_bapeg])
            ->andFilterWhere(['like', 'id_register', $this->id_register])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'id_terlapor', $this->id_terlapor])
            ->andFilterWhere(['like', 'tingkat_kd', $this->tingkat_kd])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
