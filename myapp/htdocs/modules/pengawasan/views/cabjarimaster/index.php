<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cabjari Master';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabjari-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <div class="btn-toolbar">
              <a class="btn btn-primary btn-sm pull-right" id="hapus_inspektur"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_inspektur"><i class="glyphicon glyphicon-pencil"> Ubah </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="create" href="/pengawasan/cabjarimaster/create"><i class="glyphicon glyphicon-plus"> Cabjari</i></a>
            </div>
    </p>
<?php $form = ActiveForm::begin(
        ['action' => '/pengawasan/cabjarimaster/delete', 'id' => 'forum_post', 'method' => 'post',]
    ); ?>
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
                            return ['data-id' => $model['id_cabjari']];
                        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','headerOptions'=>['style'=>'width: 4%;']],
            // 'id_cabjari',
            'nama_cabjari',
            'nama_kejari',
            'nama_kejati',
            'akronim',
            'inst_lokinst',
            'inst_alamat',
            // 'is_aktif',

            //['class' => 'yii\grid\ActionColumn'],
            [
                    'class' => 'yii\grid\CheckboxColumn',
             'headerOptions'=>['style'=>'width: 4%;'],
                       'checkboxOptions' => function ($data) {
                        return ['value' => $data['id_cabjari'],'class'=>'checkbox-row'];
            
                        },


                ],
        ],
    ]); ?>

</div>
<?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
$('.table-bordered tr').hover(function() {
      $(this).addClass('hover');
    }, function() {
      $(this).removeClass('hover');
    });

$('.table-bordered tr').on('click', function() {
    $(this).toggleClass('click-row');
    var z=$(this).attr('class');
      if(z=='hover'){
       $(this).find('.checkbox-row').prop('checked',false);
        $("#ubah_inspektur").addClass("disabled");
        $("#hapus_inspektur").addClass("disabled");
      }else{
        $(this).find('.checkbox-row').prop('checked',true);
        $("#ubah_inspektur").removeClass("disabled");
        $("#hapus_inspektur").removeClass("disabled");
      }
});

$("#ubah_inspektur").addClass("disabled");
    $("#hapus_inspektur").addClass("disabled");

$('tr').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/cabjarimaster/update?id="+id;
        $(location).attr('href',url);
        
    });

$('#ubah_inspektur').click (function (e) {
        var count =$('.checkbox-row:checked').length;
        if (count != 1 )
        {
         bootbox.dialog({
                message: "<center>Silahkan pilih hanya 1 data untuk diubah</center>",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-primary",

                    }
                }
            });
        } else {
        var id = $('.checkbox-row:checked').val();
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/cabjarimaster/update?id="+id;
        $(location).attr('href',url);
        }
    });

$('#hapus_inspektur').click(function(){
    $('form').submit();

});

});

</script>