<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmT4;
use yii\data\SqlDataProvider;
/**
 * PdmT4Search represents the model behind the search form about `app\modules\pidum\models\PdmT4`.
 */
class PdmT4Search extends PdmT4
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_t4', 'no_surat', 'tgl_dikeluarkan', 'dikeluarkan', 'tgl_mulai', 'tgl_selesai', 'id_penandatangan'], 'safe'],
            [['id_loktahanan'], 'integer'],
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
    public function search($id_perkara)
    {
       $query = " select a.id_t4,a.no_surat,a.tgl_dikeluarkan, a.tgl_mulai, a.tgl_selesai, c.nama 
	   FROM pidum.pdm_t4 a 
	   inner join pidum.pdm_perpanjangan_tahanan b on a.id_perpanjangan = b.id_perpanjangan and a.no_surat_penahanan=b.no_surat_penahanan
	   inner join pidum.ms_tersangka_pt c on b.id_perpanjangan = c.id_perpanjangan and a.no_surat_penahanan=c.no_surat_penahanan
	   WHERE b.id_perkara='".$id_perkara."'
 ";

	  $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();


	$dataProvider =	new SqlDataProvider([
      'sql' => $query,
	  'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
              'id_t4',
              'no_surat',
         ],
     ],
      'pagination' => [
          'pageSize' => 10,
      ]
]);
		 return $dataProvider;
    }
}
