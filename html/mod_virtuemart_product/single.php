<?php // no direct access
defined ('_JEXEC') or die('Restricted access');
$col = 1;

if ($products_per_row == 4) { $pwidth = 'span3'; }
elseif ($products_per_row == 3) { $pwidth = 'span4'; }
elseif ($products_per_row == 2) { $pwidth = 'span6'; }
elseif ($products_per_row == 1) { $pwidth = 'span12'; }

//$pwidth = ' width' . floor (100 / $products_per_row);
if ($products_per_row > 1) {
	$float = "floatleft";
} else {
	$float = "center";
}
?>
<div class="vmgroup<?php echo $params->get ('moduleclass_sfx') ?> product-sl-handler">

	<?php if ($headerText) { ?>
	<div class="vmheader"><?php echo $headerText ?></div>
	<?php
}
	if ($display_style == "div") {
		?>
		<div class="vmproduct productdetails row-fluid">
			<?php foreach ($products as $product) { ?>
			<div class="<?php echo $pwidth ?> <?php echo $float ?>">
				<div class="spacer">
				<div class="pr-img-handler">
				<?php
				if (!empty($product->images[0])) {
					$image = $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE);
				} else {
					$image = '';
				}
				echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));
				?>
					<?php if ($show_price and  isset($product->prices)) { ?>
					<div class="popout-price">
					<?php echo $currency->createPriceDiv ('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE); ?>
					</div>
					<?php } ?>
					
				</div>
				<?php
				$url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
					$product->virtuemart_category_id); ?>
					<h3 class="h-pr-title">
						<a href="<?php echo $url ?>"><?php echo $product->product_name ?></a>
					</h3>
					<div>
						<div class="product-price">
						<?php 
							// $product->prices is not set when show_prices in config is unchecked
							if ($show_price and  isset($product->prices)) {
								echo '<div class="product-price">'.$currency->createPriceDiv ('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
								if ($product->prices['salesPriceWithDiscount'] > 0) {
									echo $currency->createPriceDiv ('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
								}
								echo '</div>';
							}?>
						</div>
						<div>
							<?php
							if ($show_addtocart) {
								//echo mod_virtuemart_product::addtocart ($product);
								?><a href="<?php echo $url ?>" class="product-details"><?php echo JText::_ ( 'COM_VIRTUEMART_PRODUCT_DETAILS' ); ?></a><?php
							}
							?>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
			<?php
			if ($col == $products_per_row && $products_per_row && $col < $totalProd) {
				echo "</div><div class=\"vmproduct productdetails row-fluid\">";
				$col = 1;
			} else {
				$col++;
			}
		} ?>
		</div>
		<br style='clear:both;'/>

		<?php
	} else {
		$last = count ($products) - 1;
		?>
		
		<?php 
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		$temps = $doc->baseurl.'/templates/'.$doc->template;
		
		$templateparams = $app->getTemplate(true)->params;
		?>

		<?php 
			if ($templateparams->get('vmtsl_numeric')) : $vmtsl_var_numeric = "true"; else : $vmtsl_var_numeric = "false"; endif;
			if ($templateparams->get('vmtsl_nextprev')) : $vmtsl_var_nextprev = "true"; else : $vmtsl_var_nextprev = "false"; endif;
			if ($templateparams->get('vmtsl_auto')) : $vmtsl_var_auto = "true"; else : $vmtsl_var_auto = "false"; endif;
			if ($templateparams->get('vmtsl_loop')) : $vmtsl_var_loop = "true"; else : $vmtsl_var_loop = "false"; endif;
			if ($templateparams->get('vmtsl_clickstop')) : $vmtsl_var_clickstop = "true"; else : $vmtsl_var_clickstop = "false"; endif;
		
			$doc->addScript($temps.'/js/easypaginate.js'); 
			$doc->addCustomTag('
		<script type="text/javascript">
			jQuery(function($){
				$(\'ul#slider'.$module->id.'\').easyPaginate({
					delay: '.$templateparams->get('vmtsl_delay').',
					numeric: '.$vmtsl_var_numeric.',
					nextprev: '.$vmtsl_var_nextprev.',
					auto:'.$vmtsl_var_auto.',
					loop:'.$vmtsl_var_loop.',
					pause:'.$templateparams->get('vmtsl_pause').',
					clickstop:'.$vmtsl_var_clickstop.',
					controls: \'pagination-'.$module->id.'\',
					step: '.$products_per_row.'
				});
			}); 
		</script>
		');		
		
		$resVal = $templateparams->get('vmtsl_arrowsposition') - 50;
		
		$doc->addCustomTag('
		<style type="text/css">
			ol#pagination-'.$module->id.' li.prev, ol#pagination-'.$module->id.' li.next{
				position:absolute;
				top: '.$templateparams->get('vmtsl_arrowsposition').'px;
			}
			
			@media (min-width: 768px) and (max-width: 979px) { 
				ol#pagination-'.$module->id.' li.prev, ol#pagination-'.$module->id.' li.next{
					position:absolute;
					top: '.$resVal .'px;
				}
			}
		</style>
		');
		?>
		<ul class="sl-products vmproduct productdetails row-fluid" id="slider<?php echo($module->id); ?>">
			<?php foreach ($products as $product) : ?>
			<li class="<?php echo $pwidth ?> <?php echo $float ?> <?php echo "sl-item-".$a++%$products_per_row; ?>">
				<div class="spacer">
				<div class="pr-img-handler">
				<?php
				if (!empty($product->images[0])) {
					$image = $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE);
				} else {
					$image = '';
				}
				echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));
				?>
					<?php if ($show_price and  isset($product->prices)) { ?>
					<div class="popout-price">
					<?php echo $currency->createPriceDiv ('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE); ?>
					</div>
					<?php } ?>
					
				</div>
				<?php
				$url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
					$product->virtuemart_category_id); ?>
					<h3 class="h-pr-title">
						<a href="<?php echo $url ?>"><?php echo $product->product_name ?></a>
					</h3>
					<div>
						<div class="product-price">
						<?php 
							// $product->prices is not set when show_prices in config is unchecked
							if ($show_price and  isset($product->prices)) {
								echo '<div class="product-price">'.$currency->createPriceDiv ('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
								if ($product->prices['salesPriceWithDiscount'] > 0) {
									echo $currency->createPriceDiv ('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
								}
								echo '</div>';
							}?>
						</div>
						<div>
							<?php
							if ($show_addtocart) {
								//echo mod_virtuemart_product::addtocart ($product);
								?><a href="<?php echo $url ?>" class="product-details"><?php echo JText::_ ( 'COM_VIRTUEMART_PRODUCT_DETAILS' ); ?></a><?php
							}
							?>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</li>
			<?php
		endforeach; ?>
		</ul>
		<div class="clear"></div>

		<?php
	}
	if ($footerText) : ?>
		<div class="vmfooter<?php echo $params->get ('moduleclass_sfx') ?>">
			<?php echo $footerText ?>
		</div>
		<?php endif; ?>
</div>