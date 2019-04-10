<?php
/**
 * Block Name: Navigation
 *
 * This is the template that displays the navigation block.
 */
?>

<?php if( get_field('menu') ) { ?>

  <div class="navigation-card <?=(function_exists('card_colour') ? card_colour() : 'card--blue'); ?>">

    <?php if( get_field('menu_image') ) { ?>

      <div class="navigation-card__image" style="background-image: url(<?php $image = get_field('menu_image'); echo($image['sizes']['large']); ?>) !important;"></div>

    <?php } ?>

    <div class="navigation-card__main">

      <?php
        $menu_id = get_field('menu');
        $menuObj = wp_get_nav_menu_object($menu_id);
        $menu_name = $menuObj->name;
      ?>

      <?php if( get_field('menu_headline') ) { ?>

        <h2 class="navigation-card__headline"><?php the_field('menu_headline');?></h2>

      <?php } else { ?>

        <h2 class="navigation-card__headline"><?php echo $menu_name ?></h2>

      <?php } ?>

      <div class="navigation-card__menu"><?php wp_nav_menu( array( 'menu' => $menu_id ) ); ?></div>

    </div>

  </div>

<?php } else { ?>

  <p>Select a menu...</p>

<?php } ?>
