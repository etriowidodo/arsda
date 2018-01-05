<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.lookup_item".
 *
 * @property string $isi_dasar_sp_was2
 * @property string $id_dasar_surat_sp_was2
 * @property string $isi_dasar_sp_was2
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class DasarSpwas2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.dasar_sp_was2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id_sp_was2', 'id_dasar_surat_sp_was2'], 'required'],
            // [['is_deleted', 'created_by', 'updated_by'], 'integer'],
            // [['created_time', 'updated_time'], 'safe'],
           // [['isi_dasar_sp_was2'], 'string'],
            [['id_sp_was2'], 'integer'],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
            
            [['no_register'], 'string', 'max' => 25]
            // [['nm_lookup_item'], 'string', 'max' => 225],
            // [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sp_was2' => 'Kd Lookup Group',
            'id_dasar_surat_sp_was2' => 'Kd Lookup Item',
            'isi_dasar_sp_was2' => 'Nm Lookup Item',
            
        ];
    }
}
