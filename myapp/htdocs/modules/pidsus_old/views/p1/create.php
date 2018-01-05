<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'Create Pengaduan/Laporan';
//$this->params['breadcrumbs'][] = ['label' => 'Pengaduan/Laporan', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pds-lid-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    	'typeSurat' => $typeSurat,	
    	'titleForm' => $titleForm,	
    ]) ?>

</div>
