<?php
# header.php 
?>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/Flip.min.js"></script>
    <?php wp_head(); ?>
</head>

<nav class="nav">
    <div class="page-padding">
        <div class="container">
            <div class="nav-inner">
                <div class="nav-left">

                    <p>Logo</p>

                    <?php
                    # Display the Primary Menu using Custom Walker
                    if (has_nav_menu('primary_menu')) { # Check if menu location has a menu assigned
                        wp_nav_menu(array(
                            'theme_location' => 'primary_menu',
                            'container'      => 'div',           # Keep the div wrapper
                            'container_class' => 'nav-menu',      # Class for the container div
                            'items_wrap'     => '%3$s',          # Output only the items, no <ul> wrapper
                            'walker'         => new Minimal_Nav_Walker(), # Use our custom walker
                            'depth'          => 1                # Ensure only top-level items
                        ));
                    } else {
                        # Fallback or message if no menu assigned (optional)
                        echo '<div class="nav-menu"># Please assign a menu to the Primary Menu location.</div>';
                    }
                    ?>
                    <div id="loadingBar" style="position: fixed; top: 0; left: 0; height: 3px; background-color: #007bff; width: 0; opacity: 0; transition: width 0.3s ease, opacity 0.3s ease; z-index: 9999;"></div>

                </div>
                <div class="nav-right">
                    <a openmodal="sign-up" href="#" class="cta cc-nav w-inline-block">
                        <div class="cta-bg u-rainbow u-blur-perf"></div>
                        <div class="cta-inner cc-nav">
                            <div>Send brief</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>