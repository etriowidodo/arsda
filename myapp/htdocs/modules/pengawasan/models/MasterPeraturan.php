<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.master_peraturan".
 *
 * @property integer $id_peraturan
 * @property string $isi_peraturan
 * @property string $tgl_perja
 * @property string $kode_surat
 * @property string $pasal
 * @property string $tgl_inactive
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class MasterPeraturan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.master_peraturan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['id_peraturan'], 'required'],
            [['id_peraturan', 'created_by', 'updated_by'], 'integer'],
            [['isi_peraturan'], 'string'],
            [['tgl_perja', 'tgl_inactive', 'created_time', 'updated_time'], 'safe'],
            [['kode_surat'], 'string', 'max' => 20],
            [['pasal'], 'string', 'max' => 100],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_peraturan' => 'Id Peraturan',
            'isi_peraturan' => 'Isi Peraturan',
            'tgl_perja' => 'Tgl Perja',
            'kode_surat' => 'Kode Surat',
            'pasal' => 'Pasal',
            'tgl_inactive' => 'Tgl Inactive',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
