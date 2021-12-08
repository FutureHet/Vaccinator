$(function () {
    "use strict";    

    $("#verification").submit(function (e) {
        e.preventDefault();
        let id_number = $("#id_number").val().trim();
        let secret_code = $("#secret_code").val().trim();
        let dose_no = $("#dose_no").val().trim();
        $.ajax({
            url: "http://localhost:8080/verification.php",
            method: "POST",
            success: function (json) {
                console.log(json["success"]);
            },
        });
    });
});