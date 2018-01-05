<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_saran_l_was_1".
 *
 * @property string $id_l_was_1_saran
 * @property string $id_l_was_1
 * @property string $id_terlapor
 * @property integer $saran_l_was_1
 * @property string $peg_nama
 * @property string $peg_nip
 * @property string $peg_nrp
 * @property string $jabatan
 * @property string $nm_lookup_item
 */
class VSaranLWas1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_saran_l_was_1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['saran_l_was_1'], 'integer'],
            [['jabatan'], 'string'],
            [['id_l_was_1_saran', 'id_l_was_1', 'id_terlapor'], 'string', 'max' => 16],
            [['peg_nama'], 'string', 'max' => 65],
            [['peg_nip'], 'string', 'max' => 20],
            [['peg_nrp'], 'string', 'max' => 12],
            [['nm_lookup_item'], 'string', 'max' => 225]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_l_was_1_saran' => 'Id L Was 1 Saran',
            'id_l_was_1' => 'Id L Was 1',
            'id_terlapor' => 'Id Terlapor',
            'saran_l_was_1' => 'Saran L Was 1',
            'peg_nama' => 'Peg Nama',
            'peg_nip' => 'Peg Nip',
            'peg_nrp' => 'Peg Nrp',
            'jabatan' => 'Jabatan',
            'nm_lookup_item' => 'Nm Lookup Item',
        ];
    }
}
