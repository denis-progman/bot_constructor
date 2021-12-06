<?php


namespace BotConstructor\User;


use BotConstructor\core\MainHydrator;
use BotConstructor\User;

class UserService
{
    private User $user;

    private UserRepository $repository;

    public function __construct($user_id = null) {
        $this->repository = new UserRepository();
        $this->user = new User();
        var_dump($user_id);
        MainHydrator::hydrate($this->repository->getData($user_id), $this->user, []);
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return UserRepository
     */
    public function getRepository(): UserRepository
    {
        return $this->repository;
    }


}