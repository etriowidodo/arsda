<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_t15".
 *
 * @property string $id_t15
 * @property string $id_t8
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada
 * @property string $di
 * @property string $no_registrasi
 * @property string $tgl_registrasi
 * @property string $put_pengadilan
 * @property string $tgl_kabur
 * @property string $id_tersangka
 * @property string $modus
 * @property string $kerugian
 * @property string $id_penandatangan
 * @property string $id_perkara
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmT15 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_t15';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_t15', 'id_perkara'], 'required'],
            [['tgl_registrasi', 'tgl_kabur', 'created_time', 'updated_time'], 'safe'],
            [['put_pengadilan', 'modus', 'kerugian'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_t15', 'lampiran', 'id_perkara'], 'string', 'max' => 16],
            [['id_t8', 'no_surat', 'no_registrasi', 'id_tersangka'], 'string', 'max' => 32],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['kepada'], 'string', 'max' => 128],
            [['di'], 'string', 'max' => 64],
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
            'id_t15' => 'Id T15',
            'id_t8' => 'Id T8',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada' => 'Kepada',
            'di' => 'Di',
            'no_registrasi' => 'No Registrasi',
            'tgl_registrasi' => 'Tgl Registrasi',
            'put_pengadilan' => 'Put Pengadilan',
            'tgl_kabur' => 'Tgl Kabur',
            'id_tersangka' => 'Id Tersangka',
            'modus' => 'Modus',
            'kerugian' => 'Kerugian',
            'id_penandatangan' => 'Id Penandatangan',
            'id_perkara' => 'Id Perkara',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }

    public function getTersangka()
    {
        return $this->hasMany(VwTerdakwa::className(),['id_perkara'=>'id_perkara']);
    }
}
