<?php
/**
 * Template Name: Contact Page
 * Template for the contact page with custom design
 */

get_header(); ?>

<section class="sub-section">
    <div class="sub-header">
        <h1 class="sub-title">Contactez le <span>CEA</span>.</h1>
        <h2>Le <span>CEA</span> a pour mission d'être à l'écoute des étudiants et de représenter leurs intérêts au sein de l'établissement.</h2>
    </div>
    <div class="sub-form">
        <?php echo do_shortcode('[contact-form-7 id="ae60c9d" title="Formulaire de contact 1"]'); ?>
    </div>
</section>

<?php get_footer(); ?>
