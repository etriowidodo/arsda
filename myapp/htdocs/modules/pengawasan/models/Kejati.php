<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.kejagung_bidang".
 *
 * @property string $id_kejagung_bidang
 * @property string $nama_kejagung_bidang
 */
class Kejati extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.kejati';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id_kejati'], 'required'],
            [['id_kejati'], 'string', 'max' => 2],
            [['nama_kejati'], 'string', 'max' => 70],
            [['akronim'], 'string', 'max' => 50],
           // [['id_inspektur'], 'string'],
            [['inst_lokinst'], 'string', 'max' => 100],
            [['inst_alamat'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_kejati' => 'Id kejati',
            'nama_kejati' => 'Nama Kejati',
            'akronim' => ' Akronim',
            //'id_inspektur' => 'Id Inspektur',
            'inst_lokinst' => 'Lokasi Instansi',
            'inst_alamat' => 'Alamat Instansi',
        ];
    }
}
