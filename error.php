<?php
defined('_JEXEC') or die;
if (!isset($this->error)) {
	$this->error = JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	$this->debug = false; 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/reset.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/text.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/typography.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/presets/style-error.css" media="screen" />

</head>
<body>
<div id="top-handler">
	<div id="top">
		<h1><?php $config =& JFactory::getConfig(); echo $config->getValue( 'config.sitename' ); ?></h1>
		<h2><?php echo $this->error->getCode(); ?> - <?php echo $this->error->getMessage(); ?></h2>
	</div>
</div>
<div class="w-site-width">
					<div id="errorboxbody">
						<p><strong><?php echo JText::_('YOU_MAY_NOT_BE_ABLE_TO_VISIT_THIS_PAGE_BECAUSE_OF'); ?>:</strong></p>
							<ul class="list-error">
								<li><?php echo JText::_('AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
								<li><?php echo JText::_('A_SEARCH_ENGINE_THAT_HAS_AN_OUT_OF_DATE_LISTING_FOR_THIS_SITE'); ?></li>
								<li><?php echo JText::_('A_MIS_TYPED_ADDRESS'); ?></li>
								<li><?php echo JText::_('YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
								<li><?php echo JText::_('The requested resource was not found'); ?></li>
								<li><?php echo JText::_('An error has occurred while processing your request.'); ?></li>
							</ul>
						<p><strong><?php echo JText::_('PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES'); ?></strong></p>

							<ul>
								<li><a href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo JText::_('GO_TO_THE_HOME_PAGE'); ?>"><?php echo JText::_('HOME_PAGE'); ?></a></li>
							</ul>

						<p><?php echo JText::_('IF_DIFFICULTIES_PERSIST__PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR_OF_THIS_SITE'); ?></p>
						<div id="techinfo">
						<div class="alert"><div class="icon"><!-- --></div><strong><?php echo $this->error->getMessage(); ?></strong></div>
						<?php if ($this->debug) : ?>
						<div class="info"><div class="icon"><!-- --></div>
							
							<?php echo $this->renderBacktrace(); ?>
							
						</div>
						<?php endif; ?>
						</div>
					</div>
</div>


</body>
</html>
