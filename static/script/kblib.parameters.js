  $(function () {
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
      }
      else {
        $("#reset").attr("disabled", "disabled");
      }
    };

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

    updateControls();
  });

