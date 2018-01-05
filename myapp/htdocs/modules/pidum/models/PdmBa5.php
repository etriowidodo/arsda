<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba5".
 *
 * @property string $no_register_perkara
 * @property string $tgl_ba5
 * @property string $asal_satker
 * @property string $no_sp
 * @property string $tgl_sp
 * @property string $id_tersangka
 * @property string $barbuk
 * @property string $tindakan
 * @property string $no_reg_bukti
 * @property string $id_penandatangan
 * @property string $upload_file
 * @property string $lokasi
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmBa5 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba5';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_ba5', 'created_by', 'updated_by'], 'required'],
            [['tgl_ba5', 'tgl_sp', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['asal_satker', 'no_sp', 'tindakan', 'upload_file'], 'string', 'max' => 128],
            [['id_tersangka'], 'string', 'max' => 20],
            [['barbuk'], 'string', 'max' => 200],
            [['no_reg_bukti', 'lokasi'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 32],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'tgl_ba5' => 'Tgl Ba5',
            'asal_satker' => 'Asal Satker',
            'no_sp' => 'No Sp',
            'tgl_sp' => 'Tgl Sp',
            'id_tersangka' => 'Id Tersangka',
            'barbuk' => 'Barbuk',
            'tindakan' => 'Tindakan',
            'no_reg_bukti' => 'No Reg Bukti',
            'id_penandatangan' => 'Id Penandatangan',
            'upload_file' => 'Upload File',
            'lokasi' => 'Lokasi',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
