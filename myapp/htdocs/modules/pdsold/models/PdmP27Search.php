<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmP27;
use yii\db\Query;
use yii\data\SqlDataProvider;

/**
 * PdmP27Search represents the model behind the search form about `app\modules\pidum\models\PdmP27`.
 */
class PdmP27Search extends PdmP27
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p27', 'tgl_ba', 'no_putusan', 'tgl_putusan', 'id_tersangka', 'keterangan_tersangka', 'keterangan_saksi', 'dari_benda', 'dari_petunjuk', 'alasan', 'dikeluarkan', 'tgl_surat', 'id_penandatangan', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
    public function search($no_register,$params)
    {
        $query = PdmP27::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andWhere(['=', 'no_register_perkara', $no_register]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl_ba' => $this->tgl_ba,
            'tgl_putusan' => $this->tgl_putusan,
            'tgl_surat' => $this->tgl_surat,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_surat_p27', $this->no_surat_p27])
            ->andFilterWhere(['like', 'no_putusan', $this->no_putusan])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'keterangan_tersangka', $this->keterangan_tersangka])
            ->andFilterWhere(['like', 'keterangan_saksi', $this->keterangan_saksi])
            ->andFilterWhere(['like', 'dari_benda', $this->dari_benda])
            ->andFilterWhere(['like', 'dari_petunjuk', $this->dari_petunjuk])
            ->andFilterWhere(['like', 'alasan', $this->alasan])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
    
    public function search2($no_register,$params)
    {
        $sql    = "select * from pidum.pdm_p27 where no_register_perkara = '".$no_register."'";
        $kueri  = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
        $count  = $kueri->queryScalar();
        $dataProvider = new SqlDataProvider([
            'query'         => $query,
            'totalCount'    => $count,
        ]);
    }
}
