<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_b17".
 *
 * @property string $id_b17
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $no_reg_bukti
 * @property string $barbuk
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_penandatangan
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $id_tersangka
 */
class PdmB17 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_b17';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_b17', 'no_surat'], 'required'],
            [['barbuk'], 'string'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_b17', 'id_perkara', 'id_tersangka'], 'string', 'max' => 16],
            [['no_surat', 'no_reg_bukti'], 'string', 'max' => 32],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 20],
            [['upload_file'], 'string', 'max' => 200],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_b17' => 'Id B17',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'no_reg_bukti' => 'No Reg Bukti',
            'barbuk' => 'Barbuk',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_penandatangan' => 'Id Penandatangan',
            'upload_file' => 'Upload File',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'id_tersangka' => 'Id Tersangka',
        ];
    }
}
