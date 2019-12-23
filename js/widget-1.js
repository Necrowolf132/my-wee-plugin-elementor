
jQuery(document).ready(function(){
    var nav_offset_top = jQuery('header').height() + 10; 
    /*-------------------------------------------------------------------------------
      Navbar 
    -------------------------------------------------------------------------------*/
    
    //* Navbar Fixed  
    function navbarFixed(){
        if ( ('.header-top').length ){ 
            jQuery(window).scroll(function() {
                var scroll = jQuery(window).scrollTop();   
                if (scroll >= nav_offset_top ) {
                    jQuery(".header-top").addClass("relieve");
                } else {
                    jQuery(".header-top").removeClass("relieve");
                }
            });
        };
    };
    navbarFixed();
    jQuery('a[href^="#-"]').click(rodar);

    function  rodar(event) {
       //this.preventDefault();
       var togle_parent =  jQuery(this).data('padretogle');
       if(!togle_parent){
        togle_parent = '.collapse';
       }
       var destino = jQuery(this.hash).offset().top;
       var anchoVentana = window.innerWidth || document.body.clientWidth
       destino =  jQuery(this.hash);
       if (destino.length == 0) {
           console.log('estoy aqui 2');
           destino = jQuery('a[name="' + this.hash.substr(1) + '"]');
       }
       if (destino.length == 0) {
           destino = jQuery('html');
       }
       var restaAltura = 0;
       if(anchoVentana < 768){
         restaAltura = 81;
         jQuery(togle_parent).collapse('hide'); 
       }else if(anchoVentana < 1025){
         restaAltura = 109;
          jQuery(togle_parent).collapse('hide'); 
       } else {
         restaAltura = 129;
       }
       var mover =   jQuery(this.hash).offset().top - restaAltura ;
       jQuery('html, body').animate({ scrollTop: mover});
   
       return false;
   
   }
});

