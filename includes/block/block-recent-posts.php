<?php
/**
 * Block Name: Recent Posts
 *
 * This is the template that displays the recent posts block.
 */
?>

<?php
if (get_field('recent_posts_category')) :
    $align_class = $block['align'] ? 'align' . $block['align'] : '';
?>
<div class="news-card <?= card_colour(); ?> <?= $align_class; ?>">
<?php if (get_field('recent_posts_image')) : ?>
    <div class="news-card__image" style="background-image: url(<?php $image = get_field('recent_posts_image'); echo ($image['sizes']['large']); ?>) !important;"></div>
<?php endif; ?>
    <div class="news-card__main">
<?php
    $cat_id = get_field('recent_posts_category');
    $catName = get_cat_name($cat_id);
    if (get_field('recent_posts_headline')) :
?>
        <h2 class="news-card__headline"><?php the_field('recent_posts_headline'); ?></h2>
<?php else : ?>
        <h2 class="news-card__headline"><?= $catName; ?></h2>
<?php 
    endif;
    $post_count = (get_field('recent_posts_count') ? get_field('recent_posts_count') : 3);
    $loop = new WP_Query(array('post_type' => 'post', 'cat' => $cat_id, 'posts_per_page' => $post_count));
?>
        <ul class="news-card-list">
<?php while ($loop->have_posts()) : $loop->the_post(); ?>
            <li class="news-card-list__item">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
<?php the_excerpt(); ?>
            </li><!-- .news-card-list__item -->
<?php endwhile; ?>
        </ul><!-- .news-card-list -->
<?php wp_reset_query(); ?>
    </div><!-- .news-card__main -->
</div><!-- .news-card -->
<?php else : ?>
<p>Select a post category&hellip;</p>
<?php endif; ?>
