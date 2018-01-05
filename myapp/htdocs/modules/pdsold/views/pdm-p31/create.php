<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP30 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
// $this->params['breadcrumbs'][] = ['label' => 'Pdm P31', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p31-create">

    <?= $this->render('_form', [
        'model' => $model,
                 'dataProviderTersangka' => $dataProviderTersangka, 
    ]) ?>

</div>
