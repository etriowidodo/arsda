<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_pasal".
 *
 * @property string $id_pds_pasal
 * @property string $id_pds_lid_surat
 * @property integer $no_urut
 * @property string $tipe_pasal
 * @property string $pasal
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $penghubung
 * @property string $id_pds_pasal_parent
 * @property integer $sub_no_urut
 */
class PdsPasal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_pasal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_pasal', 'id_pds_lid_surat'], 'required'],
            [['no_urut', 'sub_no_urut'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_pasal', 'id_pds_lid_surat', 'penghubung', 'id_pds_pasal_parent'], 'string', 'max' => 25],
            [['tipe_pasal'], 'string', 'max' => 15],
            [['pasal'], 'string', 'max' => 255],
            [['create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_pasal' => 'Id Pds Pasal',
            'id_pds_lid_surat' => 'Id Pds Lid Surat',
            'no_urut' => 'No Urut',
            'tipe_pasal' => 'Tipe Pasal',
            'pasal' => 'Pasal',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'penghubung' => 'Penghubung',
            'id_pds_pasal_parent' => 'Id Pds Pasal Parent',
            'sub_no_urut' => 'Sub No Urut',
        ];
    }
}
