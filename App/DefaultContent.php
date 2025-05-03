<?php

use Glory\Class\DefaultContentManager;

DefaultContentManager::define(
    'service', // The slug of the CPT defined by PostTypeManager
    [
        // 1. Web Development
        [
            'default_slug' => 'web-development', // Unique identifier slug
            'post_title'   => 'Web Development',
            'post_content' => 'We craft responsive, user-centric websites that look stunning and perform seamlessly across all devices. Our development process ensures your online presence is functional and aligned with your brand identity.',
            'post_status'  => 'publish', // Make it visible immediately
            'meta_input'   => [
                'short-description' => '', // Include the meta key defined in PostTypeManager
            ],
        ],

        // 2. Social Media Marketing
        [
            'default_slug' => 'social-media-marketing',
            'post_title'   => 'Social Media Marketing',
            'post_content' => 'Our team develops strategic social media campaigns that resonate with your target audience. By leveraging the latest trends and analytics, we boost your brand\'s visibility and engagement across platforms like Facebook, Instagram, and LinkedIn.',
            'post_status'  => 'publish',
            'meta_input'   => [
                'short-description' => '',
            ],
        ],

        // 3. Community Management
        [
            'default_slug' => 'community-management',
            'post_title'   => 'Community Management',
            'post_content' => 'We foster and manage vibrant online communities, ensuring consistent engagement and positive interactions. Our approach builds brand loyalty and turns followers into advocates.',
            'post_status'  => 'publish',
            'meta_input'   => [
                'short-description' => '',
            ],
        ],

        // 4. Paid Media Advertising
        [
            'default_slug' => 'paid-media-advertising',
            'post_title'   => 'Paid Media Advertising',
            'post_content' => 'Maximize your ROI with our targeted paid advertising strategies. We design and manage campaigns across Google Ads, social media, and other platforms to drive traffic and conversions effectively.',
            'post_status'  => 'publish',
            'meta_input'   => [
                'short-description' => '',
            ],
        ],

        // 5. Videography & Photography
        [
            'default_slug' => 'videography-photography', // Using hyphen for '&'
            'post_title'   => 'Videography & Photography',
            'post_content' => 'Our creative team produces high-quality videos and photos that tell your brand\'s story compellingly. From promotional videos to product photography, we capture visuals that captivate your audience.',
            'post_status'  => 'publish',
            'meta_input'   => [
                'short-description' => '',
            ],
        ],

        // 6. Graphic Design
        [
            'default_slug' => 'graphic-design',
            'post_title'   => 'Graphic Design',
            'post_content' => 'We deliver visually striking designs that communicate your brand message. Our services include logo creation, marketing materials, and digital graphics that align with your brand\'s aesthetic.',
            'post_status'  => 'publish',
            'meta_input'   => [
                'short-description' => '',
            ],
        ],

        // 7. Content Creation
        [
            'default_slug' => 'content-creation',
            'post_title'   => 'Content Creation',
            'post_content' => 'Engage your audience with content that informs and entertains. Our content creators produce blog posts, articles, and multimedia content tailored to your brand\'s voice and audience preferences.',
            'post_status'  => 'publish',
            'meta_input'   => [
                'short-description' => '',
            ],
        ],

        // 8. Product Placement
        [
            'default_slug' => 'product-placement', // Simplified slug
            'post_title'   => 'Product Placement',
            'post_content' => 'We strategically place your products in entertainment settings like “Cinema Karaoke” to enhance brand exposure. This innovative approach connects your brand with audiences in memorable ways.',
            'post_status'  => 'publish',
            'meta_input'   => [
                'short-description' => '',
            ],
        ],
    ],
    'smart', // Use 'smart' mode: create if missing, update if changed AND not manually edited.
    false    // Do not delete these posts if their definition is removed from code (safer default).
);


DefaultContentManager::register();
