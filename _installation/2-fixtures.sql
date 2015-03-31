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


INSERT INTO Post (pID, title, content, submitted, author)
    VALUES (1, "title1", "post yada yada yada oneeee", CURDATE(), 1);

INSERT INTO Post (pID, title, content, submitted, author)
    VALUES (2, "titlehtwo", "I believe there is a God, but I'm not sure he believes in us.", CURDATE(), 1);
    