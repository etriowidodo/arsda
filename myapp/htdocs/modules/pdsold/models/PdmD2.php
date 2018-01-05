<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_d2".
 *
 * @property string $no_eksekusi
 * @property string $no_reg_tahanan
 * @property string $tgl_setor
 * @property integer $is_lunas
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $id_penandatangan
 * @property string $nama_ttd
 * @property string $pangkat_ttd
 * @property string $jabatan_ttd
 * @property string $no_register_perkara
 * @property string $nilai
 */
class PdmD2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_d2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_eksekusi', 'is_lunas'], 'required'],
            [['tgl_setor', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['is_lunas', 'created_by', 'updated_by'], 'integer'],
            [['nilai'], 'number'],
            [['no_eksekusi', 'no_reg_tahanan'], 'string', 'max' => 60],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['id_penandatangan'], 'string', 'max' => 255],
            [['nama_ttd', 'pangkat_ttd', 'jabatan_ttd'], 'string', 'max' => 100],
            [['no_register_perkara'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_eksekusi' => 'No Eksekusi',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'tgl_setor' => 'Tgl Setor',
            'is_lunas' => 'Is Lunas',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'id_penandatangan' => 'Id Penandatangan',
            'nama_ttd' => 'Nama Ttd',
            'pangkat_ttd' => 'Pangkat Ttd',
            'jabatan_ttd' => 'Jabatan Ttd',
            'no_register_perkara' => 'No Register Perkara',
            'nilai' => 'Nilai',
        ];
    }
}
