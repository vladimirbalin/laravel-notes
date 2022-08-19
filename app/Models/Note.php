<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Note model",
 *     required={"title", "content", "created_by"},
 *     schema="note",
 * )
 */

class Note extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *     format="string",
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @OA\Property(
     *     format="string",
     * )
     *
     * @var string
     */
    private $content;

    /**
     * @OA\Property(
     *     format="int",
     * )
     *
     * @var int
     */
    private $created_by;

    protected $fillable = ['title', 'content', 'created_by'];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
