  $(function () {
    var createCustomizedLink = function () {
      var queryString = "";
      $("input[data-kb-role=value]").each(function () {
        var $input = $(this);
        var id = $input.attr("id");
        var value = $input.val();
        if (queryString.length > 0) {
          queryString += "&";
        }
        queryString += encodeURIComponent(id) + "=" + encodeURIComponent(value);
      });
      if (queryString.length > 0) {
        queryString = "?" + queryString;
      }

      var baseUri = window.location.href.split("?")[0];
      var result = baseUri + queryString;
      return result;
    };

    var populateParametersFromQueryString = function () {
      var queryStringParameters = KBLib.Utils.parseQueryString(location.search);
      $("input[data-kb-role=value]").each(function () {
        var $input = $(this);
        var id = $input.attr("id");
        var queryStringValue = queryStringParameters[id];
        if (queryStringValue !== undefined) {
          $input.val(queryStringValue);
        }
      });
    };

    var doValueUpdate = function ($input) {
      var id = $input.attr("id");
      var value = $input.val();
      $("." + id).text(value);
    };

    var isDirty = function () {
      var dirty = false;
      $("input[data-kb-role=value]").each(function () {
        var $input = $(this);
        if ($input.val() != $input.data("original-value")) {
          dirty = true;
          return false;
        }
        return true;
      });
      return dirty;
    };

    var updateControls = function () {
      if (isDirty()) {
        $("#reset").removeAttr("disabled");
        $("#link").removeAttr("disabled");
      }
      else {
        $("#reset").attr("disabled", "disabled");
        $("#link").attr("disabled", "disabled");
      }
    };

    populateParametersFromQueryString();

    $("input[data-kb-role=value]").each(function () {
      var $input = $(this);
      $input.data("original-value", $input.val());
      doValueUpdate($input);
    }).keyup(function () {
      var $input = $(this);
      doValueUpdate($input);
      updateControls();
    });

    $("#reset").click(function () {
      $("input[data-kb-role=value]").each(function () {
        var $input = $(this);
        $input.val($input.data("original-value"));
        doValueUpdate($input);
        updateControls();
      });
    });

    $("#link").click(function () {
      var link = createCustomizedLink();
      $("<div class=\"kb-dialog\"><p>Copy and paste the following link and e-mail it to your friends:</p><p><a href=\"" + link + "\">" + link + "</a></p></div>").dialog({
        title: "Customized link",
        width: 500
      });
    });

    updateControls();
  });

