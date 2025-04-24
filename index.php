<?php
# Basic index template file

get_header(); // Loads header.php

if (have_posts()) :
    while (have_posts()) : the_post();
        #the_title('<h1>', '</h1>'); // Display the page title
        the_content(); // Display the page content
    endwhile;
else :
    echo '<p>No content found.</p>';
endif;

# get_footer(); // Loads footer.php
