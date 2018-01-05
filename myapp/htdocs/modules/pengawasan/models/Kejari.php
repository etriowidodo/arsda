<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.kejagung_bidang".
 *
 * @property string $id_kejagung_bidang
 * @property string $nama_kejagung_bidang
 */
class Kejari extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $nama_kejati;
    public $id_inspektur;
    public static function tableName()
    {
        return 'was.kejari';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_kejari'], 'required'],
            [['id_kejati','id_kejari'], 'string', 'max' => 2],
            [['nama_kejari'], 'string', 'max' => 70],
            [['akronim'],'string', 'max' => 50],
            [['inst_lokinst'],'string', 'max' => 100],
            [['inst_alamat'],'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_kejari' => 'Id kejari',
            'id_kejati' => 'Id kejati',
            'nama_kejari' => 'Nama Kejari',
        ];
    }
}
