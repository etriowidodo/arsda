<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kepegawaian.kp_pegawai".
 *
 * @property string $peg_nik
 * @property string $peg_nip
 * @property string $peg_nrp
 * @property string $peg_nama
 * @property string $peg_gelar
 * @property string $peg_tmplahirkab
 * @property string $peg_tgllahir
 * @property string $peg_jender
 * @property string $peg_agama
 * @property string $peg_status
 * @property string $peg_alamat
 * @property string $peg_tlp_rmh
 * @property string $peg_tlp_hp
 * @property string $peg_jnspeg
 * @property integer $pns_jnsjbtfungsi
 * @property string $peg_instakhir_idk
 * @property string $peg_instakhir
 * @property string $peg_instakhir_tmt
 * @property string $peg_instakhir_uk
 * @property integer $pns_kddkn_hkm
 * @property integer $peg_instakhir_jns
 * @property integer $peg_jbtakhirstk
 * @property integer $peg_jbtakhirjns
 * @property string $peg_jbtakhirstk_es
 * @property string $peg_jbtakhirfs
 * @property string $peg_golakhir
 * @property string $peg_npwp
 * @property string $peg_nip_baru
 * @property integer $st_insert
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class KpPegawai extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kepegawaian.kp_pegawai';
    }

    public static function primarykey()
    {
        return ['peg_nik'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['peg_tgllahir', 'peg_instakhir_tmt', 'createdtime', 'updatedtime'], 'safe'],
            [['pns_jnsjbtfungsi', 'pns_kddkn_hkm', 'peg_instakhir_jns', 'peg_jbtakhirstk', 'peg_jbtakhirjns', 'st_insert', 'is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['peg_nik', 'peg_nip', 'peg_nip_baru'], 'string', 'max' => 20],
            [['peg_nrp', 'peg_instakhir_idk', 'peg_instakhir'], 'string', 'max' => 12],
            [['peg_nama'], 'string', 'max' => 65],
            [['peg_gelar'], 'string', 'max' => 15],
            [['peg_tmplahirkab'], 'string', 'max' => 80],
            [['peg_jender'], 'string', 'max' => 1],
            [['peg_agama'], 'string', 'max' => 10],
            [['peg_status'], 'string', 'max' => 8],
            [['peg_alamat'], 'string', 'max' => 150],
            [['peg_tlp_rmh', 'peg_tlp_hp'], 'string', 'max' => 25],
            [['peg_jnspeg'], 'string', 'max' => 2],
            [['peg_instakhir_uk', 'peg_npwp'], 'string', 'max' => 50],
            [['peg_jbtakhirstk_es', 'peg_golakhir'], 'string', 'max' => 5],
            [['peg_jbtakhirfs'], 'string', 'max' => 35]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'peg_nik' => 'Peg Nik',
            'peg_nip' => 'Peg Nip',
            'peg_nrp' => 'Peg Nrp',
            'peg_nama' => 'Peg Nama',
            'peg_gelar' => 'Peg Gelar',
            'peg_tmplahirkab' => 'Peg Tmplahirkab',
            'peg_tgllahir' => 'Peg Tgllahir',
            'peg_jender' => 'Peg Jender',
            'peg_agama' => 'Peg Agama',
            'peg_status' => 'Peg Status',
            'peg_alamat' => 'Peg Alamat',
            'peg_tlp_rmh' => 'Peg Tlp Rmh',
            'peg_tlp_hp' => 'Peg Tlp Hp',
            'peg_jnspeg' => 'Peg Jnspeg',
            'pns_jnsjbtfungsi' => 'Pns Jnsjbtfungsi',
            'peg_instakhir_idk' => 'Peg Instakhir Idk',
            'peg_instakhir' => 'Peg Instakhir',
            'peg_instakhir_tmt' => 'Peg Instakhir Tmt',
            'peg_instakhir_uk' => 'Peg Instakhir Uk',
            'pns_kddkn_hkm' => 'Pns Kddkn Hkm',
            'peg_instakhir_jns' => 'Peg Instakhir Jns',
            'peg_jbtakhirstk' => 'Peg Jbtakhirstk',
            'peg_jbtakhirjns' => 'Peg Jbtakhirjns',
            'peg_jbtakhirstk_es' => 'Peg Jbtakhirstk Es',
            'peg_jbtakhirfs' => 'Peg Jbtakhirfs',
            'peg_golakhir' => 'Peg Golakhir',
            'peg_npwp' => 'Peg Npwp',
            'peg_nip_baru' => 'Peg Nip Baru',
            'st_insert' => 'St Insert',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
    
    public function getSatker() {
    	return $this->hasOne(KpInstSatker::className(), ['inst_satkerkd' => 'inst_satkerkd']);
    }
}
