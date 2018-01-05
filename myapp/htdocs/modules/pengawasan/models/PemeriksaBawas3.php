<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.pemeriksa_bawas3".
 *
 * @property string $id_pemeriksa_ba_was_3
 * @property string $nip
 * @property string $nama_pemeriksa
 * @property string $pangkat_pemeriksa
 * @property string $nrp_pemeriksa
 * @property string $jabatan_pemeriksa
 * @property string $golongan_pemeriksa
 * @property string $satker_pemeriksa
 * @property string $id_ba_was_3
 * @property integer $created_by
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $created_time
 * @property string $updated_time
 * @property string $created_ip
 */
class PemeriksaBawas3 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.pemeriksa_bawas3';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_pemeriksa_ba_was_3', 'id_ba_was_3'], 'string', 'max' => 16],
            [['nip'], 'string', 'max' => 18],
            [['pangkat_pemeriksa'], 'string', 'max' => 30],
            [['nama_pemeriksa'], 'string', 'max' => 100],
            [['nrp_pemeriksa'], 'string', 'max' => 10],
            [['jabatan_pemeriksa', 'satker_pemeriksa'], 'string', 'max' => 65],
            [['golongan_pemeriksa'], 'string', 'max' => 20],
            [['updated_ip', 'created_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pemeriksa_ba_was_3' => 'Id Pemeriksa Ba Was 3',
            'nip' => 'Nip',
            'nama_pemeriksa' => 'Nama Pemeriksa',
            'pangkat_pemeriksa' => 'Pangkat Pemeriksa',
            'nrp_pemeriksa' => 'Nrp Pemeriksa',
            'jabatan_pemeriksa' => 'Jabatan Pemeriksa',
            'golongan_pemeriksa' => 'Golongan Pemeriksa',
            'satker_pemeriksa' => 'Satker Pemeriksa',
            'id_ba_was_3' => 'Id Ba Was 3',
            'created_by' => 'Created By',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'created_ip' => 'Created Ip',
        ];
    }
}
