SnapPaste
==================

What is it?
--------------
Snapchat + Pastebin = SnapPaste.
Basically a pastebin, but as soon as someone sees the paste it permanently gets deleted.

What is it made in?
-------------------
PHP using the CodeIgniter Framework.
Bootstrap for front-end (Uses Bootstrap CDN)

How to install?
--------------------
Make sure you have a PHP compatible web server and MySQL installed. Clone to your web server.

* Import database.sql to your MySQL server.

* Edit application/config/database.php with your MySQL database/user information.

* Edit application/config/config.php , find 'encryption key', generate a random key and paste it in there.

License?
-----------
GNU GPL v2

Acknowledgements
---------------------

* Markdown support via Jon Labelle's ci-markdown library. https://github.com/jonlabelle/ci-markdown
