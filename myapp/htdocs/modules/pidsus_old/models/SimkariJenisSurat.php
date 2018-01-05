<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.jenis_surat".
 *
 * @property string $id_jenis_surat
 * @property string $nama_jenis_surat
 * @property string $url
 * @property string $keterangan
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $url_report
 */
class SimkariJenisSurat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.jenis_surat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jenis_surat'], 'required'],
            [['create_date', 'update_date'], 'safe'],
            [['url_report'], 'string'],
            [['id_jenis_surat'], 'string', 'max' => 25],
            [['nama_jenis_surat'], 'string', 'max' => 50],
            [['url', 'keterangan'], 'string', 'max' => 250],
            [['create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_jenis_surat' => 'Id Jenis Surat',
            'nama_jenis_surat' => 'Nama Jenis Surat',
            'url' => 'Url',
            'keterangan' => 'Keterangan',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'url_report' => 'Url Report',
        ];
    }
}
