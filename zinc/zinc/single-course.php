<?php get_header(); the_post(); ?>

<main class="bg-[#F1FBE7] py-12 md:px-30">

  <div class="max-w-4xl mx-auto bg-[#F1FBE7] shadow-lg rounded-2xl p-8">

    <!-- تصویر + عنوان + اطلاعات کلی -->
    <header class="flex flex-col items-center text-center">
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

      <?php if (!empty($img_src)): ?>
        <img src="<?php echo esc_url($img_src); ?>" 
             alt="<?php the_title_attribute(); ?>" 
             class="w-40 h-40 rounded-full object-cover mb-6 shadow-md">
      <?php else: ?>
        <div class="w-40 h-40 rounded-full bg-gray-200 mb-6"></div>
      <?php endif; ?>

      <h1 class="text-3xl font-bold text-[#155546] mb-4"><?php the_title(); ?></h1>

      <ul class="flex flex-wrap justify-center gap-4 text-gray-700 text-lg">
        <?php if ($price = get_field('price')): ?>
          <li class="bg-white px-5 py-2 rounded-full shadow">💰
            <span class="font-bold"><?php echo number_format_i18n($price); ?> تومان</span>
          </li>
        <?php endif; ?>

        <?php if ($level = get_field('level')): ?>
          <li class="bg-white px-5 py-2 rounded-full shadow">🎯 سطح:
            <span class="font-bold"><?php echo esc_html($level); ?></span>
          </li>
        <?php endif; ?>

        <?php if ($dur = get_field('duration_hours')): ?>
          <li class="bg-white px-5 py-2 rounded-full shadow">⏳ مدت:
            <span class="font-bold"><?php echo intval($dur); ?> ساعت</span>
          </li>
        <?php endif; ?>
      </ul>
    </header>

    <!-- اعلان ثبت نام موفق -->
    <?php if ( isset($_GET['joined']) && $_GET['joined'] == '1' ) : ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl mt-8 text-center font-medium">
        🎉 ثبت‌نام شما در این دوره با موفقیت انجام شد.
      </div>
    <?php endif; ?>

    <!-- محتوای دوره -->
    <section class="mt-10 prose prose-lg max-w-none text-gray-800">
      <?php the_content(); ?>
    </section>

    <!-- مدرس / منتور -->
    <?php if ($teacher = get_field('teacher')): ?>
      <section class="mt-16">
        <h2 class="text-2xl font-extrabold text-[#0A352A] mb-8 text-center">مدرس دوره</h2>

        <div class="flex justify-center">
          <?php
            $photo = get_field('profile_photo', $teacher->ID);
            $mentor_img = '';

            if ($photo) {
              if (is_array($photo)) {
                $mentor_img = !empty($photo['sizes']['medium']) ? $photo['sizes']['medium'] : $photo['url'];
              } elseif (is_numeric($photo)) {
                $mentor_img = wp_get_attachment_image_url($photo, 'medium');
              } else {
                $mentor_img = esc_url($photo);
              }
            }
          ?>
          <article class="bg-white w-72 h-75 rounded-3xl shadow-lg p-8 flex flex-col items-center text-center transition-transform duration-300 hover:-translate-y-2 hover:shadow-2xl">
            <a href="<?php echo get_permalink($teacher->ID); ?>" class="flex-col flex items-center w-full">

              <div class="w-28 h-28 rounded-full shadow-md mb-6 overflow-hidden">
                <?php if ($mentor_img): ?>
                  <img src="<?php echo esc_url($mentor_img); ?>" alt="<?php echo esc_attr(get_the_title($teacher->ID)); ?>" class="w-full h-full object-cover rounded-full">
                <?php else: ?>
                  <div class="w-full h-full bg-gray-100 rounded-full"></div>
                <?php endif; ?>
              </div>

              <h3 class="text-[#0A352A] font-bold text-xl mb-2">
                <?php echo esc_html(get_the_title($teacher->ID)); ?>
              </h3>

              <span class="inline-block mt-4 px-4 py-2 text-sm rounded-full bg-[#FA9D30] text-white hover:bg-orange-500 transition">
                مشاهده پروفایل
              </span>
            </a>
          </article>
        </div>
      </section>
    <?php endif; ?>

    <!-- دکمه ثبت نام -->
    <?php if ( is_user_logged_in() ) : ?>
      <form method="post" class="mt-10 text-center">
        <?php wp_nonce_field('register_course_action', 'register_course_nonce'); ?>
        <input type="hidden" name="course_id" value="<?php the_ID(); ?>">
        <button type="submit" class="bg-[#FA9D30] text-white px-6 py-3 rounded-xl hover:bg-[#155546] transition">
          ثبت‌نام در دوره
        </button>
      </form>
    <?php endif; ?>

  </div>
</main>

<?php get_footer(); ?>
