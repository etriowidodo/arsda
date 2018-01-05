<?php

use yii\helpers\Html;
// use kartik\datecontrol\DateControl;
// use kartik\widgets\ActiveForm;
// // use kartik\widgets\DatePicker;
// use kartik\grid\GridView;
// use kartik\grid\DataColumn;
// use yii\helpers\ArrayHelper;
// use yii\bootstrap\Modal;
// use kartik\widgets\FileInput;
// use yii\helpers\Url;
// use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Lapdu */

// $this->title = 'Update Lapdu: ' . ' ' . $model->no_register;
// $this->params['breadcrumbs'][] = ['label' => 'Lapdus', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->no_register, 'url' => ['view', 'id' => $model->no_register]];
// $this->params['breadcrumbs'][] = 'Update';
$this->title = 'WAS - 1 (TELAAHAN)';
$this->params['ringkasan_perkara'] = $model->no_register;
$this->params['breadcrumbs'][] = ['label' => 'lapdu', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="lapdu-update">

    <h1><?//= Html::encode($this->title) ?></h1>
    <h1><?//= $view ?></h1>


</div>
<!-- <div class="box box-primary" style="overflow:hidden;padding:10px 0px 15px 0px;height:150px">
<div class="col-md-12"> -->
     <!-- <div class="col-md-10"> -->
        <!-- <div class="form-group"> -->
            <!-- <label class="control-label col-md-2"></label> -->
        <!-- <div class="col-md-12">
             <fieldset class="group-border">
                <legend class="group-border">Dari Siapa Ke siapa</legend>
                <input type="radio" name="tujuan" id="radio1" class="radiotujuan" value="1" <?php  if($view=='_form_pemeriksa'){echo "checked";} ?>> Pemeriksa -> IRMUD
                <input type="radio" name="tujuan" id="radio2" class="radiotujuan" value="2" <?php  if($view=='_form_irmud'){echo "checked";} ?>> IRMUD -> INSPEKTUR
                <input type="radio" name="tujuan" id="radio3" class="radiotujuan" value="3" <?php  if($view=='_form_inspektur'){echo "checked";} ?>> INSPEKTUR -> JAMWAS
             </fieldset>
<div id="wait" style="display:none;width:69px;height:89px;border:0px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='/image/demo_wait.gif' width="64" height="64" /><br>Loading..</div>
        </div>
        </div> -->
    <!-- </div> -->

<!-- </div>
</div> -->
<div class="was1-create">

    

    <?= $this->render($view, [
        'model' => $model,
        'modelLapdu' => $modelLapdu,
        'modelTerlapor' => $modelTerlapor,
		'disposisi_irmud' => $disposisi_irmud,
        'modelWas1' => $modelWas1,
        'loadWas1' => $loadWas1,
        'dataTerlapor' => $dataTerlapor,
        'dataPelapor' => $dataPelapor,
       
    ]) ?>

</div>


<script type="text/javascript">
$(document).ready(function(){
    $('.radiotujuan').click(function(){
        // $("#wait").css("display", "block");
        // var nilai=$(this).val();
        // var goToClass='';
        // var url_old = document.location.href;

      
        // alert(nilai);
        // if(nilai=='1'){
        //     var new_url=url_old.substring(0, url_old.indexOf('&'));
        //     var url = new_url+"&option=1";
        // }else if(nilai=='2'){
        //     var new_url=url_old.substring(0, url_old.indexOf('&'));
        //     var url = new_url+"&option=2";
        // }else if(nilai=='3'){
        //     var new_url=url_old.substring(0, url_old.indexOf('&'));
        //     var url = new_url+"&option=3";
         
        // }
        // var newText = location.replace(url);
        // var reExp = /option=\\d+/;
        
        // var newUrl = url.replace(reExp, 'sadfasf');
        // var x=url.substring(0, url.indexOf('&'));

        // alert(url);
       // document.location = url;
        // alert(goToClass);
       // $.ajax({
       //      type:'POST',
       //      url:'/pengawasan/was1/'+goToClass,
       //      data:'id='+nilai,
       //      success:function(data){
       //      // $('#tujuan').html(data);
       //      // alert(data);
       //      $("#wait").css("display", "none");
       //      }
       //      });

    });
});
</script>
   


    <?
     ?>
