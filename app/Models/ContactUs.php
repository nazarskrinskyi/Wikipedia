<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validated)
 * @method static findOrFail($id)
 */
class ContactUs extends Model
{
    protected $table = 'contact_us';

    protected $fillable = ['username', 'email', 'content'];
}
