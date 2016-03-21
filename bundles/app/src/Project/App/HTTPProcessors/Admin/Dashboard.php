<?php

namespace Project\App\HTTPProcessors\Admin;

use PHPixie\AuthHTTP\Providers\Session as SessionProvider;
use PHPixie\HTTP\Request;
use Project\App\HTTPProcessors\Processor\AdminProtected;
use Project\App\ORM\User\UserRepository;

/**
 * Admin dashboard
 */
class Dashboard extends AdminProtected
{
    /**
     * Dashboard page
     * @param Request $request
     * @return mixed
     */
    public function defaultAction(Request $request)
    {
        $users = $this->userRepository()->query()->find();

        return $this->components->template()->get('app:admin/dashboard', array(
            'admin' => $this->admin,
            'users' => $users,
        ));
    }

    /**
     * Handles impersonation form
     * @param Request $request
     * @return mixed
     */
    public function impersonateAction(Request $request)
    {
        $id = $request->data()->getRequired('id');
        $user = $this->userRepository()->query()->in($id)->findOne();

        $userDomain = $this->builder->auth()->userDomain();
        $userDomain->setUser($user, 'session');

        /** @var SessionProvider $sessionProvider */
        $sessionProvider = $userDomain->provider('session');
        $sessionProvider->persist();

        return $this->redirectResponse('app.processor', array(
            'processor' => 'dashboard'
        ));
    }

    /**
     * @return UserRepository
     */
    protected function userRepository()
    {
        return $this->components->orm()->repository('user');
    }
}