<article class="mentor-card">
  <a href="<?php the_permalink(); ?>">
    <?php if (has_post_thumbnail()) the_post_thumbnail('mentor_card'); ?>
    <h3><?php the_title(); ?></h3>
    <?php if ( $job = get_field('job_title') ) : ?>
      <p class="job"><?php echo esc_html($job); ?></p>
    <?php endif; ?>
  </a>
</article>
