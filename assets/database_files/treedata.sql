-- DB INFORMATION
-- host:      db5015115557.hosting-data.io
-- db name:   dbs12534339
-- username:  dbu5478137
-- password:  database@treedata

SET foreign_key_checks = 0;

DROP TABLE IF EXISTS `treedata_users`;
DROP TABLE IF EXISTS `treedata_sites`;
DROP TABLE IF EXISTS `treedata_trees`;
DROP TABLE IF EXISTS `treedata_tree_species`;
DROP TABLE IF EXISTS `treedata_tree_vitality`;
DROP TABLE IF EXISTS `treedata_tree_age_class`;
DROP TABLE IF EXISTS `treedata_user_sites`;
DROP TABLE IF EXISTS `treedata_site_trees`;






SET foreign_key_checks = 1;

-- Table to store information about users
CREATE TABLE treedata_users (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) PRIMARY KEY,
    f_name VARCHAR(100) NOT NULL,
    l_name VARCHAR(100) NOT NULL,
    address_line_1 VARCHAR(200),
    address_line_2 VARCHAR(200),
    city VARCHAR(50),
    postcode VARCHAR(8),
    mobile VARCHAR(11),
    password VARCHAR(100) NOT NULL,
    isAdmin BOOL NOT NULL,
    image VARCHAR(50),
    UNIQUE (id)
);

-- Table to store information about sites
CREATE TABLE treedata_sites (
    name VARCHAR(100) NOT NULL,
    shortcode VARCHAR(4) NOT NULL PRIMARY KEY,
    description VARCHAR(1000),
    address_line_1 VARCHAR(200),
    address_line_2 VARCHAR(200),
    city VARCHAR(50),
    postcode VARCHAR(9),
    contact_name VARCHAR(100),
    contact_telephone VARCHAR(11),
    image VARCHAR(100)
);

-- Table to store information about tree IDs
CREATE TABLE treedata_trees (
    tree_id INT PRIMARY KEY
);

-- Table to store information about tree vitality (health)
CREATE TABLE treedata_tree_vitality (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    description VARCHAR(400)
);

-- Table to store information about tree age class (age)
CREATE TABLE treedata_tree_age_class (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    description VARCHAR(400)
);

-- Table to store information about the type (species) of trees
CREATE TABLE treedata_tree_species (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);

-- Junction table to represent the many-to-many relationship
CREATE TABLE treedata_site_trees (
    shortcode VARCHAR(4),
    tree_id INT,
    name VARCHAR(255),
    description VARCHAR(1000),
    latitude VARCHAR(20),
    longitude VARCHAR(20),
    species INT,
    image VARCHAR(50),
    age_class INT,
    height VARCHAR(3),
    crown_spread VARCHAR(14),
    stem_diameter VARCHAR(20),
    vitality INT,
    PRIMARY KEY (shortcode, tree_id),
    FOREIGN KEY (shortcode) REFERENCES treedata_sites(shortcode) ON DELETE CASCADE,
    FOREIGN KEY (tree_id) REFERENCES treedata_trees(tree_id) ON DELETE CASCADE,
    FOREIGN KEY (species) REFERENCES treedata_tree_species(id) ON DELETE CASCADE,
    FOREIGN KEY (vitality) REFERENCES treedata_tree_vitality(id) ON DELETE CASCADE,
    FOREIGN KEY (age_class) REFERENCES treedata_tree_age_class(id) ON DELETE CASCADE
);

-- Junction table to represent the many-to-many relationship
CREATE TABLE treedata_user_sites (
    username VARCHAR(100),
    site_shortcode VARCHAR(4),
    PRIMARY KEY (username, site_shortcode),
    FOREIGN KEY (username) REFERENCES treedata_users(username) ON DELETE CASCADE,
    FOREIGN KEY (site_shortcode) REFERENCES treedata_sites(shortcode) ON DELETE CASCADE  
);

INSERT INTO `treedata_users` (`id`, `username`, `f_name`, `l_name`, `password`, `isAdmin`, `image`)
VALUES
  (1, 'Dave', 'Dave', 'Davidson', 'test', 0, 'user_template.png'),
  (2, 'John', 'John', 'Johnson', 'test', 0, 'user_template.png'),
  (3, 'Robert','Robert', 'Robertson', 'test', 0, 'user_template.png'),
  (4, 'Steve','Steve', 'Stevenson', 'test', 0, 'user_template.png'),
  (5, 'Loz','Laurence', 'Smith', 'test', 1, 'user_template.png');


INSERT INTO `treedata_sites` (`name`, `shortcode`, `description`, `image`, `address_line_1`, `address_line_2`, `city`, `postcode`, `contact_name`, `contact_telephone`)
VALUES
  ('St Martin\'s Church', 'STMC', 'This is a church based in Scarborough.', 'stmc.jpg', '43 Main St', 'Seamer', 'Scarborough', 'YO12 4PS', 'Mrs Vicar', '666'),
  ('St Andrew\'s Church', 'STAC', 'This is a church.', 'stac.jpg', 'Middleton-on-the-Wolds', '', 'Driffield', 'YO25 9UF', 'God', '0123456789'),
  ('All Saints Church', 'ASTC', 'This is a church.', 'astc.jpg', 'North Dalton', '', 'Driffiled', 'YO25 9UX', 'Mr Vicar', '999');


INSERT INTO `treedata_trees` (`tree_id`)
VALUES
  (1),
  (2),
  (3),
  (4),
  (5),
  (6),
  (7),
  (8),
  (9),
  (10);

INSERT INTO `treedata_tree_vitality` (id, `name`)
VALUES
  (1, 'Dead'),
  (2, 'Reduced'),
  (3, 'Poor'),
  (4, 'Normal');

INSERT INTO `treedata_tree_age_class` (id, `name`)
VALUES
  (1, 'Mature'),
  (2, 'Early Mature'),
  (3, 'Post Mature'),
  (4, 'Semi Mature'),
  (5, 'Young');

INSERT INTO `treedata_tree_species` (id, `name`)
VALUES
  (1, 'Ash'),
  (2, 'Elm'),
  (3, 'Oak'),
  (4, 'Birch'),
  (5, 'Sycamore'),
  (6, 'Cherry'),
  (7, 'Norway Maple'),
  (8, 'Beech'),
  (9, 'Irish Yew'),
  (10, 'Yew'),
  (11, 'Mixed'),
  (12, 'Lawson\'s Cypress'),
  (13, 'Horse Chestnut');


INSERT INTO `treedata_site_trees` (`shortcode`, `tree_id`, `age_class`, `species`, `height`, `crown_spread`, `stem_diameter`, `vitality`, `description`, `image`)
VALUES
('STMC', 2, 3, 8, 15, '2, 6, 2, 8', '700', 3, 'Heavily suppressed stem located behind the grave of Mary Ann. Significant internal cavitation with dedicated fruiting bodies around the base. Potential for limb failure. ', 'tree_template.png'),
('STMC', 3, 3, 1, 18, '10', '>750', 2, 'The lower stem is heavily clad in Ivy preventing a full inspection. Multiple broken limbs and deadwood in the canopy. Limited targets other than graves. ', 'tree_template.png'),
('STMC', 4, 3, 1, 12, '8', '4 x 400 ave.', 2, 'The tree is located close to the boundary wall and is heavily clad in Ivy. The canopy appears to be heavily infected with Ash Dieback with reduced vigour and minor deadwood. Very limited targets. ', 'tree_template.png'),
('STMC', 5, 3, 5, 20, '6, 6, 10, 10', '800*', 4, 'Bifurcation of the main stem at 1.5m with large compression union. Limited evidence of strain at the union. Heavily canopy lifted on the northern aspect, with multiple pruning wounds around the lower stem one pruning wound on the west side, is significant with decay penetrating into the main stem.  ', 'tree_template.png'),
('STMC', 6, 3, 13, 18, '8, 2, 10, 5', '750*', 4, 'The lowest stem is heavily clad Ivy, preventing a full inspection. Branching is predominantly upright with only one significant lateral lower limb branch failure at 9 m south resulting limb being hung up in the neighbouring Sycamore tree. Possible decay at the failure point which could compromise upper branching. ', 'tree_template.png'),
('STMC', 7, 3, 5, 18, '8, 10, 10, 6', '1000*', 4, 'Significantly clad in ivy with minor deadwood in the crown', 'tree_template.png'),
('STMC', 8, 1, 1, 16, '7, 7, 7, 7', '600, 480', 4, 'The tree canopy has been significantly raised to around 9 m with multiple pruning wounds below this point. tree canopy is currently in reasonable form with no obvious signs of Ash dieback infection. Heavy lifting work has resulted in higher wind exposure to the remaining canopy. ', 'tree_template.png'),
('STMC', 9, 3, 6, 10, '8, 6, 8, 6', '850', 4, 'Root plate impacting on footpath multiple tight unions and minor regions of decay on lower branches, prolific deadwood within the inner canopy', 'tree_template.png'),
('STMC', 10, 3, 7, 11, '4, 4, 5, 6', '440*', 3, 'The trees heavily clouding ivy with signs of decay within the central stem. Limited target area given a lack of gravestones and  neighbouring field.', 'tree_template.png'),
('STMC', 11, 3, 1, 14, '8, 8, 8, 5', '1090', 2, 'A significant specimen is located close to the main entrance of the church. One of the main scaffold limbs has a large column of decay approximately 2 m In length extent. The extent of decay into the limb is unknown from ground level. The tree is infected with Ash dieback, the volume of which is difficult to ascertain given the season. ', 'tree_template.png'),
('STMC', 12, 3, 1, 18, '4, 7, 8, 8', '930', 4, 'Significant ash tree with multiple fruiting bodies of Ganoderma on the eastern and southern aspects. Assume to be as a result of a large pruning wound at 2.5 m Southeast canopy in good condition with only minor Deadwood', 'tree_template.png'),
('STAC', 1, 2, 10, 8.5, '4', '600', 2, 'A squat tree located on a steep embankment. The lower westerly canopy is restricting access to the service schedule board and visibility. Alder stems growing up through the canopy suppressing growth. ', 'tree_template.png'),
('STAC', 2, 2, 9, 7, '1', '150, 150, 100, 100', 4, 'Elder growing to the north at the base suppressing canopy growth. ', 'tree_template.png'),
('STAC', 3, 1, 10, 11, '5', '670*', 2, 'Heavily clad with Ivy in the lower crown suppressing growth and causing dieback of lower branches. ', 'tree_template.png'),
('STAC', 4, 1, 5, 20, '8', '800*', 4, 'A large tree located within woody shrub group with limited access around the base. Tree canopy in contact with the church. ', 'tree_template.png'),
('STAC', 5, 1, 10, 12, '7', '800*', 2, 'The tree is heavily clad in Ivy suppressing much of the annual growth. Large Elder growing at the north side of the canopy further suppressing development. ', 'tree_template.png'),
('STAC', 7, 4, 2, 6, '7', '200', 2, 'Suppressed trees heavily clad in Ivy with dieback at the crown. Assumed Dutch Elm Disease. Limited remaining life span.  ', 'tree_template.png'),
('ASTC', 1, 4, 2, 10, '3', '170', 1, 'Dead tree close to the entrance ', 'tree_template.png'),
('ASTC', 4, 1, 5, 20, '7', '750', 4, 'Large dead hanging branch over the farm access. The limb appears well hung up and unlikely to fall until it decays further or during a high wind event. ', 'tree_template.png'),
('ASTC', 5, 1, 1, 20, '8', '520', 4, 'Large-scale damage to the southern aspect of the stem with internal cavitation. Stem is for the most part upright and in good health. Reaction growth is considered adequate at present. Given the species and decay the tree is likely to have a limited remaining safe life span. ', 'tree_template.png'),
('ASTC', 6, 1, 2, 9, '0', '200', 4, 'Dead stem within Ash and Yew group. All trees are heavily clad in Ivy. Limited occupancy. ', 'tree_template.png'),
('ASTC', 7, 2, 12, 9, '3', '200*', 2, 'Ivy has reached the crown and is now developing over the foliage suppressing growth. ', 'tree_template.png'),
('ASTC', 8, 1, 13, 20, '9', '700, 600, 400', 4, 'One of the more significant trees within the churchyard, located on a steep back. High Ivy covers limits what can be viewed. Canopy architecture appears typical of the species with some minor bark inclusions close to the base. ', 'tree_template.png');

INSERT INTO `treedata_user_sites` (`username`, `site_shortcode`)
VALUES
('Dave', 'STAC'),
('John', 'ASTC'),
('Steve', 'STMC'),
('Robert', 'STMC'),
('Robert', 'STAC'),
('Robert', 'ASTC');