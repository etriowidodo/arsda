<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_b18".
 *
 * @property string $no_eksekusi
 * @property string $no_surat
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_penandatangan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $nama_ttd
 * @property string $pangkat_ttd
 * @property string $jabatan_ttd
 * @property string $pelaksana
 */
class PdmB18 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_b18';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_eksekusi'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['pelaksana'], 'string'],
            [['no_eksekusi'], 'string', 'max' => 16],
            [['no_surat', 'dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 20],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['nama_ttd', 'pangkat_ttd', 'jabatan_ttd'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_eksekusi' => 'No Eksekusi',
            'no_surat' => 'No Surat',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_penandatangan' => 'Id Penandatangan',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'nama_ttd' => 'Nama Ttd',
            'pangkat_ttd' => 'Pangkat Ttd',
            'jabatan_ttd' => 'Jabatan Ttd',
            'pelaksana' => 'Pelaksana',
        ];
    }
}
