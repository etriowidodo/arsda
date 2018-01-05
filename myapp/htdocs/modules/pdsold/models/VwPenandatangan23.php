<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_penandatangan23".
 *
 * @property integer $id
 * @property string $peg_instakhir
 * @property string $peg_nik
 * @property string $peg_nip
 * @property string $peg_nip_baru
 * @property string $peg_nama
 * @property string $jabat_tmt
 * @property string $peg_golakhir
 * @property string $is_active
 * @property string $jabatan
 * @property integer $peg_jbtakhirjns
 */
class VwPenandatangan23 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_penandatangan23';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'peg_jbtakhirjns'], 'integer'],
            [['jabat_tmt'], 'safe'],
            [['jabatan'], 'string'],
            [['peg_instakhir'], 'string', 'max' => 12],
            [['peg_nik', 'peg_nip', 'peg_nip_baru'], 'string', 'max' => 20],
            [['peg_nama'], 'string', 'max' => 65],
            [['peg_golakhir'], 'string', 'max' => 5],
            [['is_active'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peg_instakhir' => 'Peg Instakhir',
            'peg_nik' => 'Peg Nik',
            'peg_nip' => 'Peg Nip',
            'peg_nip_baru' => 'Peg Nip Baru',
            'peg_nama' => 'Peg Nama',
            'jabat_tmt' => 'Jabat Tmt',
            'peg_golakhir' => 'Peg Golakhir',
            'is_active' => 'Is Active',
            'jabatan' => 'Jabatan',
            'peg_jbtakhirjns' => 'Peg Jbtakhirjns',
        ];
    }
}
