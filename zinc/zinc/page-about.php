<?php get_header(); ?>
<?php get_template_part('hero'); ?>


<section class="relative bg-[#F1FBE7] py-12">
  <div class="container mx-auto px-6">
    <?php
      // نمونه داده — جایگزین کن با داده‌ی خودت یا حلقه وردپرس
      $timelines = [
        ['title'=>'از کجا؟','content'=>'ما اینجا گذاشتیم متن اول...'],
        ['title'=>'به کجا؟','content'=>'متن دوم...'],
        ['title'=>'چی شد؟','content'=>'متن سوم...'],
        ['title'=>'و اما امروز :)','content'=>'متن چهارم...'],
      ];
      $total = count($timelines);
      foreach($timelines as $i => $item):
    ?>
     <div class="timeline-row grid md:grid-cols-[80px_1fr] items-start mb-16 relative">
  <!-- دایره + خط -->
  <div class="relative flex flex-col items-center">
  <!-- دایره -->
  <div class="timeline-circle w-4 h-4 rounded-full bg-orange-400 t-scale-0-c relative z-10"></div>

  <!-- خط -->
  <?php if($i !== $total - 1): ?>
    <div class="timeline-line absolute top-4 w-1 bg-[#0b513f] t-scale-0 t-scale-transition"
         style="bottom: 0;"></div>
  <?php endif; ?>
</div>

  <!-- متن -->
  <div class="timeline-text text-right pr-6 opacity-0 translate-x-6 transition-all duration-700">
    <h4 class="text-green-800 font-bold mb-2"><?php echo $item['title']; ?></h4>
    <p class="text-sm text-green-800 leading-relaxed"><?php echo $item['content']; ?></p>
  </div>
</div>

    <?php endforeach; ?>
  </div>
</section>


<section class="bg-[#EAFBD9] py-12 px-6 text-center">
  <!-- عنوان -->
  <h2 class="font-semibold text-3xl text-[#155546] mb-12">
    یه نگاهی به زینک بنداز:)
  </h2>

  <!-- باکس ویدیو -->
  <div class="bg-gray-300 rounded-2xl w-full max-w-2xl mx-auto aspect-video overflow-hidden mb-8">
    <!-- ویدیو -->
    <video controls class="w-full h-full object-cover">
  <source src="<?php echo get_template_directory_uri(); ?>/assets/FinalZinkTeaser.mp4" type="video/mp4" />
  مرورگر شما از ویدیو پشتیبانی نمی‌کند.
</video>

  </div>

  <!-- دکمه -->
          <button class="mt-16 text-2xl inline-block bg-[#FA9D30] text-white px-7 py-5 rounded-full font-normal hover:bg-orange-500">
            بیشتر بگین راجع‌به خودتــون!
          </button>
</section>



<main class="bg-[#F1FBE7] py-25 px-8 md:px-30">
  <h2 class="text-2xl font-semibold text-center text-[#155546] mb-10">تیم ما</h2>
  <div class="px-70 grid grid-cols-1 sm:grid-cols-2 gap-y-20 gap-x-30 mt-10">
    <article class="bg-[#F1FBE7] w-full h-80 rounded-[50px] shadow-[0_10px_10px_0_rgba(0,0,0,0.25)] p-6 flex flex-col items-center justify-center text-center transition-transform duration-300 hover:scale-105">
      <a href="/mentor-profile" class="flex-col flex items-center w-full">
        <div class="w-30 h-30 rounded-[50%] shadow-[0_4px_15px_2px_rgba(0,0,0,0.25)] bg-[#F1FBE7] flex items-center justify-center mb-10 overflow-hidden">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Charecters.png" alt="نام منتور" class="w-24 h-24 object-cover rounded-full">
        </div>

        <h3 class="text-[#0A352A] font-extrabold text-2xl leading-6 mb-2">پریا رضایی</h3>
        <p class="text-sm text-[#0A352A] mt-1">همه کاره</p>
      </a>
    </article>
    <article class="bg-[#F1FBE7] w-full h-80 rounded-[50px] shadow-[0_10px_10px_0_rgba(0,0,0,0.25)] p-6 flex flex-col items-center justify-center text-center transition-transform duration-300 hover:scale-105">
      <a href="/mentor-profile" class="flex-col flex items-center w-full">
        <div class="w-30 h-30 rounded-[50%] shadow-[0_4px_15px_2px_rgba(0,0,0,0.25)] bg-[#F1FBE7] flex items-center justify-center mb-10 overflow-hidden">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Charecters.png" alt="نام منتور" class="w-24 h-24 object-cover rounded-full">
        </div>

        <h3 class="text-[#0A352A] font-extrabold text-2xl leading-6 mb-2">مهشید مقصودی</h3>
        <p class="text-sm text-[#0A352A] mt-1">همه کاره</p>
      </a>
    </article>
  </div>
  <div class="px-50 flex mt-20 gap-20">
    <div class="faq-btn w-full flex flex-col items-center justify-between bg-[#F1FBE7] text-[#155546] font-medium text-lg px-10 py-6 rounded-[40px] shadow-[inset_0_4px_10px_rgba(0,0,0,0.1)] hover:shadow-[inset_0_6px_15px_rgba(0,0,0,0.15)] transition-all duration-300 ease-in-out">
      <div class="text-2xl font-semibold text-center text-[#155546]">ماموریت ما؛</div>
      <div class="text-base text-center font-medium text-[#155546] mt-1">تا جای ممکن، کاری کنیم که از دوران نوجوانی و جوانی‌تون پشیمونی براتون باقی نمونه.</div>
    </div>
    <div class="faq-btn w-full flex flex-col items-center justify-between bg-[#F1FBE7] text-[#155546] font-medium text-lg px-10 py-6 rounded-[40px] shadow-[inset_0_4px_10px_rgba(0,0,0,0.1)] hover:shadow-[inset_0_6px_15px_rgba(0,0,0,0.15)] transition-all duration-300 ease-in-out">
      <div class="text-2xl font-semibold text-center text-[#155546]">چشم‌انداز ما؛</div>
      <div class="text-base text-center font-medium text-[#155546] mt-1">موقعی که یک کارآفرین بزرگ شدین، بیایم دیدنتون و بهتون افتخار کنیم:)</div>
    </div>
  </div>
  <section class="px-70 flex items-center flex-col">
    <button class="mt-16 text-2xl inline-block bg-[#FA9D30] text-white px-7 py-5 rounded-full font-normal hover:bg-orange-500">
      عضوی از سفر تیمی ما بــاش:)
    </button>
  </section>
  
</main>
<?php get_footer(); ?>