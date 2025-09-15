<?php
/* Template Name: Login */
if ( is_user_logged_in() ) {
    wp_redirect( site_url('/dashboard/') );
    exit;
}

get_header();

$redirect_to = !empty($_GET['redirect_to']) ? esc_url($_GET['redirect_to']) : site_url('/dashboard/');
?>

<main class="login-page bg-[#F1FBE7] py-30 flex items-center justify-center min-h-screen">
  <div class="w-full max-w-md bg-white rounded-2xl shadow p-6">
    <h1 class="text-xl font-bold text-center text-[#0A352A] mb-4">ورود به حساب</h1>

    <form name="loginform" id="loginform" action="<?php echo esc_url( site_url('wp-login.php', 'login_post') ); ?>" method="post" class="space-y-4">
      <p class="login-username">
        <label for="user_login" class="block mb-1">نام کاربری یا ایمیل</label>
        <input type="text" name="log" id="user_login" autocomplete="username" class="input w-full p-2 border rounded-lg" value="">
      </p>

      <p class="login-password">
        <label for="user_pass" class="block mb-1">رمز عبور</label>
        <input type="password" name="pwd" id="user_pass" autocomplete="current-password" class="input w-full p-2 border rounded-lg" value="">
      </p>

      <p class="login-remember py-2">
        <label class="flex items-center gap-2">
          <input name="rememberme" type="checkbox" id="rememberme" value="forever">
          مرا به خاطر بسپار
        </label>
      </p>

      <p class="login-submit">
        <input type="submit" name="wp-submit" id="wp-submit"
               class="button w-full bg-[#FA9D30] text-white p-2 rounded-lg font-bold"
               value="ورود">
        <input type="hidden" name="redirect_to" value="<?php echo $redirect_to; ?>">
      </p>
    </form>

    <p class="mt-4 text-center">
      حساب کاربری ندارید؟
      <a href="<?php echo site_url('/register/'); ?>" class="text-[#FA9D30] font-bold">ثبت‌نام</a>
    </p>
  </div>
</main>

<?php get_footer(); ?>
