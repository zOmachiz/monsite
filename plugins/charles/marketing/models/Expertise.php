<?php namespace Charles\Marketing\Models;

use Model;

/**
 * Expertise Model
 */
class Expertise extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'charles_marketing_expertises';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
