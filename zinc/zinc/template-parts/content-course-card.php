<article class="course-card">
  <a href="<?php the_permalink(); ?>">
    <?php if (has_post_thumbnail()) the_post_thumbnail('course_card'); ?>
    <h3><?php the_title(); ?></h3>
    <?php if ( $price = get_field('price') ) : ?>
      <p class="price"><?php echo number_format_i18n($price); ?> تومان</p>
    <?php endif; ?>
  </a>
</article>
