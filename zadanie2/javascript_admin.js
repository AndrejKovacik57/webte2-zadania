const form = document.querySelector('#result-table')
const button = document.querySelector('#search-button-admin')
const table = document.querySelector('#result-table-admin')
const thead = table.tHead
const tbody = table.tBodies[0]
button.addEventListener('click', () => {
    tbody.innerHTML = ''
    thead.innerHTML = ''
    const data = new FormData(document.getElementById("delete-form"))
    fetch('searchToDelete.php?delete-search=' + data.get('delete-search'),
        {method: 'get'}
    )
        .then(response => response.json())
        .then(result=>{
            const trhead = document.createElement('tr')
            const th1 = document.createElement('th')
            const th2 = document.createElement('th')
            th1.append('Sk')
            th2.append('En')
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
                const td4 = document.createElement('td')
                const buttondel = document.createElement('button')
                const buttonmo = document.createElement('button')
                buttondel.className = "btn btn-secondary"
                buttonmo.className = "btn btn-secondary"
                buttonmo.append('uprav')
                buttondel.append('vymaž')

                buttondel.addEventListener('click', () =>{
                    fetch('delete.php',{
                        method: 'POST',
                        body: JSON.stringify({id: item.word_id})
                    })
                        .then( response => response.json())
                        .then(result => {
                            if(result.deleted){
                                tr.remove()
                            }
                        })

                })
                buttonmo.addEventListener('click', () =>{
                    document.getElementById('word-id-update').value = item.word_id
                    document.getElementById('term-update').value = item.translatedTitle+';'+item.translatedDescription+';'+item.searchTitle+';'+item.searchDescription
                })

                td3.append(buttonmo)
                td4.append(buttondel)


                tr.append(td1)
                tr.append(td2)
                tr.append(td3)
                tr.append(td4)
                tbody.append(tr)
            })
        })
})