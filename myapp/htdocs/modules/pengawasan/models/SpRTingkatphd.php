<?php

namespace app\modules\pengawasan\models;

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
 * @property integer $flag
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class SpRTingkatphd extends \yii\db\ActiveRecord
{
    public $hukdis;
    public $hukuman_disiplin;
    public $pasal_hukuman_disiplin;
    public $isi_hukuman_disiplin;
    
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
            [['lama_hukuman', 'flag', 'createdby', 'updatedby'], 'integer'],
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
            'flag' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
    
     public function searchListSaran()
    {
        $query = static::findBySql("select a.tingkat_kd,b.keterangan||' - '||a.bentuk_hukuman as hukdis 
from was.sp_r_tingkatphd a inner join was.sp_r_jnsphd b on (a.phd_jns=b.phd_jns)
where a.aturan_hukum='Peraturan Pemerintah RI No. 53 Tahun 2010'
order by a.phd_jns,a.tingkat_kd")->asArray()->all();
 
        return $query;

     
        }
        
       
}
