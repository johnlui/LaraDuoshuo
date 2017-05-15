var APP_KEY = 'base64:nMYxR20sgL9zbiRrMS8GekiVzPSLBId9QAoTepx+nuk=';
var getUUID = function(identity, callback) {
  var seed = Math.round(new Date().getTime()/1000);
  var sign = md5((seed + APP_KEY).split('').sort().join(''));
  $.jsonp({
    url: 'http://fuck.io:9000/get-uuid',
    data: {
      'identity': identity,
      'seed': seed,
      'sign': sign
    },
    success: function(response) {
      if (response.status !== 0) {
        alert(response.message);
      } else {
        callback(response.values);
      }
    }
  });
};
var getCommentsByUUID = function(uuid, callback) {
  var seed = Math.round(new Date().getTime()/1000);
  var sign = md5((seed + APP_KEY).split('').sort().join(''));
  $.jsonp({
    url: 'http://fuck.io:9000/get-comments-by-uuid',
    data: {
      'uuid': uuid,
      'seed': seed,
      'sign': sign
    },
    success: function(response) {
      if (response.status !== 0) {
        alert(response.message);
      } else {
        callback(response.values);
      }
    }
  });
};
$('#comments').ready(function() {
  var commentsDOM = $('#comments');
  commentsDOM.html('<div style="font-size: 18px; margin: 10px 20px;">评论加载中...</div>')
  getUUID(location.href, function(uuid) {
    getCommentsByUUID(uuid, function(comments) {
      var commentsHTML = '';
      for (var i = comments.length - 1; i >= 0; i--) {
        commentsHTML +=
        '<div class="commment">\
          <div class="avatar"><img src="' + comments[i].avatar_uri + '" alt="' + comments[i].nickname + ' avatar" /></div>\
          <div class="comment-info"><div class="nickname">' + comments[i].nickname + '</div><div class="time">' + comments[i].created_at + '</div><div class="content">' + comments[i].content + '</div></div>\
        </div>\
        <div style="clear: both; height: 30px;"></div>';
        console.log(comments[i]);
      }
      commentsDOM.html(commentsHTML);
    });
  });
});