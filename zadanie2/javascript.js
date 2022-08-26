const form = document.querySelector('#search-form')
const button = document.querySelector('#search-button')
const popis = document.querySelector('#popis');
const table = document.querySelector('#result-table')
let wordarray = []
const input = document.querySelector('#search')
const lang = document.querySelector('#language')
input.addEventListener('input',() => {
    wordarray = []
    console.log(lang.value)
    if(popis.checked){
        fetch('translate.php?search=' + input.value + '&popis='+ popis.checked + '&language_code='+ lang.value,
            {method: 'get'}
        )
            .then(response => response.json())
            .then(result=>{
                result.forEach(item => {
                    wordarray.push(item.searchTitle)
                    wordarray.push(item.searchDescription)
                })
                $( function() {
                    $("#search").autocomplete({
                        source: wordarray,
                        minLength: 3
                    });
                } );
            })
    }else{
        fetch('translate.php?search=' + input.value + '&language_code='+ lang.value,
            {method: 'get'}
        )
            .then(response => response.json())
            .then(result=>{
                result.forEach(item => {
                    wordarray.push(item.searchTitle)
                })

                $( function() {
                    $("#search").autocomplete({
                        source: wordarray,
                        minLength: 3
                    });
                } );

            })
    }

    console.log(wordarray)

})

const thead = table.tHead
const tbody = table.tBodies[0]
button.addEventListener('click', () => {
    tbody.innerHTML = ''
    thead.innerHTML = ''
    const data = new FormData(form)

    fetch('translate.php?search=' + data.get('search')+ '&popis='+ data.get('popis') + '&language_code='+ data.get('language_code'),
        {method: 'get'}
    )
        .then(response => response.json())
        .then(result=>{
            console.log(result)
            console.log(popis.checked)
            if (popis.checked){
                const trhead = document.createElement('tr')
                const th1 = document.createElement('th')
                const th2 = document.createElement('th')
                const th3 = document.createElement('th')
                const th4 = document.createElement('th')
                if (lang.value === 'sk'){
                    th1.append('Sk')
                    th2.append('Slovenský popis')
                    th3.append('En')
                    th4.append('English description')
                }else{
                    th1.append('En')
                    th2.append('English description')
                    th3.append('Sk')
                    th4.append('Slovenský popis')
                }

                trhead.append(th1)
                trhead.append(th2)
                trhead.append(th3)
                trhead.append(th4)
                thead.append(trhead)

                result.forEach(item => {
                    const tr = document.createElement('tr')
                    const td1 = document.createElement('td')
                    td1.append(item.searchTitle)
                    const td2 = document.createElement('td')
                    td2.append(item.searchDescription)
                    const td3 = document.createElement('td')
                    td3.append(item.translatedTitle)
                    const td4 = document.createElement('td')
                    td4.append(item.translatedDescription)

                    tr.append(td1)
                    tr.append(td2)
                    tr.append(td3)
                    tr.append(td4)
                    tbody.append(tr)
                })

            }else{
                const trhead = document.createElement('tr')
                const th1 = document.createElement('th')
                const th2 = document.createElement('th')
                if (lang.value === 'sk'){
                    th1.append('Sk')
                    th2.append('En')
                }else{
                    th1.append('En')
                    th2.append('Sk')
                }
                trhead.append(th1)
                trhead.append(th2)
                thead.append(trhead)

                result.forEach(item => {

                    const tr = document.createElement('tr')
                    const td1 = document.createElement('td')
                    td1.append(item.searchTitle)
                    const td2 = document.createElement('td')
                    td2.append(item.translatedTitle)
                    const td3 = document.createElement('td')


                    tr.append(td1)
                    tr.append(td2)
                    tr.append(td3)

                    tbody.append(tr)
                })
            }


        })
})

