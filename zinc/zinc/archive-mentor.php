<?php get_header(); ?>

  <?php get_template_part('hero'); ?>



<main class="bg-[#F1FBE7] py-25 px-8 md:px-30">
  <h1 class="text-2xl text-center font-extrabold text-[#0A352A]">منتور های زینــک</h1>
  <?php
    // آماده‌سازی کوئری
    $tax_query = [];
    if (!empty($_GET['ms'])) {
      $tax_query[] = [
        'taxonomy' => 'mentor_specialty',
        'field'    => 'term_id',
        'terms'    => intval($_GET['ms']),
      ];
    }

    $args = [
      'post_type'      => 'mentor',
      'posts_per_page' => 9,
      'paged'          => max(1, get_query_var('paged')),
    ];
    if (!empty($tax_query)) {
      $args['tax_query'] = $tax_query;
    }

    $q = new WP_Query($args);
  ?>

  <!-- گرید منتورها -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-20 gap-x-40 justify-items-stretch mt-10">
    <?php if ($q->have_posts()): ?>
      <?php while($q->have_posts()): $q->the_post(); ?>
        <?php
          $photo = get_field('profile_photo'); // فیلد ACF عکس
          $img_src = '';
          if ($photo) {
            if (is_array($photo)) {
              $img_src = !empty($photo['sizes']['medium']) ? $photo['sizes']['medium'] : $photo['url'];
            } elseif (is_numeric($photo)) {
              $img_src = wp_get_attachment_image_url($photo, 'medium');
            } else {
              $img_src = esc_url($photo);
            }
          }
          $job_en = get_field('job_title'); // سمت انگلیسی
        ?>

        <article class="bg-[#F1FBE7] w-full h-80 rounded-[50px] shadow-[0_4px_18px_0_rgba(0,0,0,0.25)] p-6 flex flex-col items-center justify-center text-center">
          <a href="<?php the_permalink(); ?>" class="flex-col flex items-center w-full">
            <div class="w-28 h-32 rounded-[50%] shadow-[0_4px_22px_5px_rgba(0,0,0,0.25)] bg-[#F1FBE7] flex items-center justify-center mb-10 overflow-hidden">
              <?php if ($img_src): ?>
                <img src="<?php echo esc_url($img_src); ?>" alt="<?php the_title_attribute(); ?>" class="w-24 h-24 object-cover rounded-full">
              <?php else: ?>
                <div class="w-24 h-24 rounded-full bg-gray-100"></div>
              <?php endif; ?>
            </div>

            <h3 class="text-[#0A352A] font-extrabold text-lg leading-6 mb-2"><?php the_title(); ?></h3>

            <?php if ($job_en): ?>
              <p class="text-sm text-[#0A352A] mt-1"><?php echo esc_html($job_en); ?></p>
            <?php endif; ?>
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
      <p class="col-span-full text-center text-gray-600 mt-8">موردی یافت نشد.</p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>