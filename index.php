<?php defined( '_JEXEC' ) or die( 'Restricted access' ); define( 'YOURBASEPATH', dirname(__FILE__) ); ?>
<?php 
JHTML::_('behavior.mootools'); 

$doc = JFactory::getDocument();
$doc->setMetaData( 'cleartype', 'on', true );
/*
if (!JFactory::getApplication()->get('jquery')) { // Check if jQuery has been loaded by other 3rd party
	JFactory::getApplication()->set('jquery', true);
		$doc->addCustomTag('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>'); 
}
*/
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
if (!JFactory::getApplication()->get('jquery')) { JFactory::getApplication()->set('jquery', true); 
echo '<script src="'.$this->baseurl.'/templates/'.$this->template.'/js/jquery-1.8.1.min.js"></script><script src="'.$this->baseurl.'/templates/'.$this->template.'/js/jquery.noConflict.js"></script>'; } ?>
	<jdoc:include type="head" />
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/selectivizr-min.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/modernizr.js"></script>
<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie9-10.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/bootstrap.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/responsive.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/text.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/layout.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/nav.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/typography.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/responsive-template.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/vm-echo.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/sm/sm-core-css.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/sm/sm-simple.css" media="screen" />
	<script type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/js/bootstrap.min.js"> </script>
<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Ubuntu:300,400,700,300italic,400italic,700italic:latin' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); 
</script>
<script>
	function get_browser(){
		var ua=navigator.userAgent,tem,M=ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || []; 
		if(/trident/i.test(M[1])){
			tem=/\brv[ :]+(\d+)/g.exec(ua) || []; 
			return 'IE '+(tem[1]||'');
			}   
		if(M[1]==='Chrome'){
			tem=ua.match(/\bOPR\/(\d+)/)
			if(tem!=null)   {return 'Opera '+tem[1];}
			}   
		M=M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
		if((tem=ua.match(/version\/(\d+)/i))!=null) {M.splice(1,1,tem[1]);}
		return M[0];
    }

	
	function get_browser_version(){
		var ua=navigator.userAgent,tem,M=ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];                                                                                                                         
		if(/trident/i.test(M[1])){
			tem=/\brv[ :]+(\d+)/g.exec(ua) || [];
			return 'IE '+(tem[1]||'');
			}
		if(M[1]==='Chrome'){
			tem=ua.match(/\bOPR\/(\d+)/)
			if(tem!=null)   {return 'Opera '+tem[1];}
			}   
		M=M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
		if((tem=ua.match(/version\/(\d+)/i))!=null) {M.splice(1,1,tem[1]);}
		return M[1];
	}
	var browser_version=get_browser_version();
	var browser=get_browser();
	if(browser == "MSIE") {
		alert('In order to properly view our site you will need to upgrade your version of Microsoft Internet Explorer to version 11');
	}
		
</script>

<script
	<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/selectnav.min.js"></script>
	<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.smartmenus.min.js"></script>
<!--[if IE 6]> <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie6.css" media="screen" /> <![endif]-->
<!--[if IE 7]> <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie.css" media="screen" /> <![endif]-->
    <?php if($this->params->get('usetheme')==true) : ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/presets/<?php echo $this->params->get('choosetheme'); ?>.css" media="screen" />
    <?php endif; ?>
	<?php if($this->params->get("usedropdown")) : ?> 
	<script type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/js/superfish.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/js/supersubs.js"></script>
	<script type="text/javascript">
    jQuery(document).ready(function(){ 
        jQuery("ul.menu-nav").supersubs({ 
			minWidth: <?php echo $this->params->get("dropdownhandler1"); ?>,
            extraWidth:  1
        }).superfish({ 
            delay:500,
            animation:{opacity:'<?php if($this->params->get("dropopacity")) : ?>show<?php else: ?>hide<?php endif; ?>',height:'<?php if($this->params->get("dropheight")) : ?>show<?php else: ?>hide<?php endif; ?>',width:'<?php if($this->params->get("dropwidth")): ?>show<?php else: ?>hide<?php endif; ?>'},
            speed:'<?php echo $this->params->get("dropspeed"); ?>',
            autoArrows:true,
            dropShadows:false 
        });
    }); 
	</script>
	<?php endif; ?>
	<?php if( $this->countModules('position-1')) : ?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#menupanel').on('click', function() {
			jQuery('div.panel1').animate({
				'width': 'show'
			}, 300, function() {
				jQuery('div.menupanel').fadeIn(200);
			});
		});
		jQuery('span.closemenu').on('click', function() {
			jQuery('div.menupanel').fadeOut(200, function() {
				jQuery('div.panel1').animate({
					'width': 'hide'
				}, 300);
			});
		});
		            var newHtml = '';
            jQuery('#selectnav1 li').each(function () {

                if (jQuery(this).index() == 1 || jQuery(this).index() == 7 || jQuery(this).index() == 24) {
                    newHtml += "<li>";
                    newHtml += jQuery(this).clone().children('a').attr('href', '#').wrap('<p>').parent().html();
                    newHtml += "<ul>";
                    newHtml += "<li>" + jQuery(this).html() + "</li>";
                }
                else if (jQuery(this).index() == 6 || jQuery(this).index() == 23 || jQuery(this).index() == 26) {
                    newHtml += jQuery(this).clone().wrap('<p>').parent().html();
                    newHtml += "</li></ul>";
                }
                else {
                    newHtml += jQuery(this).clone().wrap('<p>').parent().html();
                }

            });
            jQuery('#selectnav1').html(newHtml);
            jQuery('#selectnav1').addClass("sm sm-vertical sm-simple").smartmenus();
	});
	</script>
	<style>
		body div.panel1 .menupanel
		{
			padding: 0;
		}
	</style>
	<?php endif; ?>
	<?php echo $this->params->get("headcode"); ?>
	<?php if( $this->countModules('currency')) : ?>
	<script type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/js/jquery.dropkick-1.0.0.js"></script>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.default-currency').dropkick();
	});
	</script>
	<?php endif; ?>
		
	<?php if( $this->countModules('builtin-slideshow')) : ?>
	<!-- Built-in Slideshow -->
	<?php if($this->params->get("cam_turnOn")) : ?>
		<link rel="stylesheet" id="camera-css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/camera.css" type="text/css" media="all" /> 
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.mobile.customized.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.easing.1.3.js"></script> 
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/camera.min.js"></script> 
		<script>
			jQuery(function(){		
				jQuery('#ph-camera-slideshow').camera({
					alignment: 'topCenter',
					autoAdvance: <?php if ($this->params->get("cam_autoAdvance")) : ?>true<?php else: ?>false<?php endif; ?>,
					mobileAutoAdvance: <?php if ($this->params->get("cam_mobileAutoAdvance")) : ?>true<?php else: ?>false<?php endif; ?>, 
					slideOn: '<?php if($this->params->get("cam_slideOn")) : echo $this->params->get("cam_slideOn"); else : ?>random<?php endif; ?>',	
					thumbnails: <?php if ($this->params->get("cam_thumbnails")) : ?>true<?php else: ?>false<?php endif; ?>,
					time: <?php if($this->params->get("cam_time")) : echo $this->params->get("cam_time"); else : ?>7000<?php endif; ?>,
					transPeriod: <?php if($this->params->get("cam_transPeriod")) : echo $this->params->get("cam_transPeriod"); else : ?>1500<?php endif; ?>,
					cols: <?php if($this->params->get("cam_cols")) : echo $this->params->get("cam_cols"); else : ?>10<?php endif; ?>,
					rows: <?php if($this->params->get("cam_rows")) : echo $this->params->get("cam_rows"); else : ?>10<?php endif; ?>,
					slicedCols: <?php if($this->params->get("cam_slicedCols")) : echo $this->params->get("cam_slicedCols"); else : ?>10<?php endif; ?>,	
					slicedRows: <?php if($this->params->get("cam_slicedRows")) : echo $this->params->get("cam_slicedRows"); else : ?>10<?php endif; ?>,
					fx: '<?php if($this->params->get("cam_fx_multiple_on")) : echo $this->params->get("cam_fx_multi"); else : echo $this->params->get("cam_fx"); endif; ?>',
					gridDifference: <?php if($this->params->get("cam_gridDifference")) : echo $this->params->get("cam_gridDifference"); else : ?>250<?php endif; ?>,
					height: '<?php if($this->params->get("cam_height")) : echo $this->params->get("cam_height"); else : ?>50%<?php endif; ?>',
					minHeight: '<?php echo $this->params->get("cam_minHeight"); ?>',
					imagePath: '<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/',	
					hover: <?php if ($this->params->get("cam_hover")) : ?>true<?php else: ?>false<?php endif; ?>,
					loader: '<?php if($this->params->get("cam_loader")) : echo $this->params->get("cam_loader"); else : ?>pie<?php endif; ?>',
					barDirection: '<?php if($this->params->get("cam_barDirection")) : echo $this->params->get("cam_barDirection"); else : ?>leftToRight<?php endif; ?>',
					barPosition: '<?php if($this->params->get("cam_barPosition")) : echo $this->params->get("cam_barPosition"); else : ?>bottom<?php endif; ?>',	
					pieDiameter: <?php if($this->params->get("cam_pieDiameter")) : echo $this->params->get("cam_pieDiameter"); else : ?>38<?php endif; ?>,
					piePosition: '<?php if($this->params->get("cam_piePosition")) : echo $this->params->get("cam_piePosition"); else : ?>rightTop<?php endif; ?>',
					loaderColor: '<?php if($this->params->get("cam_loaderColor")) : echo $this->params->get("cam_loaderColor"); else : ?>#eeeeee<?php endif; ?>', 
					loaderBgColor: '<?php if($this->params->get("cam_loaderBgColor")) : echo $this->params->get("cam_loaderBgColor"); else : ?>#222222<?php endif; ?>', 
					loaderOpacity: <?php if($this->params->get("cam_loaderOpacity")) : echo $this->params->get("cam_loaderOpacity"); else : ?>8<?php endif; ?>,
					loaderPadding: <?php if($this->params->get("cam_loaderPadding")) : echo $this->params->get("cam_loaderPadding"); else : ?>2<?php endif; ?>,
					loaderStroke: <?php if($this->params->get("cam_loaderStroke")) : echo $this->params->get("cam_loaderStroke"); else : ?>7<?php endif; ?>,
					navigation: <?php if ($this->params->get("cam_navigation")) : ?>true<?php else: ?>false<?php endif; ?>,
					playPause: <?php if ($this->params->get("cam_playPause")) : ?>true<?php else: ?>false<?php endif; ?>,
					navigationHover: <?php if ($this->params->get("cam_navigationHover")) : ?>true<?php else: ?>false<?php endif; ?>,
					mobileNavHover: <?php if ($this->params->get("cam_mobileNavHover")) : ?>true<?php else: ?>false<?php endif; ?>,
					opacityOnGrid: <?php if ($this->params->get("cam_opacityOnGrid")) : ?>true<?php else: ?>false<?php endif; ?>,
					pagination: <?php if ($this->params->get("cam_pagination")) : ?>true<?php else: ?>false<?php endif; ?>,
					pauseOnClick: <?php if ($this->params->get("cam_pauseOnClick")) : ?>true<?php else: ?>false<?php endif; ?>,
					portrait: <?php if ($this->params->get("cam_portrait")) : ?>true<?php else: ?>false<?php endif; ?>
				});
			});
		</script>
	<?php endif; ?>
	<!-- End of Built-in Slideshow -->
	<?php endif; ?>
	
    <style type="text/css">
	body {font-size: <?php echo $this->params->get('contentfontsize'); ?>;}
	#site-name-handler{height:<?php echo $this->params->get('topheight'); ?>px; }
	#sn-position h1{left:<?php echo $this->params->get('H1TitlePositionX'); ?>px;top:<?php echo $this->params->get('H1TitlePositionY'); ?>px;color:<?php echo $this->params->get('sitenamecolor'); ?>;font-size:<?php echo $this->params->get('sitenamefontsize'); ?>;}
	#sn-position h1 a {color:<?php echo $this->params->get('sitenamecolor'); ?>;}
	#sn-position h2 {left:<?php echo $this->params->get('H2TitlePositionX'); ?>px;top:<?php echo $this->params->get('H2TitlePositionY'); ?>px;color:<?php echo $this->params->get('slogancolor'); ?>;font-size:<?php echo $this->params->get('sloganfontsize'); ?>;}
	ul.columns-2 {width: <?php echo $this->params->get('dropdownhandler2'); ?>px !important;}
	ul.columns-3 {width: <?php echo $this->params->get('dropdownhandler3'); ?>px !important;}
	ul.columns-4 {width: <?php echo $this->params->get('dropdownhandler4'); ?>px !important;}
	ul.columns-5 {width: <?php echo $this->params->get('dropdownhandler5'); ?>px !important;}
	<?php if( $this->countModules('builtin-slideshow')) : 
	if($this->params->get("cam_turnOn")) : ?>
	.camera_caption { top: <?php echo $this->params->get("cam_caption_y_position"); ?>; }
	.camera_caption div.container div { width: <?php echo $this->params->get("cam_caption_width"); ?>; }
	.camera_pie {
		width: <?php if($this->params->get("cam_pieDiameter")) : echo $this->params->get("cam_pieDiameter"); else : ?>38<?php endif; ?>px;
		height: <?php if($this->params->get("cam_pieDiameter")) : echo $this->params->get("cam_pieDiameter"); else : ?>38<?php endif; ?>px;
	}
	#slideshow-handler { min-height: <?php echo $this->params->get("cam_minHeight"); ?>; }
	<?php endif; endif; ?>
	
<?php							
function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(",", $rgb);
}
?>
<?php if($this->params->get('usetheme')==false) : ?> 
body{background-color:<?php echo $this->params->get("bodybackground"); ?>;color:<?php echo $this->params->get("bodytextcolor"); ?>;}
a,a:hover, .moduletable_menu ul.menu li ul li a:hover, .PricesalesPrice {color:<?php echo $this->params->get("linkscolor"); ?>;}
.custom-color1{color:<?php echo $this->params->get("customcolor1"); ?>;}
.custom-color2{color:<?php echo $this->params->get("customcolor2"); ?>;}
.custom-color3{color:<?php echo $this->params->get("customcolor3"); ?>;}
header#top-handler{background:<?php echo $this->params->get("headerbg"); ?>;}
section#tab-modules{background:<?php echo $this->params->get("top1modsbg"); ?>;}
section#bottom-long{background:<?php echo $this->params->get("bottomlongbg"); ?>;}
#search-position .search .inputbox{color:<?php echo $this->params->get("searchPositionInputbox"); ?>;}
#search-position .search{border: 1px solid <?php echo $this->params->get("searchPositionBorder"); ?>;}
#search-position .search .button, #search-position .search .advanced-search-button:hover {background-color:<?php echo $this->params->get("searchPositionButtonBg"); ?> !important;color: <?php echo $this->params->get("searchPositionButtonLabel"); ?> !important;}
#search-position .search .advanced-search-button{background-color: <?php echo $this->params->get("searchPositionAButtonBg"); ?>;color: <?php echo $this->params->get("searchPositionAButtonLabel"); ?>;}
#search-position .search .button:hover{color: <?php echo $this->params->get("searchPositionButtonHLabel"); ?> !important;background-color: <?php echo $this->params->get("searchPositionButtonHBg"); ?> !important;}
.pr-add, .pr-add-bottom,.featured-view .spacer h3, .latest-view .spacer h3, .topten-view .spacer h3, .recent-view .spacer h3, .related-products-view .spacer h3, .browse-view .product .spacer h2,.featured-view .spacer .product_s_desc, .latest-view .spacer .product_s_desc, .topten-view .spacer .product_s_desc, .recent-view .spacer .product_s_desc, .related-products-view .spacer .product_s_desc, .browse-view .product .spacer .product_s_desc {color: <?php echo $this->params->get("productsDescriptionColor"); ?>;}
.pr-add a, .pr-add-bottom a,.featured-view .spacer h3 a, .latest-view .spacer h3 a, .topten-view .spacer h3 a, .recent-view .spacer h3 a, .related-products-view .spacer h3 a, .browse-view .product .spacer h2 a, .h-pr-title a{color: <?php echo $this->params->get("productsDescriptionLinkColor"); ?>;}
.category-view .row-fluid .category .spacer h2 a .cat-title {background: rgba(<?php echo hex2rgb($this->params->get("categorytitleBG")); ?>,0.7);color: <?php echo $this->params->get("categorytitleLabel"); ?>;}
.category-view .row-fluid:hover .category:hover .spacer h2 a .cat-title {background: rgba(<?php echo hex2rgb($this->params->get("categorytitleBG")); ?>,0.89);}
.button, button, a.button, dt.tabs.closed:hover, dt.tabs.closed:hover h3 a, .closemenu, .vmproduct.productdetails .spacer:hover .pr-add, .vmproduct.productdetails .spacer:hover .pr-add-bottom, a.product-details:hover, input.addtocart-button, a.ask-a-question, .highlight-button, .vm-button-correct,span.quantity-controls input.quantity-plus, span.quantity-controls input.quantity-minus, .cartpanel span.closecart, .vm-pagination ul li a, #LoginForm .btn-group > .dropdown-menu, #LoginForm .btn-group > .dropdown-menu a, .popout-price, .popout-price .PricesalesPrice {color: <?php echo $this->params->get("buttonLabel"); ?> !important;background-color: <?php echo $this->params->get("buttonbg"); ?> !important;}
.button:hover, button:hover, a.button:hover, .closemenu:hover, a.product-details, input.addtocart-button:hover, a.ask-a-question:hover, .highlight-button:hover, .vm-button-correct:hover, span.quantity-controls input.quantity-plus:hover, span.quantity-controls input.quantity-minus:hover, .cartpanel span.closecart:hover, .vm-pagination ul li a:hover{color: <?php echo $this->params->get("buttonHLabel"); ?> !important;background-color: <?php echo $this->params->get("buttonHbg"); ?> !important;}
#LoginForm .btn-group > .dropdown-menu a:hover{background: <?php echo $this->params->get("buttonHbg"); ?> !important;}
#LoginForm .caret {border-top-color: <?php echo $this->params->get("buttonLabel"); ?> !important;}
.cart-button, a#menupanel {background-color: <?php echo $this->params->get("topcartbuttonbg"); ?>;border: 1px solid <?php echo $this->params->get("topcartbuttonBorder"); ?> !important;}
.cart-button:hover, a#menupanel:hover{background-color: <?php echo $this->params->get("topcartbuttonHbg"); ?> !important;border: 1px solid <?php echo $this->params->get("topcartbuttonHBorder"); ?> !important;}
.cart-button .popover-content{color:<?php echo $this->params->get("cartButtonPopoverContent"); ?>;}
.cart-button .popover{background:<?php echo $this->params->get("cartButtonPopoverBg"); ?>;border:1px solid <?php echo $this->params->get("cartButtonPopoverBorder"); ?>;}
.cart-button .popover.bottom .arrow{border-bottom-color:<?php echo $this->params->get("cartButtonPopoverBg"); ?>;}
.cart-button .popover.bottom .arrow:after{border-bottom-color:<?php echo $this->params->get("cartButtonPopoverBorder"); ?>;}
#slideshow-handler, .moduletable, .moduletable_menu, div.spacer, li.spacer, div.panel2, .category_description, .productdetails-view, fieldset.phrases, fieldset.word, fieldset.only, .search .form-limit, .cart-view, .item-page,.categories-list,.blog,.blog-featured,.category-list,.archive{background:<?php echo $this->params->get("defaultModulesBG"); ?>;border:1px solid <?php echo $this->params->get("defaultModulesBorder"); ?>;color: <?php echo $this->params->get("defaultModulesText"); ?>;}
dt.tabs.open, .category-view .spacer, .latest-view .spacer, .topten-view .spacer, .recent-view .spacer, .featured-view .spacer, .browse-view .spacer {background-color: <?php echo $this->params->get("defaultModulesBG"); ?>;}
.moduletable a, div.panel2 a, .category_description a, .productdetails-view a{color: <?php echo $this->params->get("defaultModulesLinks"); ?>;}
#social-links li a{background-color: <?php echo $this->params->get("sociallinks"); ?>;}
#social-links li a:hover{background-color: <?php echo $this->params->get("socialHlinks"); ?> !important;}
#top-nav-handler a, .dk_label, .dk_toggle, .dk_toggle:hover{color: <?php echo $this->params->get("topsmallmenulinks"); ?>;}
.camera_wrap .camera_pag .camera_pag_ul li {background: <?php echo $this->params->get("defaultModulesBG"); ?>;}
.camera_prev, .camera_next {background-color: rgba(<?php echo hex2rgb($this->params->get("defaultModulesBG")); ?>,0.39) !important;}
.camera_prev > span,.camera_next > span,.camera_commands > .camera_play,.camera_commands > .camera_stop,.camera_prevThumbs div,.camera_nextThumbs div {background-color: <?php echo $this->params->get("defaultModulesBG"); ?> !important;}
.camera_wrap .camera_pag .camera_pag_ul li.cameracurrent > span, .camera_wrap .camera_pag .camera_pag_ul li:hover > span,.product-sl-handler ol li:hover, .product-sl-handler ol li.current{background-color: <?php echo $this->params->get("defaultModulesLinks"); ?>;}
.camera_thumbs_cont ul li > img {border: 1px solid <?php echo $this->params->get("defaultModulesBG"); ?> !important;}
.camera_caption{color: <?php echo $this->params->get("defaultSlideshowCaption"); ?>;}
#menu .menu-nav li a, #menu .menu-nav ul a, #menu .menu-nav ul ul a, ul.menu-nav li a small, .panel1, .panel1 a {color: <?php echo $this->params->get("topmenulinks"); ?>;}
#menu .menu-nav a:hover, .menu-nav li.sfHover > a, .menu-nav li a:hover, .menu-nav li.active > a, .menupanel ul.selectnav li a:hover, .dk_options a:hover, .dk_option_current a, a#menupanel:hover {background-color: <?php echo $this->params->get("topmenuHlinksBG"); ?>;color: <?php echo $this->params->get("topmenuHlinksColor"); ?> !important;}
#menu .menu-nav > li > a .sf-sub-indicator{border-top-color: <?php echo $this->params->get("topmenulinksarrow"); ?> !important;}
.dk_options a,.cartpanel a{color: <?php echo $this->params->get("cartpanellinks"); ?>;}
#menu .menu-nav > li > a:hover .sf-sub-indicator, #menu .menu-nav > li.sfHover > a .sf-sub-indicator{border-top-color: <?php echo $this->params->get("topmenulinkHsarrow"); ?> !important;}
#menu .menu-nav ul li a:hover .sf-sub-indicator,#menu .menu-nav ul li.sfHover > a .sf-sub-indicator{border-left-color: <?php echo $this->params->get("topmenulinkHsarrow"); ?>!important;}
#menu .menu-nav ul li a .sf-sub-indicator{border-left-color: <?php echo $this->params->get("topmenulinksarrow"); ?> !important;}
#menu .menu-nav li ul, #menu .menu-nav li ul li ul, #nav ol, #nav ul, #nav ol ol, #nav ul ul,.dk_options, .panel1 {background-color: <?php echo $this->params->get("topmenudropdownbg"); ?> !important;border:1px solid <?php echo $this->params->get("topmenudropdownborder"); ?>;}
.rm-line{background-color:<?php echo $this->params->get("headerbg"); ?>;}
@media (max-width: 767px) { 
	#quick-menu li a:hover, #log-panel li a:hover	{color: <?php echo $this->params->get("RestopmenuHlinksColor"); ?> !important;background-color: <?php echo $this->params->get("RestopmenuHlinksBG"); ?>;}
}
thead th, table th, tbody th, tbody td {border-top: 1px solid <?php echo $this->params->get("defaultBorders"); ?>;}
tbody th, tbody td, h2 .contact-name, .search-results dt.result-title{	border-bottom: 1px solid <?php echo $this->params->get("defaultBorders"); ?>;}
.h-pr-title {border-top: 2px solid <?php echo $this->params->get("defaultBorders"); ?>;}
ul.vmmanufacturer {border-top: 1px solid <?php echo $this->params->get("manufacturerborder"); ?>;}
ul.vmmanufacturer li{border-right: 1px solid <?php echo $this->params->get("manufacturerborder"); ?>;}
.product-price{color: <?php echo $this->params->get("defaultproductprice"); ?>;}
.moduletable_menu ul.menu li, .VMmenu li, #bot-modules{border-bottom: 2px solid <?php echo $this->params->get("defaultBorders2"); ?>;}
.moduletable_menu ul.menu li a, .latestnews_menu li a, .VMmenu li div a{color: <?php echo $this->params->get("mainmenulinks"); ?>;}
.moduletable_menu ul.menu li a:hover, ul.latestnews_menu li a:hover, .VMmenu li div a:hover{background-color:<?php echo $this->params->get("mainmenuHlinksBG"); ?>;color:<?php echo $this->params->get("mainmenuHlinksColor"); ?>;}
.VMmenu ul li div a:hover{color: <?php echo $this->params->get("mainmenuHlinksBG"); ?> !important;}
.moduletable_style1{background-color: <?php echo $this->params->get("moduletablestyle1BG"); ?>;border: 1px solid <?php echo $this->params->get("moduletablestyle1Border"); ?>;color: <?php echo $this->params->get("moduletablestyle1Color"); ?>;}
.moduletable_style1 a{color: <?php echo $this->params->get("moduletablestyle1Link"); ?> !important;}
.moduletable_style1:hover{background-color: <?php echo $this->params->get("moduletablestyle1HBG"); ?>;border: 1px solid <?php echo $this->params->get("moduletablestyle1HBorder"); ?>;color: <?php echo $this->params->get("moduletablestyle1HColor"); ?>;}
.moduletable_style1:hover a {color: <?php echo $this->params->get("moduletablestyle1HLink"); ?> !important;}
#bottom-bg{background-color: <?php echo $this->params->get("bottomareabg"); ?>;color: <?php echo $this->params->get("bottomareatext"); ?>;}
#bot-modules a {color: <?php echo $this->params->get("bottomarealink"); ?>;}
#bot-modules-2 a{color: <?php echo $this->params->get("bottomarea2link"); ?>;}
#footer{background-color: <?php echo $this->params->get("footerareaBG"); ?>;color: <?php echo $this->params->get("footerareatext"); ?>;}
#footer a{color: <?php echo $this->params->get("footerarealink"); ?>;}
#footer a:hover{color: <?php echo $this->params->get("footerareaHlink"); ?>;}
<?php endif; ?>
</style>


<?php if( $this->countModules('top-1 or top-2 or top-3 or top-4 or top-5 or top-6')) : 
	if( $this->countModules('top-1') ) $a[0] = 0;
	if( $this->countModules('top-2') ) $a[1] = 1;
	if( $this->countModules('top-3') ) $a[2] = 2;
	if( $this->countModules('top-4') ) $a[3] = 3;
	if( $this->countModules('top-5') ) $a[4] = 4;
	if( $this->countModules('top-6') ) $a[5] = 5; 
	$topmodules1 = count($a); 
	if ($topmodules1 == 1) $tm1class = "span12";
	if ($topmodules1 == 2) $tm1class = "span6";
	if ($topmodules1 == 3) $tm1class = "span4";
	if ($topmodules1 == 4) $tm1class = "span3";
	if ($topmodules1 == 5) { $tm1class = "span2"; $tm1class5w = "17.9%"; };
	if ($topmodules1 == 6) $tm1class = "span2";
	endif; 
	
	if( $this->countModules('top-7 or top-8 or top-9 or top-10 or top-11 or top-12')) : 
	if( $this->countModules('top-7') ) $b[0] = 0;
	if( $this->countModules('top-8') ) $b[1] = 1;
	if( $this->countModules('top-9') ) $b[2] = 2;
	if( $this->countModules('top-10') ) $b[3] = 3;
	if( $this->countModules('top-11') ) $b[4] = 4;
	if( $this->countModules('top-12') ) $b[5] = 5; 
	$topmodules2 = count($b); 
	if ($topmodules2 == 1) $tm2class = "span12";
	if ($topmodules2 == 2) $tm2class = "span6";
	if ($topmodules2 == 3) $tm2class = "span4";
	if ($topmodules2 == 4) $tm2class = "span3";
	if ($topmodules2 == 5) { $tm2class = "span2"; $tm2class5w = "17.9%"; };
	if ($topmodules2 == 6) $tm2class = "span2";
	endif; 
	
	if( $this->countModules('bottom-1 or bottom-2 or bottom-3 or bottom-4 or bottom-5 or bottom-6')) :
	if( $this->countModules('bottom-1') ) $c[0] = 0; 
	if( $this->countModules('bottom-2') ) $c[1] = 1; 
	if( $this->countModules('bottom-3') ) $c[2] = 2; 
	if( $this->countModules('bottom-4') ) $c[3] = 3; 
	if( $this->countModules('bottom-5') ) $c[4] = 4; 
	if( $this->countModules('bottom-6') ) $c[5] = 5; 
	$botmodules = count($c); 
	if ($botmodules == 1) $bmclass = "span12";
	if ($botmodules == 2) $bmclass = "span6";
	if ($botmodules == 3) $bmclass = "span4";
	if ($botmodules == 4) $bmclass = "span3";
	if ($botmodules == 5) { $bmclass = "span2"; $bmclass5w = "17.7%"; };
	if ($botmodules == 6) $bmclass = "span2";
	endif; 
	
	if( $this->countModules('bottom-7 or bottom-8 or bottom-9 or bottom-10 or bottom-11 or bottom-12')) :
	if( $this->countModules('bottom-7') ) $cb[0] = 0; 
	if( $this->countModules('bottom-8') ) $cb[1] = 1; 
	if( $this->countModules('bottom-9') ) $cb[2] = 2; 
	if( $this->countModules('bottom-10') ) $cb[3] = 3; 
	if( $this->countModules('bottom-11') ) $cb[4] = 4; 
	if( $this->countModules('bottom-12') ) $cb[5] = 5; 
	$botmodules2 = count($cb); 
	if ($botmodules2 == 1) $bm2class = "span12";
	if ($botmodules2 == 2) $bm2class = "span6";
	if ($botmodules2 == 3) $bm2class = "span4";
	if ($botmodules2 == 4) $bm2class = "span3";
	if ($botmodules2 == 5) { $bm2class = "span2"; $bm2class5w = "17.7%"; };
	if ($botmodules2 == 6) $bm2class = "span2";
	endif; 
	
	if( $this->countModules('top-a or top-b or top-c or top-d')) :
	if( $this->countModules('top-a') ) $d[0] = 0; 
	if( $this->countModules('top-b') ) $d[1] = 1; 
	if( $this->countModules('top-c') ) $d[2] = 2; 
	if( $this->countModules('top-d') ) $d[3] = 3; 
	$topamodules = count($d); 
	if ($topamodules == 1) $tpaclass = "span12";
	if ($topamodules == 2) $tpaclass = "span6";
	if ($topamodules == 3) $tpaclass = "span4";
	if ($topamodules == 4) $tpaclass = "span3";
	endif; 
	
	if( $this->countModules('bottom-a or bottom-b or bottom-c or bottom-d')) :
	if( $this->countModules('bottom-a') ) $e[0] = 0; 
	if( $this->countModules('bottom-b') ) $e[1] = 1; 
	if( $this->countModules('bottom-c') ) $e[2] = 2; 
	if( $this->countModules('bottom-d') ) $e[3] = 3; 
	$bottomamodules = count($e); 
	if ($bottomamodules == 1) $bmaclass = "span12";
	if ($bottomamodules == 2) $bmaclass = "span6";
	if ($bottomamodules == 3) $bmaclass = "span4";
	if ($bottomamodules == 4) $bmaclass = "span3";
	endif; 
	
	if( $this->countModules('top-right-1 or top-right-2 or position-6 or bottom-right-1 or bottom-right-2') && $this->countModules('top-left-1 or top-left-2 or position-7 or bottom-left-1 or bottom-left-2')  ) : $mcols = 'span6'; 
	elseif( $this->countModules('top-right-1 or top-right-2 or position-6 or bottom-right-1 or bottom-right-2') && !$this->countModules('top-left-1 or top-left-2 or position-7 or bottom-left-1 or bottom-left-2')  ) : $mcols = 'span9'; 
	elseif( !$this->countModules('top-right-1 or top-right-2 or position-6 or bottom-right-1 or bottom-right-2') && $this->countModules('top-left-1 or top-left-2 or position-7 or bottom-left-1 or bottom-left-2')  ) : $mcols = 'span9'; else : $mcols = 'span12'; endif; ?>
</head>
<body>

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KWGHF3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KWGHF3');</script>
<!-- End Google Tag Manager -->

<header id="top-handler">
	<div class="container">
		<?php if(JFactory::getApplication()->getMessageQueue()) : ?>
		<div class="navbar-fixed-top" id="top-com-handler">
			<div class="alert alert-block alert-error fade in">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<jdoc:include type="message" />
			</div>
		</div>
		<?php endif; ?>

		<div id="top" class="span12">
			<div class="row-fluid">
					<div id="site-name-handler" class="span5">
						<div id="sn-position">
						<?php if($this->params->get('logoLinked')) : ?>
						<?php if($this->params->get('H1TitleImgText') == true) : ?>
						<h1> <a href="<?php echo $this->baseurl; ?>"><img alt="<?php echo strip_tags($this->params->get("H1Title")); ?>" src="<?php echo $this->params->get("H1Titleimage"); ?>" /></a></h1>
						<?php else : ?>
						<h1> <a href="<?php echo $this->baseurl; ?>"> <?php echo $this->params->get("H1Title"); ?> </a> </h1>
						<?php endif; ?>
						<?php else : ?>
						<?php if($this->params->get('H1TitleImgText') == true) : ?>
						<h1> <img alt="<?php echo strip_tags($this->params->get("H1Title")); ?>" src="<?php echo $this->params->get("H1Titleimage"); ?>" /></a></h1>
						<?php else : ?>
						<h1> <?php echo $this->params->get("H1Title"); ?> </h1>
						<?php endif; ?>
						<?php endif; ?>
						<?php if($this->params->get('H2TitleImgText') == true) : ?>
						<h2> <img alt="<?php echo strip_tags($this->params->get("H2Title")); ?>" src="<?php echo $this->params->get("H2Titleimage"); ?>" /> </h2>
						<?php else : ?>
						<h2> <?php echo $this->params->get("H2Title"); ?> </h2>
						<?php endif; ?>
						</div>
					</div>
					<div id="top-nav-handler" class="span7">


						<?php if($this->params->get('twitterON') || $this->params->get('linkedinON') || $this->params->get('RSSON') || $this->params->get('facebookON') || $this->params->get('bloggerON')  || $this->params->get('myspaceON') || $this->params->get('vimeoON') || $this->params->get('stumbleuponON')  || $this->params->get('diggON') ) : ?>
						<div class="clear-sep"></div>
						<nav id="social">
							<ul id="social-links">
								<?php if($this->params->get('twitterON') == true ) : ?><li><a href="<?php echo $this->params->get('twitter'); ?>" title="Twitter" id="twitter" target="_blank"><span>Follow Us</span></a></li><?php endif; ?>
								<?php if($this->params->get('gplusON') == true ) : ?><li><a href="<?php echo $this->params->get('gplus'); ?>" title="Google Plus" id="gplus" target="_blank"><span>Google Plus</span></a></li><?php endif; ?>
								<?php if($this->params->get('facebookON') == true ) : ?><li><a href="<?php echo $this->params->get('facebook'); ?>" title="Facebook" id="facebook" target="_blank"><span>Facebook</span></a></li><?php endif; ?>
								<?php if($this->params->get('RSSON') == true ) : ?><li><a href="<?php echo $this->params->get('RSS'); ?>" title="RSS" id="rss" target="_blank"><span>RSS</span></a></li><?php endif; ?>
								<?php if($this->params->get('linkedinON') == true ) : ?><li><a href="<?php echo $this->params->get('linkedin'); ?>" title="Linkedin" id="linkedin" target="_blank"><span>Linkedin</span></a></li><?php endif; ?>
								<?php if($this->params->get('myspaceON') == true ) : ?><li><a href="<?php echo $this->params->get('myspace'); ?>" title="myspace" id="myspace" target="_blank"><span>myspace</span></a></li><?php endif; ?>
								<?php if($this->params->get('vimeoON') == true ) : ?><li><a href="<?php echo $this->params->get('vimeo'); ?>" title="vimeo" id="vimeo" target="_blank"><span>vimeo</span></a></li><?php endif; ?>
								<?php if($this->params->get('stumbleuponON') == true ) : ?><li><a href="<?php echo $this->params->get('stumbleupon'); ?>" title="stumbleupon" id="stumbleupon" target="_blank"><span>stumbleupon</span></a></li><?php endif; ?>
								<?php if($this->params->get('diggON') == true ) : ?><li><a href="<?php echo $this->params->get('digg'); ?>" title="digg" id="digg" target="_blank"><span>digg</span></a></li><?php endif; ?>
								<?php if($this->params->get('bloggerON') == true ) : ?><li><a href="<?php echo $this->params->get('blogger'); ?>" title="Blogger" id="blogger" target="_blank"><span>Blogger</span></a></li><?php endif; ?>
							</ul>
						</nav>
						<?php endif; ?>
						<div id="top-quick-nav">
							<?php if( $this->countModules('quick-menu')) : ?>
							<div id="quick-menu"><jdoc:include type="modules" name="quick-menu" /></div>
							<?php endif; ?>
							<?php if( $this->countModules('loginform')) : ?>
							<ul id="log-panel">
								<?php jimport( 'joomla.application.module.helper' ); $module_login = JModuleHelper::getModules('loginform'); ?>
								<li><a data-toggle="modal" href="#LoginForm" class="open-register-form"><?php echo $module_login[0]->title; ?></a></li>
								<?php if(!JFactory::getUser()->id) : $usersConfig = JComponentHelper::getParams('com_users'); if ($usersConfig->get('allowUserRegistration')) : ?>
								<li><a id="v_register" href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>"> <?php echo JText::_('Register'); ?> </a></li>
								<?php endif; endif; ?>
							</ul>
							<?php endif; ?>
						</div>
						<?php if( $this->countModules('loginform')) : ?>
						<div id="LoginForm" class="b-modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-header"><span id="myModalLabel"><?php echo $module_login[0]->title; ?></span></div>
							<div class="modal-body"><jdoc:include type="modules" name="loginform" /></div>
							<div class="modal-footer"><a class="button" data-dismiss="modal">Close</a></div>
						</div>
						<?php endif; ?>

					</div>
					

			</div>
		</div>
		<div class="clear"> </div>
		<?php if( $this->countModules('position-1 or position-0 or cart')) : ?>
		<nav id="menu">
			<div id="menu-handler">
				<div class="row-fluid">
					<?php if( $this->countModules('position-0 or cart')) : ?><div class="<?php if( $this->countModules('position-0 or cart')) : ?>span8<?php else : ?>span12<?php endif; ?>"><jdoc:include type="modules" name="position-1" /></div><?php endif; ?>
					<?php if( $this->countModules('position-0 or cart')) : ?>
						<div id="search-position" class="span4">
							<jdoc:include type="modules" name="cart" />
							<jdoc:include type="modules" name="position-0" />
						</div>
					<?php endif; ?>
				</div>
			</div>
		</nav>
		<?php endif; ?>
	</div>
</header>
<?php if( $this->countModules('top-1 or top-2 or top-3 or top-4 or top-5 or top-6')) : ?>
<section id="tab-modules">
	<div class="container">
		<div id="tab-modules-handler" class="row-fluid">
			<?php if( $this->countModules('top-1')) : ?><div class="<?php echo $tm1class; ?>" style="<?php if ($topmodules1 == 5) {echo "width:".$tm1class5w;} ?>"><jdoc:include type="modules" name="top-1" style="vmdefault" /></div><?php endif; ?>
			<?php if( $this->countModules('top-2')) : ?><div class="<?php echo $tm1class; ?>" style="<?php if ($topmodules1 == 5) {echo "width:".$tm1class5w;} ?>"><jdoc:include type="modules" name="top-2" style="vmdefault" /></div><?php endif; ?>
			<?php if( $this->countModules('top-3')) : ?><div class="<?php echo $tm1class; ?>" style="<?php if ($topmodules1 == 5) {echo "width:".$tm1class5w;} ?>"><jdoc:include type="modules" name="top-3" style="vmdefault" /></div><?php endif; ?>
			<?php if( $this->countModules('top-4')) : ?><div class="<?php echo $tm1class; ?>" style="<?php if ($topmodules1 == 5) {echo "width:".$tm1class5w;} ?>"><jdoc:include type="modules" name="top-4" style="vmdefault" /></div><?php endif; ?>
			<?php if( $this->countModules('top-5')) : ?><div class="<?php echo $tm1class; ?>" style="<?php if ($topmodules1 == 5) {echo "width:".$tm1class5w;} ?>"><jdoc:include type="modules" name="top-5" style="vmdefault" /></div><?php endif; ?>
			<?php if( $this->countModules('top-6')) : ?><div class="<?php echo $tm1class; ?>" style="<?php if ($topmodules1 == 5) {echo "width:".$tm1class5w;} ?>"><jdoc:include type="modules" name="top-6" style="vmdefault" /></div><?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>


<div class="container main-bg" id="main-handler">



		<?php if( $this->countModules('position-2 or currency')) : ?>
			<div id="nav-line">
				<div class="row-fluid">
					<div class="span8"><div id="brcr"><jdoc:include type="modules" name="position-2" /></div></div>
					<div class="span4">

						<?php if( $this->countModules('currency')) : ?>
						<div id="currency"><jdoc:include type="modules" name="currency" /></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="row-fluid" id="slideshow-header">
		
		
		<?php if( $this->countModules('header-left') ) : ?>
			<div class="span3"><jdoc:include type="modules" name="header-left" style="vmdefault" /></div>
		<?php endif; ?>
		
			<?php if( $this->countModules('builtin-slideshow or slideshow') ) : ?>
			<div id="slideshow-handler-bg" class="<?php if( $this->countModules('header-left and header-right') ) : ?>span6<?php elseif( $this->countModules('header-left or header-right') ): ?>span9<?php else: ?>span12<?php endif; ?>">
				<div id="slideshow-handler"> 
					<?php if( $this->countModules('builtin-slideshow') ) : ?>
					<?php
					$count_slides = JDocumentHTML::countModules('builtin-slideshow');
					$module = JModuleHelper::getModules('builtin-slideshow');
					$moduleParams = new JRegistry();
					echo "<div class=\"camera_wrap\" id=\"ph-camera-slideshow\">"; 
					for($sld_a=0;$sld_a<$count_slides;$sld_a++) { 
						$moduleParams->loadString($module[$sld_a]->params);
						$bgimage[$sld_a] = $moduleParams->get('backgroundimage', 'defaultValue'); 
						$caption_effect[$sld_a] = $moduleParams->get('moduleclass_sfx', 'defaultValue'); 
					?>
					<div data-thumb="<?php if($bgimage[$sld_a] == "defaultValue") : echo $this->baseurl."/templates/".$this->template."/images/slideshow/no-image.png"; else : echo $this->baseurl."/".$bgimage[$sld_a]; endif; ?>" data-src="<?php if($bgimage[$sld_a] == "defaultValue") : echo $this->baseurl."/templates/".$this->template."/images/slideshow/no-image.png"; else : echo $this->baseurl."/".$bgimage[$sld_a]; endif; ?>">
						<div class="camera_caption <?php if(($caption_effect[$sld_a] == "defaultValue")) : ?>fadeFromLeft<?php else: echo $caption_effect[$sld_a]; endif; ?>" style="<?php if(empty($module[$sld_a]->content)) : ?>display:none !important;visibility: hidden !important; opacity: 0 !important;<?php endif; ?>">
							<div><?php echo $module[$sld_a]->content; ?></div>
						</div>
					</div>
					<?php } echo "</div>"; // End of camera_wrap ?> 
					<?php elseif( $this->countModules('slideshow') ) : ?>
					<div class="sl-3rd-parties">
						<jdoc:include type="modules" name="slideshow" />
					</div>
					<?php endif; ?>
				</div>
			</div>
			<?php endif; ?>
			
		<?php if( $this->countModules('header-right') ) : ?>
			<div class="span3"><jdoc:include type="modules" name="header-right" style="vmdefault" /></div>
		<?php endif; ?>
			
		
		</div>

		<div id="content-handler">
					

						
						
			<?php if( $this->countModules('top-7 or top-8 or top-9 or top-10 or top-11 or top-12')) : ?>
			<div id="top-modules">
				<div class="row-fluid">
					<?php if( $this->countModules('top-7')) : ?><div class="<?php echo $tm2class; ?>" style="<?php if ($topmodules2 == 5) {echo "width:".$tm2class5w;} ?>"><jdoc:include type="modules" name="top-7" style="vmdefault" /></div><?php endif; ?>
					<?php if( $this->countModules('top-8')) : ?><div class="<?php echo $tm2class; ?>" style="<?php if ($topmodules2 == 5) {echo "width:".$tm2class5w;} ?>"><jdoc:include type="modules" name="top-8" style="vmdefault" /></div><?php endif; ?>
					<?php if( $this->countModules('top-9')) : ?><div class="<?php echo $tm2class; ?>" style="<?php if ($topmodules2 == 5) {echo "width:".$tm2class5w;} ?>"><jdoc:include type="modules" name="top-9" style="vmdefault" /></div><?php endif; ?>
					<?php if( $this->countModules('top-10')) : ?><div class="<?php echo $tm2class; ?>" style="<?php if ($topmodules2 == 5) {echo "width:".$tm2class5w;} ?>"><jdoc:include type="modules" name="top-10" style="vmdefault" /></div><?php endif; ?>
					<?php if( $this->countModules('top-11')) : ?><div class="<?php echo $tm2class; ?>" style="<?php if ($topmodules2 == 5) {echo "width:".$tm2class5w;} ?>"><jdoc:include type="modules" name="top-11" style="vmdefault" /></div><?php endif; ?>
					<?php if( $this->countModules('top-12')) : ?><div class="<?php echo $tm2class; ?>" style="<?php if ($topmodules2 == 5) {echo "width:".$tm2class5w;} ?>"><jdoc:include type="modules" name="top-12" style="vmdefault" /></div><?php endif; ?>
				</div>
			</div>
			<?php endif; ?>
						
			<div id="tmp-container">
					
					<?php if( $this->countModules('position-3')) : ?>
					<div class="row-fluid">
						<div class="span12"><div id="newsflash-position"><jdoc:include type="modules" name="position-3" style="vmdefault" /></div></div>
					</div>
					<?php endif; ?>
					<div id="main-content-handler">
						<div class="row-fluid">
							<?php if( $this->countModules('top-left-1 or top-left-2 or position-7 or bottom-left-1 or bottom-left-2')) : ?>
							<div class="span3">
								<jdoc:include type="modules" name="top-left-1" style="vmdefault" />
								<jdoc:include type="modules" name="top-left-2" style="vmdefault" />
								<jdoc:include type="modules" name="position-7" style="vmdefault" />
								<jdoc:include type="modules" name="bottom-left-1" style="vmdefault" />
								<jdoc:include type="modules" name="bottom-left-2" style="vmdefault" />
							</div>
							<?php endif; ?>
							<div class="<?php echo $mcols; ?>">
								
								<?php if( $this->countModules('top-long')) : ?>
									<jdoc:include type="modules" name="top-long" style="vmdefault" />
									<div class="clear-sep"></div>
								<?php endif; ?>
								<?php if( $this->countModules('top-a or top-b or top-c or top-d')) : ?>
								<div id="top-content-modules">
									<div class="row-fluid">
										<?php if( $this->countModules('top-a')) : ?><div class="<?php echo $tpaclass; ?>"><jdoc:include type="modules" name="top-a" style="vmdefault" /></div><?php endif; ?>
										<?php if( $this->countModules('top-b')) : ?><div class="<?php echo $tpaclass; ?>"><jdoc:include type="modules" name="top-b" style="vmdefault" /></div><?php endif; ?>
										<?php if( $this->countModules('top-c')) : ?><div class="<?php echo $tpaclass; ?>"><jdoc:include type="modules" name="top-c" style="vmdefault" /></div><?php endif; ?>
										<?php if( $this->countModules('top-d')) : ?><div class="<?php echo $tpaclass; ?>"><jdoc:include type="modules" name="top-d" style="vmdefault" /></div><?php endif; ?>
									</div>
								</div>
								<?php endif; ?>
								<div class="tmp-content-area">
								<jdoc:include type="component" />
								</div>
								<?php if( $this->countModules('bottom-a or bottom-b or bottom-c or bottom-d')) : ?>
								<div id="bottom-content-modules">
									<div class="row-fluid">
										<?php if( $this->countModules('bottom-a')) : ?><div class="<?php echo $bmaclass; ?>"><jdoc:include type="modules" name="bottom-a" style="vmdefault" /></div><?php endif; ?>
										<?php if( $this->countModules('bottom-b')) : ?><div class="<?php echo $bmaclass; ?>"><jdoc:include type="modules" name="bottom-b" style="vmdefault" /></div><?php endif; ?>
										<?php if( $this->countModules('bottom-c')) : ?><div class="<?php echo $bmaclass; ?>"><jdoc:include type="modules" name="bottom-c" style="vmdefault" /></div><?php endif; ?>
										<?php if( $this->countModules('bottom-d')) : ?><div class="<?php echo $bmaclass; ?>"><jdoc:include type="modules" name="bottom-d" style="vmdefault" /></div><?php endif; ?>
									</div>	
								</div>
								<?php endif; ?>
							</div>
							<?php if( $this->countModules('top-right-1 or top-right-2 or position-6 or bottom-right-1 or bottom-right-2')) : ?>
							<div class="span3">
								<jdoc:include type="modules" name="top-right-1" style="vmdefault" />
								<jdoc:include type="modules" name="top-right-2" style="vmdefault" />
								<jdoc:include type="modules" name="position-6" style="vmdefault" />
								<jdoc:include type="modules" name="bottom-right-1" style="vmdefault" />
								<jdoc:include type="modules" name="bottom-right-2" style="vmdefault" />
							</div>
							<?php endif; ?>
						</div>
					</div>
			</div>
		</div>
</div>
<?php if( $this->countModules('bottom-long')) : ?>
<section id="bottom-long">
	<div class="container">
		<div class="row-fluid">
			<div class="span12">
				<jdoc:include type="modules" name="bottom-long" style="vmdefault" />
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
<section id="bottom-bg">
	<div class="container">
		<?php if( $this->countModules('bottom-1 or bottom-2 or bottom-3 or bottom-4 or bottom-5 or bottom-6')) : ?>
		<div id="bot-modules">
			<div class="row-fluid">
				<?php if( $this->countModules('bottom-1')) : ?><div class="<?php echo $bmclass; ?>" style="<?php if ($botmodules == 5) {echo "width:".$bmclass5w;} ?>"><jdoc:include type="modules" name="bottom-1" style="vmdefault" /></div><?php endif; ?>
				<?php if( $this->countModules('bottom-2')) : ?><div class="<?php echo $bmclass; ?>" style="<?php if ($botmodules == 5) {echo "width:".$bmclass5w;} ?>"><jdoc:include type="modules" name="bottom-2" style="vmdefault" /></div><?php endif; ?>
				<?php if( $this->countModules('bottom-3')) : ?><div class="<?php echo $bmclass; ?>" style="<?php if ($botmodules == 5) {echo "width:".$bmclass5w;} ?>"><jdoc:include type="modules" name="bottom-3" style="vmdefault" /></div><?php endif; ?>
				<?php if( $this->countModules('bottom-4')) : ?><div class="<?php echo $bmclass; ?>" style="<?php if ($botmodules == 5) {echo "width:".$bmclass5w;} ?>"><jdoc:include type="modules" name="bottom-4" style="vmdefault" /></div><?php endif; ?>
				<?php if( $this->countModules('bottom-5')) : ?><div class="<?php echo $bmclass; ?>" style="<?php if ($botmodules == 5) {echo "width:".$bmclass5w;} ?>"><jdoc:include type="modules" name="bottom-5" style="vmdefault" /></div><?php endif; ?>
				<?php if( $this->countModules('bottom-6')) : ?><div class="<?php echo $bmclass; ?>" style="<?php if ($botmodules == 5) {echo "width:".$bmclass5w;} ?>"><jdoc:include type="modules" name="bottom-6" style="vmdefault" /></div><?php endif; ?>
			</div>
		</div>
		<div class="clear"> </div>
		<?php endif; ?>
		
		<?php if( $this->countModules('bottom-7 or bottom-8 or bottom-9 or bottom-10 or bottom-11 or bottom-12')) : ?>
		<div id="bot-modules-2">
			<div class="row-fluid">
				<?php if( $this->countModules('bottom-7')) : ?><div class="<?php echo $bm2class; ?>" style="<?php if ($botmodules2 == 5) {echo "width:".$bm2class5w;} ?>"><jdoc:include type="modules" name="bottom-7" style="vmdefault" /></div><?php endif; ?>
				<?php if( $this->countModules('bottom-8')) : ?><div class="<?php echo $bm2class; ?>" style="<?php if ($botmodules2 == 5) {echo "width:".$bm2class5w;} ?>"><jdoc:include type="modules" name="bottom-8" style="vmdefault" /></div><?php endif; ?>
				<?php if( $this->countModules('bottom-9')) : ?><div class="<?php echo $bm2class; ?>" style="<?php if ($botmodules2 == 5) {echo "width:".$bm2class5w;} ?>"><jdoc:include type="modules" name="bottom-9" style="vmdefault" /></div><?php endif; ?>
				<?php if( $this->countModules('bottom-10')) : ?><div class="<?php echo $bm2class; ?>" style="<?php if ($botmodules2 == 5) {echo "width:".$bm2class5w;} ?>"><jdoc:include type="modules" name="bottom-10" style="vmdefault" /></div><?php endif; ?>
				<?php if( $this->countModules('bottom-11')) : ?><div class="<?php echo $bm2class; ?>" style="<?php if ($botmodules2 == 5) {echo "width:".$bm2class5w;} ?>"><jdoc:include type="modules" name="bottom-11" style="vmdefault" /></div><?php endif; ?>
				<?php if( $this->countModules('bottom-12')) : ?><div class="<?php echo $bm2class; ?>" style="<?php if ($botmodules2 == 5) {echo "width:".$bm2class5w;} ?>"><jdoc:include type="modules" name="bottom-12" style="vmdefault" /></div><?php endif; ?>
			</div>
		</div>
		<div class="clear"> </div>
		<?php endif; ?>
	</div>
</section>

<?php if( $this->countModules('footer or footer-left or footer-right')) : ?>
<footer id="footer">
	<div class="container">
		<div id="footer-line" class="row-fluid">
			<?php if( $this->countModules('footer')) : ?><div class="span12"><jdoc:include type="modules" name="footer" /></div><?php endif; ?>
			<?php if( $this->countModules('footer-left or footer-right')) : ?>
			<div id="foo-left-right">
				<?php if( $this->countModules('footer-left')) : ?><div class="<?php if( $this->countModules('footer-left and footer-right')) : ?>span6<?php else: ?>span12<?php endif;?>"><jdoc:include type="modules" name="footer-left" /></div><?php endif; ?>
				<?php if( $this->countModules('footer-right')) : ?><div class="<?php if( $this->countModules('footer-left and footer-right')) : ?>span6<?php else: ?>span12<?php endif;?>"><jdoc:include type="modules" name="footer-right" /></div><?php endif; ?>
				<div class="clear"> </div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</footer>
<?php endif; ?>


<?php if($this->params->get("bodybackgroundimage")) : ?>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.backstretch.min.js"></script>
<script type="text/javascript">
jQuery.backstretch("<?php echo $this->params->get("bodybackgroundimage"); ?>");
</script>
<?php endif; ?>
<jdoc:include type="modules" name="debug" />
<?php echo $this->params->get("footercode"); ?>
</body>
</html>