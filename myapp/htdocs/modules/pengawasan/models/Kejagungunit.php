<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.kejagung_unit".
 *
 * @property string $id_kejagung_unit
 * @property string $nama_kejagung_unit
 * @property string $id_kejagung_bidang
 */
class Kejagungunit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.kejagung_unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_kejagung_unit'], 'required'],
            [['id_kejagung_unit', 'id_kejagung_bidang'], 'string', 'max' => 2],
            [['nama_kejagung_unit'], 'string', 'max' => 65]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_kejagung_unit' => 'Id Kejagung Unit',
            'nama_kejagung_unit' => 'Nama Kejagung Unit',
            'id_kejagung_bidang' => 'Id Kejagung Bidang',
        ];
    }
}
