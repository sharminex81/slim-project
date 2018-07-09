<?php

namespace Sharminshanta\Web\Accounts\Model;


use Illuminate\Database\Query\Builder;

/**
 * Class ModelLoader
 * @package Sharminshanta\Web\Accounts\Model
 */
class ModelLoader
{
    /**
     * @return Users|Builder
     */
    public function getUsers()
    {
        $users = new Users();
        return $users;
    }
}