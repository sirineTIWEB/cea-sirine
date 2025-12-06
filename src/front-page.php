<?php
/**
 * The template for displaying the front page
 */

get_header(); ?>

<main id="primary" class="site-main">
    <?php while (have_posts()): ?>
        <?php the_post(); ?>

        <!-- Hero Section -->
        <section class="hero-section w-screen my-20 flex flex-col gap-12">
            <div class="px-24 flex justify-between items-end">
                <div>
                    <h1>Bienvenue au <span>CEA</span>.</h1>
                    <p>Le site du Conseil des Étudiants Administateurs de la Haute École Fransisco-Ferrer</p>
                </div>
                <a href="" class="btn-primary">Découvrir →</a>
            </div>
            <?php if (has_post_thumbnail()): ?>
                <div class="w-screen h-[40vh] bg-cover overflow-hidden">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php endif; ?>
            <div class="w-full flex justify-end pr-24 w-2/3">
                <h2><?php
                if (is_singular()):
                    the_content();
                else:
                    the_excerpt();
                endif;
                ?></h2>
            </div>
        </section>

    <?php endwhile; ?>

    <!-- Upcoming Activities Section -->
    <section class="activities-section">
        <div class="container-cea">
            <h2>Prochaines activit�s</h2>

            <?php
            // Query for upcoming events using Events Manager
            $today = date('Y-m-d');
            $args = array(
                'post_type' => 'event',
                'posts_per_page' => 3,
                'meta_key' => '_event_start_date',
                'orderby' => 'meta_value',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => '_event_start_date',
                        'value' => $today,
                        'compare' => '>=',
                        'type' => 'DATE'
                    )
                )
            );

            $activities = new WP_Query($args);

            if ($activities->have_posts()): ?>
                <div>
                    <?php while ($activities->have_posts()):
                        $activities->the_post();
                        $event_id = get_the_ID();
                        $event_start_date = get_post_meta($event_id, '_event_start_date', true);
                        $event_start_time = get_post_meta($event_id, '_event_start_time', true);
                        $event_location = get_post_meta($event_id, '_location_name', true);
                        ?>
                        <article class="activity-card">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="activity-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="activity-content">
                                <h3>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <?php if ($event_start_date): ?>
                                    <div class="activity-date">
                                        <svg viewBox="0 0 24 24">
                                            <path
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span>
                                            <?php echo date_i18n('d/m/Y', strtotime($event_start_date)); ?>
                                            <?php if ($event_start_time): ?>
                                                � <?php echo date('H:i', strtotime($event_start_time)); ?>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($event_location): ?>
                                    <div class="activity-location">
                                        <svg viewBox="0 0 24 24">
                                            <path
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span><?php echo esc_html($event_location); ?></span>
                                    </div>
                                <?php endif; ?>

                                <a href="<?php the_permalink(); ?>">
                                    Voir le d�tail
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div>
                    <a href="<?php echo home_url('/activites/'); ?>">
                        Toutes les activit�s
                    </a>
                </div>

            <?php else: ?>
                <p>Aucune activit� � venir pour le moment.</p>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="news-section">
        <div class="container-cea">
            <h2>Derni�res actualit�s</h2>

            <?php
            // Query for latest news posts
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC',
            );

            $news = new WP_Query($args);

            if ($news->have_posts()): ?>
                <div>
                    <?php while ($news->have_posts()):
                        $news->the_post(); ?>
                        <article class="news-card">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="news-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="news-content">
                                <div class="news-meta">
                                    <?php echo get_the_date(); ?>
                                </div>

                                <h3>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <?php if (has_excerpt()): ?>
                                    <div class="news-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endif; ?>

                                <a href="<?php the_permalink(); ?>">
                                    Lire la suite
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div>
                    <a href="<?php echo home_url('/actualites/'); ?>">
                        Toutes les actualit�s
                    </a>
                </div>

            <?php else: ?>
                <p>Aucune actualit� pour le moment.</p>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </section>

    <!-- Latest Projects Section -->
    <section class="projects-section">
        <div class="container-cea">
            <h2>Derniers projets</h2>

            <?php
            // Query for latest projects
            $args = array(
                'post_type' => 'projet',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC',
            );

            $projects = new WP_Query($args);

            if ($projects->have_posts()): ?>
                <div>
                    <?php while ($projects->have_posts()):
                        $projects->the_post(); ?>
                        <article class="project-card">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="project-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="project-content">
                                <h3>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <?php if (has_excerpt()): ?>
                                    <div class="project-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endif; ?>

                                <a href="<?php the_permalink(); ?>">
                                    Voir le projet
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div>
                    <a href="<?php echo home_url('/projets/'); ?>">
                        Tous les projets
                    </a>
                </div>

            <?php else: ?>
                <p>Aucun projet pour le moment.</p>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </section>

</main>

<?php
get_footer();
?>