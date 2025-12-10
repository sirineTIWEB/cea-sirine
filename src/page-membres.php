<?php
/**
 * Template Name: Page Membres
 * Template for displaying CA composition by year
 */

get_header();

// Get all composition_ca posts ordered by year
$args = array(
    'post_type' => 'composition_ca',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
);

$compositions = new WP_Query($args);

$composition_data = array();

if ($compositions->have_posts()):
    $first = true;

    // Collect all compositions data
    while ($compositions->have_posts()):
        $compositions->the_post();
        $annee = get_field('annee_academique');
        $postes = get_field('postes_du_ca');

        // Ensure $postes is an array
        if ($annee && $postes && is_array($postes)):
            $composition_data[] = array(
                'annee' => $annee,
                'postes' => $postes,
                'is_current' => $first
            );
            $first = false;
        endif;
    endwhile;
endif;
?>

<main id="primary" class="site-main">
    <div class="container-cea py-12 md:py-16">

        <div class="header-section">
            <div class="header-title">
                <h1>Le Conseil Étudiants d'Administration</h1>
                <h3>Ses membres
                    <?php
                    $current = array_filter($composition_data, fn($d) => $d['is_current']);
                    echo !empty($current) ? esc_html(reset($current)['annee']) : '';
                    ?>
                </h3>
            </div>
            <div class="select-wrapper header-btn">
                <select id="annee-select" class="btn-primary select-year">
                    <?php foreach ($composition_data as $index => $data): ?>
                        <option value="<?php echo $index; ?>" <?php echo $data['is_current'] ? 'selected' : ''; ?>>
                            <?php echo esc_html($data['annee']); ?>
                            <?php echo $data['is_current'] ? ' (Actuel)' : ''; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <?php

        if (!empty($composition_data)): ?>

            <!-- Compositions Container -->
            <?php foreach ($composition_data as $index => $data): ?>
                <div class="composition-ca" data-composition-index="<?php echo $index; ?>"
                    style="<?php echo !$data['is_current'] ? 'display: none;' : ''; ?>">

                    <div class="cea-grid">
                        <?php
                        // Display postes in the order they appear in the repeater field
                        if (is_array($data['postes'])):
                            foreach ($data['postes'] as $poste):
                                $membre = $poste['membre'];
                                $fonction_value = $poste['fonction'];

                                // Get the label for the fonction field
                                $fonction_field = get_field_object('postes_du_ca');
                                $fonction_label = $fonction_value;
                                if ($fonction_field && isset($fonction_field['sub_fields'])) {
                                    foreach ($fonction_field['sub_fields'] as $sub_field) {
                                        if ($sub_field['name'] === 'fonction' && isset($sub_field['choices'][$fonction_value])) {
                                            $fonction_label = $sub_field['choices'][$fonction_value];
                                            break;
                                        }
                                    }
                                }

                                if ($membre && $fonction_value): ?>
                                    <article class="cea-membre">
                                        <div class="membre-photo">
                                            <?php if (has_post_thumbnail($membre->ID)): ?>

                                                <?php echo get_the_post_thumbnail($membre->ID, 'medium', array('class' => 'w-full h-[40vh] object-cover hover:scale-110 transition-transform duration-300')); ?>
                                            <?php endif; ?>
                                        </div>

                                        <div class="membre-info">
                                            <p class="fonction-badge">
                                                <?php echo esc_html($fonction_label); ?>
                                            </p>
                                            <div>
                                                <h2 class="membre-title">
                                                    <?php echo esc_html($membre->post_title); ?>
                                                </h2>

                                                <?php
                                                // Get études field
                                                $etudes = get_field('etudes', $membre->ID);
                                                if ($etudes): ?>
                                                    <h3 class="membre-etudes">
                                                        <?php echo esc_html($etudes); ?>
                                                    </h3>
                                                <?php endif; ?>
                                            </div>

                                            <?php
                                            // Get the full content of the membre post
                                            $membre_content = get_post_field('post_content', $membre->ID);
                                            if ($membre_content): ?>
                                                <div class="membre-content-wrapper">
                                                    <h3 class="membre-content" data-full-content="<?php echo esc_attr($membre_content); ?>">
                                                        <?php echo ($membre_content); ?>
                                                    </h3>
                                                    <span class="membre-expand">...plus</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                    </article>
                                <?php endif;
                            endforeach;
                        endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="no-composition bg-gray-100 rounded-lg p-8 text-center">
                <p class="text-gray-600 text-lg">Aucune composition du CA n'a été configurée.</p>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </div>
</main>

<?php
get_footer();