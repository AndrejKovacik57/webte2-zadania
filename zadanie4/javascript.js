let buttons = document.querySelectorAll('button');
let menu = document.querySelector('#obedove-menu')
let nadpisMenuDen = document.querySelector('#menu-day')
function vytvorMenu(denIndex) {
    menu.innerHTML = ''
    for (let i = 1; i <= 3; i++) {
        fetch("./storage/restaurant" + i + ".json")
            .then(response => response.json())
            .then(jsonData => {
                const restauracia = jsonData['restaurant']
                const dayData = jsonData['data'][denIndex]
                const den = dayData['day']
                const menuList = dayData['menu']
                nadpisMenuDen.innerHTML = "Obedy-" + den
                let liRestauracia = document.createElement('li')
                liRestauracia.className = "mt-3"
                let menuRestauracie = document.createElement('ul')
                if(menuList.length > 0){
                    menuList.forEach(jedlo => {
                        let li= document.createElement('li')
                        li.className= "list-unstyled  text-start border-top border-2 rounded-end rounded-start border-primary text-secondary"
                        li.style.fontWeight="bold"
                        li.append(jedlo)
                        menuRestauracie.append(li)
                    })
                }else{
                    let li= document.createElement('li')
                    li.className= "list-unstyled text-start border-top border-2 rounded-end rounded-start border-primary text-secondary"
                    li.style.fontWeight="bold"
                    li.append("Ziadna ponuka")
                    menuRestauracie.append(li)
                }



                let nazovRestauracie = document.createElement('h4')
                nazovRestauracie.className= "text-start fst-italic text-primary"
                nazovRestauracie.style.fontWeight="bold"
                nazovRestauracie.append(restauracia)
                liRestauracia.append(nazovRestauracie)
                liRestauracia.append(menuRestauracie)
                menu.append(liRestauracia)
            })
    }

}

vytvorMenu(0)
buttons.forEach(button => {
    button.addEventListener("click", ()=>{
        const dayIndex = button.value
        vytvorMenu(dayIndex)

    });//button event listener koniec

});//button for each koniec