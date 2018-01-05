<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmT5;
use yii\data\SqlDataProvider;
/**
 * PdmT5Search represents the model behind the search form about `app\modules\pidum\models\PdmT5`.
 */
class PdmT5Search extends PdmT5
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_t5', 'no_surat', 'sifat', 'lampiran',  'tgl_dikeluarkan', 'dikeluarkan','tgl_resume', 'kepada', 'di_kepada', 'alasan', 'id_penandatangan'], 'safe'],
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


    public function search($id_perkara)
    {
       $query = " select a.id_t5,a.no_surat,a.kepada, a.di_kepada, c.nama, to_char(a.tgl_dikeluarkan,'dd-mm-yyyy') as tgl_dikeluarkan 
	   FROM pidum.pdm_t5 a 
	   inner join pidum.pdm_perpanjangan_tahanan b on a.id_perpanjangan = b.id_perpanjangan
	   inner join pidum.ms_tersangka_pt c on b.id_perpanjangan = c.id_perpanjangan
	   WHERE b.id_perkara='".$id_perkara."'
 ";

	  $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();


	$dataProvider =	new SqlDataProvider([
      'sql' => $query,
	  'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
              'id_t5',
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
