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
   * @param integer totalRows
   * @param integer listRows
   * @param integer firstRow
   * @param string prevStr
   * @param string nextStr
   */
  getPaginator: function(funcName, totalRows, listRows, firstRow, prevStr, nextStr) {
    if (typeof(funcName) == "undefined" || typeof(totalRows) == "undefined" || typeof(listRows) == "undefined" || typeof(firstRow) == "undefined") {
      return "";
    }

    if (typeof(prevStr) == "undefined") {
      prevStr = "&lt;&lt;";
    }

    if (typeof(nextStr) == "undefined") {
      nextStr = "&gt;&gt;";
    }

    totalRows = parseInt(totalRows);
    listRows = parseInt(listRows);
    if (totalRows <= 0 || listRows <= 0) {
      return "";
    }

    if ((firstRow = parseInt(firstRow)) < 0) {
      firstRow = 0;
    }

    var totalPages = Math.ceil(totalRows / listRows);
    var currPage = Math.floor(firstRow / listRows) + 1;

    var string  = "<ul class=\"pagination\">";
    if (currPage > 1) {
      string += "<li><a href=\"javascript: " + funcName + "('" + (currPage - 1) + "');\">" + prevStr + "</a></li>";
    }

    if (currPage < totalPages) {
      string += "<li><a href=\"javascript: " + funcName + "('" + (currPage + 1) + "');\">" + nextStr + "</a></li>";
    }

    string += "</ul>";
    return string;
  },

  /**
   * 获取URL
   * @param string act
   * @param string ctrl
   * @param string mod
   * @param object params
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
  },

  /**
   * 页面重定向到登录页面
   * @return void
   */
  toLogin: function() {
    var url = Core.getUrl("member", "show", "login");
    Trotri.href(url);
  },

  /**
   * 投票
   * @param string name
   * @param string type
   * @return string
   */
  vote: function(name, type) {
    var url = Core.getUrl("poll", "data", "vote", {"t" : new Date().getTime()});
    var value = (type == "checkbox") ? Trotri.getCheckedValues(name + "[]") : $(":radio[name='" + name + "']:checked").val();
    $.getJSON(url, {"key": name, "value": value}, function(ret) {
      if (ret.err_no === 3001) {
        Core.toLogin();
      }

      alert(ret.err_msg);
    });
  }

}
