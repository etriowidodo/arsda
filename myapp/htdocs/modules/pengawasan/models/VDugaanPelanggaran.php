<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_dugaan_pelanggaran".
 *
 * @property string $satker_dugaan_pelanggaran
 * @property string $nm_wilayah
 * @property string $nama_inspektur
 * @property string $no_register
 * @property string $tgl_register
 * @property string $sumber_lapdu
 * @property string $sumber_pelapor
 * @property string $uraian
 * @property string $id_register
 */
class VDugaanPelanggaran extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_dugaan_pelanggaran';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_register'], 'safe'],
            [['uraian'], 'string'],
            [['satker_dugaan_pelanggaran', 'nama_inspektur'], 'string', 'max' => 100],
            [['nm_wilayah'], 'string', 'max' => 5],
            [['no_register'], 'string', 'max' => 32],
            [['sumber_lapdu', 'sumber_pelapor'], 'string', 'max' => 60],
            [['id_register'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'satker_dugaan_pelanggaran' => 'Satker Dugaan Pelanggaran',
            'nm_wilayah' => 'Nm Wilayah',
            'nama_inspektur' => 'Nama Inspektur',
            'no_register' => 'No Surat',
            'tgl_register' => 'Tgl Register',
            'sumber_lapdu' => 'Sumber Lapdu',
            'sumber_pelapor' => 'Sumber Pelapor',
            'uraian' => 'Uraian',
            'id_register' => 'Id Register',
        ];
    }
}
