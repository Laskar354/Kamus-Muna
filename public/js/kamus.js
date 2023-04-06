$(function () {
    // Kamus Indo-Muna
    $("#formKamus").submit(function (e) {
        e.preventDefault();

        const kata = $("input[name=kataIndo]").val();
        // console.log(kata);

        $.ajax({
            method: "get",
            url: "http://kamus-muna.test:8080/prosesKata",
            data: { kata: kata },
            dataType: "json",
            success: function (hasil) {
                $("#arti").html(hasil);
            },
        });
    });

    // Translate indo-muna
    $("#formTranslateIndo").submit(function (e) {
        e.preventDefault();

        const kalimatIndo = $("textArea[name=translateIndo]").val();
        // console.log(kalimatIndo);

        $.ajax({
            method: "get",
            url: "http://kamus-muna.test:8080/prosesKalimatIndo",
            data: { kalimatIndo: kalimatIndo },
            // dataType: "json",
            success: function (hasil) {
                // $("#translate").val(hasil);
                console.log(hasil);
            },
        });
    });

    // copy Clipboard
    $("#copy-button").click(function (e) {
        e.preventDefault();
        const btn = $("#translate");

        btn.focus();
        btn.select();
        document.execCommand("copy");
    });
});
