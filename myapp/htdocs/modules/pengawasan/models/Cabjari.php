<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.kejagung_bidang".
 *
 * @property string $id_kejagung_bidang
 * @property string $nama_kejagung_bidang
 */
class Cabjari extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $id_inspektur;
    public $nama_kejati;
    public $nama_kejari;
    public static function tableName()
    {
        return 'was.cabjari';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cabjari'], 'required'],
            [['id_kejati','id_kejari','id_cabjari'], 'string', 'max' => 2],
            [['nama_cabjari'], 'string', 'max' => 70],
            [['akronim'], 'string'],
            [['inst_lokinst'], 'string'],
            [['inst_alamat'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_kejati' => 'Kejati',
            'id_kejari' => 'Kejari',
            'id_cabjari' => 'Cabjari',
            'nama_cabjari' => 'Nama Cabjari',
            'akronim' => 'Akronim',
            'inst_lokinst' => 'Lokasi Instansi',
            'inst_alamat' => 'Alamat Instansi',
        ];
    }
}
