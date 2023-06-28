class Cart
{
    constructor(){
        this.url = new URL(window.location.href)
        this.btnAdd 
        this.containerCart = document.getElementById('containerCart')
        this.btnRemove = document.querySelectorAll('.removeItem')
        this.btnAddMore = document.querySelectorAll('.addMore')
        this.btnRemoveOne = document.querySelectorAll('.remove')
        this.CartOne = document.querySelector('#cartOne')
        this.quantityCartOne = document.querySelector('#quantityCartOne')
        this.cart = document.querySelector('#cartPage')
        this.deletPanier = document.querySelector('#deletPanier')


    }

    delet(){
        if (this.deletPanier != null) {
            this.deletPanier.addEventListener('click', ()=>{
                console.log(this.deletPanier);
                    const path = '/deletcart/'
                    const id = ''
                    this.request(id, path)

            })
        }
    }

    removeOne(){

        if ( this.btnRemoveOne != null) {
            
            for (let i = 0; i < this.btnRemoveOne.length; i++) {
                let element = this.btnRemoveOne[i];
                
                element.addEventListener('click', ()=>{

                    let id = element.value
                    let path = '/remove/'
                    this.request(id, path)
                
                
                })
            }

        }
    }


    addMore(){
        if ( this.btnAddMore != null) {
            
            for (let i = 0; i < this.btnAddMore.length; i++) {
                let element = this.btnAddMore[i];
                let path = '/add/'
                let id = element.value

              element.addEventListener('click', ()=>{
                this.request(id, path)
              })

            }


        }


    }


    remove(){

        if ( this.btnRemove != null) {
            
            for (let i = 0; i < this.btnRemove.length; i++) {
                let element = this.btnRemove[i];
                
                element.addEventListener('click', ()=>{

                    let id = element.value
                    let path = '/removeItem/'
                    this.request(id, path)
                
                
                })
            }

        }
    }



    add(){
        this.btnAdd = document.querySelectorAll('.btnAdd')
        if ( this.btnAdd != null) {
                
                for (let i = 0; i < this.btnAdd.length; i++) {
                    let element = this.btnAdd[i];
                    
                    
                
                    element.addEventListener('click', ()=>{
                        let id = element.value
                        let path = '/add/'
                    
                        this.request(id, path)


                    })


                }   

        }
    }


        btn(){
            
            let overlay = document.querySelector('div.cart-bg-overlay')
            let cart = document.querySelector('div.right-side-cart-area')
            cart.classList.add('cart-on')
            overlay.classList.add('cart-bg-overlay-on')
            let btnCart = document.getElementById('essenceCartBtn')
            let btnCart2 = document.querySelector('#rightSideCart')
            btnCart.addEventListener('click', ()=>{
                if (cart.classList === 'cart-on') {
                    cart.classList.remove('cart-on')
                    overlay.classList.remove('cart-bg-overlay-on')
                } else {
                    cart.classList.add('cart-on')
                    overlay.classList.add('cart-bg-overlay-on')
                }
            })
            btnCart2.addEventListener('click', ()=>{
            
                    cart.classList.remove('cart-on')
                    overlay.classList.remove('cart-bg-overlay-on')
                
            })
            overlay.addEventListener('click',()=>{
                cart.classList.remove('cart-on')
                overlay.classList.remove('cart-bg-overlay-on')

            })
            this.btnRemove = document.querySelectorAll('.removeItem')
            let quantityCart = document.querySelector('#quantityCart')
           this.quantityCartOne.innerHTML = quantityCart.innerHTML

    }







    request( id, path)
    {
        fetch(this.url.origin + path +id,  {
            headers: {
                "X-Requested-with": "XMLHttpRequest"
            }
        }).then(
            response => response.json()
        ).then(
            data => {
                
                
                
                // console.log('uytryuio' + this.cart);
                if (this.cart != null) {
                    this.cart.innerHTML = data.cart
                    this.containerCart.style.visibility = 'hidden'
                }
            
                this.containerCart.innerHTML = data.content
                
                this.btnRemoveOne = document.querySelectorAll('.remove')
                this.btnRemove = document.querySelectorAll('.removeItem')
                this.btnAddMore = document.querySelectorAll('.addMore')
                this.btn()
                this.remove()
                this.removeOne()
                this.addMore()
                console.log('rrrrrrrrr');
             
                
            
            }
    
        ).catch(e => console.log(e))

    }
  


}



window.addEventListener('load', ()=>{
    let cart = new Cart()
    cart.add()
    cart.addMore()
    cart.remove()
    cart.removeOne()
    cart.delet()
})