
//===================
// Datetime picker 
//===================

jQuery(function(){
 jQuery('#date_timepicker_start').datetimepicker({
  onShow:function( ct ){
   this.setOptions({
    maxDate:jQuery('#date_timepicker_end').val()?jQuery('#date_timepicker_end').val():false
   })
  },
 });
 jQuery('#date_timepicker_end').datetimepicker({
  onShow:function( ct ){
   this.setOptions({
    minDate:jQuery('#date_timepicker_start').val()?jQuery('#date_timepicker_start').val():false
   })
  },
 });
});


//=========================
// Email address validation 
//=========================
jQuery(function(){
  jQuery("#post").change(function($){
    var email = jQuery("input[name='email']").val();
    var phone = jQuery("input[name='phone']").val(),
    intRegex = /[0-9 -()+]+$/;
    if(email != 0)
    {
        if(isValidEmailAddress(email))
        {
            jQuery("div[name='pop_message']").hide();
           
        } else {
            jQuery("div[name='pop_message']").show();
            
        }
    }


  if( phone !=0 ){
      if( (!intRegex.test(phone)))
          {
               jQuery("div[name='pop_message_phone']").show();
          }
      else 
      {
          jQuery("div[name='pop_message_phone']").hide();
      }
  }

  });

  function isValidEmailAddress(emailAddress) {
      var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
      return pattern.test(emailAddress);
  }
});