 $(document).ready(function() {
            $(".menu-icon").on("click", function() {
                  $("nav ul").toggleClass("showing");
            });
      });

      // Scrolling Effect

      $(window).on("scroll", function() {
            if($(window).scrollTop()) {
                  $('nav').addClass('black');
            }

            else {
                  $('nav').removeClass('black');
            }
      })

//$(function() {
//  $('a[href=#*]').on('click', function(e) {
//    e.preventDefault();
//    $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top}, 500, 'linear');
//  });
//});

//Recup taille ecran puis changer taille des div

var navHeight = document.getElementsByTagName('nav')[0].clientHeight;
console.log(navHeight);
var totalHeight = window.innerHeight;
sections = document.getElementsByTagName('section')
for(var i =0; i<sections.length; i++){	
	sections[i].style.height=(totalHeight-navHeight+99)+"px"
}

