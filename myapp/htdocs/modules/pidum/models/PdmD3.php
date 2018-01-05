<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_d3".
 *
 * @property string $no_eksekusi
 * @property string $no_reg_tahanan
 * @property string $biaya_perkara
 * @property string $jml_denda
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $no_register_perkara
 * @property string $det_angsuran
 * @property string $tgl_limit_angsuran
 * @property integer $kali_angsur
 */
class PdmD3 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_d3';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_eksekusi'], 'required'],
            [['biaya_perkara', 'jml_denda'], 'number'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time', 'tgl_limit_angsuran'], 'safe'],
            [['created_by', 'updated_by', 'kali_angsur'], 'integer'],
            [['det_angsuran'], 'string'],
            [['no_eksekusi'], 'string', 'max' => 50],
            [['no_reg_tahanan', 'dikeluarkan'], 'string', 'max' => 64],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['no_register_perkara'], 'string', 'max' => 16]
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
            'biaya_perkara' => 'Biaya Perkara',
            'jml_denda' => 'Jml Denda',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'no_register_perkara' => 'No Register Perkara',
            'det_angsuran' => 'Det Angsuran',
            'tgl_limit_angsuran' => 'Tgl Limit Angsuran',
            'kali_angsur' => 'Kali Angsur',
        ];
    }
}
