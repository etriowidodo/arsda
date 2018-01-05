<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP26 */

$this->title = 'P-26';
$this->subtitle = 'SURAT KETETAPAN PENGHENTIAN PENUNTUTAN';
?>
<div class="pdm-p26-update">


    <?= $this->render('_form', [
        'model'         => $model,
        'modelJpu'      => $modelJpu,
        'modeljaksi'    => $modeljaksi,
        'searchJPU'     => $searchJPU,
        'dataJPU'       => $dataJPU,
        'no_register'   => $no_register,
    ]) ?>

</div>
