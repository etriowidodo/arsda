<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.sp_r_pengaduan".
 *
 * @property integer $tahap_no
 * @property string $desk_tahapan
 * @property string $dokumen_kd
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class SpRPengaduan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sp_r_pengaduan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahap_no', 'is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe'],
            [['desk_tahapan'], 'string', 'max' => 100],
            [['dokumen_kd'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahap_no' => 'Tahap No',
            'desk_tahapan' => 'Desk Tahapan',
            'dokumen_kd' => 'Dokumen Kd',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
