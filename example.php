<?php
/**
 * Gravatar Helper
 *
 * Generates a Gravatar avatar URL using the SHA-256 hashing algorithm.
 *
 * @param string $email   User email address.
 * @param int    $size    Avatar size (1-2048). Default: 80.
 * @param string $default Default image if no Gravatar exists.
 *                        Options include:
 *                        404, mp, identicon, monsterid,
 *                        wavatar, retro, robohash, initials, blank
 * @param string $rating  Content rating: g, pg, r, x.
 *
 * @return string Complete Gravatar avatar URL.
 */
function get_gravatar_url(
    string $email,
    int $size = 80,
    string $default = 'identicon',
    string $rating = 'g'
): string {

    // Normalize the email address.
    $email = strtolower(trim($email));

    // Generate the SHA-256 hash.
    $hash = hash('sha256', $email);

    // Ensure valid size.
    $size = max(1, min(2048, $size));

    // Build the URL.
    return sprintf(
        'https://gravatar.com/avatar/%s?s=%d&d=%s&r=%s',
        $hash,
        $size,
        rawurlencode($default),
        rawurlencode($rating)
    );
}

/**
 * Check whether a Gravatar exists for an email.
 *
 * @param string $email Email address.
 * @return bool
 */
function gravatar_exists(string $email): bool
{
    $url = get_gravatar_url($email, 80, '404');

    $headers = @get_headers($url);

    return $headers &&
           strpos($headers[0], '200') !== false;
}

/**
 * Generate an HTML <img> element for a Gravatar.
 *
 * @param string $email Email address.
 * @param int    $size Avatar size.
 * @param string $alt Alternative text.
 * @param string $class Optional CSS class.
 * @param string $default Default avatar.
 * @param string $rating Rating.
 *
 * @return string
 */
function gravatar_image(
    string $email,
    int $size = 80,
    string $alt = 'Avatar',
    string $class = '',
    string $default = 'identicon',
    string $rating = 'g'
): string {

    $src = get_gravatar_url(
        $email,
        $size,
        $default,
        $rating
    );

    return sprintf(
        '<img src="%s" alt="%s" width="%d" height="%d" loading="lazy" decoding="async"%s>',
        htmlspecialchars($src, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($alt, ENT_QUOTES, 'UTF-8'),
        $size,
        $size,
        $class !== ''
            ? ' class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '"'
            : ''
    );
}

/* ==========================================================
   Examples
   ========================================================== */

$email = 'User@example.com';

// Avatar URL
echo get_gravatar_url($email);

// Large avatar
echo get_gravatar_url($email, 256);

// Retro avatar
echo get_gravatar_url($email, 128, 'retro');

// HTML image
echo gravatar_image(
    $email,
    128,
    'User Avatar',
    'avatar rounded-circle'
);

// Check if avatar exists
if (gravatar_exists($email)) {
    echo 'Gravatar found!';
} else {
    echo 'No Gravatar found.';
}
