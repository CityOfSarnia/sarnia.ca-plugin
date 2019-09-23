<?php
/**
 * Block Name: Shortcut Menu
 *
 * This is the template that displays the shortcut-menu block.
 */
?>
<div class="shortcut-menu alignwide">
	<ul>
<?php if( have_rows('menu_repeater') ):?>			
<?php while( have_rows('menu_repeater') ): the_row(); 
	// vars
	$image = get_sub_field('sub_field_image');
	$text = get_sub_field('sub_field_text');
	$link = get_sub_field('sub_field_url');
?>
<?php if( $link ): ?>
	<a href="<?php echo $link; ?>">
<?php endif; ?>
	<li class = "shortcut-menu-list__item">
		<img id="<?= $image['url'] ?>" src="<?php echo $image['url']; ?>" width="100px" height="100px" />
		<span class="shortcut-menu-li caption"> <?= $text; ?> </span>
	</li>
<?php if( $link ): ?>
	</a>
<?php endif; ?>
<?php endwhile; ?>
<?php endif; ?>
	</ul>
 </div><!-- .shortcut-menu -->