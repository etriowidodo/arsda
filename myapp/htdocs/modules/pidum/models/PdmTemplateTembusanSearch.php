<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmTemplateTembusan;
use yii\db\Query;
use yii\data\SqlDataProvider;

/**
 * PdmTemplateTembusanSearch represents the model behind the search form about `app\modules\pidum\models\PdmTemplateTembusan`.
 */
class PdmTemplateTembusanSearch extends PdmTemplateTembusan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tmp_tembusan'], 'integer'],
            [['kd_berkas', 'no_urut', 'tembusan', 'flag', 'keterangan'], 'safe'],
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
        /*$query = PdmTemplateTembusan::find();

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
            'id_tmp_tembusan' => $this->id_tmp_tembusan,
        ]);

			$query->andFilterWhere(['like', 'kd_berkas', $this->kd_berkas])
            ->andFilterWhere(['like', 'no_urut', $this->no_urut])
            ->andFilterWhere(['like', 'tembusan', $this->tembusan])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);*/
	$this->load($params);
	
	$where = "";
	if($this->kd_berkas != ""){
		$where = " AND upper(b.kd_berkas) LIKE '%".strtoupper($this->kd_berkas)."%' ";
	}

	if($this->keterangan != ""){
		$where = " AND upper(b.keterangan) LIKE '%".strtoupper($this->keterangan)."%' ";
	}

	
	$query = " SELECT b.kd_berkas, b.keterangan, case when a.kd_berkas is null then 'Tidak Ada' ELSE 'Ada' END as status FROM  pidum.pdm_sys_menu b LEFT JOIN pidum.pdm_template_tembusan a  on UPPER(a.kd_berkas) = UPPER(b.kd_berkas)  WHERE 1=1 $where group by b.kd_berkas, b.keterangan,a.kd_berkas ORDER BY b.kd_berkas  ";		

	$jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();	

	$dataProvider =	new SqlDataProvider([
      'sql' => $query,
	  'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
              'kd_berkas',
              'keterangan',
         ],
     ],
      'pagination' => [
          'pageSize' => 10,
      ]
]);

        return $dataProvider;
    }
}
