/*add new column - user group*/
ALTER TABLE users ADD COLUMN ugroup INT(2);
UPDATE users SET ugroup = 1;

/*reset password*/
ALTER TABLE users ADD COLUMN ufirst_login INT(2);
UPDATE users SET ufirst_login = 1;