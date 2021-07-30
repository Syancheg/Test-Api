<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalToAuthor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['author_id', 'journal_id'];
}
