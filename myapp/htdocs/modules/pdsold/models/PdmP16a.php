<?php

namespace app\modules\pdsold\models;

use Yii;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\VwTersangka;
use app\components\GlobalConstMenuComponent;

/**
 * This is the model class for table "pidum.pdm_p16a".
 *
 * @property string $id_p16a
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $id_tersangka
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_penandatangan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmP16a extends \app\models\BaseModel {
    public $jpu;
    public $tersangka;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pidum.pdm_p16a';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['no_register_perkara', 'no_surat_p16a'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p16a'], 'string', 'max' => 50],
            [['dikeluarkan'], 'string', 'max' => 64],
            [[ 'id_penandatangan'], 'string', 'max' => 20],
            [['nama','jabatan'], 'string', 'max' => 200],
            [['pangkat'], 'string', 'max' => 100],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_by','updated_by'], 'string', 'max' => 18],
            [['created_ip','updated_ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_p16a' => 'No Surat P16A',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_penandatangan' => 'Id Penandatangan',
            'nama' => 'Nama',
            'pangkat' => 'Pangkat',
            'jabatan' => 'Jabatan',
            'file_upload' => 'File Upload',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time'
        ];
    }

    public function getMsTersangka() {
        return $this->hasOne(MsTersangka::className(), ['id_tersangka' => 'id_tersangka']);
    }

    public function getNama() {
        return $this->msTersangka->nama;
    }

    public function getJpu($id_perkara, $id_table) {
        $q_jpu = PdmJaksaSaksi::findAll(['id_perkara' => $id_perkara, 'code_table' => GlobalConstMenuComponent::P16A, 'id_table' => $id_table]);
        
        return $q_jpu;
    }

    public function getTersangka($id_perkara){
        $q_tersangka = VwTersangka::find()
                            ->where(['id_perkara' => $id_perkara])
                            ->all();
        return $q_tersangka;
    }

}
