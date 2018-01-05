<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.sp_r_tingkatphd".
 *
 * @property string $tingkat_kd
 * @property string $keterangan
 * @property string $aturan_hukum
 * @property string $pasal
 * @property string $ayat
 * @property integer $lama_hukuman
 * @property string $phd_jns
 * @property string $konsekwensi_lain
 * @property string $bentuk_hukuman
 * @property string $jenis_perbuatan
 * @property string $huruf
 * @property string $deskripsi
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class SpRTingkatphd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sp_r_tingkatphd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lama_hukuman', 'is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe'],
            [['tingkat_kd'], 'string', 'max' => 4],
            [['keterangan'], 'string', 'max' => 60],
            [['aturan_hukum', 'deskripsi'], 'string', 'max' => 100],
            [['pasal', 'ayat'], 'string', 'max' => 5],
            [['phd_jns'], 'string', 'max' => 3],
            [['konsekwensi_lain'], 'string', 'max' => 300],
            [['bentuk_hukuman'], 'string', 'max' => 2000],
            [['jenis_perbuatan'], 'string', 'max' => 1],
            [['huruf'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tingkat_kd' => 'Tingkat Kd',
            'keterangan' => 'Keterangan',
            'aturan_hukum' => 'Aturan Hukum',
            'pasal' => 'Pasal',
            'ayat' => 'Ayat',
            'lama_hukuman' => 'Lama Hukuman',
            'phd_jns' => 'Phd Jns',
            'konsekwensi_lain' => 'Konsekwensi Lain',
            'bentuk_hukuman' => 'Bentuk Hukuman',
            'jenis_perbuatan' => 'Jenis Perbuatan',
            'huruf' => 'Huruf',
            'deskripsi' => 'Deskripsi',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
