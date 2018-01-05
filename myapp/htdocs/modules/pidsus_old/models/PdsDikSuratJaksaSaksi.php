<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_dik_surat_jaksa".
 *
 * @property string $id_pds_dik_surat_jaksa
 * @property string $id_pds_dik_surat
 * @property integer $no_urut
 * @property string $id_jaksa
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class PdsDikSuratJaksaSaksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_dik_surat_jaksa_saksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_dik_surat'], 'required'],
            [['no_urut'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_dik_surat_jaksa_saksi', 'id_pds_dik_surat'], 'string', 'max' => 25],
            [['id_jaksa', 'create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_dik_surat_jaksa_saksi' => 'Id Pds Dik Surat Jaksa Saksi',
            'id_pds_dik_surat' => 'Id Pds Dik Surat',
            'no_urut' => 'No Urut',
            'id_jaksa' => 'Id Jaksa',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
    
    public function getPegawai()
    {
    	return $this->hasOne(KpPegawai::className(), [ 'peg_nik' => 'id_jaksa'	]);
    }
}
