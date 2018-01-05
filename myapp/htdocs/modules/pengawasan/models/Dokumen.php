<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.dokumen".
 *
 * @property integer $id_dokumen
 * @property string $kd_dokumen
 * @property string $nm_dokumen
 * @property string $url
 * @property string $proses
 * @property integer $parent
 * @property string $keterangan
 * @property string $upload_file
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class Dokumen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.dokumen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_dokumen'], 'required'],
            [['id_dokumen', 'parent', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['kd_dokumen'], 'string', 'max' => 10],
            [['nm_dokumen', 'url', 'proses', 'keterangan', 'upload_file'], 'string', 'max' => 200],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_dokumen' => 'Id Dokumen',
            'kd_dokumen' => 'Kd Dokumen',
            'nm_dokumen' => 'Nm Dokumen',
            'url' => 'Url',
            'proses' => 'Proses',
            'parent' => 'Parent',
            'keterangan' => 'Keterangan',
            'upload_file' => 'Upload File',
            'is_deleted' => 'Is Deleted',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
