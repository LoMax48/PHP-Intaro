$("#secure_connection").on("click", function() {
    var id = $("#secure_input").val();

    $.ajax({
        url: 'SecureConnection.php', // Исполняемый файл PHP
        type: 'POST', // Тип запроса
        cache: false, // Кэширование
        data: { 'id': id }, // Параметры
        dataType: 'html', // Тип возвращаемого значение
        success: function(data) { // Функция, выполняемая по завершении цикла Ajax
            $("#secure_data").html(data);
        }
    })
})

$("#unsecure_connection").on("click", function() {
    var id = $("#unsecure_input").val();

    $.ajax({
        url: 'UnsecureConnection.php', // Исполняемый файл PHP
        type: 'POST', // Тип запроса
        cache: false, // Кэширование
        data: { 'id': id }, // Параметры
        dataType: 'html', // Тип возвращаемого значение
        success: function(data) { // Функция, выполняемая по завершении цикла Ajax
            $("#unsecure_data").html(data);
        }
    })
})