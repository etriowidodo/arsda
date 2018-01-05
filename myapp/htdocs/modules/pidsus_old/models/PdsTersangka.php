<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_tersangka".
 *
 * @property string $id_pds_tersangka
 * @property string $id_pds_lid_surat
 * @property string $nama_tersangka
 * @property string $alamat_tersangka
 * @property string $no_pengenal
 * @property string $tempat_lahir
 * @property string $tgl_lahir
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class PdsTersangka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_tersangka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_tersangka', 'id_pds_lid_surat', 'nama_tersangka'], 'required'],
            [['tgl_lahir', 'create_date', 'update_date'], 'safe'],
            [['id_pds_tersangka', 'id_pds_lid_surat', 'no_pengenal', 'tempat_lahir'], 'string', 'max' => 25],
            [['nama_tersangka'], 'string', 'max' => 100],
            [['alamat_tersangka'], 'string', 'max' => 15],
            [['create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_tersangka' => 'Id Pds Tersangka',
            'id_pds_lid_surat' => 'Id Pds Lid Surat',
            'nama_tersangka' => 'Nama Tersangka',
            'alamat_tersangka' => 'Alamat Tersangka',
            'no_pengenal' => 'No Pengenal',
            'tempat_lahir' => 'Tempat Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
}
