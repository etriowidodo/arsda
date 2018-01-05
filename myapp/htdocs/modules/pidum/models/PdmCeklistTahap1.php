<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ceklist_tahap1".
 *
 * @property string $id_ceklist
 * @property string $id_pengantar
 * @property string $id_pendapat_jaksa
 * @property string $tgl_selesai
 * @property string $nik_ttd
 * @property string $nama_ttd
 * @property string $pangkat_ttd
 * @property string $jabatan_ttd
 * @property string $file
 */
class PdmCeklistTahap1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ceklist_tahap1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ceklist'], 'required'],
			[['file_upload'], 'required', 'on'=> 'create'],
            [['tgl_selesai'], 'safe'],
            [['tgl_mulai'], 'safe'],
            [['file_upload'], 'string'],
            [['id_ceklist'], 'string', 'max' => 135],
            [['no_pengantar'], 'string', 'max' => 64],
            [['id_berkas'], 'string', 'max' => 70],
            [['id_pendapat_jaksa'], 'string', 'max' => 10],
            [['nik_ttd'], 'string', 'max' => 20],
            [['nama_ttd', 'jabatan_ttd'], 'string', 'max' => 200],
            [['pangkat_ttd'], 'string', 'max' => 100]
//            [['file_upload'],'file','extensions'=>['odt'],'mimeTypes'=>['application/vnd.oasis.opendocument.text']]
            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ceklist' => 'Id Ceklist',
            'id_pendapat_jaksa' => 'Id Pendapat Jaksa',
            'tgl_selesai' => 'Tgl Selesai',
            'tgl_mulai' => 'Tgl Mulai',
            'nik_ttd' => 'Nik Ttd',
            'nama_ttd' => 'Nama Ttd',
            'pangkat_ttd' => 'Pangkat Ttd',
            'jabatan_ttd' => 'Jabatan Ttd',
            'file' => 'File',
        ];
    }
}
