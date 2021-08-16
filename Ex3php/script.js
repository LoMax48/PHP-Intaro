// Обработчик события нажатия на кнопку
$("#sendMail").on("click", function() {
    //Получаем данные
    var fio = $("#fio").val().trim();
    var email = $("#email").val().trim();
    var phone = $("#phone").val().trim();
    var comment = $("#comment").val().trim();

    // Обнуляем подсвечивание полей
    $("#errorMsg").text("");
    $("#fio").removeClass("border-danger");
    $("#email").removeClass("border-danger");
    $("#phone").removeClass("border-danger");
    $("#comment").removeClass("border-danger");

    var flag = true;
    // Проверка всех полей на пустоту
    if ($("#fio").val().length == 0) {
        $("#fio").addClass("border-danger");
        $("#errorMsg").append("Введите ФИО.<br>")
        flag = false;
    } 

    if ($("#comment").val().length < 5) {
        $("#comment").addClass("border-danger");
        $("#errorMsg").append("Комментарий должен состоять более, чем из 5 символов.<br>");
        flag = false;
    } 

    if ($("#phone").val().length == 0) {
        $("#phone").addClass("border-danger");
        $("#errorMsg").append("Введите номер телефона.<br>");
        flag = false;
    }

    if ($("#email").val().length == 0) {
        $("#email").addClass("border-danger");
        $("#errorMsg").append("Введите E-mail.<br>");
        flag = false;
    }

    if (!flag) {
        return false;
    }

    // Разбиваем ФИО на отдельные слова
    var fioArray = $("#fio").val().split(" ");
    // Проверяем кол-во слов
    if (fioArray.length != 3) {
        $("#fio").addClass("border-danger");
        $("#errorMsg").append("Введите ФИО полностью, разделяя пробелами.<br>")
        flag = false;
    }

    // Валидация email'а
    var emailRegEx = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    if (!emailRegEx.test(String($("#email").val()).toLowerCase())) {
        $("#email").addClass("border-danger");
        $("#errorMsg").append("Некорректный формат E-mail.<br>");
        flag = false;
    }
    
    // Валидация телефона
    var phoneRegEx = /^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/;
    if (!phoneRegEx.test(String($("#phone").val()).toLowerCase())) {
        $("#phone").addClass("border-danger");
        $("#errorMsg").append("Некорректный формат телефона.<br>");
        flag = false;
    }

    if (!flag) {
        return false;
    }
    
    $.ajax({
        url: 'script.php', // Исполняемый файл PHP
        type: 'POST', // Тип запроса
        cache: false, // Кэширование
        data: { 'fio': fio, 'email': email, 'phone': phone, 'comment': comment }, // Параметры
        dataType: 'html', // Тип возвращаемого значение
        success: function(data) { // Функция, выполняемая по завершении цикла Ajax
            if (data != 'success') {
                $("#errorMsg").text(data);
            } else {
                var currentdate = new Date(); 
                currentdate.setMinutes(currentdate.getMinutes() + 90);
                var datetime = currentdate.getHours() + ":"  
                    + currentdate.getMinutes() + ":" 
                    + currentdate.getSeconds() + " " 
                    + currentdate.getDate() + "."
                    + (currentdate.getMonth() + 1)  + "." 
                    + currentdate.getFullYear() + ".";

                $("#form").hide();
                $("#userMsg").html("Оставлено сообщение из формы обратной связи." + "<br>" + 
                    "ФАМИЛИЯ: " + fioArray[0] + "<br>" +
                    "ИМЯ: " + fioArray[1] + "<br>" + "ОТЧЕСТВО: " + fioArray[2] + "<br>" +
                    "ТЕЛЕФОН: " + phone + "<br>" + "E-mail: " + email + "<br>" +
                    "С вами свяжутся после " + datetime);
            }
        }
    })
});