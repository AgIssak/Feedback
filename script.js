$(document).ready(function() {
    $('#feedback-form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: 'submit_feedback.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function() {
                alert('Ошибка при отправке отзыва!!!');
            }
        });
    });
});
