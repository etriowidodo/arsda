<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PidumPdmSpdp */

$this->title = 'SPDP';
$this->subtitle = 'Surat Pemberitahuan Dimulainya Penyidikan';
?>
<div class="pidum-pdm-spdp-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelTersangka' => $modelTersangka,
        'modelTersangkaUpdate' => $modelTersangkaUpdate,
        'status_perkara' => $status_perkara,
        'mst_perkara' => $mst_perkara,
        'modelPasal' => $modelPasal
    ]) ?>

</div>
