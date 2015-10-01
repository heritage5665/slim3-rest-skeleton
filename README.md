# Slim 3 REST Skeleton

This is a simple skeleton project for Slim 3 that implements a simple REST API.
Based on [akrabat's slim3-skeleton](https://github.com/akrabat/slim3-skeleton).

## Create Database

```sql
CREATE TABLE IF NOT EXISTS `notes` (
`id` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;


ALTER TABLE `notes`
 ADD PRIMARY KEY (`id`);


ALTER TABLE `notes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
```