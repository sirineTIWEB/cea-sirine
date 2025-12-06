<?php
/**
 * The template for displaying archive pages
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container-cea py-12">
        <?php if (have_posts()): ?>

            <header class="page-header text-center mb-12">
                <?php
                the_archive_title('<h1 class="page-title text-3xl md:text-4xl font-bold text-gray-800 mb-4">', '</h1>');
                the_archive_description('<div class="archive-description text-lg text-gray-600 max-w-3xl mx-auto">', '</div>');
                ?>
            </header>

            <!-- News Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while (have_posts()): ?>
                    <?php the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('card group hover:shadow-2xl transition-all duration-300'); ?>>
                        <?php if (has_post_thumbnail()): ?>
                            <div class="post-thumbnail overflow-hidden rounded-t-xl -m-6 mb-6">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="block">
                                    <?php the_post_thumbnail('medium_large', array(
                                        'class' => 'w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300'
                                    )); ?>
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="post-thumbnail overflow-hidden rounded-t-xl -m-6 mb-6">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="block">
                                    <div
                                        class="w-full h-48 bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center">
                                        <span class="text-white text-6xl opacity-30">
                                            <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z">
                                                </path>
                                            </svg>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>

                        <header class="entry-header mb-4">
                            <?php
                            the_title('<h2 class="entry-title text-xl font-bold"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="text-gray-800 hover:text-blue-700 transition-colors duration-200 no-underline line-clamp-2">', '</a></h2>');
                            ?>
                        </header>

                        <div class="entry-meta text-sm text-gray-500 mb-4 flex items-center space-x-4">
                            <span class="posted-on flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <?php echo get_the_date(); ?>
                            </span>
                            <?php if (has_category()): ?>
                                <span class="cat-links flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                        </path>
                                    </svg>
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        echo esc_html($categories[0]->name);
                                    }
                                    ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="entry-content mb-6">
                            <div class="text-gray-600 line-clamp-3">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>

                        <footer class="entry-footer">
                            <a href="<?php echo esc_url(get_permalink()); ?>"
                                class="inline-flex items-center text-blue-700 hover:text-blue-800 font-semibold transition-colors duration-200">
                                <?php esc_html_e('Lire la suite', 'theme-cea-prof'); ?>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        </footer>
                    </article>

                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                <?php
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>',
                    'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
                    'before_page_number' => '<span class="sr-only">Page</span>',
                    'class' => 'pagination flex space-x-2'
                ));
                ?>
            </div>

        <?php else: ?>

            <section class="no-results not-found text-center py-16">
                <header class="page-header mb-8">
                    <h1 class="page-title text-3xl font-bold text-gray-800 mb-4">
                        <?php esc_html_e('Aucun article trouvé', 'theme-cea-prof'); ?></h1>
                </header>

                <div class="page-content max-w-2xl mx-auto">
                    <p class="text-lg text-gray-600 mb-8">
                        <?php esc_html_e('Il semble qu\'aucun article ne corresponde à votre recherche.', 'theme-cea-prof'); ?>
                    </p>

                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary inline-block">
                        <?php esc_html_e('Retour à l\'accueil', 'theme-cea-prof'); ?>
                    </a>
                </div>
            </section>

        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
?>