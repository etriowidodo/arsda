<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmT15;
use yii\db\Query;

/**
 * PdmT15Search represents the model behind the search form about `app\modules\pidum\models\PdmT15`.
 */
class PdmT15Search extends PdmT15
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_t15', 'id_t8', 'no_surat', 'sifat', 'lampiran', 'kepada', 'di', 'no_registrasi', 'tgl_registrasi', 'put_pengadilan', 'tgl_kabur', 'id_tersangka', 'modus', 'kerugian', 'id_penandatangan', 'id_perkara', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
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
        //$query = PdmT15::find();

        //$query = PdmT15::find()->with('tersangka')->where(['id_perkara'=>$params]);

        //$query = PdmT15::find()->joinWith('tersangka')->where(['pidum.pdm_t15.id_perkara'=>$params])->all();

        $query = new Query();
        $query->select('*')
            ->from('pidum.pdm_t15')
            ->innerJoin('pidum.vw_terdakwa', 'pidum.vw_terdakwa.id_tersangka = pidum.pdm_t15.id_tersangka')
            ->where('pidum.pdm_t15.id_perkara=:id_perkara AND pidum.pdm_t15.flag<>:flag',[':id_perkara'=>$params,':flag'=>'3']);

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
            'tgl_registrasi' => $this->tgl_registrasi,
            'tgl_kabur' => $this->tgl_kabur,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_t15', $this->id_t15])
            ->andFilterWhere(['like', 'id_t8', $this->id_t8])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di', $this->di])
            ->andFilterWhere(['like', 'no_registrasi', $this->no_registrasi])
            ->andFilterWhere(['like', 'put_pengadilan', $this->put_pengadilan])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'modus', $this->modus])
            ->andFilterWhere(['like', 'kerugian', $this->kerugian])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }

    public function searchTersangka($params)
    {
        $query = new Query;
        //$query->select(*)->from(pidum.vw_terdakwa)->where('id_tersangka=:id_tersangka',[':id_tersangka'=>$id_tersangka]);
        $query->select('*')->from('pidum.vw_terdakwa')->where('id_perkara=:id_perkara',[':id_perkara'=>$params]);

        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
            'pagination'=>[
                'pageSize'=>10,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl_registrasi' => $this->tgl_registrasi,
            'tgl_kabur' => $this->tgl_kabur,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_t15', $this->id_t15])
            ->andFilterWhere(['like', 'id_t8', $this->id_t8])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di', $this->di])
            ->andFilterWhere(['like', 'no_registrasi', $this->no_registrasi])
            ->andFilterWhere(['like', 'put_pengadilan', $this->put_pengadilan])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'modus', $this->modus])
            ->andFilterWhere(['like', 'kerugian', $this->kerugian])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
