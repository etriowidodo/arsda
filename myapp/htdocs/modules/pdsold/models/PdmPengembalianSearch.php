<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmPengembalian;
use yii\data\SqlDataProvider;

/**
 * PdmPengembalianSearch represents the model behind the search form about `app\modules\pidum\models\PdmPengembalian`.
 */
class PdmPengembalianSearch extends PdmPengembalian
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pengembalian', 'id_perkara', 'alasan','id_berkas', 'no_surat', 'sifat', 'lampiran', 'tgl_dikeluarkan', 'dikeluarkan', 'kepada', 'di_kepada', 'perihal', 'file_upload', 'id_penandatangan', 'nama', 'pangkat', 'jabatan', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
        $query = " select d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY') as berkas,coalesce(b.id_pengembalian,'0') as id_pengembalian ,string_agg(f.nama,', ') as nama
,coalesce(b.no_surat||'<br/>'||to_char(b.tgl_dikeluarkan,'DD-MM-YYYY'),'-')  as pengembalian, d.id_berkas
	  from 
	  pidum.pdm_berkas_tahap1 d 
	  INNER JOIN (
			select x.* from 
			pidum.pdm_pengantar_tahap1 x inner join (
				select max(id_pengantar) as id_pengantar from pidum.pdm_pengantar_tahap1 group by id_berkas 
			)y on x.id_pengantar = y.id_pengantar
                    ) e on d.id_berkas = e.id_berkas
	  INNER JOIN pidum.ms_tersangka_berkas f on e.id_berkas = f.id_berkas
	  left join pidum.pdm_pengembalian_berkas b on d.id_berkas = b.id_berkas
		where d.id_perkara='".$id_perkara."' 
		GROUP BY d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY'),coalesce(b.id_pengembalian,'0')
	  ,b.no_surat||'<br/>'||to_char(b.tgl_dikeluarkan,'DD-MM-YYYY') ,d.id_berkas
 ";

	  $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();


	$dataProvider =	new SqlDataProvider([
      'sql' => $query,
	  'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
              'berkas',
              'id_pengembalian',
              'pengembalian',
              'nama',
			  'd.id_berkas',
         ],
     ],
      'pagination' => [
          'pageSize' => 10,
      ]
]);
		 return $dataProvider;
    }
}
