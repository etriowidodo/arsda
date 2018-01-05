<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_t13".
 *
 * @property string $id_t13
 * @property string $id_t8
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $dikeluarkan
 * @property string $kepada
 * @property string $sp_penahanan
 * @property string $penetapan
 * @property string $no_penahanan
 * @property string $tgl_penahanan
 * @property string $keperluan
 * @property string $menghadap
 * @property string $tempat
 * @property string $tgl_penetapan
 * @property string $jam
 * @property string $id_penandatangan
 * @property string $id_perkara
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $id_tersangka
 */
class PdmT13 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_t13';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_t13', 'id_perkara','id_tersangka','id_penandatangan'], 'required'],
            [['tgl_surat', 'tgl_penahanan', 'tgl_penetapan', 'jam', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_t13', 'id_t8', 'id_perkara', 'id_tersangka'], 'string', 'max' => 16],
            [['no_surat'], 'string', 'max' => 32],
            [['dikeluarkan', 'sp_penahanan', 'penetapan', 'no_penahanan', 'menghadap', 'tempat'], 'string', 'max' => 64],
            [['kepada', 'id_penandatangan'], 'string', 'max' => 20],
            [['keperluan'], 'string', 'max' => 128],
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
            'id_t13' => 'Id T13',
            'id_t8' => 'Id T8',
            'no_surat' => 'No Surat',
            'tgl_surat' => 'Tgl Surat',
            'dikeluarkan' => 'Dikeluarkan',
            'kepada' => 'Kepada',
            'sp_penahanan' => 'Sp Penahanan',
            'penetapan' => 'Penetapan',
            'no_penahanan' => 'No Penahanan',
            'tgl_penahanan' => 'Tgl Penahanan',
            'keperluan' => 'Keperluan',
            'menghadap' => 'Menghadap',
            'tempat' => 'Tempat',
            'tgl_penetapan' => 'Tgl Penetapan',
            'jam' => 'Jam',
            'id_penandatangan' => 'Id Penandatangan',
            'id_perkara' => 'Id Perkara',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'id_tersangka' => ' Nama ',
        ];
    }
}
