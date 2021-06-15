$(document).ready(function () {
    // Variable to hold request
    var request;

    $("#message-form").submit(function (e) {
        e.preventDefault();

        // Abort any pending request
        if (request) {
            request.abort();
        }

        // setup some local variables
        var $form = $(this);

        // Let's select and cache all the fields
        var $inputs = $form.find("input, textarea");

        // Serialize the data in the form
        var serializedData = $form.serialize();

        // Let's disable the inputs for the duration of the Ajax request.
        // Note: we disable elements AFTER the form data has been serialized.
        // Disabled form elements will not be serialized.
        $inputs.prop("disabled", true);

        // Fire off the request to /form.php
        request = $.ajax({
            url: "/message.php",
            type: "post",
            data: serializedData
        });

        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR) {
            const jsonResponse = JSON.parse(response);
            if (jsonResponse.success) {
                alert("Thank you. Your message has been sent.")
            } else if (jsonResponse.success === false && jsonResponse.reason === "Validation") {
                const propertyNames = Object.keys(jsonResponse.errors);
                $(propertyNames).each(function (index, propName) {
                    $(`#${propName}`).addClass("is-invalid");
                    $(`label[for='${propName}']`).addClass("text-danger");
                    const message = jsonResponse.errors[`${propName}`];
                    $(`small[for='${propName}']`).text(message).show();
                });
            } else {
                alert("Something went wrong and your message could not be sent.")
            }
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });
    });
    
    $("input, textarea").blur(function (e) {
        const id = $(this).attr("id");
        $(`#${id}`).removeClass("is-invalid");
        $(`label[for='${id}']`).removeClass("text-danger");
        $(`small[for='${id}']`).hide();
        e.stopPropagation();
    });
});