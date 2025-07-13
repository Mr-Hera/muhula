

    $(document).click(function (event) {
      $('.navbar-collapse').collapse('hide');
    });
    $('.navbar-collapse').click(function (event) {event.stopPropagation();});
  

  $("#lft_filter").click(function(){
    $("#product_lft").slideToggle();
  });

$(window).scroll(function() {    
    var scroll = $(window).scrollTop();

    if (scroll >= 100) {
        $("header").addClass("lightheader");
    } else {
        $("header").removeClass("lightheader");
    }
});



$(function(){
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");
    if(togglePassword){
    togglePassword.addEventListener("click", function () {
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        this.classList.toggle("fa-eye-slash");
    });
  }
  });
  
  $(function(){
    const togglePassword2 = document.querySelector("#togglePassword2");
    const password2 = document.querySelector("#password2");
    if(togglePassword2){
    togglePassword2.addEventListener("click", function () {
        const type = password2.getAttribute("type") === "password" ? "text" : "password";
        password2.setAttribute("type", type);
        this.classList.toggle("fa-eye-slash");
    });
  }
  });

    $(function(){
    const togglePassword3 = document.querySelector("#togglePassword3");
    const password2 = document.querySelector("#password3");
    if(togglePassword3){
    togglePassword3.addEventListener("click", function () {
        const type = password3.getAttribute("type") === "password" ? "text" : "password";
        password2.setAttribute("type", type);
        this.classList.toggle("fa-eye-slash");
    });
  }
  });

 // $(function(){
        //$('#thumbnails').Thumbelina({
            //$bwdBut:$('#thumbnails .left'),   
            //$fwdBut:$('#thumbnails .right')    
        //});
    //})

$(document).ready(function(){
    var scrollToTopBtn = document.querySelector("#scrollToTopBtn");
    var rootElement = document.documentElement;
    
    function handleScroll() {
      // Do something on scroll
      var scrollTotal = rootElement.scrollHeight - rootElement.clientHeight;
      if (rootElement.scrollTop / scrollTotal > 0.3) {
        // Show button
        scrollToTopBtn.classList.add("showBtn");
      } else {
        // Hide button
        scrollToTopBtn.classList.remove("showBtn");
      }
    }
    
    function scrollToTop() {
      // Scroll to top logic
      rootElement.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    }
    scrollToTopBtn.addEventListener("click", scrollToTop);
    document.addEventListener("scroll", handleScroll);
  });


$(document).ready(function(){
    $(".click_filter").click(function(){$(".left-bar").slideToggle();});
});
$(document).on('click', function () {
  if (('.left-bar').is(":visible")) {$('.left-bar').slideUp();}
}); 


    $(document).ready(function() {
      $(".sort_open").click(function() {
          $(".sort_lst").slideToggle("slow");
      });
    });



    $('#show-more-content').hide();

$('#show-more').click(function(){
    $('#show-more-content').show(300);
    $('#show-less').show();
    $('#show-more').hide();
});

$('#show-less').click(function(){
    $('#show-more-content').hide(150);
    $('#show-more').show();
    $(this).hide();
});

$(".loggd-nv-btn").click(function(){
        $(".loggd-nv-list").slideToggle();
    });
    $('body').click(function(){
        if( $(".loggd-nv-list").is(':visible') ) {
          $(".loggd-nv-list").slideUp();
        }
    });
    $('.loggd-nv-list').click(function (event) {event.stopPropagation();});
    $('.loggd-nv-btn').click(function (event) {event.stopPropagation();});


    $(document).ready(function(){
        $('.menu__element').click(function(){
        $('.menu__element').removeClass("active");
        $(this).addClass("active");
        });
    });


var so=150;
var sc=90;
var sd=120;
var sos=130;
var scs=120;
var sds=140;
var soa=150;
var sca=90;
var post=180;
var sda=120
if (window.matchMedia('(max-width: 900px)').matches) {
so=190;
sc=150;
sd=150;
sos=160;
scs=160;
sds=160;
soa=150;
sca=150;
post=180;
sda=120
}
    $('.what1').click(function(){
$('html, body').animate({
'scrollTop' : $("#what_why_panel1").position().top-so
});
});
    $('.why1').click(function(){
$('html, body').animate({
'scrollTop' : $("#what_why_panel2").position().top-sc
});
});
    $('.how1').click(function(){
$('html, body').animate({
'scrollTop' : $("#how_sec").position().top-sd
});
});

    $('.what2').click(function(){
$('html, body').animate({
'scrollTop' : $("#what_why_panel12").position().top-sos
});
});
    $('.why2').click(function(){
$('html, body').animate({
'scrollTop' : $("#what_why_panel22").position().top-scs
});
});
    $('.how2').click(function(){
$('html, body').animate({
'scrollTop' : $("#how_sec2").position().top-sds
});
});


        $('.what3').click(function(){
$('html, body').animate({
'scrollTop' : $("#what_why_panel13").position().top-soa
});
});
    $('.why3').click(function(){
$('html, body').animate({
'scrollTop' : $("#what_why_panel23").position().top-sca
});
});
    $('.how3').click(function(){
$('html, body').animate({
'scrollTop' : $("#how_sec23").position().top-sda
});
});

      $('.post_tab').click(function(){
$('html, body').animate({
'scrollTop' : $("#post-schs").position().top-post
});
});


    function handleOtherPetVisibility() {
      if ($("#otherpetdrop").is(':checked')) {
        $("#otherPet").slideDown();
      } else {
        $("#otherPet").slideUp();
      }
    }
    handleOtherPetVisibility();
    $("#otherpetdrop").change(function(){
      handleOtherPetVisibility();
    });
    $('.quote-label').click(function(){
      if ($("#otherPet").is(':visible')) {
        $("#otherPet").slideUp();
      }
    });
    $('#otherpetdrop').click(function (event) {
      event.stopPropagation();
    });


//  $(document).ready(function() {
//       let minusBtn = document.getElementById("minus-btn");
//       let count = document.getElementById("count");
//       let plusBtn = document.getElementById("plus-btn");
      
//       //let countNum = 0;
//       count.innerHTML = countNum;
      
//       minusBtn.addEventListener("click", () => {
//         if (countNum > 0) {
//           countNum -= 1;
//           count.innerHTML = countNum;
//         }
//       });
      
//       plusBtn.addEventListener("click", () => {
//         countNum += 1;
//         count.innerHTML = countNum;
//       });
//     })
    

    
/* 27-02 */
    const counters = document.querySelectorAll(".counter");
      counters.forEach((counter) => {
      counter.innerText = "0";
      const updateCounter = () => {
         const target = +counter.getAttribute("data-target");
         const count = +counter.innerText;
         const increment = 10;
         if (count < target) {
            counter.innerText = `${Math.ceil(count + increment)}`;
            setTimeout(updateCounter, 1);
         } else counter.innerText = target;
      };
      updateCounter();
      });

/* 27-02 */