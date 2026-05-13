<?php
/**
 * DROP THIS FILE in /public_html/wp-content/themes/asanteyhair/
 * Then visit: https://asanteyhair.com/wp-content/themes/asanteyhair/debug-theme.php
 * It will show exactly what paths WordPress is using.
 * DELETE after use.
 */
$wp_load = dirname(__FILE__) . '/../../../wp-load.php';
if (!file_exists($wp_load)) die('wp-load.php not found at: ' . $wp_load);
require_once $wp_load;

echo '<pre style="background:#111;color:#0f0;padding:20px;font-size:13px;">';
echo "=== WORDPRESS PATHS ===\n";
echo "ABSPATH:              " . ABSPATH . "\n";
echo "WP_CONTENT_DIR:       " . WP_CONTENT_DIR . "\n";
echo "Template dir:         " . get_template_directory() . "\n";
echo "Template URI:         " . get_template_directory_uri() . "\n";
echo "Stylesheet URI:       " . get_stylesheet_uri() . "\n";
echo "Home URL:             " . home_url() . "\n";
echo "Site URL:             " . site_url() . "\n";

echo "\n=== THEME FILES EXIST? ===\n";
$dir = get_template_directory();
$files = ['style.css','functions.php','front-page.php','assets/css/main.css','assets/js/main.js'];
foreach ($files as $f) {
    echo str_pad($f, 30) . (file_exists($dir.'/'.$f) ? "EXISTS (".filesize($dir.'/'.$f)." bytes)" : "MISSING") . "\n";
}

echo "\n=== ENQUEUED STYLES ===\n";
global $wp_styles;
if ($wp_styles) {
    foreach ($wp_styles->queue as $handle) {
        $src = $wp_styles->registered[$handle]->src ?? '';
        echo "$handle: $src\n";
    }
} else {
    echo "No styles enqueued yet (this is normal in this context)\n";
}

echo "\n=== ACTIVE THEME ===\n";
$theme = wp_get_theme();
echo "Name:    " . $theme->get('Name') . "\n";
echo "Version: " . $theme->get('Version') . "\n";
echo "Status:  " . (is_a($theme, 'WP_Theme') ? 'OK' : 'ERROR') . "\n";
echo get_stylesheet() . " / " . get_template() . "\n";

echo "\n=== PHP VERSION ===\n";
echo PHP_VERSION . "\n";

echo "\n=== ERRORS IN THEME? ===\n";
$err = error_get_last();
print_r($err);
echo '</pre>';
