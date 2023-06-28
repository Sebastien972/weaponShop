class Search
{
    constructor()
    {
      this.search = document.querySelector('#search') 
      this.submitSearch = document.querySelector('#submitSearch')
      this.formSearch = document.querySelector('#formSearch')
      this.paramSearch = new URLSearchParams()
      this.url = new URL(window.location)
    }

    inputSearch(){
       this.formSearch.addEventListener('submit', (event) => {

        if (this.url.origin + "/shop?" != this.url.href ) {
            console.log(this.search.value);
            this.paramSearch.append('search', this.search.value)
            document.location.href = this.url.origin + "/shop?" + this.paramSearch.toString()
            
        }else{
            console.log(this.url.href);

        }
        console.log(event.preventDefault())
      })

        
    }

}

   


window.addEventListener('load', ()=>{
    let shop = new Search()
    shop.inputSearch()
})



      

