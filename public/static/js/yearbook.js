(function (window, document, undefined) {

    // Edit page script
    function promptText(title, placeholder, callback) {
        var $modal = $("#prompt-text");
        $modal.find("h4").html(title);
        $modal.find("input").val(placeholder);
        $modal.modal();
        // Weirdly written code but it prevents multiple event handlers attached to the same button
        $modal.find(".accept").off("click").on("click", function () {
            callback($modal.find("input").val());
        });
    }

    function promptTextarea(title, placeholder, callback) {
        var $modal = $("#prompt-textarea");
        $modal.find("h4").html(title);
        $modal.find("textarea").html(placeholder);
        $modal.modal();
        // Weirdly written code but it prevents multiple event handlers attached to the same button
        $modal.find(".accept").off("click").on("click", function () {
            callback($modal.find("textarea").html());
        });
    }

    $("#student-name").on("click", function () {
        var title = "Edit your name";
        var text = $(this).html();
        var target = this;
        promptText(title, text, function (input) {
            $(target).html(input);
        });
    });

    $("#student-quote, #student-about").on("click", function () {
        // Lazy developer code follows
        var titles = {
            quote: "Edit your smartass quote",
            about: "Edit your bio"
        };
        var index = $(this).attr("id").split("-")[1];
        var text = $(this).html();
        var target = this;
        promptTextarea(titles[index], text, function (input) {
            $(target).html(input);
        });
    });

    // Script to update all data
    $("#save-changes").click(function () {
        var formData = {};
        formData.name = $("#student-name").html();
        formData.quote = $("#student-quote").html();
        formData.about = $("#student-about").html();
        $.post("/edit.php", formData, function (response) {
            response = JSON.parse(response);
            var $modal = $("#alert");
            $modal.find("h4").html(response.status);
            $modal.find("p").html(response.message);
            $modal.modal();
        });

    });
})(window, document);