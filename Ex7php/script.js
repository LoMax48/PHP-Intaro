$("#send").on("click", function() {
    var address = $("#address").val();

    $.ajax({
        url: 'GetAddressInfo.php',
        type: 'POST',
        cache: false,
        data: {'address': address},
        dataType: 'html',
        beforeSend: function () {
            $("#send").prop('disabled', true);
        },
        success: function(response) {
            var result = $.parseJSON(response);
            $("#result").html(
                "Страна: " + result.address.country + '<br>' +
                "Субъект: " + result.address.province + '<br>' +
                "Округ: " + result.address.area + '<br>' +
                "Населённый пункт: " + result.address.locality + '<br>' +
                "Улица: " + result.address.street + '<br>' +
                "Дом: " + result.address.house + '<br>' +
                "Координаты: " + result.coords + '<br>' +
                "Ближайшее метро: " + result.metro
            );

            $("#send").prop('disabled', false);
        }
    })
})