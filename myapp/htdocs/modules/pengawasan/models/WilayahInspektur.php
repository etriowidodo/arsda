<?php

namespace app\modules\pengawasan\models;

use Yii;

class WilayahInspektur extends \yii\db\ActiveRecord
{
    public $cari;
    public $nama_kejati;
    public $nama_wilayah;
    public $nama_inspektur;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.wilayah_inspektur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_kejati','id_wilayah'], 'string'],
            //[['id_inspektur','id_kejati','id_wilayah'], 'required'],
            [['id_inspektur'], 'integer'],

            //[['nama'], 'required'],
            //[['tahun'], 'string', 'max' => 4],
            //[['is_aktif'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_kejati'    => 'Id Kejati',
            'id_wilayah'   => 'Id Wilayah',
            'id_inspektur' => 'Id Inspektur'
        ];
    }
}
