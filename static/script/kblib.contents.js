  $(function () {
    var buildContents = function () {
      var currentSection = undefined;
      var sections = [];
      $("h1, h2").each(function () {
        var $element = $(this);
        var nodeName = this.nodeName.toLowerCase();

        if ($element.attr("data-contents-role") != "skip") {
          if (nodeName == "h1") {
            currentSection = {text: $element.text(), subsections: []};
            sections.push(currentSection);
            $element
              .prepend("<a name=\"section" + sections.length + "\"></a><span class=\"section-index\">" + sections.length + ".</span> ")
              .append(" <a class=\"contents-link\" href=\"#contents\">Contents</a>");
          }
          else if (nodeName == "h2") {
            if (typeof currentSection != "undefined") {
              var subsection = {text: $element.text()};
              currentSection.subsections.push(subsection);
              $element
                .prepend("<a name=\"section" + sections.length + "-" + currentSection.subsections.length + "\"></a><span class=\"section-index\">" + sections.length + "." + currentSection.subsections.length + "</span> ")
                .append(" <a class=\"contents-link\" href=\"#contents\">Contents</a>");
            }
          }
        }
      });

      if (sections.length > 0) {
        var html = "<ol>";
        for (var i = 0; i < sections.length; ++i) {
          var section = sections[i];
          html += "<li><a href=\"#section" + (i + 1) + "\">" + section.text + "</a></li>";
          if (section.subsections.length > 0) {
            html += "<ol>";
            for (var j = 0; j < section.subsections.length; ++j) {
              var subsection = section.subsections[j];
              html += "<li><a href=\"#section" + (i + 1) + "-" + (j + 1) + "\">" + subsection.text + "</a></li>";
            }
            html += "</ol>";
          }
        }
        html += "</ol>";
        $("#contents").html("<ol>" + html + "</ol>");
      }
    };

    buildContents();
  });

