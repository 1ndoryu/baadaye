<?php
/*
Template Name: Home
*/

use Glory\Class\ContentManager;
use Glory\Components\LogoHelper;
use Glory\Components\EmailFormBuilder;
use Glory\Components\FormModalBuilder;
use Glory\Components\PostDisplay;

get_header();
?>


<main class="main" id="content">
    <div class="hero">

        <div class="home-hero-header">
            <div class="eyebrow-pill">
                <a href="" class="eyebrow-pill-inner w-inline-block" style="display: none;">
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
                    <?php echo ContentManager::text('subHeading', 'Focused on delivering measurable results and elevating your brand.'); ?>
                </p>
            </div>

            <?php EmailFormBuilder::display([
                'form_id' => 'newsletter-footer', // Este ID debe coincidir con 'target_form_id' abajo
                'email_placeholder' => 'Your email address',
                'submit_value' => 'Join Us',
                'nonce_action' => 'glory_email_signup_action', // Nonce para la acción de registro de email
                'modal_target_id' => 'newsletter-footer-modal' // Asegúrate que el ID del modal a abrir es correcto
            ]); ?>

            <?php FormModalBuilder::display(
                [
                    'modal_id' => 'newsletter-footer-modal', // ID de este modal
                    'modal_title' => 'Complete Your Profile',
                    'ajax_action' => 'glory_update_user_details', // La acción AJAX que este form dispara
                    'nonce_action' => 'glory_update_user_details_nonce', // <<<==== NONCE ACTION ESPECÍFICO para la acción de arriba
                    'target_form_id' => 'newsletter-footer', // ID del form original (EmailFormBuilder) para mostrar mensaje de éxito
                    'hidden_fields' => [
                        ['name' => 'user_id', 'data_attr' => 'glory-user-id-input'] // JS buscará 'data-glory-user-id-input'
                    ],
                    'fields' => [
                        [
                            'name' => 'first_name',
                            'label' => 'First Name',
                            'required' => true,
                            'id' => 'newsletter-footer-modal-first-name' // IDs explícitos son buenos
                        ],
                        [
                            'name' => 'last_name',
                            'label' => 'Last Name',
                            'required' => false,
                            'id' => 'newsletter-footer-modal-last-name'
                        ],
                    ],
                    'submit_value' => 'Save Profile',
                    'submit_data_wait' => 'Saving...',
                    'failure_message' => 'Could not save details. Please try again.' // Mensaje para errores *dentro* del modal
                ]
            ); ?>

        </div>
    </div>

    <div class="separador">
        <div class="separador-linea">
            <p class="separador-titulo"></p>
        </div>
    </div>

    <div class="space-div">



        <div class="svg-container">
            <?php echo $GLOBALS['logoHomeAnimation']; ?>
        </div>

        <p>Baadaye Agency is a B2B digital marketing and media company built for the future of Africa. We are committed to driving positive change through bold marketing campaigns and digital solutions by empowering our clients to communicate their messaging and sustainability efforts intentionally and authentically.</p>

        <p>Our focus is on brand, sales and ESG marketing. We strive to break barriers and create opportunities for everyone to access a better future. By harnessing the power of marketing and technology, we aim to bridge gaps, empower communities, and contribute to a more just and sustainable world.</p>
    </div>

    <div class="separador">
        <div class="separador-linea">
            <p class="separador-titulo"></p>
            <p class="space-title">Featured Projects</p>
        </div>
    </div>



    <div class="postdisplay-home">
        <?php
        PostDisplay::render(
            'portfolio_item',
            [
                'posts_per_page' => 8,
                'template_path'  => get_stylesheet_directory() . '/App/View/PortafolioPost.php',
                'title_tag'      => 'h3',
                'show_excerpt'   => false,
                'sector_enable'      => true,
                'sector_size'        => 4,
                'sector_class'       => 'post-sector',
                'priority_ids'       => [49, 47, 95, 45],
            ]
        );
        ?>
    </div>

    <div class="separador">
        <div class="separador-linea">
            <p class="separador-titulo"></p>
        </div>
    </div>
</main>
<?php
get_footer();
?>