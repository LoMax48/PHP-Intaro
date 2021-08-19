$("#change_string").on("click", function() {
    var str = $("#str").val();

    $.ajax({
        url: 'DoubleNumbers.php', // Исполняемый файл PHP
        type: 'GET', // Тип запроса
        cache: false, // Кэширование
        data: { 'str': str }, // Параметры
        dataType: 'html', // Тип возвращаемого значение
        success: function(data) { // Функция, выполняемая по завершении цикла Ajax
            $("#result").text(data);
        }
    })
})

$("#change_references").on("click", function() {
    $.ajax({
        url: 'ReplaceReferences.php', // Исполняемый файл PHP
        type: 'POST', // Тип запроса
        cache: false, // Кэширование
        data: { }, // Параметры
        dataType: 'html', // Тип возвращаемого значение
        success: function(data) { // Функция, выполняемая по завершении цикла Ajax
            $("#references").html(data);
        }
    })
})