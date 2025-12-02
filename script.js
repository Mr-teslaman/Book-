document.addEventListener('DOMContentLoaded', function() {
    const payButton = document.getElementById('payButton');
    
    payButton.addEventListener('click', payWithPaystack);
    
    function payWithPaystack() {
      const ref = 'TICKET_' + Date.now();
      
      const handler = PaystackPop.setup({
        key: 'pk_live_bf738c9dbf541b14d3437e0fe2f2b03130656cb4', 
        email: 'customer@example.com', 
        amount: 10000, 
        currency: 'KES',
        ref: ref,
        label: "Event Ticket Payment",
        callback: function(response) {
          alert(`Payment successful! Reference: ${response.reference}`);
        },
      });
      
      handler.openIframe();
    }
  });