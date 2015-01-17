document.observe("dom:loaded", function() {
   var elements = $$('.custom-color');
   elements.each(function(item){
      item.up('tr').setStyle({
         backgroundColor: item.getStyle('background-color')
      });
   });
});

Ajax.Responders.register({
   onComplete: function() {
      var elements = $$('.custom-color');
      elements.each(function(item){
         item.up('tr').setStyle({
            backgroundColor: item.getStyle('background-color')
         });
      });
   }
});