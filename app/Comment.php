<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  public function belongsToArticle()
  {
    return $this->belongsTo(Article::class, 'article_id', 'id');
  }
}
