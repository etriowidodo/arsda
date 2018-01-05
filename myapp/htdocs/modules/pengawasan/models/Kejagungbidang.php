<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.kejagung_bidang".
 *
 * @property string $id_kejagung_bidang
 * @property string $nama_kejagung_bidang
 */
class Kejagungbidang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.kejagung_bidang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_kejagung_bidang'], 'required'],
            [['id_kejagung_bidang'], 'string', 'max' => 2],
            [['nama_kejagung_bidang'], 'string', 'max' => 65]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_kejagung_bidang' => 'Id Kejagung Bidang',
            'nama_kejagung_bidang' => 'Nama Kejagung Bidang',
        ];
    }
}
