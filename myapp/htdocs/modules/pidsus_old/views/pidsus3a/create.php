<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = $titleForm;
//$this->params['breadcrumbs'][] = ['label' => 'Create', 'url' => ['index?id='.$modelLid->id_pds_lid]];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelSuratIsi' => $modelSuratIsi,
        'modelTembusan'	 =>$modelTembusan,
        'modelLid' => $modelLid,
    	'typeSurat' => '1',	
    	'titleForm' => $titleForm,
    	'readOnly' => false,		
    ]) ?>

</div>
