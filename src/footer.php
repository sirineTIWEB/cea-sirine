<?php
/**
 * The template for displaying the footer
 */

// Get Footer Settings page ID
$footer_page_id = get_option('footer_settings_page_id');
?>

</div><!-- #content -->

<footer id="colophon" class="site-footer border-t border-black">
    <!-- Main Footer -->
    <div class="footer-cea">
        <!-- Left Section: Logo + Legal Links -->
        <div class="footer-left">
            <!-- Logo at top -->
            <div class="footer-logo">
                <?php if (get_theme_mod('custom_logo')): ?>
                    <div class="custom-logo w-12 h-12">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else: ?>
                    <h3>
                        <span><?php bloginfo('name'); ?></span>
                    </h3>
                <?php endif; ?>
            </div>

            <!-- Legal links at bottom -->
            <div class="footer-legal">
                <a href="#" class="text-sm hover:text-cea-orange transition-colors duration-200">Mentions légales</a>
                <a href="#" class="text-sm hover:text-cea-orange transition-colors duration-200">Politique de confidentialité</a>
                <a href="#" class="text-sm hover:text-cea-orange transition-colors duration-200">CGU</a>
                <p class="text-sm">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Tous droits réservés.</p>
            </div>
        </div>

        <!-- Right Section: 3 Columns -->
        <div class="footer-right">
            <!-- Column 1: Liens utiles -->
            <div class="footer-widget">
                <h2>Liens utiles</h2>
                <?php
                if (function_exists('get_field') && $footer_page_id):
                    $useful_links = get_field('useful_links', $footer_page_id);
                    if ($useful_links): ?>
                        <div class="useful-links-content space-y-3">
                            <?php
                            $dom = new DOMDocument();
                            @$dom->loadHTML("<?xml encoding=\"UTF-8\">{$useful_links}", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                            $links = $dom->getElementsByTagName('a');
                            foreach ($links as $link) {
                                if ($link instanceof DOMElement) {
                                    $existing_class = $link->getAttribute('class');
                                    $link->setAttribute('class', trim("{$existing_class} btn-primary"));
                                }
                            }
                            echo $dom->saveHTML();
                            ?>
                        </div>
                    <?php endif;
                else: ?>
                    <ul class="space-y-3">
                        <li><a href="https://www.he-ferrer.eu/" target="_blank" rel="noopener" class="btn-primary">HEFF</a></li>
                        <li><a href="https://cerclehermes.be/" target="_blank" rel="noopener" class="btn-primary">Cercle Hermès</a></li>
                        <li><a href="https://fef.be/" target="_blank" rel="noopener" class="btn-primary">FEF</a></li>
                        <li><a href="https://www.comdel.be/" target="_blank" rel="noopener" class="btn-primary">Comdel</a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Column 2: Réseaux sociaux -->
            <div class="footer-widget">
                <h2>Réseaux sociaux</h2>
                <div class="footer-socials">
                    <?php if (function_exists('get_field') && $footer_page_id && get_field('social_facebook', $footer_page_id)): ?>
                        <a href="<?php echo esc_url(get_field('social_facebook', $footer_page_id)); ?>" target="_blank" rel="noopener" class="text-black hover:text-cea-orange transition-colors duration-200" aria-label="Facebook">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php if (function_exists('get_field') && $footer_page_id && get_field('social_instagram', $footer_page_id)): ?>
                        <a href="<?php echo esc_url(get_field('social_instagram', $footer_page_id)); ?>" target="_blank" rel="noopener" class="text-black hover:text-cea-orange transition-colors duration-200" aria-label="Instagram">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z" />
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php if (function_exists('get_field') && $footer_page_id && get_field('social_linkedin', $footer_page_id)): ?>
                        <a href="<?php echo esc_url(get_field('social_linkedin', $footer_page_id)); ?>" target="_blank" rel="noopener" class="text-black hover:text-cea-orange transition-colors duration-200" aria-label="LinkedIn">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Column 3: Contact -->
            <div class="footer-widget">
                <h2>Contact</h2>
                <ul class="space-y-3 text-sm">
                    <?php
                    $email = function_exists('get_field') && $footer_page_id ? get_field('contact_email', $footer_page_id) : 'cea@he-ferrer.eu';
                    if ($email): ?>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-black mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="text-black hover:text-cea-orange transition-colors duration-200">
                                <?php echo esc_html($email); ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $address = function_exists('get_field') && $footer_page_id ? get_field('contact_address', $footer_page_id) : 'L411 33, Quai de Willebroeck 1000 - Bruxelles';
                    if ($address): ?>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-black mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-black"><?php echo nl2br(esc_html($address)); ?></span>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>