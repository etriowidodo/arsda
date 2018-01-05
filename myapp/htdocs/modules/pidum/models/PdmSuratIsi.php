<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_surat_isi".
 *
 * @property string $id_surat_isi
 * @property integer $kode_table
 * @property string $id_table
 * @property integer $id_jenis_surat
 * @property integer $no_urut
 * @property string $isi_surat
 * @property string $id_perkara
 * @property string $flag
 */
class PdmSuratIsi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_surat_isi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_surat_isi', 'kode_table', 'id_table', 'id_jenis_surat', 'no_urut', 'id_perkara'], 'required'],
            [['kode_table', 'id_jenis_surat', 'no_urut'], 'integer'],
            [['isi_surat'], 'string'],
            [['id_surat_isi', 'id_perkara'], 'string', 'max' => 16],
            [['id_table'], 'string', 'max' => 32],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_surat_isi' => 'Id Surat Isi',
            'kode_table' => 'Kode Table',
            'id_table' => 'Id Table',
            'id_jenis_surat' => 'Id Jenis Surat',
            'no_urut' => 'No Urut',
            'isi_surat' => 'Isi Surat',
            'id_perkara' => 'Id Perkara',
            'flag' => 'Flag',
        ];
    }
}
