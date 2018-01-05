<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmBa13;
use yii\db\Query;

/**
 * pdmBa13Search represents the model behind the search form about `app\modules\pidum\models\PdmBa13`.
 */
class PdmBa13Search extends PdmBa13
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba13', 'id_perkara', 'id_t8', 'tgl_pembuatan', 'id_tersangka', 'no_reg_perkara', 'no_reg_tahanan', 'tgl_penahanan', 'no_sp', 'tgl_sp', 'tindakan', 'tgl_mulai', 'kepala_rutan', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['id_ms_loktahanan', 'created_by', 'updated_by'], 'integer'],
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
        $query = PdmBa13::find();
        // $query = new Query();
        // $query->select('*')
        //     ->from('pidum.pdm_ba13')
        //     ->innerJoin('pidum.vw_terdakwa', 'pidum.vw_terdakwa.id_tersangka = pidum.pdm_ba13.id_tersangka')
        //     ->where('pidum.pdm_ba13.id_perkara=:id_perkara AND pidum.pdm_ba13.flag<>:flag',[':id_perkara'=>$id,':flag'=>'3']);

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
            'tgl_pembuatan' => $this->tgl_pembuatan,
            'tgl_penahanan' => $this->tgl_penahanan,
            'tgl_sp' => $this->tgl_sp,
            'id_ms_loktahanan' => $this->id_ms_loktahanan,
            'tgl_mulai' => $this->tgl_mulai,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_ba13', $this->id_ba13])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'id_t8', $this->id_t8])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'no_reg_perkara', $this->no_reg_perkara])
            ->andFilterWhere(['like', 'no_reg_tahanan', $this->no_reg_tahanan])
            ->andFilterWhere(['like', 'no_sp', $this->no_sp])
            ->andFilterWhere(['like', 'tindakan', $this->tindakan])
            ->andFilterWhere(['like', 'kepala_rutan', $this->kepala_rutan])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);
        return $dataProvider;
    }
}
