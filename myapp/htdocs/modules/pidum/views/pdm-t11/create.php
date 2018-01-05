<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT11 */

$this->title = 'T11';
$this->subtitle = 'SURAT PERINTAH PEMERIKSAAN KESEHATAN TAHANAN';
?>
<div class="pdm-t11-create">
    <?=
    $this->render('_form', [
        'model'                 => $model,
        'sysMenu'               => $sysMenu,
        'no_register_perkara'   => $no_register_perkara,
        'dataJPU'               => $dataJPU,
        'searchJPU'             => $searchJPU,
        'modeltsk'              => $modeltsk,
    ])
    ?>

</div>
