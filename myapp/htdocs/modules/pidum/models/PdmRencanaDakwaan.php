<?php

namespace app\modules\pidum\models;

use Yii;
use yii\db\Query;
use app\components\GlobalConstMenuComponent;

/**
 * This is the model class for table "pidum.pdm_p29".
 *
 * @property string $id_p29
 * @property string $id_perkara
 * @property string $no_perkara
 * @property string $id_tersangka
 * @property string $tgl_awal_rutan
 * @property string $tgl_akhir_rutan
 * @property string $tgl_awal_rumah
 * @property string $tgl_akhir_rumah
 * @property string $tgl_awal_kota
 * @property string $tgl_akhir_kota
 * @property string $perpanjangan
 * @property string $tgl_perpanjangan
 * @property string $pengalihan
 * @property string $tgl_pengalihan
 * @property string $tgl_penangguhan
 * @property string $pencabutan
 * @property string $tgl_pencabutan
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $dakwaan
 * @property string $id_penandatangan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmRencanaDakwaan extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_rencana_dakwaan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_rencana_dakwaan', 'id_perkara', 'no_perkara'], 'required'],
            [['tgl_awal_rutan', 'tgl_akhir_rutan', 'tgl_awal_rumah', 'tgl_akhir_rumah', 'tgl_awal_kota', 'tgl_akhir_kota', 'tgl_perpanjangan', 'tgl_pengalihan', 'tgl_penangguhan', 'tgl_pencabutan', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['dakwaan'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_rencana_dakwaan', 'id_perkara'], 'string', 'max' => 16],
			[['id_perkara'], 'string', 'max' => 56],
            [['no_perkara', 'id_tersangka'], 'string', 'max' => 32],
            [['perpanjangan', 'pengalihan', 'pencabutan', 'dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 20],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_rencana_dakwaan' => 'Id Rencana Dakwaan',
            'id_perkara' => 'Id Perkara',
            'no_perkara' => 'No Perkara',
            'id_tersangka' => 'Id Tersangka',
            'tgl_awal_rutan' => 'Tgl Awal Rutan',
            'tgl_akhir_rutan' => 'Tgl Akhir Rutan',
            'tgl_awal_rumah' => 'Tgl Awal Rumah',
            'tgl_akhir_rumah' => 'Tgl Akhir Rumah',
            'tgl_awal_kota' => 'Tgl Awal Kota',
            'tgl_akhir_kota' => 'Tgl Akhir Kota',
            'perpanjangan' => 'Perpanjangan',
            'tgl_perpanjangan' => 'Tgl Perpanjangan',
            'pengalihan' => 'Pengalihan',
            'tgl_pengalihan' => 'Tgl Pengalihan',
            'tgl_penangguhan' => 'Tgl Penangguhan',
            'pencabutan' => 'Pencabutan',
            'tgl_pencabutan' => 'Tgl Pencabutan',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'dakwaan' => 'Dakwaan',
            'id_penandatangan' => 'Id Penandatangan',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }

    public function getTersangka(){
        return $this->hasOne(MsTersangka::className(), ['id_tersangka' => 'id_tersangka']);
    }

    public function getJpu($id_perkara){
        $query = "SELECT  *
                    FROM (
                        SELECT pjs.id_perkara, pjs.nip, pjs.nama
                        FROM pidum.pdm_jaksa_saksi pjs
                        RIGHT JOIN (
                            SELECT pdm_p16a.id_p16a, pdm_p16a.id_perkara, max(pdm_p16a.tgl_dikeluarkan) as max_tgl
                            FROM pidum.pdm_p16a pdm_p16a
                            WHERE pdm_p16a.flag <> '3' AND id_perkara = '" . $id_perkara . "'
                            GROUP BY pdm_p16a.id_perkara, pdm_p16a.id_p16a
                    ORDER BY pdm_p16a.tgl_dikeluarkan desc
                    limit 1) max_date ON pjs.id_perkara::text = max_date.id_perkara::text AND pjs.id_table::text = max_date.id_p16a
                            WHERE pjs.code_table = 'P-16A') p16a
                    ";
        $query = Yii::$app->db->createCommand($query)->queryAll();

        return $query;
    }

    public function getDakwaan($id_perkara, $id_tersangka){
        $query = "SELECT
                    CASE WHEN id_ms_rentut = 3 THEN -- Pidana Penjara
                        CONCAT(
                            'Masa Percobaan: '||tahun_coba||' Tahun - '||bulan_coba||' Bulan - '||hari_coba||' Hari'||', '
                            'Pidana Badan: '||tahun_badan||' Tahun - '||bulan_badan||' Bulan - '||hari_badan||' Hari'||', '
                            'Denda: Rp '||denda||',00 , '
                            'SubSidair: '||tahun_sidair||' Tahun - '||bulan_sidair||' Bulan - '||hari_sidair||' Hari'||', '
                            'Biaya Perkara: Rp '||biaya_perkara||',00 , '
                            'Pidana Tambahan: '||pidana_tambahan||', '
                            'Pidana Pengawasan: '||(SELECT nama FROM pidum.pdm_pidana_pengawasan WHERE id = id_ms_pidanapengawasan)||' '
                        ) 
                    WHEN id_ms_rentut = 4 THEN
                        CONCAT(
                            'Kurungan: '||bulan_kurung||' Bulan - '||hari_kurung||' Hari'||', '
                            'Pidana Tambahan: '||pidana_tambahan||' '
                        ) 
                    ELSE
                    CONCAT('Pidana Tambahan: '||pidana_tambahan) 
                    END dakwaan
                    FROM pidum.pdm_amar_putusp29
                    WHERE id_perkara = '" . $id_perkara . "'
                    AND id_tersangka = '" . $id_tersangka . "'
                ";
        $query = Yii::$app->db->createCommand($query)->queryOne();

        return $query;
    }

    public static function getStaticDakwaan($id_perkara, $id_tersangka){
        $query = "SELECT
                    CASE WHEN id_ms_rentut = 3 THEN -- Pidana Penjara
                        CONCAT(
                            'Masa Percobaan: '||tahun_coba||' Tahun - '||bulan_coba||' Bulan - '||hari_coba||' Hari'||', '
                            'Pidana Badan: '||tahun_badan||' Tahun - '||bulan_badan||' Bulan - '||hari_badan||' Hari'||', '
                            'Denda: Rp '||denda||',00 , '
                            'SubSidair: '||tahun_sidair||' Tahun - '||bulan_sidair||' Bulan - '||hari_sidair||' Hari'||', '
                            'Biaya Perkara: Rp '||biaya_perkara||',00 , '
                            'Pidana Tambahan: '||pidana_tambahan||', '
                            'Pidana Pengawasan: '||(SELECT nama FROM pidum.pdm_pidana_pengawasan WHERE id = id_ms_pidanapengawasan)||' '
                        ) 
                    WHEN id_ms_rentut = 4 THEN
                        CONCAT(
                            'Kurungan: '||bulan_kurung||' Bulan - '||hari_kurung||' Hari'||', '
                            'Pidana Tambahan: '||pidana_tambahan||' '
                        ) 
                    ELSE
                    CONCAT('Pidana Tambahan: '||pidana_tambahan) 
                    END dakwaan
                    FROM pidum.pdm_amar_putusp29
                    WHERE id_perkara = '" . $id_perkara . "'
                    AND id_tersangka = '" . $id_tersangka . "'
                ";
        $query = Yii::$app->db->createCommand($query)->queryOne();

        return $query;
    }
}