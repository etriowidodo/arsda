<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP26 */

$this->title = 'P-26';
$this->subtitle = 'SURAT KETETAPAN PENGHENTIAN PENUNTUTAN';
//$this->params['breadcrumbs'][] = ['label' => 'Pdm P26s', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p26-create">

    <!--<h1><?// Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model'         => $model,
        'modelJpu'      => $modelJpu,
        'modeljaksi'    => $modeljaksi,
        'searchJPU'     => $searchJPU,
        'dataJPU'       => $dataJPU,
        'no_register'   => $no_register,
    ]) ?>

</div>
