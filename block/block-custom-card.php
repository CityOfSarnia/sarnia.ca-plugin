<?php
/**
 * Block Name: Custom Card
 *
 * This is the template that displays the custom card block.
 */
?>

<?php if( get_field('custom_card_headline') ) { ?>

  <a href="<?php the_field('custom_card_cta_url');?>" class="custom-card <?=(function_exists('card_colour') ? card_colour() : 'card--blue'); ?>">

    <?php if( get_field('custom_card_image') ) { ?>

      <?php if( get_field('custom_card_image_size') ) { ?>

        <div class="card__image card__image--portrait" style="background-image: url('<?php $image = get_field('custom_card_image'); echo($image['sizes']['large']); ?>')" alt="<?php the_field('custom_card_headline');?>"></div>

      <?php } else { ?>

        <div class="card__image" style="background-image: url('<?php $image = get_field('custom_card_image'); echo($image['sizes']['large']); ?>')" alt="<?php the_field('custom_card_headline');?>"></div>

      <?php } ?>

    <?php } ?>
		
    <div class="card__main">

      <?php if( get_field('custom_card_headline') ) { ?>

        <h2 class="card__headline">
          <?php the_field('custom_card_headline');?>
        </h2>

      <?php } ?>

      <?php if( get_field('custom_card_text') ) { ?>

        <div class="card__text"><?php the_field('custom_card_text');?></div>

      <?php } ?>

      <?php if( get_field('custom_card_cta_url') ) { ?>

        <div class="card__cta"><div class="btn btn--sm"><?php the_field('custom_card_cta_text');?></div></div>
      
      <?php } ?>

    </div>
  
  </a>

<?php } else { ?>

  <p>Create a custom card...</p>

<?php } ?>
