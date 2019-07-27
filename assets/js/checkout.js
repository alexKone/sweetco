const tmpl = document.getElementById('tmpl');
const pickupTemplate = ` <div class="row">
        <div class="col-12 billing-fields">
          <h3 class="h4">Détails de facturation</h3>
          <div>
            <div>
              <label>
                <span>Prenom</span>
                <input type="text" name="first_name" />
              </label>
              <label>
                <span>Nom</span>
                <input type="text" name="last_name" />
              </label>
            </div>
            <div>
              <label>
                <span>Telephone</span>
                <input type="tel" name="tel" />
              </label>
            </div>
            <div>
              <label>
                <span>Adresse mail</span>
                <input type="email" name="email" />
              </label>
            </div>
          </div>
        </div>
        <div class="col-12 hour-delivery">
          <h3>Horaire de retrait</h3>
          <div>
            <p>
              <label>
                <input type="radio" name="hour_delivery" value="12_00" />
                <span>de 11h30 a 12h</span>
              </label>
            </p>
            <p>
              <label>
                <input type="radio" name="hour_delivery" value="12_00" />
                <span>de 12h a 12h30</span>
              </label>
            </p>
            <p>
              <label>
                <input type="radio" name="hour_delivery" value="12_30" />
                <span>de 12h30 a 13h</span>
              </label>
            </p>
            <p>
              <label>
                <input type="radio" name="hour_delivery" value="13_00" />
                <span>de 13h a 13h30</span>
              </label>
            </p>
            <p>
              <label>
                <input type="radio" name="hour_delivery" value="13_30" />
                <span>de 13h30 a 14h</span>
              </label>
            </p>
            <p>
              <label>
                <input type="radio" name="hour_delivery" value="14_00" />
                <span>de 14h a 14h30</span>
              </label>
            </p>
          </div>
        </div>
      </div>`;
const deliveryTemplate = `<div class="billing-fields">
          <h3 class="h4">Adresse de livaison</h3>
          <div>
            <div>
              <label>
                <span>Adresse</span>
                <input type="text" name="billing_address">
              </label>
            </div>
            <div>
              <label>
                <span>Ville</span>
                <input type="text" name="billing_city">
              </label>
            </div>
            <div>
              <label>
                <span>Code Postal</span>
                <input type="text" name="billing_zipcode">
              </label>
            </div>
          </div>
        </div>`;
const radioElts = document.querySelectorAll('.delivery input[type="radio"]');
radioElts.forEach(r => r.addEventListener('change', evt => {
    switch (r.getAttribute('value')) {
      case 'livraison':
        tmpl.innerHTML = deliveryTemplate;
        document.querySelector('input[value="cash"]').style.display='none';
        break;
      case 'retrait':
        tmpl.innerHTML = pickupTemplate;
        break;
      default:
        break;
    }
}));

const stripeTmpl = ``;

// STRIPE GATEWAY
// const stripe = Stripe('pk_test_TYooMQauvdEDq54NiTphI7jx');
// const elements = stripe.elements();
// const style = {
//   base: {
//     // Add your base input styles here. For example:
//     fontSize: '16px',
//     color: "#32325d",
//   },
// };
//
// // Create an instance of the card Element.
// const card = elements.create('card', {style});
//
// // Add an instance of the card Element into the `card-element` <div>.
// card.mount('#card-element');
// card.addEventListener('change', ({error}) => {
//   const displayError = document.getElementById('card-errors');
//   if (error) {
//     displayError.textContent = error.message;
//   } else {
//     displayError.textContent = '';
//   }
// });
// const form = document.getElementById('payment-form');
// form.addEventListener('submit', async (event) => {
//   event.preventDefault();
//
//   const {token, error} = await stripe.createToken(card);
//
//   if (error) {
//     // Inform the customer that there was an error.
//     const errorElement = document.getElementById('card-errors');
//     errorElement.textContent = error.message;
//   } else {
//     // Send the token to your server.
//     stripeTokenHandler(token);
//   }
// });
// const stripeTokenHandler = (token) => {
//   // Insert the token ID into the form so it gets submitted to the server
//   const form = document.getElementById('payment-form');
//   const hiddenInput = document.createElement('input');
//   hiddenInput.setAttribute('type', 'hidden');
//   hiddenInput.setAttribute('name', 'stripeToken');
//   hiddenInput.setAttribute('value', token.id);
//   form.appendChild(hiddenInput);
//
//   // Submit the form
//   form.submit();
// }
