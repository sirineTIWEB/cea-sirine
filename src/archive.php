<?php
/**
 * The template for displaying archive pages
 */

get_header(); ?>

<main id="primary" class="site-main">
    <?php if (have_posts()): ?>

        <div class="header-section">
            <div class="header-title">
                <?php
                if (is_category()) {
                    echo '<h1>' . single_cat_title('', false) . ' ARCH</h1>';
                } elseif (is_tag()) {
                    echo '<h1>Tag: ' . single_tag_title('', false) . ' ARCH</h1>';
                } elseif (is_author()) {
                    echo '<h1>Auteur: ' . get_the_author() . ' ARCH</h1>';
                } elseif (is_date()) {
                    echo '<h1>Archives</h1>';
                } else {
                    echo '<h1>Archives</h1>';
                }
                ?>
                <?php if (get_the_archive_description()): ?>
                    <h3><?php echo wp_kses_post(get_the_archive_description()); ?></h3>
                <?php endif; ?>
            </div>
        </div>

        <section class="activities-section">
            <?php while (have_posts()):
                the_post(); ?>
                <article class="activity-card">
                    <div class="activity-info">
                        <p><?php echo get_the_date(); ?></p>
                        <?php
                        $categories = get_the_category();
                        if (!empty($categories)): ?>
                            <p><?php echo esc_html($categories[0]->name); ?></p>
                        <?php endif; ?>
                    </div>

                    <h1 class="activity-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h1>

                    <a class="btn-icon activity-btn" href="<?php the_permalink(); ?>">
                        →
                    </a>
                </article>
            <?php endwhile; ?>
        </section>

        <!-- Pagination -->
        <?php if (paginate_links()): ?>
            <div class="grid grid-cols-12 my-12">
                <div class="col-start-2 col-span-10">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '← Précédent',
                        'next_text' => 'Suivant →',
                        'before_page_number' => '',
                        'class' => 'pagination'
                    ));
                    ?>
                </div>
            </div>
        <?php endif; ?>

    <?php else: ?>

        <div class="header-section">
            <div class="header-title">
                <h1>Aucun article trouvé</h1>
                <h3>Il semble qu'aucun article ne corresponde à votre recherche.</h3>
            </div>
            <a data-text="← Retour à l'accueil" href="<?php echo esc_url(home_url('/')); ?>" class="header-btn btn-primary-reverse">
                ← Retour à l'accueil
            </a>
        </div>

    <?php endif; ?>
</main>

<?php get_footer(); ?>