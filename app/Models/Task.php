<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table        = "tasks";
    protected $primaryKey   =   "id";

    protected $fillable     =   [
        "description",
        "title",
        "visible_to_all",
        "status_id",
        "complete_until",
        "assigned_to",
        "created_at",
        "updated_at",
        "created_by"
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
