<?php
namespace Database\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Ablunier\Laravel\Database\Contracts\Repository\HasCustomRepository;

class Text extends Model implements HasCustomRepository
{
    /**
     * Get Eloquent Model custom repository
     *
     * @return string
     */
    public function repository()
    {
        return \Database\Tests\Models\Repositories\TextRepository::class;
    }
}
