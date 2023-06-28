class Shop{
    constructor(){
        this.cart = new Cart
        this.sortBy = document.querySelector('.sortBy')
        this.url = new URL(window.location.href)   
        this.paramSearch = new URLSearchParams()
        this.search = document.querySelector('#search') 
        this.itemsCategorie = document.querySelectorAll('.categorieItems')
        this.itemsCategorieAll = document.querySelector('#categorieItemsAll')
        this.sliderPrice =  document.querySelectorAll('input[type="range"]')
        this.rangeInput = document.querySelectorAll(".range-input input")
        this.priceInput = document.querySelectorAll(".price-input p")
        this.range = document.querySelector(".slider .progress")
        this.subCat = document.querySelectorAll(".subCat")
        this.caliberData
        this.buttonData
    }
    
    inputSearch(){
        this.search.addEventListener('input', () => {
  
            let mots = search.value
            if (this.url.origin + "/shop?" != this.url.href ) {
                console.log(this.url.href);
                
                document.location.href= this.url.origin + "/shop?" + this.paramSearch.toString()
            }
  
            if (this.paramSearch.get('search') != null) {
                this.paramSearch.delete('search')
                this.paramSearch.append('search', mots)
    
    
            }else{
                this.paramSearch.append('search', mots)
    
            }
            
            
            
    
    
    
    
            fetch(this.url.origin + "/shop?" + this.paramSearch.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-with": "XMLHttpRequest"
                }
            }).then(response =>
                response.json()
    
            ).then(
                data => {
                    //zonne de contenu
                    const product = document.getElementById('shop')
                    this.cart.addMore()
                    //remplace le contenue
                    product.innerHTML = data.content
                    this.sortBy = document.querySelector('.sortBy')
                    this.sort()
                    //metre a jour l'url
                 history.pushState({}, null,this.url.origin + "/shop?" + this.paramSearch.toString() )

                }
            ).catch(e => alert(e))
    

    
        })

        
    }
    
    sort(){
        this.sortBy = document.querySelector('.sortBy')

        this.sortBy.addEventListener('change',()=>{
            
            let sortData = this.sortBy.value
            

        if (this.paramSearch.get('sort') != null) {
            this.paramSearch.delete('sort')

            this.paramSearch.append('sort', sortData)

        }else{
            this.paramSearch.delete('sort')

            this.paramSearch.append('sort', sortData)

        }

        this.request( this.paramSearch)

        }) 
    }
    categorie(){
        this.itemsCategorieAll.addEventListener('click', ()=>{
            
            this.paramSearch.delete('categorie')
            this.paramSearch.delete('caliber')
            this.request( this.paramSearch)

        })
        this.itemsCategorie.forEach(button =>{
            
            button.addEventListener('click', ()=>{

                this.buttonData = button.value

                
                if (this.paramSearch.get('categorie') != this.buttonData && this.paramSearch.delete('caliber') === this.caliberData) {
                            this.paramSearch.delete('caliber')
                
                           
                        }
        
                      
                
                   
                if (this.paramSearch.get('categorie') != null && this.buttonData != 'all') {
                    this.paramSearch.delete('categorie')
                    
                    this.paramSearch.append('categorie', this.buttonData)
        
                }else{
                    this.paramSearch.append('categorie', this.buttonData)

        
                }
               

                this.request( this.paramSearch)
               
        
              
            })
        })
    }

    request(param)
    {
        fetch(this.url.origin + "/shop?" + param.toString() + "&ajax=1", {
            headers: {
                "X-Requested-with": "XMLHttpRequest"
            }        
        }).then(response =>
            response.json()

        ).then(
            data => {
                  //zonne de contenu
        let product = document.getElementById('shop')
        // console.log(product);
        //remplace le contenue
         product.innerHTML = data.content
        this.sortBy = document.querySelector('.sortBy')
        this.sort()

        this.cart.add()
        
         //metre a jour l'url
      history.pushState({}, null,this.url.origin + "/shop?" + this.paramSearch.toString() )
               

            }
        ).catch(e => alert(e))
    }

    subCategorie(){
        this.subCat.forEach( calibre=>{
            calibre.addEventListener('click',()=>{
                this.caliberData = calibre.value
                if (this.paramSearch.get('categorie') != this.buttonData) {
                    this.paramSearch.append('caliber', this.caliberData)

        
                   
                }
                if (this.paramSearch.get('caliber') != null) {
                    this.paramSearch.delete('caliber')
        
                    this.paramSearch.append('caliber', this.caliberData)
        
                }else{
                    this.paramSearch.append('caliber', this.caliberData)
        
                }

                this.request( this.paramSearch)


            })
        })
    }
    filterPrice(maxPrice, minPrice)
    {
        if (this.paramSearch.get('maxPrice') != null || this.paramSearch.get('minPrice') != null ) {
            this.paramSearch.delete('maxPrice')
            this.paramSearch.delete('minPrice')

            this.paramSearch.append('maxPrice', (maxPrice))
            this.paramSearch.append('minPrice', minPrice)

        }else{
            this.paramSearch.append('minPrice', maxPrice)
            this.paramSearch.append('minPrice', minPrice)


        }

        this.request( this.paramSearch)


    }
    
    makeInput(){
        let priceGap = 100;
        this.rangeInput.forEach(input =>{
            input.addEventListener("input", e =>{
                let minVal = parseInt(this.rangeInput[0].value)
                let maxVal = parseInt(this.rangeInput[1].value)
                 
                this.filterPrice(maxVal * 100, minVal * 100)
                
                var int3 = new Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR", currencyDisplay: "symbol"});


                if((maxVal - minVal) < priceGap){
                    
                    if(e.target.className === "range-min"){
                        this.rangeInput[0].value = maxVal - priceGap
                    }else{
                        this.rangeInput[1].value = minVal + priceGap;
                    }
                }else{
                    this.priceInput[0].innerHTML = int3.format(minVal);
                    this.priceInput[1].innerHTML = int3.format(maxVal);
                    this.range.style.left = ((minVal  / this.rangeInput[0].max) * 100) + "%";
                    this.range.style.right = 100 - (maxVal  / this.rangeInput[1].max) * 100 + "%";
                }
            })
        })

    }

}


window.addEventListener('load', ()=>{
    let shop = new Shop()
    
    shop.inputSearch()
    shop.categorie()
    shop.makeInput()
    shop. subCategorie()
    shop.sort()



})