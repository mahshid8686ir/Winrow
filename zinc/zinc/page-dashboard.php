<?php
/* Template Name: Dashboard */
if ( ! is_user_logged_in() ) {
    wp_redirect( site_url('/login/?redirect_to=' . urlencode(get_permalink())) );
    exit;
}

get_header();

$current_user = wp_get_current_user();
?>

<main class="bg-[#F1FBE7] min-h-screen py-10 px-6 md:px-20">
  <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-6">

    <!-- Sidebar --> 
    <aside class="lg:col-span-1"> 
      <div class="bg-[#E9F9D8] p-6 rounded-2xl shadow-[0_10px_10px_0_rgba(0,0,0,0.25)]"> 
        <nav class="flex flex-col gap-2 space-y-4 text-[#0A352A] font-bold">
          <button data-tab="dashboard" class="tab-btn flex text-green-600">● داشبورد پیشرفت</button>
          <button data-tab="health" class="tab-btn flex">● برنامه سلامت من</button>
          <button data-tab="courses" class="tab-btn flex">● دوره های من</button>
          <button data-tab="mentors" class="tab-btn flex">● منتور های من</button>
          <button data-tab="messages" class="tab-btn flex">● پیام ها</button>
          <button data-tab="settings" class="tab-btn flex">● تنظیمات</button>
          <a href="<?php echo wp_logout_url( home_url() ); ?>" class="text-red-600 mt-4">● خروج</a>
        </nav>
      </div>
    </aside>

    <!-- Content -->
    <section class="lg:col-span-3 space-y-6">

      <!-- Dashboard Tab -->
      <div id="dashboard" class="tab-content">
        <!-- Courses -->
        <div class="grid mb-6 grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="bg[#E9F9D8] p-6 rounded-2xl shadow text-center">
            <h3 class="font-bold text-lg">ثبت نشده</h3>
          </div>
          <div class="bg[#E9F9D8] p-6 rounded-2xl shadow text-center">
            <h3 class="font-bold text-lg">دوره مرز مصاحبه</h3>
          </div>
          <div class="bg[#E9F9D8] p-6 rounded-2xl shadow text-center">
            <h3 class="font-bold text-lg">دوره من کیم؟</h3>
          </div>
        </div>

        <!-- Health Progress -->
        <div class="bg[#E9F9D8] p-6 rounded-2xl shadow">
          <h3 class="font-bold mb-4">پیشرفت سلامت من</h3>
          <div class="w-full bg-gray-200 rounded-full h-3 mb-6">
            <div class="bg-green-600 h-3 rounded-full" style="width:70%"></div>
          </div>
          <div>
            <!-- نمودار ساده -->
            <canvas id="healthChart" class="w-full h-48"></canvas>
          </div>
        </div>

        <!-- Notifications & Reminder -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-6">
          <div class="bg[#E9F9D8] p-6 rounded-2xl shadow">
            <h3 class="font-bold mb-3">اعلان ها</h3>
            <p>۲ تا پیام جدید</p>
          </div>
          <div class="bg[#E9F9D8] p-6 rounded-2xl shadow">
            <h3 class="font-bold mb-3">یادآور</h3>
            <p>جلسه با مهدی مهریزی - فردا</p>
          </div>
        </div>

        <!-- Quick Settings -->
        <div class="bg[#E9F9D8] p-6 rounded-2xl shadow">
          <h3 class="font-bold mb-3">تنظیمات سریع</h3>
          <a href="#" class="text-green-700">ویرایش پروفایل</a>
        </div>
      </div>

      <!-- Health Tab -->
      <div id="health" class="tab-content hidden">
        <div class="bg[#E9F9D8] p-6 rounded-2xl shadow">
          <?php
$activities = get_user_meta(get_current_user_id(), 'health_activities', true);
if (!$activities) {
    $activities = [
        ['title' => 'نوشیدن آب کافی', 'duration' => 'حدود 8 لیوان', 'done' => false],
        ['title' => 'ورزش و نرمش', 'duration' => 'حدود 30 دقیقه', 'done' => false],
        ['title' => 'انجام فعالیت تفریحی', 'duration' => 'حدود 2 ساعت', 'done' => false],
        ['title' => 'امروز برای خودم نوشتم', 'duration' => 'حدود چند خط', 'done' => false],
    ];
}
?>
<form method="post">
<?php wp_nonce_field('update_health_activities', 'update_health_activities_nonce'); ?>
<div class="space-y-4">
    <?php foreach($activities as $i => $act): ?>
        <label class="flex items-center gap-4 bg-[#F1FBE7] p-4 rounded-xl shadow">
            <input type="checkbox" name="activities[<?php echo $i; ?>][done]" value="1"
                   <?php checked($act['done']); ?>>
            <div>
                <div class="font-semibold"><?php echo esc_html($act['title']); ?></div>
                <small class="text-gray-600"><?php echo esc_html($act['duration']); ?></small>
            </div>
            <input type="hidden" name="activities[<?php echo $i; ?>][title]" value="<?php echo esc_attr($act['title']); ?>">
            <input type="hidden" name="activities[<?php echo $i; ?>][duration]" value="<?php echo esc_attr($act['duration']); ?>">
        </label>
    <?php endforeach; ?>
</div>
<button type="submit" name="save_health" class="mt-4 bg-[#FA9D30] text-white px-5 py-2 rounded-xl">ثبت کن</button>
</form>

<?php
// ذخیره وضعیت فعالیت‌ها
if (isset($_POST['save_health']) && wp_verify_nonce($_POST['update_health_activities_nonce'], 'update_health_activities')) {
    $new_activities = $_POST['activities'] ?? [];
    foreach($new_activities as $i => $act) {
        $new_activities[$i]['done'] = isset($act['done']);
    }
    update_user_meta(get_current_user_id(), 'health_activities', $new_activities);
    echo '<div class="p-4 my-4 bg-green-100 text-green-800 rounded">برنامه سلامت شما بروز شد ✅</div>';
}
?>

        </div>
      </div>

      <!-- Courses Tab -->
      <div id="courses" class="tab-content hidden">
         <?php if ( isset($_GET['unjoined']) && $_GET['unjoined'] == '1' ) : ?>
  <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-xl mb-4">
    ❗ ثبت‌نام شما از این دوره لغو شد.
  </div>
<?php endif; ?>
  <div class="bg[#E9F9D8] p-6 rounded-2xl shadow">
    <h3 class="font-bold mb-3">دوره های من</h3>

    <?php
    $my_courses = get_user_meta(get_current_user_id(), 'my_courses', true);

    if ( !empty($my_courses) ) {
        $query = new WP_Query([
            'post_type' => 'course',
            'post__in'  => $my_courses,
            'orderby'   => 'post__in'
        ]);

        if ( $query->have_posts() ) {
            echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">';
            while ( $query->have_posts() ) {
                $query->the_post();
                ?>
                <div class="bg-[#F1FBE7] rounded-[30px] shadow p-6 text-center transition hover:scale-105">
  <h4 class="text-lg font-bold mb-2"><?php the_title(); ?></h4>
  <a href="<?php the_permalink(); ?>" 
     class="mt-3 inline-block bg-[#FA9D30] text-white px-4 py-2 rounded-xl hover:bg-[#155546]">
    مشاهده دوره
  </a>

  <!-- فرم لغو ثبت نام -->
  <form method="post" class="mt-3">
    <?php wp_nonce_field('unregister_course_action', 'unregister_course_nonce'); ?>
    <input type="hidden" name="course_id" value="<?php the_ID(); ?>">
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-800 transition">
      لغو ثبت‌نام
    </button>
  </form>
</div>

                <?php
            }
            echo '</div>';
            wp_reset_postdata();
        }
    } else {
        echo '<p>هنوز در هیچ دوره‌ای ثبت‌نام نکردی.</p>';
    }
    ?>
  </div>
</div>


      <!-- Mentors Tab -->
      <div id="mentors" class="tab-content hidden">
        <div class="bg[#E9F9D8] p-6 rounded-2xl shadow">
          <h3 class="font-bold mb-3">منتور های من</h3>
<?php
$mentors = get_user_meta(get_current_user_id(), 'my_mentors', true);

if ( !empty($mentors) ) {
    $query = new WP_Query([
        'post_type' => 'mentor',
        'post__in'  => $mentors,
        'orderby'   => 'post__in'
    ]);

    if ( $query->have_posts() ) {
        echo '<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">';
        while ( $query->have_posts() ) {
            $query->the_post();
            $photo = get_field('profile_photo'); // فیلد ACF
            $job   = get_field('job_title');     // فیلد ACF
            ?>
            <div class="bg-[#F1FBE7] rounded-[50px] shadow-[0_10px_10px_0_rgba(0,0,0,0.25)] p-6 flex flex-col items-center justify-center text-center transition-transform duration-300 hover:scale-105">
                <?php if ($photo): ?>
                  <div class="w-30 h-30 rounded-[50%] shadow-[0_4px_15px_2px_rgba(0,0,0,0.25)] bg-[#F1FBE7] flex items-center justify-center mb-10 overflow-hidden">
                    <img src="<?php echo esc_url($photo['url']); ?>" alt="<?php the_title(); ?>" class="w-24 h-24 object-cover rounded-full">
                  </div>
                <?php endif; ?>
                <h3 class="text-[#0A352A] font-extrabold text-2xl leading-6 mb-2"><?php the_title(); ?></h3>
                <p class="ext-sm text-[#0A352A] mt-1"><?php echo esc_html($job); ?></p>
                <a href="<?php the_permalink(); ?>" 
                  class="mt-4 inline-block bg-[#FA9D30] text-white px-5 py-2 shadow-[0_4px_15px_2px_rgba(0,0,0,0.25)] rounded-xl hover:bg-[#155546] transition-colors duration-300">
                  مشاهده پروفایل
                </a>
            </div>
            <?php
        }
        echo '</div>';
        wp_reset_postdata();
    }
} else {
    echo '<p>هیچ منتوری برای شما ثبت نشده است.</p>';
}
?>
<?php
$current_user_id = get_current_user_id();
$selected = get_user_meta($current_user_id, 'my_mentors', true);
if (!is_array($selected)) $selected = [];

// وقتی فرم سابمیت شد
if (isset($_POST['update_my_mentors']) && wp_verify_nonce($_POST['update_my_mentors_nonce'], 'update_my_mentors')) {
    $new = isset($_POST['mentors']) ? array_map('intval', $_POST['mentors']) : [];
    update_user_meta($current_user_id, 'my_mentors', $new);
    $selected = $new;
    echo '<div class="p-4 my-6 bg-green-100 text-green-800 rounded">منتورهای شما بروز شد ✅</div>';
}

// همه منتورها
$mentors = get_posts([
    'post_type'      => 'mentor',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC'
]);
?>

<form method="post" class="mt-20">
    <?php wp_nonce_field('update_my_mentors', 'update_my_mentors_nonce'); ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <?php foreach ($mentors as $m): ?>
            <label class="flex items-center gap-2 p-3 bg-[#F1FBE7] rounded-xl shadow cursor-pointer">
                <input type="checkbox" name="mentors[]" value="<?php echo $m->ID; ?>" 
                       <?php checked(in_array($m->ID, $selected)); ?>>
                <span><?php echo esc_html($m->post_title); ?></span>
            </label>
        <?php endforeach; ?>
    </div>
    <button type="submit" name="update_my_mentors" 
            class="mt-6 bg-[#FA9D30] text-white px-5 py-2 rounded-xl hover:bg-[#155546] transition">
        ذخیره منتورها
    </button>
</form>

        </div>
      </div>

      <!-- Messages Tab -->
      <div id="messages" class="tab-content hidden">
        <div class="bg[#E9F9D8] p-6 rounded-2xl shadow">
          <?php
$messages = get_user_meta(get_current_user_id(), 'my_messages', true);

if (!empty($messages)) {
    echo '<div class="space-y-4">';
    foreach ($messages as $msg) {
        $sender = esc_html($msg['sender']);
        $text = esc_html($msg['text']);
        $date = esc_html($msg['date']);
        echo "<div class='bg-[#E9F9D8] p-4 rounded-xl shadow'>
                <strong>{$sender}:</strong>
                <p>{$text}</p>
                <small class='text-gray-600'>{$date}</small>
              </div>";
    }
    echo '</div>';
} else {
    echo '<p class="text-gray-600">هیچ پیامی برای شما موجود نیست.</p>';
}
?>

        </div>
      </div>

      <!-- Settings Tab -->
      <div id="settings" class="tab-content hidden">
        <div class="bg-[#E9F9D8] p-6 rounded-2xl shadow">
          <?php
$current_user = wp_get_current_user();

// ذخیره تغییرات پروفایل
if (isset($_POST['save_profile']) && wp_verify_nonce($_POST['update_profile_nonce'], 'update_profile')) {
    $userdata = [
        'ID'           => $current_user->ID,
        'display_name' => sanitize_text_field($_POST['display_name']),
        'user_email'   => sanitize_email($_POST['user_email']),
        'description'  => sanitize_textarea_field($_POST['description']),
    ];

    // تغییر رمز عبور اگر کاربر چیزی وارد کرده باشد
    if (!empty($_POST['user_pass']) && $_POST['user_pass'] === $_POST['user_pass_confirm']) {
        $userdata['user_pass'] = $_POST['user_pass'];
    }

    // ذخیره اطلاعات
    $user_id = wp_update_user($userdata);

    if (!is_wp_error($user_id)) {
        echo '<div class="p-4 my-4 bg-green-100 text-green-800 rounded">پروفایل با موفقیت به‌روز شد ✅</div>';
    } else {
        echo '<div class="p-4 my-4 bg-red-100 text-red-800 rounded">خطا در به‌روزرسانی اطلاعات ❌</div>';
    }
}
?>

<div class="p-6 rounded-2xl">
  <h3 class="font-bold mb-4">تنظیمات پروفایل</h3>
  
  <form method="post" class="space-y-4">
    <?php wp_nonce_field('update_profile', 'update_profile_nonce'); ?>
    
    <!-- نام نمایشی -->
    <div>
      <label class="block font-semibold mb-1">نام نمایشی</label>
      <input type="text" name="display_name" value="<?php echo esc_attr($current_user->display_name); ?>"
             class="w-full border rounded-lg px-3 py-2">
    </div>

    <!-- ایمیل -->
    <div>
      <label class="block font-semibold mb-1">ایمیل</label>
      <input type="email" name="user_email" value="<?php echo esc_attr($current_user->user_email); ?>"
             class="w-full border rounded-lg px-3 py-2">
    </div>

    <!-- بیو -->
    <div>
      <label class="block font-semibold mb-1">درباره من</label>
      <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2"><?php echo esc_textarea($current_user->description); ?></textarea>
    </div>

    <!-- تغییر رمز -->
    <div>
      <label class="block font-semibold mb-1">رمز عبور جدید</label>
      <input type="password" name="user_pass" class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
      <label class="block font-semibold mb-1">تکرار رمز عبور</label>
      <input type="password" name="user_pass_confirm" class="w-full border rounded-lg px-3 py-2">
    </div>

    <button type="submit" name="save_profile"
            class="bg-green-600 text-white px-6 py-2 rounded-xl hover:bg-green-700">
      ذخیره تغییرات
    </button>
  </form>
</div>

        </div>
      </div>

    </section>
  </div>
</main>

<!-- JS برای سوئیچ تب‌ها -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.tab-btn');
  const contents = document.querySelectorAll('.tab-content');

  // آخرین تب انتخاب‌شده از localStorage
  const activeTab = localStorage.getItem('activeTab');
  if (activeTab) {
    contents.forEach(c => c.classList.add('hidden'));
    document.getElementById(activeTab).classList.remove('hidden');
    tabs.forEach(t => t.classList.remove('text-green-600'));
    document.querySelector(`.tab-btn[data-tab="${activeTab}"]`).classList.add('text-green-600');
  }

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      contents.forEach(c => c.classList.add('hidden'));
      document.getElementById(tab.dataset.tab).classList.remove('hidden');

      tabs.forEach(t => t.classList.remove('text-green-600'));
      tab.classList.add('text-green-600');

      // ذخیره تب انتخاب‌شده
      localStorage.setItem('activeTab', tab.dataset.tab);
    });
  });
});
</script>

<?php get_footer(); ?>
