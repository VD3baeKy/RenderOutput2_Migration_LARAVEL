const stripe = Stripe('pk_test_51QbmklFY800zzpxKpAd6wUyX3T7gnnJtgy2c4s8LCt7W5Hl7aMuddjbtUMb5eyFx700M4jHxJGTsSNrOwsEsqu8u008saOkxMd');
const paymentButton = document.querySelector('#paymentButton');

paymentButton.addEventListener('click', function() {
  // HTMLのdata属性からセッションIDを取得
  const sessionId = paymentButton.getAttribute('data-session-id');
  stripe.redirectToCheckout({
    sessionId: sessionId
  });
});
