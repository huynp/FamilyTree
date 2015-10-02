<?php defined('_JEXEC') or die('Restricted access');

if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
$config = VmConfig::loadConfig();
$app = JFactory::getApplication();
$document = JFactory::getDocument();
$tempURL = $this->baseurl.'/templates/'.$template;

$document->addScript($tempURL.'/js/jquery.jqzoom-core-pack.js'); 


$templateparams = $app->getTemplate(true)->params;

if ($templateparams->get('useZoom')) {

// ** jQuery Zoom

if ($templateparams->get('zoom_preloadImages')) : $zoom_var_preloadImages = "true"; else : $zoom_var_preloadImages = "false"; endif;
if ($templateparams->get('zoom_lens')) : $zoom_var_lens = "true"; else : $zoom_var_lens = "false"; endif;
if ($templateparams->get('zoom_alwaysOn')) : $zoom_var_alwaysOn = "true"; else : $zoom_var_alwaysOn = "false"; endif;

	$zoomJS = "
	jQuery(document).ready(function(){  
		var options = {  
				zoomType: '".$templateparams->get('zoom_Type')."',  
				zoomWidth: ".$templateparams->get('zoom_Width').",  
				zoomHeight: ".$templateparams->get('zoom_Height').", 
				xOffset:".$templateparams->get('zoom_xOffset').",  
				yOffset:".$templateparams->get('zoom_yOffset').",
				position:'".$templateparams->get('zoom_position')."',
				preloadImages: ".$zoom_var_preloadImages.",
				preloadText: '".$templateparams->get('zoom_preloadText')."',
				lens:".$zoom_var_lens.", 
				showEffect: '".$templateparams->get('zoom_showEffect')."',
				hideEffect: '".$templateparams->get('zoom_hideEffect')."',
				fadeinSpeed: '".$templateparams->get('zoom_fadeinSpeed')."',
				fadeoutSpeed: '".$templateparams->get('zoom_fadeoutSpeed')."',
				alwaysOn: ".$zoom_var_alwaysOn.",  
				title: false
		};  
		jQuery('.zoomImage').jqzoom(options);  
	});
	";
	$document->addScriptDeclaration ($zoomJS);
	
	if ($templateparams->get('zoom_ShowOnMobiles') == false) {
		$document->addCustomTag('<style type="text/css"> 
		@media screen and (max-width: 767px) {
			.zoomWindow, .zoomPup { display: none !important; }
		}
		</style>
		');
	}
	

	if (!empty($this->product->images)) {
		$image = $this->product->images[0];
		?>
	<div class="main-image" style="position:relative; height:616px;">
		<div id="img_Background" style="position:absolute; left:38px; top:53px;"></div>
		<div id="mainimage" style="position:relative; left:38px; top:43px;"> 
			<?php 
                echo $image->displayMediaFull("id=PDP_Image",true,"class='zoomImage' rel='gal1'");
            ?>
        </div>
		<div id="img_Leaves" style="width:403px; height:513px; position:relative; left:38px; top:43px;"></div>
		<div id="img_BottomLeft" style="left:38px; top:53px;"></div>
		<div id="img_BottomRight" style="left:38px; top:53px;"></div>
		<div id="img_Bottom" style="left:38px; top:53px;"></div> 
        <div id="img_Frame"></div>
	</div>
	<?php
		$count_images = count ($this->product->images);
		if ($count_images > 1) {
			?>
		<div class="additional-images">
			<?php
			for ($i = 0; $i < $count_images; $i++) {
				$image = $this->product->images[$i];
				?>
				<div class="floatleft">
					<?php
						$path_products_IMG = VmConfig::get('media_product_path');
						$zoomimg = $this->baseurl.'/'.$path_products_IMG.$image->file_name.'.'.$image->file_extension;
					?>
					<a class="<?php if($i==0) { ?>zoomThumbActive<?php } ?>" href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo $zoomimg; ?>',largeimage: '<?php echo $zoomimg; ?>'}">  
						<img src="<?php echo $zoomimg; ?>">  
					</a>  
				</div>
				<?php
			}
			?>
			<div class="clear"></div>
		</div>
		<?php
		}
	}


} else {

// ** Default VirtueMart Images

	vmJsApi::js( 'fancybox/jquery.fancybox-1.3.4.pack');
	vmJsApi::css('jquery.fancybox-1.3.4');

	$imageJS = '
	jQuery(document).ready(function() {
		jQuery("a[rel=vm-additional-images]").fancybox({
			"titlePosition" 	: "inside",
			"transitionIn"	:	"elastic",
			"transitionOut"	:	"elastic"
		});
		jQuery(".additional-images .product-image").click(function() {
			jQuery(".main-image img").attr("src",this.src );
			jQuery(".main-image img").attr("alt",this.alt );
			jQuery(".main-image a").attr("href",this.src );
			jQuery(".main-image a").attr("title",this.alt );
		}); 
	});
	';
	$document->addScriptDeclaration ($imageJS);

	if (!empty($this->product->images)) {
		$image = $this->product->images[0];
		?>
	<div class="main-image" style="position:relative; height:616px;">
		<div id="img_Background"></div>
		<div id="mainimage"> 
			<?php 
                echo $image->displayMediaFull("id=PDP_Image",true,"class='zoomImage' rel='gal1'");
            ?>
        </div>
		<div id="img_Leaves"></div>
		<div id="img_BottomLeft"></div>
		<div id="img_BottomRight"></div>
		<div id="img_Bottom"></div> 
        <div id="img_Frame"></div>
	</div>
	<?php
		$count_images = count ($this->product->images);
		if ($count_images > 1) {
			?>
		<div class="additional-images">
			<?php
			for ($i = 0; $i < $count_images; $i++) {
				$image = $this->product->images[$i];
				?>
				<div class="floatleft">
					<?php
						echo $image->displayMediaFull('class="product-image" style="cursor: pointer"',false,"");
					?>
				</div>
				<?php
			}
			?>
			<div class="clear"></div>
		</div>
		<?php
		}
	}

} ?>
 
 