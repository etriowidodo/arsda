<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmT10;
use yii\data\SqlDataProvider;
use yii\db\Query;

/**
 * PdmT10Search represents the model behind the search form about `app\modules\pidum\models\PdmT10`.
 */
class PdmT10Search extends PdmT10
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_surat_t10', 'keperluan', 'jam_mulai', 'tgl_kunjungan', 'dikeluarkan', 'id_penandatangan'], 'safe'],
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
    public function search($no_register_perkara)
    {
        $query = PdmT10::find(['no_register_perkara'=>$no_register_perkara]);

//        $query = new Query();
//        $query = "select no_surat_t10, nama, tgl_kunjungan, keperluan from pidum.pdm_t10 where no_register_perkara = '".$params."'";
//        $query->select('no_surat_t10, nama, tgl_kunjungan, keperluan')
//            ->from('pidum.pdm_t10')
//            ->where([':no_register_perkara'=>$params]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            
        ]);

        //tidak bisa menggunakan andFilterWhere
        /*$dataProvider = new SqlDataProvider([
            'sql' => 'SELECT a.no_surat, b.nama, a.tgl_kunjungan, a.keperluan' .
                     ' FROM pidum.pdm_t10 a' .
                     ' INNER JOIN pidum.vw_tersangka b ON (a.id_tersangka = b.id_tersangka)' .
                     ' WHERE a.id_perkara=:id_perkara AND a.flag<>:flag',
            'params' => [':id_perkara' => $params,':flag' => '3'],
        ]);*/

        $this->load($params);
        $query->andWhere(['=', 'no_register_perkara', $no_register_perkara]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'jam_mulai' => $this->jam_mulai,
            'tgl_kunjungan' => $this->tgl_kunjungan,
        ]);

        $query->andFilterWhere(['like', 'no_surat_t10', $this->no_surat_t10])
            ->andFilterWhere(['like', 'keperluan', $this->keperluan])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan]);

        return $dataProvider;
    }
}
