<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmP20;
use yii\data\SqlDataProvider;

/**
 * PdmP20Search represents the model behind the search form about `app\modules\pidum\models\PdmP20`.
 */
class PdmP20Search extends PdmP20
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p20',  'no_surat', 'sifat', 'lampiran', 'tgl_dikeluarkan', 'dikeluarkan', 'kepada', 'di_kepada', 'id_penandatangan'], 'safe'],
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

	
	public function searchdetail($id_perkara)
	{
		
	  
	  $query = " select d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY') as berkas,a.id_pengantar,coalesce(b.id_p20,'0') as id_p20 ,string_agg(f.nama,', ') as nama
,c.no_surat ||'<br/>'||to_char(c.tgl_dikeluarkan,'DD-MM-YYYY') as p19,to_char(c.tgl_terima,'DD-MM-YYYY') as tgl_p19
,coalesce(b.no_surat||'<br/>'||to_char(b.tgl_dikeluarkan,'DD-MM-YYYY'),'-')  as p20,d.id_berkas
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
	  left join pidum.pdm_p20 b on a.id_pengantar = b.id_pengantar
	  inner join pidum.pdm_p19 c on a.id_pengantar = c.id_pengantar
where d.id_perkara='".$id_perkara."' 
GROUP BY d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY') ,a.id_pengantar,coalesce(b.id_p20,'0')
	  ,c.no_surat ||'<br/>'||to_char(c.tgl_dikeluarkan,'DD-MM-YYYY'),to_char(c.tgl_terima,'DD-MM-YYYY') 
	  ,b.no_surat||'<br/>'||to_char(b.tgl_dikeluarkan,'DD-MM-YYYY'),c.tgl_terima,d.id_berkas
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
