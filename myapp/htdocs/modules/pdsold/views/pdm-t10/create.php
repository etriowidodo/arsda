<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT10 */

$this->title = 'T10';
$this->subtitle = 'Surat Ijin Mengunjungi Tahanan';
/*$this->params['breadcrumbs'][] = ['label' => 'Pdm T10s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="pdm-t10-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?= $this->render('_form', [
        'model'                 => $model,
        'no_register_perkara'   => $no_register_perkara,
    ]) ?>

</div>
