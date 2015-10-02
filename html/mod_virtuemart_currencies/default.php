<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<!-- Currency Selector Module -->
<form action="<?php echo vmURI::getCleanUrl() ?>" method="post">
	<div class="currency-label"><?php echo $text_before ?></div>
	<?php echo JHTML::_('select.genericlist', $currencies, 'virtuemart_currency_id', 'class="dk default-currency"', 'virtuemart_currency_id', 'currency_txt', $virtuemart_currency_id) ; ?>
    <input class="button" type="submit" name="submit" value="<?php echo JText::_('MOD_VIRTUEMART_CURRENCIES_CHANGE_CURRENCIES') ?>" />
</form>
