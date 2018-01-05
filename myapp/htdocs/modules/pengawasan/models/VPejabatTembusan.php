<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\data\ActiveDataProvider;


use yii\db\Query;
/**
 * This is the model class for table "was.v_pejabat_tembusan".
 *
 * @property integer $id_pejabat_tembusan
 * @property string $bidang
 * @property string $wilayah
 * @property string $jabatan
 * @property integer $dugaan_pelanggaran
 * @property integer $was_1
 * @property integer $was_2
 * @property integer $was_3
 * @property integer $sp_was_1
 * @property integer $was_9
 * @property integer $was_11
 * @property integer $was_13
 * @property integer $l_was_1
 * @property integer $ba_was_2
 * @property integer $was_27_kla
 * @property integer $sp_was_2
 * @property integer $was_10
 * @property integer $was_12
 * @property integer $ba_was_3
 * @property integer $ba_was_4
 * @property integer $l_was_2
 * @property integer $was_15
 * @property integer $was_27_inspek
 * @property integer $was_16a
 * @property integer $was_16b
 * @property integer $was_16c
 * @property integer $was_16d
 * @property integer $was_17
 * @property integer $was_18
 * @property integer $was_19a
 * @property integer $was_19b
 * @property integer $was_20a
 * @property integer $was_20b
 * @property integer $was_21
 * @property integer $ba_was_5
 * @property integer $ba_was_6
 * @property integer $ba_was_7
 * @property integer $ba_was_8
 * @property integer $ba_was_9
 * @property integer $sk_was_2a
 * @property integer $sk_was_2b
 * @property integer $sk_was_2c
 * @property integer $sk_was_3a
 * @property integer $sk_was_3b
 * @property integer $sk_was_3c
 * @property integer $sk_was_4a
 * @property integer $sk_was_4b
 * @property integer $sk_was_4c
 * @property integer $sk_was_4d
 * @property integer $sk_was_4e
 */
class VPejabatTembusan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_pejabat_tembusan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pejabat_tembusan', 'dugaan_pelanggaran', 'was_1', 'was_2', 'was_3', 'sp_was_1', 'was_9', 'was_11', 'was_13', 'l_was_1', 'ba_was_2', 'was_27_kla', 'sp_was_2', 'was_10', 'was_12', 'ba_was_3', 'ba_was_4', 'l_was_2', 'was_15', 'was_27_inspek', 'was_16a', 'was_16b', 'was_16c', 'was_16d', 'was_17', 'was_18', 'was_19a', 'was_19b', 'was_20a', 'was_20b', 'was_21', 'ba_was_5', 'ba_was_6', 'ba_was_7', 'ba_was_8', 'ba_was_9', 'sk_was_2a', 'sk_was_2b', 'sk_was_2c', 'sk_was_3a', 'sk_was_3b', 'sk_was_3c', 'sk_was_4a', 'sk_was_4b', 'sk_was_4c', 'sk_was_4d', 'sk_was_4e'], 'integer'],
            [['wilayah'], 'string'],
            [['bidang'], 'string', 'max' => 20],
            [['jabatan'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pejabat_tembusan' => 'Id Pejabat Tembusan',
            'bidang' => 'Bidang',
            'wilayah' => 'Wilayah',
            'jabatan' => 'Jabatan',
            'dugaan_pelanggaran' => 'Dugaan Pelanggaran',
            'was_1' => 'Was 1',
            'was_2' => 'Was 2',
            'was_3' => 'Was 3',
            'sp_was_1' => 'Sp Was 1',
            'was_9' => 'Was 9',
            'was_11' => 'Was 11',
            'was_13' => 'Was 13',
            'l_was_1' => 'L Was 1',
            'ba_was_2' => 'Ba Was 2',
            'was_27_kla' => 'Was 27 Kla',
            'sp_was_2' => 'Sp Was 2',
            'was_10' => 'Was 10',
            'was_12' => 'Was 12',
            'ba_was_3' => 'Ba Was 3',
            'ba_was_4' => 'Ba Was 4',
            'l_was_2' => 'L Was 2',
            'was_15' => 'Was 15',
            'was_27_inspek' => 'Was 27 Inspek',
            'was_16a' => 'Was 16a',
            'was_16b' => 'Was 16b',
            'was_16c' => 'Was 16c',
            'was_16d' => 'Was 16d',
            'was_17' => 'Was 17',
            'was_18' => 'Was 18',
            'was_19a' => 'Was 19a',
            'was_19b' => 'Was 19b',
            'was_20a' => 'Was 20a',
            'was_20b' => 'Was 20b',
            'was_21' => 'Was 21',
            'ba_was_5' => 'Ba Was 5',
            'ba_was_6' => 'Ba Was 6',
            'ba_was_7' => 'Ba Was 7',
            'ba_was_8' => 'Ba Was 8',
            'ba_was_9' => 'Ba Was 9',
            'sk_was_2a' => 'Sk Was 2a',
            'sk_was_2b' => 'Sk Was 2b',
            'sk_was_2c' => 'Sk Was 2c',
            'sk_was_3a' => 'Sk Was 3a',
            'sk_was_3b' => 'Sk Was 3b',
            'sk_was_3c' => 'Sk Was 3c',
            'sk_was_4a' => 'Sk Was 4a',
            'sk_was_4b' => 'Sk Was 4b',
            'sk_was_4c' => 'Sk Was 4c',
            'sk_was_4d' => 'Sk Was 4d',
            'sk_was_4e' => 'Sk Was 4e',
        ];
    }
    
    public function searchTembusanWas($params){
        $query = new Query;
        $query->select('id_pejabat_tembusan, wilayah, bidang, jabatan')
                ->from('was.v_pejabat_tembusan');
                
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
			'pageSize' => 10,
			],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        
         $query->andFilterWhere(['like', 'lower(wilayah)', strtolower($this->wilayah)])
            ->andFilterWhere(['like', 'lower(bidang)', strtolower($this->bidang)])
            ->andFilterWhere(['like', 'lower(jabatan)', strtolower($this->jabatan)]);
        return $dataProvider;
    
    
  
    }
    
}
