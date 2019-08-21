<?php
/**
 * Block Name: Accordion
 *
 * This is the template that displays the accordion block.
 */
?>

<?php if (get_field('accordion_heading_text') &&  get_field('accordion_content')) : ?>
<article class="accordion js-accordion__toggle">
    <header class="accordion__header">
<?php $accordion_heading_level = (get_field('accordion_heading_level') ? get_field('accordion_heading_level') : 'h2'); ?>
        <h2 class="accordion__headline"><?php the_field('accordion_heading_text'); ?></h2>
        <div class="accordion__toggle"></div>
    </header><!-- .accordion__header -->
    <div class="accordion__content">
<?php the_field('accordion_content'); ?>
    </div><!-- .accordion__content -->
</article><!-- .accordion js-accordion__toggle -->
<?php else : ?>
<p>Create an accordion&hellip;</p>
<?php endif; ?>
