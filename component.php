<?php
defined( '_JEXEC' ) or die;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<?php
if (!JFactory::getApplication()->get('jquery')) { JFactory::getApplication()->set('jquery', true); 
echo '<script src="'.$this->baseurl.'/templates/'.$this->template.'/js/jquery-1.8.1.min.js"></script><script src="'.$this->baseurl.'/templates/'.$this->template.'/js/jquery.noConflict.js"></script>'; } ?>
	<jdoc:include type="head" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/bootstrap.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/responsive.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/text.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/layout.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/nav.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/typography.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/responsive-template.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/vm-swift.css" media="print" />
    <?php if($this->params->get('usetheme')==true) : ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/presets/<?php echo $this->params->get('choosetheme'); ?>.css" media="screen" />
    <?php endif; ?>
</head>
<body class="contentpane">
		<jdoc:include type="component" />
</body>
</html>
