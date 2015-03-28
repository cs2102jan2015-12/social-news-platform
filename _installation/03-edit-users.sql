USE social_news_platform;

-- Remove duplicate rows:
-- http://stackoverflow.com/a/18949/559119
DELETE User FROM User LEFT OUTER JOIN (
    SELECT MIN(uid) as uid, username FROM User GROUP BY username
) as KeepRows ON User.uid = KeepRows.uid WHERE KeepRows.uid IS NULL;

-- Then alter table User:
ALTER TABLE User
  -- Make username unique
MODIFY COLUMN username VARCHAR(255) NOT NULL UNIQUE,
  -- Make banned default to 0 explicitly
MODIFY COLUMN banned INT NOT NULL DEFAULT 0,
  -- Make admin default to 0 explicitly
  -- We will set it to 1 within mysql-ctl.
MODIFY COLUMN admin INT NOT NULL DEFAULT 0;