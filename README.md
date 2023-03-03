# Install documentation is at Confluence.

[Go to "Yipnyap First Install"](https://yipnyap.atlassian.net/l/cp/mKRE70De)

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
or a VPS. Installing on a local machine for development takes a bit more work.
Using docker or Local by Flywheel is recommended.

Ultimately, for local development, how you install WordPress is up to you. If you
are on a Debian/Ubuntu based machine, Canonical has a great guide for [installing
WordPress](https://ubuntu.com/tutorials/install-and-configure-wordpress). If you
are on a Mac or Windows, Local by Flywheel is a great. Local is on linux, but
(in my experience) it's extremely finniky to get working perfectly on a linux
machine. Their support is pain, so don't bother.

**If you are on a Mac or Windows, use Local. If you are on a linux machine, use
docker.** Ready to use images are available on [Docker Hub](https://hub.docker.com/_/wordpress).

Alternatively, you can use a service like [Digital Ocean](https://www.digitalocean.com/)
or [Vultr](https://www.vultr.com/), as they have one-click WordPress installs.

**PHP8.1+ is required.** If you are using a service like Digital Ocean or Vultr,
you can select the PHP version when you create your droplet, or upgrade it after
install. If you are using docker, you can select the PHP version tag when you
create your container. If you are using Local, you can select the PHP version
in the settings.

### Install Yipnyap Theme

*todo: script can automate all of this with wp-cli. I'll get around to it
eventually.*

Yipnyap is a WordPress theme. To install it for local development, you can clone
the repo anywhere and symlink it to your WordPress themes directory. For example,
if you are using Local, you can symlink it to `~/Local Sites/yipnyap/app/public/wp-content/themes/yipnyap`.

#### Install Plugins (if not done automatically already)

Similar to the theme, you can clone the plugins repo anywhere and symlink it to
your WordPress plugins directory. **Only difference is that you should symlink
the entire directoy as the WordPress `plugins` folder, not individually.**

In total, your commands should look something like this (assuming it's cloned
as `yp2-cmui` and `yp-modules`):

```bash
cd ~/Local\ Sites/<name>/app/public/wp-content
rm -r ./plugins
ln -s /path/to/yp-modules ./plugins
cd ../themes
ln -s /path/to/yp2-cmui ./yp2-cmui
```

Your directory structure should look something like this:

```bash
wp-content
├── plugins
│   └── ... (should see `ex-*`, etc.)
└── themes
    └── yp2-cmui
        ├── ... (should be the git repo)
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
plugin UI for anything else anyhow.

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

That *should* be it. Yipnyap should be usable without too much issues. Installing
for production is a lot more involved and requires a lot more setup.