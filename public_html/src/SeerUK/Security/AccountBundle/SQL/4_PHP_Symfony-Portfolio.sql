CREATE TABLE account (
	account_id int UNSIGNED NOT NULL AUTO_INCREMENT,
	account_name varchar(25) NOT NULL,
	account_password varchar(128) NOT NULL,
	account_salt varchar(32) NOT NULL,
	account_email varchar(255) NOT NULL,
	is_active boolean NOT NULL,

	PRIMARY KEY (account_id),
	UNIQUE KEY (account_name),
	UNIQUE KEY (account_email)
)
ENGINE=InnoDB,
DEFAULT CHARSET utf8
;
