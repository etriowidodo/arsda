<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAS-15 Nota Dinas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dipa-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
        <div class="box-body" style="padding:15px;">
            <div class="row">   
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">No. Perkara Perdata</label>        
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="" id="" placeholder="" readonly="true">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>        
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Asal Panggilan</label>        
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="" id="" placeholder="" readonly="true">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">        
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">No. SKK</label>        
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="" id="" name="" placeholder="" readonly="true">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>        
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Tanggal  SKK</label>        
                        <div class="col-md-4">
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="text" id="" name="" class="form-control" value="" readonly />
                            </div>                      
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">        
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">No. SKKS</label>        
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="" id="" name="" placeholder="" readonly="true">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>        
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Tanggal  SKKS</label>        
                        <div class="col-md-4">
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="text" id="" name="" class="form-control" value="" readonly />
                            </div>                      
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">        
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Penggugat</label>        
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="" id="" placeholder="" readonly="true">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>       
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Tergugat</label>        
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="" id="" placeholder="" readonly="true">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="row">        
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Diterima Wilayah Kerja</label>        
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="" id="" placeholder="" readonly="true">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>       
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Tanggal Diterima</label>        
                        <div class="col-md-4">
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="text" id="" name="" class="form-control" value="" readonly />
                            </div>                      
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>

    <div class="row">        
        <div class="col-md-6">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-4">Nomor Putusan</label>        
                <div class="col-md-8">
                    <input type="text" name="" id="" class="form-control" value="" required data-error="" maxlength=""  />
                    <div class="help-block with-errors" id="error_custom4"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-4">Dikeluarkan</label>        
                <div class="col-md-8">
                    <input type="text" class="form-control" value="" id="" placeholder="" readonly="true">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div> 
        <div class="col-md-6">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-4">Tanggal Putusan</label>        
                <div class="col-md-4">
                    <div class="input-group date">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input type="text" id="" name="" class="form-control" value="" readonly />
                    </div>                      
                </div>
            </div>
        </div>  
    </div>

    <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
        <div class="box-body" style="padding:15px;">
            <div class="row">    
                <div class="col-md-12">
                    <div class="panel with-nav-tabs panel-default">
                        <div class="panel-heading single-project-nav">
                            <ul class="nav nav-tabs"> 
                                <li class="active"><a href="#tab-amar" data-toggle="tab">AMAR PUTUSAN</a></li>  
                            </ul>
                        </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-amar">
                                        <textarea class="ckeditor" id="tab_amar" name="" ></textarea>
                                        <div class="help-block with-errors" id="error_custom2"></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;"> 
        <input type="hidden" name="tgl_pengadilan" id="tgl_pengadilan" value="<?php echo $tgl_pengadilan;?>" />
        <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
        <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
        <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php } ?>
        <a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
    </div>

</div>