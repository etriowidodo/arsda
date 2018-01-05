<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmSpdp;

/**
 * PidumPdmSpdpSearch represents the model behind the search form about `app\modules\pidum\models\PidumPdmSpdp`.
 */
class PdmSpdpSearch extends PdmSpdp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perkara', 'id_asalsurat', 'id_penyidik', 'no_surat', 'tgl_surat', 'tgl_terima','tgl_sprindik','no_sprindik', 'ket_kasus'], 'safe'],
            [['id_pk_ting_ref'], 'integer'],
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
        $query = PdmSpdp::find();

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
            'id_pk_ting_ref' => $this->id_pk_ting_ref,
        ]);

        $query->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'id_asalsurat', $this->id_asalsurat])
            ->andFilterWhere(['like', 'id_penyidik', $this->id_penyidik])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'ket_kasus', $this->ket_kasus]);

        return $dataProvider;
    }

    public function searchSpdp($params){
        $query = new \yii\db\Query;

        $query->select('a.id_perkara, d.nama as asal_surat, e.nama as asal_penyidik, a.no_surat, a.tgl_surat, c.url')
            ->from('pidum.pdm_spdp a')
            ->join('inner join', 'pidum.pdm_trx_pemrosesan b', 'a.id_perkara = b.id_perkara')
            ->join('inner join', 'pidum.pdm_sys_menu c', 'b.id_sys_menu::integer = c.id')
            ->join('inner join', 'pidum.ms_asalsurat d', 'a.id_asalsurat = d.id_asalsurat')
            ->join('inner join', 'pidum.ms_penyidik e', 'a.id_penyidik = e.id_penyidik')
            ->all();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        /*$query->andFilterWhere(['like', "CONCAT(a.thn_pelayanan,'/',a.bundel_pelayanan,'/',a.no_urut_pelayanan)", $this->no_urut_pelayanan])
            ->andFilterWhere(['like', 'd.nm_pegawai', $this->nm_pegawai])
            ->andFilterWhere(['=', 'c.kd_jns_pelayanan', $this->nm_jenis_pelayanan])
            ->andFilterWhere(['=', 'a.tgl_surat_permohonan', ($this->tgl_surat_permohonan != null ) ? date("Y-m-d",strtotime($this->tgl_surat_permohonan)) : '' ])
            ->andFilterWhere(['=', 'a.id_tujuan', \Yii::$app->user->identity->id]);*/

        return $dataProvider;
    }
}
