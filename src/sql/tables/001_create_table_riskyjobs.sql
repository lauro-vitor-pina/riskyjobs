CREATE TABLE `riskyjobs` (
  `job_id` INT AUTO_INCREMENT,
  `title` VARCHAR(200),
  `description` MEDIUMTEXT,
  `city` VARCHAR(100),
  `state` VARCHAR(100),
  `zip` VARCHAR(5),
  `company` VARCHAR(30),
  `date_posted` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`job_id`)
);
