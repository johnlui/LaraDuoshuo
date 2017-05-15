var LaraDuoshuo = {
  APP_KEY: 'base64:nMYxR20sgL9zbiRrMS8GekiVzPSLBId9QAoTepx+nuk=',
  getUUID: function(identity, callback) {
    var seed = Math.round(new Date().getTime()/1000);
    var sign = md5((seed + LaraDuoshuo.APP_KEY).split('').sort().join(''));
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
  },
  getCommentsByUUID: function(uuid, callback) {
    var seed = Math.round(new Date().getTime()/1000);
    var sign = md5((seed + LaraDuoshuo.APP_KEY).split('').sort().join(''));
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
  },
  submit: function(submitDOM) {
    var nickname = submitDOM.find('.nickname').val().trim();
    var email    = submitDOM.find('.email').val().trim();
    var website  = submitDOM.find('.website').val().trim();
    var uuid     = submitDOM.find('.uuid').val().trim();
    var content  = validator.escape(submitDOM.find('.content').val().trim());
    
    submitDOM.find('.nickname').val(nickname);
    submitDOM.find('.email').val(email);
    submitDOM.find('.website').val(website);
    submitDOM.find('.uuid').val(uuid);
    submitDOM.find('.content').val(content);
    
    if (nickname === '') {
      alert('昵称为空');
      return;
    }
    if (content === '') {
      alert('评论为空');
      return;
    }
    if ( email && !validator.isEmail(email)) {
      alert('邮箱格式不合法');
      return;
    }
    if ( website && !validator.isURL(website)) {
      alert('主页网址格式不合法');
      return;
    }
    
    var seed = Math.round(new Date().getTime()/1000);
    var sign = md5((seed + LaraDuoshuo.APP_KEY).split('').sort().join(''));
    $.jsonp({
      url: 'http://fuck.io:9000/add-comments-by-uuid',
      data: {
        'nickname': nickname,
        'email': email,
        'website': website,
        'uuid': uuid,
        'content': content,
        'seed': seed,
        'sign': sign
      },
      success: function(response) {
        if (response.status !== 0) {
          alert(response.message);
        } else {
          LaraDuoshuo.loadComments(function() {
            location.href = '#comments';
          });
        }
      }
    });
  },
  loadComments: function(callback) {
    var commentsDOM = $('#comments');
    commentsDOM.html('<div style="font-size: 18px; margin: 10px 20px;">评论加载中...</div>')
    LaraDuoshuo.getUUID(location.href.replace(location.search, '').replace(location.hash, ''), function(uuid) {
      LaraDuoshuo.getCommentsByUUID(uuid, function(comments) {
        var commentsHTML = '';
        for (var i = comments.length - 1; i >= 0; i--) {
          commentsHTML +=
          '<div class="commment">\
            <div class="avatar"><img src="' + comments[i].avatar_uri + '" alt="' + comments[i].nickname + ' avatar" /></div>\
            <div class="comment-info"><div class="nickname">' + (comments[i].website ? '<a href="' + comments[i].website + '" target="_blank">' + comments[i].nickname + '</a>' : comments[i].nickname) + '</div><div class="time">' + comments[i].created_at + '</div><div class="content">' + comments[i].content + '</div></div>\
          </div>\
          <div style="clear: both; height: 30px;"></div>';
          // console.log(comments[i]);
        }
        commentsDOM.html(commentsHTML);
        commentsDOM.append(
          '<div class="submit">\
            <input type="text" class="nickname" placeholder="nickname（必填）"/>\
            <input type="text" class="email" placeholder="email"/>\
            <input type="text" class="website" placeholder="website"/>\
            <input type="text" class="uuid" value="' + uuid + '" hidden="hidden"/>\
            <br />\
            <textarea name="" id="" cols="30" rows="10" class="content" placeholder="content（必填）"></textarea>\
            <button onclick="LaraDuoshuo.submit($(this).parent());">提交评论</button>\
          </div>'
        );
        callback();
      });
    });
  }
}
$('#comments').ready(function() {
  LaraDuoshuo.loadComments();
});