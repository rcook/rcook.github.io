var KBLib = KBLib || {};

KBLib.Utils = {}

KBLib.Utils.parseQueryString = function (queryString) {
  var e;
  var a = /\+/g;
  var r = /([^&=]+)=?([^&]*)/g;
  var d = function (s) {return decodeURIComponent(s.replace(a, " "));};
  var q = queryString.substring(1);
  var values = {};
  while (e = r.exec(q)) {
    values[d(e[1])] = d(e[2]);
  }
  return values;
};

KBLib.Utils.createElementId = (function () {
  var id = 0;
  return function (label) {
    return "KBLib-" + label + "-" + (id++);
  };
}());

