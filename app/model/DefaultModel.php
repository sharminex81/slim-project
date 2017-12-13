<?php

namespace Sharminshanta\Web\Accounts\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class DefaultModel
 * @package Sharminshanta\Web\Accounts\Model
 */
class DefaultModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var bool
     */
    public $timestamps = false;

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
     * @return mixed
     */
    public function getAll()
    {
        /**
         * @var $this Model|Builder
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
         * @var $this Model|Builder
         */
       return $this->where('id', $id)->first();

    }
}