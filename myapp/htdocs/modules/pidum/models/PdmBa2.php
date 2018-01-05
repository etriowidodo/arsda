<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba2".
 *
 * @property string $id_ba2
 * @property string $id_berkas
 * @property string $id_perkara
 * @property string $tgl_ba
 * @property string $jam
 * @property string $lokasi
 * @property string $nip_jaksa
 * @property string $id_tersangka
 * @property string $id_penandatangan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmBa2 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba2', 'id_perkara'], 'required'],
            [['tgl_pembuatan', 'jam', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_ba2', 'id_perkara'], 'string', 'max' => 16],
         // [['id_berkas', 'id_tersangka'], 'string', 'max' => 32],
			[['id_ms_saksi_ahli'], 'string', 'max' => 20],
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
            'id_ba2' => 'Id Ba2',
			'id_ms_saksi_ahli' => 'id_ms_saksi_ahli',
            'id_perkara' => 'Id Perkara',
            'tgl_pembuatan' => 'Tgl Pembuatan',
            'jam' => 'Jam',
			'lokasi' => 'lokasi',
         //   'nip_jaksa' => 'Nip Jaksa',
          //  'id_tersangka' => 'Id Tersangka',
          //  'id_penandatangan' => 'Id Penandatangan',
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
