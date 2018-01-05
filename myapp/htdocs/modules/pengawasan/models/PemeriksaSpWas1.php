<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.pemeriksa_sp_was1".
 *
 * @property integer $id_pemeriksa_sp_was1
 * @property string $nip
 * @property string $nrp
 * @property string $nama_pemeriksa
 * @property string $pangkat_pemeriksa
 * @property string $jabatan_pemeriksa
 * @property string $golongan_pemeriksa
 * @property string $id_sp_was1
 * @property integer $created_by
 * @property string $created_time
 * @property string $created_ip
 */
class PemeriksaSpWas1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.pemeriksa_sp_was1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sp_was1'], 'required'],
            [['created_by'], 'integer'],
            [['created_time'], 'safe'],
            [['nip'], 'string', 'max' => 18],
            [['nrp'], 'string', 'max' => 10],
            [['pangkat_pemeriksa'], 'string', 'max' => 30],
            [['jabatan_pemeriksa','nama_pemeriksa'], 'string', 'max' => 100],
            [['golongan_pemeriksa'], 'string', 'max' => 20],
            [['no_register'], 'string', 'max' => 25],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_sp_was1', 'id_pemeriksa_sp_was1'], 'integer'],
            [['created_ip'], 'string', 'max' => 15],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pemeriksa_sp_was1' => 'Id Pemeriksa Sp Was1',
            'nip' => 'Nip',
            'nrp' => 'Nrp',
            'nama_pemeriksa' => 'Nama Pemeriksa',
            'pangkat_pemeriksa' => 'Pangkat Pemeriksa',
            'jabatan_pemeriksa' => 'Jabatan Pemeriksa',
            'golongan_pemeriksa' => 'Golongan Pemeriksa',
            'id_sp_was1' => 'Id Sp Was1',
            'created_by' => 'Created By',
            'created_time' => 'Created Time',
            'created_ip' => 'Created Ip',
        ];
    }
}
