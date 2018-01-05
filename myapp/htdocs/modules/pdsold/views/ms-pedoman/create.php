<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsPedoman */

$this->title = 'Master Pedoman Tuntutan Pidana';
//$this->params['breadcrumbs'][] = ['label' => 'Pedoman', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-pedoman-create">


    <?= $this->render('_form', [
        'model' => $model,
		'searchUU' => $searchUU,
        'dataUU' => $dataUU,
    ]) ?>

</div>
