<?php

namespace Project\App\HTTPProcessors;

use PHPixie\HTTP\Request;
use PHPixie\Template;

class Auth extends \PHPixie\DefaultBundle\Processor\HTTP\Actions
{
    /**
     * @var \Project\App\Builder
     */
    protected $builder;

    protected $components;

    public function __construct($builder)
    {
        $this->builder = $builder;
        $this->components = $this->builder->components();
    }

    public function defaultAction(Request $request)
    {
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

    public function logoutAction(Request $request)
    {
        $this->components->auth()->domain()->forgetUser();
        return $this->builder->frameworkBuilder()->http()->redirectResponse('app.login');
    }

    protected function handleLogin(Request $request)
    {
        $domain = $this->components->auth()->domain();
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
            $cookieProvider = $domain->provider('cookie');
            $cookieProvider->persist();
        }

        return $this->loggedInRedirect();
    }

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
        $passwordProvider = $domain->provider('password');

        $user = $this->userRepository()->create();
        $user->email = $data->get('email');
        $user->passwordHash = $passwordProvider->hash($data->get('password'));
        $user->save();

        $domain->setUser($user, 'session');
        $domain->provider('session')->persist();
        return $this->loggedInRedirect();
    }

    protected function getSignupValidator()
    {
        $validator = $this->components->validate()->validator();
        $document = $validator->rule()->addDocument();
        $document->allowExtraFields();

        $document->valueField('email')
            ->required()
            ->filter('email')
            ->callback(function ($result, $value) {
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

        $validator->rule()->callback(function ($result, $data) {
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
