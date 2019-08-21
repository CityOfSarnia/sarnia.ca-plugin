<?php
/**
 * Block Name: Navigation
 *
 * This is the template that displays the navigation block.
 */
?>

<?php if( get_field('menu') ) : ?>
<div class="navigation-card <?=card_colour(); ?>">
<?php if( get_field('menu_image') ) : ?>
    <div class="navigation-card__image" style="background-image: url(<?php $image = get_field('menu_image'); echo($image['sizes']['large']); ?>) !important;"></div>
<?php endif; ?>
    <div class="navigation-card__main">
<?php
$menu_id = get_field('menu');
$menuObj = wp_get_nav_menu_object($menu_id);
$menu_name = $menuObj->name;
    if( get_field('menu_headline') ) :
?>
        <h2 class="navigation-card__headline"><?php the_field('menu_headline');?></h2>
<?php else : ?>
        <h2 class="navigation-card__headline"><?= $menu_name ?></h2>
<?php endif; ?>
        <div class="navigation-card__menu"><?php wp_nav_menu( array( 'menu' => $menu_id ) ); ?></div>
    </div><!-- .navigation-card__main -->
</div><!-- .navigation-card -->
<?php else : ?>
<div class="navigation-card <?=card_colour(); ?>">
<?php if( get_field('menu_image') ) : ?>
    <div class="navigation-card__image" style="background-image: url(<?php $image = get_field('menu_image'); echo($image['sizes']['large']); ?>) !important;"></div>
<?php endif; ?>
    <div class="navigation-card__main">
<?php if( get_field('menu_headline') ) : ?>
        <h2 class="navigation-card__headline"><?php the_field('menu_headline');?></h2>
<?php else : ?>
        <h2 class="navigation-card__headline"><?="Navigation"?></h2>
<?php endif; ?>
        <div class="navigation-card__menu">
<?php
    $children = wp_list_pages( array(
    'title_li' => '',
    'child_of' => my_acf_post_id(),
    'echo'     => 0
    ) );
    if ( $children ) echo $children;
?>
        </div><!-- .navigation-card__menu -->
    </div><!-- .navigation-card__main -->
</div><!-- .navigation-card -->
<?php endif; ?>
