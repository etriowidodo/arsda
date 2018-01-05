<?php

namespace app\modules\pdsold\models;

use Yii;


/**
 * This is the model class for table "pidum.pdm_pratut_putusan".
 *
 * @property string $id_pratut
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $tgl_terima
 * @property integer $is_proses
 * @property string $flag

 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmLokasiTtd extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.lokasi_ttd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['lokasi'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'lokasi' => 'Lokasi',
           
        ];
    }

}
