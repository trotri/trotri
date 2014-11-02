/*!
 * IE10 viewport hack for Surface/desktop Windows 8 bug
 * Copyright 2014 Twitter, Inc.
 * Licensed under the Creative Commons Attribution 3.0 Unported License. For
 * details, see http://creativecommons.org/licenses/by/3.0/.
 */

// See the Getting Started docs for more information:
// http://getbootstrap.com/getting-started/#support-ie10-width

(function () {
  'use strict';
  if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement('style')
    msViewportStyle.appendChild(
      document.createTextNode(
        '@-ms-viewport{width:auto!important}'
      )
    )
    document.querySelector('head').appendChild(msViewportStyle)
  }
})();

$(document).ready(function() {
  $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
  });
});

/**
 * Core
 * @author songhuan <trotri@yeah.net>
 * @version $Id: template.js 1 2013-10-16 18:38:00Z $
 */
Core = {
  /**
   * 获取分页HTML
   * @param string funcName
   * @param integer currPage
   * @param integer totalRows
   * @param integer listRows
   */
  getPaginator: function(funcName, currPage, totalRows, listRows) {
    if (typeof(currPage) == "undefined" || typeof(totalRows) == "undefined" || typeof(listRows) == "undefined") {
      return "";
    }

    currPage = parseInt(currPage);
    totalRows = parseInt(totalRows);
    listRows = parseInt(listRows);
    if (currPage <= 0 || totalRows <= 0 || listRows <= 0) {
      return "";
    }

    var totalPages = Math.ceil(totalRows / listRows);
    var nextPage = (currPage < totalPages) ? currPage + 1 : totalPages;

    var string  = "<ul class=\"pagination\">";
    if (currPage > 1) {
      string += "<li><a href=\"javascript: " + funcName + "('" + (currPage - 1) + "');\">&lt;&lt;</a></li>";
    }
    if (currPage < totalPages) {
      string += "<li><a href=\"javascript: " + funcName + "('" + (currPage + 1) + "');\">&gt;&gt;</a></li>";
    }
    string += "</ul>";
    return string;
  },

  /**
   * 获取URL
   * @param string act
   * @param string ctrl
   * @param string mod
   * @param array params
   * @return string
   */
  getUrl: function(mod, ctrl, act, params) {
    var url = g_url + "?r=" + mod + "/" + ctrl + "/" + act;
    if (typeof(params) == "object") {
      for (var key in params) {
        url += "&" + key + "=" + params[key];
      }
    }
    return url;
  }
}
