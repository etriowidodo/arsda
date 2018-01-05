<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_grid_penuntutan".
 *
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $assurat
 * @property string $tgl_terima
 * @property string $undang
 * @property string $no_p16a
 * @property string $tgl_p16a
 * @property string $jpu
 * @property string $tersangka
 * @property string $id_sys_menu
 * @property string $status
 * @property string $url
 */
class VwGridPenuntutan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_grid_penuntutan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_surat', 'tgl_terima', 'tgl_p16a'], 'safe'],
            [['undang', 'jpu', 'tersangka'], 'string'],
            [['id_perkara'], 'string', 'max' => 16],
            [['no_surat', 'no_p16a', 'id_sys_menu'], 'string', 'max' => 32],
            [['assurat'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'tgl_surat' => 'Tgl Surat',
            'assurat' => 'Assurat',
            'tgl_terima' => 'Tgl Terima',
            'undang' => 'Undang',
            'no_p16a' => 'No P16a',
            'tgl_p16a' => 'Tgl P16a',
            'jpu' => 'Jpu',
            'tersangka' => 'Tersangka',
            'id_sys_menu' => 'Id Sys Menu',
            'status' => 'Status',
            'url' => 'Url',
        ];
    }
}
