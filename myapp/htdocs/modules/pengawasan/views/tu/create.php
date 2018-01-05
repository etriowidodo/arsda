<?php

use yii\helpers\Html;
use yii\db\Query;
use yii\db\Command;

/* @var $this yii\web\View */
/* @var $model app\models\Was1 */
 
                            
//$this->title = 'WAS1';
//$this->subtitle = 'TELAAHAN';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
 // $session = Yii::$app->session;
// $this->params['ringkasan_perkara'] = $session->get('was_register');

$this->params['breadcrumbs'][] = ['label' => 'Was1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary" style="overflow:hidden;padding:10px 0px 15px 0px;height:100%">
<div class="col-md-12">
     <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <center><h3>Sp.Was 1</h3></center>
            </div>
          <!--   <div class="icon">
              <i class="ion ion-bag"></i>
            </div> -->
            <a href="/pengawasan/sp-was-1/index" class="small-box-footer">Pilih <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <center><h3>Sp.Was 2</h3></center>
            </div>
            <!-- <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div> -->
            <a href="/pengawasan/sp-was-2/index" class="small-box-footer">Pilih <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <center><h3>Was 9</h3></center>
            </div>
            <!-- <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div> -->
            <a href="/pengawasan/was9-inspeksi-tu/index" class="small-box-footer">Pilih <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <center><h3>Was 10</h3></center>
            </div>
            <!-- <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div> -->
            <a href="/pengawasan/was10-inspeksi-tu/index" class="small-box-footer">Pilih <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <center><h3>Was 11</h3></center>
            </div>
          <!--   <div class="icon">
              <i class="ion ion-bag"></i>
            </div> -->
            <a href="/pengawasan/was11-inspeksi-tu/index" class="small-box-footer">Pilih <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <center><h3>Was 12</h3></center>
            </div>
          <!--   <div class="icon">
              <i class="ion ion-bag"></i>
            </div> -->
            <a href="/pengawasan/was12-inspeksi-tu/index" class="small-box-footer">Pilih <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
</div>
</div>
<div class="was1-create">

    <!-- , , [
        'model' => $model,
        'modelLapdu' => $modelLapdu,
        'modelTerlapor' => $modelTerlapor,
        'model_terlapor' => $model_terlapor,
        'modelWas1' => $modelWas1,
        'loadWas1' => $loadWas1,
        'modelPelapor' => $modelPelapor,
        'modelPenandatangan' => $modelPenandatangan,
       
    ][
        'model' => $model,
        'modelLapdu' => $modelLapdu,
        'modelTerlapor' => $modelTerlapor,
        'model_terlapor' => $model_terlapor,
        'modelWas1' => $modelWas1,
        'loadWas1' => $loadWas1,
        'modelPelapor' => $modelPelapor,
        'modelPenandatangan' => $modelPenandatangan,
       
    ] -->

    <?//= $this->render('_form') ?>

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


