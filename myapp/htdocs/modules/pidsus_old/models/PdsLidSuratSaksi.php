<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_lid_surat_saksi".
 *
 * @property string $id_pds_lid_surat_saksi
 * @property string $id_pds_lid_surat
 * @property integer $no_urut
 * @property string $id_saksi
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class PdsLidSuratSaksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_lid_surat_saksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_lid_surat'], 'required'],
            [['no_urut'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_lid_surat_saksi', 'id_pds_lid_surat'], 'string', 'max' => 25],
            [['id_saksi', 'create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_lid_surat_saksi' => 'Id Pds Lid Surat Saksi',
            'id_pds_lid_surat' => 'Id Pds Lid Surat',
            'no_urut' => 'No Urut',
            'id_saksi' => 'Id Saksi',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
    

    public function getSaksi()
    {
    	return $this->hasOne(PdsLidSaksi::className(), ['id_pds_lid_saksi' => 'id_saksi']);
    }
}
