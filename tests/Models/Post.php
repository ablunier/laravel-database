<?php

namespace Database\Tests\Models;

use Ablunier\Laravel\Database\Contracts\Repository\HasCustomRepository;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements HasCustomRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get Eloquent Model custom repository.
     *
     * @return string
     */
    public function repository()
    {
        return \Database\Tests\Models\Repositories\PostRepository::class;
    }
}
