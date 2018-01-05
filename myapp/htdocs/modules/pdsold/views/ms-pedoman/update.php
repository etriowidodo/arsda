<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsPedoman */

$this->title = 'Pedoman Tuntutan Pidana ' ;
/*$this->params['breadcrumbs'][] = ['label' => 'Ms Pedomen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->uu, 'url' => ['view', 'uu' => $model->uu, 'pasal' => $model->pasal, 'kategori' => $model->kategori]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="ms-pedoman-update">

 

    <?= $this->render('_form', [
        'model' => $model,
		'searchUU' => $searchUU,
        'dataUU' => $dataUU,
    ]) ?>

</div>
