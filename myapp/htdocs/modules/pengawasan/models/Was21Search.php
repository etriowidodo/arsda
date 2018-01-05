<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was21;

/**
 * Was21Search represents the model behind the search form about `app\modules\pengawasan\models\Was21`.
 */
class Was21Search extends Was21
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was_21', 'no_was_21', 'id_register', 'inst_satkerkd', 'tgl_was_21', 'perihal', 'id_terlapor', 'tingkat_kd', 'ttd_peg_nik', 'upload_file', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['sifat_surat', 'jml_lampiran', 'satuan_lampiran', 'kpd_was_21', 'ttd_was_21', 'pendapat', 'id_peraturan', 'kputusan_ja', 'ttd_id_jabatan', 'created_by', 'updated_by'], 'integer'],
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
        $query = Was21::find();

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
            'tgl_was_21' => $this->tgl_was_21,
            'sifat_surat' => $this->sifat_surat,
            'jml_lampiran' => $this->jml_lampiran,
            'satuan_lampiran' => $this->satuan_lampiran,
            'kpd_was_21' => $this->kpd_was_21,
            'ttd_was_21' => $this->ttd_was_21,
            'pendapat' => $this->pendapat,
            'id_peraturan' => $this->id_peraturan,
            'kputusan_ja' => $this->kputusan_ja,
            'ttd_id_jabatan' => $this->ttd_id_jabatan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_was_21', $this->id_was_21])
            ->andFilterWhere(['like', 'no_was_21', $this->no_was_21])
            ->andFilterWhere(['like', 'id_register', $this->id_register])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'perihal', $this->perihal])
            ->andFilterWhere(['like', 'id_terlapor', $this->id_terlapor])
            ->andFilterWhere(['like', 'tingkat_kd', $this->tingkat_kd])
            ->andFilterWhere(['like', 'ttd_peg_nik', $this->ttd_peg_nik])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
    
     public function searchWas21($params,$id_register)
    {
         
            
            $query = Was21::find()->where("flag = '1' and id_register = :id",[":id"=>$id_register]);
				
				//->all();;
		
		
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
			'pageSize' => 10,
			],
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
