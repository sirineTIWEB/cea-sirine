<?php
/**
 * The header for the theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <div id="page" class="site">
    <a class="skip-link screen-reader-text"
      href="#primary"><?php esc_html_e('Skip to content', 'theme-cea-prof'); ?></a>

    <header id="masthead" class="site-header bg-white sticky top-0 z-50">
      <!-- Desktop Header -->
      <div class="hidden lg:grid grid-cols-12 items-center h-20 w-screen">
        <!-- Logo -->
        <div class="site-branding col-start-2 col-span-1">
          <?php if (has_custom_logo()): ?>
            <div class="custom-logo w-12 h-12">
              <?php the_custom_logo(); ?>
            </div>
          <?php else: ?>
            <?php if (is_front_page() && is_home()): ?>
              <h1 class="site-title m-0">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"
                  class="text-xl font-bold text-black hover:text-cea-orange transition-colors duration-200 no-underline">
                  <?php bloginfo('name'); ?>
                </a>
              </h1>
            <?php else: ?>
              <p class="site-title m-0">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"
                  class="text-xl font-bold text-black hover:text-cea-orange transition-colors duration-200 no-underline">
                  <?php bloginfo('name'); ?>
                </a>
              </p>
            <?php endif; ?>
          <?php endif; ?>
        </div>

        <!-- Navigation -->
        <nav id="site-navigation" class="main-navigation col-start-4 col-span-6 flex justify-center">
          <?php
          wp_nav_menu(
            array(
              'theme_location' => 'primary',
              'menu_id' => 'primary-menu',
              'menu_class' => 'flex space-x-3 items-center',
              'container' => false,
              'fallback_cb' => false,
              'walker' => new class extends Walker_Nav_Menu {
            function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
            {
              $classes = empty($item->classes) ? array() : (array) $item->classes;
              $classes[] = 'menu-item-' . $item->ID;

              $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
              $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

              $output .= '<li' . $class_names . '>';

              $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
              $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
              $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
              $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

              // Check if this is the current menu item
              $is_current = in_array('current-menu-item', $classes) || in_array('current_page_item', $classes) || in_array('current-menu-ancestor', $classes) || in_array('current-page-ancestor', $classes);
              $link_class = 'btn-nav text-xl font-light' . ($is_current ? ' active' : '');

              $item_output = isset($args->before) ? $args->before : '';
              $item_output .= '<a' . $attributes . ' class="' . $link_class . '">';
              $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
              $item_output .= '</a>';
              $item_output .= isset($args->after) ? $args->after : '';

              $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
            }

            function end_el(&$output, $item, $depth = 0, $args = null)
            {
              $output .= "</li>\n";
            }
              }
            )
          );
          ?>
        </nav>

        <!-- Contact Button -->
        <div class="col-span-2 col-start-10 col-end-12 flex justify-self-end">
          <a href="#footer" data-text="Contactez-nous →" class="btn-primary" onclick="event.preventDefault(); document.querySelector('.site-footer').scrollIntoView({ behavior: 'smooth' });">
            Contactez-nous →
          </a>
        </div>
      </div>

      <!-- Mobile Header -->
      <div class="lg:hidden grid grid-cols-12 w-screen">
        <div class="col-start-2 col-end-12 flex items-center justify-between h-16">
          <!-- Site Branding -->
          <div class="site-branding flex items-center space-x-3">
            <?php if (has_custom_logo()): ?>
              <div class="custom-logo w-10 h-10">
                <?php the_custom_logo(); ?>
              </div>
            <?php endif; ?>

            <?php if (is_front_page() && is_home()): ?>
              <h1 class="site-title m-0">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"
                  class="text-xl font-bold text-gray-800 hover:text-blue-700 transition-colors duration-200 no-underline">
                  <?php bloginfo('name'); ?>
                </a>
              </h1>
            <?php else: ?>
              <p class="site-title m-0">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"
                  class="text-xl font-bold text-gray-800 hover:text-blue-700 transition-colors duration-200 no-underline">
                  <?php bloginfo('name'); ?>
                </a>
              </p>
            <?php endif; ?>
          </div>

          <!-- Mobile Menu Button -->
          <button
            class="menu-toggle flex items-center justify-center w-10 h-10 transition-colors duration-200 cursor-pointer"
            aria-controls="primary-menu" aria-expanded="false" type="button">
            <span class="sr-only"><?php esc_html_e('Toggle navigation menu', 'theme-cea-prof'); ?></span>
            <!-- Hamburger Icon -->
            <svg class="w-6 h-6 text-cea-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>

        <!-- Mobile Navigation Menu -->
        <nav class="mobile-navigation lg:hidden hidden col-start-2 col-end-12">
          <div class="py-2 lg:py-4">
            <?php
            wp_nav_menu(
              array(
                'theme_location' => 'primary',
                'menu_id' => 'mobile-menu',
                'menu_class' => 'space-y-2',
                'container' => false,
                'fallback_cb' => false,
                'walker' => new class extends Walker_Nav_Menu {
              function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
              {
                $classes = empty($item->classes) ? array() : (array) $item->classes;
                $classes[] = 'menu-item-' . $item->ID;

                $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
                $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

                $output .= '<li' . $class_names . '>';

                $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
                $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
                $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
                $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

                // Check if this is the current menu item
                $is_current = in_array('current-menu-item', $classes) || in_array('current_page_item', $classes) || in_array('current-menu-ancestor', $classes) || in_array('current-page-ancestor', $classes);
                $link_class = 'btn-nav-mobile text-xl font-light' . ($is_current ? ' active' : '');

                $item_output = isset($args->before) ? $args->before : '';
                $item_output .= '<h1><a' . $attributes . ' class="' . $link_class . '">';
                $item_output .= '<span>' . (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '') . '</span>';
                $item_output .= '</a></h1>';
                $item_output .= isset($args->after) ? $args->after : '';

                $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
              }

              function end_el(&$output, $item, $depth = 0, $args = null)
              {
                $output .= "</li>\n";
              }
                }
              )
            );
            ?>
          </div>
        </nav>
      </div>
    </header>

    <div id="content" class="site-content">