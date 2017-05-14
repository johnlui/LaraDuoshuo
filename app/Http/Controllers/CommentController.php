<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article, App\Comment;

class CommentController extends Controller
{
  public function getCommentsByUUID(Request $request)
  {
    $uuid = $request->get('uuid');
    if (!$uuid) {
      return $this->jsonPResponse(404, '缺少 uuid 字段');
    }

    $article = Article::where('uuid', $uuid)->first();
    if ($article) {
      $comments = $article->hasManyComments()->get(['nickname', 'email', 'website', 'created_at'])->toArray();
      return $this->jsonPResponse(0, 'OK', $comments);
    } else {
      return $this->jsonPResponse(404, 'uuid 不存在');
    }
  }
}
