-- Drop the existing database (if any).
DROP DATABASE IF EXISTS social_news_platform;

-- (Re-)Create the database.
CREATE DATABASE social_news_platform;
USE social_news_platform;

-- Create the tables:

CREATE TABLE User (
  uid INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  hash VARCHAR(255) NOT NULL,
  banned INT NOT NULL DEFAULT 0,
  admin INT NOT NULL DEFAULT 0,
  PRIMARY KEY (uid)
);

CREATE TABLE Post (
  pid INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  content VARCHAR(255) NOT NULL,
  submitted DATETIME NOT NULL,
  hidden INT NOT NULL DEFAULT 0,
  author INT NOT NULL,
  PRIMARY KEY (pid),
  FOREIGN KEY (author) REFERENCES User(uid)
);

CREATE TABLE Comment (
  cid INT NOT NULL AUTO_INCREMENT,
  content VARCHAR(255) NOT NULL,
  submitted DATETIME NOT NULL,
  hidden INT NOT NULL DEFAULT 0,
  author INT NOT NULL,
  parent INT NOT NULL,
  PRIMARY KEY (cid),
  FOREIGN KEY (author) REFERENCES User(uid),
  FOREIGN KEY (parent) REFERENCES Post(pid)
);

CREATE TABLE Tag (
  tid INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL UNIQUE,
  PRIMARY KEY (tid)
);

CREATE TABLE PostTags (
  pid INT NOT NULL,
  tid INT NOT NULL,
  PRIMARY KEY (pid, tid),
  FOREIGN KEY (pid) REFERENCES Post(pid),
  FOREIGN KEY (tid) REFERENCES Tag(tid)
);

CREATE TABLE Feed (
  uid INT NOT NULL,
  tid INT NOT NULL,
  PRIMARY KEY (uid, tid),
  FOREIGN KEY (uid) REFERENCES User(uid),
  FOREIGN KEY (tid) REFERENCES Tag(tid)
);

CREATE Table PostVote (
  uid INT NOT NULL,
  pid INT NOT NULL,
  value INT NOT NULL,
  PRIMARY KEY (uid, pid),
  FOREIGN KEY (uid) REFERENCES User(uid),
  FOREIGN KEY (pid) REFERENCES Post(pid)
);

CREATE TABLE PostReport (
  uid INT NOT NULL,
  pid INT NOT NULL,
  submitted DATETIME NOT NULL,
  reviewed INT NOT NULL DEFAULT 0,
  PRIMARY KEY (uid, pid),
  FOREIGN KEY (uid) REFERENCES User(uid),
  FOREIGN KEY (pid) REFERENCES Post(pid)
);

CREATE Table CommentVote (
  uid INT NOT NULL,
  cid INT NOT NULL,
  value INT NOT NULL,
  PRIMARY KEY (uid, cid),
  FOREIGN KEY (uid) REFERENCES User(uid),
  FOREIGN KEY (cid) REFERENCES Comment(cid)
);

CREATE TABLE CommentReport (
  uid INT NOT NULL,
  cid INT NOT NULL,
  submitted DATETIME NOT NULL,
  reviewed INT NOT NULL DEFAULT 0,
  PRIMARY KEY (uid, cid),
  FOREIGN KEY (uid) REFERENCES User(uid),
  FOREIGN KEY (cid) REFERENCES Comment(cid)
);
