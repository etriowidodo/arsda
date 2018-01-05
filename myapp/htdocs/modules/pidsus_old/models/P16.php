<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\helpers\Url;

/**
 * This is the model class for table "simkari.p16".
 *
 * @property string $no_p16
 * @property string $dasar
 * @property string $dasar1
 * @property string $untuk
 * @property string $dikeluarkan
 * @property string $tgl_keluar
 * @property string $nip_ka_jaksa
 * @property string $pertimbangan
 * @property string $tembusan
 * @property string $no_spdp
 * @property string $tgl_spdp
 * @property string $penyidik
 * @property string $tgl_terima
 * @property string $jenis_perkara
 * @property string $waktu_terjadi
 * @property string $tempat_terjadi
 * @property string $created_time
 * @property string $created_by
 * @property string $updated_by
 * @property string $updated_time
 * @property string $kasus_posisi
 * @property string $inst_satkerkd
 * @property int $status_sinkron
 *
 * @property PdmTersangka[] $pdmTersangkas
 * @property PdmTimJpu[] $pdmTimJpus
 */
class P16 extends \yii\db\ActiveRecord
{
    public $nama;
    public $tempat_lahir;
    public $tgl_lahir;
    public $jkl;
    public $kewarganegaraan;
    public $alamat;
    public $pasal;
    public $nip_jpu;
    public $nip_pegawai;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'simkari.p16';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_p16'], 'required'],
            [['dasar', 'dasar1', 'untuk', 'pertimbangan', 'tembusan', 'kasus_posisi'], 'string'],
            [['tgl_keluar', 'tgl_spdp', 'tgl_terima', 'waktu_terjadi', 'created_time', 'updated_time'], 'safe'],
            [['no_p16', 'dikeluarkan', 'no_spdp', 'penyidik', 'inst_satkerkd'], 'string', 'max' => 50],
            [['nip_ka_jaksa', 'created_by', 'updated_by'], 'string', 'max' => 20],
            [['jenis_perkara'], 'string', 'max' => 2],
            [['tempat_terjadi'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_p16' => 'No P16',
            'dasar' => 'Dasar',
            'dasar1' => 'Dasar1',
            'untuk' => 'Untuk',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_keluar' => 'Tgl Keluar',
            'nip_ka_jaksa' => 'Nip Ka Jaksa',
            'pertimbangan' => 'Pertimbangan',
            'tembusan' => 'Tembusan',
            'no_spdp' => 'No Spdp',
            'tgl_spdp' => 'Tgl Spdp',
            'penyidik' => 'Penyidik',
            'tgl_terima' => 'Tgl Terima',
            'jenis_perkara' => 'Jenis Perkara',
            'waktu_terjadi' => 'Waktu Terjadi',
            'tempat_terjadi' => 'Tempat Terjadi',
            'created_time' => 'Created Time',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'kasus_posisi' => 'Kasus Posisi',
            'inst_satkerkd' => 'Inst Satkerkd',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmTersangkas()
    {
        return $this->hasMany(PdmTersangka::className(), ['no_p16' => 'no_p16']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmTimJpus()
    {
        return $this->hasMany(PdmTimJpu::className(), ['no_p16' => 'no_p16']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert == true){

            try{
                $username="simkari_baru";
                $password="bandung";
                $dbname="192.168.11.11/sismiop";
                $connection=oci_connect($username, $password, $dbname);
                $sql1="insert into PDM_PERKARA(nomor_perkara, no_p16,no_spdp, tgl_spdp, penyidik, tgl_diterima, inst_satkerkd)
                      VALUES('$this->no_p16','$this->no_p16','$this->no_spdp',TO_DATE('".$this->tgl_spdp."', 'yyyy/mm/dd'),'$this->penyidik',TO_DATE('".$this->tgl_terima."', 'yyyy/mm/dd'), '09.01')";

                $result=oci_parse($connection,$sql1);

                $r = oci_execute($result);

                if($r) {

                    $array = oci_parse($connection, "SELECT max(id) FROM pdm_perkara");

                    oci_execute($array);

                    while ($row = oci_fetch_array($array)) {

                       $sql2="insert into PDM_TERSANGKA(nama, tempat_lahir,tgl_lahir, jkl, kewarganegaraan, alamat, id_perkara)
                          VALUES('$this->nama','$this->tempat_lahir',TO_DATE('".$this->tgl_lahir."', 'yyyy/mm/dd'),'$this->jkl', '$this->kewarganegaraan', '$this->alamat', '$row[0]')";

                        $result2=oci_parse($connection,$sql2);
                        oci_execute($result2);

                        $array1 = oci_parse($connection, "SELECT max(id) FROM pdm_tersangka");

                        oci_execute($array1);

                        while ($row1 = oci_fetch_array($array1)) {
                            $sql3="insert into PDM_PASAL(id_tersangka, pasal)
                          VALUES('$row1[0]','$this->pasal')";

                            $result3=oci_parse($connection,$sql3);
                            oci_execute($result3);
                        }

                        for($i=0;$i<count($this->nip_jpu);$i++){
                            $nip_jpu = $this->nip_jpu[$i];
                            $sql3="insert into PDM_TIM_JPU(id_perkara, nip_pegawai)
                          VALUES('$row[0]','$nip_jpu')";

                            $result3=oci_parse($connection,$sql3);
                            oci_execute($result3);
                        }
                    }
                }
            }catch (ErrorException $e){
                var_dump($e->getMessage());
                if($e->getMessage()){
                    $this->status_sinkron = 1;
                    $this->save();
                    echo "<script>alert('Data gagal sinkron ke database simkari harap melakukan sinkronisasi manual'); window.location.assign('".Url::to('index')."');</script>";
                }

            }
        }
        
        parent::afterSave($insert, $changedAttributes);
    }
}
