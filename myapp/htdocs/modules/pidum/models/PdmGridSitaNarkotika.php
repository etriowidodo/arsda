<?php

namespace app\modules\pidum\models;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

use Yii;

/**
 * This is the model class for table "pidum.pdm_penetapan_barbuk_surat".
 *
 * @property string $id_penetapan_barbuk_surat
 * @property string $id_penetapan_barbuk
 * @property string $nama_surat
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $tgl_diterima
 */
class PdmGridSitaNarkotika extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_grid_sita_narkotika';
    }

   
    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['id_sita'], 'string', 'max' => 56],
            [['id_sita','nama','pemilik','id_satuan'], 'string', 'max' => 128],
        ];
    }*/

    /**
     * @inheritdoc
     */
    /*public function attributeLabels()
    {
        return [
            'id_penetapan_barbuk_surat' => 'Id Penetapan Barbuk Surat',
            'id_sita' => 'Id Penetapan Barbuk',
            'nama_surat' => 'Nama Surat',
            'no_surat' => 'No Surat',
            'tgl_surat' => 'Tgl Surat',
            'tgl_diterima' => 'Tgl Diterima',
        ];
    }*/
}
