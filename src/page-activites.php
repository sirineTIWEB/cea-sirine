<?php
/**
 * Template Name: Page Activités
 */

get_header();
?>

<main id="primary" class="site-main">
    <div>
        <div class="header-section">
            <div class="header-title">
                <h1>Le <span>CEA</span> organise.</h1>
                <h3>Le <span>CEA</span> Ferrer est l’organisme officiel composé des étudiants élus par la HEFF pour
                    représenter et défendre les intérêts de tous au sein de la Haute École.</h3>
            </div>
            <!-- vers div agenda -->
            <a data-text="Voir l'agenda →" href="#agenda" class="header-btn btn-primary">
                Voir l'agenda →
            </a>
        </div>

        <?php
        // Get all event categories from Events Manager
        $event_categories = EM_Categories::get();

        // Loop through each category
        if ($event_categories): ?>
            <div class="categories-section">
                <?php foreach ($event_categories as $category):
                    // Get the next upcoming event for this category
                    $upcoming_events = EM_Events::get(array(
                        'category' => $category->term_id,
                        'scope' => 'future',
                        'order' => 'ASC',
                        'limit' => 1
                    ));

                    // Get first event (EM_Events::get returns associative array with event IDs as keys)
                    $next_event = !empty($upcoming_events) ? reset($upcoming_events) : null;
                    ?>
                    <article class="category-card">
                        <div class="category-info">
                            <h3>Future programmation</h3>
                            <?php if ($next_event): ?>
                                <p>
                                    <?php echo date_i18n('d/m/Y', strtotime($next_event->event_start_date)); ?>
                                    <?php if ($next_event->event_start_time): ?>
                                        - <?php echo date('H:i', strtotime($next_event->event_start_time)); ?>
                                    <?php endif; ?>
                                </p>
                                <?php
                                $location = $next_event->get_location();
                                if ($location && !empty($location->location_name)): ?>
                                    <p><?php echo esc_html($location->location_name); ?></p>
                                <?php endif; ?>
                            <?php else: ?>
                                <p>Aucun événement programmé</p>
                            <?php endif; ?>
                        </div>

                        <h1 class="category-title">
                            <?php echo esc_html($category->name); ?>
                        </h1>

                        <h3 class="category-description">
                            <?php echo wp_kses_post($category->description); ?>
                        </h3>

                        <div class="category-icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/<?php echo esc_attr($category->slug); ?>.svg"
                                alt="<?php echo esc_attr($category->name); ?>">
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="agenda">
        <div class="header-section">
            <div class="header-title">
                <h1>L'Agenda du <span>CEA</span>.</h1>
                <h3></h3>
            </div>
        </div>
        <div class="grid grid-cols-12">
            <div class="col-start-2 col-span-10 calendar-wrapper">
                <?php
                // Display the Events Manager calendar/agenda
                echo do_shortcode('[events_calendar]');
                ?>
            </div>
        </div>
    </div>



</main>

<?php get_footer(); ?>