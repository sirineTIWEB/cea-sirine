<?php
/**
 * The home template file for displaying all actualit�s
 * This template is used as a fallback to display all news posts
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="header-section">
        <div class="header-title">
            <h1>Actualités</h1>
            <h3>Toutes les actualités du CEA</h3>
        </div>

        <div class="header-btn">
            <form method="get" action="" class="select-wrapper">
                <label for="tri" class="sr-only">Trier par</label>
                <select name="tri" id="tri" onchange="this.form.submit()" class="select-year btn-nav">
                    <option value="recent" <?php selected(isset($_GET['tri']) ? $_GET['tri'] : '', 'recent'); ?>>
                        Du plus récent
                    </option>
                    <option value="ancien" <?php selected(isset($_GET['tri']) ? $_GET['tri'] : '', 'ancien'); ?>>
                        Du plus ancien
                    </option>
                </select>
            </form>
        </div>
    </div>

    <?php
    // Handle sorting
    $order = 'DESC'; // Default: most recent first
    if (isset($_GET['tri']) && $_GET['tri'] === 'ancien') {
        $order = 'ASC';
    }

    // Query all posts
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 10,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => $order
    );
    $news_query = new WP_Query($args);

    if ($news_query->have_posts()): ?>

        <section class="activities-section">
            <?php while ($news_query->have_posts()):
                $news_query->the_post(); ?>
                <article class="activity-card">
                    <div class="activity-info">
                        <p><?php echo get_the_date(); ?></p>
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
        <?php if ($news_query->max_num_pages > 1): ?>
            <div class="grid grid-cols-12 my-12">
                <div class="col-start-2 col-span-10">
                    <?php
                    echo paginate_links(array(
                        'total' => $news_query->max_num_pages,
                        'current' => $paged,
                        'mid_size' => 2,
                        'prev_text' => '← Précédent',
                        'next_text' => 'Suivant →',
                        'before_page_number' => '',
                        'type' => 'list'
                    ));
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    <?php else: ?>

        <div class="header-section">
            <div class="header-title">
                <h1>Aucune actualité trouvée</h1>
                <h3>Il semble qu'aucune actualité n'ait encore été publiée.</h3>
            </div>
        </div>

    <?php endif; ?>
</main>

<?php get_footer(); ?>
