<?php get_header(); ?>
<?php get_template_part('hero'); ?>
<!-- <main class="container">
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <article <?php post_class(); ?>>
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
    </article>
  <?php endwhile; else: ?>
    <p><?php _e('No content yet.', 'zink'); ?></p>
  <?php endif; ?>
</main> -->
<?php get_footer(); ?>
