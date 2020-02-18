DROP TABLE IF EXISTS `activities`;
CREATE TABLE `activities` (
  `activity` varchar(10) NOT NULL,
  `description` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO activities (activity, description) values ('STATUS_A', 'Heen');
INSERT INTO activities (activity, description) values ('STATUS_B', 'Wachten');
INSERT INTO activities (activity, description) values ('STATUS_C', 'Lossen');
INSERT INTO activities (activity, description) values ('STATUS_D', 'Terug');
INSERT INTO activities (activity, description) values ('STATUS_E', 'Pauze');
