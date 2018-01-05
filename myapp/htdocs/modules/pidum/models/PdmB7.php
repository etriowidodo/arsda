<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_b7".
 *
 * @property string $id_b7
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada
 * @property string $di_kepada
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_tersangka
 * @property string $barbuk
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
 */
class PdmB7 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_b7';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_b7','sifat','id_penandatangan','tgl_dikeluarkan','no_surat'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['barbuk', 'tindakan'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_b7', 'id_perkara', 'lampiran', 'id_tersangka'], 'string', 'max' => 16],
            [['no_surat'], 'string', 'max' => 32],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['kepada', 'di_kepada'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
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
            'id_b7' => 'Id B7',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_tersangka' => 'Id Tersangka',
            'barbuk' => 'Barbuk',
            'tindakan' => 'Tindakan',
            'id_penandatangan' => 'Penandatangan',
            'upload_file' => 'Upload File',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}