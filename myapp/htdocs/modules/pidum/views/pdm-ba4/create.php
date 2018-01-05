<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA15 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba4-create">


    <?=
    $this->render('_form', [
        'model' => $model,
        'agama'             => $agama,
        'identitas'         => $identitas,
        'JenisKelamin'      => $JenisKelamin,
        'pendidikan'        => $pendidikan,
        'warganegara'       => $warganegara,
        'maxPendidikan'     => $maxPendidikan,                
        'searchJPU'         => $searchJPU,
        'dataProviderJPU'   => $dataProviderJPU,
        'dataTersangka'     => $dataTersangka,
        'rp9'               => $rp9,

    ])
    ?>

</div>
