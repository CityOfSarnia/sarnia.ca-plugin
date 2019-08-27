<?php
/**
 * Block Name: Post Card
 *
 * This is the template that displays the post card block.
 */
?>

<?php

if ($post = get_field('post_card')) :
    setup_postdata($post);
?>
<a href="<?php the_permalink($post->ID); ?>" class="post-card <?= card_colour(); ?>">
<?php 
    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'card');
    if (has_post_thumbnail($post->ID)) :
?>
    <div class="card__image" style="background-image: url('<?= $thumb['0']; ?>')"></div>
<?php endif; ?>
    <div class="card__main">
        <h2 class="card__headline"><?= get_the_title($post->ID); ?></h2>
        <p class="card__text"><?= get_the_excerpt($post->ID); ?></p>
        <div class="card__cta">
            <div class="btn btn--sm">Learn More</div>
        </div><!-- .card__cta -->
    </div><!-- .card__main -->
</a><!-- .post-card -->
<?php wp_reset_postdata(); ?>
<?php else : ?>
<p>Select a post&hellip;</p>
<?php endif; ?>
