
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
let newData
let totalPrice = 0
let addCount = 0


document.getElementById('btn-success').addEventListener('click', () => {

    const body = document.getElementById('alertBody')
    const y = body.getElementsByTagName("tr");

    let arr = []


    for (let i = 0; i < y.length; i++) {
        for (let x = 0; x < y[i].getElementsByTagName('td').length; x++) {
            // console.log(y[i].getElementsByTagName('td')[x].innerHTML)
            // console.log(typeof y[i].getElementsByTagName('td')[x].innerHTML)
            //
            // console.log(y[i].getElementsByTagName('td')[x].innerHTML.search('checked'))


            if (y[i].getElementsByTagName('td')[x].innerHTML.search('checked') != "-1") {
                // console.log(y[i].getElementsByTagName('td')[x].innerHTML)
                let l = y[i].getElementsByTagName('td')[x + 2].innerHTML.substr(y[i].getElementsByTagName('td')[x + 2].innerHTML.search('value') + 6, 6)

                if (document.getElementById(`typeNumber${y[i].getElementsByTagName('td')[x - 1].innerHTML}`).value != 0) {
                    let arrItem = []
                    arrItem.push(y[i].getElementsByTagName('td')[x - 1].innerHTML)
                    arrItem.push(y[i].getElementsByTagName('td')[x + 1].innerHTML)
                    arrItem.push(document.getElementById(`typeNumber${y[i].getElementsByTagName('td')[x - 1].innerHTML}`).value)

                    arr.push(arrItem)
                }
            }
        }
    }
    let arrId = arr.map((item) => {
        return item[0]
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
                item.count = arr[index][2]
                return item
            })
            newData=data
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
})

let intp=document.getElementById('searchName')
intp.addEventListener('input',()=>{
    const y =  document.getElementById('alertBody').getElementsByTagName("tr");
    const alertBody = document.getElementById('alertBody')
    for (let i=0;i<y.length;i++){
        for (let x = 0; x < y[i].getElementsByTagName('td').length; x++){
            if (y[i].getElementsByTagName('td')[x].innerHTML===intp.value){
                // console.log(y[i].getElementsByTagName('td')[x-2].innerHTML)
                // console.log(y[i].getElementsByTagName('td')[x-1].innerHTML)
                // console.log(y[i].getElementsByTagName('td')[x].innerHTML)
                let html= `
                <tr>
                    <td scope='row'>${y[i].getElementsByTagName('td')[x - 2].innerHTML}</td>
                    <td><input  type='checkbox' aria-label='Checkbox for following text input'></td>
                    <td>${y[i].getElementsByTagName('td')[x].innerHTML}</td>
                    <td><input type='number' id='typeNumber${y[i].getElementsByTagName('td')[x - 2].innerHTML}' class='form-control' name="count[]"/></td>
                </tr>
                `
                alertBody.innerHTML=html

            }else{

            }

        }
    }
    // console.log(intp.value)
})


let storeId =$('#orders-storeid').val()
// console.log(storeId)

document.getElementById('btn-success-order').addEventListener("click", () => {
    let storeId =$('#orders-storeid').val()

    if (storeId){
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
                500: function() {
                    alert( "Error :: add orders" );
                }
            }
        })
    }

})

