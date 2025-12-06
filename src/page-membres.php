<?php
/**
 * Template Name: Page Membres
 * Template for displaying CA composition by year
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container-cea py-12 md:py-16">

        <?php while (have_posts()):
            the_post(); ?>

            <header class="page-header mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    <?php the_title(); ?>
                </h1>

                <?php if (get_the_content()): ?>
                    <div class="page-intro text-lg text-gray-600 max-w-3xl mb-8">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            </header>

        <?php endwhile; ?>

        <?php
        // Get all composition_ca posts ordered by year
        $args = array(
            'post_type' => 'composition_ca',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $compositions = new WP_Query($args);

        if ($compositions->have_posts()):
            $first = true;
            $composition_data = array();

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

            if (!empty($composition_data)): ?>

                <!-- Year Selector -->
                <div class="year-selector mb-8">
                    <label for="annee-select" class="block text-lg font-semibold text-gray-900 mb-3">
                        Sélectionner l'année académique :
                    </label>
                    <select id="annee-select"
                        class="w-full md:w-auto px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:border-gray-400">
                        <?php foreach ($composition_data as $index => $data): ?>
                            <option value="<?php echo $index; ?>" <?php echo $data['is_current'] ? 'selected' : ''; ?>>
                                <?php echo esc_html($data['annee']); ?>
                                <?php echo $data['is_current'] ? ' (Actuel)' : ''; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Compositions Container -->
                <?php foreach ($composition_data as $index => $data): ?>
                    <div class="composition-ca" data-composition-index="<?php echo $index; ?>"
                        style="<?php echo !$data['is_current'] ? 'display: none;' : ''; ?>">

                        <div class="ca-header mb-8 pb-6 border-b-2 border-blue-600">
                            <h2 class="text-3xl font-bold text-gray-900">
                                Conseil d'Administration <?php echo esc_html($data['annee']); ?>
                            </h2>
                        </div>

                        <div class="ca-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                                    <article
                                        class="ca-membre bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">

                                        <?php if (has_post_thumbnail($membre->ID)): ?>
                                            <div class="membre-photo">
                                                <?php echo get_the_post_thumbnail($membre->ID, 'medium', array('class' => 'w-full h-64 object-cover')); ?>
                                            </div>
                                        <?php else: ?>
                                            <div
                                                class="membre-photo-placeholder bg-gradient-to-br from-blue-400 to-blue-600 h-64 flex items-center justify-center">
                                                <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        <?php endif; ?>

                                        <div class="membre-info p-6">
                                            <div
                                                class="fonction-badge inline-block px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 mb-3">
                                                <?php echo esc_html($fonction_label); ?>
                                            </div>

                                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                                <?php echo esc_html($membre->post_title); ?>
                                            </h3>

                                            <?php
                                            // Get études field
                                            $etudes = get_field('etudes', $membre->ID);
                                            if ($etudes): ?>
                                                <div class="membre-etudes text-gray-700 text-sm font-medium mb-2">
                                                    <?php echo esc_html($etudes); ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php
                                            // Get the full content of the membre post
                                            $membre_content = get_post_field('post_content', $membre->ID);
                                            if ($membre_content): ?>
                                                <div class="membre-content text-gray-600 text-sm mt-3">
                                                    <?php echo wpautop($membre_content); ?>
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

        <?php else: ?>
            <div class="no-composition bg-gray-100 rounded-lg p-8 text-center">
                <p class="text-gray-600 text-lg">Aucune composition du CA n'a été trouvée.</p>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('annee-select');
        const compositions = document.querySelectorAll('.composition-ca');

        if (select && compositions.length > 0) {
            select.addEventListener('change', function () {
                const selectedIndex = this.value;

                // Hide all compositions
                compositions.forEach(function (composition) {
                    composition.style.display = 'none';
                });

                // Show selected composition with fade effect
                const selectedComposition = document.querySelector('[data-composition-index="' + selectedIndex + '"]');
                if (selectedComposition) {
                    selectedComposition.style.display = 'block';
                    selectedComposition.style.opacity = '0';
                    setTimeout(function () {
                        selectedComposition.style.transition = 'opacity 0.3s ease-in-out';
                        selectedComposition.style.opacity = '1';
                    }, 10);
                }
            });
        }
    });
</script>

<?php
get_footer();