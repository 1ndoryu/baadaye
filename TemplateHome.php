<?php
/*
Template Name: Home
*/

use Glory\Class\ContentManager;
use Glory\Components\LogoHelper;
use Glory\Components\EmailFormBuilder;
use Glory\Components\FormModalBuilder;


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
        <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/App/css/logoHelper.css" />
        <?php LogoHelper::render(); ?>
    </div>
</main>
<?php
get_footer();
?>