<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_rp11".
 *
 * @property string $no_register_perkara
 * @property string $no_akta
 * @property string $tgl_permohonan
 * @property string $no_reg_tahanan
 * @property integer $id_pemohon
 * @property integer $id_status_yakum
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $no_permohonan_kasasi
 * @property string $tgl_permohonan_kasasi
 * @property string $id_perkara
 * @property string $no_permohonan
 */
class PdmRp11 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_rp11';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_akta', 'tgl_permohonan', 'no_reg_tahanan', 'id_pemohon', 'id_status_yakum', 'created_by', 'updated_by'], 'required'],
            [['tgl_permohonan', 'created_time', 'updated_time', 'tgl_permohonan_kasasi'], 'safe'],
            [['id_pemohon', 'id_status_yakum', 'created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_akta'], 'string', 'max' => 50],
            [['no_reg_tahanan'], 'string', 'max' => 30],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['no_permohonan_kasasi', 'id_perkara', 'no_permohonan'], 'string', 'max' => 60]
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
            'tgl_permohonan' => 'Tgl Permohonan',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'id_pemohon' => 'Id Pemohon',
            'id_status_yakum' => 'Id Status Yakum',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'no_permohonan_kasasi' => 'No Permohonan Kasasi',
            'tgl_permohonan_kasasi' => 'Tgl Permohonan Kasasi',
            'id_perkara' => 'Id Perkara',
            'no_permohonan' => 'No Permohonan',
        ];
    }
}
