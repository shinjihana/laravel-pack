<?php
namespace Happy\ThreadMan\Filters;

use App\User;

class ThreadFilters extends Filters
{

    protected $filters = ['by', 'popular', 'unanswered'];

    /**
     * Filter the query by a given username
     * @Var $username
     * @return mixed
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query by a given popular comments
     * @Var $username
     * @return mixed
     */
    public function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }

    /**
     * filter unanswered thread
     */
    public function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }
}