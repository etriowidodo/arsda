<?php

namespace app\modules\pidum\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "pidum.vw_jaksa_penuntut".
 *
 * @property integer $id
 * @property string $peg_instakhir
 * @property string $peg_nik
 * @property string $peg_nip
 * @property string $peg_nip_baru
 * @property string $peg_nama
 * @property string $jabat_tmt
 * @property string $jabatan
 * @property string $pangkat
 */
class VwJaksaPenuntut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_jaksa_penuntut';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['jabat_tmt'], 'safe'],
            [['jabatan'], 'string'],
            [['peg_instakhir'], 'string', 'max' => 12],
            [['peg_nik', 'peg_nip', 'peg_nip_baru'], 'string', 'max' => 20],
            [['peg_nama'], 'string', 'max' => 65],
            [['pangkat'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peg_instakhir' => 'Peg Instakhir',
            'peg_nik' => 'Peg Nik',
            'peg_nip' => 'Peg Nip',
            'peg_nip_baru' => 'Peg Nip Baru',
            'peg_nama' => 'Peg Nama',
            'jabat_tmt' => 'Jabat Tmt',
            'jabatan' => 'Jabatan',
            'pangkat' => 'Pangkat',
        ];
    }

    public function searchJaksaPelaksana($params)
    {
        $query = new Query;
		 $instaakhir = \Yii::$app->globalfunc->getSatker()->inst_satkerkd;
        $query->select('*')
                ->from('pidum.vw_jaksa_penuntut')
				->where("peg_instakhir='" . $instaakhir . "'")
                ->limit(1);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
              ->andFilterWhere(['like', 'peg_nip', $this->peg_nip])
              ->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru])
              ->andFilterWhere(['like', 'peg_nama', strtoupper($this->peg_nama)])
              ->andFilterWhere(['like', 'jabat_tmt', $this->jabat_tmt])
              ->andFilterWhere(['like', 'jabatan', $this->jabatan]);
          

        return $dataProvider;
    }
    
    public function searchJpuP25($params,$wilayah_kerja)
    {
        $query = new Query;
        $query->select('*')
                ->from('pidum.vw_jaksa_penuntut')
                ->where('peg_inst_akhir =:instKd',['instKd'=>$wilayah_kerja])
                ->limit(1);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
              ->andFilterWhere(['like', 'peg_nip', $this->peg_nip])
              ->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru])
              ->andFilterWhere(['like', 'peg_nama', strtoupper($this->peg_nama)])
              ->andFilterWhere(['like', 'jabat_tmt', $this->jabat_tmt])
              ->andFilterWhere(['like', 'jabatan', $this->jabatan]);
          

        return $dataProvider;
    }
}
