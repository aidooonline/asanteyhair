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
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="sr-only" href="#main">Skip to main content</a>

<header class="hdr" id="site-header" role="banner">
  <div class="hdr__inner">

    <!-- Left: Navigation -->
    <nav aria-label="Primary">
      <?php wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'site-nav',
        'fallback_cb'    => function() {
          echo '<ul class="site-nav">';
          $links = [
            'Shop'              =>'/shop/',
            'Raw Hair'          =>'/raw-hair/',
            'Virgin Hair'       =>'/virgin-hair/',
            'HD Lace'=>'/closures-frontals/',
            'Salon'=>'/salon-services/',
            'Gallery'           =>'/gallery/',
            'FAQ'               =>'/faq/',
            'Contact'           =>'/contact/',
          ];
          foreach($links as $label=>$url)
            echo '<li><a href="'.esc_url(home_url($url)).'">'.$label.'</a></li>';
          echo '</ul>';
        },
      ]); ?>
    </nav>

    <!-- Center: Logo -->
    <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Asantey Hair &amp; Beauty — Home">
      <?php if(has_custom_logo()):
        $logo_id = get_theme_mod('custom_logo');
        echo '<img src="'.esc_url(wp_get_attachment_image_url($logo_id,'full')).'" alt="Asantey Hair &amp; Beauty" width="160" height="40">';
      else: ?>
        <span class="site-logo__name">Asantey</span>
        <span class="site-logo__sub">Hair &amp; Beauty</span>
      <?php endif; ?>
    </a>

    <!-- Right: Actions + Hamburger -->
    <div class="hdr__actions">
      <a href="https://asanteyhair.as.me/"
         class="btn btn--ow btn--sm"
         target="_blank" rel="noopener noreferrer"
         style="display:none;" id="hdr-book">Book</a>
      <a href="<?php echo esc_url(ah_whatsapp_url( 'Hello! I would like to order with Asantey Hair and Beauty.' )); ?>"
         class="btn btn--w btn--sm"
         target="_blank" rel="noopener noreferrer">
        Order Now
      </a>
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
