@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">管理评论</div>

        <div class="panel-body">

          @if (count($errors) > 0)
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (!count($comments))
            <h2>暂无评论</h2>
          @else
            <table class="table table-striped">
              <tr class="row">
                <th class="col-lg-4">Content</th>
                <th class="col-lg-2">User</th>
                <th class="col-lg-3">Page</th>
                <th class="col-lg-1" style="text-align: center;">审核</th>
                <th class="col-lg-1">编辑</th>
                <th class="col-lg-1">删除</th>
              </tr>
              @foreach ($comments as $comment)
                <tr class="row">
                  <td class="col-lg-6">
                    {{ $comment->content }}
                  </td>
                  <td class="col-lg-2">
                    @if ($comment->website)
                      <a href="{{ $comment->website }}">
                        <h4>{{ $comment->nickname }}</h4>
                      </a>
                    @else
                      <h3>{{ $comment->nickname }}</h3>
                    @endif
                    {{ $comment->email }}
                  </td>
                  <td class="col-lg-3">
                    <a href="{{ $comment->belongsToArticle->identity }}" target="_blank">
                      {{ $comment->belongsToArticle->identity }}
                    </a>
                  </td>
                  <td class="col-lg-1" style="text-align: center;">
                    @if ($comment->checked)
                      已审核
                    @else
                      <div style="color: #ff3333;">未审核</div>
                      <a href="{{ url('admin/'.$comment->id.'/checked') }}" class="btn btn-primary btn-xs">通过审核</a>
                    @endif
                  </td>
                  <td class="col-lg-1">
                    <a href="{{ url('admin/'.$comment->id.'/edit') }}" class="btn btn-success">编辑</a>
                  </td>
                  <td class="col-lg-1">
                    <form action="{{ url('admin/'.$comment->id) }}" method="POST" style="display: inline;">
                      <input name="_method" type="hidden" value="DELETE">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="btn btn-danger">删除</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </table>
          @endif

          {{{ $comments->render() }}}
        </div>
    </div>
  </div>
</div>
@endsection