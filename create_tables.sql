CREATE TABLE IF NOT EXISTS sht.shorturls
(
    id integer primary key unique auto_increment,
    ipaddresscreator varchar(64) default '' comment 'Ip address of the creator',
    maxclicks integer default 0 comment 'Maximum number of clicks allowed, 0=no limits',
    maxseconds integer default 0 comment 'Maximum duration in seconds from the creation, 0=no limits',
    mobileonly boolean default false comment 'accept only mobile devices',
    dtcreation datetime default '000-00-00 00:00:00' comment 'date/time of creation',
    dtlastclick datetime default '000-00-00 00:00:00' comment 'date/time of last click',
    totclicks integer default 0 comment 'total number of clicks',
    shorturl varchar(64) default '' comment 'generated short url',
    destinationurl varchar(128) default '' comment 'destination long url'
);
create index shorturl on shorturls(shorturl);