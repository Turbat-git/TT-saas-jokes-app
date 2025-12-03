<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsStringable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'title' => AsStringable::class,
            'description' => AsStringable::class
        ];
    }

    /**
     * Return the slug version of the category title
     *
     */
    public function slug(): null|string
    {
        return $this->title->slug();
    }

    public function snippet(int $words = 5): null|string
    {
        if (is_null($this->description)) {
            return "";
        }
        return ($this->description->words($words));
    }

    public function jokes()
    {
        return $this->belongsToMany(Joke::class)
            ->using(\App\Models\CategoryJoke::class)
            ->withTimestamps();
    }

}
