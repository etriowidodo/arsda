<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.template_surat_isi".
 *
 * @property string $id_jenis_surat
 * @property string $label_isi_surat
 * @property string $isi_surat
 * @property string $jenis_field
 * @property string $sql_ddl
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property integer $id_template_surat_isi
 * @property integer $no_urut
 * @property string $source_table
 * @property string $source_field
 */
class TemplateSuratIsi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.template_surat_isi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jenis_surat'], 'required'],
            [['create_date', 'update_date'], 'safe'],
            [['no_urut'], 'integer'],
            [['id_jenis_surat'], 'string', 'max' => 10],
            [['label_isi_surat'], 'string', 'max' => 50],
            [['isi_surat'], 'string', 'max' => 4000],
            [['jenis_field'], 'string', 'max' => 15],
            [['sql_ddl'], 'string', 'max' => 1000],
            [['create_by', 'update_by', 'source_table', 'source_field'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_jenis_surat' => 'Id Jenis Surat',
            'label_isi_surat' => 'Label Isi Surat',
            'isi_surat' => 'Isi Surat',
            'jenis_field' => 'Jenis Field',
            'sql_ddl' => 'Sql Ddl',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'id_template_surat_isi' => 'Id Template Surat Isi',
            'no_urut' => 'No Urut',
            'source_table' => 'Source Table',
            'source_field' => 'Source Field',
        ];
    }
}
