<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_template_berkas".
 *
 * @property integer $id_tmp_berkas
 * @property string $kd_berkas
 * @property string $type_surat
 * @property string $no_urut
 * @property string $sub_no_urut
 * @property string $isi_surat
 * @property string $flag
 * @property string $ddl_sql
 */
class PdmTemplateBerkas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_template_berkas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tmp_berkas'], 'required'],
            [['id_tmp_berkas'], 'integer'],
            [['isi_surat'], 'string'],
            [['kd_berkas'], 'string', 'max' => 16],
            [['type_surat'], 'string', 'max' => 32],
            [['no_urut', 'sub_no_urut'], 'string', 'max' => 4],
            [['flag'], 'string', 'max' => 1],
            [['ddl_sql'], 'string', 'max' => 4000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tmp_berkas' => 'Id Tmp Berkas',
            'kd_berkas' => 'Kd Berkas',
            'type_surat' => 'Type Surat',
            'no_urut' => 'No Urut',
            'sub_no_urut' => 'Sub No Urut',
            'isi_surat' => 'Isi Surat',
            'flag' => 'Flag',
            'ddl_sql' => 'Ddl Sql',
        ];
    }
}
