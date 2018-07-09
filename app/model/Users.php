<?php

namespace Sharminshanta\Web\Accounts\Model;

use Illuminate\Database\Query\Builder;


/**
 * Class Users
 * @package Sharminshanta\Web\Accounts\Model
 */
class Users extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = [
        'email_address',
        'password',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'email_address' => 'string',
        'password' => 'string',
    ];

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAll()
    {
        /**
         * @var $this Builder
         */
        return $this->get();
    }

    /**
     * @param $postdata
     * @return mixed
     */
    public function createNew($postdata)
    {
        $postData = $postdata;
        return $this->create($postData);

    }

    /**
     * @param $postdata
     * @return mixed
     */
    public function updateUser($id)
    {
        /**
         * @var $this Builder
         */
        return $this->where('id', $id)->first();

    }
}