<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\bootstrap\Nav;
	use yii\bootstrap\NavBar;
	use yii\widgets\Breadcrumbs;
	use app\assets\AppAsset;
	use dmstr\web\AdminLteAsset;
?>
<div class="container" style="width:1300px;lign:center;background:#fff;padding-top:15px;border-radius:4px;box-shadow: 0 0 6px 0 rgba(0, 0, 0, 0.75);">
    <div class="row">
        <?php if(count($data) > 0){ foreach($data as $idx=>$res){ ?>

        <?php if($res['module'] == "PIDSUS"){ ?>
        <div class="col-md-15 col-sm-3">
            <div class="box box-danger" style="padding:10px;box-shadow:0 0 11px 0 rgba(0, 0, 0, 0.29) inset;">
                <h3 class="box-title" style="text-align:center;color:#dd4b39;font-size:40px;margin:0px 0px 10px 0px;">PIDSUS</h3>
                <img src="<?php echo Url::to('/image/pidsus-icon.jpg'); ?>" class="profile-img-card" style="border:4px solid #dd4b39;">
                <p style="text-align:center;">Pidana Khusus</p>
                <a href="pidsus/default/index" class="btn btn-block btn-danger" style="cursor:pointer;">Enter</a>
            </div>
        </div>
        <?php } ?>
    
        <?php if($res['module'] == "PIDUM"){ ?>
        <div class="col-md-15 col-sm-3">
            <div class="box box-danger" style="padding:10px;box-shadow:0 0 11px 0 rgba(0, 0, 0, 0.29) inset;border-top-color:#c85117;">
                <h3 class="box-title" style="text-align:center;color:#c85117;font-size:40px;margin:0px 0px 10px 0px;">PIDUM</h3>
                <img src="<?php echo Url::to('/image/pidum-icon.jpg'); ?>" class="profile-img-card" style="border:4px solid #c85117;">
                <p style="text-align:center;">Pidana Umum</p>
                <a href="pidum/spdp/index" class="btn btn-block btn-pdm" style="cursor:pointer;">Enter</a>
            </div>
        </div>
		<?php } ?>

        <?php if($res['module'] == "PENGAWASAN"){ ?>
        <div class="col-md-15 col-sm-3">
            <div class="box box-default" style="padding:10px;box-shadow:0 0 11px 0 rgba(0, 0, 0, 0.29) inset;border-top-color:#73a8de;">
                <h3 class="box-title" style="text-align:center;color:#73a8de;font-size:40px;margin:0px 0px 10px 0px;">WAS</h3>
                <img src="<?php echo Url::to('/image/was-icon.jpg'); ?>" class="profile-img-card" style="border:4px solid #3c8dbc;">
                <p style="text-align:center;">Pengawasan</p>
                <?php
                    if($_SESSION['inspektur']=='1' OR $_SESSION['inspektur']=='2' OR $_SESSION['inspektur']=='3' OR $_SESSION['inspektur']=='4' OR $_SESSION['inspektur']=='5'){
                        echo "<a href='pengawasan/inspektur' class='btn btn-block btn-primary' style='cursor:pointer;'>Enter</a>";    
                    }else  if($_SESSION['inspektur']=='6'){ 
                        echo "<a href='pengawasan/was1/index' class='btn btn-block btn-primary' style='cursor:pointer;'>Enter</a>";    
                    }else  if($_SESSION['inspektur']=='7'){ 
                        echo "<a href='pengawasan/irmud/index' class='btn btn-block btn-primary' style='cursor:pointer;'>Enter</a>";    
                    }else{
                        echo "<a href='pengawasan/lapdu' class='btn btn-block btn-primary' style='cursor:pointer;'>Enter</a>";
                    }
                ?>
            </div>
        </div>
		<?php } ?>

        <?php if($res['module'] == "DATUN"){ ?>
        <div class="col-md-15 col-sm-3">
            <div class="box box-danger" style="padding:10px;box-shadow:0 0 11px 0 rgba(0, 0, 0, 0.29) inset;border-top-color:#eaba03;">
                <h3 class="box-title" style="text-align:center;color:#eaba03;font-size:40px;margin:0px 0px 10px 0px;">DATUN</h3>
                <img src="<?php echo Url::to('/image/datun-icon.jpg'); ?>" class="profile-img-card" style="border:4px solid #eaba03;">
                <p style="text-align:center;">Perdata dan Tata Usaha Negara</p>
                <a href="datun/permohonan/index" class="btn btn-block btn-dtn" style="cursor:pointer;">Enter</a>
            </div>
        </div>
		<?php } ?>

        <?php if($res['module'] == "SECURITY"){ ?>
        <div class="col-md-15 col-sm-3">
            <div class="box box-default" style="padding:10px;box-shadow:0 0 11px 0 rgba(0, 0, 0, 0.29) inset;border-top-color:#00a65a;">
                <h3 class="box-title" style="text-align:center;color:#00a65a;font-size:40px;margin:0px 0px 10px 0px;">SECURITY</h3>
                <img src="<?php echo Url::to('/image/scurity-icon.jpg'); ?>" class="profile-img-card" style="border:4px solid #00a65a;">
                <p style="text-align:center;">Keamanan</p>
                <a href="wewenang" class="btn btn-block btn-success" style="cursor:pointer;">Enter</a>
            </div>
        </div>
		<?php } ?>

	<?php } } ?>
    </div>
</div>
