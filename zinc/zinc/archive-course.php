<?php get_header(); ?>
<main class="container">
  <header class="page-head"><h1>دوره‌ها</h1></header>

  <form class="filters" method="get">
    <?php
      // فیلتر ساده بر اساس دسته‌بندی دوره
      wp_dropdown_categories([
        'show_option_all' => 'همه دسته‌بندی‌ها',
        'taxonomy' => 'course_category', // دسته‌بندی دوره
        'name' => 'cc',
        'orderby' => 'name',
        'selected' => isset($_GET['cc']) ? intval($_GET['cc']) : 0,
        'hide_empty' => true,
      ]);
    ?>
    <button type="submit">فیلتر</button>
  </form>

  <div class="grid">
    <?php
    $tax_query = [];
    if (!empty($_GET['cc'])) {
      $tax_query[] = [
        'taxonomy' => 'course_category',
        'field'    => 'term_id',
        'terms'    => intval($_GET['cc']),
      ];
    }

    $q = new WP_Query([
      'post_type' => 'course', // نوع پست دوره
      'paged' => max(1, get_query_var('paged')),
      'tax_query' => $tax_query
    ]);

    if ($q->have_posts()):
      while($q->have_posts()): $q->the_post();
        get_template_part('template-parts/content','course-card');
      endwhile;

      the_posts_pagination();
      wp_reset_postdata();
    else:
      echo '<p>موردی یافت نشد.</p>';
    endif;
    ?>
  </div>
</main>
<?php get_footer(); ?>
