##ContactsBook (PHP & MySQL Project)

######Features:

- PHP and MySQL project for beginners
- User Registration and Login
- User Profile (Edit Profile and Password reset)
- User can add his/her contacts and manage them
- Authentication and autherization
- Upload Profile image

---

#####Steps to setup Project localy:

- Create **contactsbook** directory in your local system
- clone the poject in contactsbook directory

`git clone https://github.com/pankajibn/contacts-book-php.git`

- If you do not have git, you can download as zip.

- Create Mysql Database

```
CREATE DATABASE `contactsbook`;
```

- Create two tables (users, contacts)

```
CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `first_name` varchar(20) NOT NULL,
 `last_name` varchar(20) NOT NULL,
 `email` varchar(100) NOT NULL,
 `password` varchar(100) NOT NULL,
 `profile_img` varchar(100) DEFAULT NULL,
 `is_admin` enum('1','0') NOT NULL DEFAULT '0',
 `is_active` enum('1','0') NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
```

```
CREATE TABLE `contacts` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `first_name` varchar(20) NOT NULL,
 `last_name` varchar(20) NOT NULL,
 `email` varchar(100) NOT NULL,
 `phone` varchar(20) NOT NULL,
 `address` varchar(255) NOT NULL,
 `photo` varchar(100) NOT NULL,
 `status` enum('1','0') NOT NULL DEFAULT '1',
 `owner_id` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
```

- Point your browser to
  `http://localhost/contactsbook`
