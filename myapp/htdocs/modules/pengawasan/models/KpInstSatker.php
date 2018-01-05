<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "kepegawaian.kp_inst_satker".
 *
 * @property string $inst_satkerkd
 * @property string $inst_satkerinduk
 * @property string $inst_nama
 * @property string $inst_kepala
 * @property string $inst_akronim
 * @property string $inst_alamat
 * @property string $inst_telepon
 * @property string $inst_fax
 * @property string $inst_jenis
 * @property integer $inst_level
 * @property string $inst_indukpkpn
 * @property string $inst_indukbkn
 * @property string $inst_wilayahbayar
 * @property string $inst_lokinst
 * @property integer $inst_jnslokasi
 * @property string $inst_lokkec
 * @property string $inst_lokkab
 * @property string $inst_lokprov
 * @property string $inst_kepala_nip
 * @property string $id_cabang
 * @property string $created_by
 * @property string $created_time
 * @property string $created_ip
 * @property string $lastupdate_by
 * @property string $lastupdate_time
 * @property string $lastupdate_ip
 * @property string $inst_intern
 * @property string $inst_satkerinduk_temp
 * @property string $inst_satkerkd_temp
 * @property string $is_active
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class KpInstSatker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kepegawaian.kp_inst_satker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inst_satkerkd'], 'required'],
            [['inst_level', 'inst_jnslokasi', 'inst_lokkec', 'createdby', 'updatedby'], 'integer'],
            [['created_time', 'lastupdate_time', 'createdtime', 'updatedtime'], 'safe'],
            [['inst_satkerkd', 'inst_akronim', 'inst_satkerkd_temp'], 'string', 'max' => 50],
            [['inst_satkerinduk', 'inst_satkerinduk_temp'], 'string', 'max' => 12],
            [['inst_nama', 'inst_lokinst', 'id_cabang'], 'string', 'max' => 100],
            [['inst_kepala'], 'string', 'max' => 45],
            [['inst_alamat'], 'string', 'max' => 80],
            [['inst_telepon', 'inst_lokkab', 'inst_lokprov', 'created_by', 'created_ip', 'lastupdate_by', 'lastupdate_ip', 'inst_intern'], 'string', 'max' => 15],
            [['inst_fax'], 'string', 'max' => 11],
            [['inst_jenis', 'is_active'], 'string', 'max' => 1],
            [['inst_indukpkpn', 'inst_indukbkn'], 'string', 'max' => 25],
            [['inst_wilayahbayar'], 'string', 'max' => 5],
            [['inst_kepala_nip'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'inst_satkerkd' => 'Inst Satkerkd',
            'inst_satkerinduk' => 'Inst Satkerinduk',
            'inst_nama' => 'Inst Nama',
            'inst_kepala' => 'Inst Kepala',
            'inst_akronim' => 'Inst Akronim',
            'inst_alamat' => 'Inst Alamat',
            'inst_telepon' => 'Inst Telepon',
            'inst_fax' => 'Inst Fax',
            'inst_jenis' => 'Inst Jenis',
            'inst_level' => 'Inst Level',
            'inst_indukpkpn' => 'Inst Indukpkpn',
            'inst_indukbkn' => 'Inst Indukbkn',
            'inst_wilayahbayar' => 'Inst Wilayahbayar',
            'inst_lokinst' => 'Inst Lokinst',
            'inst_jnslokasi' => 'Inst Jnslokasi',
            'inst_lokkec' => 'Inst Lokkec',
            'inst_lokkab' => 'Inst Lokkab',
            'inst_lokprov' => 'Inst Lokprov',
            'inst_kepala_nip' => 'Inst Kepala Nip',
            'id_cabang' => 'Id Cabang',
            'created_by' => 'Created By',
            'created_time' => 'Created Time',
            'created_ip' => 'Created Ip',
            'lastupdate_by' => 'Lastupdate By',
            'lastupdate_time' => 'Lastupdate Time',
            'lastupdate_ip' => 'Lastupdate Ip',
            'inst_intern' => 'Inst Intern',
            'inst_satkerinduk_temp' => 'Inst Satkerinduk Temp',
            'inst_satkerkd_temp' => 'Inst Satkerkd Temp',
            'is_active' => 'Is Active',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
