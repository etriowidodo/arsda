<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_27_klari_detail".
 *
 * @property string $id_was_27_klari_detail
 * @property string $id_was_27_klari
 * @property integer $rncn_henti_riksa_was_27_kla
 * @property string $saran
 * @property string $upload_file
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */

class Was27KlariDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_27_klari_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id_was_27_klari_detail'], 'required'],
            [['created_by', 'updated_by','id_was_27_detail_urut','id_was_27'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['saran'], 'string', 'max' => 2000],
            [['no_register'], 'string', 'max' => 25],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_27_detail_urut' => 'Id Was 27 Klari Detail',
            'saran' => 'Saran',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
