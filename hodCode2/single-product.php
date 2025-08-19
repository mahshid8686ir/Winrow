<?php get_header(); ?>
<main id="main" class="site-main">
    <div class="mt-15 max-w-screen-lg mx-auto grid grid-cols-1 xl:grid-cols-4 gap-6">
        
        <aside class="border border-gray-300 order-2 lg:order-1 lg:col-span-1 bg-white rounded-2xl p-4 h-fit  xl:mx-0 mx-5">
            <h3 class="font-bold text-[#152b4b] mb-3">محصولات مشابه</h3>
            <div class="space-y-4">
                <?php 
                $related = new WP_Query([
                    'post_type' => 'product',
                    'posts_per_page' => 3,
                    'post__not_in' => [get_the_ID()],
                ]);
                while($related->have_posts()): $related->the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="flex items-center gap-3 border-b border-gray-300 pb-3 last:border-0 hover:bg-gray-50 transition">
                    <?php the_post_thumbnail('thumbnail', ['class' => 'w-16 h-12 object-cover rounded']); ?>
                    <h4 class="text-xs text-slate-600 text-xs/6 font-normal"><?php the_title(); ?></h4>
                </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </aside>
        
        <div class="order-1 xl:order-2 xl:col-span-3 rounded-lg xl:mx-0 mx-5">

            <div class="flex mb-6">
                <?php the_post_thumbnail('large', ['class' => 'rounded-xl object-contain']); ?>
            </div>


            <?php 
                $price = get_post_meta(get_the_ID(),'price',true);
                $oldPrice = get_post_meta(get_the_ID(),'old_price',true);
            ?>
            <div class="flex md:flex-row flex-col items-center justify-between mb-8">
                <h1 class="font-bold text-2xl text-[#152b4b]"><?php the_title(); ?></h1>
                <div class = 'price flex items-center m-3 flex-row-reverse justify-between'>
                    <div class = 'flex flex-row-reverse gap-2 items-center'>
                        <p class = 'font-medium text-xs text-slate-400'>تومان</p>
                        <p class = 'font-black text-xl'><?= toPersianNumber( number_format( $price ) )?></p>
                        <div class = 'font-normal text-[15px] text-slate-400 line-through ml-2'><?= toPersianNumber( number_format( $oldPrice ) )?></div>
                    </div>
                    <div class = 'dis bg-red-600 p-1.5 px-2.5 rounded-lg ml-6'>
                        <p class = 'font-normal text-xs text-white'>۴%</p>
                    </div>
                </div>
            </div>


            <div class="text-base font-light leading-7 text-slate-500 leading-7 mb-6">
                <?php the_content(); ?>
            </div>


            <button class="flex justify-center items-center gap-1 bg-[#7092c5] text-white font-light text-[15] w-50 h-12 rounded-lg mb-8">
            <a href="#">
                <img src="<?php echo get_template_directory_uri(); ?>/shopicon.png" alt="سبد خرید" class="h-8">
            </a>                
            افزودن به سبد
            </button>

<div>
  <h3 class="font-bold text-[23px] text-[#152b4b] mb-3">ویژگی‌ها</h3>
  <ul class="text-sm space-y-2 list-disc list-inside text-right">
    <li class="text-base font-extralight text-slate-500">
      نوع حسگر: <span class="font-semibold text-gray-900 mx-3">CMOS</span>
    </li>
    <li class="text-base font-extralight text-slate-500">
      قطع حسگر: <span class="font-semibold text-gray-900 mx-3"> (کراپ فریم) APS-C / Crop Frame</span>
    </li>
  </ul>
</div>

        </div>





    </div>
</main>
<?php get_footer(); ?>
