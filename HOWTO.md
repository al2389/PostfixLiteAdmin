## How to use PostfixLiteAdmin ##

#### Download and Copy to your web server ####

 1. Download this project files.
 2. If it is in zip format, unzip it. Rename the unzipped directory name to PostfixLiteAdmin.
 3. Copy to the directory PostfixLiteAdmin and its contents  to the root of your web server.
 4. Edit PostfixLiteAdmin/config.inc.php if you don't like the default path and sqlite database name.


#### Create an empty sqlite3 database ####
	$ mkdir -p /etc/postfix/sqlite-db
	$ sqlite3 /etc/postfix/sqlite-db/vmail.sqlite3
	sqlite> .database
	sqlite> .quit

Please make sure to issue the above ".database" command, otherwise the database may not be written to disk. 

In order to make sqlite database editable, its containing directory should be writable. Also php should has the right to write the database.
	
	$ chown -R www-data:www-data /etc/postfix/sqlite-db
	$ chmod 777 /etc/postfix/sqlite-db
	$ chmod 644 /etc/postfix/sqlite-db/vmail.sqlite3


Now, open the location http://YourWebServer/PostfixLiteAdmin and start to use it. Empty tables will be generated when you access the location first time.
	


----------


#### Postfix & Dovecot queries ####
/etc/postfix/sqlite_domains.cf

	dbpath = /etc/postfix/sqlite-db/vmail.sqlite3
	query = SELECT domain FROM domain WHERE domain = '%s'

/etc/postfix/sqlite_mailbox.cf

	dbpath = /etc/postfix/sqlite-db/vmail.sqlite3
	query = SELECT email FROM mailbox WHERE email = '%s'
	result_format = %d/%u/

/etc/postfix/sqlite_alias.cf

	dbpath = /etc/postfix/sqlite-db/vmail.sqlite3
	query = SELECT a.goto FROM alias a, mailbox m WHERE m.email = '%s' and a.email_id = m.email_id

/etc/dovecot/dovecot-sql.conf.ext

	password_query = SELECT password FROM mailbox WHERE email = '%u'
	user_query = \
		SELECT '/var/spool/mail/vmail/%d/%n' AS home, \
		5000 AS uid, 5000 AS gid, \
		'*:storage=' || quota AS quota_rule \
		FROM mailbox WHERE email = '%u'
