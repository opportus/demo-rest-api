<?php

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * The authentication Google OAuth exception.
 *
 * @package App\Exception
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
class AuthenticationGoogleOAuthException extends AuthenticationException
{
}
