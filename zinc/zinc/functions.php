<?php
function zink_enqueue_assets() {
    $ver = wp_get_theme()->get('Version');

    // استایل اصلی قالب (style.css)
    wp_enqueue_style(
        'zink-style',
        get_stylesheet_uri(),
        [],
        $ver
    );

    // Tailwind از CDN
    wp_enqueue_script(
        'tailwind',
        "https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4",
        [],
        null,
        false // قبل از بقیه لود شود
    );

    // اسکریپت اصلی قالب
    wp_enqueue_script(
        'zink-main',
        get_template_directory_uri() . '/assets/js/main.js',
        ['jquery'],
        $ver,
        true
    );
}

// فقط از wp_enqueue_scripts استفاده کن
add_action('wp_enqueue_scripts', 'zink_enqueue_assets');

// امنیت ساده
if ( ! defined('ABSPATH') ) exit;

add_action('after_setup_theme', function () {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', ['search-form','gallery','caption','script','style']);
  add_theme_support('align-wide');
  add_theme_support('responsive-embeds');
  add_theme_support('custom-logo', [
  'height'      => 60,
  'width'       => 200,
  'flex-height' => true,
  'flex-width'  => true,
  ]);

  register_nav_menus([
    'primary' => __('Primary Menu', 'zink'),
    'footer'  => __('Footer Menu', 'zink'),
  ]);

  // سایزهای تصویر برای کارت‌ها
  add_image_size('mentor_card', 400, 400, true);
  add_image_size('course_card', 600, 360, true);
});

add_action('wp_enqueue_scripts', function () {
  $ver = wp_get_theme()->get('Version');
  wp_enqueue_style('zink-main', get_stylesheet_directory_uri() . '/assets/css/main.css', [], $ver);
  wp_enqueue_script('zink-main', get_stylesheet_directory_uri() . '/assets/js/main.js', ['jquery'], $ver, true);
});
// ثبت پست‌تایپ‌ها و تکسونامی‌ها
add_action('init', function () {

  // منتور
  register_post_type('mentor', [
    'label' => __('Mentors', 'zink'),
    'labels' => [
      'name' => __('Mentors', 'zink'),
      'singular_name' => __('Mentor', 'zink'),
      'add_new_item' => __('Add New Mentor', 'zink'),
      'edit_item' => __('Edit Mentor', 'zink'),
    ],
    'public' => true,
    'has_archive' => true,
    'menu_icon' => 'dashicons-businessperson',
    'rewrite' => ['slug' => 'mentors'],
    'supports' => ['title','editor','excerpt','thumbnail','custom-fields'],
    'show_in_rest' => true,
  ]);

  register_taxonomy('mentor_specialty', 'mentor', [
    'label' => __('Specialties', 'zink'),
    'public' => true,
    'rewrite' => ['slug' => 'mentor-specialty'],
    'hierarchical' => false,
    'show_in_rest' => true,
  ]);

  // دوره
  register_post_type('course', [
    'label' => __('Courses', 'zink'),
    'labels' => [
      'name' => __('Courses', 'zink'),
      'singular_name' => __('Course', 'zink'),
      'add_new_item' => __('Add New Course', 'zink'),
      'edit_item' => __('Edit Course', 'zink'),
    ],
    'public' => true,
    'has_archive' => true,
    'menu_icon' => 'dashicons-welcome-learn-more',
    'rewrite' => ['slug' => 'courses'],
    'supports' => ['title','editor','excerpt','thumbnail','custom-fields'],
    'show_in_rest' => true,
  ]);

  register_taxonomy('course_category', 'course', [
    'label' => __('Course Categories', 'zink'),
    'public' => true,
    'rewrite' => ['slug' => 'course-category'],
    'hierarchical' => true,
    'show_in_rest' => true,
  ]);

  register_taxonomy('course_level', 'course', [
    'label' => __('Course Levels', 'zink'),
    'public' => true,
    'rewrite' => ['slug' => 'course-level'],
    'hierarchical' => false,
    'show_in_rest' => true,
  ]);

});

// لوکیشن فهرست فوتر
add_action('after_setup_theme', function () {
  register_nav_menus([
    'footer-menu' => 'فهرست فوتر',
  ]);
});

// استایل اصلی + فونت‌آوسام
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('theme-style', get_stylesheet_uri(), [], null);
  wp_enqueue_style(
    'font-awesome',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css',
    [],
    '6.6.0'
  );
});

// کلاس به لینک‌های فهرست فوتر (برای استایل تمیز)
add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
  if (!empty($args->theme_location) && $args->theme_location === 'footer-menu') {
    $atts['class'] = 'block text-[#155e48] hover:text-[#0f4e3b] transition';
  }
  return $atts;
}, 10, 3);

function theme_enqueue_timeline_scripts() {
  wp_enqueue_script('theme-timeline', get_template_directory_uri() . '/assets/js/timeline.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts','theme_enqueue_timeline_scripts');

function enqueue_dashboard_assets() {
  if ( is_page_template('page-dashboard.php') ) {
    wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array(), null, true);
    wp_add_inline_script('chart-js', "
      const ctx = document.getElementById('healthChart').getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['هفته 1','هفته 2','هفته 3','هفته 4'],
          datasets: [{
            label: 'سلامت',
            data: [20,40,35,70],
            borderColor: '#0A352A',
            fill: false
          }]
        }
      });
    ");
  }
}
add_action('wp_enqueue_scripts','enqueue_dashboard_assets');






















// نمایش فیلد منتورها در پروفایل کاربر
function add_user_mentors_field($user) {
    // همه منتورها (CPT mentor)
    $mentors = get_posts([
        'post_type'      => 'mentor',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC'
    ]);

    // منتورهای فعلی کاربر
    $user_mentors = get_user_meta($user->ID, 'my_mentors', true);
    if ( !is_array($user_mentors) ) {
        $user_mentors = [];
    }
    ?>
    <h3>منتورهای کاربر</h3>
    <table class="form-table">
        <tr>
            <th><label for="my_mentors">انتخاب منتورها</label></th>
            <td>
                <select name="my_mentors[]" multiple style="width: 400px; height: 150px;">
                    <?php foreach ( $mentors as $m ): ?>
                        <option value="<?php echo $m->ID; ?>" <?php selected(in_array($m->ID, $user_mentors)); ?>>
                            <?php echo esc_html($m->post_title); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="description">منتورهای مربوط به این کاربر را انتخاب کنید.</p>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'add_user_mentors_field');
add_action('edit_user_profile', 'add_user_mentors_field');

// ذخیره منتورها
function save_user_mentors_field($user_id) {
    if ( current_user_can('edit_user', $user_id) ) {
        $mentors = isset($_POST['my_mentors']) ? array_map('intval', $_POST['my_mentors']) : [];
        update_user_meta($user_id, 'my_mentors', $mentors);
    }
}
add_action('personal_options_update', 'save_user_mentors_field');
add_action('edit_user_profile_update', 'save_user_mentors_field');

// ذخیره دوره‌های کاربر
function zink_register_course() {
    if ( isset($_POST['course_id'], $_POST['register_course_nonce']) 
         && wp_verify_nonce($_POST['register_course_nonce'], 'register_course_action') 
         && is_user_logged_in() ) {

        $user_id   = get_current_user_id();
        $course_id = intval($_POST['course_id']);

        $courses = get_user_meta($user_id, 'my_courses', true);
        if ( !is_array($courses) ) $courses = [];

        // اگر قبلا ثبت نشده، اضافه کن
        if ( !in_array($course_id, $courses) ) {
            $courses[] = $course_id;
            update_user_meta($user_id, 'my_courses', $courses);
        }

        // بعد از ذخیره با پیام موفقیت ریدایرکت کن
        wp_redirect( add_query_arg([
            'joined' => '1',
            'course' => $course_id
        ], get_permalink($course_id)) );
        exit;
    }
}
add_action('init', 'zink_register_course');



// لغو ثبت‌نام از دوره
function zink_unregister_course() {
    if ( isset($_POST['course_id'], $_POST['unregister_course_nonce']) 
         && wp_verify_nonce($_POST['unregister_course_nonce'], 'unregister_course_action') 
         && is_user_logged_in() ) {

        $user_id   = get_current_user_id();
        $course_id = intval($_POST['course_id']);

        $courses = get_user_meta($user_id, 'my_courses', true);
        if ( is_array($courses) && in_array($course_id, $courses) ) {
            $courses = array_diff($courses, [$course_id]);
            update_user_meta($user_id, 'my_courses', $courses);
        }

        wp_redirect( add_query_arg('unjoined', '1', site_url('/dashboard/')) );
        exit;
    }
}
add_action('init', 'zink_unregister_course');





add_action('admin_post_nopriv_send_contact_form', 'handle_contact_form');
add_action('admin_post_send_contact_form', 'handle_contact_form');

function handle_contact_form() {
    $name    = sanitize_text_field($_POST['name']);
    $email   = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    $to      = get_option('admin_email'); // ایمیل ادمین وردپرس
    $subject = "پیام جدید از $name";
    $body    = "نام: $name\nایمیل: $email\n\nپیام:\n$message";
    $headers = ["From: $name <$email>"];

    wp_mail($to, $subject, $body, $headers);

    // بعد از ارسال برو به صفحه تشکر
    wp_redirect(home_url('/contact'));
    exit;
}
