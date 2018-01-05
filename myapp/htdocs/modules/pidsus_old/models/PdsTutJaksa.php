<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_tut_jaksa".
 *
 * @property string $id_pds_tut_jaksa
 * @property string $id_jaksa
 * @property string $id_pds_tut
 * @property integer $is_active
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $jenis_jaksa
 * @property string $create_ip
 * @property string $update_ip
 * @property string $flag
 */
class PdsTutJaksa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_tut_jaksa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_tut'], 'required'],
            [['is_active'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_tut_jaksa', 'id_pds_tut'], 'string', 'max' => 25],
            [['id_jaksa', 'create_by', 'update_by'], 'string', 'max' => 20],
            [['jenis_jaksa'], 'string', 'max' => 15],
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
            'id_pds_tut_jaksa' => 'Id Pds Tut Jaksa',
            'id_jaksa' => 'Id Jaksa',
            'id_pds_tut' => 'Id Pds Tut',
            'is_active' => 'Is Active',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'jenis_jaksa' => 'Jenis Jaksa',
            'create_ip' => 'Create Ip',
            'update_ip' => 'Update Ip',
            'flag' => 'Flag',
        ];
    }
}
