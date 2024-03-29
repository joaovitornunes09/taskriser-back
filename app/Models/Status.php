<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table    = "status_task";

    protected $fillable = ["status"];

    protected $primaryKey = "id";
}
