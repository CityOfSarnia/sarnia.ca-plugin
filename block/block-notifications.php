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
          <a href="https://member.everbridge.net/index/892807736721815#/login" target="_blank" rel="noopener" class="btn btn--outline">Subscribe</a>
        </div>

        <!-- Recent Notification Query for Headers and screen readers -->
        <?php $count = 0; ?>
        <?php $loop = new WP_Query( array( 'post_type' => 'notifications', 'filter' => 'sticky', 'posts_per_page' => 3 ) ); ?>
        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
          <?php
            $terms = get_the_terms( $loop->ID, 'notification-icon' );
            if ($terms) {
              $terms_slugs = array();
              foreach ( $terms as $term ) {
                  $terms_slugs[] = $term->slug;
              }
              $icon = $terms_slugs[0];
            } else {
              $icon = 'default-notification';
            }
            $post_id = get_the_ID();
          ?>
          <a href="/notifications" class="recent-notification-list__item">
            <div class="recent-notification__icon"><?php include(TEMPLATEPATH . '/assets/img/icons/' . $icon . '.svg'); ?></div>
            <div class="recent-notification__header">
              <div class="recent-notification__headline"><?php the_title(); ?></div>
              <p class="recent-notification__date"><?php the_field('notification_date', $post_id); ?></p>
            </div>
            <p class="recent-notification__text hidden"><?php echo get_the_excerpt(); ?></p>
          </a>
          <?php $count++ ?>
        <?php endwhile; ?>

        <?php if ( $count < 3 ) { ?>
          <?php $num = 3 - $count; ?>
          <?php
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
          ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <?php
              $terms = get_the_terms( $loop->ID, 'notification-icon' );
              if ($terms) {
                $terms_slugs = array();
                foreach ( $terms as $term ) {
                    $terms_slugs[] = $term->slug;
                }
                $icon = $terms_slugs[0];
              } else {
                $icon = 'default-notification';
              }
              $post_id = get_the_ID();
            ?>
            <a href="/notifications" class="recent-notification-list__item">
              <div class="recent-notification__icon"><?php include(TEMPLATEPATH . '/assets/img/icons/' . $icon . '.svg'); ?></div>
              <div class="recent-notification__header">
                <div class="recent-notification__headline"><?php the_title(); ?></div>
                <p class="recent-notification__date"><?php the_field('notification_date', $post_id); ?></p>
              </div>
              <p class="recent-notification__text hidden"><?php echo get_the_excerpt(); ?></p>
            </a>
          <?php endwhile; ?>
        <?php } ?>
        <?php wp_reset_query(); ?>
        <div class="recent-notification-list__item">
          <a href="/notifications" class="btn btn--outline">More</a>
        </div>
      </div>
    </div>

    <div class="recent-notification-list--bottom" aria-hidden="true">
      <div class="container recent-notification-list ">
        <div class="recent-notification-list__item recent-notification-list--collapse"></div>

        <!-- Recent Notification Query for Expert Only -->
        <?php $count = 0; ?>
        <?php $loop = new WP_Query( array( 'post_type' => 'notifications', 'filter' => 'sticky', 'posts_per_page' => 3 ) ); ?>
        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
          <a href="/notifications" class="recent-notification-list__item">
            <p class="recent-notification__text"><?php echo get_the_excerpt(); ?></p>
          </a>
          <?php $count++ ?>
        <?php endwhile; ?>

        <?php if ( $count < 3 ) { ?>
          <?php $num = 3 - $count; ?>
          <?php
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
          ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <a href="/notifications" class="recent-notification-list__item">
              <p class="recent-notification__text"><?php echo get_the_excerpt(); ?></p>
            </a>
          <?php endwhile; ?>
        <?php } ?>
        <?php wp_reset_query(); ?>

        <div class="recent-notification-list__item"></div>
      </div>
    </div>
</div>
