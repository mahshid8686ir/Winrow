<section class="bg-[#E9F9D8] py-8 pb-15">
  <div class="mx-30 container mx-auto px-23 flex items-center justify-between flex-col md:flex-row relative z-10">


    <!-- متن -->
    <div class="w-full md:w-1/2 text-center md:text-right md:mt-0" data-aos="fade-right">
      <h1 class="md:text-6xl text-4xl md:leading-20 max-w-128 font-black text-[#155546]">
        <?php the_field('hero_title'); ?>
      </h1>
      <p class="md:text-5xl text-3xl font-bold text-[#155546] mt-4">
        <?php the_field('hero_subtitle'); ?>
      </p>
      <p class="md:text-3xl text-xl font-medium text-[#155546] mt-2">
        <?php the_field('hero_description'); ?>
      </p>

      <?php if( get_field('hero_button_text') && get_field('hero_button_link') ): ?>
        <a href="#start" 
     class="text-center mt-6 inline-block bg-[#FA9D30] text-white px-6 py-3 text-2xl rounded-full font-normal hover:bg-orange-500">
          <?php the_field('hero_button_text'); ?>
        </a>
      <?php endif; ?>
    </div>


    <!-- تصویر -->
     <div class="" data-aos="fade-left">
    <?php 
    $hero_image = get_field('hero_image'); 
    if($hero_image): ?>
      <div class="md:static absolute inset-0 flex items-center justify-center z-0 md:z-auto">
        <img src="<?php echo esc_url($hero_image['url']); ?>" 
             alt="<?php echo esc_attr($hero_image['alt']); ?>" 
             class="opacity-20 md:opacity-100 max-w-xs md:max-w-lg object-contain">
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>