<?php

use yii\helpers\Html;
use yii\db\Query;
use yii\db\Command;

/* @var $this yii\web\View */
/* @var $model app\models\Was1 */
 
                            
$this->title = 'WAS1';
$this->subtitle = 'TELAAHAN';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
 // $session = Yii::$app->session;
// $this->params['ringkasan_perkara'] = $session->get('was_register');

$this->params['breadcrumbs'][] = ['label' => 'Was1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary" style="overflow:hidden;padding:10px 0px 15px 0px;height:150px">
<div class="col-md-12">
     <!-- <div class="col-md-10"> -->
        <div class="form-group">
            <!-- <label class="control-label col-md-2"></label> -->
        <div class="col-md-12">
             <fieldset class="group-border">
                <legend class="group-border">Dari Ke </legend>
                <input type="radio" name="tujuan" id="radio1" class="radiotujuan" value="1" <?php  if($view=='_form_pemeriksa'){echo "checked";} if($modelWas1[0]['id_level_was1']=='1' OR $modelWas1[0]['id_level_was1']=='2' OR $modelWas1[0]['id_level_was1']=='3'){echo "disabled";}?> > Pemeriksa -> IRMUD
                <input type="radio" name="tujuan" id="radio2" class="radiotujuan" value="2" <?php  if($view=="_form_irmud") {echo 'checked';} if($modelWas1[0]['id_level_was1']=='2' OR $modelWas1[0]['id_level_was1']=='3'){echo "disabled";}?> > IRMUD -> INSPEKTUR
                <input type="radio" name="tujuan" id="radio3" class="radiotujuan" value="3" <?php  if($view=="_form_inspektur") {echo 'checked';} if($modelWas1[0]['id_level_was1']=='3'){echo "disabled";}?>  > INSPEKTUR -> JAMWAS
             </fieldset>

        </div>
        </div>
    <!-- </div> -->
</div>
</div>
<div class="was1-create">

    

    <?= $this->render($view, [
        'model' => $model,
        'modelLapdu' => $modelLapdu,
        'modelTerlapor' => $modelTerlapor,
        'model_terlapor' => $model_terlapor,
        'modelWas1' => $modelWas1,
        'loadWas1' => $loadWas1,
        'modelPelapor' => $modelPelapor,
        'modelPenandatangan' => $modelPenandatangan,
       
    ]) ?>

</div>

<script type="text/javascript">
// $(document).ready(function(){
//     $('.radiotujuan').click(function(){
//         $("#wait").css("display", "block");
//         var nilai=$(this).val();
//         var goToClass='';
//         // alert(nilai);
//         if(nilai=='1'){
//         goToClass='pemeriksa';
//         }else if(nilai=='2'){
//          goToClass='irmud';
//         }else if(nilai=='3'){
//          goToClass='inspektur';
//         }

//         // alert(goToClass);
//        $.ajax({
//             type:'POST',
//             url:'/pengawasan/was1/'+goToClass,
//             data:'id='+nilai,
//             success:function(data){
//             // $('#tujuan').html(data);
//             // alert(data);
//             $("#wait").css("display", "none");
//             }
//             });
//     });
// });
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('.radiotujuan').click(function(){
        
        var nilai=$(this).val();
        var goToClass='';
        var url_old = document.location.href;
        
      
        // alert(nilai);
        if(nilai=='1'){
        // goToClass='pemeriksa';
            var new_url=url_old.substring(0, url_old.indexOf('?'));
            var url = new_url+"?id=1";
            // $("#wait").css("display", "block");
        }else if(nilai=='2'){
         // goToClass='irmud';
            var new_url=url_old.substring(0, url_old.indexOf('?'));
            var url = new_url+"?id=2";
        }else if(nilai=='3'){
         // goToClass='inspektur';
            var new_url=url_old.substring(0, url_old.indexOf('?'));
            var url = new_url+"?id=3";
         // var url = location.replace();
        }
        // var newText = location.replace(url);
        // var reExp = /option=\\d+/;
        
        // var newUrl = url.replace(reExp, 'sadfasf');
        // var x=url.substring(0, url.indexOf('&'));

        // alert(url);
        document.location = url;
        // alert(goToClass);
       // $.ajax({
       //      type:'POST',
       //      url:'/pengawasan/was1/'+goToClass,
       //      data:'id='+nilai,
       //      success:function(data){
       //      // $('#tujuan').html(data);
       //      // alert(data);
            // $("#wait").css("display", "none");
       //      }
       //      });

    });
    $('#cetak').click(function(){

          $(this).addClass('disabled');
          $('#simpan').addClass('disabled');
        });


});
</script>


