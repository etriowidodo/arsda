<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba6".
 *
 * @property string $no_register_perkara
 * @property string $tgl_ba6
 * @property string $lokasi
 * @property string $nama
 * @property string $alamat
 * @property string $pekerjaan
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property string $desk_barbuk
 * @property string $id_tersangka
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmBa6 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba6';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_ba6', 'created_by', 'updated_by'], 'required'],
            [['tgl_ba6', 'created_time', 'updated_time'], 'safe'],
            [['desk_barbuk'], 'string'],
            [['created_by', 'updated_by','id_sts'], 'integer'],
            [['id_tersangka'], 'string', 'max' => 16],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['lokasi', 'nama', 'pekerjaan'], 'string', 'max' => 64],
            [['alamat'], 'string', 'max' => 128],
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
            'tgl_ba6' => 'Tgl Ba6',
            'lokasi' => 'Lokasi',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'pekerjaan' => 'Pekerjaan',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'desk_barbuk' => 'Desk Barbuk',
            'id_tersangka' => 'Id Tersangka',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
