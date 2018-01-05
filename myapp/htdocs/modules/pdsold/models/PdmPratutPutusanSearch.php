<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmPratutPutusan;

/**
 * PdmPratutPutusanSearch represents the model behind the search form about `app\modules\pidum\models\PdmPratutPutusan`.
 */
class PdmPratutPutusanSearch extends PdmPratutPutusan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pratut', 'id_perkara', 'no_surat', 'tgl_surat', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['is_proses', 'created_by', 'updated_by'], 'integer'],
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
    public function search($id_berkas ,$params)
    {
        $query = PdmBerkas::find()
		->select ("a.no_pengiriman as no,
				string_agg(c.nama, ', ') as nama,
				d.is_proses as proses,
				a.tgl_pengiriman as tgl,
					d.tgl_surat as surat")
		->from('pidum.pdm_berkas a')
		->join('left join','pidum.pdm_tahanan_penyidik b','a.id_berkas = b.id_berkas')
		->join('left join','pidum.ms_tersangka c',' b.id_tersangka = c.id_tersangka')
		->join('left join','pidum.pdm_pratut_putusan d','d.id_berkas = a.id_berkas')
		->where("b.id_berkas is not null and b.flag <> '3' and a.flag <> '3' and a.id_berkas='".$id_berkas."' GROUP BY a.id_berkas,d.is_proses,d.tgl_surat");
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

         /* if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
             $query->andWhere(['!=', 'flag', '3']);
             $query->andwhere(['=', 'id_perkara', $id_perkara]);
        
      $query->andFilterWhere([
            'tgl_surat' => $this->tgl_surat,
          //  'tgl_terima' => $this->tgl_terima,
            'is_proses' => $this->is_proses,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_pratut', $this->id_pratut])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);
*/
        return $dataProvider;
    }
}
