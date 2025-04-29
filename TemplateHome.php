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
            <p class="separador-titulo">Hola</p>
        </div>
    </div>

    <div class="space-div">

        <div class="svg-container">
            <!-- Modified SVG -->

            <svg id="uuid-dbfa4d8e-76c7-49b6-a7f7-2447ca454ece" data-name="Capa 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1546.06 796.56">
                <defs>
                    <style>
                        .uuid-ee668a26-bc6f-4c9d-9a50-c882c9b9ac8a {
                            fill: none;
                            stroke: #000;
                            stroke-miterlimit: 10;
                            stroke-width: 160px;
                            stroke-linecap: butt;
                            stroke-linejoin: miter;

                        }
                    </style>
                </defs>
                <path
                    id="infinity-path"
                    class="uuid-ee668a26-bc6f-4c9d-9a50-c882c9b9ac8a"
                    d="m609.91,205.27c-33.07-32.12-82.88-69.21-151-85-3.61-.84-10.34-2.3-18.9-3.72-35.9-5.97-105.25-11.13-180.1,23.72-22.39,10.42-97.58,46.82-141,135-47.76,96.99-23.42,188.29-17,210,3.72,18.11,28.08,127.54,132,187,87.05,49.8,174.1,32.6,205,26,78.13-16.69,129.55-59.01,152-80,121.5-145.83,243-291.67,364.5-437.5,15.22-16.46,79.37-82.08,183-90,88.69-6.77,152.46,32.83,173,46,94.23,60.43,160.11,180.34,141.5,305.5-15.97,107.42-87.06,170.78-104.5,185.5-98.13,82.81-212.52,72.67-232.94,70.5-69.83-7.41-119.66-44.1-126.56-49-19.21-13.64-33.41-27.53-43-38" />
            </svg>
        </div>

        <p>Baadaye Agency is a B2B digital marketing and media company built for the future of Africa. We are committed to driving positive change through bold marketing campaigns and digital solutions by empowering our clients to communicate their messaging and sustainability efforts intentionally and authentically.</p>

        <p>Our focus is on brand, sales and ESG marketing. We strive to break barriers and create opportunities for everyone to access a better future. By harnessing the power of marketing and technology, we aim to bridge gaps, empower communities, and contribute to a more just and sustainable world.</p>
    </div>

    <div class="separador">
        <div class="separador-linea">
            <p class="separador-titulo">Hola</p>
        </div>
    </div>

    <div class="test">
        <?php
        PostDisplay::render(
            'portfolio_item',
            [
                'posts_per_page' => 4,
                'template_path'  => get_stylesheet_directory() . '/App/View/PortafolioPost.php',
                'title_tag'      => 'h3',
                'show_excerpt'   => false,
            ]
        );
        ?>
    </div>

    <div class="separador">
        <div class="separador-linea">
            <p class="separador-titulo">Hola</p>
        </div>
    </div>
</main>
<?php
get_footer();
?>