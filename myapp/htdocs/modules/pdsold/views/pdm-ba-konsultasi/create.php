<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBaKonsultasi */

$this->title = 'Berita Acara Konsultasi';
//$this->params['breadcrumbs'][] = ['label' => 'Pdm Ba Konsultasis', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-ba-konsultasi-create">

   

    <?= $this->render('_form', [
        'model' => $model,
        'jaksa' => $jaksa,
        'jaksa_p16' => $jaksa_p16,
    ]) ?>

</div>
