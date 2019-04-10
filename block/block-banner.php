<?php
/**
 * Block Name: Banner
 *
 * This is the template that displays the banner block.
 */
?>

<div class="banner" style="background-image: url(<?php $image = get_field('banner_image'); echo($image['sizes']['home-banner']); ?>) !important;">
		
  <header class="banner__header">

    <h1>

      <?php if( get_field('banner_byline') ) { ?>

        <div class="banner__byline"><?php the_field('banner_byline');?></div>

      <?php } ?>

      <?php if( get_field('banner_headline') ) { ?>

        <div class="banner__headline"><?php the_field('banner_headline');?></div>

      <?php } else { ?>

        <?php if ( ! is_admin() ) { ?>

          <div class="banner__headline"><?php the_title(); ?></div>

        <?php } else { ?>

          <div class="banner__headline">Enter a title...</div>

        <?php } ?>

      <?php } ?>

    </h1>

    <?php if( get_field('banner_cta_url') ) { ?>

      <a href="<?php the_field('banner_cta_url');?>" class="btn banner__cta"><?php the_field('banner_cta_text');?></a>

    <?php } ?>

  </header>

</div>