let body = document.getElementById('alertBody')
let inputSearch = document.getElementById('searchName')

let bodyData = []

function toPrintAlertBody(data) {

    let html = data.map((item, index) => {
        return `    <tr>
                         <td class="rowItem">${item['id']}</td>
                        <td><input  type='checkbox' aria-label='Checkbox for following text input' ${item.count ? 'checked' : ''}/></td>
                        <td class="nameItem">${item['name']}</td>
                        <td><input type='number' id='typeNumber${item['id']}' class='form-control' name="count[]" ${item.count ? `value=${item.count}` : ''}  /></td>
                    </tr>`
    }).join('')
    body.innerHTML = html

}


document.getElementById('addItem').addEventListener('click', () => {
    $.ajax({
        url: 'create-order',
        type: "GET",
        dataType: "json",
        success: function (data) {
            bodyData = data
            toPrintAlertBody(data)
            inputSearch.value = ''
        }
    });
})


let a = document.querySelectorAll('input[type="checkbox"]')

for (let i = 0; i < a.length; i++) {
    a[i].addEventListener('click', () => {
        if (a[i].hasAttribute("checked")) {
            a[i].removeAttribute("checked");
        } else {
            a[i].setAttribute("checked", "");
        }
    })
}
let newData = []
let totalPrice = 0
let addCount = 0

let arrSelectDate = []

function SelectDate() {
    arrSelectDate = []
    $('#alertBody tr').each(function () {

        let el_ = $(this);

        if (el_.find('[type=checkbox]').is(':checked')) {
            if (el_.find('[ type=number]').val()) {
                let id = el_.find(".rowItem").text();
                let name = el_.find(".nameItem").text();
                let count = el_.find('[ type=number]').val()
                arrSelectDate.push({id, name, count})
            }
        }
    });
}

function creatOrdersTable(arr) {
    if (!arr.length) {
        alert('ERROR :: Please check')
        return
    }

    const y = body.getElementsByTagName("tr");

    let arrId = arr.map((item) => {
        return item['id']
    })

    $.ajax({
        url: 'get-product-db',
        type: "POST",
        dataType: "html",
        data: {
            id: arrId
        },
        success: function (data) {
            data = JSON.parse(data)
            data = data.map((item, index) => {
                item.count = arr[index]['count']
                return item
            })
            newData = data
            totalPrice = 0
            addCount = 0

            let html = data.map((item, index) => {
                addCount += +item.count
                totalPrice += item.count * item.price
                return `   <tr>
                                <td>${index + 1}</td>
                                <td>${item.name}</td>
                                <td>${item.price}</td>
                                <td>${item.count * item.price}</td>
                                <td>${item.count}</td>
                                <td>${item.cost}</td>
                            </tr>`
            }).join('').toString()

            document.getElementById("orders-addcount").value = addCount
            document.getElementById("orders-totalprice").value = totalPrice


            document.getElementById("ordersBody").innerHTML = html
            $('.btn-close').trigger('click')

        }
    });
}

$('#btn-success').click(() => {
    SelectDate()
    creatOrdersTable(arrSelectDate)
});


inputSearch.addEventListener('input', () => {
    SelectDate()
    let inputDate = []

    function filterDate(arr = bodyData) {
        let filterDate = arr.filter((item) => {

            return arrSelectDate
                .map((item) => item.id)
                .includes(item.id.toString()) === false
        })
        toPrintAlertBody([...arrSelectDate, ...filterDate])
    }


    if (inputSearch.value.length > 0) {

        inputDate = bodyData.filter((item) => {
            return item.name.includes(inputSearch.value)
        })
        filterDate(inputDate)
    } else {
        filterDate()
    }


})


document.getElementById('btn-success-order').addEventListener("click", () => {
    let storeId = $('#orders-storeid').val()

    if (storeId) {
        if (newData.length) {
            $.ajax({
                url: 'create-order',
                type: "POST",
                dataType: "html",
                data: {
                    newData,
                    storeId,
                    totalPrice,
                    addCount,
                },
                success: function (data) {
                    window.location = 'index';
                },
                statusCode: {
                    500: function () {
                        alert("Error :: add orders");
                    },
                    404: function () {
                        alert("Error :: add orders");
                    }
                }
            })
        } else alert("Error :: add orders")
    } else alert('Choose store')


})

