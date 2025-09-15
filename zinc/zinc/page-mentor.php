<?php get_header(); ?>

  <?php get_template_part('hero'); ?>



<main class="bg-[#F1FBE7] py-25 px-8 md:px-40" id="mentoring">
  <h1 class="text-2xl text-center font-extrabold text-[#0A352A]">منتور های زینـکی</h1>
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
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-20 gap-x-30 justify-items-stretch mt-10">
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

        <article class="bg-[#F1FBE7] w-full h-80 rounded-[50px] shadow-[0_10px_10px_0_rgba(0,0,0,0.25)] p-6 flex flex-col items-center justify-center text-center transition-transform duration-300 hover:scale-105">
          <a href="<?php the_permalink(); ?>" class="flex-col flex items-center w-full">
            <div class="w-30 h-30 rounded-[50%] shadow-[0_4px_15px_2px_rgba(0,0,0,0.25)] bg-[#F1FBE7] flex items-center justify-center mb-10 overflow-hidden">
              <?php if ($img_src): ?>
                <img src="<?php echo esc_url($img_src); ?>" alt="<?php the_title_attribute(); ?>" class="w-24 h-24 object-cover rounded-full">
              <?php else: ?>
                <div class="w-24 h-24 rounded-full bg-gray-100"></div>
              <?php endif; ?>
            </div>

            <h3 class="text-[#0A352A] font-extrabold text-2xl leading-6 mb-2"><?php the_title(); ?></h3>

            <?php if ($job_en): ?>
              <p class="text-sm text-[#0A352A] mt-1"><?php echo esc_html($job_en); ?></p>
            <?php endif; ?>
          </a>
          <a href="<?php the_permalink(); ?>" 
            class="mt-4 inline-block bg-[#FA9D30] text-white px-5 py-2 shadow-[0_4px_15px_2px_rgba(0,0,0,0.25)] rounded-xl hover:bg-[#155546] transition-colors duration-300">
            مشاهده پروفایل
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

  <div class="bg-[#E9F9D8] flex items-center justify-between flex-col py-20 px-30">
    <div class="text">
      <div class="font-semibold text-3xl text-[#155546]">چرا منتــور؟!</div>  
    </div>
    <div id="mentor-steps" class="w-full mt-8 flex justify-around opacity-0">
  <div class="flex gap-2 step-item opacity-0 translate-x-6 transition duration-700">
    <div class="w-5 h-5 bg-[#FA9D30] rounded-full"></div>
    <div class="font-normal text-lg text-[#155546] max-w-50">به منتورت در حوزه موردنظرت، درخواست بفرست.</div>
  </div>
  <div class="flex gap-2 step-item opacity-0 translate-x-6 transition duration-700">
    <div class="w-5 h-5 bg-[#FA9D30] rounded-full"></div>
    <div class="font-normal text-lg text-[#155546] max-w-50">به منتورت متصل شو.</div>
  </div>
  <div class="flex gap-2 step-item opacity-0 translate-x-6 transition duration-700">
    <div class="w-5 h-5 bg-[#FA9D30] rounded-full"></div>
    <div class="font-normal text-lg text-[#155546] max-w-50">مشاوره و جلسات صحبت رو با منتورت شروع کن و از تجربیاتشون بپرس.</div>
  </div>
</div>
  </div>



<section class="bg-[#F1FBE7] py-12 pb-16">
  <div class="container mx-auto text-center">
    <!-- عنوان -->
    <h2 class="text-2xl font-bold text-[#155546] mb-10">سوالات شما</h2>

    <!-- باکس سوالات -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">

      <!-- سوال 1 -->
      <div class="w-full max-w-xl mx-auto mt-4">
        <button
          class="faq-btn w-full flex items-center justify-between bg-[#F1FBE7] text-[#155546] font-medium text-lg px-5 py-4 rounded-[20px] shadow-[inset_0_4px_10px_rgba(0,0,0,0.1)] hover:shadow-[inset_0_6px_15px_rgba(0,0,0,0.15)] transition-all duration-300 ease-in-out">
          <span>چطور می‌تونم منتور مورد نظرم رو پیدا کنم؟</span>
          <span class="icon text-2xl font-bold">+</span>
        </button>
        <div class="faq-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out text-right px-2">
          <p class="mt-3 text-[#155546] text-base leading-7">
            شما می‌توانید از طریق فیلترها و دسته‌بندی‌های سایت، منتور مورد نظرتان را به راحتی پیدا کنید.
          </p>
        </div>
      </div>

      <!-- سوال 2 -->
      <div class="w-full max-w-xl mx-auto mt-4">
        <button
          class="faq-btn w-full flex items-center justify-between bg-[#F1FBE7] text-[#155546] font-medium text-lg px-5 py-4 rounded-[20px] shadow-[inset_0_4px_10px_rgba(0,0,0,0.1)] hover:shadow-[inset_0_6px_15px_rgba(0,0,0,0.15)] transition-all duration-300 ease-in-out">
          <span>چقدر تایم برای صحبت دارم؟</span>
          <span class="icon text-2xl font-bold">+</span>
        </button>
        <div class="faq-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out text-right px-2">
          <p class="mt-3 text-[#155546] text-base leading-7">
            مدت زمان صحبت با منتور بسته به پکیج انتخابی شما متغیر است و در صفحه پروفایل منتور مشخص می‌شود.
          </p>
        </div>
      </div>

      <!-- سوال 3 -->
      <div class="w-full max-w-xl mx-auto mt-4">
        <button
          class="faq-btn w-full flex items-center justify-between bg-[#F1FBE7] text-[#155546] font-medium text-lg px-5 py-4 rounded-[20px] shadow-[inset_0_4px_10px_rgba(0,0,0,0.1)] hover:shadow-[inset_0_6px_15px_rgba(0,0,0,0.15)] transition-all duration-300 ease-in-out">
          <span>منتورینگ چقدر هزینه داره برام؟</span>
          <span class="icon text-2xl font-bold">+</span>
        </button>
        <div class="faq-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out text-right px-2">
          <p class="mt-3 text-[#155546] text-base leading-7">
            هزینه منتورینگ بستگی به منتور و مدت زمان جلسه دارد. می‌توانید قبل از رزرو، هزینه را مشاهده کنید.
          </p>
        </div>
      </div>

      <!-- سوال 4 -->
      <div class="w-full max-w-xl mx-auto mt-4">
        <button
          class="faq-btn w-full flex items-center justify-between bg-[#F1FBE7] text-[#155546] font-medium text-lg px-5 py-4 rounded-[20px] shadow-[inset_0_4px_10px_rgba(0,0,0,0.1)] hover:shadow-[inset_0_6px_15px_rgba(0,0,0,0.15)] transition-all duration-300 ease-in-out">
          <span>فایده های منتورینگ چیه؟</span>
          <span class="icon text-2xl font-bold">+</span>
        </button>
        <div class="faq-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out text-right px-2">
          <p class="mt-3 text-[#155546] text-base leading-7">
            منتورینگ به شما کمک می‌کند مسیر یادگیری خود را سریع‌تر طی کنید و از تجربه‌های منتور استفاده کنید.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll(".faq-btn");

    buttons.forEach((btn) => {
      btn.addEventListener("click", () => {
        const content = btn.nextElementSibling;
        const icon = btn.querySelector(".icon");

        // بستن همه آکاردئون‌ها به جز همین یکی
        document.querySelectorAll(".faq-content").forEach((el) => {
          if (el !== content) {
            el.style.maxHeight = null;
            el.previousElementSibling.querySelector(".icon").textContent = "+";
          }
        });

        // باز و بسته کردن آکاردئون
        if (content.style.maxHeight) {
          content.style.maxHeight = null;
          icon.textContent = "+";
        } else {
          content.style.maxHeight = content.scrollHeight + "px";
          icon.textContent = "−";
        }
      });
    });
  });
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const section = document.querySelector("#mentor-steps");
  const items = section.querySelectorAll(".step-item");

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        items.forEach((item, index) => {
          setTimeout(() => {
            item.classList.remove("opacity-0", "translate-x-6");
          }, index * 300);
        });
        section.classList.remove("opacity-0");
        observer.unobserve(section);
      }
    });
  }, { threshold: 0.3 });

  if (section) {
    observer.observe(section);
  }
});
</script>


<?php get_footer(); ?>