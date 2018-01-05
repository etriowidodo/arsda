<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.status".
 *
 * @property string $nama_status
 * @property string $keterangan
 * @property string $url
 * @property integer $id_status
 * @property string $proses
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $is_final
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date', 'update_date'], 'safe'],
            [['nama_status'], 'string', 'max' => 75],
            [['keterangan'], 'string', 'max' => 500],
            [['url'], 'string', 'max' => 250],
            [['proses'], 'string', 'max' => 25],
            [['create_by', 'update_by'], 'string', 'max' => 20],
            [['is_final'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nama_status' => 'Nama Status',
            'keterangan' => 'Keterangan',
            'url' => 'Url',
            'id_status' => 'Id Status',
            'proses' => 'Proses',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'is_final' => 'Is Final',
        ];
    }
}
