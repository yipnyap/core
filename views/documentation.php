<!-- VK CONTENT -->
<div class="vk-content">
    <!-- SECTION BANNER -->
    <div class="section-banner">
        <!-- SECTION BANNER ICON-->
        <svg class="section-banner-icon icon-logo-yipnyap">
            <use href="#svg-logo-yipnyap"></use>
        </svg>
        <!-- /SECTION BANNER ICON-->

        <!-- SECTION BANNER PRETITLE -->
        <p class="section-banner-pretitle">
            <?php

            printf(
                esc_html__('Version %s', 'yipnyap'),
                YIPNYAP_VERSION
            );

            ?>
        </p>
        <!-- /SECTION BANNER PRETITLE -->

        <!-- SECTION BANNER TITLE -->
        <p class="section-banner-title"><?php esc_html_e('Documentation', 'yipnyap'); ?></p>
        <!-- /SECTION BANNER TITLE -->

        <!-- SECTION BANNER TEXT -->
        <p class="section-banner-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('%sThank you for your purchase!%s Below you will find information on where to find theme documentation!.', 'yipnyap'),
                    '<strong>',
                    '</strong>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION BANNER TEXT -->
    </div>
    <!-- /SECTION BANNER -->

    <!-- SECTION -->
    <div class="section">
        <!-- SECTION TOP IMAGE -->
        <img class="section-top-image" src="<?php echo YIPNYAP_URL; ?>/img/admin/includes.png" alt="includes">
        <!-- /SECTION TOP IMAGE -->

        <!-- SECTION PRETITLE -->
        <p class="section-pretitle"><?php esc_html_e('Documentation', 'yipnyap'); ?></p>
        <!-- /SECTION PRETITLE -->

        <!-- SECTION TITLE -->
        <p class="section-title"><?php esc_html_e('Where can i find the theme documentation?', 'yipnyap'); ?></p>
        <!-- /SECTION TITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('You can find the theme documentation %shere%s.%s%sPlease follow the documentation setup and install guide when installing the theme and check the various customization sections for information on how to customize each part of the theme.%s', 'yipnyap'),
                    '<a href="https://odindesignthemes.com/vikinger-theme-docs" target="_blank">',
                    '</a>',
                    '<br><br>',
                    '<strong>',
                    '</strong>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->
    </div>
    <!-- /SECTION -->
</div>
<!-- /VK CONTENT -->
