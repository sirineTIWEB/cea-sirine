<?php
/**
 * The template for info page
 */

get_header(); ?>

<main id="primary" class="site-main lg:gap-12">
    <!-- c quoi CEA  -->
    <div class="def-grid">
        <div class="def-title">
            <h1>Qu’est-ce que le <span>CEA</span> ?</h1>
            <h3>Le Conseil des Étudiants Administrateurs <span>CEA</span> est l’organe représentatif des étudiants de la
                Haute École Fransisco Ferrer. Indépendant et reconnu officiellement comme le stipule le décret
                participation, nous menons 7 missions différentes :</h3>
        </div>
        <div class="def-content">
            <div class="def-mission">
                <h1>1.</h1>
                <h3>Représenter les étudiants de l’établissement</h3>
            </div>
            <div class="def-mission">
                <h1>2.</h1>
                <h3>Défendre et promouvoir les intérêts des étudiants</h3>
            </div>
            <div class="def-mission">
                <h1>3.</h1>
                <h3>Suciter la participation active des étudiants</h3>
            </div>
            <div class="def-mission">
                <h1>4.</h1>
                <h3>Assurer la circulation de l’information entre les autorités et les étudiants</h3>
            </div>
            <div class="def-mission">
                <h1>5.</h1>
                <h3>Participer à la formation des représentants des étudiants</h3>
            </div>
            <div class="def-mission">
                <h1>6.</h1>
                <h3>Désigner les mandataires des étudiants au sein des organes de la HEFF</h3>
            </div>
            <div class="def-mission">
                <h1>7.</h1>
                <h3>Informer les étudiants</h3>
            </div>
        </div>
    </div>

    <!-- Compo Bureau -->
    <div>
        <div class="header-section">
            <div class="header-title">
                <h1>Composition du Bureau</h1>
                <h3>Il est composé des membres élus par l'assemblée générale pour gérer le conseil étudiant au
                    quotidien.
                    Bien que nous soyons partisans d'une certaine horizontalité, certains postes doivent être donnés
                    (toujours selon le décret participation).</h3>
            </div>
        </div>
        <div class="bureau-section">
            <article class="bureau-card">
                <p class="bureau-info">
                    la porte parole du CEA, à l'intérieur comme à l'extérieur de la HEFF. Elle préside nos réunions et
                    coordonne nos actions.
                </p>

                <h1 class="bureau-title">
                    La présidence
                </h1>
            </article>
            <article class="bureau-card">
                <p class="bureau-info">
                    Elle gère les ressources financières du CEA (budget, factures, notes de frais, comptabilité, caisse,
                    etc.).
                </p>

                <h1 class="bureau-title">
                    La trésorerie
                </h1>
            </article>
            <article class="bureau-card">
                <p class="bureau-info">
                    Il s'assure du respect du décret en faisant respecter l'échéancier. Il s'occupe de l'organisation
                    pratique du CEA, de l'archivage, du planning et de vraiment beaucoup de choses (c'est le job le plus
                    important, si, si).
                </p>

                <h1 class="bureau-title">
                    Le secrétariat
                </h1>
            </article>
            <article class="bureau-card">
                <p class="bureau-info">
                    Il s'occupe de nos réseaux et de notre propagande sous toutes ses formes.
                </p>

                <h1 class="bureau-title">
                    Le gourou
                </h1>
            </article>

        </div>

    </div>

    <!-- FEF -->

    <?php if (get_field('membre_fef_cette_annee')): ?>
        <div class="fef-grid">
            <h1>La Fédération des Étudiants Francophones</h1>
            <h3>La FEF est un Organe de Représentation Communautaire qui assiste les conseils étudiants dans leurs missions. Elle permet aussi de faire le lien entre les conseils des différentes Universités, HE et ESA pour organiser des dialogues à grande échelle et/ou exprimer leurs idées au travers de vastes manifestations. Chaque année, nous pouvons choisir ou non de nous réaffilier à cet organe.</h3>

        </div>
    <?php endif; ?>


</main>

<?php
get_footer();
?>