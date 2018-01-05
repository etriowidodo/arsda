<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap\Modal;
use app\models\KpInstSatker;
use app\models\Wilayah;
use app\models\Inspektur;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DugaanPelanggaranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dugaan Pelanggaran';
$this->subtitle = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
  var url1 = '<?php echo Url::toRoute('dugaan-pelanggaran/register-was'); ?>';
  var url2 = '<?php echo Url::toRoute('dugaan-pelanggaran/register-was-session'); ?>';
</script>

<?php
$script = <<<JS
    function sessionWas(id)
    {
        
        $.ajax(
        {
            type: "POST",
            url: url1,
            data: "id_register="+id,
            dataType : "json",
            cache: false,
            success: function(data)
            {
             
                $("#dugaan_pemberitahuan").html(data.view_pemberitahuan);
                $("#confirm_dugaan").val(data.key);
            //    $("#m_pemberitahuan").modal("show"); 
          $('#confirm_dugaan').trigger('click');
            }
        });

    }
JS;
$this->registerJs($script, View::POS_BEGIN);
$this->registerJs("
    $(document).ready(function(){
$('#search-form form').submit(function(){
    $.fn.yiiGridView.update('table-dugaan', {
        data: $(this).serialize()
    });
    return false;
});         

 //$('td').dblclick(function (e) {
  //      var id = $(this).closest('tr').data('id');
 //       if (e.target == this && id)
 //           sessionWas(id);
  //  });
          $('#confirm_dugaan').click(function(){
         
           $.ajax(
        {
            type: 'POST',
            url: url2,
            data: 'id_register='+$('#confirm_dugaan').val(),
            dataType : 'json',
            cache: false,
            success: function(data)
            {
               
                //$('#m_pemberitahuan').modal('hide');
                window.location.href = 'http://'+window.location.host+data.link;
            }
        });

      });
}); ", \yii\web\View::POS_END);

/*
  $this->registerJs("function sessionWas(id){
  $.ajax({
  type:'POST',
  url: ". \Yii::$app->getUrlManager()->createUrl(['pengawasan/dugaanPelanggaran/registerWas']).",
  data:'id_register=id',
  dataType:'json',
  success:function(data){

  }
  });

  }", \yii\web\View::POS_HEAD);
 */
?>
<div class="dugaan-pelanggaran-create">
     <?= $this->render('_search', [
        'searchModel' => $searchModel]);
?>
    <?= Html::a('<i class="fa fa-plus"> </i> Tambah Dugaan Pelanggaran', ['create'], ['class' => 'btn btn-success'])?>
     <div class="form-group pull-right">
   
 
    
    <button id="btnHapus" class="btn btn-primary" type="button"><i class="fa fa-times"></i> Hapus</button>
   
  
 </div>
</div>


    <!--h1><?//= Html::encode($this->title) ?></h1-->
  <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <br><br>
   

   
    <div class="dugaan-pelanggaran-index">
  <?=
  GridView::widget([
      'id' => 'table-dugaan',
      'hover' => true,
      'rowOptions' => function ($model, $key, $index, $grid) {
        return ['data-id' => $model['id_register'],'ondblclick'=>"sessionWas('".$model['id_register']."')"];
      },
              'dataProvider' => $dataProvider,
            //  'filterModel' => $searchModel,
              'tableOptions' => ['class' => 'table table-striped table-dugaan-pelanggaran'], 'export' => false,
              'columns' => [
                  ['class' => 'yii\grid\SerialColumn',
                    'header' => 'No'  ],
//\yii\helpers\Html::a('Create Team',\yii\helpers\Url::to('url'),['onclick'=>"$('#createTeamForm').show(500);$('#createTeamForm').css('display','')",'style'=>'margin-left: 30px;']);
                  /*   [
                    'class' => '\kartik\grid\DataColumn',
                    'format'=>'raw',//text, html
                    'attribute' => 'id_register',
                    'value'=>function ($model, $key, $index, $widget){
                    //    return yii\helpers\Html::a($key,null,['onclick'=>"alert('test'+".$key.");".$session = Yii::$app->session.";".$session->remove('was_register').";".$session->set('was_register', $key).";"]);
                    return yii\helpers\Html::a($model['id_register'],null,['onclick'=>"sessionWas('".$model['id_register']."')"]);
                    },


                    ], */
                  'no_register',
                  ['label' => 'Satker',
                      'value' => function ($data) {
                        return $data['inst_nama'];
                      },
                  ],
                  ['label' => 'Tanggal Dugaan',
                      'value' => function ($data) {
                        return date('d-m-Y', strtotime($data['tgl_dugaan']));
                      },
                  ],
                  ['label' => 'Terlapor',
                      'value' => function ($data) {
                        return $data['terlapor'];
                      },
                  ],
                  ['label' => 'Pelapor',
                      'value' => function ($data) {
                        return $data['pelapor'];
                      },
                  ],
                  ['label' => 'Status',
                      'value' => function ($data) {
                        return $data['status'];
                      },
                  ],
                  //  ['class' => 'yii\grid\ActionColumn'],
                  /* [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}{delete}',
                    'urlCreator' => function ($action, $model, $key, $index) {

                    if ($action === 'update') {
                    $url = '/pengawasan/dugaan-pelanggaran/update?id=' . $model['id_register'];
                    return $url;
                    }
                    }
                    ], */
                  [
                      'class' => 'kartik\grid\CheckboxColumn',
                      'headerOptions' => ['class' => 'kartik-sheet-style'],
                      'checkboxOptions' => function ($model, $key, $index, $action) {
                        return ['value' => $model['id_register']];
                      }
                  ],
              ],
                           'export' => false,
            'pjax' => true,
            'responsive'=>true,
            'hover'=>true,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-book"></i>',
            ],

            'pjaxSettings'=>[
                'options'=>[
                    'enablePushState'=>false,
                     'id'=>'dugaangrid-index',
                    
                ],
              
                'neverTimeout'=>true,
              //  'beforeGrid'=>['columns'=>'peg_nip'],
            ]
          ]);
          ?>

        </div>

        <?php
        Modal::begin([
            'id' => 'm_pemberitahuan',
            'header' => 'Apakah Dugaan Pelanggaran Akan di Proses',
//'closeButton' =>false,
            'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Batal</a><button id="confirm_dugaan" class="btn btn-primary"  value="" type="button">OK</button>',
            'options' => [
            ],
        ]);
        ?> 

        <div id='dugaan_pemberitahuan'></div>

        <?php
        Modal::end();
        ?>

<?php
$js = <<< JS

  $('#btnHapus').click(function(){
  var count = $('input[name="selection[]"]:checked').length
  if(count==0){
  bootbox.dialog({
              message: "Pilih Data Yang Akan Dihapus",
              title: "Peringatan",
              buttons: {
                  success: {
                      label: "Tutup",
                      className: "btn-warning",
                      callback: function () {
                      }
                  }
              }
          });
  }else{
   bootbox.dialog({
          title: "Peringatan",
          message: "Apakah anda ingin menghapus data ini?",
          buttons:{
              ya : {
                  label: "Ya",
                  className: "btn-warning",
                  callback: function(){
                    var value = [];
                    $('input[name="selection[]"]:checked').each(function(i,e) {
                            value.push(e.value);
                    });
                    $.ajax({
                    type:'POST',
                    url:'/pengawasan/dugaan-pelanggaran/delete',
                    data:'data='+value,
                    success:function(data){
                    }
                    });
                  }
              },
              tidak : {
                  label: "Tidak",
                  className: "btn-warning",
                  callback: function(result){
                      console.log(result);
                  }
              },
          },
      });
  }
  });
JS;
$this->registerJs($js);
?>