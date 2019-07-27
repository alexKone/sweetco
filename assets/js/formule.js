import {addClassInItem} from "./utils";

function addClass(elts, target, nbMax) {
  elts.forEach(elt => elt.addEventListener('click', evt => {
    for (let i = 0; i < elts.length; i++) {
      elts[i].classList.remove('is-active')
    }
    elt.classList.add('is-active')
    smoothScroll(target, 2000)
  }))
}

function smoothScroll(target, duration) {
  var target = document.getElementById(target);
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
    t--;
    return -c / 2 * (t * (t - 2) - 1) + b;
  }

  requestAnimationFrame(animation);
}

const baseElts = document.querySelectorAll('.base .content__items>ul>li');
const sauceElts = document.querySelectorAll('.sauce .content__items>ul>li');
const boissonElts = document.querySelectorAll('.boisson .content__items>ul>li');
const dessertElts = document.querySelectorAll('.dessert .content__items>ul>li');
const ingredientElts = document.querySelectorAll('.ingredients .content__items li');

addClass(baseElts, '.ingredients');
addClass(sauceElts, '');
addClass(boissonElts, '');
addClass(dessertElts, '');
addClass(document.querySelectorAll('#opt-base>ul>li'), '')


let nbIngredients = Number(document.querySelector('input[name="details"]').getAttribute('data-ingredients'));
let inputElts = document.querySelectorAll('.ingredients input[type="checkbox"]');
let count = 0;
let arr = [];

console.log(nbIngredients);

// ingredientElts.forEach(ingredient => ingredient.addEventListener('click', evt => {
//   console.log(evt.target)
//   ingredient.classList.contains('is-active') ? ingredient.classList.remove('is-active') : ingredient.classList.remove('is-active')
// }))
inputElts.forEach(elt => elt.addEventListener('change', evt => addClassInItem(evt, nbIngredients, inputElts)))

// inputElts.forEach(elt => elt.addEventListener('change', evt => {
//   if (evt.path[2].classList.contains('is-active')) {
//       evt.path[2].classList.remove('is-active');
//   } else {
//     evt.path[2].classList.add('is-active')
//   }
//   // console.log('evt', evt.path[2].classList.contains('is-active'));
//   arr = [];
//   for (let i = 0; i < inputElts.length; i++) {
//     inputElts[i].checked ? arr = [...arr, inputElts[i].checked] : '';
//   }
//   count = arr.length;
//   if (count === nbIngredients) {
//     console.log('le conpte y est');
//     inputElts.forEach(element => {
//       console.log(element)
//       if(!element.checked) {
//         element.setAttribute('disabled', 'disabled')
//       }
//     })
//     smoothScroll('.sauce', 1000)
//   }
//   if (count < nbIngredients) {
//     inputElts.forEach(i => {
//       if (i.getAttribute('disabled', 'disabled')) {
//         i.removeAttribute('disabled');
//       }
//     })
//   }
// }));


const resultElt = document.getElementById('result-order');
const btnBase = document.getElementById('js-base');
const btnIngredients = document.getElementById('js-ingredients');
btnBase.addEventListener('click', evt => {
  document.getElementById('base-tmpl').style.display = 'block';
  document.getElementById('ingredients-tmpl').style.display = 'none';
});
btnIngredients.addEventListener('click', evt => {
  document.getElementById('base-tmpl').style.display = 'none';
  document.getElementById('ingredients-tmpl').style.display = 'block';
});
// const base =

function quantityInput(element, options) {
  const spinner = element;

  const defaultOptions = {
    min: 1,
    max: 250,
    value: 1,
  };

  options = Object.assign({}, defaultOptions, options);

  const obj = {

    input: spinner.querySelector('input[type="number"]'),
    init() {
      this.setup();
      this.events();
      return this;
    },
    setup() {

      this.input.value = options.value;
      this.max = options.max;
      this.min = options.min;

      const qNav = document.createElement('div');
      const qUp = document.createElement('div');
      const qDown = document.createElement('div');

      qNav.setAttribute('class', 'quantity-nav');
      qUp.setAttribute('class', 'quantity-button quantity-button--up');
      qDown.setAttribute('class', 'quantity-button quantity-button--down');

      qUp.innerHTML = '+';
      qDown.innerHTML = '-';
      qNav.appendChild(qUp);
      qNav.appendChild(qDown);
      spinner.appendChild(qNav);

      this.btnUp = spinner.querySelector('.quantity-button--up');
      this.btnDown = spinner.querySelector('.quantity-button--down');
    },
    trigger() {
      const event = document.createEvent('HTMLEvents');
      event.initEvent('change', true, false);
      return event;
    },
    events() {
      this.btnUp.addEventListener('click', () => {
        const oldValue = parseFloat(this.input.value);
        let newVal;
        if (oldValue >= this.max) {
          newVal = oldValue;
        } else {
          newVal = oldValue + 1;
        }
        this.input.value = newVal;
        this.input.dispatchEvent(this.trigger());
      });

      this.btnDown.addEventListener('click', () => {
        const oldValue = parseFloat(this.input.value);
        let newVal;
        if (oldValue <= this.min) {
          newVal = oldValue;
        } else {
          newVal = oldValue - 1;
        }
        this.input.value = newVal;
        this.input.dispatchEvent(this.trigger());
      });
      this.input.addEventListener('change', () => {
        if (parseInt(this.input.value, 16) < this.min) {
          this.input.value = this.min;
        }
        if (parseInt(this.input.value, 16) > this.max) {
          this.input.value = this.max;
        }
      });
    },
  }
  return obj.init();
}

const numberInputs = document.querySelectorAll(".quantity");

if (numberInputs.length > 0) {
  numberInputs.forEach((el, index) => {
    quantityInput(el, {
      min: 1,
      max: 4,
      value: 1,
    });
  });
}
