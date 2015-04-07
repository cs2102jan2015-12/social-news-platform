USE social_news_platform;

-- It's safe to alter AUTO_INCREMENT after deleting all rows.
-- Certain tables must be cleared first to prevent foreign key constraint errors.
DELETE FROM PostVote;
ALTER TABLE PostVote AUTO_INCREMENT = 1;
DELETE FROM Comment;
ALTER TABLE Comment AUTO_INCREMENT = 1;
DELETE FROM Post;
ALTER TABLE Post AUTO_INCREMENT = 1;
DELETE FROM User;
ALTER TABLE User AUTO_INCREMENT = 1;
DELETE FROM Tag;
ALTER TABLE Tag AUTO_INCREMENT = 1;
DELETE FROM PostTags;
ALTER TABLE PostTags AUTO_INCREMENT = 1;
DELETE FROM Feed;
ALTER TABLE Feed AUTO_INCREMENT = 1;


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

INSERT INTO Post (title, content, link, submitted, author)
VALUES ("Monster", "I'm just a man with a candle to guide me.", 'https://www.youtube.com/watch?v=VTNjuBjtlpA', '2015-03-29 18:12:53', 1);
INSERT INTO Post (title, content, submitted, author)
VALUES ("My Little Musings", "I believe there is a God, but I'm not sure he believes in us.", '2015-03-30 15:17:22', 2);


/*
Comment fixtures.
*/

INSERT INTO Comment (content, submitted, author, parent)
VALUES ("OMG! I love that song!", '2015-03-31 09:10:34', 2, 1);
INSERT INTO Comment (content, submitted, author, parent)
VALUES ("IKR!! I'm taking a stand to escape what's inside me~", '2015-03-31 10:10:23', 1, 1);
INSERT INTO Comment (content, submitted, author, parent)
VALUES ("Wah. Why so emo one?", '2015-03-31 12:45:12', 1, 2);
INSERT INTO Comment (content, submitted, author, parent)
VALUES (":P Just feeling weird today.", '2015-03-31 23:07:02', 2, 2);


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


/*
* Tag fixtures.
*/
Insert INTO Tag (tid, name) VALUES (1, 'blossom');
Insert INTO Tag (tid, name) VALUES (2, 'bubbles');
Insert INTO Tag (tid, name) VALUES (3, 'buttercup');

/*
* PostTags fixtures.
*/
-- post(1) has tags 1, 2, 3
Insert INTO PostTags (pid, tid) VALUES (1, 1);
Insert INTO PostTags (pid, tid) VALUES (1, 2);
Insert INTO PostTags (pid, tid) VALUES (1, 3);

-- post(2) has tags 1
Insert INTO PostTags (pid, tid) VALUES (2, 1);

/*
* Feed fixtures.
*/
-- admin user(1) follows tag 1, 2, 3
Insert INTO Feed (uid, tid) VALUES (1, 1);
Insert INTO Feed (uid, tid) VALUES (1, 2);

-- test user(2) follows tag 1
Insert INTO Feed (uid, tid) VALUES (2, 1);

/**
 * Report fixtures.
 */
 
-- dummy user(3) reports post 1
INSERT INTO PostReport (uid, pid, submitted) VALUES (3, 1, '2015-04-01 10:16:23');

-- dummy user(3) reports comment 4
INSERT INTO CommentReport (uid, cid, submitted) VALUES (3, 4, '2015-04-01 23:47:02');
