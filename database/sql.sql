
-- history databse

CREATE TABLE `cotton`.`history` ( `id` INT NOT NULL , `ip` TEXT NOT NULL , `device` TEXT NOT NULL , `cl_days` INT NOT NULL , `from_date` DATE NOT NULL , `to_date` DATE NOT NULL , `time_stamp` BIGINT NOT NULL ) ENGINE = InnoDB;