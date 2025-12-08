<?php
/**
 * Template for displaying single event posts
 */

get_header();
?>

<main id="primary">
    <?php while (have_posts()):
        the_post();

        $event_id = get_the_ID();
        $event = em_get_event($event_id, 'post_id');

        // Get event meta data
        $event_start_date = $event->event_start_date;
        $event_end_date = $event->event_end_date;
        $event_start_time = $event->event_start_time;
        $event_end_time = $event->event_end_time;
        $location = $event->get_location();
        $categories = $event->get_categories();
        ?>

        <!-- Back to Activities - Top Left -->
        <div class="grid grid-cols-12 pt-8">
            <div class="col-start-2">
                <a href="<?php echo home_url('/activites/'); ?>" class="btn-nav">
                    ← Retour aux activités
                </a>
            </div>
        </div>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Hero Section -->
            <section class="hero-section w-screen my-20 flex flex-col gap-12">
                <div class="header-section">
                    <div class="header-title">
                        <h1><?php the_title(); ?></h1>

                        <div class="event-meta">
                            <?php if ($event_start_date): ?>
                                <p>
                                    <span>Date:</span>
                                    <?php
                                    echo date_i18n('d/m/Y', strtotime($event_start_date));
                                    if ($event_start_date !== $event_end_date && $event_end_date) {
                                        echo ' - ' . date_i18n('d/m/Y', strtotime($event_end_date));
                                    }
                                    ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($event_start_time): ?>
                                <p>
                                    <span>Heure:</span>
                                    <?php
                                    echo date('H:i', strtotime($event_start_time));
                                    if ($event_end_time && $event_start_time !== $event_end_time) {
                                        echo ' - ' . date('H:i', strtotime($event_end_time));
                                    }
                                    ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($location && $location->location_name): ?>
                                <p>
                                    <span>Lieu:</span> <?php echo esc_html($location->location_name); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($categories)): ?>
                        <div class="event-categories">
                            <?php foreach ($categories as $category): ?>
                                <a href="<?php echo get_term_link($category); ?>" class="btn-secondary">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (has_post_thumbnail()): ?>
                    <div class="w-screen h-[40vh] bg-cover overflow-hidden">
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Event Content Section -->
            <section class="container-cea">
                <div class="grid grid-cols-12 gap-8 my-12">
                    <div class="col-start-2 col-span-10 lg:col-start-3 lg:col-span-8">
                        <div class="event-content">
                            <?php the_content(); ?>
                        </div>

                        <?php
                        // Display location details if available
                        if ($location && ($location->location_address || $location->location_town)): ?>
                            <div class="event-location-details mt-12 p-6 bg-gray-50 rounded-lg">
                                <h3 class="mb-4">Détails du lieu</h3>

                                <?php if ($location->location_address): ?>
                                    <p class="mb-2">
                                        <strong>Adresse:</strong> <?php echo esc_html($location->location_address); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if ($location->location_town): ?>
                                    <p class="mb-2">
                                        <strong>Ville:</strong> <?php echo esc_html($location->location_town); ?>
                                        <?php if ($location->location_postcode): ?>
                                            <?php echo esc_html($location->location_postcode); ?>
                                        <?php endif; ?>
                                    </p>
                                <?php endif; ?>

                                <?php if ($location->location_country): ?>
                                    <p class="mb-2">
                                        <strong>Pays:</strong> <?php echo esc_html($location->location_country); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Event Booking Section (if enabled) -->
                        <?php if ($event->event_rsvp): ?>
                            <div class="event-booking mt-12 p-6 bg-blue-50 rounded-lg">
                                <h3 class="mb-4">Réservation</h3>
                                <?php echo $event->output_single('#_BOOKINGFORM'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- Event Navigation -->
            <?php
            // Get next and previous events
            $current_event_id = get_the_ID();

            // Get next event
            $next_events = EM_Events::get(array(
                'scope' => 'future',
                'order' => 'ASC',
                'limit' => 1,
                'post__not_in' => array($current_event_id)
            ));
            $next_event = !empty($next_events) ? reset($next_events) : null;

            // Get previous event
            $prev_events = EM_Events::get(array(
                'scope' => 'past',
                'order' => 'DESC',
                'limit' => 1,
                'post__not_in' => array($current_event_id)
            ));
            $prev_event = !empty($prev_events) ? reset($prev_events) : null;
            ?>

            <?php if ($next_event || $prev_event): ?>
                <section class="container-cea my-12">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-start-2 col-span-10 flex justify-between items-center">
                            <?php if ($prev_event): ?>
                                <a href="<?php echo get_permalink($prev_event->post_id); ?>" class="btn-nav">
                                    ← Événement précédent
                                </a>
                            <?php else: ?>
                                <div></div>
                            <?php endif; ?>

                            <?php if ($next_event): ?>
                                <a href="<?php echo get_permalink($next_event->post_id); ?>" class="btn-nav">
                                    Événement suivant →
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
