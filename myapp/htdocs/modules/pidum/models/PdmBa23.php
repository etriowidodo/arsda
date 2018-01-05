<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba23".
 *
 * @property string $no_register_perkara
 * @property string $no_akta
 * @property string $no_reg_tahanan
 * @property string $no_eksekusi
 * @property string $tgl_ba23
 * @property string $dikeluarkan
 * @property string $pemusnahan
 * @property string $id_penandatangan
 * @property string $nama
 * @property string $pangkat
 * @property string $jabatan
 * @property string $saksi
 * @property string $terpidana
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
class PdmBa23 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba23';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_akta', 'no_reg_tahanan', 'no_eksekusi', 'tgl_ba23', 'created_by', 'updated_by'], 'required'],
            [['tgl_ba23', 'created_time', 'updated_time'], 'safe'],
            [['pemusnahan', 'saksi'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_akta'], 'string', 'max' => 16],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_reg_tahanan', 'no_eksekusi'], 'string', 'max' => 30],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 20],
            [['nama', 'jabatan'], 'string', 'max' => 200],
            [['pangkat', 'terpidana'], 'string', 'max' => 100],
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
            'no_akta' => 'No Akta',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'no_eksekusi' => 'No Eksekusi',
            'tgl_ba23' => 'Tgl Ba23',
            'dikeluarkan' => 'Dikeluarkan',
            'pemusnahan' => 'Pemusnahan',
            'id_penandatangan' => 'Id Penandatangan',
            'nama' => 'Nama',
            'pangkat' => 'Pangkat',
            'jabatan' => 'Jabatan',
            'saksi' => 'Saksi',
            'terpidana' => 'Terpidana',
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
