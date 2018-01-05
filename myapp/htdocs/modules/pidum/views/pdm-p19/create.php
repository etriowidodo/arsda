<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP19 */

$this->title = 'Pengembalian Berkas Perkara untuk Dilengkapi';
$this->params['breadcrumbs'][] = ['label' => 'Pdm P19s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p19-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		      'model2' => $model2,
                        'modelPasalBerkas' => $modelPasalBerkas,
                        'modelTersangka' => $modelTersangka,
                        'modelBerkas' => $modelBerkas,
                        'modelSpdp' => $modelSpdp,
                        'sysMenu' => $sysMenu
    ]) ?>

</div>
