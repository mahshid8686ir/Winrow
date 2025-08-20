<?php
function hodcode_enqueue_styles() {
    wp_enqueue_style(
      'hodcode-style', // Handle name
      get_stylesheet_uri(), // This gets style.css in the root of the theme
      
    );
    wp_enqueue_script(
      'tailwind', // Handle name
      "https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4", // This gets style.css in the root of the theme
      
    );
  }
  add_action('wp_enqueue_scripts', 'hodcode_enqueue_styles');
  

function mytheme_setup() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-background' );
    add_theme_support( 'title-tag' );
    add_theme_support('custom-logo');

    register_nav_menus(["Header" => "Header Menu "]);
}
add_action( 'after_setup_theme', 'mytheme_setup' );

add_action('init', function(){

  register_taxonomy('product_category', ['product'], [
    'hierarchical'      => true,
    'labels'            => [
      'name'          => 'Product Categories',
      'singular_name' => 'Product Category'
    ],
    'rewrite'           => ['slug' => 'product-category'],

    'show_in_rest'=> true,

  ]);

  register_post_type('product', [
    'public' => true,
    'label' => 'Products',

    'supports' =>[
      'title',
      'editor',
      'thumbnail',
      'excerpt',
      'custom-fields'
    ],

    'show_in_rest'=> true,

  ]);
});

hodcode_add_custom_field("price","product","Price (Final)");
hodcode_add_custom_field("old_price","product","Price (Before)");

function hodcode_add_custom_field($fieldName, $postType, $title)
{
  add_action('add_meta_boxes', function () use ($fieldName, $postType, $title) {
    add_meta_box(
      $fieldName . '_box',
      $title,
      function ($post) use ($fieldName) {
        $value = get_post_meta($post->ID, $fieldName, true);
        wp_nonce_field($fieldName . '_nonce', $fieldName . '_nonce_field');
        echo '<input type="text" style="width:100%"
         name="' . esc_attr($fieldName) . '" value="' . esc_attr($value) . '">';
      },
      $postType,
      'normal',
      'default'
    );
  });

  add_action('save_post', function ($post_id) use ($fieldName) {
    // checks
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST[$fieldName . '_nonce_field'])) return;
    if (!wp_verify_nonce($_POST[$fieldName . '_nonce_field'], $fieldName . '_nonce')) return;
    if (!current_user_can('edit_post', $post_id)) return;
    // save
    if (isset($_POST[$fieldName])) {
      $san = sanitize_text_field(wp_unslash($_POST[$fieldName]));
      update_post_meta($post_id, $fieldName, $san);
    } else {
      delete_post_meta($post_id, $fieldName);
    }
  });
}

add_action('pre_get_posts', function ($query) {
  if ($query->is_home() && $query->is_main_query() && !is_admin()) {
    $query->set('post_type', 'product');
  }
});






function toPersianNumber($number) {
    $english = ['0','1','2','3','4','5','6','7','8','9'];
    $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    return str_replace($english, $persian, $number);
}

$price = get_post_meta(get_the_ID(), 'price', true);
$oldPrice = get_post_meta(get_the_ID(), 'old_price', true);

