<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_dugaan_pelanggaran_index".
 *
 * @property string $id_register
 * @property string $no_register
 * @property string $inst_nama
 * @property string $inst_satkerkd
 * @property string $tgl_dugaan
 * @property string $terlapor
 * @property string $status
 */
class VDugaanPelanggaranIndex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_dugaan_pelanggaran_index';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_dugaan'], 'safe'],
            [['terlapor'], 'string'],
            [['id_register'], 'string', 'max' => 16],
            [['no_register'], 'string', 'max' => 32],
            [['inst_nama'], 'string', 'max' => 100],
            [['inst_satkerkd'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 128],
            [['pelapor'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_register' => 'Id Surat',
            'no_register' => 'No Surat',
            'inst_nama' => 'Inst Nama',
            'inst_satkerkd' => 'Inst Satkerkd',
            'tgl_dugaan' => 'Tgl Dugaan',
            'terlapor' => 'Terlapor',
            'status' => 'Status',
            'pelapor' => 'Pelapor',
        ];
    }
}

                                                                                
