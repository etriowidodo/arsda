<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p49".
 *
 * @property string $no_surat_p49
 * @property string $no_register_perkara
 * @property string $no_akta
 * @property string $no_reg_tahanan
 * @property string $no_eksekusi
 * @property string $surat_kematian
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_penandatangan
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $mengingat
 */
class PdmP49 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p49';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_surat_p49', 'no_register_perkara', 'no_akta', 'no_reg_tahanan', 'no_eksekusi'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['mengingat'], 'string'],
            [['no_surat_p49', 'no_register_perkara', 'no_akta', 'no_reg_tahanan', 'no_eksekusi'], 'string', 'max' => 30],
            [['surat_kematian'], 'string', 'max' => 200],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 20],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_surat_p49' => 'No Surat P49',
            'no_register_perkara' => 'No Register Perkara',
            'no_akta' => 'No Akta',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'no_eksekusi' => 'No Eksekusi',
            'surat_kematian' => 'Surat Kematian',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_penandatangan' => 'Id Penandatangan',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'mengingat' => 'Mengingat',
        ];
    }
}
