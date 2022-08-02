<?php

session_start();
session_unset(); 
session_destroy();
/*
unset(
    $_SESSION['nome'],
    $_SESSION['cpf'],
    $_SESSION['uf']);*/
header('Location: index.php');

