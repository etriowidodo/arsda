<!--<div class="modal-content modalContent" style="width: 750px;margin-left: 400px;margin-top: 30px">-->
<?php
use kartik\widgets\ActiveForm;
$form = ActiveForm::begin([
            'id' => 'tersangka-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'showLabels' => false
            ],
            'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
        ]);
?>
<div class="modal-content" style="width: 500px;margin: 30px auto;">    
    <div class="modal-header">
        Data Kewarganegaraan
        <a class="close" data-dismiss="modal" style="color: white">&times;</a>
    </div>

    <div class="modal-body">
            <?php
            // Generate a bootstrap responsive striped table with row highlighted on hover
            use kartik\grid\GridView;
            use yii\helpers\Html;
            echo GridView::widget([
                'id'=>'jpu-grid',
                'dataProvider'=> $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                   
                     [
                       'label'      => 'Nama',
                       'attribute'  => 'nama',  
                        'contentOptions' => function ($model, $key, $index, $grid){
                            return ['data-id'=>$model['id']];
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
            ]);
            ?>
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="modal-footer">
            <a id="batal-wn" class="btn btn-warning">Batal</a>
             <!-- <a  data-dismiss="modal" id="kirim" data-id="78098" class="btn btn-warning">Kirim</a> -->
    </div>

    </div>
<?php
$this->registerJs(\yii\web\View::POS_BEGIN);
        $js = <<< JS
     //<!-- BEGIN CMS_PIDUM001_13 ETRIO WIDODO --> 

     $('#m_kewarganegaraan').on('hidden.bs.modal', function () {
            $("body").css('overflow','hidden');
            $("body").css('overflow-y','scroll');
            //$("#m_tersangka").css('max-height','100%'); 
            var Wn  = $('#pdmba4-warganegara').attr('data-id');
            if(Wn !=1)
            {
               $('#pdmba4-suku').prop('disabled',true);
               $('#pdmba4-suku').val('-');
               $('#pdmba4-id_identitas option:eq(1)').hide();
               $('#pdmba4-id_identitas option:eq(2)').hide();
               $('#pdmba4-id_identitas option:eq(3)').prop('selected','true');
               $('#pdmba4-no_identitas').val('');
               $('#pdmba4-suku').val('-');
               $('.field-pdmba4-suku').removeClass('has-error');
               $('.field-pdmba4-suku').find('.help-block').remove();
               $('.field-pdmba4-id_agama').removeClass('has-error');
               $('.field-pdmba4-id_agama').removeClass('required');
               $('.field-pdmba4-id_agama').find('.help-block').remove();
               $('#pdmba4-id_agama option:eq(0)').val(0);
            }
            else
            {
               $('#pdmba4-id_agama option:eq(0)').val('');
               $('#pdmba4-suku').val('-');
               $('#pdmba4-suku').prop('disabled',false);
               $('#pdmba4-id_identitas option:eq(1)').show();
               $('#pdmba4-id_identitas option:eq(2)').show();
               $('#pdmba4-id_identitas option:eq(0)').prop('selected','true');
               $('#pdmba4-no_identitas').val('');
            }
        });   
     $(document).ajaxSuccess(function(){
       $('td ').click(function(){
                    var td = $(this).attr('data-col-seq');
                    if(td ==1){
                       var value = $(this).text();
                       var dataId = $(this).attr('data-id');
                        $("#pdmba4-warganegara-text").val(value);
                        $("#pdmba4-warganegara").val(dataId);
                        $("#pdmba4-warganegara").parent().parent().removeClass('has-error');
                        $("#pdmba4-warganegara").parent().eq(3).find('.help-block').remove();                        
                        $("#m_kewarganegaraan").modal('hide');
                    }
                    
                });
     });  
          
     function edit()
     {
         $('.close').hide();
         $('.panel-heading').hide();
         $('.kv-panel-before').hide();

         var text = $('.panel-heading').text();
         $('#daftar').html(text);
     }
    
     $(document).ajaxSuccess(function(){
      $('#jpu-grid-container table thead th').hide();
      $('#jpu-grid-container table tbody tr td').first().css('width','30px');
      if($('#jpu-grid-filters td').length>1)
      {
      $('#jpu-grid-filters td').first().remove();
      $('#jpu-grid-filters td').first().attr('colspan',2);
      }
      
      $('#jpu-grid-filters td input').attr('placeholder','Cari Kewarganegaraan'); 
      var div_label = '<div id=\'daftar\'></div>';
        $('.kv-panel-pager').append(div_label);
         edit();
     });
    $('#batal-wn').on('click',function(){
      $('#m_kewarganegaraan').modal('hide')
    });
//<!-- END CMS_PIDUM001_13 ETRIO WIDODO -->
      
JS;

$this->registerJs($js, \yii\web\View::POS_END);
ActiveForm::end();
?>
</div>