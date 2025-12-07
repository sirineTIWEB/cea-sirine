<?php
/**
 * The template for displaying the front page
 */

get_header(); ?>

<main id="primary" class="site-main flex flex-col gap-32">
    <?php while (have_posts()): ?>
        <?php the_post(); ?>

        <!-- Hero Section -->
        <section class="hero-section w-screen my-20 flex flex-col gap-12">
            <div class="header-section">
                <div class="header-title">
                    <h1>Bienvenue au <span>CEA</span>.</h1>
                    <h3>Le <span>CEA</span> Ferrer est l’organisme officiel composé des étudiants élus par la HEFF pour
                        représenter et défendre les intérêts de tous au sein de la Haute École.</h3>
                </div>
                <a href="<?php echo home_url('/informations/'); ?>" class="header-btn btn-primary">En savoir plus sur le
                    <span>CEA</span></a>
            </div>
            <?php if (has_post_thumbnail()): ?>
                <div class="w-screen h-[40vh] bg-cover overflow-hidden">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php endif; ?>
            <div class="w-full grid grid-cols-12 lg:bg-white md:bg-blue-200 sm:bg-blue-300 bg-blue-400">
                <h2 class="col-start-6 col-span-6"><?php
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
        <div class="header-section">
            <div class="header-title">
                <h1>Activités à venir</h1>
                <h3>Le <span>CEA</span> Vorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc
                    vulputate libero et velit interdum, ac aliquet odio mattis.</h3>
            </div>
            <a class="header-btn btn-primary" href="<?php echo home_url('/activites/'); ?>">Toutes les activités</a>
        </div>

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
            <div class="activities-section">
                <?php while ($activities->have_posts()):
                    $activities->the_post();
                    $event_id = get_the_ID();
                    $event_start_date = get_post_meta($event_id, '_event_start_date', true);
                    $event_start_time = get_post_meta($event_id, '_event_start_time', true);
                    $event_location = get_post_meta($event_id, '_location_name', true);
                    ?>
                    <article class="activity-card">
                        <div class="activity-info">
                            <?php if ($event_start_date): ?>
                                <p>
                                    <?php echo date_i18n('d/m/Y', strtotime($event_start_date)); ?>

                                    <?php if ($event_start_time): ?>
                                        - <?php echo date('H:i', strtotime($event_start_time)); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if ($event_location): ?>
                                    <p><?php echo esc_html($event_location); ?></p>
                                <?php endif; ?>
                            </div>

                        <?php endif; ?>
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
                <h1 class="col-start-6 col-span-5">Aucune activité à venir pour le moment.</h1>
            </div>

        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </section>

    <!-- Latest News Section -->
    <section class="news-section">
        <div class="container-cea">
            <div class="header-section">
                <div class="header-title">
                    <h1>Actualités à la une</h1>
                    <h3>Le <span>CEA</span> Vorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc
                        vulputate libero et velit interdum, ac aliquet odio mattis.</h3>
                </div>
                <a class="header-btn btn-primary" href="<?php echo home_url('/actualites/'); ?>">Toutes les
                    actualités</a>
            </div>

            <?php
            // Query for latest news posts
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC',
            );

            $news = new WP_Query($args);

            // Store all articles data for JavaScript carousel
            $articles_data = array();
            if ($news->have_posts()) {
                while ($news->have_posts()) {
                    $news->the_post();
                    $articles_data[] = array(
                        'title' => get_the_title(),
                        'excerpt' => get_the_excerpt(),
                        'date' => get_the_date(),
                        'permalink' => get_the_permalink(),
                        'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
                        'thumbnail_medium' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                    );
                }
                wp_reset_postdata();
            }

            if ($news->have_posts()):
                $news->the_post();
                // Get the FIRST post (article N)
                ?>
                <div class="news-grid grid grid-cols-12 grid-rows-2"
                    data-news-articles='<?php echo json_encode($articles_data, JSON_HEX_APOS | JSON_HEX_QUOT); ?>'>
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
                                    Lire la suite
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
                    // Get the SECOND post (article N+1) if it exists
                    if ($news->have_posts()):
                        $news->the_post();
                        ?>
                        <div class="btn-prevcard">
                            <button id="btn-news-prev">←</button>
                            <button id="btn-news-next">→</button>
                        </div>
                        <article class="news-prevcard">
                            <p>
                                <?php echo get_the_date(); ?>
                            </p>
                            <?php if (has_post_thumbnail()): ?>
                                <div class="news-prevthumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </article>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <p>Aucune actualité pour le moment.</p>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </section>

    <!-- Latest Projects Section -->
    <section class="projects-section">
        <div class="container-cea">
            <div class="header-section">
                <div class="header-title">
                    <h1>Derniers projets</h1>
                    <h3>Le <span>CEA</span> Vorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc
                        vulputate libero et velit interdum, ac aliquet odio mattis.</h3>
                </div>
                <a class="header-btn btn-primary" href="<?php echo home_url('/projets/'); ?>">Tous les projets</a>
            </div>

            <?php
            // Query for latest projects
            $args = array(
                'post_type' => 'projet',
                'posts_per_page' => 5,
                'orderby' => 'date',
                'order' => 'DESC',
            );

            $projects = new WP_Query($args);

            // Store all projects data for JavaScript carousel
            $projects_data = array();
            if ($projects->have_posts()) {
                while ($projects->have_posts()) {
                    $projects->the_post();
                    $projects_data[] = array(
                        'title' => get_the_title(),
                        'excerpt' => get_the_excerpt(),
                        'date' => get_the_date('d.m'),
                        'permalink' => get_the_permalink(),
                        'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                    );
                }
                wp_reset_postdata();
            }

            if ($projects->have_posts()): ?>
                <div class="projects-grid"
                    data-projects='<?php echo json_encode($projects_data, JSON_HEX_APOS | JSON_HEX_QUOT); ?>'>

                    <!-- Single arrow button that changes direction -->
                    <button id="btn-projects-navigate" data-direction="right">→</button>
                    <div class="flex items-start gap-19">

                    <?php
                    // Display the first 2 projects
                    $count = 0;
                    while ($projects->have_posts() && $count < 2):
                        $projects->the_post();
                        $count++;
                        ?>
                        <article class="project-card project-card-<?php echo $count; ?>">
                            <h1 class="w-fit"><span class="text-cea-orange"><?php echo get_the_date('d.m'); ?></span></h1>


                            <div class="project-thumbnail">
                                <?php if (has_post_thumbnail()): ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="project-content">
                                <h2 class="w-fit">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <?php if (has_excerpt()): ?>
                                    <h3 class="project-excerpt">
                                        <?php the_excerpt(); ?>
                                    </h3>
                                <?php endif; ?>

                                <a class="btn-secondary" href="<?php the_permalink(); ?>">
                                    En savoir plus
                                </a>
                            </div>

                        </article>
                    <?php endwhile; ?>
                    </div>
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