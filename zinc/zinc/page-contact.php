<?php
/* Template Name: تماس با ما */
get_header();
?>
<?php get_template_part('hero'); ?>

<section class="bg-[#EAFBD8] py-12">
  <div class="container mx-auto max-w-md">
    
    <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="POST" class="flex flex-col gap-4">
      <input type="hidden" name="action" value="send_contact_form">

      <!-- نام و نام خانوادگی -->
      <input 
        type="text" 
        name="name" 
        placeholder="نام و نام‌خانوادگی" 
        required
        class="w-full rounded-[15px] border border-gray-200 shadow-sm p-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-400"
      >

      <!-- ایمیل -->
      <input 
        type="email" 
        name="email" 
        placeholder="ایمیل" 
        required
        class="w-full rounded-[15px] border border-gray-200 shadow-sm p-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-400"
      >

      <!-- پیام -->
      <textarea 
        name="message" 
        placeholder="پیامت به ما :)" 
        required
        class="w-full rounded-[15px] border border-gray-200 shadow-sm p-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-400 h-32"
      ></textarea>

      <!-- دکمه ارسال -->
      <button 
        type="submit" 
        class="w-full rounded-full bg-orange-400 text-white font-bold py-3 hover:bg-orange-500 transition"
      >
        الان می‌فرستم
      </button>
    </form>

  </div>
</section>

<?php
get_footer();
