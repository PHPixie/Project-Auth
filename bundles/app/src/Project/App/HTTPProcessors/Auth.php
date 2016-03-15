<?php

namespace Project\App\HTTPProcessors;

use PHPixie\DefaultBundle\Processor\HTTP\Actions as ActionsProcessor;
use PHPixie\AuthHTTP\Providers\Cookie as CookieProvider;
use PHPixie\AuthHTTP\Providers\Session as SessionProvider;
use PHPixie\AuthLogin\Providers\Password as PasswordProvider;
use PHPixie\Framework\Components;
use PHPixie\HTTP\Request;
use PHPixie\Template;
use PHPixie\Validate\Results\Result\Field;
use PHPixie\Validate\Rules\Rule\Data\Document;
use Project\App\Builder;
use Project\App\ORM\User\User;
use PHPixie\Validate\Results\Result\Root as RootResult;

class Auth extends ActionsProcessor
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var Components
     */
    protected $components;

    /**
     * @param Builder $builder
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
        $this->components = $this->builder->components();
    }

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
        $this->components->auth()->domain()->forgetUser();
        return $this->builder->frameworkBuilder()->http()->redirectResponse('app.login');
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

        $domain = $this->components->auth()->domain();
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

    protected function userRepository()
    {
        return $this->components->orm()->repository('user');
    }

    protected function loggedInRedirect()
    {
        return $this->builder->frameworkBuilder()->http()->redirectResponse('app.dashboard');
    }
}
