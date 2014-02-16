$(document).ready(function() {
  $(":checkbox[name='tbl_profile']").change(function() {
    Core.singleModify($(this));
  });

  $(":checkbox[name='column_auto_increment']").change(function() {
    Core.singleModify($(this));
  });

  $("select[name='validator_name']").change(function() {
    var validatorName = $(this).val();
    var optionCategory = validators[validatorName]['option_category'];
    var message = validators[validatorName]['message'];
    $(":text[name='options']").parent().next("span").html("Suggest Option Category: " + optionCategory);
    $(":text[name='message']").val(message);
  });
});

/**
 * Builder
 * @author songhuan <trotri@yeah.net>
 * @version $Id: builder.js 1 2013-10-16 18:38:00Z $
 */
Builder = {

}
