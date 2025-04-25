<?php
/*
Template Name: Home
*/

use Glory\Class\ContentManager;
use Glory\Components\LogoHelper;
use Glory\Components\EmailFormBuilder;


get_header();
?>


<main class="main" id="content">
    <div class="hero">

        <div class="home-hero-header">
            <div class="eyebrow-pill">
                <a href="" class="eyebrow-pill-inner w-inline-block">
                    <div> <?php echo ContentManager::text('welcomeText', 'Welcome to Baadaye'); ?></div>
                </a>
                <div class="eyebrow-pill-bg u-rainbow u-blur-perf">
                </div>
            </div>
            <h1 class="home-hero-heading">
                <?php echo ContentManager::text('siteTitle', 'B2B digital, media & tech team'); ?>
            </h1>
            <div class="home-hero-subheading">
                <p class="subheading">
                    <?php echo ContentManager::text('subheading', 'Focused on delivering measurable results and elevating your brand.'); ?>
                </p>
            </div>

            <?php EmailFormBuilder::display([
                'form_id' => 'newsletter-footer', 
                'email_placeholder' => 'Your email address', 
                'submit_value' => 'Join Us',
            ]); ?>

        </div>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/App/css/logoHelper.css" />
        <?php LogoHelper::render(); ?>
    </div>
</main>
<?php 
get_footer();
?>