<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmPenyelesaianPratut;
use yii\data\SqlDataProvider;
/**
 * PdmPenyelesaianPratutSearch represents the model behind the search form about `app\modules\pidum\models\PdmPenyelesaianPratut`.
 */
class PdmPenyelesaianPratutSearch extends PdmPenyelesaianPratut
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pratut', 'id_perkara', 'id_berkas', 'nomor', 'tgl_surat', 'status', 'sikap_jpu', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
    public function search($id_perkara)
    {
        $query = " select d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY') as berkas,coalesce(b.id_pratut,'0') as id_pratut ,string_agg(f.nama,', ') as nama
,coalesce(case when b.status='1' then 'Lanjut Ke Penuntutan' when b.status='2' then 'Diversi' when b.status='3' then 'SP-3' when b.status='4' then 'Optimal' else '-' end ,'-') as status, d.id_berkas
	  from 
	  pidum.pdm_berkas_tahap1 d 
	  INNER JOIN (
			select x.* from 
			pidum.pdm_pengantar_tahap1 x inner join (
				select max(id_pengantar) as id_pengantar from pidum.pdm_pengantar_tahap1 group by id_berkas 
			)y on x.id_pengantar = y.id_pengantar
                    ) e on d.id_berkas = e.id_berkas
	  INNER JOIN pidum.ms_tersangka_berkas f on e.id_berkas = f.id_berkas
	  left join pidum.pdm_penyelesaian_pratut b on d.id_perkara = b.id_perkara AND d.id_berkas = b.id_berkas 
		where d.id_perkara='".$id_perkara."' 
		GROUP BY d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY'),coalesce(b.id_pratut,'0')
	  ,b.status ,d.id_berkas
 ";

	  $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();


	$dataProvider =	new SqlDataProvider([
      'sql' => $query,
	  'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
              'berkas',
              'id_pratut',
              'status',
              'nama',
			  'id_berkas',
         ],
     ],
      'pagination' => [
          'pageSize' => 10,
      ]
]);
		 return $dataProvider;
    }
}
