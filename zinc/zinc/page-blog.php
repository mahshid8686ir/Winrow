<?php get_header(); ?>

  <?php get_template_part('hero'); ?>
<main class="bg-[#F1FBE7] py-25 px-8 md:px-40">
  <h1 class="text-2xl text-center font-extrabold text-[#0A352A]">مقالات اخیــر</h1>
  <?php
    // آماده‌سازی کوئری
    $args = [
      'post_type'      => 'post',
      'posts_per_page' => 9,
      'paged'          => max(1, get_query_var('paged')),
    ];

    $q = new WP_Query($args);
  ?>

  <!-- گرید نوشته‌ها -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-20 gap-x-30 justify-items-stretch mt-10">
    <?php if ($q->have_posts()): ?>
      <?php while($q->have_posts()): $q->the_post(); ?>
        <?php
          // تصویر شاخص نوشته
          if (has_post_thumbnail()) {
            $img_src = get_the_post_thumbnail_url(get_the_ID(), 'medium');
          } else {
            $img_src = '';
          }
        ?>

        <article class="bg-[#F1FBE7] w-full h-[420px] rounded-[30px] shadow-[0_10px_10px_0_rgba(0,0,0,0.15)] p-6 flex flex-col justify-between text-center transition-transform duration-300 hover:scale-105">
          <a href="<?php the_permalink(); ?>" class="flex flex-col items-center w-full">
            <div class="w-full h-40 rounded-2xl overflow-hidden mb-6 shadow-[0_4px_15px_2px_rgba(0,0,0,0.1)]">
              <?php if ($img_src): ?>
                <img src="<?php echo esc_url($img_src); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
              <?php else: ?>
                <div class="w-full h-full bg-gray-100"></div>
              <?php endif; ?>
            </div>

            <h3 class="text-[#0A352A] font-extrabold text-xl leading-6 mb-2 line-clamp-2"><?php the_title(); ?></h3>
            
            <p class="text-sm text-[#0A352A] mt-2 line-clamp-3"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
          </a>

          <a href="<?php the_permalink(); ?>" 
            class="mt-4 inline-block bg-[#FA9D30] text-white px-5 py-2 shadow-[0_4px_15px_2px_rgba(0,0,0,0.25)] rounded-xl hover:bg-[#155546] transition-colors duration-300">
            ادامه مطلب
          </a>
        </article>
      
      <?php endwhile; ?>

      <!-- pagination -->
      <div class="col-span-full flex justify-center mt-6">
        <?php
          echo paginate_links([
            'total'   => $q->max_num_pages,
            'current' => max(1, get_query_var('paged')),
            'prev_text' => '‹',
            'next_text' => '›',
          ]);
        ?>
      </div>

      <?php wp_reset_postdata(); ?>
    <?php else: ?>
      <p class="col-span-full text-center text-gray-600 mt-8">مقاله‌ای یافت نشد.</p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>