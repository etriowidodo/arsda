<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenandatangan */
$this->title = 'PenandaTangan';


?>
<div class="pdm-penandatangan-create">

     <?= $this->render('_form', [
        'model' => $model,
        'searchJPU' => $searchJPU,
        'dataJPU' => $dataJPU,
     ]) ?>

</div>
