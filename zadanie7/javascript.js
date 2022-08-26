mapboxgl.accessToken = '';

navigator.geolocation.getCurrentPosition(successLocation, errorLocation, {enableHighAccuracy: true})

function successLocation(position){
    setupMap([position.coords.longitude, position.coords.latitude])
}

function errorLocation(){
    setupMap([17.107748, 48.148598])
}

function setupMap(center){
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: center,
        zoom: 12
    });
    map.addControl(new mapboxgl.NavigationControl());

    const geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl
    });

    map.addControl(geocoder);
    map.on('load', () => {
        // Listen for the `geocoder.input` event that is triggered when a user
        // makes a selection
        geocoder.on('result', (event) => {

            const obec = event.result.text
            pocasie(event.result.center,obec)
            console.log('---------vysledok hladania-----------')
            console.log(event.result)
            const table = document.querySelector('#result-table')
            const thead = table.tHead
            thead.innerHTML = ''
            const tbody = table.tBodies[0]
            tbody.innerHTML = ''
            const trhead = document.createElement('tr')
            const th1 = document.createElement('th')
            const th2 = document.createElement('th')
            const th3 = document.createElement('th')
            th1.append('GPS')
            th2.append('Štát')
            th3.append('Hlavné mesto')
            trhead.append(th1)
            trhead.append(th2)
            trhead.append(th3)
            thead.append(trhead)

            const tr = document.createElement('tr')
            const td1 = document.createElement('td')
            const lat =event.result.center[1]
            const lon = event.result.center[0]
            td1.append(lat + '/' + lon)
            const td2 = document.createElement('td')
            let kodKrajiny;
            let krajina;
            event.result.context.forEach(element => {
                if (element.id.includes('country')){
                    kodKrajiny = element.short_code
                    krajina = element.text
                    td2.append(krajina)
                }
            })

            const td3 = document.createElement('td')

            fetch('https://api.worldbank.org/v2/country/'+ kodKrajiny +'?format=json',
                {method: 'get'}
            )
                .then(response => response.json())
                .then(result=>{
                    console.log('mesto')
                    console.log(result)
                    const hlavneMesto = result[1][0].capitalCity
                    td3.append(hlavneMesto)
                    const datum = new Date()
                    const url = 'addEntry.php'
                    const data = {
                        location:obec,
                        country:krajina,
                        countryCode:kodKrajiny,
                        capital:hlavneMesto,
                        lat:lat,
                        lon:lon,
                        localTime: datum.getFullYear()+'-'+pridajNulu(datum.getMonth()+1)+'-'+pridajNulu(datum.getDate())+' '+pridajNulu(datum.getHours())+':'+pridajNulu(datum.getMinutes())+':'+pridajNulu(datum.getSeconds())
                    }

                    fetch(url,{
                        method:'POST',
                        body: JSON.stringify(data),
                        headers:{
                            'Content-Type':'application/text'
                        },
                    })
                        .then(response => {
                            console.log(response)
                        })
                })
            tr.append(td1)
            tr.append(td2)
            tr.append(td3)
            tbody.append(tr)
            // console.log(JSON.stringify(event.result, null, 2))
        });
    });
    geoMarkery(map)
    navstevy()
    scitanieNastev()
}

function pocasie(center, obec){
    console.log('----------pocasie----------')
    console.log(center)
    fetch('https://api.weatherapi.com/v1/forecast.json?key=8b962c418e444637b76215945222504&q=' + center[1]+','+center[0] + '&days=1&aqi=no&alerts=no&lang=sk',
        {method: 'get'}
    )
        .then(response => response.json())
        .then(result=>  {
            obj = result
            document.getElementById("pocasie").style.display = 'block'
            let nazovObce = document.getElementById("nazov-obce")
            let cas = document.getElementById("lokalny-cas")
            let obrazokPocasia = document.getElementById("obrazok-pocasia")
            let pocasie = document.getElementById("pocasie-info")
            let c = document.getElementById("stupen-c")
            let vlhk = document.getElementById("vlhkost")
            let rych = document.getElementById("rychlost-vetru")
            nazovObce.innerText = obec
            cas.innerText = 'Čas: ' + result.location.localtime.replace(/\d{4}[-]\d{2}[-]\d{2}\s/, "")
            obrazokPocasia.src = result.current.condition.icon
            pocasie.innerText = result.current.condition.text
            c.innerText = result.current.temp_c + 'ºC/'+ result.current.temp_f  +'ºF'
            vlhk.innerText = result.current.humidity
            rych.innerText = result.current.wind_kph
            console.log(result)
        })
}
function pridajNulu(n) {
    return (n < 10 ? '0' : '') + n;
}

function navstevy(){
    console.log("nastevy")
    fetch('getTodayVisitorsCountries.php',
        {method: 'get'}
    )
        .then(response => response.json())
        .then(result=>{
            console.log(result)
            const table = document.querySelector('#visitor-table')
            const tbody = table.tBodies[0]
            tbody.innerHTML = ''

            result.forEach(element => {
                const tr = document.createElement('tr')
                // console.log(element)
                fetch('getTodayVIsitorsFromCountry.php?krajina='+element.country,
                    {method: 'get'}
                )
                    .then(response => response.json())
                    .then(result=>{
                        // console.log(result)

                        const td1 = document.createElement('td')
                        td1.append(element.country)
                        const td2 = document.createElement('td')
                        td2.append(result)
                        const td3 = document.createElement('td')
                        let img = document.createElement('img')
                        img.src='https://countryflagsapi.com/svg/'+element.country_code
                        img.style.maxWidth='100px'
                        img.style.maxHeight='75px'
                        img.style.cursor='pointer'
                        img.addEventListener('click',function (){
                            pocetNastevZLokacie(element.country)
                        })
                        td3.append(img)


                        tr.append(td1)
                        tr.append(td2)
                        tr.append(td3)
                        tbody.append(tr)
                    })
            })
        })
}
function pocetNastevZLokacie(krajina){
    const table = document.querySelector('#visitor-location-table')
    table.style.display='block'
    const tbody = table.tBodies[0]
    tbody.innerHTML = ''
    fetch('getTodayVisitorPlaces.php?krajina='+krajina,
        {method: 'get'}
    )
        .then(response => response.json())
        .then(result=>{
            console.log(result)
            result.forEach(element =>{
                const tr = document.createElement('tr')
                const td1 = document.createElement('td')
                td1.append(krajina)
                const td2 = document.createElement('td')
                td2.append(element.location)
                tr.append(td1)
                tr.append(td2)
                tbody.append(tr)
            })

        })
}

function scitanieNastev(){
    const table = document.querySelector('#visitor-time-table')
    const tbody = table.tBodies[0]
    tbody.innerHTML = ''
    const casy = [
        {min:6, max:15},{min:15, max:21},{min:21, max:24},{min:0, max:6}
    ]
    casy.forEach(element => {

        fetch('getVisitorsCount.php?maxHodina='+element.max+'&minHodina='+element.min,
            {method: 'get'}
        )
            .then(response => response.json())
            .then(result=>{
                const tr = document.createElement('tr')
                const td1 = document.createElement('td')
                const max = element.max === 24? 0 : element.max
                td1.append(element.min+':00-'+max+':00')
                const td2 = document.createElement('td')
                td2.append(result)
                tr.append(td1)
                tr.append(td2)
                tbody.append(tr)
            })
    })
}

function geoMarkery(map){
    fetch('placesVisited.php',
        {method: 'get'}
    )
        .then(response => response.json())
        .then(result=>{
            console.log(result)
            result.forEach(element => {
                console.log(element)
                let markerDiv = document.createElement('div')
                markerDiv.className = 'marker'
                new mapboxgl.Marker(markerDiv)
                    .setLngLat([element.lon, element.lat])
                    .addTo(map)

            })
        })
}


