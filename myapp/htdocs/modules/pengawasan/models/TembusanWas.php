<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.pemeriksa".
 *
 * @property string $id_pemeriksa
 * @property integer $updated_by
 * @property string $updated_time
 */
class TembusanWas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_tembusan_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['created_by', 'updated_by'], 'integer'],
            // [['created_time', 'updated_time'], 'safe'],
            [['id_tembusan','kode_wilayah'], 'string', 'max' => 2],
            [['nama_tembusan'], 'string', 'max' => 65],
            [['for_tabel'], 'string', 'max' =>20]
            // [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tembusan' => 'Id tembusan',
            'kode_wilayah' => 'Kode Wilayah',
            'nama_tembusan' => 'Nama Tembusan',
            'for_tabel' => 'for table',
            // 'created_by' => 'Created By',
            // 'created_ip' => 'Created Ip',
            // 'created_time' => 'Created Time',
            // 'updated_ip' => 'Updated Ip',
            // 'updated_by' => 'Updated By',
            // 'updated_time' => 'Updated Time',
        ];
    }
}
