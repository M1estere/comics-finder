jQuery(document).ready(function ($) {    
    loadComicsList();

    $('#comic-uploader-form').on('submit', function (e) {
        e.preventDefault();

        var fileInput = $('input[name="comic_file"]')[0];
        var file = fileInput.files[0];

        var allowedExtensions = ['pdf'];

        var fileExtension = file.name.split('.').pop().toLowerCase();
        
        if (!allowedExtensions.includes(fileExtension)) {
            $('#comic-uploader-message').text('Разрешены только pdf файлы').css('color', 'red');
            return;
        }

        var formData = new FormData(this);
        formData.append('action', 'comic_uploader');
        formData.append('nonce', comicUploader.nonce);

        $('#comic-uploader-message').empty();

        $.ajax({
            url: comicUploader.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('#comic-uploader-message').html('Загрузка...');
                $('#comic-uploader-message').css('color', 'yellow');
            },
            success: function (response) {
                if (response.success) {
                    $('#comic-uploader-message').html(response.data.message);
                    $('#comic-uploader-message').css('color', 'green');
                } else {
                    $('#comic-uploader-message').html(response.data.message);
                    $('#comic-uploader-message').css('color', 'red');
                }
            },
            error: function () {
                $('#comic-uploader-message').html('Произошла ошибка при загрузке файла');
                $('#comic-uploader-message').css('color', 'red');
            },
        });
    });

    $('body').on('click', '.approve-comic', function() {
        var comicId = $(this).data('comic-id');
        var nonce = comicUploader.nonce;

        $.ajax({
            url: comicUploader.ajax_url,
            type: 'POST',
            data: {
                action: 'approve_comic',
                nonce: nonce,
                comic_id: comicId,
            },
            success: function(response) {
                if (response.success) {
                    console.log(response.data.message);
                    location.reload();
                } else {
                    console.log('Ошибка: ' + response.data.message);
                }
            },
            error: function() {
                console.log('Произошла ошибка. Попробуйте еще раз.');
            }
        });
    });

    $('body').on('click', '.delete-comic', function() {
        var comicId = $(this).data('comic-id');
        var nonce = comicUploader.nonce;

        $.ajax({
            url: comicUploader.ajax_url,
            type: 'POST',
            data: {
                action: 'delete_comic',
                nonce: nonce,
                comic_id: comicId,
            },
            success: function(response) {
                if (response.success) {
                    console.log(response.data.message);
                    location.reload();
                } else {
                    console.log('Ошибка: ' + response.data.message);
                }
            },
            error: function() {
                console.log('Произошла ошибка. Попробуйте еще раз.');
            }
        });
    });

    function loadComicsList() {
        var nonce = comicUploader.nonce;

        $.ajax({
            url: comicUploader.ajax_url,
            type: 'POST',
            data: {
                action: 'load_comics_list',
                nonce: nonce,
            },
            success: function(response) {
                response = response.slice(0, -1);
                $('.comic-list').html(response);
            }
        });
    }
});
