<?php
/*
Template Name: Home
*/

use App\Glory\ContentManager;

get_header();
?>
<main class="main">
    <div class="hero">

        <div class="home-hero-header">
            <div class="eyebrow-pill">
                <a href="https://popcorn-labs.typeform.com/to/WSvaYPHv" class="eyebrow-pill-inner w-inline-block">
                    <div>Heyo! We launched our Alpha!</div>
                </a>
                <div class="eyebrow-pill-bg u-rainbow u-blur-perf">
                </div>
            </div>
            <h1 class="home-hero-heading">
                <?php echo ContentManager::text('site_title', 'One global plan etc etc etc'); ?>
            </h1>
            <div class="home-hero-subheading">
                <p class="subheading">Enjoy unlimited global service for $69/mo. No roaming fees, or&nbsp;headaches.</p>
            </div>


        </div>
    </div>
</main>
<?php wp_footer(); ?>