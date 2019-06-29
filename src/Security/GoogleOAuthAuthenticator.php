<?php

namespace App\Security;

use App\Exception\AuthenticationGoogleOAuthException;
use Goutte\Client as HttpClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\StreamHandler as GuzzleStreamHandler;
use GuzzleHttp\HandlerStack as GuzzleHandlerStack;
use Opportus\ExtendedFrameworkBundle\Generator\Context\ControllerException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * The Google OAuth authenticator.
 *
 * @package App\Security
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
class GoogleOAuthAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * {@inheritdoc}
     */
    public function supports(Request $request)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        if (null === $credentials = $request->headers->get('X-AUTH-TOKEN')) {
            throw new AuthenticationCredentialsNotFoundException('Authentication credentials could not be found.');
        }

        return $credentials;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $guzzleConfig['handler'] = GuzzleHandlerStack::create(new GuzzleStreamHandler());

        if ('dev' === $_SERVER['APP_ENV']) {
            $guzzleConfig['verify'] = false;
        }

        $guzzleClient = new GuzzleClient($guzzleConfig);

        $httpClient = new HttpClient();
        $httpClient->setClient($guzzleClient);
        $httpClient->request('GET', \sprintf('https://www.googleapis.com/oauth2/v1/userinfo?access_token=%s', $credentials));
        $response = $httpClient->getResponse();

        $responseBody = \json_decode($response->getContent(), true);
        $responseCode = $response->getStatusCode();

        if (false == $responseBody || (200 !== $responseCode && !isset($responseBody['error'])) || (200 === $responseCode && !isset($responseBody['email']))) {
            throw new AuthenticationServiceException('Authentication request could not be processed due to a system problem.');
        }

        if (200 !== $responseCode) {
            throw new AuthenticationGoogleOAuthException(\sprintf('Google OAuth error: %s %s', $responseBody['error']['message'], $responseBody['error']['code']));
        }

        try {
            $user = $userProvider->loadUserByUsername($responseBody['email']);
        } catch (UsernameNotFoundException $exception) {
            throw new AuthenticationCredentialsNotFoundException('Authentication credentials could not be found.');
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        throw $exception;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $exception = null)
    {
        throw new ControllerException(Response::HTTP_FORBIDDEN, null, 'Authentication required.', 0, $exception);
    }
}
