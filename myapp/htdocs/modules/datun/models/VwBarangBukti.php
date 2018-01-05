<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_barang_bukti".
 *
 * @property string $id_perkara
 * @property string $idx
 * @property string $nama
 * @property string $jumlah
 * @property integer $id_satuan
 * @property string $sita_dari
 * @property string $tindakan
 * @property string $id_stat_kondisi
 * @property string $tgl_eksekusi
 * @property integer $id_ms_barbuk_eksekusi
 * @property integer $is_lelang
 */
class VwBarangBukti extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_barang_bukti';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idx'], 'string'],
            [['jumlah'], 'number'],
            [['id_satuan', 'id_ms_barbuk_eksekusi', 'is_lelang'], 'integer'],
            [['tgl_eksekusi'], 'safe'],
            [['id_perkara'], 'string', 'max' => 16],
            [['nama', 'sita_dari', 'tindakan'], 'string', 'max' => 128],
            [['id_stat_kondisi'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perkara' => 'Id Perkara',
            'idx' => 'Idx',
            'nama' => 'Nama',
            'jumlah' => 'Jumlah',
            'id_satuan' => 'Id Satuan',
            'sita_dari' => 'Sita Dari',
            'tindakan' => 'Tindakan',
            'id_stat_kondisi' => 'Id Stat Kondisi',
            'tgl_eksekusi' => 'Tgl Eksekusi',
            'id_ms_barbuk_eksekusi' => 'Id Ms Barbuk Eksekusi',
            'is_lelang' => 'Is Lelang',
        ];
    }
}
