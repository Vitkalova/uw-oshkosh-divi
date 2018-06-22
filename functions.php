<?php
// Instantiate the Google Custom Search module
require 'includes/gcs-module.php' ;

// Stylesheets
function uwo_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
    wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
}
add_action( 'wp_enqueue_scripts', 'uwo_theme_enqueue_styles' );

// Custom JavaScript
function uwo_theme_enqueue_script(){
  wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/script.js', array('jquery') ,'1.0', true );
  wp_enqueue_script( 'jfeed', get_stylesheet_directory_uri() . '/lib/xml2json.js', array('jquery') ,'1.0', true );
  wp_enqueue_script( 'get-emergency', get_stylesheet_directory_uri() . '/js/get-emergency.js', array('jquery') ,'1.0', true );
}
add_action( 'wp_enqueue_scripts', 'uwo_theme_enqueue_script' );

// Customize Wordpress login page
function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/wordmark-login.png);
            background-size: contain;
            padding-bottom: 30px;
            margin-left: 0;
            margin-right: 0;
            width: 322px;
            height: 149px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

// Favicons
function uwo_favicon_link() {
    echo '<!-- Favicons -->
    <link rel="shortcut icon" type="image/x-icon" href="' . get_stylesheet_directory_uri() . '/images/favicons/favicon.ico?v=2">
    <link rel="apple-touch-icon" sizes="57x57" href="' . get_stylesheet_directory_uri() . '/images/favicons/apple-touch-icon-57x57.png?v=2">
    <link rel="apple-touch-icon" sizes="114x114" href="' . get_stylesheet_directory_uri() . '/images/favicons/apple-touch-icon-114x114.png?v=2">
    <link rel="apple-touch-icon" sizes="72x72" href="' . get_stylesheet_directory_uri() . '/images/favicons/apple-touch-icon-72x72.png?v=2">
    <link rel="apple-touch-icon" sizes="144x144" href="' . get_stylesheet_directory_uri() . '/images/favicons/apple-touch-icon-144x144.png?v=2">
    <link rel="apple-touch-icon" sizes="60x60" href="' . get_stylesheet_directory_uri() . '/images/favicons/apple-touch-icon-60x60.png?v=2">
    <link rel="apple-touch-icon" sizes="120x120" href="' . get_stylesheet_directory_uri() . '/images/favicons/apple-touch-icon-120x120.png?v=2">
    <link rel="apple-touch-icon" sizes="76x76" href="' . get_stylesheet_directory_uri() . '/images/favicons/apple-touch-icon-76x76.png?v=2">
    <link rel="apple-touch-icon" sizes="152x152" href="' . get_stylesheet_directory_uri() . '/images/favicons/apple-touch-icon-152x152.png?v=2">
    <meta name="apple-mobile-web-app-title" content="UW Oshkosh">
    <link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/images/favicons/favicon-196x196.png?v=2" sizes="196x196">
    <link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/images/favicons/favicon-160x160.png?v=2" sizes="160x160">
    <link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/images/favicons/favicon-96x96.png?v=2" sizes="96x96">
    <link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/images/favicons/favicon-16x16.png?v=2" sizes="16x16">
    <link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/images/favicons/favicon-32x32.png?v=2" sizes="32x32">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="msapplication-TileImage" content="' . get_stylesheet_directory_uri() . '/images/favicons/mstile-144x144.png?v=2">
    <meta name="application-name" content="UW Oshkosh">';
}
add_action( 'wp_head', 'uwo_favicon_link' );
/**
 * I want to use the basic 2012 theme but don't want TinyMCE to create
 * unwanted HTML. By removing editor-style.css from the $editor_styles
 * global, this code effectively undoes the call to add_editor_style()
 */
add_action( 'after_setup_theme', 'foobar_setup', 11 );
function foobar_setup() {
  global $editor_styles;
  $editor_styles = array();
}

?>
<?php
/*
* For accessibility a user needs to be able to zoom into a webpage, ex. cases where the user has poor eyesight, to acheive this
* we need the meta tag in the header to have "maximum-scale" > 2 and "user-scalable" cannot be disabled.
*/

/*remove the function that sets:
* '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />'
*/
function child_remove_parent_function(){
    remove_action('wp_head', 'et_add_viewport_meta');
}
add_action('wp_loaded', 'child_remove_parent_function');

/*
* replace removed function with child function that allows zooming
*/
function et_add_viewport_meta_2(){
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=1" />';
}
add_action('wp_head', 'et_add_viewport_meta_2');
?>

<?php
/*
* altering comment template to add aria-label for accessibility
*/

function wpsites_modify_comment_form_text_area($arg) {
    $arg['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" aria-label="comment" aria-required="true"></textarea></p>';
    return $arg;
}

add_filter('comment_form_defaults', 'wpsites_modify_comment_form_text_area');
?>
