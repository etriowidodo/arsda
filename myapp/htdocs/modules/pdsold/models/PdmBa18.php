<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba18".
 *
 * @property string $no_eksekusi
 * @property string $no_sp
 * @property string $tgl_sp
 * @property string $no_reg_tahanan
 * @property string $tindakan
 * @property string $id_penandatangan
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $tgl_pembuatan
 * @property string $lokasi
 * @property string $saksi
 * @property string $nama_ttd
 * @property string $pangkat_ttd
 * @property string $jabatan_ttd
 * @property string $no_visum
 * @property string $tgl_visum
 * @property string $no_menteri
 * @property string $tgl_menteri
 * @property string $jam
 */
class PdmBa18 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba18';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_eksekusi', 'no_sp'], 'required'],
            [['tgl_sp', 'created_time', 'updated_time', 'tgl_pembuatan', 'tgl_visum', 'tgl_menteri', 'jam'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['saksi'], 'string'],
            [['no_eksekusi'], 'string', 'max' => 20],
            [['no_sp', 'tindakan', 'upload_file'], 'string', 'max' => 128],
            [['no_reg_tahanan'], 'string', 'max' => 60],
            [['id_penandatangan'], 'string', 'max' => 32],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['lokasi'], 'string', 'max' => 64],
            [['nama_ttd', 'jabatan_ttd', 'no_visum', 'no_menteri'], 'string', 'max' => 100],
            [['pangkat_ttd'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_eksekusi' => 'No Eksekusi',
            'no_sp' => 'No Sp',
            'tgl_sp' => 'Tgl Sp',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'tindakan' => 'Tindakan',
            'id_penandatangan' => 'Id Penandatangan',
            'upload_file' => 'Upload File',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'tgl_pembuatan' => 'Tgl Pembuatan',
            'lokasi' => 'Lokasi',
            'saksi' => 'Saksi',
            'nama_ttd' => 'Nama Ttd',
            'pangkat_ttd' => 'Pangkat Ttd',
            'jabatan_ttd' => 'Jabatan Ttd',
            'no_visum' => 'No Visum',
            'tgl_visum' => 'Tgl Visum',
            'no_menteri' => 'No Menteri',
            'tgl_menteri' => 'Tgl Menteri',
            'jam' => 'Jam',
        ];
    }
}
