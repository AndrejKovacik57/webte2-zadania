const  socket = new WebSocket('wss://site101.webte.fei.stuba.sk:9000')
const canvas = document.getElementById('mojCanvas')
const ctx = canvas.getContext('2d')
const vytvorHracaButton = document.getElementById('vytvor')

const setFilled = (x,y,farba) =>{
    ctx.fillStyle = farba
    ctx.fillRect(x*20, y*20, 20 ,20)
}


for (let i = 0; i < canvas.height; i+=20){
    ctx.moveTo(0, i)
    ctx.lineTo(canvas.width, i)
}
for (let i = 0; i < canvas.width; i+=20){
    ctx.moveTo(i, 0)
    ctx.lineTo(i, canvas.height)
}
ctx.stroke()

vytvorHracaButton.addEventListener('click',click => {
    let nazovHracaPole = document.getElementById('nazov')
    vytvorHracaButton.disabled = true
    let nazovHraca = nazovHracaPole.value
    let nazovHraca2 = ''
    nazovHracaPole.disabled = true
    let hrac1Pripraveny = false
    let hrac2Pripraveny = false
    let koniec = false
    socket.send(JSON.stringify({'nazovHraca':nazovHraca, 'x':0,'y':0,'pripraveny':hrac1Pripraveny,'koniec':koniec}))
    let posX=0;
    let posY=0;
    let pos2X=0;
    let pos2Y=0;
    setFilled(9,10,'red')
    setFilled(12,10,'green')
    let direction = 'KeyS'
    document.body.addEventListener('keypress', key => {
        if (key.code === 'KeyW' || key.code === 'KeyS' || key.code === 'KeyA' || key.code === 'KeyD'){
            direction = key.code

        }

    })

    socket.addEventListener('message', msg => {
        const pos = JSON.parse(msg.data)

        if (pos.nazovHraca === nazovHraca){
            if(!pos.koniec){
                posX = pos.x
                posY = pos.y
                hrac1Pripraveny = pos.pripraveny
                console.log(pos.nazovHraca,' ',hrac2Pripraveny)
                setFilled(posX,posY,'green')
            }else{
                koniec = pos.koniec
                document.getElementById('vytaz').innerHTML += '<h1>' + 'Hrac ' + nazovHraca2 + ' vyhral!' + '</h1>'
            }


        }else{
            if(!pos.koniec){
                nazovHraca2 = pos.nazovHraca
                pos2X = pos.x
                pos2Y = pos.y
                hrac2Pripraveny = pos.pripraveny
                console.log(pos.nazovHraca,' ',hrac2Pripraveny)

                setFilled(pos2X,pos2Y,'red')
            }else{
                koniec = pos.koniec
                document.getElementById('vytaz').innerHTML += '<h1>' + 'Hrac ' + nazovHraca + ' vyhral!' + '</h1>'
            }
        }



    })

    setInterval(() =>{
        if(hrac1Pripraveny && hrac2Pripraveny && !koniec){
            if(direction === 'KeyS'){
                posY += 1
            }
            if(direction === 'KeyW'){
                posY -= 1
            }
            if(direction === 'KeyD'){
                posX += 1
            }
            if(direction === 'KeyA'){
                posX -= 1
            }

            socket.send(JSON.stringify({'nazovHraca':nazovHraca, 'x':posX,'y':posY,'pripraveny':hrac1Pripraveny}))


        }

    },300)
})




