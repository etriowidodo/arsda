<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.inspektur".
 *
 * @property string $id_inspektur
 * @property string $nama_inspektur
 * @property string $bidang_inspektur
 * @property string $kode_surat
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class Inspektur extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.inspektur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_inspektur'], 'required'],
            [['is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_inspektur'], 'string', 'max' => 20],
            [['nama_inspektur', 'bidang_inspektur'], 'string', 'max' => 100],
            [['kode_surat'], 'string', 'max' => 3],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_inspektur' => 'Id Inspektur',
            'nama_inspektur' => 'Nama Inspektur',
            'bidang_inspektur' => 'Bidang Inspektur',
            'kode_surat' => 'Kode Surat',
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
