const WebSocket = require('ws')
const https = require('https')
const fs = require('fs')

const server = https.createServer({
 cert: fs.readFileSync('/var/www/site101.webte.fei.stuba.sk/zadaniadsf/zadanie6/webte.fei.stuba.sk-chain-cert.pem'),
 key: fs.readFileSync('/var/www/site101.webte.fei.stuba.sk/zadaniadsf/zadanie6/webte.fei.stuba.sk.key')
})

server.listen(9000)

const ws = new WebSocket.Server({server})

class Player {

    constructor(x,y,meno) {
        this.x = x;
        this.y = y;
        this.meno = meno

    }
}

const messages = []
const players = [];
const policka = [];
ws.on('connection', (socket) => {

    messages.forEach(message => {
        socket.send(JSON.stringify(message))
    })
    console.log('new connection')
    socket.on('message', (data) => {

        const msg = JSON.parse(data.toString())
        if(players.length < 2){
            if(msg.x === 0 && msg.y === 0){
                if (players.length === 0){
                    console.log('vytvoreny hrac 1')
                    players.push(new Player(9,10, msg.nazovHraca))
                    msg.pripraveny=true
                    msg.x = 9
                    msg.y = 10
                    players.forEach(p =>{
                        if(p.meno === msg.nazovHraca){
                            policka.push([9,10])
                        }
                    })
                }

                else{
                    console.log('vytvoreny hrac 2')
                    players.push(new Player(12,10, msg.nazovHraca))
                    msg.pripraveny=true
                    msg.x = 12
                    msg.y = 10
                    players.forEach(p =>{
                        if(p.meno === msg.nazovHraca){
                            policka.push([12,10])
                        }
                    })
                }

            }
        }else{
            players.forEach(p =>{
                if(p.meno === msg.nazovHraca){
                    let mozemVlozit = true
                    policka.forEach(policko => {
                        if(policko[0]===msg.x && policko[1]===msg.y)
                            mozemVlozit = false
                    })
                    policka.push([msg.x,msg.y])
                    if (!mozemVlozit){
                        msg.koniec = true
                    }

                }
            })
            if (msg.y < 0 || msg.x <0 || msg.y > 29 || msg.x > 19){
                msg.koniec = true
            }

        }
        console.log(msg)
        messages.push(msg)
        ws.clients.forEach(client => {
            client.send(JSON.stringify(msg))
        })

    })

})
