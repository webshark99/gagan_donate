<!DOCTYPE html>
<html>
   <head>
      <title>UnlockingSolution - Donate Us !</title>
   </head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <style> 
      input {
      width: 100%;
      padding: 12px 20px;
      margin: 8px;
      box-sizing: border-box;
      border: 2px solid blue;
      border-radius: 4px;
      }
   </style>
   <body>
      <div class="w3-container" style="padding-left: 10%; padding-right: 10%; padding-top: 2%; padding-bottom: 2%;">
         <center>
            <div id="smart-button-container">
              <div style="text-align: center; padding-bottom: 30px;"><h1>Unlocking Solution</h1><p>Donate Us</p></div>
               <div style="text-align: center"><label for="description"><b>YOUR NAME </b></label><input type="text" name="descriptionInput" id="description" maxlength="127" value=""></div>
               <p id="descriptionError" style="visibility: hidden; color:red; text-align: center;">ENTER YOUR NAME</p>
               <div style="text-align: center"><label for="amount"><b>DONATE AMOUNT </b></label><input name="amountInput" type="number" id="amount" value="" ><span> USD</span></div>
               <p id="priceLabelError" style="visibility: hidden; color:red; text-align: center;">ENTER DONATE AMOUNT (USD)</p>
               </td>
               <div id="invoiceidDiv" style="text-align: center; display: none;"><label for="invoiceid"> </label><input name="invoiceid" maxlength="127" type="text" id="invoiceid" value="" ></div>
               <p id="invoiceidError" style="visibility: hidden; color:red; text-align: center;">PLEASE ENTER DONATE AMOUNT</p>
               <div style="text-align: center; margin-top: 0.625rem;" id="paypal-button-container"></div>
            </div>
         </center>
      </div>
      <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=USD" data-sdk-integration-source="button-factory"></script>
      <script>
         function initPayPalButton() {
           var description = document.querySelector('#smart-button-container #description');
           var amount = document.querySelector('#smart-button-container #amount');
           var descriptionError = document.querySelector('#smart-button-container #descriptionError');
           var priceError = document.querySelector('#smart-button-container #priceLabelError');
           var invoiceid = document.querySelector('#smart-button-container #invoiceid');
           var invoiceidError = document.querySelector('#smart-button-container #invoiceidError');
           var invoiceidDiv = document.querySelector('#smart-button-container #invoiceidDiv');
         
           var elArr = [description, amount];
         
           if (invoiceidDiv.firstChild.innerHTML.length > 1) {
             invoiceidDiv.style.display = "block";
           }
         
           var purchase_units = [];
           purchase_units[0] = {};
           purchase_units[0].amount = {};
         
           function validate(event) {
             return event.value.length > 0;
           }
         
           paypal.Buttons({
             style: {
               color: 'blue',
               shape: 'pill',
               label: 'paypal',
               layout: 'vertical',
               
             },
         
             onInit: function (data, actions) {
               actions.disable();
         
               if(invoiceidDiv.style.display === "block") {
                 elArr.push(invoiceid);
               }
         
               elArr.forEach(function (item) {
                 item.addEventListener('keyup', function (event) {
                   var result = elArr.every(validate);
                   if (result) {
                     actions.enable();
                   } else {
                     actions.disable();
                   }
                 });
               });
             },
         
             onClick: function () {
               if (description.value.length < 1) {
                 descriptionError.style.visibility = "visible";
               } else {
                 descriptionError.style.visibility = "hidden";
               }
         
               if (amount.value.length < 1) {
                 priceError.style.visibility = "visible";
               } else {
                 priceError.style.visibility = "hidden";
               }
         
               if (invoiceid.value.length < 1 && invoiceidDiv.style.display === "block") {
                 invoiceidError.style.visibility = "visible";
               } else {
                 invoiceidError.style.visibility = "hidden";
               }
         
               purchase_units[0].description = description.value;
               purchase_units[0].amount.value = amount.value;
         
               if(invoiceid.value !== '') {
                 purchase_units[0].invoice_id = invoiceid.value;
               }
             },
         
             createOrder: function (data, actions) {
               return actions.order.create({
                 purchase_units: purchase_units,
               });
             },
         
             onApprove: function (data, actions) {
               return actions.order.capture().then(function (details) {
                 alert('Transaction completed by ' + details.payer.name.given_name + '!');
               });
             },
         
             onError: function (err) {
               console.log(err);
             }
           }).render('#paypal-button-container');
         }
         initPayPalButton();
      </script>
   </body>
</html>
