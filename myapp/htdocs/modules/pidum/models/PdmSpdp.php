<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_spdp".
 *
 * @property string $id_perkara
 * @property string $id_asalsurat
 * @property string $id_penyidik
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $tgl_terima
 * @property string $ket_kasus
 * @property integer $id_pk_ting_ref
 * @property string $wilayah_kerja
 * @property string $tgl_kejadian_perkara
 * @property string $undang_pasal
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $id_satker_tujuan
 *
 * @property MsTersangka[] $msTersangkas
 * @property PdmBerkas[] $pdmBerkas
 * @property PdmJaksaSaksi[] $pdmJaksaSaksis
 * @property PdmJpu[] $pdmJpus
 * @property PdmP16[] $pdmP16s
 * @property PdmPasal[] $pdmPasals
 * @property MsAsalsurat $idAsalsurat
 * @property MsPenyidik $idPenyidik
 */
class PdmSpdp extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
	
	
    public static function tableName()
    {
        return 'pidum.pdm_spdp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perkara', 'tgl_sprindik','no_sprindik','no_surat', 'tgl_surat', 'tgl_terima','id_asalsurat','id_penyidik', 'ket_kasus','undang_pasal'], 'required'], //jaka |25 mei 2016|CMS_PIDUM001_14|tambah required ket_kasus dan undang_pasal
            [['tgl_surat', 'tgl_terima', 'tgl_kejadian_perkara', 'created_time', 'updated_time','id_asalsurat','id_penyidik'], 'safe'],
            [['ket_kasus', 'undang_pasal'], 'string'],
            [['id_pk_ting_ref', 'created_by', 'updated_by', 'pkting', 'kode_pidana'], 'integer'],
            [['id_perkara'], 'string', 'max' => 56],
            [['tempat_kejadian'], 'string', 'max' => 250],
            [['id_asalsurat', 'id_penyidik', 'no_surat'], 'string', 'max' => 50],
            [['wilayah_kerja','id_satker_tujuan'], 'string', 'max' => 11],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
			[['id_perkara'], 'unique'],
           // [['tgl_terima'], 'compare','compareAttribute'=>'tgl_surat','operator'=>'>=','message'=>'Tanggal Terima tidak boleh lebih kecil dari Tanggal Spdp'],
		    [['file_upload'],'safe'],
			[['file_upload'],'file','extensions'=>['pdf'],'mimeTypes'=>['application/pdf'], 'maxSize'=>1024 * 1024 * 3, 'tooBig'=>'File has to be smaller than 3MB'],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perkara' => 'Kode Perkara',
            'id_asalsurat' => 'Asal surat',
            'id_penyidik' => 'Penyidik',
            'no_surat' => 'Nomor SPDP',
            'tgl_surat' => 'Tanggal SPDP',
            'tgl_terima' => 'Tanggal Diterima',
            'ket_kasus' => 'Uraian Singkat Perkara',
            'id_pk_ting_ref' => 'Perkara Penting',
            'wilayah_kerja' => 'Wilayah Kerja',
            'tgl_kejadian_perkara' => 'Tanggal Kejadian Perkara',
			//'tempat_kejadian' => 'Tempat Kejadian',
            'undang_pasal'  => 'Undang-Undang & Pasal',
            'tgl_sprindik'  => 'Tanggal Sprindik',
            'no_sprindik'   => 'No Sprindik',            
			'id_satker_tujuan' => 'Satker Tujuan' ,
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
			'pkting' => 'PK TING',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMsTersangkas()
    {
        return $this->hasMany(MsTersangka::className(), ['id_perkara' => 'id_perkara']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmBerkas()
    {
        return $this->hasMany(PdmBerkas::className(), ['id_perkara' => 'id_perkara']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmJaksaSaksis()
    {
        return $this->hasMany(PdmJaksaSaksi::className(), ['id_perkara' => 'id_perkara']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmJpus()
    {
        return $this->hasMany(PdmJpu::className(), ['id_perkara' => 'id_perkara']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmP16s()
    {
        return $this->hasMany(PdmP16::className(), ['id_perkara' => 'id_perkara']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmPasals()
    {
        return $this->hasMany(PdmPasal::className(), ['id_perkara' => 'id_perkara']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAsalsurat()
    {
        return $this->hasOne(MsInstPenyidik::className(), ['kode_ip' => 'id_asalsurat']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPenyidik()
    {
        return $this->hasOne(MsInstPelakPenyidikan::className(), ['kode_ip' => 'id_asalsurat'],['kode_ipp' => 'id_penyidik']);
    }

    public function getPkTingRef()
    {
        return $this->hasOne(PdmPkTingRef::className(), ['id' => 'id_pk_ting_ref']);
    }
}
