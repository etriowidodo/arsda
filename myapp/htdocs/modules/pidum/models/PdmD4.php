<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_d4".
 *
 * @property string $no_eksekusi
 * @property string $no_reg_tahanan
 * @property string $no_surat
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property integer $id_msstatusdata
 * @property string $id_penandatangan
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $nama_jaksa
 * @property string $nip_jaksa
 * @property string $pangkat_jaksa
 * @property string $jabatan_jaksa
 * @property string $nama_ttd
 * @property string $pangkat_ttd
 * @property string $jabatan_ttd
 * @property string $nilai
 */
class PdmD4 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_d4';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_eksekusi', 'no_surat', 'id_msstatusdata'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['id_msstatusdata', 'created_by', 'updated_by'], 'integer'],
            [['nilai'], 'number'],
            [['no_eksekusi'], 'string', 'max' => 60],
            [['no_reg_tahanan'], 'string', 'max' => 30],
            [['no_surat', 'dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 20],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['nama_jaksa', 'nip_jaksa', 'pangkat_jaksa', 'jabatan_jaksa', 'nama_ttd', 'pangkat_ttd', 'jabatan_ttd'], 'string', 'max' => 100]
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
            'no_surat' => 'No Surat',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_msstatusdata' => 'Id Msstatusdata',
            'id_penandatangan' => 'Id Penandatangan',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'nama_jaksa' => 'Nama Jaksa',
            'nip_jaksa' => 'Nip Jaksa',
            'pangkat_jaksa' => 'Pangkat Jaksa',
            'jabatan_jaksa' => 'Jabatan Jaksa',
            'nama_ttd' => 'Nama Ttd',
            'pangkat_ttd' => 'Pangkat Ttd',
            'jabatan_ttd' => 'Jabatan Ttd',
            'nilai' => 'Nilai',
        ];
    }
}
