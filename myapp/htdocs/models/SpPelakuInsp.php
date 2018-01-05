<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.sp_pelaku_insp".
 *
 * @property string $peg_nik
 * @property string $insp_id
 * @property string $temuan_id
 * @property string $peg_nip
 * @property string $peg_nrp
 * @property string $peg_gol
 * @property integer $peg_jabatan
 * @property string $peg_inst_satker
 * @property string $peg_unitkerja
 * @property string $no_surat
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class SpPelakuInsp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sp_pelaku_insp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['peg_jabatan', 'is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe'],
            [['peg_nik', 'peg_nip'], 'string', 'max' => 20],
            [['insp_id', 'temuan_id'], 'string', 'max' => 15],
            [['peg_nrp'], 'string', 'max' => 10],
            [['peg_gol'], 'string', 'max' => 5],
            [['peg_inst_satker', 'peg_unitkerja'], 'string', 'max' => 12],
            [['no_surat'], 'string', 'max' => 35]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'peg_nik' => 'Peg Nik',
            'insp_id' => 'Insp ID',
            'temuan_id' => 'Temuan ID',
            'peg_nip' => 'Peg Nip',
            'peg_nrp' => 'Peg Nrp',
            'peg_gol' => 'Peg Gol',
            'peg_jabatan' => 'Peg Jabatan',
            'peg_inst_satker' => 'Peg Inst Satker',
            'peg_unitkerja' => 'Peg Unitkerja',
            'no_surat' => 'No Surat',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
