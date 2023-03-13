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
        "status",
        "complete_until",
        "completed_by",
        "completed_in",
        "assigned_to",
        "created_at",
        "updated_at",
        "created_by"
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
