#
# replace with correct paths, then feed to e.g. mysql with 
#
# $ mysql -u <databaseuser> -p < load.sql 
#

LOAD DATA local INFILE '/var/www/html/NodeSoftware-12.07/nodes/grotrian/species.in' IGNORE INTO TABLE species COLUMNS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"';
LOAD DATA local INFILE '/var/www/html/NodeSoftware-12.07/nodes/grotrian/references.in' IGNORE INTO TABLE refs COLUMNS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"';
LOAD DATA local INFILE '/var/www/html/NodeSoftware-12.07/nodes/grotrian/states.in' IGNORE INTO TABLE states COLUMNS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"';
LOAD DATA local INFILE '/var/www/html/NodeSoftware-12.07/nodes/grotrian/transitions.in' IGNORE INTO TABLE transitions COLUMNS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"';