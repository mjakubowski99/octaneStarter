import {loadStripe} from '@stripe/stripe-js';


function makeStripe(publishableKey, paymentIntentId, connectedAccountId)
{
    const stripe = loadStripe(publishableKey);


}

function initStripe()
{
    const paymentIntent = axios.post('/api/stripe/paymentIntent', {
        product_id: "6f99510a-5f87-4d13-b98a-5c74ac6d76a7",
        payment_methods: ['card']
    }, {
        Accept: "application/json",
        "Content-type": "application/json"
    }).then(function (response) {
        makeStripe(response.data.publishableKey, response.data.paymentIntentId, response.data.connectedAccountId);
    })
}

window.addEventListener('DOMContentLoaded', () => {
    initStripe();
});
