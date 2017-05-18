<?php

namespace App\Http\Controllers\Admin;

use App\Comment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
  public function index()
  {
    return view('admin.index')->withComments(Comment::with('belongsToArticle')->orderBy('id', 'desc')->paginate(20));
  }

  public function edit($id)
  {
    return view('admin.edit')->withComment(Comment::find($id));
  }

  public function checked($id)
  {
    $comment = Comment::find($id);
    $comment->checked = 1;
    $comment->save();
    return redirect()->back()->withErrors('审核成功！');
  }

  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'nickname' => 'required',
      'content' => 'required',
    ]);
    if (Comment::where('id', $id)->update($request->except(['_method', '_token']))) {
      return redirect()->to('admin')->withErrors('编辑成功！');
    } else {
      return redirect()->back()->withInput()->withErrors('编辑失败！');
    }
  }

  public function destroy($id)
  {
    $comment = Comment::find($id);
    $comment->delete();

    return redirect()->back()->withErrors('删除成功！');
  }
}
