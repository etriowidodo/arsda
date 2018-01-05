<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsPasal */

$this->title = 'Master Pasal';
/*$this->params['breadcrumbs'][] = ['label' => 'Pasal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="ms-pasal-create">

  

    <?= $this->render('_form', [
        'model' => $model,
		'searchUU' => $searchUU,
        'dataUU' => $dataUU,
    ]) ?>

</div>
