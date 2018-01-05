<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.sp_dok_pengawasan".
 *
 * @property string $dokumen_kd
 * @property string $bentuk_dok
 * @property string $deskripsi
 * @property string $sifat
 * @property string $perihal
 * @property string $maksud_tujuan
 * @property string $link_pdf
 * @property string $tembusan
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class SpDokPengawasan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sp_dok_pengawasan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe'],
            [['dokumen_kd'], 'string', 'max' => 20],
            [['bentuk_dok'], 'string', 'max' => 1],
            [['deskripsi'], 'string', 'max' => 100],
            [['sifat'], 'string', 'max' => 50],
            [['perihal'], 'string', 'max' => 300],
            [['maksud_tujuan'], 'string', 'max' => 3000],
            [['link_pdf'], 'string', 'max' => 250],
            [['tembusan'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dokumen_kd' => 'Dokumen Kd',
            'bentuk_dok' => 'Bentuk Dok',
            'deskripsi' => 'Deskripsi',
            'sifat' => 'Sifat',
            'perihal' => 'Perihal',
            'maksud_tujuan' => 'Maksud Tujuan',
            'link_pdf' => 'Link Pdf',
            'tembusan' => 'Tembusan',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
