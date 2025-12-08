<?php
/**
 * Template Name: Page Projets
 * Template for displaying Projects page
 */

get_header(); ?>

<main id="primary" class="site-main">

    <section class="news-section">
        <div class="container-cea">
            <div class="header-section">
                <div class="header-title">
                    <h1>Projets en cours</h1>
                </div>
            </div>

            <?php
            // Query for ongoing projects (latest 2)
            $args_current = array(
                'post_type' => 'projet',
                'posts_per_page' => 2,
                'orderby' => 'date',
                'order' => 'DESC',
            );

            $projets_current = new WP_Query($args_current);
            $exclude_ids = array();

            // Store projects data for JavaScript carousel
            $projects_data = array();
            if ($projets_current->have_posts()) {
                while ($projets_current->have_posts()) {
                    $projets_current->the_post();
                    $exclude_ids[] = get_the_ID();
                    $projects_data[] = array(
                        'title' => get_the_title(),
                        'excerpt' => get_the_excerpt(),
                        'date' => get_the_date(),
                        'permalink' => get_the_permalink(),
                        'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
                        'thumbnail_medium' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                    );
                }
                // Rewind the posts so we can loop through them again
                $projets_current->rewind_posts();
            }

            if ($projets_current->have_posts()):
                $projets_current->the_post();
                // Get the FIRST project
                ?>
                <div class="news-grid grid grid-cols-12 grid-rows-2"
                    data-news-articles='<?php echo json_encode($projects_data, JSON_HEX_APOS | JSON_HEX_QUOT); ?>'>
                    <article class="news-card">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="news-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large', ['class' => 'h-full w-auto object-cover']); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="news-content">
                            <div class="news-meta">
                                <a class="btn-secondary" href="<?php the_permalink(); ?>">
                                    Voir le projet
                                </a>
                                <p>
                                    <?php echo get_the_date(); ?>
                                </p>
                            </div>

                            <div>
                                <h2>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <?php if (has_excerpt()): ?>
                                    <h3 class="news-excerpt">
                                        <?php the_excerpt(); ?>
                                    </h3>
                                <?php endif; ?>
                            </div>

                        </div>
                    </article>

                    <?php
                    // Get the SECOND project if it exists
                    if ($projets_current->have_posts()):
                        $projets_current->the_post();
                        ?>
                        <div class="btn-prevcard">
                            <button id="btn-news-prev">←</button>
                            <button id="btn-news-next">→</button>
                        </div>
                        <article class="news-prevcard">
                            <p>
                                <?php echo get_the_date(); ?>
                            </p>
                            <div class="news-prevthumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                                </a>
                            </div>
                        </article>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <p>Aucun projet en cours pour le moment.</p>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </section>

    <section class="activities-section">
        <div class="header-section">
            <div class="header-title">
                <h1>Projets passés</h1>
            </div>
        </div>

        <?php
        // Query for past projects (exclude the 2 ongoing ones)
        $args_past = array(
            'post_type' => 'projet',
            'posts_per_page' => -1,
            'post__not_in' => $exclude_ids,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $projets_past = new WP_Query($args_past);

        if ($projets_past->have_posts()): ?>
            <div class="activities-section">
                <?php while ($projets_past->have_posts()):
                    $projets_past->the_post();
                    ?>
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
            </div>

        <?php else: ?>
            <div class="border-t grid grid-cols-12 border-t-black">
                <h1 class="col-start-6 col-span-5">Aucun projet passé pour le moment.</h1>
            </div>

        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </section>


</main>
<?php get_footer(); ?>
