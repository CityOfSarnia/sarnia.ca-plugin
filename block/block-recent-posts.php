<?php
/**
 * Block Name: Recent Posts
 *
 * This is the template that displays the recent posts block.
 */
?>

<?php if( get_field('recent_posts_category') ) { ?>

  <?php $align_class = $block['align'] ? 'align' . $block['align'] : ''; ?>

  <div class="news-card <?=card_colour(); ?> <?php echo $align_class; ?>">

    <?php if( get_field('recent_posts_image') ) { ?>

      <div class="news-card__image" style="background-image: url(<?php $image = get_field('recent_posts_image'); echo($image['sizes']['large']); ?>) !important;"></div>

    <?php } ?>

    <div class="news-card__main">

      <?php $cat_id = get_field('recent_posts_category'); ?>
      <?php $catName = get_cat_name( $cat_id ) ?>

      <?php if( get_field('recent_posts_headline') ) { ?>

        <h2 class="news-card__headline"><?php the_field('recent_posts_headline');?></h2>

      <?php } else { ?>

        <h2 class="news-card__headline"><?php echo $catName; ?></h2>

      <?php } ?>

      <?php $loop = new WP_Query( array( 'post_type' => 'post', 'cat' => $cat_id, 'posts_per_page' => 3 ) ); ?>

      <ul class="news-card-list">
          
        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

          <li class="news-card-list__item">

            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

            <?php the_excerpt(); ?>

          </li>

        <?php endwhile; ?>

      </ul>

      <?php wp_reset_query(); ?>

    </div>

  </div>

<?php } else { ?>

  <p>Select a post category...</p>

<?php } ?>