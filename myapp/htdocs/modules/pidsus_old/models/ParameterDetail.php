<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.parameter_detail".
 *
 * @property integer $id_detail
 * @property integer $id_header
 * @property string $nama_detail
 * @property integer $no_urut
 * @property string $nama_lain
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class ParameterDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.parameter_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_header', 'no_urut'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['nama_detail', 'nama_lain'], 'string', 'max' => 50],
            [['create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_detail' => 'Id Detail',
            'id_header' => 'Id Header',
            'nama_detail' => 'Nama Detail',
            'no_urut' => 'No Urut',
            'nama_lain' => 'Nama Lain',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
}
