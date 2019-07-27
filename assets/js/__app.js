/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
// require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

// import React, { Component, Fragment } from 'react';
// import ReactDOM from 'react-dom';
// import '../css/app.css';
//
// class App extends Component {
//   render() {
//     return(
//       <Fragment>
//         <header>mon header</header>
//         <footer>mon footer</footer>
//       </Fragment>
//     )
//   }
// }
//
// ReactDOM.render(
//   <App />,
//   document.getElementById('root')
// )

import '../css/app.css';


let nbIngredients = Number(document.querySelector('input[name="details"]').getAttribute('data-ingredients'));
let inputElts = document.querySelectorAll('.ingredients input[type="checkbox"]');
let ingredientElts = [];
// console.log(inputElts, nbIngredients)
/**
 inputElts.forEach(elt => elt.addEventListener('change', evt => {
  let eltsChecked = [];
  let notCheckedElts = []
  let val = 0;

  console.log(evt.target.getAttribute('value'));
  for (let i = 0; i < inputElts.length; i++) {
    eltsChecked = [...eltsChecked, inputElts[i].checked];

    // eltsChecked = [...eltsChecked,{
    //   key: inputElts[i].value,
    //   value: inputElts[i].checked
    // }];
  }



  let count = 0;
  for (let j = 0; j < eltsChecked.length; j++) {
    console.log('count =>', count, eltsChecked[j])

    if (eltsChecked[j]) {
      if (count < nbIngredients) {
        inputElts.forEach(i => {
          if (!i.checked)
            i.setAttribute('disabled', false)
        });
        count++;
      }
      // count++;
      if (count >= nbIngredients) {
        // console.log('stop')
        // get all not checked elts
        inputElts.forEach(i => {
          if (!i.checked)
            i.setAttribute('disabled', 'disabled')
            // notCheckedElts = [...notCheckedElts, i]
        })
      }
    }
    // console.log('eltschecked', eltsChecked[j])
  }


  // console.log(eltsChecked.slice(0,4).every(currentValue => currentValue === true))
  // console.log(eltsChecked)
}));
 */
function countInArray(array, what) {
  let count = 0;
  for (let i = 0; i < array.length; i++) {
    if (array[i] === what) {
      count++
    }
  }
  return count;
}
