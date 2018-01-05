<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmPenyelesaianPratutLimpah;
use app\modules\pidum\models\PdmPenyelesaianPratut;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmPenyelesaianPratutLimpahJaksa;
use app\modules\pidum\models\PdmPenyelesaianPratutLimpahSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\components\GlobalConstMenuComponent;
/**
 * PdmPenyelesaianPratutLimpahController implements the CRUD actions for PdmPenyelesaianPratutLimpah model.
 */
class PdmPenyelesaianPratutLimpahController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PdmPenyelesaianPratutLimpah models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PdmPenyelesaianPratutLimpahSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmPenyelesaianPratutLimpah model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmPenyelesaianPratutLimpah model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmPenyelesaianPratutLimpah();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pratut_limpah]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdmPenyelesaianPratutLimpah model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pratut_limpah]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PdmPenyelesaianPratutLimpah model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmPenyelesaianPratutLimpah model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmPenyelesaianPratutLimpah the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmPenyelesaianPratutLimpah::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionCetak($id) {
		$connection = \Yii::$app->db;
		$odf = new \Odf(Yii::$app->params['report-path'] . "web/template/pidum/limpah.odt");
		
		$model = PdmPenyelesaianPratutLimpah::findOne(['id_pratut_limpah' => $id]);
		$modelSpdp = PdmSpdp::findOne(['id_perkara' => trim($model->id_perkara)]);
		$modelPratut = PdmPenyelesaianPratut::findOne(['id_pratut' => trim($model->id_pratut)]);
		$modelJaksa = PdmPenyelesaianPratutLimpahJaksa::findAll(['id_pratut_limpah' => trim($model->id_pratut_limpah)]);
		$modelTersangka = Yii::$app->db->createCommand(" select string_agg(c.nama,', ') as nama, a.no_berkas,a.tgl_berkas
		from 
		pidum.pdm_berkas_tahap1 a 
		INNER JOIN (
			select x.* from 
			pidum.pdm_pengantar_tahap1 x inner join (
				select max(id_pengantar) as id_pengantar from pidum.pdm_pengantar_tahap1 group by id_berkas 
			)y on x.id_pengantar = y.id_pengantar
        ) b on a.id_berkas = b.id_berkas
		INNER JOIN pidum.ms_tersangka_berkas c on b.id_pengantar = c.id_pengantar
		WHERE a.id_berkas='".$modelPratut->id_berkas."' GROUP BY a.no_berkas,a.tgl_berkas ")->queryOne();
		
		$odf->setVars('nama_penandatangan', $model->nama);
		$odf->setVars('jabatan_penandatangan', $model->jabatan);
        $odf->setVars('pangkat', $model->pangkat);
        $odf->setVars('nip_penandatangan', $model->id_penandatangan);
        $odf->setVars('nomor', $model->no_surat);
        $odf->setVars('sifat', $model->sifat);
        $odf->setVars('lampiran', $model->lampiran);
        $odf->setVars('dikeluarkan', $model->dikeluarkan);
        $odf->setVars('kepada', $model->kepada);
        $odf->setVars('di_tempat', $model->di_kepada);
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama);
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan));
		
		$odf->setVars('nama_tersangka_berkas', $modelTersangka['nama']);
		$odf->setVars('nomor_berkas', $modelTersangka['no_berkas']);
		$odf->setVars('tanggal_berkas', Yii::$app->globalfunc->ViewIndonesianFormat($modelTersangka['tgl_berkas']));
		
		$query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where(" trim(id_perkara) ='" .trim($model->id_perkara)."' AND  kode_table='" . GlobalConstMenuComponent::LimpahBerkas . "'")
                ->orderby('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
		$i=1;
		
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($i);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
			$i++;
        }
        $odf->mergeSegment($dft_tembusan);
		
		$dft_jaksa = $odf->setSegment('jaksa_p16a');
		$i=1;
		
        foreach ($modelJaksa as $element) {
            $dft_jaksa->nama($element->nama);
            $dft_jaksa->merge();
			
        }
        $odf->mergeSegment($dft_jaksa);
		
		$odf->exportAsAttachedFile('limpahBerkas.odt');
	}
}
