<?php

namespace app\modules\datun\controllers;

use app\modules\datun\models\PdmBarbukTambahan;
use app\modules\datun\models\PdmDetailB10;
use app\modules\datun\models\PdmTerdakwa;
use app\modules\datun\models\VwTerdakwa;
use app\modules\datun\models\PdmPenandatanganSearch;
use app\modules\datun\models\PdmSpdp;
use Yii;
use yii\db\Query;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTerdakwa()
    {
        $terdakwa = VwTerdakwa::find()
            ->where(['id_tersangka' => $_POST['id_tersangka']])
            ->one();

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'tmpt_lahir' => $terdakwa->tmpt_lahir,
            'tgl_lahir' => ($terdakwa->tgl_lahir != null) ? date('d-m-Y', strtotime($terdakwa->tgl_lahir)) : '',
            'jns_kelamin' => $terdakwa->is_jkl,
            'alamat' => $terdakwa->alamat,
            'agama' => $terdakwa->is_agama,
            'pekerjaan' => $terdakwa->pekerjaan,
            'pendidikan' => $terdakwa->is_pendidikan,
        ];
    }

    public function actionUndang($q = null){

        $query = new Query();
        $query->select(["*"])
            ->from('pidum.pdm_ms_uu')
            ->where("concat(lower(uu),'||',lower(keterangan), '||', lower(keyword) ) LIKE lower('%" . $q . "%')")->orderBy('uu');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out [] = [
                'value' => $d ['uu'],
                'nama' => $d ['keterangan'],
                'id' => $d ['id']
            ];
        }
        echo Json::encode($out);
    }

    public function actionDetilB10($id){

        $model = PdmDetailB10::findOne(['id_perkara' => \Yii::$app->session->get('id_perkara'), 'id_barbuk' => $id]);

        if($model == null)
            $model = new PdmDetailB10();

        $barbuk = PdmBarbukTambahan::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_detail_b10', 'id_dtb10', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

            $model->id_dtb10 = $seq['generate_pk'];

            if($model->save()) {
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
            }
        }else{
            return $this->renderAjax('_detilB10', [
                'model' => $model,
                'barbuk' => $barbuk
            ]);
        }
    }

    public function actionDashboard()
    {
        $connection = Yii::$app->db;

        $model = $connection->createCommand("
            SELECT
                ID,nama,
                CASE WHEN spdp_masuk.jml ISNULL THEN	0 ELSE spdp_masuk.jml END AS spdp_total,
              CASE WHEN sisa_bulan.jml ISNULL THEN 0 ELSE  sisa_bulan.jml  END  AS sisa_bulan_spdp,
                CASE WHEN spdp_selesai.jml ISNULL THEN 0 ELSE  spdp_selesai.jml  END AS spdp_selesai,
              CASE WHEN tuntutan_total.jml ISNULL THEN 0 ELSE  tuntutan_total.jml  END AS tuntutan_total,
                CASE WHEN tuntutan_selesai.jml ISNULL THEN 0 ELSE  tuntutan_selesai.jml  END AS tuntutan_selesai,
              CASE WHEN eksekusi_total.jml ISNULL THEN 0 ELSE  eksekusi_total.jml  END AS eksekusi_total ,
              CASE WHEN eksekusi_selesai.jml ISNULL THEN 0 ELSE  eksekusi_selesai.jml  END AS eksekusi_selesai

            FROM
                pidum.ms_bulan
            LEFT JOIN(
            SELECT
                  EXTRACT (YEAR FROM spdp.tgl_terima) AS tahun,
                    EXTRACT (MONTH FROM spdp.tgl_terima) AS bulan,
            count(spdp.id_perkara) jml
            FROM pidum.pdm_spdp spdp
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            AND pidum.get_tahun_bulan(spdp.tgl_terima) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM spdp.tgl_terima),
                    EXTRACT (MONTH FROM spdp.tgl_terima)
            )spdp_masuk ON (spdp_masuk.bulan = ms_bulan.id)
            LEFT JOIN (
            SELECT
                    EXTRACT (YEAR FROM spdp.tgl_terima) AS tahun,
                    EXTRACT (MONTH FROM spdp.tgl_terima) AS bulan,
                count(spdp.id_perkara) jml
            FROM pidum.pdm_berkas brks
            RIGHT JOIN pidum.pdm_spdp spdp ON (brks.id_perkara =spdp.id_perkara)
            LEFT JOIN pidum.pdm_pratut_putusan pratut ON (pratut.id_perkara = spdp.id_perkara)
            WHERE spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            AND pidum.get_tahun_bulan(spdp.tgl_terima) < pidum.get_tahun_bulan (current_date)
            AND (brks.tgl_terima ISNULL AND pratut.tgl_surat ISNULL)
            GROUP BY
                    EXTRACT (YEAR FROM spdp.tgl_terima),
                    EXTRACT (MONTH FROM spdp.tgl_terima)
            )sisa_bulan ON (sisa_bulan.bulan =  ms_bulan.id)
            LEFT JOIN (
            SELECT
            x.tahun,x.bulan,count(x.jml) jml
            from (

            select
                    EXTRACT (YEAR FROM p21.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p21.tgl_dikeluarkan) AS bulan,
            COUNT(p21.id_perkara) jml
            from
            pidum.pdm_spdp spdp INNER JOIN pidum.pdm_p21 p21 ON (p21.id_perkara = spdp.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p21.tgl_dikeluarkan)= pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p21.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p21.tgl_dikeluarkan)
            UNION
            select
            EXTRACT (YEAR FROM p22.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p22.tgl_dikeluarkan) AS bulan,
                count(p22.id_perkara) jml
            from
            pidum.pdm_spdp spdp INNER JOIN pidum.pdm_p22 p22 ON (p22.id_perkara = spdp.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p22.tgl_dikeluarkan)= pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p22.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p22.tgl_dikeluarkan)
            ) x
            GROUP BY x.tahun, x.bulan
            )spdp_selesai ON (spdp_selesai.bulan = ms_bulan.id)
            LEFT JOIN(
            SELECT
            EXTRACT (YEAR FROM thpdua.tgl_terima) AS tahun,
                    EXTRACT (MONTH FROM thpdua.tgl_terima) AS bulan,
                    count(thpdua.id_perkara) jml
            FROM
            pidum.pdm_spdp spdp inner join pidum.pdm_tahap_dua thpdua ON (spdp.id_perkara = thpdua.id_perkara)
            WHERE
            spdp.wilayah_kerja='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(thpdua.tgl_terima)= pidum.get_tahun_bulan (CURRENT_DATE)
            GROUP BY
                    EXTRACT (YEAR FROM thpdua.tgl_terima),
                    EXTRACT (MONTH FROM thpdua.tgl_terima)
            )tuntutan_total ON  (tuntutan_total.bulan = ms_bulan.id)
            LEFT JOIN(
            select
            y.tahun,
            y.bulan,
            count(y.jml) jml
            from (

            SELECT
                EXTRACT (YEAR FROM p31.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p31.tgl_dikeluarkan) AS bulan,
                count(p31.id_perkara) jml
            FROM
            pidum.pdm_p31 p31 LEFT JOIN pidum.pdm_spdp spdp ON (spdp.id_perkara=p31.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p31.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p31.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p31.tgl_dikeluarkan)
            UNION
            SELECT
                  EXTRACT (YEAR FROM p32.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p32.tgl_dikeluarkan) AS bulan,
                    count(p32.id_perkara) jml
            FROM
            pidum.pdm_p32 p32 LEFT JOIN pidum.pdm_spdp spdp ON (spdp.id_perkara=p32.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p32.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p32.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p32.tgl_dikeluarkan)
            ) y
            GROUP BY y.tahun,y.bulan
            )tuntutan_selesai ON (tuntutan_selesai.bulan = ms_bulan.id)
            LEFT JOIN(
            SELECT
                    EXTRACT (YEAR FROM p48.tgl_putusan) AS tahun,
                    EXTRACT (MONTH FROM p48.tgl_putusan) AS bulan,
                count(p48.id_perkara) jml
            FROM
            pidum.pdm_p48 p48 INNER JOIN pidum.pdm_spdp spdp ON (p48.id_perkara = spdp.id_perkara)
            WHERE
            case when spdp.id_satker_tujuan is null then spdp.wilayah_kerja else spdp.wilayah_kerja end = '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p48.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p48.tgl_putusan),
                    EXTRACT (MONTH FROM p48.tgl_putusan)
            ) eksekusi_total ON (eksekusi_total.bulan = ms_bulan.id)
            LEFT JOIN(
            SELECT

                    EXTRACT (YEAR FROM p52.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p52.tgl_dikeluarkan) AS bulan,
                count(p52.id_perkara) jml
            FROM
            pidum.pdm_spdp spdp INNER JOIN pidum.pdm_p52 p52 ON (spdp.id_perkara =p52.id_perkara)
            WHERE
            case when spdp.id_satker_tujuan is null then spdp.wilayah_kerja else spdp.wilayah_kerja end = '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p52.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p52.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p52.tgl_dikeluarkan)
            )eksekusi_selesai ON (eksekusi_selesai.bulan = ms_bulan.id)
            where ms_bulan.id = ".date('m')."
        ");

        $dashboard = $model->queryAll();

        $json = [];
        foreach ($dashboard as $item) {
            $total = [$item['spdp_total'], $item['tuntutan_total'], $item['eksekusi_total']];
            $selesai = [$item['spdp_selesai'], $item['tuntutan_selesai'], $item['eksekusi_selesai']];

            array_push($json, $total, $selesai);
        }

        $json = json_encode($json);

        return $this->render('dashboard',[
            'json' => $json,
            'jsonSpdp' => $this->DashSpdp(),
            'jsonTuntutan' => $this->DashTuntutan(),
            'jsonEksekusi' => $this->DashEksekusi()
        ]);
    }

    private function DashSpdp()
    {
        $connection = Yii::$app->db;

        $model = $connection->createCommand("
            SELECT
                ID,nama,
                CASE WHEN spdp_masuk.jml ISNULL THEN    0 ELSE spdp_masuk.jml END AS spdp_total,
                CASE WHEN spdp_selesai.jml ISNULL THEN 0 ELSE  spdp_selesai.jml  END AS spdp_selesai
              
            FROM
                pidum.ms_bulan
            LEFT JOIN(
            SELECT
                  EXTRACT (YEAR FROM spdp.tgl_terima) AS tahun,
                    EXTRACT (MONTH FROM spdp.tgl_terima) AS bulan,
            count(spdp.id_perkara) jml
            FROM pidum.pdm_spdp spdp
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            AND pidum.get_tahun_bulan(spdp.tgl_terima) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM spdp.tgl_terima),
                    EXTRACT (MONTH FROM spdp.tgl_terima)
            )spdp_masuk ON (spdp_masuk.bulan = ms_bulan.id)
            LEFT JOIN (
            SELECT
                    EXTRACT (YEAR FROM spdp.tgl_terima) AS tahun,
                    EXTRACT (MONTH FROM spdp.tgl_terima) AS bulan,
                count(spdp.id_perkara) jml
            FROM pidum.pdm_berkas brks
            RIGHT JOIN pidum.pdm_spdp spdp ON (brks.id_perkara =spdp.id_perkara)
            LEFT JOIN pidum.pdm_pratut_putusan pratut ON (pratut.id_perkara = spdp.id_perkara)
            WHERE spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            AND pidum.get_tahun_bulan(spdp.tgl_terima) < pidum.get_tahun_bulan (current_date)
            AND (brks.tgl_terima ISNULL AND pratut.tgl_surat ISNULL)
            GROUP BY
                    EXTRACT (YEAR FROM spdp.tgl_terima),
                    EXTRACT (MONTH FROM spdp.tgl_terima)
            )sisa_bulan ON (sisa_bulan.bulan =  ms_bulan.id)
            LEFT JOIN (
            SELECT
            x.tahun,x.bulan,count(x.jml) jml
            from (

            select
                    EXTRACT (YEAR FROM p21.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p21.tgl_dikeluarkan) AS bulan,
            COUNT(p21.id_perkara) jml
            from
            pidum.pdm_spdp spdp INNER JOIN pidum.pdm_p21 p21 ON (p21.id_perkara = spdp.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p21.tgl_dikeluarkan)= pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p21.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p21.tgl_dikeluarkan)
            UNION
            select
            EXTRACT (YEAR FROM p22.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p22.tgl_dikeluarkan) AS bulan,
                count(p22.id_perkara) jml
            from
            pidum.pdm_spdp spdp INNER JOIN pidum.pdm_p22 p22 ON (p22.id_perkara = spdp.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p22.tgl_dikeluarkan)= pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p22.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p22.tgl_dikeluarkan)
            ) x
            GROUP BY x.tahun, x.bulan
            )spdp_selesai ON (spdp_selesai.bulan = ms_bulan.id)
            LEFT JOIN(
            SELECT
            EXTRACT (YEAR FROM thpdua.tgl_terima) AS tahun,
                    EXTRACT (MONTH FROM thpdua.tgl_terima) AS bulan,
                    count(thpdua.id_perkara) jml
            FROM
            pidum.pdm_spdp spdp inner join pidum.pdm_tahap_dua thpdua ON (spdp.id_perkara = thpdua.id_perkara)
            WHERE
            spdp.wilayah_kerja='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(thpdua.tgl_terima)= pidum.get_tahun_bulan (CURRENT_DATE)
            GROUP BY
                    EXTRACT (YEAR FROM thpdua.tgl_terima),
                    EXTRACT (MONTH FROM thpdua.tgl_terima)
            )tuntutan_total ON  (tuntutan_total.bulan = ms_bulan.id)
            LEFT JOIN(
            select
            y.tahun,
            y.bulan,
            count(y.jml) jml
            from (

            SELECT
                EXTRACT (YEAR FROM p31.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p31.tgl_dikeluarkan) AS bulan,
                count(p31.id_perkara) jml
            FROM
            pidum.pdm_p31 p31 LEFT JOIN pidum.pdm_spdp spdp ON (spdp.id_perkara=p31.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p31.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p31.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p31.tgl_dikeluarkan)
            UNION
            SELECT
                  EXTRACT (YEAR FROM p32.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p32.tgl_dikeluarkan) AS bulan,
                    count(p32.id_perkara) jml
            FROM
            pidum.pdm_p32 p32 LEFT JOIN pidum.pdm_spdp spdp ON (spdp.id_perkara=p32.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p32.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p32.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p32.tgl_dikeluarkan)
            ) y
            GROUP BY y.tahun,y.bulan
            )tuntutan_selesai ON (tuntutan_selesai.bulan = ms_bulan.id)
            LEFT JOIN(
            SELECT
                    EXTRACT (YEAR FROM p48.tgl_putusan) AS tahun,
                    EXTRACT (MONTH FROM p48.tgl_putusan) AS bulan,
                count(p48.id_perkara) jml
            FROM
            pidum.pdm_p48 p48 INNER JOIN pidum.pdm_spdp spdp ON (p48.id_perkara = spdp.id_perkara)
            WHERE
            case when spdp.id_satker_tujuan is null then spdp.wilayah_kerja else spdp.wilayah_kerja end = '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p48.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p48.tgl_putusan),
                    EXTRACT (MONTH FROM p48.tgl_putusan)
            ) eksekusi_total ON (eksekusi_total.bulan = ms_bulan.id)
            LEFT JOIN(
            SELECT

                    EXTRACT (YEAR FROM p52.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p52.tgl_dikeluarkan) AS bulan,
                count(p52.id_perkara) jml
            FROM
            pidum.pdm_spdp spdp INNER JOIN pidum.pdm_p52 p52 ON (spdp.id_perkara =p52.id_perkara)
            WHERE
            case when spdp.id_satker_tujuan is null then spdp.wilayah_kerja else spdp.wilayah_kerja end = '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p52.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p52.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p52.tgl_dikeluarkan)
            )eksekusi_selesai ON (eksekusi_selesai.bulan = ms_bulan.id)
            
        ");

        $dashboard = $model->queryAll();

        $json = [
            'data' => []
        ];
        foreach ($dashboard as $item) {
            $data = [
                'label' => $item['nama'],
                'data'  => [
                    $item['spdp_total'],$item['spdp_selesai']
                ]
            ];
            
            array_push($json['data'], $data);
        }

        return json_encode($json);
    }

    private function DashTuntutan()
    {
        $connection = Yii::$app->db;

        $model = $connection->createCommand("
            SELECT
                ID,nama,
                CASE WHEN tuntutan_total.jml ISNULL THEN 0 ELSE  tuntutan_total.jml  END AS tuntutan_total,
                CASE WHEN tuntutan_selesai.jml ISNULL THEN 0 ELSE  tuntutan_selesai.jml  END AS tuntutan_selesai
              
            FROM
                pidum.ms_bulan
            LEFT JOIN(
            SELECT
                  EXTRACT (YEAR FROM spdp.tgl_terima) AS tahun,
                    EXTRACT (MONTH FROM spdp.tgl_terima) AS bulan,
            count(spdp.id_perkara) jml
            FROM pidum.pdm_spdp spdp
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            AND pidum.get_tahun_bulan(spdp.tgl_terima) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM spdp.tgl_terima),
                    EXTRACT (MONTH FROM spdp.tgl_terima)
            )spdp_masuk ON (spdp_masuk.bulan = ms_bulan.id)
            LEFT JOIN (
            SELECT
                    EXTRACT (YEAR FROM spdp.tgl_terima) AS tahun,
                    EXTRACT (MONTH FROM spdp.tgl_terima) AS bulan,
                count(spdp.id_perkara) jml
            FROM pidum.pdm_berkas brks
            RIGHT JOIN pidum.pdm_spdp spdp ON (brks.id_perkara =spdp.id_perkara)
            LEFT JOIN pidum.pdm_pratut_putusan pratut ON (pratut.id_perkara = spdp.id_perkara)
            WHERE spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            AND pidum.get_tahun_bulan(spdp.tgl_terima) < pidum.get_tahun_bulan (current_date)
            AND (brks.tgl_terima ISNULL AND pratut.tgl_surat ISNULL)
            GROUP BY
                    EXTRACT (YEAR FROM spdp.tgl_terima),
                    EXTRACT (MONTH FROM spdp.tgl_terima)
            )sisa_bulan ON (sisa_bulan.bulan =  ms_bulan.id)
            LEFT JOIN (
            SELECT
            x.tahun,x.bulan,count(x.jml) jml
            from (

            select
                    EXTRACT (YEAR FROM p21.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p21.tgl_dikeluarkan) AS bulan,
            COUNT(p21.id_perkara) jml
            from
            pidum.pdm_spdp spdp INNER JOIN pidum.pdm_p21 p21 ON (p21.id_perkara = spdp.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p21.tgl_dikeluarkan)= pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p21.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p21.tgl_dikeluarkan)
            UNION
            select
            EXTRACT (YEAR FROM p22.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p22.tgl_dikeluarkan) AS bulan,
                count(p22.id_perkara) jml
            from
            pidum.pdm_spdp spdp INNER JOIN pidum.pdm_p22 p22 ON (p22.id_perkara = spdp.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p22.tgl_dikeluarkan)= pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p22.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p22.tgl_dikeluarkan)
            ) x
            GROUP BY x.tahun, x.bulan
            )spdp_selesai ON (spdp_selesai.bulan = ms_bulan.id)
            LEFT JOIN(
            SELECT
            EXTRACT (YEAR FROM thpdua.tgl_terima) AS tahun,
                    EXTRACT (MONTH FROM thpdua.tgl_terima) AS bulan,
                    count(thpdua.id_perkara) jml
            FROM
            pidum.pdm_spdp spdp inner join pidum.pdm_tahap_dua thpdua ON (spdp.id_perkara = thpdua.id_perkara)
            WHERE
            spdp.wilayah_kerja='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(thpdua.tgl_terima)= pidum.get_tahun_bulan (CURRENT_DATE)
            GROUP BY
                    EXTRACT (YEAR FROM thpdua.tgl_terima),
                    EXTRACT (MONTH FROM thpdua.tgl_terima)
            )tuntutan_total ON  (tuntutan_total.bulan = ms_bulan.id)
            LEFT JOIN(
            select
            y.tahun,
            y.bulan,
            count(y.jml) jml
            from (

            SELECT
                EXTRACT (YEAR FROM p31.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p31.tgl_dikeluarkan) AS bulan,
                count(p31.id_perkara) jml
            FROM
            pidum.pdm_p31 p31 LEFT JOIN pidum.pdm_spdp spdp ON (spdp.id_perkara=p31.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p31.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p31.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p31.tgl_dikeluarkan)
            UNION
            SELECT
                  EXTRACT (YEAR FROM p32.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p32.tgl_dikeluarkan) AS bulan,
                    count(p32.id_perkara) jml
            FROM
            pidum.pdm_p32 p32 LEFT JOIN pidum.pdm_spdp spdp ON (spdp.id_perkara=p32.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p32.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p32.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p32.tgl_dikeluarkan)
            ) y
            GROUP BY y.tahun,y.bulan
            )tuntutan_selesai ON (tuntutan_selesai.bulan = ms_bulan.id)
            LEFT JOIN(
            SELECT
                    EXTRACT (YEAR FROM p48.tgl_putusan) AS tahun,
                    EXTRACT (MONTH FROM p48.tgl_putusan) AS bulan,
                count(p48.id_perkara) jml
            FROM
            pidum.pdm_p48 p48 INNER JOIN pidum.pdm_spdp spdp ON (p48.id_perkara = spdp.id_perkara)
            WHERE
            case when spdp.id_satker_tujuan is null then spdp.wilayah_kerja else spdp.wilayah_kerja end = '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p48.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p48.tgl_putusan),
                    EXTRACT (MONTH FROM p48.tgl_putusan)
            ) eksekusi_total ON (eksekusi_total.bulan = ms_bulan.id)
            LEFT JOIN(
            SELECT

                    EXTRACT (YEAR FROM p52.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p52.tgl_dikeluarkan) AS bulan,
                count(p52.id_perkara) jml
            FROM
            pidum.pdm_spdp spdp INNER JOIN pidum.pdm_p52 p52 ON (spdp.id_perkara =p52.id_perkara)
            WHERE
            case when spdp.id_satker_tujuan is null then spdp.wilayah_kerja else spdp.wilayah_kerja end = '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p52.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p52.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p52.tgl_dikeluarkan)
            )eksekusi_selesai ON (eksekusi_selesai.bulan = ms_bulan.id)
            
        ");

        $dashboard = $model->queryAll();

        $json = [
            'data' => []
        ];
        foreach ($dashboard as $item) {
            $data = [
                'label' => $item['nama'],
                'data'  => [
                    $item['tuntutan_total'],$item['tuntutan_selesai']
                ]
            ];
            
            array_push($json['data'], $data);
        }

        return json_encode($json);
    }
       public function actionPopupPenandaTangan() {
        $searchModel = new PdmPenandatanganSearch();
  //$dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
         $dataProvider2 = $searchModel->searchPenandaTangan(Yii::$app->request->queryParams);
//var_dump ($dataProvider2);exit;
//echo $dataProvider['id_tersangka'];exit;
//$dataProvider->pagination->pageSize = 5;
        $dataProvider2->pagination->pageSize = 5;
        return $this->renderAjax('_penandaTangan', [
                    'searchModelPenandatangan'   => $searchModel,
                    'dataProvider'               => $dataProvider,
                    'dataProvider2'              => $dataProvider2,
        ]);
    }

    private function DashEksekusi()
    {
        $connection = Yii::$app->db;

        $model = $connection->createCommand("
            SELECT
                ID,nama,
                CASE WHEN eksekusi_total.jml ISNULL THEN 0 ELSE  eksekusi_total.jml  END AS eksekusi_total ,
              CASE WHEN eksekusi_selesai.jml ISNULL THEN 0 ELSE  eksekusi_selesai.jml  END AS eksekusi_selesai
              
            FROM
                pidum.ms_bulan
            LEFT JOIN(
            SELECT
                  EXTRACT (YEAR FROM spdp.tgl_terima) AS tahun,
                    EXTRACT (MONTH FROM spdp.tgl_terima) AS bulan,
            count(spdp.id_perkara) jml
            FROM pidum.pdm_spdp spdp
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            AND pidum.get_tahun_bulan(spdp.tgl_terima) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM spdp.tgl_terima),
                    EXTRACT (MONTH FROM spdp.tgl_terima)
            )spdp_masuk ON (spdp_masuk.bulan = ms_bulan.id)
            LEFT JOIN (
            SELECT
                    EXTRACT (YEAR FROM spdp.tgl_terima) AS tahun,
                    EXTRACT (MONTH FROM spdp.tgl_terima) AS bulan,
                count(spdp.id_perkara) jml
            FROM pidum.pdm_berkas brks
            RIGHT JOIN pidum.pdm_spdp spdp ON (brks.id_perkara =spdp.id_perkara)
            LEFT JOIN pidum.pdm_pratut_putusan pratut ON (pratut.id_perkara = spdp.id_perkara)
            WHERE spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            AND pidum.get_tahun_bulan(spdp.tgl_terima) < pidum.get_tahun_bulan (current_date)
            AND (brks.tgl_terima ISNULL AND pratut.tgl_surat ISNULL)
            GROUP BY
                    EXTRACT (YEAR FROM spdp.tgl_terima),
                    EXTRACT (MONTH FROM spdp.tgl_terima)
            )sisa_bulan ON (sisa_bulan.bulan =  ms_bulan.id)
            LEFT JOIN (
            SELECT
            x.tahun,x.bulan,count(x.jml) jml
            from (

            select
                    EXTRACT (YEAR FROM p21.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p21.tgl_dikeluarkan) AS bulan,
            COUNT(p21.id_perkara) jml
            from
            pidum.pdm_spdp spdp INNER JOIN pidum.pdm_p21 p21 ON (p21.id_perkara = spdp.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p21.tgl_dikeluarkan)= pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p21.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p21.tgl_dikeluarkan)
            UNION
            select
            EXTRACT (YEAR FROM p22.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p22.tgl_dikeluarkan) AS bulan,
                count(p22.id_perkara) jml
            from
            pidum.pdm_spdp spdp INNER JOIN pidum.pdm_p22 p22 ON (p22.id_perkara = spdp.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p22.tgl_dikeluarkan)= pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p22.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p22.tgl_dikeluarkan)
            ) x
            GROUP BY x.tahun, x.bulan
            )spdp_selesai ON (spdp_selesai.bulan = ms_bulan.id)
            LEFT JOIN(
            SELECT
            EXTRACT (YEAR FROM thpdua.tgl_terima) AS tahun,
                    EXTRACT (MONTH FROM thpdua.tgl_terima) AS bulan,
                    count(thpdua.id_perkara) jml
            FROM
            pidum.pdm_spdp spdp inner join pidum.pdm_tahap_dua thpdua ON (spdp.id_perkara = thpdua.id_perkara)
            WHERE
            spdp.wilayah_kerja='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(thpdua.tgl_terima)= pidum.get_tahun_bulan (CURRENT_DATE)
            GROUP BY
                    EXTRACT (YEAR FROM thpdua.tgl_terima),
                    EXTRACT (MONTH FROM thpdua.tgl_terima)
            )tuntutan_total ON  (tuntutan_total.bulan = ms_bulan.id)
            LEFT JOIN(
            select
            y.tahun,
            y.bulan,
            count(y.jml) jml
            from (

            SELECT
                EXTRACT (YEAR FROM p31.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p31.tgl_dikeluarkan) AS bulan,
                count(p31.id_perkara) jml
            FROM
            pidum.pdm_p31 p31 LEFT JOIN pidum.pdm_spdp spdp ON (spdp.id_perkara=p31.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p31.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p31.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p31.tgl_dikeluarkan)
            UNION
            SELECT
                  EXTRACT (YEAR FROM p32.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p32.tgl_dikeluarkan) AS bulan,
                    count(p32.id_perkara) jml
            FROM
            pidum.pdm_p32 p32 LEFT JOIN pidum.pdm_spdp spdp ON (spdp.id_perkara=p32.id_perkara)
            WHERE
            spdp.wilayah_kerja ='".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p32.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p32.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p32.tgl_dikeluarkan)
            ) y
            GROUP BY y.tahun,y.bulan
            )tuntutan_selesai ON (tuntutan_selesai.bulan = ms_bulan.id)
            LEFT JOIN(
            SELECT
                    EXTRACT (YEAR FROM p48.tgl_putusan) AS tahun,
                    EXTRACT (MONTH FROM p48.tgl_putusan) AS bulan,
                count(p48.id_perkara) jml
            FROM
            pidum.pdm_p48 p48 INNER JOIN pidum.pdm_spdp spdp ON (p48.id_perkara = spdp.id_perkara)
            WHERE
            case when spdp.id_satker_tujuan is null then spdp.wilayah_kerja else spdp.wilayah_kerja end = '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p48.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p48.tgl_putusan),
                    EXTRACT (MONTH FROM p48.tgl_putusan)
            ) eksekusi_total ON (eksekusi_total.bulan = ms_bulan.id)
            LEFT JOIN(
            SELECT

                    EXTRACT (YEAR FROM p52.tgl_dikeluarkan) AS tahun,
                    EXTRACT (MONTH FROM p52.tgl_dikeluarkan) AS bulan,
                count(p52.id_perkara) jml
            FROM
            pidum.pdm_spdp spdp INNER JOIN pidum.pdm_p52 p52 ON (spdp.id_perkara =p52.id_perkara)
            WHERE
            case when spdp.id_satker_tujuan is null then spdp.wilayah_kerja else spdp.wilayah_kerja end = '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."'
            and pidum.get_tahun_bulan(p52.tgl_dikeluarkan) = pidum.get_tahun_bulan (current_date)
            GROUP BY
                    EXTRACT (YEAR FROM p52.tgl_dikeluarkan),
                    EXTRACT (MONTH FROM p52.tgl_dikeluarkan)
            )eksekusi_selesai ON (eksekusi_selesai.bulan = ms_bulan.id)
            
        ");

        $dashboard = $model->queryAll();

        $json = [
            'data' => []
        ];
        foreach ($dashboard as $item) {
            $data = [
                'label' => $item['nama'],
                'data'  => [
                    $item['eksekusi_total'],$item['eksekusi_selesai']
                ]
            ];
            
            array_push($json['data'], $data);
        }

        return json_encode($json);
    }

    
}
