<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p48".
 *
 * @property string $no_register_perkara
 * @property string $no_putusan
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
 * @property string $tgl_putusan
 * @property string $no_reg_tahanan
 * @property integer $is_denda
 * @property string $nama_ttd
 * @property string $pangkat_ttd
 * @property string $jabatan_ttd
 * @property string $no_akta
 * @property string $id_perkara
 * @property integer $id_ms_rentut
 */
class PdmP48 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p48';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_putusan', 'no_surat', 'no_reg_tahanan'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time', 'tgl_putusan'], 'safe'],
            [['created_by', 'updated_by', 'is_denda', 'id_ms_rentut'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_putusan', 'no_surat'], 'string', 'max' => 50],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 20],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['no_reg_tahanan', 'no_akta', 'id_perkara'], 'string', 'max' => 60],
            [['nama_ttd'], 'string', 'max' => 100],
            [['pangkat_ttd', 'jabatan_ttd'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_putusan' => 'No Putusan',
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
            'tgl_putusan' => 'Tgl Putusan',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'is_denda' => 'Is Denda',
            'nama_ttd' => 'Nama Ttd',
            'pangkat_ttd' => 'Pangkat Ttd',
            'jabatan_ttd' => 'Jabatan Ttd',
            'no_akta' => 'No Akta',
            'id_perkara' => 'Id Perkara',
            'id_ms_rentut' => 'Id Ms Rentut',
        ];
    }
}
