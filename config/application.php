<?php
define("DEFAULT_LIMIT", 5);    // default limit for items per page
define("BC_PRICE", 800);        // Bitcoin market price
/*
define("EMAIL_PREG", '/^[A-Za-z0-9]{6,16}$/');
define("FULLNAME_PREG", '/^[A-Za-z\s]{6,32}$/');
define("PASSWORD_PREG", '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$/');
*/

define("EMAIL_PREG_ERROR", "Username must be between 6 and 16 characters and should contain only letters and digits");
define("FULLNAME_PREG_ERROR", "Full name must be between 6 and 32 characters and should contain only letters and space separator");
define("FULLNAME_IN_USE_ERROR", "Sorry, but this Username already in use");
define("PASSWORD_PREG_ERROR", "Password must be between 8 and 16 characters and should contain only letters and digit(at least 1 number, one uppercase character and one lowercase character)");
define("WRONG_USERNAME_OR_PASSWORD", "Wrong Username or Password");

define("MAX_MIN_ERROR","Max should be greater than min or equal");
define("NOT_ENOUGH_OF_BTC","You don't have enough of BTC to create this offer");


