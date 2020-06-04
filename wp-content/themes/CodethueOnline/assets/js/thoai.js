jQuery(document).ready(function(){
  /*Resize col md 6 on tablet width 800 , container fix*/
    if (jQuery(window).width() < 801) {
        jQuery(".follow-me .col-md-6").addClass("container remove-col-6");
        jQuery(".follow-me .remove-col-6").removeClass("col-md-6");
        jQuery(".remove-col-6").css("max-width","100%");

        jQuery(".sub-footer").css({"display":"block","border-bottom":"unset"});
        jQuery(".menu-social").css("border-bottom","1.5px solid #dddbdb");
    }
});
