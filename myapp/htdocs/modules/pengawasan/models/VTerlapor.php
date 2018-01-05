<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_terlapor".
 *
 * @property string $peg_nip
 * @property string $peg_nama
 * @property string $jabatan
 * @property string $id_register
 * @property string $id_terlapor
 * @property string $peg_nrp
 */
class VTerlapor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_terlapor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jabatan'], 'string'],
            [['peg_nip'], 'string', 'max' => 20],
            [['peg_nama'], 'string', 'max' => 65],
            [['id_register', 'id_terlapor'], 'string', 'max' => 16],
            [['peg_nrp'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'peg_nip' => 'Peg Nip',
            'peg_nama' => 'Peg Nama',
            'jabatan' => 'Jabatan',
            'id_register' => 'Id Register',
            'id_terlapor' => 'Id Terlapor',
            'peg_nrp' => 'Peg Nrp',
        ];
    }
    
    public function getTerlapor(){
        return $this->peg_nip.' – '.$this->peg_nama;
    }
}
