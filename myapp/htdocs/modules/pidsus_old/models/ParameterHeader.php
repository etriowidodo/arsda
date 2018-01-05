<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.parameter_header".
 *
 * @property string $nama_header
 * @property integer $no_urut
 * @property integer $id_header
 * @property string $nama_lain
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class ParameterHeader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.parameter_header';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_urut'], 'integer'],
            [['nama_lain'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['nama_header'], 'string', 'max' => 50],
            [['create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nama_header' => 'Nama Header',
            'no_urut' => 'No Urut',
            'id_header' => 'Id Header',
            'nama_lain' => 'Nama Lain',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
}
