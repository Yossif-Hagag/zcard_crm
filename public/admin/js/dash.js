function MainForm(nameForm, index = 0) {
    const modal = $(`${nameForm}`).eq(index);
    modal.css('display', 'unset');
    modal.removeClass('animate__fadeOut');
    modal.addClass('animate__backInDown');
}
$('#addLead').on('click', () => {
    const modal = $('.bg-mian-dark');
    modal.css('display', 'unset');
    modal.removeClass('animate__fadeOut');
    modal.addClass('animate__backInDown');
});
$('.leadSales .AddNAddress').on('click', () => {
    MainForm('.AddAddress')
});
$('.leadSales .AddNOrders').on('click', () => {
    MainForm('.AddOrders')
});
$('.dealsPage .editDealsBtn').each((index) => {
    $(' .editDealsBtn ').eq(index).on('click', () => {
        MainForm('.editDealsModals', index)
    })
});
// $('.leadSales .AddNOrders').each('click', () => {
//     MainForm('.editDealsModals')
// });

$('.leadSales .delay').on('click', () => {
    MainForm('.delay')
});
$('.RenewPage .renewCreate').each((index) => {

    $('.RenewPage .renewCreate').eq(index).on('click', () => {

        MainForm('.renewCard', index)
    })
});


$('.leadSales .AddNComments').on('click', () => {
    MainForm('.AddComments')
});

$('.cickMe').on('click', () => {
    const modal = $('.bg-mian-dark');
    modal.removeClass('animate__backInDown');
    modal.addClass('animate__fadeOut');

    setTimeout(() => {
        modal.css('display', 'none');
    }, 1000);
});
$('.lite').on('click', () => {
    const modal = $('.bg-mian-dark');
    modal.removeClass('animate__backInDown');
    modal.addClass('animate__fadeOut');

    setTimeout(() => {
        modal.css('display', 'none');
    }, 1000);
});




let statu = test;



if (statu == 1) {
    $('.request.crecal').css('background-color', '#2b30b0');
    $('.request.crecal').eq(0).append('<i class="fa-solid fa-check"></i>');
} else if (statu == 2) {
    $('.request.crecal').css('background-color', '#2b30b0');
    $('.confirmation.crecal').css('background-color', '#4cc98d');
    $('.request.crecal').eq(0).append('<i class="fa-solid fa-check"></i>');
    $('.confirmation.crecal').eq(0).append('<i class="fa-solid fa-check"></i>');

} else if (statu == 3) {
    $('.request.crecal').css('background-color', '#2b30b0');
    $('.confirmation.crecal').css('background-color', '#4cc98d');
    $('.request.print').css('background-color', '#2b30b0');
    $('.request.crecal').eq(0).append('<i class="fa-solid fa-check"></i>');
    $('.request.print').eq(0).append('<i class="fa-solid fa-check"></i>');
    $('.confirmation.crecal').eq(0).append('<i class="fa-solid fa-check"></i>');


} else if (statu == 4) {
    $('.request.crecal').css('background-color', '#2b30b0');
    $('.confirmation.crecal').css('background-color', '#4cc98d');
    $('.print.crecal').css('background-color', '#ff7575');
    $('.shipping.crecal').css('background-color', '#ab9aff');

    $('.request.crecal').eq(0).append('<i class="fa-solid fa-check"></i>');
    $('.confirmation.crecal').eq(0).append('<i class="fa-solid fa-check"></i>');
    $('.print.crecal').eq(0).append('<i class="fa-solid fa-check"></i>');
    $('.shipping.crecal').eq(0).append('<i class="fa-solid fa-check"></i>');
} else if (statu == 5) {
    $('.request.crecal').css('background-color', '#2b30b0');
    $('.confirmation.crecal').css('background-color', '#4cc98d');
    $('.print.crecal').css('background-color', '#ff7575');
    $('.shipping.crecal').css('background-color', '#ab9aff');
    $('.reception.crecal').css('background-color', '#551d70');

    $('.request.crecal').eq(0).append('<i class="fa-solid fa-check"></i>');
    $('.confirmation.crecal').eq(0).append('<i class="fa-solid fa-check"></i>');
    $('.print.crecal').eq(0).append('<i class="fa-solid fa-check"></i>');
    $('.shipping.crecal').eq(0).append('<i class="fa-solid fa-check"></i>');
    $('.reception.crecal').eq(0).append('<i class="fa-solid fa-check"></i>');
}

// forms add address
$('.AddAddress .AddMoreAddress').on('click', () => {
    $('.AddressSection').append(`<input type="text" class="form-control animate__animated animate__fadeInDown">`)

})

// orders
let id = $('.valOfCustomID');
let finalPrice
function colectePrice(index, dataCost) {
    $('.cardCost').attr('custom-attr', dataCost);
    let num = $(`.${$(id[index]).val()} .form-row`).length;

    $('.cardCost').val(dataCost * num);
    finalPrice = dataCost * num
    if ($('.finalPrice').length > 0) {
        $('.finalPrice').val(finalPrice)
    }

}


$('.addCustomerButton').each((index) => {
    $('.addCustomerButton').eq(index).on('click', function () {
        if (id.length > 0) {

            $(`.${$(id[index]).val()}`).append(`<div class="form-row customInputsCards animate__animated animate__fadeInDown">
                                    <div class="form-group col-md-6">
                                        <label for="inputName">Card Name</label>
                                        <input type="text" class="form-control" name="customer_name[]"
                                            placeholder="Please enter data" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPhone">Card Phone</label>
                                        <input type="text" class="form-control" name="customer_phone[]"
                                            placeholder="Please enter data" required>
                                    </div>
                                </div>`)
            var selectedOption = $('select[name="card_name"]').eq(index).find('option:selected');
            var dataCost = selectedOption.attr('data-cost');
            $('.cardCost').eq(index).val(dataCost);
            $('.cardCost').eq(index).attr('custom-attr', dataCost);

            colectePrice(index, dataCost)
        } else {
            $(`.customer-data-entry`).append(`<div class="form-row customInputsCards animate__animated animate__fadeInDown">
                                    <div class="form-group col-md-6">
                                        <label for="inputName">Card Name</label>
                                        <input type="text" class="form-control" name="customer_name[]"
                                            placeholder="Please enter data" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPhone">Card Phone</label>
                                        <input type="text" class="form-control" name="customer_phone[]"
                                            placeholder="Please enter data" required>
                                    </div>
                                </div>`)
            var selectedOption = $('select[name="card_name"]').find('option:selected');
            var dataCost = selectedOption.attr('data-cost');
            $('.cardCost').val(dataCost);
            $('.cardCost').attr('custom-attr', dataCost);
            colectePrice(0, 1)

        }
    })
})
if ($('.cardCost').length > 0) {
    $('.cardCost').on('keyup', () => {
        finalPrice = $('.cardCost').val()
        $('.finalPrice').val(finalPrice)
        // console.log($('.finalPrice').val());

    })
}
$(document).ready(function () {
    //
    if ($('select[name="card_name"]').length > 1) {

        $('select[name="card_name"]').each((index) => {
            $('select[name="card_name"]').eq(index).on('change', function () {

                var selectedOption = $('select[name="card_name"]').eq(index).find('option:selected');
                var dataCost = selectedOption.attr('data-cost');

                $('.cardCost').eq(index).val(dataCost);
                // console.log($('.cardCost').val());

                $('.cardCost').eq(index).attr('custom-attr', dataCost);
                colectePrice(index, dataCost)
            });
        })
    } else {

        $('select[name="card_name"]').on('change', function () {
            let count = $('.AddOrders .customer-data-entry .form-row').length;

            console.log(count);

            var selectedOption = $(this).find('option:selected');
            var dataCost = selectedOption.attr('data-cost');
            $('.cardCost').val(dataCost * count);
            colectePrice(0, dataCost)

        });
    }

});

$('#keyupForNum').on('change', function () {
    let valus = $('#keyupForNum').val();
    let count = $('.AddOrders .cardsInputs .form-row').length;

    if (valus > count) {
        if (valus < 50) {
            for (let index = count; index < valus; index++) {
                $('.AddOrders .cardsInputs').append(`
                    <div class="form-row animate_animated animate_fadeInDown">
                        <div class="form-group col-md-6">
                            <label for="inputEmail1${index + 1}">Input Name <div class="closess">x</div></label>
                            <input type="text" class="form-control" id="inputEmail1${index + 1}" placeholder="Please enter data">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword11${index + 2}">Phone Number</label>
                            <input type="number" class="form-control" id="inputPassword11${index + 2}" placeholder="Please enter data">
                        </div>
                    </div>
                `);
            }

        }
    }

    else if (valus < count) {
        $('.AddOrders .cardsInputs .form-row').slice(valus).remove();
    }
});
// sidebar
let sidebar = true
$('#btnSideBar').on('click', function () {
    // if (sidebar == true) {
    $('.flex-shrink-0.p-3.bg-white').css('left', 0)
    $('.sideClose').css('display', 'unset')
    $('#btnSideBar').css('display', 'none')
    // }
    // else {
    //     $('.flex-shrink-0.p-3.bg-white').css('left', '-240px')
    // }
    // sidebar = !sidebar
})
$('.sideClose').on('click', () => {
    $('.flex-shrink-0.p-3.bg-white').css('left', '-200px')
    $('#btnSideBar').css('display', 'unset')
    $('.sideClose').css('display', 'none')
})
// sidebar
// end orders

// porss test
if ($('#graph').length) {
    let el = document.getElementById('graph'); // get canvas

    let options = {
        percent: el.getAttribute('data-percent') || 15,
        size: el.getAttribute('data-size') || 150,
        lineWidth: el.getAttribute('data-line') || 15,
        rotate: el.getAttribute('data-rotate') || 0
    }

    let canvas = document.createElement('canvas');
    let span = document.createElement('span');
    span.textContent = options.percent;
    span.classList.add('prog');
    if (typeof (G_vmlCanvasManager) !== 'undefined') {
        G_vmlCanvasManager.initElement(canvas);
    }

    let ctx = canvas.getContext('2d');
    canvas.width = canvas.height = options.size;

    el.appendChild(span);
    el.appendChild(canvas);

    ctx.translate(options.size / 2, options.size / 2); // change center
    ctx.rotate((-1 / 2 + options.rotate / 180) * Math.PI); // rotate -90 deg

    // imd = ctx.getImageData(0, 0, 240, 240);
    let radius = (options.size - options.lineWidth) / 2;

    let drawCircle = function (color, lineWidth, percent) {
        percent = Math.min(Math.max(0, percent), 1);
        ctx.beginPath();
        ctx.arc(0, 0, radius, 0, Math.PI * 2 * percent, false);
        ctx.strokeStyle = color;
        ctx.lineCap = 'round'; // butt, round or square
        ctx.lineWidth = lineWidth
        ctx.stroke();
    };

    drawCircle('#efefef', options.lineWidth, 100 / 100);
    drawCircle('rgb(100 60 234)', options.lineWidth, options.percent / 100);
}

// end porss test

// sidebar

let btnSidebar = {};

$('.btnD').each(function (index) {
    btnSidebar[index] = true;

    $(this).on('click', function () {

        btnSidebar[index] = !btnSidebar[index];

        const rotation = btnSidebar[index] ? 'rotate(-90deg)' : 'rotate(0deg)';
        $('svg.svg-inline--fa.fa-chevron-down').eq(index).css('transform', rotation);
    });
});


//
if ($('#countries').length > 0) {
    new MultiSelectTag('countries', {
        rounded: true,    // default true
        shadow: true,      // default false
        placeholder: 'Search',  // default Search...
        tagColor: {
            textColor: 'rgb(224, 221, 220)',
            borderColor: 'none',
            bgColor: 'rgb(139, 135, 133)',
        },
        onChange: function (values) {
            console.log(values)
        }
    })
}

//===>>>


$('.table-content .Ticon').each(function (index) {

    let statuSubTable = false;

    $(this).on('click', function () {
        if (statuSubTable) {

            $('.subTable').eq(index).removeClass('animate__fadeInDown').addClass('animate__fadeOutUp');
            setTimeout(() => {
                $('.subTable').eq(index).css('display', 'none');
            }, 500);
        } else {

            $('.subTable').eq(index).css('display', 'block').removeClass('animate__fadeOutUp').addClass('animate__animated animate__fadeInDown');
        }

        statuSubTable = !statuSubTable;
    });
});

// shipping
$('.ShippingPage .headerSearching .table-header .item').removeClass('headerLineSearching')
switch ($('#item_name').val()) {
    case 'all':
        $('.ShippingPage .headerSearching .table-header #all').addClass('headerLineSearching')
        break;
    case 'new':
        $('.ShippingPage .headerSearching .table-header #new').addClass('headerLineSearching')
        break;
    case 'in-progress':
        $('.ShippingPage .headerSearching .table-header #in-progress').addClass('headerLineSearching')
        break;
    case 'on-the-way':
        $('.ShippingPage .headerSearching .table-header #on-the-way').addClass('headerLineSearching')
        break;
    case 'waiting-for-follow-up':
        $('.ShippingPage .headerSearching .table-header #waiting-for-follow-up').addClass('headerLineSearching')
        break;
    case 'completed':
        $('.ShippingPage .headerSearching .table-header #completed').addClass('headerLineSearching')
        break;
    case 'unsuccessful':
        $('.ShippingPage .headerSearching .table-header #unsuccessful').addClass('headerLineSearching')
        break;
    case 'returns-rejected':
        $('.ShippingPage .headerSearching .table-header #returns-rejected').addClass('headerLineSearching')
        break;
    default:
        // Handle unknown filter case if necessary
        break;
}



$('.ShippingPage .barPower .power').each(function (index) {
    let power = $(this).find('input').val();

    if (power == 1 || power == 2 || power == 3) {
        $(this).find('.green').css('background-color', 'green');

        if (power == 2 || power == 3) {
            $(this).find('.blue').css('background-color', '#04103b');

            if (power == 3) {
                $(this).find('.red').css('background-color', 'rgb(148, 3, 3)');
            }
        }
    }
});

// chat
if ($(".ppl .nameAndmsg").length > 0) {
    $(".ppl .nameAndmsg").on("click", function (event) {
        if ($("#CContainerOfMesseges").length) {
            $("#CContainerOfMesseges").removeClass("animate__bounceIn");
            console.log('here');

            setTimeout(() => {
                $("#CContainerOfMesseges").addClass("animate__bounceIn");
            }, 100);
        }
    });
}

function funclick() {
    $('.writeMessageSection .writing').val(' ')
}
// end chat
// chart

// end chart

if ($('#myChart').length > 0) {

    const data = {
        labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
        datasets: [{
            label: "30 Days",
            data: [122212, 190000, 3000000, 5000000, 2000000, 300000, 122212, 190000, 3000000, 5000000, 2000000, 300000],
            borderColor: 'rgba(38, 185, 154, 0.7)',
            backgroundColor: 'rgba(38, 185, 154, 0.3)',
            borderWidth: 2,
            pointStyle: 'false',
            pointRadius: 5,
            pointBackgroundColor: 'rgb(240 248 255 / 0%)',
            pointBorderWidth: 5,

        },
        {
            label: "12 months",
            data: [1500000, 1000000, 5004621, 756565, 1256484, 841642, 1500000, 1000000, 5004621, 756565, 1256484, 841542],
            borderColor: 'rgba(255, 99, 132, 0.7)',
            backgroundColor: 'rgba(255, 99, 132, 0.3)',
            borderWidth: 2,
            pointStyle: 'false',
            pointRadius: 5,
            pointBackgroundColor: 'rgb(240 248 255 / 0%)',
            pointBorderWidth: 5,

        },
        {
            label: "7 Days",
            data: [150000, 100000, 500421, 756565, 125484, 81642, 150000, 100000, 5004621, 75565, 125484, 84542],
            borderColor: 'rgba(255, 99, 252, 0.7)',
            backgroundColor: 'rgba(255, 99, 252, 0.3)',
            borderWidth: 2,
            pointStyle: 'false',
            pointRadius: 5,
            pointBackgroundColor: 'rgb(260 28 255 / 0%)',
            pointBorderWidth: 5,

        }
        ]
    };
    // Define the configuration
    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Line Chart with Custom Y-Axis Formatting'
                }
            },
            scales: {
                y: {
                    min: 0,
                    max: 5000000,
                    ticks: {
                        callback: function (value) {
                            if (value >= 1000000) {
                                return (value / 1000000).toFixed(1) + 'm'; // Format as millions
                            } else if (value >= 1000) {
                                return (value / 1000).toFixed(1) + 'k'; // Format as thousands
                            }
                            return value; // Return the value if less than 1000
                        }
                    }
                }
            }
        }
    };

    // Create the chart
    const ctx = document.getElementById('myChart');
    const myChart = new Chart(ctx, config);
}

if ($('.EditRuleTitle').length > 0) {
    $('.EditRuleTitle .TableRwo .col-md-4').each((index) => {
        $('.EditRuleTitle .TableRwo .col-md-4 .btnActive').eq(index).on('click', () => {
            if (!$('.EditRuleTitle .TableRwo .col-md-4 .btnActive').eq(index).hasClass('actived')) {
                $('.EditRuleTitle .TableRwo .col-md-4 .btnUnActive').eq(index).removeClass('actived')
                $('.EditRuleTitle .TableRwo .col-md-4 .btnActive').eq(index).addClass('actived')
            } else {
                $('.EditRuleTitle .TableRwo .col-md-4 .btnActive').eq(index).removeClass('actived')
                $('.EditRuleTitle .TableRwo .col-md-4 .btnUnActive').eq(index).addClass('actived')

            }
        })

        $('.EditRuleTitle .TableRwo .col-md-4 .btnUnActive').eq(index).on('click', () => {
            if (!$('.EditRuleTitle .TableRwo .col-md-4 .btnUnActive').eq(index).hasClass('actived')) {
                $('.EditRuleTitle .TableRwo .col-md-4 .btnActive').eq(index).removeClass('actived')
                $('.EditRuleTitle .TableRwo .col-md-4 .btnUnActive').eq(index).addClass('actived')
            } else {
                $('.EditRuleTitle .TableRwo .col-md-4 .btnUnActive').eq(index).removeClass('actived')
                $('.EditRuleTitle .TableRwo .col-md-4 .btnActive').eq(index).addClass('actived')

            }
        })
    })
}
//searching with date
if ($('.searchbyDates').length > 0) {
    let search = true;

    $('.searchbyDates select').on('change', () => {
        if (search == true) {
            //animate__bounceIn
            $('.searchbyDates .DealDateTo').removeClass('animate__fadeOut');
            $('.searchbyDates .ReceiptDateTo').removeClass('animate__bounceIn');
            $('.searchbyDates .ReceiptDateTo').addClass('animate__fadeOut');

            $('.searchbyDates .ReceiptDateTo').css('display', 'none');

            $('.searchbyDates .DealDateTo').css('display', 'block');
            $('.searchbyDates .DealDateTo').addClass('animate__bounceIn');
        } else {
            $('.searchbyDates .ReceiptDateTo').removeClass('animate__fadeOut');
            $('.searchbyDates .DealDateTo').removeClass('animate__bounceIn');
            $('.searchbyDates .DealDateTo').addClass('animate__fadeOut');

            $('.searchbyDates .DealDateTo').css('display', 'none');

            $('.searchbyDates .ReceiptDateTo').css('display', 'block');
            $('.searchbyDates .ReceiptDateTo').addClass('animate__bounceIn');
        }
        search = !search
    })
}

let divId = $('.shippingModalsBolesaa');

function printDiv(index) {
    var printContents = divId.get(index).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}

$('.btnprint').each((index) => {
    $('.btnprint').eq(index).on('click', () => {
        printDiv(index)
    })
})


new DataTable('#accountingTable', {
    layout: {
        topStart: {
            buttons: ['pdfHtml5']
        }
    }
});
$('.accountingTablePage .dt-search').append('<i class="fa-solid fa-magnifying-glass" style="color: #76747b;"></i>')

$('.accountingTablePage .dt-buttons').addClass('pdfBtn')
// $('.accountingTablePage .dt-buttons').prepend('<button  data-bs-toggle="modal" data-bs-target="#AddRevenue" class="addRevenues" ><i class="fa-solid fa-plus" style="color: #ffffff;"></i></button>')
$('.accountingTablePage .dt-buttons .buttons-pdf').append('<i class="fa-solid fa-arrow-down" style="color: #ffffff;"></i>')

// fillter form
if ($('.leadsTableF'.length > 0)) {
    function redirectToShippingPage() {
        var customerName = $('#name').val()
        var customerPhone = $('#phone').val()
        var contract_id = $('#contract_id').val()
        var follow_date_from = $('#follow_date_from').val()
        var follow_date_to = $('#follow_date_to').val()
        var create_date_from = $('#create_date_from').val()
        var create_date_to = $('#create_date_to').val()
        var stage_id = $('#stage_id').val()
        var source_id = $('#source_id').val()
        var user_id = $('#user_id').val()

        var newUrl = window.location.pathname;
        var params = [];

        if (customerName) {
            params.push('name=' + encodeURIComponent(customerName));
        }
        if (customerPhone) {
            params.push('phone=' + encodeURIComponent(customerPhone));
        }
        if (contract_id) {
            params.push('contract_id=' + encodeURIComponent(contract_id));
        }
        if (follow_date_from) {
            params.push('follow_date_from=' + encodeURIComponent(follow_date_from));
        }
        if (follow_date_to) {
            params.push('follow_date_to=' + encodeURIComponent(follow_date_to));
        }
        if (create_date_from) {
            params.push('create_date_from=' + encodeURIComponent(create_date_from));
        }
        if (create_date_to) {
            params.push('create_date_to=' + encodeURIComponent(create_date_to));
        }
        if (stage_id) {
            params.push('stage_id=' + encodeURIComponent(stage_id));
        }
        if (source_id) {
            params.push('source_id=' + encodeURIComponent(source_id));
        }
        if (user_id) {
            params.push('user_id=' + encodeURIComponent(user_id));
        }

        if (params.length > 0) {
            newUrl += '?' + params.join('&');
        } else {
            newUrl = '/leads';
        }

        // Redirect to the new URL
        window.location.replace(newUrl);
    }

    $('#stage_id').on('change', () => {

        redirectToShippingPage()
    })
    $('#contract_id').on('change', () => {

        redirectToShippingPage()
    })
    $('#source_id').on('change', () => {

        redirectToShippingPage()
    })
    $('#user_id').on('change', () => {

        redirectToShippingPage()
    })
    $('#follow_date_to').on('change', () => {

        redirectToShippingPage()
    })
    $('#create_date_to').on('change', () => {

        redirectToShippingPage()
    })

    $('#name').on('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent default form submission
            redirectToShippingPage();
        }
    });
    // $('#stage_id').on('change', function() {
    //     console.log('dddd');

    //     // preventDefault(); // Prevent default form submission
    //     // redirectToShippingPage();
    // });

    $('#phone').on('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent default form submission
            redirectToShippingPage();
        }
    });


}

