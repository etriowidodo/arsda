<!--<div class="modal-content modalContent" style="width: 750px;margin-left: 400px;margin-top: 30px">-->
<div class="modal-content" style="width: 780px;margin: 30px auto;">    
    <div class="modal-header">
        Data Jaksa
        
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
                     'label' => 'NIP',
                     'attribute' => 'peg_nip_baru',
                    ],
                    [
                      'label' => 'Nama',
                      'attribute' => 'peg_nama',
                    ],
                    'jabatan',
                    'pangkat',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{select}',
                        'buttons' => [
                            'select' => function ($url, $model) {
                                return Html::checkbox('pilih', false, ['value' => $model['peg_nip'].'#'.$model['peg_nama'].'#'.$model['pangkat'].'#'.$model['jabatan'].'#'.$model['peg_nip_baru']]);
                            },
                        ]
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
            <a id="pilih-jpu" class="btn btn-warning">Pilih</a>
            <!-- CMS_PIDUM001_16|JAKA|06-06-2016|tambah tombol batal-->
            <a class="btn btn-danger" data-dismiss="modal" style="color: white">Batal</a>
            <!-- END CMS_PIDUM001_16-->
             <!-- <a  data-dismiss="modal" id="kirim" data-id="78098" class="btn btn-warning">Kirim</a> -->
    </div>

    </div>
<?php
$this->registerJs(\yii\web\View::POS_BEGIN);
        $js = <<< JS
                //Menambahkan array untuk checkbox jaksa
                var nipBaruValue = [];
                var clickJaksaBaru = [];         
                $("input[name='nip_baru[]']").each(function(){
                   var a =  nipBaruValue.push($(this).val());
                });
                $("#kirim").click(function(){
                    $("#mstersangka-warganegara").val($(this).attr('data-id'));                    
                });
        $('#pilih-jpu').click(function () {            
           /*$('input:checkbox:checked').each(function (index) {  perubahan di line 70 */
            $.each(clickJaksaBaru,function (index,value) {
                var value = value
                var data = value.split('#');
                var trCount = $("#table_jpu tr").length;                
                var nipBaruValue = [];
                $("input[name='nip_baru[]']").each(function(){
                    nipBaruValue.push($(this).val());
                });
                if(jQuery.inArray(data[4], nipBaruValue) > -1) {
                    // console.log(nipBaruValue);
                    // console.log(data[4]);
                    // $('input:checkbox').prop('checked', false);
                    // alert(data[1] + ' Sudah terpilih');return false;
                }else{
                    $('#tbody_jpu').append(
                        '<tr data-id="'+data[0]+'">' +
                        '<input type="hidden" name="nip_jpu[]" value="' + data[0] + '">' +
                        
                        '<td id="tdJPU"><input type="checkbox" name="jaksa[]"" class="hapusJaksa" id="hapusJaksa" value="'+data[0]+'">'+
                        '<td align="center">'+trCount+'<input type="hidden" name="no_urut[]" style="width: 50px;" class="form-control" value="'+(trCount)+'"></td>' +
                        '<td>'+data[1]+'<br>'+data[4]+'<input type="hidden" class="form-control" name="nama_jpu[]" readonly="true" value="' + data[1] + '"><input type="hidden" class="form-control" name="nip_baru[]" readonly="true" value="' + data[4] + '"> </td>' +
                        '<td>'+data[2]+'<br>'+data[3]+'<input type="hidden" class="form-control" name="gol_jpu[]" readonly="true" value="' + data[2] + '"><input type="hidden" class="form-control" name="jabatan_jpu[]" readonly="true" value="' + data[3] + '"></td>'+
                        '</tr>'
                    );
                    $('#m_jpu').modal('hide');
                }

            });

        clickJaksaBaru.splice(0,clickJaksaBaru.length);
        });


        //<!-- END CMS_PIDUM001_13 ETRIO WIDODO -->     
     function edit()
     {
         $('.close').hide();
         $('.panel-heading').hide();
         $('.kv-panel-before').hide();

         var text = $('.panel-heading').text();
         $('#daftar').html(text);
     }

     $(document).ajaxSuccess(function(){
      $('#id_tersangka-grid-filters td input').attr('placeholder','Cari Tersangka'); 
      var div_label = '<div id=\'daftar\'></div>';
        $('.kv-panel-pager').append(div_label);
         edit();
     });
//Edit Layout Etrio Widodo
JS;

$this->registerJs($js, \yii\web\View::POS_END);
?>
</div>