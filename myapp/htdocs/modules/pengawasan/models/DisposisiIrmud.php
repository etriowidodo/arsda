<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was_disposisi_irmud".
 *
 * @property string $no_register
 * @property integer $id_inspektur
 * @property integer $id_irmud
 * @property integer $pemeriksa_1
 * @property integer $pemeriksa_2
 * @property string $id_terlapor_awal
 * @property string $tanggal_disposisi
 * @property string $isi_disposisi
 */
class DisposisiIrmud extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_disposisi_irmud';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register', 'id_inspektur', 'id_irmud'], 'required'],
            [['id_inspektur', 'id_irmud', 'id_pemeriksa','urut_terlapor','no_urut','created_by'], 'integer'],
            [['tanggal_disposisi','created_time'], 'safe'],
            [['isi_disposisi'], 'string'],
			[['file_irmud'], 'string', 'max' => 50],
            [['no_register'], 'string', 'max' => 25],
            [['created_ip'], 'string', 'max' => 15],
            [['status'], 'string', 'max' => 30],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register' => 'No Register',
            'id_inspektur' => 'Id Inspektur',
            'id_irmud' => 'Id Irmud',
            'id_pemeriksa' => 'Id Pemeriksa',
            'urut_terlapor' => 'Id Terlapor Awal',
            'tanggal_disposisi' => 'Tanggal Disposisi',
            'isi_disposisi' => 'Isi Disposisi',
			'file_irmud' => 'File Irmud',
        ];
    }
}
