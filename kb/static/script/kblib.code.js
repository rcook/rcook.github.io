var KBLib = KBLib || {};

KBLib.Code = {}

KBLib.Code.setUp = function () {
  var trimWhitespace = function (str) {
    return str.replace(/^\s\s*/, "").replace(/\s\s*$/, "");
  };

  $(".code-block").each(function (index, item) {
    var $item = $(item);
    var lines = trimWhitespace($item.html()).split("\n");
    var html = "";
    $.each(lines, function (index, item) {
      html += "<span class=\"prompt\">&gt;</span> " + item + "\n";
    });
    $item.html(html);
  });

  $(".content").each(function (index, item) {
    var $item = $(item);
    $item.html(trimWhitespace($item.html()));
  });
};

