<?php

use yii\web\View;

/* @var $this View */
/* @var $model app\modules\pidum\models\pdmb17 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
// $this->params['breadcrumbs'][] = ['label' => 'Pdmb17s', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_b17, 'url' => ['view', 'id' => $model->id_b17]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdmb17-update">



    <?=
    $this->render('_form', [
        'model' => $model,
        'modelSpdp' => $modelSpdp,
        'modelTersangka' => $modelTersangka,
        'id' => $id,
        'modelVwTersangka' => $modelVwTersangka,
        'modelbarbuk' => $modelbarbuk
    ])
    ?>

</div>
