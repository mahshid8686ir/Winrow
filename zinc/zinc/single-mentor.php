<?php get_header(); the_post(); ?>

<main class="bg-[#F1FBE7] py-12 md:px-30">

  <div class="max-w-4xl mx-auto bg-[#F1FBE7] shadow-lg rounded-2xl p-8">

    <!-- تصویر + عنوان + شغل -->
    <header class="flex flex-col items-center text-center">
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
  ?>

  <?php if (!empty($img_src)): ?>
    <img src="<?php echo esc_url($img_src); ?>" 
         alt="<?php the_title_attribute(); ?>" 
         class="w-32 h-32 rounded-full object-cover mb-4">
  <?php else: ?>
    <div class="w-32 h-32 rounded-full bg-gray-200 mb-4"></div>
  <?php endif; ?>

  <h1 class="text-3xl font-bold text-[#155546]"><?php the_title(); ?></h1>

  <?php if ($job = get_field('job_title')): ?>
    <p class="text-lg text-gray-600 mt-2"><?php echo esc_html($job); ?></p>
  <?php endif; ?>
</header>

    <!-- بیو -->
    <section class="mt-8 prose prose-lg max-w-none text-gray-800">
      <?php the_content(); ?>
    </section>

    <!-- دوره‌های این منتور -->
    <section class="mt-12">
      <h2 class="text-2xl font-extrabold text-[#0A352A] mb-8 text-center">دوره‌های این منتور</h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 justify-items-center">

        <?php
        // کوئری دوره‌ها که شامل این منتور هستن
       $courses = new WP_Query([
  'post_type' => 'course',
  'posts_per_page' => -1,
  'meta_query' => [
    'relation' => 'OR',
    [
      'key'     => 'teacher',
      'value'   => get_the_ID(),
      'compare' => '='
    ],
    [
      'key'     => 'teacher',
      'value'   => '"' . get_the_ID() . '"',
      'compare' => 'LIKE'
    ],
  ],
]);

        if ($courses->have_posts()):
          while ($courses->have_posts()): $courses->the_post(); ?>

            <article class="bg-[#F1FBE7] w-60 h-80 rounded-[50px] shadow-[0_10px_10px_0_rgba(0,0,0,0.25)] p-4 flex flex-col items-center justify-center text-center transition-transform duration-300 hover:scale-105">
              <a href="<?php the_permalink(); ?>" class="flex flex-col items-center w-full">
                
                <!-- عکس دوره -->
                <?php
                $course_img = get_field('course_image');
                $img_src = '';
                if ($course_img) {
                  if (is_array($course_img)) {
                    $img_src = !empty($course_img['sizes']['medium']) ? $course_img['sizes']['medium'] : $course_img['url'];
                  } elseif (is_numeric($course_img)) {
                    $img_src = wp_get_attachment_image_url($course_img, 'medium');
                  } else {
                    $img_src = esc_url($course_img);
                  }
                }
                ?>
                <div class="w-32 h-32 rounded-full shadow-[0_4px_15px_2px_rgba(0,0,0,0.25)] mb-4 overflow-hidden">
                  <?php if ($img_src): ?>
                    <img src="<?php echo esc_url($img_src); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover rounded-full">
                  <?php else: ?>
                    <div class="w-full h-full bg-gray-100 rounded-full"></div>
                  <?php endif; ?>
                </div>

                <!-- نام دوره -->
                <h3 class="text-[#0A352A] font-extrabold text-lg"><?php the_title(); ?></h3>

                <!-- قیمت و سطح -->
                <p class="text-sm text-gray-600 mt-1">
                  <?php if ($price = get_field('price')): ?>
                    قیمت: <?php echo number_format_i18n($price); ?> تومان
                  <?php endif; ?>
                </p>
                <p class="text-sm text-gray-600">
                  <?php echo get_the_term_list(get_the_ID(), 'course_level', 'سطح: ', ', '); ?>
                </p>

              </a>
            </article>

          <?php endwhile; wp_reset_postdata();
        else:
          echo '<p class="text-gray-600 text-center">هنوز دوره‌ای ثبت نشده است.</p>';
        endif; ?>

      </div>
    </section>

  </div>
</main>

<?php get_footer(); ?>
