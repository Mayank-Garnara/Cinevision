<?php
function maskEmail($email)
{
    // Split the email into username and domain
    list($username, $domain) = explode('@', $email);

    // Mask the username (keep first two characters, replace the rest with asterisks)
    $maskedUsername = substr($username, 0, 2) . str_repeat('*', strlen($username) - 2);

    // Get only the domain without the '@' part
    $maskedDomain = substr($domain, strpos($domain, '.') + 1);

    // Combine the masked username and domain
    return $maskedUsername . '******' . $maskedDomain;
}
?>