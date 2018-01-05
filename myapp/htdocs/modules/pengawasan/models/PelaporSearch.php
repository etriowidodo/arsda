<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Pelapor;
use yii\db\Query;

/**
 * PelaporSearch represents the model behind the search form about `app\models\Pelapor`.
 */
class PelaporSearch extends Pelapor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        /*asli*/
        // return [
        //     [['id_pelapor', 'id_register', 'dugaan_pelaporan', 'was_9', 'was_11', 'was_13', 'ba_was_2', 'ba_was_3', 'ba_was_4', 'l_was_2', 'was_15', 'ba_was_5', 'ba_was_7', 'created_by', 'updated_by'], 'integer'],
        //     [['nik', 'nama', 'tempat_lahir', 'tgl_lahir', 'alamat', 'pendidikan', 'agama', 'pekerjaan', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'flag'], 'safe'],
        // ];

        return [
            [['telp_pelapor','id_sumber_laporan'], 'integer'],
            [['alamat_pelapor','nama_pelapor','pekerjaan_pelapor','no_register','sumber_lainya'], 'safe'],
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
        $query = Pelapor::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->andFilterWhere([
        //     'id_pelapor' => $this->id_pelapor,
        //     'id_register' => $this->id_register,
        //     'tgl_lahir' => $this->tgl_lahir,
        //     'dugaan_pelaporan' => $this->dugaan_pelaporan,
        //     'was_9' => $this->was_9,
        //     'was_11' => $this->was_11,
        //     'was_13' => $this->was_13,
        //     'ba_was_2' => $this->ba_was_2,
        //     'ba_was_3' => $this->ba_was_3,
        //     'ba_was_4' => $this->ba_was_4,
        //     'l_was_2' => $this->l_was_2,
        //     'was_15' => $this->was_15,
        //     'ba_was_5' => $this->ba_was_5,
        //     'ba_was_7' => $this->ba_was_7,
        //     'is_deleted' => $this->is_deleted,
        //     'created_by' => $this->created_by,
        //     'created_time' => $this->created_time,
        //     'updated_by' => $this->updated_by,
        //     'updated_time' => $this->updated_time,
        // ]);

        // $query->andFilterWhere(['like', 'nik', $this->nik])
        //     ->andFilterWhere(['like', 'nama', $this->nama])
        //     ->andFilterWhere(['like', 'tempat_lahir', $this->tempat_lahir])
        //     ->andFilterWhere(['like', 'alamat', $this->alamat])
        //     ->andFilterWhere(['like', 'pendidikan', $this->pendidikan])
        //     ->andFilterWhere(['like', 'agama', $this->agama])
        //     ->andFilterWhere(['like', 'pekerjaan', $this->pekerjaan])
        //     ->andFilterWhere(['like', 'created_ip', $this->created_ip])
        //     ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }

    public function pelapor_with_deatil(){

        $pelapor = new Query;
        $connection = \Yii::$app->db;
          $query = " select a.*,
    case when a.id_sumber_laporan='11' or a.id_sumber_laporan='13' then
        (select sumber_lainnya from was.pelapor x where x.id_pelapor=a.id_pelapor) 
    else
    (select nama_sumber_laporan from was.sumber_laporan z where z.id_sumber_laporan=a.id_sumber_laporan) 
end as nama_sumber
  from was.pelapor a inner join was.sumber_laporan b on a.id_sumber_laporan=b.id_sumber_laporan where no_register='".$_SESSION['was_register']."'";
          $pelapor = $connection->createCommand($query)->queryAll();
          return $pelapor;

    }
}
