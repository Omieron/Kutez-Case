 const apiUrl = "../php/mainPage-webapi.php"

 window.onload = function() {
     showList();  // Sayfa yüklendiğinde showList fonksiyonu çalışacak
 };

 function showList(){
     $.ajax({
         type: "GET",
         url : apiUrl,
         contentType: "application/json",
         success: function(response){
           
             console.log(response);
             for (let item of response.arr) {
                 createItem(item);
              }
         }, error: function(response) {
             console.log(response)
         }
     });
 }

 function createItem(obj){
    const sanitizedName = obj.name.replace(/\s+/g, '_');
     $("#container").append(`
         <section class="product">
                 <div class="imgBox">
                    <img id="imgSource-${sanitizedName}" src="${obj['images']['yellow']}" alt="">
                 </div>
                 <div class="title">
                     <p>${obj['name']}</p>
                 </div>
                 <div class="price">
                     <p>$101.00 USD</p>
                 </div>
                 <div class="colorsButton">
                     <nav class="colorRadioGroup">
                         <input type="radio" name="rdoBtnGrp-${sanitizedName}" class="yellow_gold" checked>
                         <input type="radio" name="rdoBtnGrp-${sanitizedName}" class="white_gold">
                         <input type="radio" name="rdoBtnGrp-${sanitizedName}" class="rose_gold">
                     </nav>
                     <div class="colorRadioGroupName">
                         <p>Yellow Gold</p>
                     </div>
                 </div>
                 <div class="rating">
                     <p>score: ${obj['popularityScore']}</p>
                 </div>
             </section>    
     `)

     $(`input[name="rdoBtnGrp-${sanitizedName}"]`).on("change", function () {
        const selectedClass = $(this).attr("class"); // Tıklanan butonun class'ını al
        const imgElement = document.querySelector(`#imgSource-${sanitizedName}`); // İlgili img elementini bul

        // Resim kaynağını class'a göre değiştir
        switch (selectedClass) {
            case "yellow_gold":
                imgElement.src = obj['images']['yellow'];
                break;
            case "white_gold":
                imgElement.src = obj['images']['white'];
                break;
            case "rose_gold":
                imgElement.src =  obj['images']['rose']
                break;
        }
    });
 }

