USE social_news_platform;

-- It's safe to alter AUTO_INCREMENT after deleting all rows.
-- Certain tables must be cleared first to prevent foreign key constraint errors.
DELETE FROM PostVote;
ALTER TABLE PostVote AUTO_INCREMENT = 1;
DELETE FROM Post;
ALTER TABLE Post AUTO_INCREMENT = 1;
DELETE FROM User;
ALTER TABLE User AUTO_INCREMENT = 1;


-- The following fixtures are used to seed the database.

/*
 * User fixtures.
 */

-- uid: (will be) 1
-- Username: admin
-- Password: password
-- Admin: 1 (true)
INSERT INTO User (username, hash, admin)
    VALUES ('admin', '$2y$10$PhFzL8GpcflHq77t7dgxGu7bGTqyprTl5kSW8BhITIvbWr3MDBY62', 1);

-- uid: (will be) 2
-- Username: test
-- Password: password
INSERT INTO User (username, hash)
    VALUES ('test', '$2y$10$PhFzL8GpcflHq77t7dgxGu7bGTqyprTl5kSW8BhITIvbWr3MDBY62');

-- uid: (will be) 3
-- username: dummy
-- password: password
INSERT INTO User (username, hash)
    VALUES ('dummy', '$2y$10$PhFzL8GpcflHq77t7dgxGu7bGTqyprTl5kSW8BhITIvbWr3MDBY62');


/*
 * Post fixtures.
 */

INSERT INTO Post (pID, title, content, submitted, author)
    VALUES (1, "title1", "post yada yada yada oneeee", CURDATE(), 1);

INSERT INTO Post (pID, title, content, submitted, author)
    VALUES (2, "titlehtwo", "I believe there is a God, but I'm not sure he believes in us.", CURDATE(), 1);


/*
 * Vote fixtures.
 */

-- admin user(1) upvotes post 1 and downvotes post 2
INSERT INTO PostVote (uid, pid, value) VALUES (1, 1, 1);
INSERT INTO PostVote (uid, pid, value) VALUES (1, 2, -1);

-- test user(2) upvotes post 1 and 2
INSERT INTO PostVote (uid, pid, value) VALUES (2, 1, 1);
INSERT INTO PostVote (uid, pid, value) VALUES (2, 2, 1);

-- dummy user(3) upvotes post 1
INSERT INTO PostVote (uid, pid, value) VALUES (3, 1, 1);
