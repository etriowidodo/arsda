<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBerkasTahap1 */
//$this->title = $sysMenu->kd_berkas;
//$this->subtitle = $sysMenu->keterangan;

$this->title = 'Penerimaan Berkas';
$this->subtitle = 'Penelitian Berkas Tahap I';
//$this->params['breadcrumbs'][] = ['label' => 'Pdm Berkas Tahap 1', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-berkas-tahap1-create">

    

    <?= $this->render('_form', [
        'model' => $model,
		'searchModel' => $searchModel,
		'dataProvider' => $dataProvider,
		'sysMenu'=>$sysMenu,
		'modelSpdp' => $modelSpdp,
		'modelPengantar'=> $modelPengantar,		
        'modelCeklis' => $modelCeklis
    ]) ?>

</div>
