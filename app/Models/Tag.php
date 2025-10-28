<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Documentとの多対多リレーション
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'document_tag');
    }
}
