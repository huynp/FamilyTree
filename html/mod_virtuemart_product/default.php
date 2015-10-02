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
<div class="vmgroup<?php echo $params->get ('moduleclass_sfx') ?>">

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

		<ul class="vmproduct productdetails row-fluid">
			<?php foreach ($products as $product) : ?>
			<li class="<?php echo $pwidth ?> <?php echo $float ?>">
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
			if ($col == $products_per_row && $products_per_row && $last) {
				echo '
		</ul><div class="clear"></div>
		<ul  class="vmproduct productdetails row-fluid">';
				$col = 1;
			} else {
				$col++;
			}
			$last--;
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