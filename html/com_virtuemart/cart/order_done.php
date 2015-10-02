<?php
defined('_JEXEC') or die('');

/**
*
* Template for the shopping cart
*
* @package	VirtueMart
* @subpackage Cart
* @author Max Milbers
*
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/



echo "<h3>".JText::_('COM_VIRTUEMART_CART_ORDERDONE_THANK_YOU')."</h3>";

echo '<!-- Google Code for Sales Conversions Conversion Page -->
		<script type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 956686823;
		var google_conversion_language = "en";
		var google_conversion_format = "3";
		var google_conversion_color = "ffffff";
		var google_conversion_label = "LXKrCPr431oQ58OXyAM";
		var google_conversion_value = ' . $this->cart->pricesUnformatted['billTotal'] . ';
		var google_conversion_currency = "USD";
		var google_remarketing_only = false;
		/* ]]> */
		</script>
		<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/956686823/?value='. $this->cart->pricesUnformatted['billTotal'] .'&amp;currency_code=USD&amp;label=LXKrCPr431oQ58OXyAM&amp;guid=ON&amp;script=0"/>
		</div>
		</noscript>
		
		<!-- Facebook Conversion Code for Checkouts - Clint Newbold 1 -->
		<script>(function() {
		var _fbq = window._fbq || (window._fbq = []);
		if (!_fbq.loaded) {
		var fbds = document.createElement("script");
		fbds.async = true;
		fbds.src = "//connect.facebook.net/en_US/fbds.js";
		var s = document.getElementsByTagName("script")[0];
		s.parentNode.insertBefore(fbds, s);
		_fbq.loaded = true;
		}
		})();
		window._fbq = window._fbq || [];
		window._fbq.push(["track", "6026045638362", {"value":"0.00","currency":"USD"}]);
		</script>
		<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6026045638362&amp;cd[value]=0.00&amp;cd[currency]=USD&amp;noscript=1" /></noscript>';
		

echo $this->html;
