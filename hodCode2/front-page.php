   <?php get_header(); ?>
<div id="page" class="site">
    <div class="sm:flex hidden pt-10 max-w-screen-lg mx-auto gap-4 flex">
      <?php
      // همه ترم‌ها رو بگیر
      $terms = get_terms([
        'taxonomy' => 'product_category',
        'hide_empty' => false,
        'orderby' => 'id',
        'order' => 'ASC'
      ]);

      // اول دسته‌های مادر
      foreach ($terms as $term) {
        if ($term->parent == 0) {
          ?>
          <a href="<?= get_term_link($term) ?>"
            class="px-5 py-1.5 border rounded-full font-extralight bg-blue-400 text-white">
            <?= $term->name ?>
          </a>
          <?php
        }
      }

      // بعد دسته‌های فرزند
      foreach ($terms as $term) {
        if ($term->parent != 0) {
          ?>
          <a href="<?= get_term_link($term) ?>"
            class="px-5 font-light py-1.5 border rounded-full 
            bg-white text-gray-700 border-gray-300 hover:bg-gray-100">
            <?= $term->name ?>
          </a>
          <?php
        }
      }
      ?>
    </div>
  </div>


    <main id="main" class="site-main ">
      <div class="gap-5 mt-6 max-w-screen-lg mx-5 lg:mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <?php
        if (have_posts()) {
          while (have_posts()) {
            the_post();
        ?>
          <div class="overflow-hidden bg-white pb-5 rounded-lg">
            <?php the_post_thumbnail()?>
            <h3 class="mt-4 mx-3 font-bold text-neutral-900 text-base"><?php the_title()?></h3>
            <?php $terms = get_the_terms( get_the_ID(), 'product_category' );
            if ($terms[0])
              echo "<div class='mt-2 mx-3 text-slate-500 text-sm'>".$terms[0]->name."</div>";
            ?>
            <?php $price = get_post_meta(get_the_ID(),'price',true)?>
            <?php $oldPrice = get_post_meta(get_the_ID(),'old_price',true)?>

            <div class="price flex items-center m-3 flex-row-reverse justify-between">
          <div class="flex flex-row-reverse gap-2 items-center">
            <p class="font-semibold text-xs text-slate-400">تومان</p>
          <p class="font-semibold text-base"><?=toPersianNumber(number_format($price))?></p>
          <div class="font-normal text-sm text-slate-400 line-through"><?=toPersianNumber(number_format($oldPrice))?></div>
          </div>
          <div class="dis bg-red-600 p-1 px-2.5 rounded-lg">
            <p class="font-normal text-xs text-white">۴%</p>
          </div>
          </div>
          <div class="groupbtn flex justify-between h-[40px] mt-8 gap-2 mx-3">
          <button class="font-normal text-sm bg-[#7092c5] w-1/2 h-full rounded-lg text-white">افزودن به سبد</button>
          <button class="font-normal text-sm bg-[#edeeef] w-1/2 h-full rounded-lg text-slate-500">
            <a href="<?php the_permalink()?>">مشاهده جزئیات</a> 
          </button>
        </div>
          </div>
        <?php
            // the_title('<h2>', '</h2>');
            // the_excerpt();
            // the_post_thumbnail();
          }
        } else {
          echo '<p>محصولی برای نمایش وجود ندارد</p>';
        }
        ?>
      </div>
    </main>


















<!-- 
        <main id="main" class="site-main">
        <?php
//  if (have_posts()) {
//         while (have_posts()) {
//           the_post();
//           the_title('<h2>', '</h2>');
//           the_excerpt();
//           the_post_thumbnail();
//         }
//       } else {
//         echo '<p>No content found.</p>';
//       }
    
      ?>
        </main> -->

    <?php get_footer(); ?>

  