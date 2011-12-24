SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `blog_users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `blog_users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `is_active` TINYINT(1) NOT NULL ,
  `created` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blog_posts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `blog_posts` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `subject` VARCHAR(255) NOT NULL ,
  `body` TEXT NOT NULL ,
  `is_publish` TINYINT(1) NOT NULL DEFAULT false ,
  `created` INT NULL ,
  `modified` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_posts_user_id` (`user_id` ASC) ,
  CONSTRAINT `fk_posts_user_id`
    FOREIGN KEY (`user_id` )
    REFERENCES `blog_users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blog_tags`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `blog_tags` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `post_count` INT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blog_categories`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `blog_categories` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `parent_id` INT NULL ,
  `lft` INT NULL ,
  `rght` INT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  `post_count` INT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blog_posts_categories`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `blog_posts_categories` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `post_id` INT NOT NULL ,
  `category_id` INT NOT NULL ,
  INDEX `fk_blog_category_has_blog_posts_blog_posts` (`post_id` ASC) ,
  INDEX `fk_blog_category_has_blog_posts_blog_category` (`category_id` ASC) ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_blog_category_has_blog_posts_blog_posts`
    FOREIGN KEY (`post_id` )
    REFERENCES `blog_posts` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_blog_category_has_blog_posts_blog_category`
    FOREIGN KEY (`category_id` )
    REFERENCES `blog_categories` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blog_posts_tags`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `blog_posts_tags` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `post_id` INT NOT NULL ,
  `tag_id` INT NOT NULL ,
  INDEX `fk_blog_posts_has_blog_tags_blog_tags1` (`tag_id` ASC) ,
  INDEX `fk_blog_posts_has_blog_tags_blog_posts1` (`post_id` ASC) ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_blog_posts_has_blog_tags_blog_posts1`
    FOREIGN KEY (`post_id` )
    REFERENCES `blog_posts` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_blog_posts_has_blog_tags_blog_tags1`
    FOREIGN KEY (`tag_id` )
    REFERENCES `blog_tags` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
