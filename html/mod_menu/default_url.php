<?php
defined('_JEXEC') or die;

$class = $item->anchor_css ? 'class="'.$item->anchor_css.'" ' : '';
$title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';
$note = $item->note ? '<br /><small>'.$item->note.'</small>' : ''; 
if ($item->menu_image) {
		$item->params->get('menu_text', 1 ) ? 
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';
} 
else { $linktype = $item->title;
}

switch ($item->browserNav) :
	default:
	case 0:
?><a <?php echo $class; ?>href="<?php echo $item->flink; ?>" <?php echo $title; ?>><span<?php if ($item->menu_image) { echo ' class="link-has-image"'; } else {echo ' class="link-no-image"';} ?>><?php echo $linktype; ?><?php echo $note; ?></span></a><?php
		break;
	case 1:
		// _blank
?><a <?php echo $class; ?>href="<?php echo $item->flink; ?>" target="_blank" <?php echo $title; ?>><span<?php if ($item->menu_image) { echo ' class="link-has-image"'; } else {echo ' class="link-no-image"';} ?>><?php echo $linktype; ?><?php echo $note; ?></span></a><?php
		break;
	case 2:
		// window.open
		$attribs = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,'.$params->get('window_open');
?><a <?php echo $class; ?>href="<?php echo $item->flink; ?>" onclick="window.open(this.href,'targetWindow','<?php echo $attribs;?>');return false;" <?php echo $title; ?>><?php echo $linktype; ?><?php echo $note; ?></a><?php
		break;
endswitch;
