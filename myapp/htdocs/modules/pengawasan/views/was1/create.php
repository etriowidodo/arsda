<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Was1 */
 
                            
$this->title = 'WAS - 1 (TELAAHAN)';
//$this->subtitle = 'TELAAHAN';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
 // $session = Yii::$app->session;
// $this->params['ringkasan_perkara'] = $session->get('was_register');

$this->params['breadcrumbs'][] = ['label' => 'Was-1', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$id = $_GET['id'];

$connection = \Yii::$app->db;
$query1 = "SELECT max(id_level_was1) as id_level_was1 FROM was.was1 where no_register='".$_SESSION['was_register']."'";
$disposisi_irmud = $connection->createCommand($query1)->queryOne();

?>
<div class="box box-primary" style="overflow:hidden;padding:10px 0px 15px 0px;height:150px">
<div class="col-md-12">
     
     <h3>Dari Ke <?php echo  $disposisi_irmud['id_level_was1']; ?></h3>
     <ul class="nav nav-tabs">
        <?php if($id == '1'){?>
            <li class="active" id="mn1"> <a data-toggle="tab" href="#menu1">Pemeriksa -> IRMUD</a></li>
            <li id="mn2"><a data-toggle="tab" href="#menu2">IRMUD -> INSPEKTUR</a></li>
            <li id="mn3"><a data-toggle="tab" href="#menu3">INSPEKTUR -> JAMWAS</a></li>
        <?php }else if($id == '2'){ ?>    
            <li id="mn1"><a data-toggle="tab" href="#menu1">Pemeriksa -> IRMUD </a></li>
            <li class="active" id="mn2"><a data-toggle="tab" href="#menu2">IRMUD -> INSPEKTUR</a></li>
            <li id="mn3"><a data-toggle="tab" href="#menu3">INSPEKTUR -> JAMWAS</a></li>
        <?php  }else if($id == '3'){ ?>
            <li id="mn1"><a data-toggle="tab" href="#menu1">Pemeriksa -> IRMUD </a></li>
            <li id="mn2"><a data-toggle="tab" href="#menu2">IRMUD -> INSPEKTUR</a></li>
            <li  class="active" id="mn3"><a data-toggle="tab" href="#menu3">INSPEKTUR -> JAMWAS</a></li>
        <?php }else { ?>    
            <li id="mn1"><a data-toggle="tab" href="#menu1">Pemeriksa -> IRMUD </a></li>
            <li id="mn2"><a data-toggle="tab" href="#menu2">IRMUD -> INSPEKTUR</a></li>
            <li id="mn3"><a data-toggle="tab" href="#menu3">INSPEKTUR -> JAMWAS</a></li>
        <?php } ?>
    </ul>

    <div class="tab-content">
      <div id="menu1" class="tab-pane fade ">
        <!-- <input type="text" id="nilai" value="1"> -->
      </div>
      <div id="menu2" class="tab-pane fade">
       <!--  <input type="text" id="nilai" value="2"> -->
      </div>
      <div id="menu3" class="tab-pane fade">
       <!--  <input type="text" id="nilai" value="3"> -->
      </div>
    </div>   



     <!-- <div class="col-md-10"> -->
       <!--  <div class="form-group"> -->
            <!-- <label class="control-label col-md-2"></label> -->
       <!--  <div class="col-md-12">
             <fieldset class="group-border">
                <legend class="group-border">Dari Ke </legend>
                <input type="radio" name="tujuan" id="radio1" class="radiotujuan" value="1" <?php // if($view=='_form_pemeriksa'){echo "checked";} if($modelWas1[0]['id_level_was1']=='1' OR $modelWas1[0]['id_level_was1']=='2' OR $modelWas1[0]['id_level_was1']=='3'){echo "disabled";}?> > Pemeriksa -> IRMUD
                <input type="radio" name="tujuan" id="radio2" class="radiotujuan" value="2" <?php // if($view=="_form_irmud") {echo 'checked';} if($modelWas1[0]['id_level_was1']=='2' OR $modelWas1[0]['id_level_was1']=='3'){echo "disabled";}?> > IRMUD -> INSPEKTUR
                <input type="radio" name="tujuan" id="radio3" class="radiotujuan" value="3" <?php // if($view=="_form_inspektur") {echo 'checked';} if($modelWas1[0]['id_level_was1']=='3'){echo "disabled";}?>  > INSPEKTUR -> JAMWAS
             </fieldset>

        </div>
        </div> -->
    <!-- </div> -->
</div>
</div>
<div class="was1-create">

    

    <?= $this->render($view, [
        'model' => $model,
        'modelLapdu' => $modelLapdu,
        'model_terlapor' => $model_terlapor,
        'modelWas1' => $modelWas1,
        'loadWas1' => $loadWas1,
        'modelPelapor' => $modelPelapor,
        'modelPenandatangan' => $modelPenandatangan,
		'disposisi_irmud' => $disposisi_irmud,
    ]) ?>

</div>


<script type="text/javascript">
$(document).ready(function(){
    var x = "<?php echo  $disposisi_irmud['id_level_was1']; ?>";
  // alert(x);
    if(x == ''){//kondisi awal jika belum di pilih
        /*alert('semua');*/
        $('#mn1').click(function(){ 
                location.href='/pengawasan/was1/create?id=1';
         });
        $('#mn2').click(function(){
                location.href='/pengawasan/was1/create?id=2';
         });
        $('#mn3').click(function(){
            location.href='/pengawasan/was1/create?id=3';
        });
    }else if (x == 1){//kondisi jika diinput pilihan 1
        /*alert('dua'); */   
        $('#mn2').click(function(){
                location.href='/pengawasan/was1/create?id=2';
         });
        $('#mn3').click(function(){
            location.href='/pengawasan/was1/create?id=3';
        });
    }else if (x == 2){//kondisi jika diinput pilihan 2
        
        $('#mn3').click(function(){
            location.href='/pengawasan/was1/create?id=3';
        });
    }else if (x == 3){//kondisi jika diinput pilihan 3
        bootbox.alert({
                    message:"Data Sudah Ada",
                    size:'small'
                });
       location.href='/pengawasan/was1/index';
    }
    
        

        //var nilai=$(this).val();
       /* var nilai    =document.getElementById("nilai");
        var goToClass='';
        var url_old  = document.location.href;

        alert('test');
        */
        // alert(nilai);
        //if(nilai=='1'){
        // goToClass='pemeriksa';
          /*  var new_url=url_old.substring(0, url_old.indexOf('?'));
            var url = new_url+"?id=1";*/
            // $("#wait").css("display", "block");
        //}else if(nilai=='2'){
         // goToClass='irmud';
           /* var new_url=url_old.substring(0, url_old.indexOf('?'));
            var url = new_url+"?id=2";
        }else if(nilai=='3'){*/
         // goToClass='inspektur';
           /* var new_url=url_old.substring(0, url_old.indexOf('?'));
            var url = new_url+"?id=3";*/
         // var url = location.replace();
      //  }
        // var newText = location.replace(url);
        // var reExp = /option=\\d+/;
        
        // var newUrl = url.replace(reExp, 'sadfasf');
        // var x=url.substring(0, url.indexOf('&'));

        // alert(url);
      //  document.location = url;
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

    $('#cetak').click(function(){

          $(this).addClass('disabled');
          $('#simpan').addClass('disabled');
        });


});
</script>


