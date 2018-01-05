<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.l_was_1_saran".
 *
 * @property string $id_l_was_1_saran
 * @property string $id_l_was_1
 * @property string $id_terlapor
 * @property integer $saran_l_was_1
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class LWas1Saran extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.l_was_1_saran';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_time'], 'safe'],
            [['saran_lwas1','id_l_was_1','created_by'], 'integer'],
            [['nip_terlapor'], 'string', 'max' => 18],
            [['nrp_terlapor'], 'string', 'max' => 10],
            [['created_ip'], 'string', 'max' => 15],
            [['pangkat_terlapor'], 'string', 'max' => 30],
            [['jabatan_terlapor', 'satker_terlapor','nama_terlapor'], 'string', 'max' => 100],
            [['golongan_terlapor'], 'string', 'max' => 50],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            
            'id_l_was_1' => 'Id L Was 1',
            
        ];
    }
}
