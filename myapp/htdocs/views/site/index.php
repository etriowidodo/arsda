<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\bootstrap\Nav;
	use yii\bootstrap\NavBar;
	use yii\widgets\Breadcrumbs;
	use app\assets\AppAsset;
	use dmstr\web\AdminLteAsset;
	use mdm\admin\models\searchs\Menu as MenuSearch;
?>
<div class="row" style="width:1300px; box-shadow: 0 0 6px 0 rgba(0, 0, 0, 0.75); margin:0 auto;">
    <div id="centeredmenu-nav">
    	<ul>
        <?php 
			if(count($data) > 0){ 
				foreach($data as $idx=>$res){ 
					$sqlMn = "select distinct d.route, d.path 
					from mdm_user_role a 
					join mdm_role b on a.id_role = b.id_role 
					join mdm_role_menu c on b.id_role = c.id_role
					join v_menu d on c.id_menu = d.id 
					where a.id_user = '".Yii::$app->user->identity->id."' and d.route is not null and d.route != '' 
						and d.module = '".$res['module']."' and d.tipe_menu = 'MASTER' 
					order by d.path";
		?>

			<?php if($res['module'] == "PIDSUS"){ ?>
    		<li><div class="wrap-linav">
                <div class="box box-danger">
                    <h3 class="box-title text-center" style="color:#EC407A;">PIDSUS</h3>
                    <img src="<?php echo Url::to('/image/pidsus-icon.png'); ?>" class="profile-img-card" style="border:4px solid #EC407A;">
                    <p class="text-center">Pidana Khusus</p>
                    <?php $resOpt = MenuSearch::findBySql($sqlMn)->asArray()->one();?>
                    <a href="/pidsus/spdp/index" class="btn btn-block btn-pidsus" style="cursor:pointer;">Enter</a>
                </div>
            </div></li>
    
			<?php } else if($res['module'] == "PIDUM"){ ?>
    		<li><div class="wrap-linav">
                <div class="box box-danger" style="border-top-color:#c85117;">
                    <h3 class="box-title text-center" style="color:#c85117;">PIDUM</h3>
                    <img src="<?php echo Url::to('/image/pidum-icon.jpg'); ?>" class="profile-img-card" style="border:4px solid #c85117;">
                    <p class="text-center">Pidana Umum</p>
                    <?php $resOpt = MenuSearch::findBySql($sqlMn)->asArray()->one();?>
                    <a href="<?php echo $resOpt['route'];?>" class="btn btn-block btn-pdm" style="cursor:pointer;">Enter</a>
                </div>
            </div></li>

			<?php } else if($res['module'] == "PENGAWASAN"){ ?>
    		<li><div class="wrap-linav">
                <div class="box box-default" style="border-top-color:#73a8de;">
                    <h3 class="box-title text-center" style="color:#73a8de;">WAS</h3>
                    <img src="<?php echo Url::to('/image/was-icon.jpg'); ?>" class="profile-img-card" style="border:4px solid #3c8dbc;">
                    <p class="text-center">Pengawasan</p>
                    <?php $resOpt = MenuSearch::findBySql($sqlMn)->asArray()->one();?>
                    <a href="<?php echo $resOpt['route'];?>" class="btn btn-block btn-primary" style="cursor:pointer;">Enter</a>
                    <?php
                        /*if($_SESSION['inspektur']=='1' OR $_SESSION['inspektur']=='2' OR $_SESSION['inspektur']=='3' OR $_SESSION['inspektur']=='4' OR $_SESSION['inspektur']=='5'){
                            echo "<a href='pengawasan/inspektur' class='btn btn-block btn-primary' style='cursor:pointer;'>Enter</a>";    
                        }else  if($_SESSION['inspektur']=='6'){ 
                            echo "<a href='pengawasan/was1/index' class='btn btn-block btn-primary' style='cursor:pointer;'>Enter</a>";    
                        }else  if($_SESSION['inspektur']=='7'){ 
                            echo "<a href='pengawasan/irmud/index' class='btn btn-block btn-primary' style='cursor:pointer;'>Enter</a>";    
                        }else{
                            echo "<a href='pengawasan/lapdu' class='btn btn-block btn-primary' style='cursor:pointer;'>Enter</a>";
                        }*/
                    ?>
                </div>
            </div></li>

			<?php } else if($res['module'] == "DATUN"){ ?>
    		<li><div class="wrap-linav">
                <div class="box box-danger" style="border-top-color:#eaba03;">
                    <h3 class="box-title text-center" style="color:#eaba03;">DATUN</h3>
                    <img src="<?php echo Url::to('/image/datun-icon.jpg'); ?>" class="profile-img-card" style="border:4px solid #eaba03;">
                    <p class="text-center">Perdata dan Tata Usaha Negara</p>
                    <?php $resOpt = MenuSearch::findBySql($sqlMn)->asArray()->one();?>
                    <a href="/datun/permohonan/index" class="btn btn-block btn-dtn" style="cursor:pointer;">Enter</a>
                </div>
            </div></li>

			<?php } else if($res['module'] == "SECURITY"){ ?>
    		<li><div class="wrap-linav">
                <div class="box box-default" style="border-top-color:#00a65a;">
                    <h3 class="box-title text-center" style="color:#00a65a;">SECURITY</h3>
                    <img src="<?php echo Url::to('/image/scurity-icon.jpg'); ?>" class="profile-img-card" style="border:4px solid #00a65a;">
                    <p class="text-center">Keamanan</p>
                    <?php $resOpt = MenuSearch::findBySql($sqlMn)->asArray()->one();?>
                    <a href="<?php echo $resOpt['route'];?>" class="btn btn-block btn-success" style="cursor:pointer;">Enter</a>
                </div>
            </div></li>
            <?php } ?>

		<?php } } ?>

		<?php if(!Yii::$app->user->identity->peg_nip){ ?>
        <li><div class="wrap-linav">
            <div class="box box-default" style="border-top-color:#00a65a;">
                <h3 class="box-title text-center" style="color:#00a65a;">SECURITY</h3>
                <img src="<?php echo Url::to('/image/scurity-icon.jpg'); ?>" class="profile-img-card" style="border:4px solid #00a65a;">
                <p class="text-center">Keamanan</p>
                <a href="/wewenang/menu/index" class="btn btn-block btn-success" style="cursor:pointer;">Enter</a>
            </div>
        </div></li>
		<?php } ?>

       </ul>
    </div>
</div>


<style>
#centeredmenu-nav {
	background-color: #fff;
    border-radius: 4px;
    float: left;
    overflow: hidden;
    padding: 15px 10px;
    position: relative;
    width: 100%;
}
#centeredmenu-nav ul {
   clear:left;
   float:left;
   list-style:none;
   margin:0;
   padding:0;
   position:relative;
   left:50%;
   text-align:center;
}
#centeredmenu-nav ul li {
   display:block;
   float:left;
   list-style:none;
   margin:0;
   padding:0;
   position:relative;
   right:50%;
}
#centeredmenu-nav .wrap-linav{
	width:240px;
	margin:0 8px;
}
#centeredmenu-nav .wrap-linav > .box{
	padding:10px;
	box-shadow:0 0 11px 0 rgba(0, 0, 0, 0.29) inset;
	margin:0px;
}
#centeredmenu-nav .wrap-linav .box-title{
	font-size:40px;
	margin:0px 0px 10px 0px;
}
</style>
