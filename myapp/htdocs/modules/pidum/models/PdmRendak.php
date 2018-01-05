<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_rendak".
 *
 * @property string $id_rendak
 * @property string $id_perkara
 * @property string $id_berkas
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_penandatangan
 * @property string $nama
 * @property string $pangkat
 * @property string $jabatan
 */
class PdmRendak extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_rendak';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_rendak', 'id_perkara', 'id_berkas'], 'required'],
            [['tgl_dikeluarkan'], 'safe'],
			[['dakwaan'], 'string'],
            [['id_rendak'], 'string', 'max' => 16],
            [['id_berkas'], 'string', 'max' => 70],
            [['id_perkara'], 'string', 'max' => 56],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 20],
            [['nama', 'jabatan'], 'string', 'max' => 200],
            [['pangkat'], 'string', 'max' => 100],
			[['file_upload'],'safe'],
			[['file_upload'],'file','extensions'=>['doc','docx'],'mimeTypes'=>['application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document'], 'maxSize'=>1024 * 1024 * 3, 'tooBig'=>'File has to be smaller than 3MB'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_rendak' => 'Id Rendak',
            'id_perkara' => 'Id Perkara',
            'id_berkas' => 'Id Berkas',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_penandatangan' => 'Id Penandatangan',
            'nama' => 'Nama',
            'pangkat' => 'Pangkat',
            'jabatan' => 'Jabatan',
        ];
    }
}
