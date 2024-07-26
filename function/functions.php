<?php



function login($email, $password): bool
{
    $admin = Administratoren::findByEmail($email);
    if ($admin && $admin->verifyPassword($password)) {
        $_SESSION['admin_id'] = $admin->getId();
        return true;
    }
    return false;
}


function isAuthenticated(): bool
{
    return isset($_SESSION['admin_id']);
}

// logout.php

function logout(): void
{
session_destroy();
}
?>