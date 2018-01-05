<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_barbuk_lelang".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_b19
 * @property string $no_akta
 * @property string $nama
 * @property string $jumlah
 * @property integer $id_satuan
 * @property string $sita_dari
 * @property string $tindakan
 * @property integer $id_stat_kondisi
 */
class PdmBarbukLelang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_barbuk_lelang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_b19', 'nama', 'jumlah', 'sita_dari', 'tindakan'], 'required'],
            [['jumlah'], 'number'],
            [['id_satuan', 'id_stat_kondisi','flag','no_urut'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_eksekusi'], 'string', 'max' => 16],
            [['no_surat_b19'], 'string', 'max' => 50],
            [['nama', 'sita_dari', 'tindakan'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_b19' => 'No Surat B19',
            'no_akta' => 'No Akta',
            'nama' => 'Nama',
            'jumlah' => 'Jumlah',
            'id_satuan' => 'Id Satuan',
            'sita_dari' => 'Sita Dari',
            'tindakan' => 'Tindakan',
            'id_stat_kondisi' => 'Id Stat Kondisi',
        ];
    }
}
