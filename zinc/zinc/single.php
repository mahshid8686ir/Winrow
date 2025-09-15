<?php get_header(); ?>

<main class="bg-[#F1FBE7] py-25 px-8 md:px-40">
  <?php
  if (have_posts()):
    while (have_posts()): the_post(); ?>
      <article class="max-w-3xl mx-auto bg-[#E9F9D8] p-8 rounded-xl shadow-md">
        
        
        <?php if (has_post_thumbnail()): ?>
          <div class="mb-6">
            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title_attribute(); ?>" class="w-full rounded-xl">
          </div>
        <?php endif; ?>
        <h1 class="text-3xl font-extrabold text-[#0A352A] mb-4"><?php the_title(); ?></h1>
        <div class="prose max-w-full text-[#0A352A]">
          <?php the_content(); ?>
        </div>
      </article>
  <?php
    endwhile;
  endif;
  ?>
</main>

<?php get_footer(); ?>
