
let btnMesCommandes = document.getElementById('mesCommandesAccout')
let btnMesAdresses = document.getElementById('mesAdressesAcount')
let btnProfil = document.getElementById('profilAccount')

let templatProfil = document.getElementById('templatProfil')
let templatMesCommandes = document.getElementById('templatMesComandes')
let templatMesAdresses = document.getElementById('templatMesAdresse')

btnProfil.addEventListener('click', function (){
    templatMesCommandes.classList.remove('visible')
    templatMesAdresses.classList.remove('visible')
    templatProfil.classList.add('visible')
})
btnMesAdresses.addEventListener('click', function (){
    templatMesCommandes.classList.remove('visible')
    templatProfil.classList.remove('visible')
    templatMesAdresses.classList.add('visible')
})

btnMesCommandes.addEventListener('click', function (){
    console.log('kjgdfk')
    templatMesAdresses.classList.remove('visible')
    templatProfil.classList.remove('visible')
    templatMesCommandes.classList.add('visible')
})