<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tahap_dua".
 *
 * @property string $no_register_perkara
 * @property string $id_berkas
 * @property string $no_pengiriman
 * @property string $tgl_pengiriman
 * @property string $tgl_terima
 * @property string $kasus_posisi
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $id_perkara
 */
class PdmTahapDua extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tahap_dua';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'id_berkas', 'no_pengiriman', 'tgl_terima', 'created_by', 'updated_by'], 'required'],
            [['tgl_pengiriman', 'tgl_terima', 'created_time', 'updated_time'], 'safe'],
            [['kasus_posisi'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['id_berkas'], 'string', 'max' => 70],
            [['no_pengiriman'], 'string', 'max' => 64],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['id_perkara'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'id_berkas' => 'Id Berkas',
            'no_pengiriman' => 'No Pengiriman',
            'tgl_pengiriman' => 'Tgl Pengiriman',
            'tgl_terima' => 'Tgl Terima',
            'kasus_posisi' => 'Kasus Posisi',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'id_perkara' => 'Id Perkara',
        ];
    }
}
