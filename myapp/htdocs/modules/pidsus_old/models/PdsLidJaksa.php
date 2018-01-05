<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_lid_jaksa".
 *
 * @property string $id_pds_lid_jaksa
 * @property string $id_jaksa
 * @property string $id_pds_lid
 * @property integer $is_active
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class PdsLidJaksa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_lid_jaksa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_lid_jaksa', 'id_pds_lid'], 'string', 'max' => 25],
            [['id_jaksa', 'create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_lid_jaksa' => 'Id Pds Lid Jaksa',
            'id_jaksa' => 'Id Jaksa',
            'id_pds_lid' => 'Id Pds Lid',
            'is_active' => 'Is Active',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
    

    public function getPegawai()
    {
    	return $this->hasOne(KpPegawai::className(), ['peg_nik' => 'id_jaksa']);
    }
}
