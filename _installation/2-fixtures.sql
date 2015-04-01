USE social_news_platform;

-- The following fixtures are used to seed the database.

/*
 * User fixtures.
 */
DELETE FROM User;
ALTER TABLE User AUTO_INCREMENT = 1; -- Safe to use because we deleted all rows.

-- Username: admin
-- Password: password
-- Admin: 1 (true)
INSERT INTO User (username, hash, admin)
    VALUES ('admin', '$2y$10$PhFzL8GpcflHq77t7dgxGu7bGTqyprTl5kSW8BhITIvbWr3MDBY62', 1);

-- Username: test
-- Password: password
INSERT INTO User (username, hash)
    VALUES ('test', '$2y$10$PhFzL8GpcflHq77t7dgxGu7bGTqyprTl5kSW8BhITIvbWr3MDBY62');

/*
* Post fixtures.
*/

DELETE FROM Post;
ALTER TABLE Post AUTO_INCREMENT = 1; -- Safe to use because we deleted all rows.
INSERT INTO Post (title, content, submitted, author)
VALUES ("Monster", "I'm just a man with a candle to guide me.", '2015-03-29 18:12:53', 1);
INSERT INTO Post (title, content, submitted, author)
VALUES ("My Little Musings", "I believe there is a God, but I'm not sure he believes in us.", '2015-03-30 15:17:22', 2);

/*
Comment fixtures.
*/

DELETE FROM Comment;
ALTER TABLE Comment AUTO_INCREMENT = 1; -- Safe to use because we deleted all rows.
INSERT INTO Comment (content, submitted, author, parent)
VALUES ("OMG! I love that song!", '2015-03-31 09:10:34', 2, 1);
INSERT INTO Comment (content, submitted, author, parent)
VALUES ("IKR!! I'm taking a stand to escape what's inside me~", '2015-03-31 10:10:23', 1, 1);
INSERT INTO Comment (content, submitted, author, parent)
VALUES ("Wah. Why so emo one?", '2015-03-31 12:45:12', 1, 2);
INSERT INTO Comment (content, submitted, author, parent)
VALUES (":P Just feeling weird today.", '2015-03-31 23:07:02', 2, 2);