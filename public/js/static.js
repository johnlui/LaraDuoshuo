var getUUID = function(identity) {
  $.jsonp({
    url: 'http://fuck.io:9000/get-uuid',
    data: { 'identity': identity },
    success: function(response) {
      if (response.status !== 0) {
        alert(response.message);
      } else {
        UUID = response.values;
      }
    }
  });
};
var getCommentsByUUID = function(uuid) {
  $.jsonp({
    url: 'http://fuck.io:9000/get-comments-by-uuid',
    data: { 'uuid': uuid },
    success: function(response) {
      if (response.status !== 0) {
        alert(response.message);
      } else {
        COMMENTS = response.values;
      }
    }
  });
};