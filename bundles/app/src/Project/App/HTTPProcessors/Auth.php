<?php

namespace Project\App\HTTPProcessors;

use PHPixie\AuthHTTP\Providers\Cookie as CookieProvider;
use PHPixie\AuthHTTP\Providers\Session as SessionProvider;
use PHPixie\AuthLogin\Providers\Password as PasswordProvider;
use PHPixie\HTTP\Request;
use PHPixie\HTTP\Responses\Response;
use PHPixie\Template;
use PHPixie\Validate\Results\Result\Field;
use PHPixie\Validate\Rules\Rule\Data\Document;
use Project\App\ORM\User\User;
use PHPixie\Validate\Results\Result\Root as RootResult;
use Project\App\ORM\User\UserRepository;

/**
 * User authorization processor
 */
class Auth extends Processor
{
    /**
     * Login and signup page
     * @param Request $request
     * @return mixed
     */
    public function defaultAction(Request $request)
    {
        /** @var User $user */
        $user = $this->components->auth()->domain()->user();

        if($user !== null) {
            return $this->loggedInRedirect();
        }

        if($request->method() === 'GET') {
            return $this->getTemplate();
        }

        if($request->data()->get('signup')) {
            return $this->handleSignup($request);
        }

        return $this->handleLogin($request);
    }

    /**
     * Logout action
     * @param Request $request
     * @return mixed
     */
    public function logoutAction(Request $request)
    {
        $this->builder->auth()->userDomain()->forgetUser();
        return $this->userLoginRedirect();
    }

    /**
     * Handles login form processing
     * @param Request $request
     * @return mixed
     */
    protected function handleLogin(Request $request)
    {
        $domain = $this->components->auth()->domain();

        /** @var PasswordProvider $passwordProvider */
        $passwordProvider = $domain->provider('password');

        $data = $request->data();
        $user = $passwordProvider->login(
            $data->getRequired('email'),
            $data->getRequired('password')
        );

        if($user === null) {
            return $this->getTemplate(array(
                'loginFailed' => true
            ));
        }

        if($data->get('rememberMe')) {
            /** @var CookieProvider $cookieProvider */
            $cookieProvider = $domain->provider('cookie');
            $cookieProvider->persist();
        }

        return $this->loggedInRedirect();
    }

    /**
     * Handles signup form processing
     * @param Request $request
     * @return mixed
     */
    protected function handleSignup(Request $request)
    {
        $data = $request->data();
        $validator = $this->getSignupValidator();
        $result = $validator->validate($data->get());
        if(!$result->isValid()) {
            return $this->getTemplate(array(
                'signupResult' => $result,
                'activeTab' => 'signUp'
            ));
        }

        $domain = $this->builder->auth()->userDomain();
        /** @var PasswordProvider $passwordProvider */
        $passwordProvider = $domain->provider('password');

        /** @var User $user */
        $user = $this->userRepository()->create();
        $user->email = $data->get('email');
        $user->passwordHash = $passwordProvider->hash($data->get('password'));
        $user->save();

        $domain->setUser($user, 'session');

        /** @var SessionProvider $sessionProvider */
        $sessionProvider = $domain->provider('session');
        $sessionProvider->persist();

        return $this->loggedInRedirect();
    }

    /**
     * Builds a validator for the signup form
     * @return \PHPixie\Validate\Validator
     */
    protected function getSignupValidator()
    {
        $validator = $this->components->validate()->validator();
        /** @var Document $document */
        $document = $validator->rule()->addDocument();
        $document->allowExtraFields();

        $document->valueField('email')
            ->required()
            ->filter('email')
            ->callback(function (Field $result, $value) {
                if ($result->isValid()) {
                    $user = $this->userRepository()->query()
                        ->where('email', $value)
                        ->findOne();

                    if ($user !== null) {
                        $result->addCustomError('emailInUse');
                    }
                }
            });

        $document->valueField('password')
            ->required()
            ->addFilter()
                ->minLength(8);

        $validator->rule()->callback(function (RootResult $result, $data) {
            if ($result->field('password')->isValid() && $data['passwordConfirm'] !== $data['password']) {
                $result->field('passwordConfirm')->addCustomError('passwordConfirm');
            }
        });

        return $validator;
    }

    /**
     * Get template for the auth page
     * @param array $data
     * @return Template\Container
     */
    protected function getTemplate($data = array())
    {
        $defaults = array(
            'user' => null
        );

        return $this->components->template()->get(
            'app:auth',
            array_merge($defaults, $data)
        );
    }

    /**
     * User repository
     * @return UserRepository
     */
    protected function userRepository()
    {
        return $this->components->orm()->repository('user');
    }

    /**
     * Redirect response used after login
     * @return Response
     */
    protected function loggedInRedirect()
    {
        return $this->redirectResponse(
            'app.processor',
            array('processor' => 'dashboard')
        );
    }
}
