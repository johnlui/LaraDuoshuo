<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article;

use Ramsey\Uuid\Uuid;

class ArticleController extends Controller
{
  public function getUUID(Request $request)
  {
    $identity = $request->get('identity');
    if (!$identity) {
      return $this->jsonPResponse(404, '缺少 identity 字段');
    }

    $identityInDatabase = Article::where('identity', $identity)->get()->toArray();
    if (count($identityInDatabase)) {
      return $this->jsonPResponse(0, 'OK', $identityInDatabase[0]['uuid']);
    } else {
      $article = new Article;
      $article->identity = $identity;
      $article->uuid = Uuid::uuid1()->toString();
      $article->save();
      return $this->jsonPResponse(0, 'OK', $article->uuid);
    }
  }
}
