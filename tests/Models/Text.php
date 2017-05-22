<?php

namespace Database\Tests\Models;

use Ablunier\Laravel\Database\Contracts\Repository\HasCustomRepository;
use Illuminate\Database\Eloquent\Model;

class Text extends Model implements HasCustomRepository
{
    /**
     * Get Eloquent Model custom repository.
     *
     * @return string
     */
    public function repository()
    {
        return \Database\Tests\Models\Repositories\TextRepository::class;
    }
}
