<?php

use yii\helpers\Html;
use yii\grid\GridView;
// use kartik\grid\GridView;
// use kartik\grid\DataColumn;
// use yii\helpers\Url;
// use yii\web\View;


/* @var $this yii\web\View */
/* @var $searchModel app\models\LapduSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Lapdu';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php// print_r($_SESSION); ?>
<div class="lapdu-index">

    <h4><?php ?></h4>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
   
    <p>
        <?//= Html::a('Create Lapdu', ['create'], ['class' => 'btn btn-success']) ?>
         <div class="btn-toolbar">
              <!-- <a class="btn btn-primary btn-sm pull-right" id="hapus_lapdu"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp; -->
              <!-- <a class="btn btn-primary btn-sm pull-right" id="ubah_irmud"><i class="glyphicon glyphicon-pencil"> Ubah </i></a>&nbsp; -->
              <a class="btn btn-primary btn-sm pull-right" id="create_spwas2"><i class="glyphicon glyphicon-plus"> Tambah</i></a>
            </div>
    </p>
    <div>
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
            
            
                 ['label' => 'No. Register',
            'headerOptions'=>['style'=>'text-align:center'],
                'value' => function ($data) {
                         return $data['no_register']; 
                      },
           ], 

            ['class' => 'yii\grid\CheckboxColumn',
             'headerOptions'=>['style'=>'text-align:center'],
             'contentOptions'=>['style'=>'text-align:center; width:5%'],
                       'checkboxOptions' => function ($data) {
                        $result = json_encode($data);

                        return ['value' => $data['no_register'].'#'.$data['id_sp_was2'].'#'.$data['id_tingkat'].'#'.$data['id_kejati'].'#'.$data['id_kejari'].'#'.$data['id_cabjari'],'rel'=>$data['no_register'],'cek_tgl'=>$data['tanggal_sp_was2'],'json'=>$result,'class'=>'selection_one'];
                        },
                ],


        ],
            
            
         
    ]);  ?>

    </div>
</div>   
    <style type="text/css">
fieldset.group-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}
legend.group-border {
    width:inherit; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
    font-size: 14px;
}
</style>
</div>
<style type="text/css">
    tr.hover {
  background-color: #FFFFCC;
}

tr.click-row {
  background-color: #81bcf8;
}
.grid-view th{
  white-space:unset;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td
{
  vertical-align:top;
  
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td
{
  
  text-align:center;
}
.dataTables_filter,.dataTables_length {
   display: none;
}
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $("#create_spwas2").click(function(){
            var id=$('.selection_one:checked').attr('rel');
            //var data= JSON.parse($(".MselectionSI_one:checked").attr('json'));
            var data=JSON.parse($('.selection_one:checked').attr('json'));
            //alert(data.id_wilayah);
            location.href='/pengawasan/tu/index1?id='+id+'&wil='+data.id_wilayah+'&lv1='+data.id_level1+'&lv2='+data.id_level2+'&lv3='+data.id_level3+'&lv4='+data.id_level4; 
        });
    });

    $(document).on('change', '.select-on-check-all', function () {
            var c = this.checked ? '#f00' : '#09f';
             if(c=='#f00'){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
        
        $(document).on('change', '.selection_one', function () {
            var c = this.checked ? '#f00' : '#09f';
             if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });

    $(document).ready(function(){ 

          $('tr').dblclick(function(){
            var id=$('.selection_one').attr('rel');
            //var data= JSON.parse($(".MselectionSI_one:checked").attr('json'));
            var data=JSON.parse($('.selection_one').attr('json'));
            //alert(data.id_wilayah);
            location.href='/pengawasan/tu/index1?id='+id+'&wil='+data.id_wilayah+'&lv1='+data.id_level1+'&lv2='+data.id_level2+'&lv3='+data.id_level3+'&lv4='+data.id_level4; 
        
          }); 
     });

</script>>


