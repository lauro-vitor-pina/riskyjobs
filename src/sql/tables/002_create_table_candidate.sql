CREATE TABLE candidate (
    `candidate_id` INT NOT NULL AUTO_INCREMENT,
    `job_id` INT NULL,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(20) NOT NULL, 
    `email` VARCHAR(100) NOT NULL,
    `resume` TEXT NOT NULL,
    `date_registration` DATETIME NOT NULL,
    PRIMARY KEY (candidate_id)
);

ALTER TABLE candidate
ADD CONSTRAINT fk_candidate_x_riskyjobs
FOREIGN KEY (job_id) REFERENCES riskyjobs(job_id)
ON DELETE RESTRICT 
ON UPDATE RESTRICT;