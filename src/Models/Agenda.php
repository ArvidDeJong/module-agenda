<?php

namespace Darvis\ModuleAgenda\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Darvis\Manta\Traits\HasUploadsTrait;

class Agenda extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUploadsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'created_by',
        'updated_by',
        'deleted_by',
        'company_id',
        'host',
        'pid',
        'locale',
        'from',
        'till',
        'show_from',
        'show_till',
        'title',
        'title_2',
        'slug',
        'seo_title',
        'seo_description',
        'tags',
        'summary',
        'excerpt',
        'content',
        'contact',
        'email',
        'phone',
        'address',
        'zipcode',
        'city',
        'country',
        'price',
        'currency',
        'organizer_name',
        'organizer_url',
        'longitude',
        'latitude',
        'data',        // Nieuwe kolom
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    public function getDataAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }
}
