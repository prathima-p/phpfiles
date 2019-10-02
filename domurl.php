<?php

// This is PHP function to convert a user-supplied URL to just the domain name,
// which I use as the link text.


function url_to_domain($url)
{
    $host = @parse_url($url, PHP_URL_HOST);

    // If the URL can't be parsed, use the original URL
    // Change to "return false" if you don't want that
    if (!$host)
        $host = $url;

    // The "www." prefix isn't really needed if you're just using
    // this to display the domain to the user
    if (substr($host, 0, 4) == "www.")
        $host = substr($host, 4);

    // You might also want to limit the length if screen space is limited
    if (strlen($host) > 50)
        $host = substr($host, 0, 47) . '...';

    return $host;
}


// EXAMPLE USAGE:

?>



OUTPUT:

