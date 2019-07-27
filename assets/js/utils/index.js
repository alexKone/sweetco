export function addClassInItem(evt, nbIngredients, inputElts) {
  if (evt.path[2].classList.contains('is-active')) {
    evt.path[2].classList.remove('is-active');
  } else {
    evt.path[2].classList.add('is-active')
  }
  // console.log('evt', evt.path[2].classList.contains('is-active'));
  let arr = [];
  for (let i = 0; i < inputElts.length; i++) {
    inputElts[i].checked ? arr = [...arr, inputElts[i].checked] : '';
  }
  let count = arr.length;
  if (nbIngredients !== null) {
    if (count === nbIngredients) {
      console.log('le conpte y est');
      inputElts.forEach(element => {
        console.log(element)
        if(!element.checked) {
          element.setAttribute('disabled', 'disabled')
        }
      })
      smoothScroll('.sauce', 1000)
    }
    if (count < nbIngredients) {
      inputElts.forEach(i => {
        if (i.getAttribute('disabled', 'disabled')) {
          i.removeAttribute('disabled');
        }
      })
    }
  }

}
