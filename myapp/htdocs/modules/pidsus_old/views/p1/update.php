<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'Update Laporan/Pengaduan: ' . ' ' . $model->id_pds_lid;
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_pds_lid, 'url' => ['view', 'id' => $model->id_pds_lid]];
//$this->params['breadcrumbs'][] = 'Update';
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    	'typeSurat' => '1',
    	'titleForm' => 'Update Laporan/Pengaduan',	
    ]) ?>

</div>
