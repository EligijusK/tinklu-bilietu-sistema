<?php
session_start();
if(empty($_SESSION['username'])) {
    $_SESSION['username'] = null;
}
if(empty($_SESSION['userID']))
{
    $_SESSION['userID'] = null;
}
if(empty($_SESSION['administrator']))
{
    $_SESSION['administrator'] = null;
}
if(empty($_SESSION['user']))
{
    $_SESSION['user'] = null;
}
if(empty($_SESSION['manager']))
{
    $_SESSION['manager'] = null;
}
?>