<?php
/* Template Name: Register */
if ( is_user_logged_in() ) {
    wp_redirect( site_url('/dashboard/') );
    exit;
}

get_header();

if ($_POST && isset($_POST['user_login'], $_POST['user_email'], $_POST['user_pass'])) {
  $userdata = [
    'user_login' => sanitize_user($_POST['user_login']),
    'user_email' => sanitize_email($_POST['user_email']),
    'user_pass'  => $_POST['user_pass'],
  ];
  $user_id = wp_insert_user($userdata);

  if (!is_wp_error($user_id)) {
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);
    wp_redirect(site_url('/dashboard/'));
    exit;
  } else {
    $error = $user_id->get_error_message();
  }
}
?>

<main class="register-page bg-[#F1FBE7] min-h-screen flex items-center justify-center">
  <div class="w-full max-w-md bg-white rounded-2xl shadow p-6">
    <h1 class="text-xl font-bold text-center text-[#0A352A] mb-4">ثبت‌نام</h1>

    <?php if (!empty($error)): ?>
      <p class="text-red-500 text-center mb-4"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post" class="space-y-4">
      <input type="text" name="user_login" placeholder="نام کاربری" required class="w-full p-2 border rounded-lg">
      <input type="email" name="user_email" placeholder="ایمیل" required class="w-full p-2 border rounded-lg">
      <input type="password" name="user_pass" placeholder="رمز عبور" required class="w-full p-2 border rounded-lg">
      <button type="submit" class="w-full bg-[#FA9D30] text-white p-2 rounded-lg">ثبت‌نام</button>
    </form>

    <p class="mt-4 text-center">
      حساب دارید؟
      <a href="<?php echo site_url('/login/'); ?>" class="text-[#FA9D30] font-bold">وارد شوید</a>
    </p>
  </div>
</main>

<?php get_footer(); ?>
