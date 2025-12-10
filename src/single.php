<?php
/**
 * The template for displaying single posts
 */

get_header(); ?>

<main id="primary" class="site-main">
    <?php while (have_posts()):
        the_post(); ?>

        <article class="single-grid" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="single-thumbnail">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('large', ['class' => ' w-full h-full object-cover hover:scale-110 transition-transform duration-300']); ?>
                <?php endif; ?>
            </div>
            <div class="single-content">
                <div>
                    <p>
                        <?php echo get_the_date(); ?>
                        <?php
                        $categories = get_the_category();
                        if (!empty($categories)): ?>
                            - <span><?php echo esc_html($categories[0]->name); ?></span>
                        <?php endif; ?>
                    </p>
                    <h1 class="single-title"><?php the_title(); ?></h1>
                    <h3><?php the_content(); ?></h3>
                </div>
                <a class="btn-primary-reverse" data-text="← Retour" href="#" onclick="history.back(); return false;">← Retour</a>
            </div>
        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>