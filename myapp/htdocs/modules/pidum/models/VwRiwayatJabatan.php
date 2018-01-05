<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_riwayat_jabatan".
 *
 * @property integer $id
 * @property string $peg_nik
 * @property string $peg_nip
 * @property string $peg_nip_baru
 * @property string $peg_nama
 * @property string $jabat_tmt
 * @property string $jabatan
 */
class VwRiwayatJabatan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_riwayat_jabatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['jabat_tmt'], 'safe'],
            [['jabatan'], 'string'],
            [['peg_nik', 'peg_nip', 'peg_nip_baru'], 'string', 'max' => 20],
            [['peg_nama'], 'string', 'max' => 65]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peg_nik' => 'Peg Nik',
            'peg_nip' => 'Peg Nip',
            'peg_nip_baru' => 'Peg Nip Baru',
            'peg_nama' => 'Peg Nama',
            'jabat_tmt' => 'Jabat Tmt',
            'jabatan' => 'Jabatan',
        ];
    }
}
