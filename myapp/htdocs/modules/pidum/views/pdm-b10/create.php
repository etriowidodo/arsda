<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB10 */

//$this->title = 'Create Pdm B10';
//$this->params['breadcrumbs'][] = ['label' => 'Pdm B10s', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;

?>
<div class="pdm-b10-create">

    <h1><?// Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'no_register_perkara'=> $no_register_perkara,
        'listTersangka' => $listTersangka,
        'ba5' => $ba5,
        'listBarbuk' => $listBarbuk,
        'sysMenu' => $sysMenu,
        'modelBarbuk' => $modelBarbuk,
    ]) ?>

</div>
