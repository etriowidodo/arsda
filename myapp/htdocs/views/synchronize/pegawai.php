<?php
use kartik\form\ActiveForm;

$this->title = 'Import data pegawai';
$this->params['breadcrumbs'][] = $this->title;
?>
 <div class="hasil"></div>
<?php //$form = ActiveForm::begin(); ?>
	<button class="btn btn-primary import">Import Pegawai</button>
<?php //ActiveForm::end(); ?>
<?php

$js = <<< JS
    $('.import').click(function(e){
    	$.ajax({
                url: 'http://10.1.0.24/migrasi_cms/',
                crossDomain: true,
                cache: false,
                success:function(data){
                    alert(data);
                    var dataJson =  {
                                        'data'  :  JSON.parse(data)
                                    }

                    $.ajax({
                            type    : 'POST',
                            url     : 'recive-pegawai',
                            data    :  dataJson ,
                            success:function(data){
                            },
                            error : function(data)
                            {
                                alert('cek koneksi silahkan ulangi ! ! !');
                            }
                        });
                },
                error : function(data)
                {
                    alert('cek koneksi silahkan ulangi ! ! !');
                }
            });
    });
JS;
$this->registerJs($js);