<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_tut_surat_jaksa".
 *
 * @property string $id_pds_tut_surat_jaksa
 * @property string $id_pds_tut_surat
 * @property integer $no_urut
 * @property string $id_jaksa
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $create_ip
 * @property string $update_ip
 * @property string $flag
 */
class PdsTutSuratJaksa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_tut_surat_jaksa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'id_pds_tut_surat'], 'required'],
            [['no_urut'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_tut_surat_jaksa', 'id_pds_tut_surat'], 'string', 'max' => 25],
            [['id_jaksa', 'create_by', 'update_by'], 'string', 'max' => 20],
            [['create_ip', 'update_ip'], 'string', 'max' => 45],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_tut_surat_jaksa' => 'Id Pds Tut Surat Jaksa',
            'id_pds_tut_surat' => 'Id Pds Tut Surat',
            'no_urut' => 'No Urut',
            'id_jaksa' => 'Id Jaksa',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'create_ip' => 'Create Ip',
            'update_ip' => 'Update Ip',
            'flag' => 'Flag',
        ];
    }
    public function getPegawai()
    {
    	return $this->hasOne(KpPegawai::className(), [ 'peg_nik' => 'id_jaksa'	]);
    }
}