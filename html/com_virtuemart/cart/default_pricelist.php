<?php defined ('_JEXEC') or die('Restricted access');
/**
 *
 * Layout for the shopping cart
 *
 * @package    VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 * @author Patrick Kohl
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 */

// Check to ensure this file is included in Joomla!

// jimport( 'joomla.application.component.view');
// $viewEscape = new JView();
// $viewEscape->setEscape('htmlspecialchars');

?>

<script type="text/javascript">
	Image1= new Image(75,75)
	Image1.src = "/images/RejectButton.png"
	
	Image2 = new Image(75,75)
	Image2.src = "/images/RejectButton_Hover.png"
	
	Image3= new Image(75,75)
	Image3.src = "/images/AcceptButton.png"
	
	Image4 = new Image(75,75)
	Image4.src = "/images/AcceptButton_Hover.png"
	
	function show_moreprints() {
	  SqueezeBox.initialize({
		  size: {x: 350, y: 350}
		});
	  SqueezeBox.resize({x: 350, y: 200})
		
	  var newElem = new Element( 'div' );
	  /*newElem.setStyle('border', 'solid 1px #CCC');*/ 
	  newElem.setStyle('width', '325px');
	  newElem.setStyle('height', '175px');
	  newElem.setStyle('padding', '10px');   
	  newElem.setStyle('text-align', 'center');
	
	  var spn = document.createElement("span");
	  
	  spn.innerHTML = "<center><table class=\"background_table\"><tbody><tr>" +
					  "<td colspan='2'>Would you like to order additional prints at a discounted price?</td>" +
					  "</tr><tr>" +
					  "<td style='text-align:center'><br /><a href='/index.php/our-products/re-prints-additional-prints/additional-prints-detail' class='yesmoreprints' title='Yes More Prints'></a></td>" +
					  "<td style='text-align:center'><br /><a href='#' onClick='SqueezeBox.close()'; class='nomoreprints' title='No More Prints'></a></td>" +
					  "</tr></tbody></table></center>"; 
	  
	  newElem.appendChild(spn);
		
	  SqueezeBox.setContent('adopt',newElem);
	}
</script>

<div class="billto-shipto row-fluid">
	<div class="span6">

		<span><span class="vmicon vm2-billto-icon"></span>
			<?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_LBL'); ?></span>
		<?php // Output Bill To Address ?>
		<div class="output-billto">
			<?php

			foreach ($this->cart->BTaddress['fields'] as $item) {
				if (!empty($item['value'])) {
					if ($item['name'] === 'agreed') {
						$item['value'] = ($item['value'] === 0) ? JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_NO') : JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_YES');
					}
					?><!-- span class="titles"><?php echo $item['title'] ?></span -->
					<span class="values vm2<?php echo '-' . $item['name'] ?>"><?php echo $this->escape ($item['value']) ?></span>
					<?php if ($item['name'] != 'title' and $item['name'] != 'first_name' and $item['name'] != 'middle_name' and $item['name'] != 'zip') { ?>
						<br class="clear"/>
						<?php
					}
				}
			} ?>
			<div class="clear"></div>
		</div>

		<a class="button" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=user&task=editaddresscart&addrtype=BT', $this->useXHTML, $this->useSSL) ?>">
			<?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_EDIT_BILLTO_LBL'); ?>
		</a>

		<input type="hidden" name="billto" value="<?php echo $this->cart->lists['billTo']; ?>"/>
	</div>

	<div class="span6">

		<span><span class="vmicon vm2-shipto-icon"></span>
			<?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_SHIPTO_LBL'); ?></span>
		<?php // Output Bill To Address ?>
		<div class="output-shipto">
			<?php
			if (empty($this->cart->STaddress['fields'])) {
				echo JText::sprintf ('COM_VIRTUEMART_USER_FORM_EDIT_BILLTO_EXPLAIN', JText::_ ('COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL'));
			} else {
				if (!class_exists ('VmHtml')) {
					require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'html.php');
				}
				echo JText::_ ('COM_VIRTUEMART_USER_FORM_ST_SAME_AS_BT');
				echo VmHtml::checkbox ('STsameAsBTjs', $this->cart->STsameAsBT) . '<br />';
				?>
				<div id="output-shipto-display">
					<?php
					foreach ($this->cart->STaddress['fields'] as $item) {
						if (!empty($item['value'])) {
							?>
							<!-- <span class="titles"><?php echo $item['title'] ?></span> -->
							<?php
							if ($item['name'] == 'first_name' || $item['name'] == 'middle_name' || $item['name'] == 'zip') {
								?>
								<span class="values<?php echo '-' . $item['name'] ?>"><?php echo $this->escape ($item['value']) ?></span>
								<?php } else { ?>
								<span class="values"><?php echo $this->escape ($item['value']) ?></span>
								<br class="clear"/>
								<?php
							}
						}
					}
					?>
				</div>
				<?php
			}
			?>
			<div class="clear"></div>
		</div>
		<?php if (!isset($this->cart->lists['current_id'])) {
		$this->cart->lists['current_id'] = 0;
	} ?>
		<a class="button" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=user&task=editaddresscart&addrtype=ST&virtuemart_user_id[]=' . $this->cart->lists['current_id'], $this->useXHTML, $this->useSSL) ?>">
			<?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL'); ?>
		</a>

	</div>

	<div class="clear"></div>
</div>


<table class="cart-summary" cellspacing="0" cellpadding="0" border="0" width="100%">
<tr> 
	<th align="left" style="text-align:left;padding-left:5px;"><?php echo JText::_ ('COM_VIRTUEMART_CART_NAME') ?></th>
	<th align="left" class="hidden-phone"><?php echo JText::_ ('COM_VIRTUEMART_CART_SKU') ?></th>
	<th	align="center" width="60px" class="hidden-phone"><?php echo JText::_ ('COM_VIRTUEMART_CART_PRICE') ?></th>
	<th align="center"><?php echo JText::_ ('COM_VIRTUEMART_CART_QUANTITY') ?>/<?php echo JText::_ ('COM_VIRTUEMART_CART_ACTION') ?></th>
	<?php if (VmConfig::get ('show_tax')) { ?>
	<th align="right" width="60px" class="hidden-phone"><?php  echo "<span  class='priceColor2'>" . JText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?></th>
	<?php } ?>
	<th align="right" width="60px" class="hidden-phone"><?php echo "<span  class='priceColor2'>" . JText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') ?></th>
	<th align="right" style="text-align:right;padding-right:5px;"><?php echo JText::_ ('COM_VIRTUEMART_CART_TOTAL') ?></th>
</tr>

<?php
$i = 1;
// 		vmdebug('$this->cart->products',$this->cart->products);
$productNames=array();
foreach ($this->cart->products as $pkey => $prow) {
	?>
<tr valign="top" class="sectiontableentry<?php echo $i ?>" style="font-size:11px; margin-top:5px;"> 
	<td align="left" style="padding:5px; width:295px;">
		<div style="display:inline-block; vertical-align:top; padding-right:5px;"> 
			<?php if ($prow->virtuemart_media_id) { ?>
            <span class="cart-images">
                             <?php
                if (!empty($prow->image)) {
                    echo $prow->image->displayMediaThumb ('', FALSE);
                }
                ?>
                            </span>
            <?php } ?>
        </div>
        <div style="display:inline-block">   
			<?php echo JHTML::link ($prow->url, $prow->product_name) . $prow->customfields; ?>
            <?php 
				//$pattern1 = '/[\sA-Za-z0-9\&\>\"\-\=]*?(: 0)/';
				//$pattern2 = '/br/';
				//$pattern3 = '/<<\s\S>/';
				//$breaks = array("\r\n", "\n", "\r");
				//$newCustomFields1 = preg_replace($pattern1,'',$prow->customfields);
				//$newCustomFields2 = preg_replace($pattern2,"",$newCustomFields1);
				//$newCustomFields3 = preg_replace($pattern3,"",$newCustomFields2);
    			//$newtext = str_replace($breaks, "", $newCustomFields2);
				//var_dump($prow);
			?>
        </div>
	</td> 
	<td align="left" class="hidden-phone" style="padding:12px 5px 5px 0px;"><?php  echo $prow->product_sku ?></td>
	<td align="left" class="hidden-phone" style="padding:12px 5px 5px 0px;">
		<?php
		// 					vmdebug('$this->cart->pricesUnformatted[$pkey]',$this->cart->pricesUnformatted[$pkey]['priceBeforeTax']);
		echo $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $this->cart->pricesUnformatted[$pkey], FALSE);
		// 					echo $prow->salesPrice ;
		?>
	</td>
	<td align="left" style="padding:5px 5px 5px 0px;"><?php
//				$step=$prow->min_order_level;
				if ($prow->step_order_level)
					$step=$prow->step_order_level;
				else
					$step=1;
				if($step==0)
					$step=1;
				$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
				?>
                <script type="text/javascript">
				function check<?php echo $step?>(obj) {
 				// use the modulus operator '%' to see if there is a remainder
				remainder=obj.value % <?php echo $step?>;
				quantity=obj.value;
 				if (remainder  != 0) {
 					alert('<?php echo $alert?>!');
 					obj.value = quantity-remainder;
 					return false;
 				}
 				return true;
 				}
				</script>
		
		<form action="<?php echo JRoute::_ ('index.php'); ?>" method="post" class="inline">
			<input type="hidden" name="option" value="com_virtuemart"/>
				<!--<input type="text" title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="inputbox" size="3" maxlength="4" name="quantity" value="<?php echo $prow->quantity ?>" /> -->
                <input type="text" class="inputbox" onblur="check<?php echo $step?>(this);" onclick="check<?php echo $step?>(this);" onchange="check<?php echo $step?>(this);" onsubmit="check(<?php echo $step?>this);" title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="quantity-input js-recalculate" size="3" maxlength="4" name="quantity" value="<?php echo $prow->quantity ?>" />
			<input type="hidden" name="view" value="cart"/>
			<input type="hidden" name="task" value="update"/>
			<input type="hidden" name="cart_virtuemart_product_id" value="<?php echo $prow->cart_item_id  ?>"/>
			<input type="submit" class="vmicon vm2-add_quantity_cart" name="update" title="<?php echo  JText::_ ('COM_VIRTUEMART_CART_UPDATE') ?>" align="middle" value=" "/>
		</form>
		
		<a class="vmicon vm2-remove_from_cart" title="<?php echo JText::_ ('COM_VIRTUEMART_CART_DELETE') ?>" align="middle" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=cart&task=delete&cart_virtuemart_product_id=' . $prow->cart_item_id) ?>"> </a>
	</td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td align="right" class="hidden-phone"><?php echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE, $prow->quantity) . "</span>" ?></td>
	<?php } ?>
	<td align="right" class="hidden-phone"><?php echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('discountAmount', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE, $prow->quantity) . "</span>" ?></td>
	<td colspan="1" style="text-align:right; padding:12px 0px 5px 5px;">
		<?php
		if (VmConfig::get ('checkout_show_origprice', 1) && !empty($this->cart->pricesUnformatted[$pkey]['basePriceWithTax']) && $this->cart->pricesUnformatted[$pkey]['basePriceWithTax'] != $this->cart->pricesUnformatted[$pkey]['salesPrice']) {
			echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceWithTax', '', $this->cart->pricesUnformatted[$pkey], TRUE, FALSE, $prow->quantity) . '</span><br />';
		}
		echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE, $prow->quantity) ?></td>
</tr>
	<?php
	$i = 1 ? 2 : 1;
	
	array_push($productNames, $prow->product_name);  
} ?>

</table>

<?php
if(in_array("Additional Prints", $productNames) || in_array("Updates", $productNames)) {
}
else {
	echo "<script>show_moreprints();</script>";
}
?>

<table class="cart-summary" cellspacing="0" cellpadding="0" border="0" width="100%">

<tr class="sectiontableentry1">
	<td><b><?php echo JText::_ ('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_PRICES_TOTAL'); ?></b></td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td align="right"><?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $this->cart->pricesUnformatted, FALSE) . "</span>" ?></td>
	<?php } ?>
	<td align="right"><?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('discountAmount', '', $this->cart->pricesUnformatted, FALSE) . "</span>" ?></td>
	<td align="right" style="text-align:right;"><?php echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->pricesUnformatted, FALSE) ?></td>
</tr>
</table>

<table class="cart-summary" cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr class="sectiontableentry1">
		<td>
			<?php
			if (VmConfig::get ('coupons_enable')) { ?>
				<div class="row-fluid">
					<div class="span5"> <b>Coupon Discount:</b> </div>
					<div class="span7">
						
						<?php if (!empty($this->layoutName) && $this->layoutName == 'default') {
							echo $this->loadTemplate ('coupon');
						}?>

					</div>


					<?php if (!empty($this->cart->cartData['couponCode'])) { ?>
						<div class="span4">
							<?php
								echo $this->cart->cartData['couponCode'];
								echo $this->cart->cartData['couponDescr'] ? (' (' . $this->cart->cartData['couponDescr'] . ')') : '';
							?>	
						</div>
						<div class="span4">
							
							 <?php if (VmConfig::get ('show_tax')) { 
							 	echo $this->currencyDisplay->createPriceDiv ('couponTax', '', $this->cart->pricesUnformatted['couponTax'], FALSE); 
							 }?> 
						</div>
						<div class="span4">
							<?php echo $this->currencyDisplay->createPriceDiv ('salesPriceCoupon', '', $this->cart->pricesUnformatted['salesPriceCoupon'], FALSE); ?>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</td>
	</tr>
</table>
<table class="cart-summary" cellspacing="0" cellpadding="0" border="0" width="100%">

<?php
foreach ($this->cart->cartData['DBTaxRulesBill'] as $rule) {
	?>
<tr class="sectiontableentry<?php echo $i ?>">
	<td colspan="4" align="right"><?php echo $rule['calc_name'] ?> </td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td align="right"></td>
	<?php } ?>
	<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?></td>
	<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
</tr>
	<?php
	if ($i) {
		$i = 1;
	} else {
		$i = 0;
	}
} ?>

<?php

foreach ($this->cart->cartData['taxRulesBill'] as $rule) {
	?>
<tr class="sectiontableentry<?php echo $i ?>">
	<td colspan="4" align="right"><?php echo $rule['calc_name'] ?> </td>
	<?php if (VmConfig::get ('show_tax')) { ?>
	<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
	<?php } ?>
	<td align="right"><?php ?> </td>
	<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
</tr>
	<?php
	if ($i) {
		$i = 1;
	} else {
		$i = 0;
	}
}

foreach ($this->cart->cartData['DATaxRulesBill'] as $rule) {
	?>
<tr class="sectiontableentry<?php echo $i ?>">
	<td colspan="4" align="right"><?php echo   $rule['calc_name'] ?> </td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td align="right"></td>

	<?php } ?>
	<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?>  </td>
	<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
</tr>
	<?php
	if ($i) {
		$i = 1;
	} else {
		$i = 0;
	}
} ?>
</table>

<table class="cart-summary" cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td>
			<div class="row-fluid">
				<?php if (!$this->cart->automaticSelectedShipment) { ?>
					<div class="span9" align="left">
						<?php echo $this->cart->cartData['shipmentName']; ?>
						<br/>
						<?php
							if (!empty($this->layoutName) && $this->layoutName == 'default' && !$this->cart->automaticSelectedShipment) {
								if (VmConfig::get('oncheckout_opc', 0)) {
									$previouslayout = $this->setLayout('select');
									echo $this->loadTemplate('shipment');
									$this->setLayout($previouslayout);
								} else {
									echo JHTML::_('link', JRoute::_('index.php?view=cart&task=edit_shipment', $this->useXHTML, $this->useSSL), $this->select_shipment_text, 'class=""');
								}
							} else {
								echo JText::_ ('COM_VIRTUEMART_CART_SHIPPING');
							}
						?>
					</div>
				<?php
				}
				else {
				?>
					<div class="span3"><b>Shipping Information:</b></div>
					<div class="span6"><?php echo $this->cart->cartData['shipmentName']; ?></div>
				<?php } ?>
					<div class="span3"><?php echo $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->pricesUnformatted['salesPriceShipment'], FALSE); ?>
					</div>
			</div>
		</td>
	</tr>
</<table>

<table class="cart-summary" cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td>
			<?php if ($this->cart->pricesUnformatted['salesPrice']>0.0 ) { ?>
				<div class="row-fluid">
					<?php if (!$this->cart->automaticSelectedPayment) { ?>
						<div class="span5" align="left">
							<b>Payment Selected:</b>
						</div>
						<div class="span7" align="left">
							<?php echo $this->cart->cartData['paymentName']; ?>
						</div>
						<div class="span12" align="left">
						<?php if (!empty($this->layoutName) && $this->layoutName == 'default') {
								if (VmConfig::get('oncheckout_opc', 0)) {
									$previouslayout = $this->setLayout('select');
									echo $this->loadTemplate('payment');
									$this->setLayout($previouslayout);
								} else {
									echo JHTML::_('link', JRoute::_('index.php?view=cart&task=editpayment', $this->useXHTML, $this->useSSL), $this->select_payment_text, 'class=""');
								}
						} 
						else {?>
						
							<?php echo JText::_ ('COM_VIRTUEMART_CART_PAYMENT'); ?>
						<?php } ?>
						</div>
					<?php } 
					else { ?>
						<div class="span5" align="left">
							<b>Payment Information:</b>
						</div>
						<div class="span7" align="left">
							<?php echo $this->cart->cartData['paymentName']; ?> 
						</div>
					<?php }  ?>

					<?php if (VmConfig::get ('show_tax')) { ?>
						<div class="span12" style="text-align:right">
							<?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('paymentTax', '', $this->cart->pricesUnformatted['paymentTax'], FALSE) . "</span>"; ?> 
						</div>
					<?php } ?>

					<?php if($this->cart->pricesUnformatted['salesPricePayment'] < 0){?>
						<div class="span12" style="text-align:right">
							<?php echo $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->pricesUnformatted['salesPricePayment'], FALSE); ?>
						</div>
					<?php } ?>

					<div class="span12" style="text-align:right">
						<?php  echo $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->pricesUnformatted['salesPricePayment'], FALSE); ?>
						<i>*Redirected to PayPal after checekout</i>
					</div>
				</div>
			<?php }  ?>
		</td>
	</tr>
</<table>

<table class="cart-summary total-price" cellspacing="0" cellpadding="0" border="0" width="100%">

<tr class="sectiontableentry2">
	<td colspan="2" align="right"><b style="color:#709a00"><?php echo JText::_ ('COM_VIRTUEMART_CART_TOTAL') ?>:</b></td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td align="right"> <?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billTaxAmount', '', $this->cart->pricesUnformatted['billTaxAmount'], FALSE) . "</span>" ?> </td>
	<?php } ?>
	<td align="right"> <?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billDiscountAmount', '', $this->cart->pricesUnformatted['billDiscountAmount'], FALSE) . "</span>" ?> </td>
	<td align="right"></td><td align="right"></td><td align="right"><?php $_SESSION['CartTotal'] = $this->cart->pricesUnformatted['billTotal']; ?></td>
	<td style="text-align:right"><strong><?php echo $this->currencyDisplay->createPriceDiv ('billTotal', '', $this->cart->pricesUnformatted['billTotal'], FALSE); ?></strong></td>
</tr> 
<?php
if ($this->totalInPaymentCurrency) {
?>

<tr class="sectiontableentry2">
	<td colspan="4" align="right"><?php echo JText::_ ('COM_VIRTUEMART_CART_TOTAL_PAYMENT') ?>:</td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td align="right"></td>
	<?php } ?>
	<td align="right"></td>
	<td align="right"><strong><?php echo $this->totalInPaymentCurrency;   ?></strong></td>
</tr>
	<?php
}
?>


</table> 

