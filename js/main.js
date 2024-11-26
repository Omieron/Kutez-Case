 const apiUrl = "../php/mainPage.php"
 let dataPrice = 0;

 window.onload = function() {
     showList();  
 };

 function showList(){
     $.ajax({
         type: "GET",
         url : apiUrl,
         contentType: "application/json",
         success: function(response){
            dataPrice = JSON.parse(response.arr['price']);
             console.log(dataPrice.price_gram_24k);
             for (let item of response.arr['obj']) {
                 createItem(item);
              }
         }, error: function(response) {
             console.log(response)
         }
     });
 }

 function createItem(obj){
    const sanitizedName = obj['name'].replace(/\s+/g, '_');
     $("#container").append(`
         <section class="product">
                 <div class="imgBox">
                    <img id="imgSource-${sanitizedName}" src="${obj['images']['yellow']}" alt="">
                 </div>
                 <div class="title">
                     <p>${obj['name']}</p>
                 </div>
                 <div class="price">
                     <p>$${calculatePrice(obj)} USD</p>
                 </div>
                 <div class="colorsButton">
                     <nav class="colorRadioGroup">
                         <input type="radio" name="rdoBtnGrp-${sanitizedName}" class="yellow_gold" checked>
                         <input type="radio" name="rdoBtnGrp-${sanitizedName}" class="white_gold">
                         <input type="radio" name="rdoBtnGrp-${sanitizedName}" class="rose_gold">
                     </nav>
                     <div class="colorRadioGroupName">
                         <p id="colorName-${sanitizedName}">Yellow Gold</p>
                     </div>
                 </div>
                 <div class="rating">
                     <p>score: ${obj['popularityScore']}</p>
                 </div>
             </section>    
     `)

     $(`input[name="rdoBtnGrp-${sanitizedName}"]`).on("change", function () {
        const selectedClass = $(this).attr("class"); 
        const imgElement = document.querySelector(`#imgSource-${sanitizedName}`); 
        const pElement = document.querySelector(`#colorName-${sanitizedName}`)

        switch (selectedClass) {
            case "yellow_gold":
                imgElement.src = obj['images']['yellow'];
                pElement.textContent = `Yellow Gold`;
                break;
            case "white_gold":
                imgElement.src = obj['images']['white'];
                pElement.textContent = `White Gold`;
                break;
            case "rose_gold":
                imgElement.src =  obj['images']['rose'];
                pElement.textContent = `Rose Gold`;
                break;
        }
    });
}

function calculatePrice(obj){
    var price = 0;
    price = (obj['popularityScore'] + 1) * obj['weight'] * dataPrice.price_gram_24k;
    return price.toFixed(2);
}

