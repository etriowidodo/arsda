<?php

use yii\web\View;

/* @var $this View */
/* @var $model app\modules\pidum\models\pdmb17 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
// $this->params['breadcrumbs'][] = ['label' => 'Pdmb17s', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdmb17-create">

    <?=
    $this->render('_form', [
        'model' => $model,
        'modelSpdp' => $modelSpdp,
        'id' => $id,
        'modelbarbuk' => $modelbarbuk
    ])
    ?>

</div>
