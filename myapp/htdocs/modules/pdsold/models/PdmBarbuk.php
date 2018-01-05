<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_barbuk".
 *
 * @property string $no_register_perkara
 * @property string $tgl_ba5
 * @property string $nama
 * @property string $jumlah
 * @property integer $id_satuan
 * @property string $sita_dari
 * @property string $tindakan
 * @property integer $id_stat_kondisi
 * @property string $id_perkara
 * @property string $tgl_eksekusi
 * @property integer $id_ms_barbuk_eksekusi
 * @property integer $is_lelang
 * @property integer $no_urut_bb
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property string $pindah
 * @property string $pindah_dari
 */
class PdmBarbuk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_barbuk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_ba5', 'nama', 'jumlah', 'sita_dari', 'tindakan', 'no_urut_bb', 'created_by', 'updated_by'], 'required'],
            [['tgl_ba5', 'tgl_eksekusi', 'created_time', 'updated_time'], 'safe'],
            [['jumlah'], 'number'],
            [['id_satuan', 'id_stat_kondisi', 'id_ms_barbuk_eksekusi', 'is_lelang', 'no_urut_bb', 'created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['id_perkara', 'pindah', 'pindah_dari'], 'string', 'max' => 16],
            [['nama', 'sita_dari', 'tindakan'], 'string', 'max' => 128],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'tgl_ba5' => 'Tgl Ba5',
            'nama' => 'Nama',
            'jumlah' => 'Jumlah',
            'id_satuan' => 'Id Satuan',
            'sita_dari' => 'Sita Dari',
            'tindakan' => 'Tindakan',
            'id_stat_kondisi' => 'Id Stat Kondisi',
            'id_perkara' => 'Id Perkara',
            'tgl_eksekusi' => 'Tgl Eksekusi',
            'id_ms_barbuk_eksekusi' => 'Id Ms Barbuk Eksekusi',
            'is_lelang' => 'Is Lelang',
            'no_urut_bb' => 'No Urut Bb',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'pindah' => 'Pindah',
            'pindah_dari' => 'Pindah Dari',
        ];
    }
}
