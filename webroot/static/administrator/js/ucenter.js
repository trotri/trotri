$(document).ready(function() {
  Ucenter.checkedToggle();
});

/**
 * Ucenter
 * @author songhuan <trotri@yeah.net>
 * @version $Id: ucenter.js 1 2014-01-25 18:38:00Z $
 */
Ucenter = {
  /**
   * Ctrl CheckBox全选|全不选，jQuery方式有Bug：全不选后，再全选失败
   * @return void
   */
  checkedToggle: function() {
    var ctrls = Trotri.getInputs("checkbox", "__ctrl__[]");
    for (var i in ctrls) {
      var acts = Trotri.getInputs("checkbox", ctrls[i].value);
      ctrls[i].onclick = function() {
      	alert("aaa");
	    for (var i in acts) {
	      // acts[i].checked = ctrls[i];
	      // $(acts[i]).parent().addClass("checked");
	      alert("aaa");
	    }
	  }
    };

 /*
    if (o == undefined) { return ; }
    var a = Trotri.getInputs("checkbox", o.value);
    o.onclick = function() {
      for (var i in a) {
        a[i].checked = o.checked;
      }
    }
   
    for (var i in a) {
      a[i].onclick = function() {
        o.checked = (Trotri.getCheckeds(o.value).length == a.length);
      }
    }
    */
  },
}
