<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class("bg-gray-100"); ?>>
    <!-- <header class="bg-white">
      <div class="max-w-screen-lg mx-auto">
        <?php //if(function_exists("the_custom_logo"))
        //the_custom_logo();?>
        <?php //wp_nav_menu([
         // "theme_location" =>'Header',
         // "menu_class" => "flex gap-3",
         // "container" => false
        //]);
        ?>
      </div>
    </header> -->

    
    <nav class="font-normal bg-white shadow p-2 px-4 pl-0 md:px-70">
      <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center space-x-4 space-x-reverse">
          
      <div class="flex items-center  space-x-6">
        <a href="<?php echo home_url(); ?>">
              <img src="<?php echo get_template_directory_uri(); ?>/HodeCode2.png" alt="لوگو" class="h-15">
        </a>

        <div><a href="#" class="hidden sm:inline-block text-gray-700 hover:text-red-500">خانه</a></div>
        <div><a href="#" class="hidden sm:inline-block text-gray-700 hover:text-red-500">محصولات</a></div>

        </div>
      </div>

        <div class="flex items-center space-x-6 space-x-reverse text-gray-700">
          <div><a href="#" class="hidden sm:inline-block hover:text-red-500">ارتباط با ما</a></div>
          <a href="<?php echo home_url(); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/shop.png" alt="سبد خرید" class="h-15">
          </a>
        </div>
      </div>
    </nav>

