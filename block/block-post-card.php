<?php
/**
 * Block Name: Post Card
 *
 * This is the template that displays the post card block.
 */
?>

<?php

$post_object = get_field('post_card');
if( $post_object ) {
  
$post = $post_object;
setup_postdata( $post );
?>

<a href="<?php the_permalink($post->ID); ?>" class="post-card <?=(function_exists('card_colour') ? card_colour() : 'card--blue'); ?>">

  <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'card' );?>

  <?php if ( has_post_thumbnail($post->ID) ) { ?>

    <div class="card__image" style="background-image: url('<?php echo $thumb['0'];?>')"></div>

  <?php } ?>

  <div class="card__main">

    <h2 class="card__headline"><?php echo get_the_title($post->ID); ?></h2>

    <p class="card__text"><?php echo get_the_excerpt($post->ID); ?></p>

    <div class="card__cta"><div class="btn btn--sm">Learn More</div></div>

  </div>

</a>

<?php wp_reset_postdata(); ?>

<?php } else { ?>

  <p>Select a post...</p>

<?php } ?>
