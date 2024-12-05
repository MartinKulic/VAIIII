-- Exported from QuickDBD: https://www.quickdatabasediagrams.com/
-- NOTE! If you have used non-SQL datatypes in your design, you will have to change these here.

-- rating should have imageId + userId as primary key

CREATE TABLE `images` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `path` varchar(200)  NOT NULL ,
    `name` varchar(100)  NOT NULL ,
    `desc` varchar(1000)  NOT NULL ,
    `autor_id` int  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `image_tags` (
    `tag_id` int AUTO_INCREMENT NOT NULL ,
    `image_id` int  NOT NULL ,
    PRIMARY KEY (
        `tag_id`,`image_id`
    )
);

CREATE TABLE `tags` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `name` varchar(50)  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `users` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `name` varchar(100)  NOT NULL ,
    `pass_hash` varchar(200)  NOT NULL ,
    `email` varchar(100)  NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `favs` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `user_id` int  NOT NULL ,
    `image_id` int  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `ratings` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `user_id` int  NOT NULL ,
    `image_id` int  NOT NULL ,
    `value` int  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

ALTER TABLE `images` ADD CONSTRAINT `fk_images_autor` FOREIGN KEY(`autor_id`)
REFERENCES `users` (`id`);

ALTER TABLE `image_tags` ADD CONSTRAINT `fk_image_tags_tag_id` FOREIGN KEY(`tag_id`)
REFERENCES `tags` (`id`);

ALTER TABLE `image_tags` ADD CONSTRAINT `fk_image_tags_image_id` FOREIGN KEY(`image_id`)
REFERENCES `images` (`id`);

ALTER TABLE `favs` ADD CONSTRAINT `fk_favs_user_id` FOREIGN KEY(`user_id`)
REFERENCES `users` (`id`);

ALTER TABLE `favs` ADD CONSTRAINT `fk_favs_image_id` FOREIGN KEY(`image_id`)
REFERENCES `images` (`id`);

ALTER TABLE `ratings` ADD CONSTRAINT `fk_ratings_user_id` FOREIGN KEY(`user_id`)
REFERENCES `users` (`id`);

ALTER TABLE `ratings` ADD CONSTRAINT `fk_ratings_image_id` FOREIGN KEY(`image_id`)
REFERENCES `images` (`id`);

