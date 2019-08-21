<?php

/**
 * Block Name: Notifications
 *
 * This is the template that displays the notifications block.
 */
?>

<div class="recent-notifications">
    <div class="recent-notification-list--top">
        <div class="container recent-notification-list">
            <div class="recent-notification-list__item recent-notification-list--collapse">
<?php if ($signup_option = get_field('signup', 'option')) : ?>
                <a href="<?= $signup_option ?>" target="_blank" rel="noopener" class="btn btn--outline">Subscribe</a>
<?php else : ?>
                <a href="<?= '/feed/?post_type=notifications'; ?>" target="_blank" rel="noopener" class="btn btn--outline">RSS Feed</a>
<? endif; ?>
            </div><!-- .recent-notification-list__item.recent-notification-list--collapse -->
            <!-- Recent Notification Query for Headers and screen readers -->
<?php
$count = 0;
$loop = new WP_Query(array('post_type' => 'notifications', 'filter' => 'sticky', 'posts_per_page' => 3));
while ($loop->have_posts()) : $loop->the_post();
    $terms = get_the_terms($loop->ID, 'notification-icon');
    if ($terms) :
        $terms_slugs = array();
        foreach ($terms as $term) :
            $terms_slugs[] = $term->slug;
        endforeach;
        $icon = $terms_slugs[0];
    else :
        $icon = 'default-notification';
    endif;
    $post_id = get_the_ID();
?>
            <a href="<?= get_permalink(); ?>" id="post-<?php the_ID();?>" class="recent-notification-list__item">
                <div class="recent-notification__icon">
<?php get_template_part('/assets/img/icons/notifications/inline', $icon . '.svg'); ?>
                </div><!-- .recent-notification__icon -->
                <div class="recent-notification__header">
                    <div class="recent-notification__headline"><?php the_title(); ?></div>
                    <p class="recent-notification__date"><?php the_field('notification_date', $post_id); ?></p>
                </div><!-- .recent-notification__header -->
                <p class="recent-notification__text hidden"><?= get_the_excerpt(); ?></p>
            </a><!-- #post-<?php the_ID();?> -->
<?php
    $count++;
endwhile;
if ($count < 3) :
    $num = 3 - $count;
    $loop = new WP_Query(
        array(
            'post_type'      => 'notifications',
            'posts_per_page' => $num,
            'tax_query'      => array(
                array(
                    'taxonomy'  => 'filter',
                    'field'     => 'slug',
                    'terms'     => array('sticky', 'feature'),
                    'operator'  => 'NOT IN'
                )
            ),
        )
    );
    while ($loop->have_posts()) : $loop->the_post();
        $terms = get_the_terms($loop->ID, 'notification-icon');
        if ($terms):
            $terms_slugs = array();
            foreach ($terms as $term) :
                $terms_slugs[] = $term->slug;
            endforeach;
            $icon = $terms_slugs[0];
        else:
            $icon = 'default-notification';
        endif;
        $post_id = get_the_ID();
?>
            <a href="<?= get_permalink(); ?>" id="post-<?php the_ID();?>" class="recent-notification-list__item">
                <div class="recent-notification__icon">
<?php get_template_part('/assets/img/icons/notifications/inline', $icon . '.svg'); ?></div>
                <div class="recent-notification__header">
                    <div class="recent-notification__headline"><?php the_title(); ?></div>
                    <p class="recent-notification__date"><?php the_field('notification_date', $post_id); ?></p>
                </div><!-- .recent-notification__header -->
                <p class="recent-notification__text hidden"><?= get_the_excerpt(); ?></p>
            </a><!-- #post-<?php the_ID();?> -->
<?php
    endwhile;
endif;
wp_reset_query(); 
?>
            <div class="recent-notification-list__item">
<?php if ($notifications_page_option = get_field('notifications_page', 'option')) : ?>
                <a href="<?= $notifications_page_option; ?>" class="btn btn--outline">More</a>
<?php else : ?>
                <a href="/notifications" class="btn btn--outline">More</a>
<?php endif; ?>
            </div><!-- .recent-notification-list__item -->
        </div><!-- .container recent-notification-list -->
    </div><!-- .recent-notification-list--top -->

    <div class="recent-notification-list--bottom" aria-hidden="true">
        <div class="container recent-notification-list">
            <div class="recent-notification-list__item recent-notification-list--collapse"></div>
            <!-- Recent Notification Query for Expert Only -->
<?php
$count = 0;
$loop = new WP_Query(array('post_type' => 'notifications', 'filter' => 'sticky', 'posts_per_page' => 3));
while ($loop->have_posts()) : $loop->the_post(); 
?>
            <a id="post-<?php the_ID();?>" href="<?= get_permalink(); ?>" class="recent-notification-list__item">
                <p class="recent-notification__text"><?= get_the_excerpt(); ?></p>
            </a><!-- #post-<?php the_ID();?> -->
<?php 
    $count++;
endwhile;
if ($count < 3) :
    $num = 3 - $count;

    $loop = new WP_Query(
        array(
            'post_type'  => 'notifications',
            'posts_per_page' => $num,
            'tax_query' => array(
                array(
                    'taxonomy'  => 'filter',
                    'field'     => 'slug',
                    'terms'     => array('sticky', 'feature'),
                    'operator'  => 'NOT IN'
                )
            ),
        )
    );
    while ($loop->have_posts()) : $loop->the_post(); 
?>
            <a href="<?= get_permalink(); ?>" id="post-<?php the_ID();?>" class="recent-notification-list__item">
                <p class="recent-notification__text"><?= get_the_excerpt(); ?></p>
            </a><!-- #post-<?php the_ID();?> -->
<?php
    endwhile;
endif;
wp_reset_query();
?>
            <div class="recent-notification-list__item recent-notification-list--collapse"></div>
        </div><!-- .container recent-notification-list -->
    </div><!-- .recent-notification-list--bottom -->
</div><!-- .recent-notifications -->