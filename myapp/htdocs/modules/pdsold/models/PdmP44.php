<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p44".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p44
 * @property string $tgl_tuntutan
 * @property string $tgl_putusan
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $no_putusan
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
class PdmP44 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p44';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p44', 'created_by', 'updated_by'], 'required'],
            [['tgl_tuntutan', 'tgl_putusan', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p44'], 'string', 'max' => 50],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['no_putusan'], 'string', 'max' => 128],
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
            'no_surat_p44' => 'No Surat P44',
            'tgl_tuntutan' => 'Tgl Tuntutan',
            'tgl_putusan' => 'Tgl Putusan',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'no_putusan' => 'No Putusan',
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
