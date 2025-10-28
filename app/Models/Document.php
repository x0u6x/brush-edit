<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'user_id'];
    // 一括代入OKなカラム

    // ユーザーごとのタグ取得（多対多）
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'document_tag');
    }
}
