<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "kepegawaian.kp_pegawai".
 *
 * @property string $peg_nik
 * @property string $peg_nip
 * @property string $peg_nrp
 * @property string $peg_nama
 * @property string $peg_gelar
 * @property string $peg_marga
 * @property string $peg_tmplahirkab
 * @property string $peg_tmplahirprov
 * @property string $peg_tgllahir
 * @property string $peg_jender
 * @property string $peg_agama
 * @property string $peg_status
 * @property string $peg_jnspeg
 * @property string $pns_jnsjbtfungsi
 * @property string $peg_instakhir
 * @property string $peg_instakhir_tmt
 * @property string $peg_instakhir_jns
 * @property string $peg_jbtakhirstk
 * @property string $peg_jbtakhirjns
 * @property string $peg_jbtakhirstk_tmt
 * @property string $peg_jbtakhirstk_es
 * @property string $peg_jbtakhirfs
 * @property string $peg_jbtakhirfs_tmt
 * @property string $peg_golakhir
 * @property string $peg_golakhir_tmt
 * @property string $peg_golakhir_mkth
 * @property string $peg_golakhir_mkbl
 * @property string $peg_gelar_depan
 * @property string $id_cabang
 * @property string $peg_nip_baru
 *
 * @property KpRJabatan $pegJbtakhirstk
 * @property KpRJabatan $pegJbtakhirfs
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['peg_nik', 'peg_nama'], 'required'],
            [['peg_tgllahir', 'peg_instakhir_tmt', 'peg_jbtakhirstk_tmt', 'peg_jbtakhirfs_tmt', 'peg_golakhir_tmt'], 'safe'],
            [['peg_jnspeg', 'pns_jnsjbtfungsi', 'peg_instakhir_jns', 'peg_jbtakhirstk', 'peg_jbtakhirjns', 'peg_jbtakhirfs', 'peg_golakhir_mkth', 'peg_golakhir_mkbl'], 'number'],
            [['peg_nik', 'peg_nip', 'peg_nip_baru'], 'string', 'max' => 20],
            [['peg_nrp', 'peg_instakhir'], 'string', 'max' => 12],
            [['peg_nama'], 'string', 'max' => 65],
            [['peg_gelar', 'peg_gelar_depan'], 'string', 'max' => 15],
            [['peg_marga'], 'string', 'max' => 25],
            [['peg_tmplahirkab', 'peg_tmplahirprov'], 'string', 'max' => 80],
            [['peg_jender'], 'string', 'max' => 1],
            [['peg_agama'], 'string', 'max' => 10],
            [['peg_status'], 'string', 'max' => 8],
            [['peg_jbtakhirstk_es', 'peg_golakhir'], 'string', 'max' => 5],
            [['id_cabang'], 'string', 'max' => 100]
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
            'peg_marga' => 'Peg Marga',
            'peg_tmplahirkab' => 'Peg Tmplahirkab',
            'peg_tmplahirprov' => 'Peg Tmplahirprov',
            'peg_tgllahir' => 'Peg Tgllahir',
            'peg_jender' => 'Peg Jender',
            'peg_agama' => 'Peg Agama',
            'peg_status' => 'Peg Status',
            'peg_jnspeg' => 'Peg Jnspeg',
            'pns_jnsjbtfungsi' => 'Pns Jnsjbtfungsi',
            'peg_instakhir' => 'Peg Instakhir',
            'peg_instakhir_tmt' => 'Peg Instakhir Tmt',
            'peg_instakhir_jns' => 'Peg Instakhir Jns',
            'peg_jbtakhirstk' => 'Peg Jbtakhirstk',
            'peg_jbtakhirjns' => 'Peg Jbtakhirjns',
            'peg_jbtakhirstk_tmt' => 'Peg Jbtakhirstk Tmt',
            'peg_jbtakhirstk_es' => 'Peg Jbtakhirstk Es',
            'peg_jbtakhirfs' => 'Peg Jbtakhirfs',
            'peg_jbtakhirfs_tmt' => 'Peg Jbtakhirfs Tmt',
            'peg_golakhir' => 'Peg Golakhir',
            'peg_golakhir_tmt' => 'Peg Golakhir Tmt',
            'peg_golakhir_mkth' => 'Peg Golakhir Mkth',
            'peg_golakhir_mkbl' => 'Peg Golakhir Mkbl',
            'peg_gelar_depan' => 'Peg Gelar Depan',
            'id_cabang' => 'Id Cabang',
            'peg_nip_baru' => 'Peg Nip Baru',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegJbtakhirstk()
    {
        return $this->hasOne(KpRJabatan::className(), ['ref_jabatan_kd' => 'peg_jbtakhirstk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegJbtakhirfs()
    {
        return $this->hasOne(KpRJabatan::className(), ['ref_jabatan_kd' => 'peg_jbtakhirfs']);
    }
    
    public function getGolongan(){
    	return $this->hasOne(KpRGolpangkat::className(), ['gol_kd' => 'peg_golakhir']);
    }
    public function getInstansi(){
    	return $this->hasMany(KpInstSatker::classnName(),['inst_satkerkd'=>'peg_instakhir'])	;
    }
}
