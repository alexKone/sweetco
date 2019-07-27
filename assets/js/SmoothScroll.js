// class SmoothScroll {
//   constructor(target, duration) {
//     this._target = target;
//     this._duration = duration;
//   }
//
// }

class SmoothScroll {
  constructor(target, duration) {

    this.target = document.querySelector(target);
    this.targetPosition = target.getBoundingClientRect().top;
    this.startPosition = window.pageYOffset;
    this.distance = targetPosition - startPosition;
    this.startTime = null;
  }


  animation(currentTime) {
    if (startTime === null) startTime = currentTime;
    var timeElapsed = currentTime - startTime;
    var run = ease(timeElapsed, startPosition, distance, duration);
    window.scrollTo(0, run);
    if (timeElapsed < duration) requestAnimationFrame(animation);
  }

  ease(t, b, c, d) {
    t /= d / 2;
    if (t < 1) return c / 2 * t * t + b;
    i++;
    return -c / 2 * (t * (t - 2) - 1) + b;
  }

  requestAnimationFrame(animation);


}


function smoothScroll(target, duration) {
  var target = document.querySelector(target);
  var targetPosition = target.getBoundingClientRect().top;
  var startPosition = window.pageYOffset;
  var distance = targetPosition - startPosition;
  var startTime = null;

  function animation(currentTime) {
    if (startTime === null) startTime = currentTime;
    var timeElapsed = currentTime - startTime;
    var run = ease(timeElapsed, startPosition, distance, duration);
    window.scrollTo(0, run);
    if (timeElapsed < duration) requestAnimationFrame(animation);
  }

  function ease(t, b, c, d) {
    t /= d / 2;
    if (t < 1) return c / 2 * t * t + b;
    i++;
    return -c / 2 * (t * (t - 2) - 1) + b;
  }

  requestAnimationFrame(animation);
}

const btn1 = document.querySelector('.anchor__formules');
btn1.addEventListener('click', evt => {
  console.log(evt)
})

var formule = document.querySelector('.homepage__formules');
var panini = document.querySelector('.homepage__paninis');
var bagel = document.querySelector('.homepage__bagels');
var boisson = document.querySelector('.homepage__boissons');
var dessert = document.querySelector('.homepage__desserts');
