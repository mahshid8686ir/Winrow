<?php get_header(); ?>

<?php get_template_part('hero'); ?>

<main class="bg-[#F1FBE7] py-25 px-8 md:px-40">
  <h1 class="text-2xl text-center font-extrabold text-[#0A352A]">آموزش های زینــک</h1>

  <?php
    // آماده‌سازی کوئری با فیلتر دسته‌بندی
    $tax_query = [];
    if (!empty($_GET['cc'])) {
      $tax_query[] = [
        'taxonomy' => 'course_category',
        'field'    => 'term_id',
        'terms'    => intval($_GET['cc']),
      ];
    }

    $args = [
      'post_type'      => 'course',
      'posts_per_page' => 9,
      'paged'          => max(1, get_query_var('paged')),
    ];
    if (!empty($tax_query)) {
      $args['tax_query'] = $tax_query;
    }

    $q = new WP_Query($args);
  ?>

  <!-- گرید دوره‌ها -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-20 gap-x-30 justify-items-stretch mt-10">
    <?php if ($q->have_posts()): ?>
      <?php while($q->have_posts()): $q->the_post(); ?>
        <?php
          $course_image = get_field('course_image');
          $teacher      = get_field('teacher'); // Post Object به منتور
          $price        = get_field('price');
          $level        = get_field('level');

          $img_src = '';
          if ($course_image) {
            if (is_array($course_image)) {
              $img_src = !empty($course_image['sizes']['medium']) ? $course_image['sizes']['medium'] : $course_image['url'];
            } elseif (is_numeric($course_image)) {
              $img_src = wp_get_attachment_image_url($course_image, 'medium');
            } else {
              $img_src = esc_url($course_image);
            }
          }
        ?>

        <article class="bg-[#F1FBE7] w-full h-80 rounded-[50px] shadow-[0_10px_10px_0_rgba(0,0,0,0.25)] p-6 flex flex-col items-center justify-center text-center transition-transform duration-300 hover:scale-105">
          <a href="<?php the_permalink(); ?>" class="flex-col flex items-center w-full">

            <!-- عکس دوره -->
            <div class="w-30 h-30 rounded-[50%] shadow-[0_4px_15px_2px_rgba(0,0,0,0.25)] bg-[#F1FBE7] flex items-center justify-center mb-10 overflow-hidden">
              <?php if ($img_src): ?>
                <img src="<?php echo esc_url($img_src); ?>" alt="<?php the_title_attribute(); ?>" class="w-24 h-24 object-cover rounded-full">
              <?php else: ?>
                <div class="w-24 h-24 rounded-full bg-gray-100"></div>
              <?php endif; ?>
            </div>

            <!-- عنوان دوره -->
            <h3 class="text-[#0A352A] font-extrabold text-2xl leading-6 mb-2"><?php the_title(); ?></h3>

            <!-- سطح دوره -->
            <?php if ($level): ?>
              <p class="text-sm text-[#0A352A]">سطح: <?php echo esc_html($level); ?></p>
            <?php endif; ?>

            <!-- قیمت -->
            <?php if ($price): ?>
              <p class="text-sm text-[#0A352A]">قیمت: <?php echo number_format($price); ?> تومان</p>
            <?php endif; ?>
            
            <!-- مدرس -->
            <?php if ($teacher): ?>
              <div class="mt-2 text-sm text-[#155546]">
                مدرس: 
                <a href="<?php echo esc_url(get_permalink($teacher->ID)); ?>" class="hover:underline">
                  <?php echo esc_html(get_the_title($teacher->ID)); ?>
                </a>
              </div>
            <?php endif; ?>

          </a>
          <?php if ( is_user_logged_in() ) : ?>
  <form method="post" class="mt-4 mb-8">
    <?php wp_nonce_field('register_course_action', 'register_course_nonce'); ?>
    <input type="hidden" name="course_id" value="<?php the_ID(); ?>">
    <button type="submit" class="bg-[#FA9D30] text-white px-5 py-2 rounded-xl hover:bg-[#155546] transition">
      ثبت‌نام در دوره
    </button>
  </form>
<?php endif; ?>

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

<div class="bg-[#E9F9D8] flex items-center justify-between flex-col py-20 px-30">
  <div class="text">
    <div class="font-semibold text-3xl mb-5 text-[#155546]">قبل از هرکاری، عضو همیشگی زینــک شو!</div>  
  </div>
  <div id="steps-section" class="w-full mt-8 flex justify-around opacity-0">
  <div class="flex gap-2 step-item opacity-0 translate-x-6 transition duration-700">
    <div class="w-5 h-5 bg-[#FA9D30] rounded-full"></div>
    <div class="font-normal text-lg text-[#155546] max-w-50">دوره آموزشی مورد نیازتو انتخاب کن.</div>
  </div>
  <div class="flex gap-2 step-item opacity-0 translate-x-6 transition duration-700">
    <div class="w-5 h-5 bg-[#FA9D30] rounded-full"></div>
    <div class="font-normal text-lg text-[#155546] max-w-50">یادگیری رو شروع کن.</div>
  </div>
  <div class="flex gap-2 step-item opacity-0 translate-x-6 transition duration-700">
    <div class="w-5 h-5 bg-[#FA9D30] rounded-full"></div>
    <div class="font-normal text-lg text-[#155546] max-w-50">امتیاز بگیر، گواهی‌نامه بگیر، بیزینس خودتو شروع کن.</div>
  </div>
</div>
    <a href="http://winrow.hodecode.ir/register/">
      <button class="mt-16 text-2xl inline-block bg-[#FA9D30] text-white px-7 py-5 rounded-full font-normal hover:bg-orange-500">میخوام زینــکی بشم:)</button>
    </a>

</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const section = document.querySelector("#steps-section");
  const items = document.querySelectorAll(".step-item");

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // یکی یکی با تأخیر ظاهر بشن
        items.forEach((item, index) => {
          setTimeout(() => {
            item.classList.remove("opacity-0", "translate-x-6");
          }, index * 300);
        });
        section.classList.remove("opacity-0");
        observer.unobserve(section); // فقط یک بار اجرا بشه
      }
    });
  }, { threshold: 0.3 });

  if (section) {
    observer.observe(section);
  }
});
</script>

<?php get_footer(); ?>
