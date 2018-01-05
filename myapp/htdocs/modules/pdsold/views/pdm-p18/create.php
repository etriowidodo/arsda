<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP18 */

$this->title = 'Hasil Penyelidikan Belum Lengkap';
$this->params['breadcrumbs'][] = ['label' => 'Pdm P18s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p18-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelSpdp' => $modelSpdp,
        'modelPengantar' => $modelPengantar,
        'modelBerkas' => $modelBerkas,
        'modelTersangka' => $modelTersangka,
        'modelInsPenyidik' => $modelInsPenyidik,
        'sysMenu' => $sysMenu
    ]) ?>

</div>
