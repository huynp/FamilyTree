<?php defined('_JEXEC') or die('Restricted access');

function modChrome_vmdefault($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	if (!empty ($module->content)) : ?>
		<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
				<?php if ($module->showtitle) : ?>
					<h<?php echo $headerLevel; ?>><?php 
					$title = $module->title;
                    $title = explode(' ', $title);
                    $title[0] = '<span>'.$title[0].'</span>';
                    $title= join(' ', $title);
                    echo $title; ?></h<?php echo $headerLevel; ?>>
					
				<?php endif; ?>
				<div class="module-content"><?php echo $module->content; ?></div>
		</div>
	<?php endif;
}

function modChrome_slides($module, &$params, &$attribs)
{
$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
if (!empty ($module->content)) : ?>
<div>
<?php if ($module->showtitle) : ?><h<?php echo $headerLevel; ?> class="slide-header"><?php echo $module->title; ?></h<?php echo $headerLevel; ?>><?php endif; ?>
<?php echo $module->content; ?>
</div>
<?php endif;
}


