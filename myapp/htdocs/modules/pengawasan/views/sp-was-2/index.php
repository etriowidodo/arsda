<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\SpWas2Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar SP.WAS-2';
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="sp-was2-index">

    <h1><?//= Html::encode($this->title) ?></h1>
    
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <div class="btn-toolbar">  
              <a class="btn btn-primary btn-sm pull-right" id="cetak_sp_was2"><i class="glyphicon glyphicon-print"></i> Cetak</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="hapus_sp_was2"><i class="glyphicon glyphicon-trash"></i> Hapus</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_sp_was2"><i class="glyphicon glyphicon-pencil"></i> Ubah </a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/sp-was-2/create"><i class="glyphicon glyphicon-plus"></i> SP.WAS-2</a>
        </div>
    </p>
    <style type="text/css">
        fieldset.group-border {
            border: 1px solid #ddd;
            margin: 0;
            padding: 10px;
        }
        legend.group-border {
            border-bottom: none;
            width: inherit;
            margin: 0;
            padding: 0px 5px;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
     <fieldset class="group-border">
        <legend class="group-border">Daftar SP.WAS-2</legend>
        <?php Pjax::begin(['id' => 'rekam-grid', 'timeout' => false,'formSelector' => '#searchForm','enablePushState' => false]) ?>
        <?= GridView::widget([
        
          'dataProvider' => $dataProvider,
          'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
          // 'filterModel' => $searchModel,
          // 'layout' => "{items}\n{pager}",
          'columns' => [
             ['header'=>'No',
             'headerOptions'=>['style'=>'text-align:center'],
             'contentOptions'=>['style'=>'text-align:center; width:5%'],
                   'class' => 'yii\grid\SerialColumn'],
            
            
                 ['label' => 'No. SP.WAS-2',
            'headerOptions'=>['style'=>'text-align:center'],
                'value' => function ($data) {
                         return $data['nomor_sp_was2']; 
                      },
           ],

           
           ['label' => 'Terlapor',
           'format'=>'raw',
            'headerOptions'=>['style'=>'text-align:center'],
                'value' => function ($data) {
                    $pecah=explode('#', $data['terlapor']);
                    $result='';
                    $no_terlapor=1;
                    if(count($pecah)<=1){
                        $result.=$pecah[0];
                    }else{
                      for ($i=0; $i <count($pecah) ; $i++) { 
                        $result.=$no_terlapor.'. '.$pecah[$i].'<br>';
                      $no_terlapor++;
                      }

                    }
                         return $result; 
                      },
           ],

            ['class' => 'yii\grid\CheckboxColumn',
             'headerOptions'=>['style'=>'text-align:center'],
             'contentOptions'=>['style'=>'text-align:center; width:5%'],
                       'checkboxOptions' => function ($data) {
                        return ['value' => $data['no_register'].'#'.$data['id_sp_was2'].'#'.$data['id_tingkat'].'#'.$data['id_kejati'].'#'.$data['id_kejari'].'#'.$data['id_cabjari'],'rel'=>$data['no_register'],'cek_tgl'=>$data['tanggal_sp_was2'],'class'=>'selection_one'];
                        },
                ],


        ],
            
            
         
    ]);  ?>
    <?php Pjax::end(); ?>
    
     
    
    
</fieldset>
    

</div>
<script type="text/javascript">
window.onload=function(){
    $(document).ready(function(){
        $(document).on('click','#ubah_sp_was2',function(){
            var id=$('.selection_one:checked').val();
            var pecah=id.split('#');
            // alert(pecah[0]);
            location.href='/pengawasan/sp-was-2/update?id='+pecah[0]+'&id_sp_was2='+pecah[1]; 
          });


       });

    $(document).ready(function(){
        $(document).on('click','#cetak_sp_was2',function(){
            var id=$('.selection_one:checked').val();
            var pecah=id.split('#');
            // alert(pecah[0]);
            location.href='/pengawasan/sp-was-2/cetakdocx?no_register='+pecah[0]+'&id='+pecah[1]+'&id_tingkat='+pecah[2]+'&id_kejati='+pecah[3]+'&id_kejari='+pecah[4]+'&id_cabjari='+pecah[5]; 
          });


       });
  
  $("#ubah_sp_was2").addClass("disabled");
  $("#hapus_sp_was2").addClass("disabled");
  $("#cetak_sp_was2").addClass("disabled");

$(document).on('click','#hapus_sp_was2',function() {
    var checkValues = $('.selection_one:checked').map(function()
                                {
                                    return $(this).attr('rel');
                                }).get();

    var tgl = $('.selection_one:checked').map(function()
                                {
                                    return $(this).attr('cek_tgl');
                                }).get();

    // var cek_tgl=tgl.split('#');

    var msg=(tgl==''?'Apakah anda Akan Menghapus Data ini ?':'Data Ini Sudah Ditandatangani Tidak boleh d Hapus!');
    var jml=checkValues.length;
    var id=$('.selection_one:checked').val();
    var pecah=id.split('#');
    // alert(pecah[0]);
    // exit();
    // location.href='/pengawasan/sp-was-1/hapus?id='+checkValues+'&jml='+jml; 
      bootbox.confirm(msg, function(result){ 
          if(result==true){
              //if(tgl==''){
              // alert(msg);
              $.ajax({
                      type:'POST',
                      url:'/pengawasan/sp-was-2/hapus',
                      data:'id='+pecah[0]+'&jml='+jml+'&id_sp_was2='+pecah[1],
                      success:function(data){
                          alert(data);
                      }
                      });
              //}
          }
          
         });

    // alert(checkValues.length);
});


$(document).on('change','.select-on-check-all',function() {
    var c = this.checked ? '#f00' : '#09f';
     if(c=='#f00'){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
    var x=$('.selection_one:checked').length;
    ConditionOfButton(x);
});
    
  $(document).on('change','.selection_one',function() {
      var c = this.checked ? '#f00' : '#09f';
      if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
      var x=$('.selection_one:checked').length;
      ConditionOfButton(x);
  });


function ConditionOfButton(n){
        if(n == 1){
           $('#ubah_sp_was2,#cetak_sp_was2, #hapus_sp_was2').removeClass('disabled');
        } else if(n > 1){
           $('#hapus_sp_was2').removeClass('disabled');
           $('#ubah_sp_was2,#cetak_sp_was2').addClass('disabled');
        } else{
           $('#ubah_sp_was2,#cetak_sp_was2, #hapus_sp_was2').addClass('disabled');
        }
}
}

$(document).ready(function(){ 

          $('tr').dblclick(function(){
            var id=$('.selection_one').val();
            var pecah=id.split('#');
            // alert(pecah[0]);
            location.href='/pengawasan/sp-was-2/update?id='+pecah[0]+'&id_sp_was2='+pecah[1]; 
          }); 
     });
</script>
