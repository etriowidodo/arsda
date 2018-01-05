<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmPenetapanBarbuk;
use yii\data\SqlDataProvider;
/**
 * PdmPenetapanBarbukSearch represents the model behind the search form about `app\modules\pidum\models\PdmPenetapanBarbuk`.
 */
class PdmPenetapanBarbukSearch extends PdmPenetapanBarbuk
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sita', 'no_penetapan', 'tersangka', 'id_inst_penyidik', 'id_inst_penyidik_pelaksana', 'tgl_surat', 'dikeluarkan', 'k_pembuktian_perkara', 'k_pengembangan_iptek', 'k_pendidikan_pelatihan', 'dimusnahkan', 'id_penandatangan', 'nama', 'pangkat', 'jabatan', 'file_upload', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
        $query = PdmPenetapanBarbuk::find();

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
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_sita', $this->id_sita])
            ->andFilterWhere(['like', 'no_penetapan', $this->no_penetapan])
            ->andFilterWhere(['like', 'tersangka', $this->tersangka])
            ->andFilterWhere(['like', 'id_inst_penyidik', $this->id_inst_penyidik])
            ->andFilterWhere(['like', 'id_inst_penyidik_pelaksana', $this->id_inst_penyidik_pelaksana])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'k_pembuktian_perkara', $this->k_pembuktian_perkara])
            ->andFilterWhere(['like', 'k_pengembangan_iptek', $this->k_pengembangan_iptek])
            ->andFilterWhere(['like', 'k_pendidikan_pelatihan', $this->k_pendidikan_pelatihan])
            ->andFilterWhere(['like', 'dimusnahkan', $this->dimusnahkan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'pangkat', $this->pangkat])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'file_upload', $this->file_upload])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
	
	public function searchdetail($id_perkara)
	{
		
	  
	  $query = " SELECT id_sita as id , no_penetapan,to_char(tgl_surat,'dd-mm-yyyy') as tgl_surat, tersangka as tersangka
	  FROM pidum.pdm_penetapan_barbuk a
 ";

	  $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();


	$dataProvider =	new SqlDataProvider([
      'sql' => $query,
	  'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
              'id',
              'penetapan',
              'barbuk',
         ],
     ],
      'pagination' => [
          'pageSize' => 10,
      ]
]);
		 return $dataProvider;
        
	}
}
