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
        <p class="section-banner-title"><?php esc_html_e('FAQs', 'yipnyap'); ?></p>
        <!-- /SECTION BANNER TITLE -->

        <!-- SECTION BANNER TEXT -->
        <p class="section-banner-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('%sThank you for your purchase!%s Below you will find the most frequently asked questions!.', 'yipnyap'),
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
        <img class="section-top-image" src="<?php echo YIPNYAP_URL; ?>/img/admin/activation-howto.png"
             alt="activation-howto">
        <!-- /SECTION TOP IMAGE -->

        <!-- SECTION PRETITLE -->
        <p class="section-pretitle"><?php esc_html_e('FAQs', 'yipnyap'); ?></p>
        <!-- /SECTION PRETITLE -->

        <!-- SECTION TITLE -->
        <p class="section-title"><?php esc_html_e('Frequently Asked Questions', 'yipnyap'); ?></p>
        <!-- /SECTION TITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('Check out here the most common questions that users have when using the theme. We recommend reading this before contacting support because your question may already be answered! %s%sJust keep in mind that it\'s very important that you have the theme updated to the latest version, as we add new features with every update and the feature you are looking for may have already been added.%s%sHere\'s a list of all questions:', 'yipnyap'),
                    '<br><br>',
                    '<strong>',
                    '</strong>',
                    '<br><br>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- UNORDERED LIST -->
        <ul class="unordered-list unordered-list-bold">
            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-customizer-guide">
                        <?php esc_html_e('Do I have a guide to what I can do with the Yipnyap customizer options?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-customize-pages-elementor">
                        <?php esc_html_e('Can I customize all pages with Elementor?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-top-bar">
                        <?php esc_html_e('Can I remove the WordPress bar at the top?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-user-register">
                        <?php esc_html_e('Where can users register?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-manage-groups">
                        <?php esc_html_e('How do I create Groups?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-default-avatar-cover">
                        <?php esc_html_e('Can I change the default user avatars and covers?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-hide-sidemenu">
                        <?php esc_html_e('Can I hide the side menu?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-hide-footer">
                        <?php esc_html_e('Can I hide the footer?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-folders-illustrations">
                        <?php esc_html_e('Where can I find the folders and illustrations mentioned in the documentation?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-login-redirect">
                        <?php esc_html_e('Can I change the page that users are redirected to after they login?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-frontend-blog">
                        <?php esc_html_e('Can users upload blog posts from the front end?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-hide-page-headers">
                        <?php esc_html_e('Can I remove the section headers?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-registered-only-content">
                        <?php esc_html_e('Is there an option so only registered users can see the content?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-profile-tabs-order">
                        <?php esc_html_e('Can I change the order of the members profile tabs?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-remove-blog-tab">
                        <?php esc_html_e('Can I remove the blog tab of the members profile?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-change-avatar-types">
                        <?php esc_html_e('Can I change the avatars from hexagons to circles/squares?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-forum-positions">
                        <?php esc_html_e('Can I order/change the positions of the forums?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-login-customization">
                        <?php esc_html_e('How can I customize the Login page?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-theme-translate">
                        <?php esc_html_e('How can I translate the theme?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-quest-images">
                        <?php esc_html_e('Why are all the quests images the same?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-svg-icons">
                        <?php esc_html_e('How can I add new SVG icons?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-file-uploads-directory">
                        <?php esc_html_e('Where are all images and videos saved?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->

            <!-- UNORDERED LIST ITEM -->
            <li class="unordered-list-item">
                <!-- UNORDERED LIST ITEM TEXT -->
                <p class="unordered-list-item-text">
                    <a href="#vk-color-presets-stored">
                        <?php esc_html_e('Where are the color presets stored?', 'yipnyap'); ?>
                    </a>
                </p>
                <!-- /UNORDERED LIST ITEM TEXT -->
            </li>
            <!-- /UNORDERED LIST ITEM -->
        </ul>
        <!-- /UNORDERED LIST -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-customizer-guide"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Do I have a guide to what can I do with the Yipnyap customizer options?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('Yes! Check out our documentation %shttps://odindesignthemes.com/vikinger-theme-docs/%s inside the "Theme Customization" -> "Customizer Overview". There you\'ll find a quick view of what you\'ll be able to do on each section, from changing login page texts, settings, color presets, member options, headers, and much more! We strongly suggest you to check out this page before customizing your theme!.', 'yipnyap'),
                    '<a href="https://odindesignthemes.com/vikinger-theme-docs/" target="_blank">',
                    '</a>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-customize-pages-elementor"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Can I customize all pages with Elementor?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text"><?php esc_html_e('No, you can only use Elementor to edit pages created with Elementor (like the landing page) or create new pages.', 'yipnyap'); ?></p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-top-bar"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Can I remove the WordPress bar at the top?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('You can remove the WordPress bar for all users except administrators by using the Customizer -> Yipnyap Settings -> Admin Bar option.%sUsers can also individually remove the toolbar by going to the WordPress admin, Users -> Profile and unchecking the Toolbar option.%sBuddyPress adds the toolbar for logged out users too, you can change this by going to Settings -> BuddyPress -> Options tab.', 'yipnyap'),
                    '<br><br>',
                    '<br><br>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-user-register"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Where can users register?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('The register form is on the landing page, you\'ll find a tab where the login form is. Also, you\'ll see a register button on the top header.%sPlease, make sure that the WordPress option for anyone to register is enabled. You can find it inside Settings -> General -> "Membership: Anyone can Register".', 'yipnyap'),
                    '<br><br>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-manage-groups"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('How do I create Groups?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('Groups must be created from the front-end.%sWe created a system so users can easily create and manage groups. Just go to your front-end settings menu (the cog wheel icon at the top right) and click on "Manage Groups".%sThere you\'ll be able to create them, change settings, promote users and more!.', 'yipnyap'),
                    '<br><br>',
                    '<br><br>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-default-avatar-cover"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Can I change the default user avatars and covers?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('Yes! You have that option inside the customizer.%sJust go to Yipnyap Settings -> Members and Yipnyap Settings -> Groups.', 'yipnyap'),
                    '<br><br>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-hide-sidemenu"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Can I hide the side menu?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('Yes! You have that option inside the customizer.%sJust go to Yipnyap Settings -> Side Menu.', 'yipnyap'),
                    '<br><br>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-hide-footer"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Can I hide the footer?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('Yes! You have that option inside the customizer.%sJust go to Yipnyap Settings -> Footer.', 'yipnyap'),
                    '<br><br>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-folders-illustrations"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Where can I find the folders and illustrations mentioned in the documentation?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('Please be sure that when you go to your downloads page, you not only download the installable WordPress file, but also the main files.%sMany things, like the demo imports and illustration files are inside that main zip file so be sure to download it and check it out.', 'yipnyap'),
                    '<br><br>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-login-redirect"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Can I change the page that users are redirected to after they login?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('You can select your site "Homepage" in the WordPress backend settings.%sGo to "Settings" -> "Reading" -> "Your homepage displays" -> "A static page" and select your desired page from the "Homepage" dropdown.', 'yipnyap'),
                    '<br><br>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-frontend-blog"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Can users upload blog posts from the front end?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('Sorry, but it\'s not possible at the moment, the WordPress blog feature works from the backend and they have an already really powerful editor with lots of blocks and features (and constantly getting updates). %sIf you don\'t want to grant access to the complete backend features to someone, remember that you also have the option to give users the role of "Editor", "Author", or "Contributor" %shttps://wordpress.org/support/article/roles-and-capabilities/%s which allows them to write blog posts from the backend but "locks" some of the other features.', 'yipnyap'),
                    '<br><br>',
                    '<a href="https://wordpress.org/support/article/roles-and-capabilities/" target="_blank">',
                    '</a>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-hide-page-headers"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Can I remove the section headers?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('Yes! You can do it inside the WordPress Customizer.%sJust go to Yipnyap "Settings" -> "Page Headers", and choose "Hide"', 'yipnyap'),
                    '<br><br>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-registered-only-content"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Is there an option so only registered users can see the content?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('Yes, we have an option in the Customizer that you can check to force users to login.%sGo to the "Customizer" -> "Yipnyap Settings" -> "Login - Register" -> "Force Login" and select "Enabled".
          ', 'yipnyap'),
                    '<br><br>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-profile-tabs-order"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Can I change the order of the members profile tabs?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('Yes, just go to  "Customizer" -> "Yipnyap Settings" -> "Members" and change the numbers to order them in the way you want..', 'yipnyap')
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-remove-blog-tab"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Can I remove the blog tab of the members profile?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('Yes, just go to  "Customizer" -> "Yipnyap Settings" -> "Members" and you can disable it. .', 'yipnyap')
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-change-avatar-types"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Can I change the avatars from hexagons to circles/squares?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('Yes! You can change the shape of the avatars, just go to "Customizer" -> "Yipnyap Settings" -> "Avatar" and choose the one you like the most.', 'yipnyap')
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-forum-positions"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Can I order/change the positions of the forums?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('Yes, the forum positions are managed from the backend. You have to number them in the order that you want them to be shown (1, 2, 3…), check this screen: %shttps://imagizer.imageshack.com/img923/253/6TKg0G.png%s.', 'yipnyap'),
                    '<a href="https://imagizer.imageshack.com/img923/253/6TKg0G.png" target="_blank">',
                    '</a>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-login-customization"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('How can I customize the Login page?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('The theme uses the default WordPress login and forgot password pages, we include several options in the "Customizer" like text and background customization.%sFor further customization, please check the WordPress docs on how to edit these pages:%s%shttps://codex.wordpress.org/Customizing_the_Login_Form%s%s%shttps://codex.wordpress.org/Customizing_the_Login_Form#Styling_Your_Login%s', 'yipnyap'),
                    '<br><br>',
                    '<br><br>',
                    '<a href="https://codex.wordpress.org/Customizing_the_Login_Form" target="_blank">',
                    '</a>',
                    '<br><br>',
                    '<a href="https://codex.wordpress.org/Customizing_the_Login_Form#Styling_Your_Login" target="_blank">',
                    '</a>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-theme-translate"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('How can I translate the theme?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('We recommend using a tool that will help you create your localization files instead of creating them manually.%sThis official WordPress resource details how to localize themes: %shttps://developer.wordpress.org/apis/handbook/internationalization/localization/#translating-themes-and-plugins%s%sThe Poedit tool can be used to create your localized files using the yipnyap.pot file as a base, you can find more information about it here: %shttps://developer.wordpress.org/apis/handbook/internationalization/localization/#poedit%s', 'yipnyap'),
                    '<br><br>',
                    '<a href="https://developer.wordpress.org/apis/handbook/internationalization/localization/#translating-themes-and-plugins" target="_blank">',
                    '</a>',
                    '<br><br>',
                    '<a href="https://developer.wordpress.org/apis/handbook/internationalization/localization/#poedit" target="_blank">',
                    '</a>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-quest-images"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Why are all the quests images the same?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('What you’re seeing isn’t and issue! They are shown like that because the quests aren’t unlocked yet (the icon means locked or “open” quest)! Once people earn them, they will be shown the colored token, this way people are encouraged to finish the quests to “unlock” the tokens!. What you see in the live preview is an example of some of the tokens locked, and others unlocked. ', 'yipnyap')
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-svg-icons"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('How can I add new SVG icons?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('1) To add new icons you need to create:%s

          a) A new script file that includes the SVG code and include it in your theme "functions.php" (we recommend using the child theme as to not lose changes after a theme update).%s
          
          You can use the theme script as an example, you will find it in the "yipnyap/js/source/utils/svg-loader.js" file. You can copy it and replace the svgData constant value with the SVG icons you want to include.%s
          
          Your SVG icons need to follow the same naming structure as existing ones, i.e:', 'yipnyap'),
                    '<br><br>',
                    '<br><br>',
                    '<br><br>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <pre>
    <?php
    esc_html_e('
<!-- SVG CUSTOM -->
<svg style="display: none;">
  <symbol id="svg-custom" viewBox="0 0 yourviewboxvalue yourviewboxvalue" preserveAspectRatio="xMinYMin meet">
    // your svg content
  </symbol>
</svg>
<!-- /SVG CUSTOM -->'
    );

    ?>
    </pre>

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('b) Create styles for your icons and add them to the style.css or add a new stylesheet and include it in the "functions.php" file, they must also follow the naming structure:', 'yipnyap')
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <pre>
    <?php
    esc_html_e('
.icon-custom {
    
  // your icon styles
  
}'
    );

    ?>
    </pre>

        <!-- SECTION TEXT -->
        <p class="section-text">
            <?php

            echo wp_kses(
                sprintf(
                    esc_html__('c) You can then use the part after the icon-* name to use that icon in the theme. In this case, you can use "custom" to assign this icon to a menu item.%sThe "yipnyap/style.css" file contains all theme styles that are not related to third-party plugins, you will find the .icon-* CSS declarations in that file.', 'yipnyap'),
                    '<br><br>'
                ),
                yipnyap_wp_kses_admin_text_get_allowed_tags()
            );

            ?>
        </p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-file-uploads-directory"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Where are all images and videos saved?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text"><?php esc_html_e('Videos (and images) uploaded by users are saved in your WordPress install "uploads" directory (wp-content/uploads/yipnyap).', 'yipnyap'); ?></p>
        <!-- /SECTION TEXT -->

        <!-- SECTION INNERTITLE -->
        <p id="vk-color-presets-stored"
           class="section-innertitle section-innertitle-padded"><?php esc_html_e('Where are the color presets stored?', 'yipnyap'); ?></p>
        <!-- /SECTION INNERTITLE -->

        <!-- SECTION TEXT -->
        <p class="section-text"><?php esc_html_e('Color presets are stored as options in your WordPress install database (“yourprefix_options” table), you can find each preset name in the “yipnyap/includes/customizer/vikinger-customizer-utils.php” file, “yipnyap_customizer_color_preset_setting_name_get” function on line 1152.', 'yipnyap'); ?></p>
        <!-- /SECTION TEXT -->
    </div>
    <!-- /SECTION -->
</div>
<!-- /VK CONTENT -->
