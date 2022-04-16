# Yipnyap EX
yes

# Install
While installing Wordpress, ensure that it is not accessible via the public.

1. Ensure that Wordpress is installed at `/var/www/html/` with PHP 8.1 & FPM. You can confirm the PHP version via Health Check on Wordpress Admin.
1. Yipnyap requires special modifications to Wordpress.
	* Open `wp.config.php` and change/add the following:
	```php
	define ('WP_CONTENT_DIR', '/var/www/html/vault/@server');
	define( 'WP_CONTENT_URL', 'https://yipnyap.xyz/vault/@server');
	```
	* Change `https` and/or domain to match the public domain. If using Cloudflare's Automanaged HTTPS, assume the server is accessed via HTTPS during Wordpress configuration.
	* Now change `wp-content` into `vault/@server`. Execute: `mkdir vault && mv wp-content vault/@server`
1. Install and activate Houndkit Board.
1. Now, install and activate the following in order:
	* Yipnyap EX wp-die.php Snap-in
	* Yipnyap EX Maintenance Mode
1. You may now allow Yipnyap to be accessed publicly, via adding the Server IP to your DNS records. Maintenance Mode will prevent everyone but Admins from accessing Yipnyap and will be greeted with an error message.
	* **When signed out, you must be greeted with `Yipnyap got confused...` before allowing public access to the domain**.
1. 
