<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_penetapan_hakim".
 *
 * @property string $no_register_perkara
 * @property string $no_penetapan_hakim
 * @property string $tgl_penetapan_hakim
 * @property string $memerintahkan
 * @property string $dengan_cara
 * @property string $upload_file
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property integer $tentang
 * @property string $penetapan
 */
class PdmPenetapanHakim extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_penetapan_hakim';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_penetapan_hakim', 'created_by', 'updated_by'], 'required'],
            [['tgl_penetapan_hakim', 'created_time', 'updated_time'], 'safe'],
            [['memerintahkan', 'upload_file'], 'string'],
            [['created_by', 'updated_by', 'tentang'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_penetapan_hakim'], 'string', 'max' => 20],
            [['dengan_cara'], 'string', 'max' => 150],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['penetapan'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_penetapan_hakim' => 'No Penetapan Hakim',
            'tgl_penetapan_hakim' => 'Tgl Penetapan Hakim',
            'memerintahkan' => 'Memerintahkan',
            'dengan_cara' => 'Dengan Cara',
            'upload_file' => 'Upload File',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'tentang' => 'Tentang',
            'penetapan' => 'Penetapan',
        ];
    }
}
