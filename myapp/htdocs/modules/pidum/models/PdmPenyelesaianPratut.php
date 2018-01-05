<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_penyelesaian_pratut".
 *
 * @property string $id_pratut
 * @property string $id_perkara
 * @property string $id_berkas
 * @property string $nomor
 * @property string $tgl_surat
 * @property string $status
 * @property string $sikap_jpu
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmPenyelesaianPratut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_penyelesaian_pratut';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pratut'], 'required'],
            [['tgl_surat', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_pratut'], 'string', 'max' => 56],
            [['id_berkas'], 'string', 'max' => 70],
            [['id_perkara'], 'string', 'max' => 56],
            [['nomor'], 'string', 'max' => 50],
            [['status', 'sikap_jpu'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
			[['file_upload'],'safe'],
			[['file_upload'],'file','extensions'=>['pdf'],'mimeTypes'=>['application/pdf'], 'maxSize'=>1024 * 1024 * 3, 'tooBig'=>'File has to be smaller than 3MB']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pratut' => 'Id Pratut',
            'id_perkara' => 'Id Perkara',
            'id_berkas' => 'Id Berkas',
            'nomor' => 'Nomor',
            'tgl_surat' => 'Tgl Surat',
            'status' => 'Status',
            'sikap_jpu' => 'Sikap Jpu',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
