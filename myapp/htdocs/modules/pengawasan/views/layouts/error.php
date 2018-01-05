<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Was1 */

$this->title = 'WAS-Error';
$this->subtitle = 'Privilege';
// $this->params['ringkasan_perkara'] = $model->no_register;
// $this->params['breadcrumbs'][] = ['label' => 'Was1s', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_was1, 'url' => ['view', 'id' => $model->id_was1]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="was-error">
<div class="box box-primary" style="overflow:hidden;padding:10px 0px 15px 0px;">
    <div class="col-sm-12">
        <h3>Access denied; you need the SUPER privilege for this operation</h3>
        <p>Anda Tidak mempunyai Hak akses! hubungi Administrator</p>
    </div>    

</div>

        
</div>
       

<script type="text/javascript">
    $('#btn0').click(function(){
         $.ajax({
            type:'POST',
            url:'/pengawasan/was1/pemeriksa',
            // data:'id='+id,
            // success:function(data){
            // // $('#KejagungToBidang').html(data);
            
            // alert(data);
           // }
            });
    });
</script>
