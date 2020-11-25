window.addEventListener("DOMContentLoaded", init);

/**
 * Init event listeners
 * @return {void}
 */
function init(){

    var sliderContainer = $('.slick-container');

    sliderContainer.on('init', resetTabindexSlider);
    sliderContainer.on('init', displayDots);
    sliderContainer.on('setPosition', resetTabindexSlider);

    sliderContainer.slick({
        dots: true,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        arrows: false,
        accessibility: true,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              arrows: false,
              slidesToShow: 2,
              slidesToScroll: 1,
            }
          },
          {
            breakpoint: 480,
            settings: {
              arrows: false,
              slidesToScroll: 1,
              slidesToShow: 1
            }
          }
        ]
    });

    var animatedCardLinks = document.querySelectorAll('.animated-card .animated-card-content a');
    for(var index = 0; index < animatedCardLinks.length; ++index){
        animatedCardLinks[index].addEventListener('focusin', applyFocus);
        animatedCardLinks[index].addEventListener('focusout', removeFocus);
    }
}

function displayDots(){
  setTimeout(function(){
    console.log(document.querySelector('.slick-dots'))
    var dotsContainer =  document.querySelector('.slick-dots');
    
    if(dotsContainer){
      var displayClass = 'd-none';
      if(dotsContainer.querySelectorAll('.slick-dots li').length > 1){
        displayClass = 'd-block';
      }
      dotsContainer.classList.add(displayClass);
    }
  }, 500)
}

function resetTabindexSlider(){
    setTimeout(function(){
        var activeSlides = document.querySelectorAll('.slick-slide.slick-active');
        for(var index = 0; index < activeSlides.length; ++index){
            activeSlides[index].setAttribute('tabindex', '-1');
        }
    
        var slideDots = document.querySelectorAll('.slick-dots button');
        for(var index = 0; index < slideDots.length; ++index){
            slideDots[index].setAttribute('tabindex', '0');
        }
    }, 500)
}

/**
 * Add class focus
 * @param {Event} event - focus event
 * @return {void}
 */
function applyFocus(event){
    console.log('la')
    event.currentTarget.closest('.animated-card').classList.add('focused');
    return;
}

/**
 * Remove class focus
 * @param {Event} event - focus event
 * @return {void}
 */
function removeFocus(event){
    event.currentTarget.closest('.animated-card').classList.remove('focused');
    return;
}