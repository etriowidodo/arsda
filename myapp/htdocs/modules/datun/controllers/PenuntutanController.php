<?php

namespace app\modules\pidum\controllers;


use app\modules\pidum\models\VwGridPenuntutanSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Jaspersoft\Client\Client;
use yii\web\Session;

/**
 * SpdpController implements the CRUD actions for PidumPdmSpdp model.
 */
class PenuntutanController extends Controller
{
    /**
     * Lists all PidumPdmSpdp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VwGridPenuntutanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = '15';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	
	 public function actionUpdate($id)
    {
        //return $this->redirect([$url, 'id' => $id]);

        //Yii::$app->globalfunc->setSessionPerkara($id);
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $id);

        //return $this->redirect('index');
		return $this->redirect(\Yii::$app->urlManager->createUrl("pidum/pdm-ba15/index"));
        /*$model = $this->findModel($id);
        $modelTersangka = new MsTersangka();
        $modelTersangkaUpdate = $this->findModelTersangka($id);
        $modelPasal = new PdmPasal();
        $modelPasalUpdate = $this->findModelPasal($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_perkara]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelTersangka' => $modelTersangka,
                'modelTersangkaUpdate' => $modelTersangkaUpdate,
                'modelPasal' => $modelPasal
            ]);
        }*/
    }
    
}
