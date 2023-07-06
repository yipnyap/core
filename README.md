Installing Yipnyap is pretty easy - it's just a WordPress plugins and theme,
with a few setup steps for WordPress and a few for Yipnyap.

## WordPress

WordPress is a free and open source blogging tool and a content management system
(CMS) based on PHP and MySQL. WordPress is installed on a web server that is
either part of an Internet hosting service or a network host in its own right. A
local installation of WordPress can also be used for development and testing
purposes.

### Install WordPress

It's required that WordPress to be installed on a hosted server, either dedicated
or a VPS, recommended to be installed on a droplet.

**PHP8.1+ is required.** You can select the PHP version tag when you
create your container. If you are using Local, you can select the PHP version
in the settings.

### Install Yipnyap Theme

*todo: script can automate all of this with wp-cli. I'll get around to it
eventually.*

Yipnyap is a WordPress theme. To install it for local development, you can clone
the repo anywhere and symlink it to your WordPress themes directory. On docker,
you can bind Yipnyap into a directory in the container. I.e. `/home/rekki/IdeaProjects/core` -> `/var/www/html/wp-content/themes/core`.

It is **not recommended** to store the git repo in the WordPress themes directory.

#### Install Plugins (if not done automatically already)

Similar to the theme, you can clone the plugins repo anywhere and symlink it to
your WordPress plugins directory. **Only difference is that you should symlink
the entire directoy as the WordPress `plugins` folder, not individually.**

Your directory structure should look something like this:

```bash
wp-content
├── plugins
│   └── ... (should see `ex-*`, etc.)
└── themes
    └── core
        ├── ... (should be 1:1 copy of the git repo from wherever you stored it - it wont appear as a symlink)
        └── functions.php
```

### Activate plugins

1. Go to Wordpress Admin > Plugins.
2. Select all.
3. Click on “Bulk Actions” then select “Activate.”
4. Click “Apply”

Some may fail to activate. If this happens, activate `Yippy` first, then try
activating the rest again. **Your plugin UI will look absolute garbage.** This
is normal. It's not a big deal, just deal with it. You won't need to use the
plugin UI for anything else anyhow. If it bothers you extremely, disable `Houndkit`

### Install Composer

Composer is a dependency manager for PHP. Install it first. If you're using
IntelliJ, the IDE will automatically install it for you when you attempt
to install dependencies via `composer.json`, just check `Download composer.phar`
when prompted.

To install all dependencies, run:
    
```bash
composer install
``` 

### Activate theme

1. Go to Wordpress Admin > Appearance > Themes
2. Click on “Activate” for Yipnyap
3. Click “Apply” (if required)
4. Go to Wordpress Admin > Settings > BuddyPress
5. Activate all components apart from "Private Messages"
6. Still in BuddyPress settings, go to "options" and change the template pack
   to "Legacy". This is required for the Yipnyap theme to work properly.
7. Go to Wordpress Admin > Settings > Permalinks
8. Select "Custom Structure" and enter "/%post_id%/"
9. Under "Change wp-admin login", enter `login` for login, and blank for redirect.
10. Click "Save Changes"

### Setup Yipnyap
Go to https://localhost/ and follow the instructions on setting up Yipnyap and it's
environment.

That *should* be it. Yipnyap should be usable without too much issues. Installing
for production is a lot more involved and requires a lot more setup.