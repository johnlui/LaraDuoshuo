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
      $comments = $article->hasManyComments()->get(['nickname', 'email', 'website', 'avatar_uri', 'content', 'created_at'])->toArray();
      return $this->jsonPResponse(0, 'OK', $comments);
    } else {
      return $this->jsonPResponse(404, 'uuid 不存在');
    }
  }
  public function addCommentsByUUID(Request $request)
  {
    $validator = \Validator::make($request->all(), [
      'nickname' => 'required|max:255',
      'email' => 'max:255',
      'website' => 'max:255',
      'uuid' => 'required|size:36',
      'content' => 'required|max:3000',
    ]);
    if ($validator->fails()) {
      return $this->jsonPResponse(403, json_encode($validator->errors(), JSON_UNESCAPED_UNICODE));
    }
    $article = Article::where('uuid', $request->get('uuid'))->first();
    if (!$article) {
      return $this->jsonPResponse(404, 'uuid 不存在');
    }

    $comment = new Comment;
    $comment->nickname = $request->get('nickname');
    $comment->email = $request->get('email');
    $comment->avatar_uri = (new \Identicon\Identicon())->getImageDataUri($comment->nickname.$comment->email);
    $comment->website = $request->get('website');
    $comment->article_id = $article->id;
    $comment->content = $request->get('content');
    $comment->save();

    return $this->jsonPResponse(0, 'OK');
  }
}
