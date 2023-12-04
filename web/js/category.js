// console.log(window.location.pathname)

if (window.location.pathname === '/category') {

    let categoryBody = document.getElementById('categoryBody')
    // localStorage.clear()
    let bodyData = []
    let mainArr = []
    let objOpen = {}
    let orderId = []
    let defId = localStorage.getItem('orderId') ?
        JSON.parse(localStorage.getItem('orderId'))
        : [1, 3, 15, 20, 21, 22, 5, 6, 11, 12, 17, 7, 23, 9, 10, 19, 13, 14, 16]


    $(document).ready(async function () {
        await getProductBody()
        $("#categoryBody").sortable();
        mainArr.forEach((el, index) => {
            $(`#categoryBody${el['id']}`).sortable();

        })

        $(".list-group-item").mouseup(function () {
            orderId = []
            setTimeout(() => {
                $('#categoryBody li').each(function () {
                    orderId.push($(this).attr('id'))
                })

                sortProduct(orderId)

            }, 0)

        });


    });

    function sortProduct(orderId) {
        localStorage.setItem('orderId', JSON.stringify(orderId))


    }

    function sortProductById(data = bodyData, id = defId) {

        let newData = []
        id.forEach(id => {
            data.forEach(el => {
                +id === +el.id ? newData.push(el) : ''
            })
        })
        bodyData = newData

        mainArr = newData.filter((item) => item.parentId === '')
        mainArr.forEach(item => objOpen[item.id] = newData.filter(el => +el.parentId === +item.id))
    }


    async function getProductBody() {
        await $.ajax({
            url: '/category/get-product',
            type: "GET",
            success: (data) => {
                data = JSON.parse(data)
                sortProductById(data)

                !defId &&
                mainArr.forEach(item => {
                    orderId.push(item.id)
                    objOpen[item.id].forEach(el => orderId.push(el.id))
                })


                printBody(mainArr)

            }
        });

    }

    <!--         class="d-none"-->
    function printBody(data = mainArr) {

        categoryBody.innerHTML = data.map((el, index) => {
            let html = objOpen[el['id']].map((el, index) => `<li id="${el['id']}" class="list-group-item list-group-item-action fw-normal" >. ${el['name']}</li>`).join('')
            return `<div>
                        <li id="${el['id']}" onclick="openTable(${el['id']})" class="list-group-item list-group-item-action fw-bold" >${index + 1}  ${el["name"]}</li>
                            <ul id="categoryBody${el['id']}"  style="display:none">
                                ${html}
                            </ul>
                    </div>`
        }).join('')
    }

    function openTable(id) {
        let body = document.getElementById('categoryBody' + id)
        body.style.display = body.style.display === 'none' ? '' : 'none'
    }


}

