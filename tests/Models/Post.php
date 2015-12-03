<?php
namespace Database\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use ANavallaSuiza\Laravel\Database\Contracts\Repository\HasCustomRepository;

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
     * Get Eloquent Model custom repository
     *
     * @return string
     */
    public function repository()
    {
        return \Database\Tests\Models\Repositories\PostRepository::class;
    }
}
