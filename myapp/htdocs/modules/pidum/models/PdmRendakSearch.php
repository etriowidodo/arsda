<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmRendak;
use yii\data\SqlDataProvider;
/**
 * PdmRendakSearch represents the model behind the search form about `app\modules\pidum\models\PdmRendak`.
 */
class PdmRendakSearch extends PdmRendak
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_rendak', 'id_perkara', 'id_berkas', 'dikeluarkan', 'tgl_dikeluarkan', 'id_penandatangan', 'nama', 'pangkat', 'jabatan'], 'safe'],
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
         $query = " select d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY') as berkas,a.id_pengantar,coalesce(b.id_rendak,'0') as id_rendak ,string_agg(f.nama,', ') as nama
,coalesce(to_char(b.tgl_dikeluarkan,'DD-MM-YYYY'),'-')  as tgl_rendak,d.id_berkas
	  from 
	  pidum.pdm_berkas_tahap1 d 
	  INNER JOIN (
			select x.* from 
			pidum.pdm_pengantar_tahap1 x inner join (
				select max(id_pengantar) as id_pengantar from pidum.pdm_pengantar_tahap1 group by id_berkas 
			)y on x.id_pengantar = y.id_pengantar
                    ) e on d.id_berkas = e.id_berkas
	  INNER JOIN pidum.ms_tersangka_berkas f on e.id_berkas = f.id_berkas
	  INNER JOIN pidum.pdm_p24 a on e.id_pengantar = a.id_pengantar
	  left join pidum.pdm_rendak b on d.id_berkas = b.id_berkas
		where d.id_perkara='".$id_perkara."' 
		GROUP BY d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY') ,a.id_pengantar,coalesce(b.id_rendak,'0')
	  ,to_char(b.tgl_dikeluarkan,'DD-MM-YYYY'),d.id_berkas
 ";

	  $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();


	$dataProvider =	new SqlDataProvider([
      'sql' => $query,
	  'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
              'id_pengantar',
              'id_p20',
         ],
     ],
      'pagination' => [
          'pageSize' => 10,
      ]
]);
		 return $dataProvider;
    }
}
