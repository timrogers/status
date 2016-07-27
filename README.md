* Create a database and a user with permissions to access it, and import the necessary database table by running the SQL in `structure.sql`
* Create a `config.inc.php` following the format in `config.inc.php.example` - you'll be configuring the SQL database and a URL for the StatusPage API and an Authorization header to access it (it should be the `components.json` API as in the example)
* Upload `config.inc.php`, `cron.php`, `ServerStatus.php` and `StatusPage.php` to somewhere inaccessible from the web. I put them in the user root in a `server_status` directory (see the `require` in `ServerStatusPanel.php`).
* Update the requires at the top of `ServerStatusPanel.php` to point to the files where you put them in the step above
* `ServerStatusPanel.php` should be placed in `includes/hooks` - it adds panels to the logged-in client's client area for any products/services they have on services which aren't in "operational" state
* Add a cronjob to run `cron.php` as and when desired - for example you might want it to run every half hour, which you can set up in cPanel, with command `php /path/to/cron.php`
