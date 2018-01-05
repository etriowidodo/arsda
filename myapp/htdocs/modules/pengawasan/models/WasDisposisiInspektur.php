<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_disposisi_inspektur".
 *
 * @property integer $no_urut
 * @property string $id_tingkat
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $id_wilayah
 * @property integer $id_level1
 * @property integer $id_level2
 * @property integer $id_level3
 * @property integer $id_level4
 * @property string $no_register
 * @property integer $id_inspektur
 * @property string $tanggal_disposisi
 * @property string $isi_disposisi
 * @property string $file_inspektur
 * @property integer $id_irmud
 * @property string $status
 * @property integer $urut_terlapor
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 */
class WasDisposisiInspektur extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_disposisi_inspektur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['no_urut', 'id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'id_wilayah', 'id_level1', 'no_register', 'id_inspektur', 'urut_terlapor'], 'required'],
            [['no_urut', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'id_inspektur', 'id_irmud', 'urut_terlapor', 'created_by'], 'integer'],
            [['tanggal_disposisi', 'created_time'], 'safe'],
            [['isi_disposisi'], 'string'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['file_inspektur'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 50],
            [['created_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_urut' => 'No Urut',
            'id_tingkat' => 'Id Tingkat',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
            'no_register' => 'No Register',
            'id_inspektur' => 'Id Inspektur',
            'tanggal_disposisi' => 'Tanggal Disposisi',
            'isi_disposisi' => 'Isi Disposisi',
            'file_inspektur' => 'File Inspektur',
            'id_irmud' => 'Id Irmud',
            'status' => 'Status',
            'urut_terlapor' => 'Urut Terlapor',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
        ];
    }
}
