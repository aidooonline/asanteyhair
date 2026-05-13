<?php
/**
 * Asantey Hair & Beauty — header.php
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
<?php
// Bulletproof CSS — loads directly even if wp_enqueue_scripts fails
$theme_uri = get_template_directory_uri();
$main_css  = get_template_directory() . '/assets/css/main.css';
$style_css = get_template_directory() . '/style.css';
$main_v    = file_exists($main_css)  ? filemtime($main_css)  : '1';
$style_v   = file_exists($style_css) ? filemtime($style_css) : '1';
// Only output direct links if our theme stylesheet wasn't already enqueued
global $wp_styles;
$already_loaded = isset($wp_styles) && isset($wp_styles->done) && in_array('ah-theme', $wp_styles->done);
if (!$already_loaded):
?>
<link rel="stylesheet" href="<?php echo esc_url($theme_uri); ?>/assets/css/main.css?v=<?php echo $main_v; ?>">
<link rel="stylesheet" href="<?php echo esc_url($theme_uri); ?>/style.css?v=<?php echo $style_v; ?>">
<?php endif; ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="sr-only" href="#main">Skip to main content</a>

<header class="hdr" id="site-header" role="banner">
  <div class="hdr__inner">

    <!-- 1. Logo — always first -->
    <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Asantey Hair &amp; Beauty — Home">
      <?php if(has_custom_logo()):
        $logo_id = get_theme_mod('custom_logo');
        echo '<img src="'.esc_url(wp_get_attachment_image_url($logo_id,'full')).'" alt="Asantey Hair &amp; Beauty" width="160" height="40">';
      else: ?>
        <span class="site-logo__name">Asantey</span>
        <span class="site-logo__sub">Hair &amp; Beauty</span>
      <?php endif; ?>
    </a>

    <!-- 2. Navigation -->
    <nav aria-label="Primary">
      <?php wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'site-nav',
        'fallback_cb'    => function() {
          echo '<ul class="site-nav">';
          $links = [
            'Shop'         => '/shop/',
            'Raw Hair'     => '/raw-hair/',
            'Virgin Hair'  => '/virgin-hair/',
            'HD Lace'      => '/closures-frontals/',
            'Salon'        => '/salon-services/',
            'Gallery'      => '/gallery/',
            'FAQ'          => '/faq/',
            'Contact'      => '/contact/',
          ];
          foreach($links as $label => $url)
            echo '<li><a href="'.esc_url(home_url($url)).'">'.$label.'</a></li>';
          echo '</ul>';
        },
      ]); ?>
    </nav>

    <!-- 3. Actions — right side -->
    <div class="hdr__actions">
      <button class="hamburger" id="hamburger"
              aria-expanded="false" aria-controls="mobile-nav"
              aria-label="Toggle menu">
        <span></span><span></span><span></span>
      </button>
    </div>

  </div>
</header>

<?php get_template_part('template-parts/nav-mobile'); ?>

<!-- Floating WhatsApp -->
<a href="<?php echo esc_url(ah_whatsapp_url()); ?>"
   class="wa-float" target="_blank" rel="noopener noreferrer"
   aria-label="WhatsApp us">
  <?php echo ah_svg('whatsapp','wa-float__icon'); ?>
  <span>WhatsApp Us</span>
</a>

<main id="main" role="main">
