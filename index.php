<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>English-Only Input Validation</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .error { color: red; display: none; }
    </style>
</head>
<body>
    <h2>English-Only Input Validation</h2>
    <form id="inputForm">
        <label for="textInput">Enter text:</label>
        <input type="text" id="textInput" name="textInput" required>
        <button type="submit">Submit</button>
        <p class="error" id="error-message">Only English letters, numbers, spaces, and allowed symbols are permitted.</p>
    </form>

    <script>
        (function($) {
            $.fn.validateEnglishInput = function(allowedCharacters) {
                var regex = new RegExp('^[a-zA-Z0-9\s' + allowedCharacters + ']*$');
                this.on('input', function() {
                    if (!regex.test($(this).val())) {
                        $('#error-message').show();
                        $(this).val($(this).val().replace(new RegExp('[^a-zA-Z0-9\s' + allowedCharacters + ']', 'g'), ''));
                    } else {
                        $('#error-message').hide();
                    }
                });
                return this;
            };
        })(jQuery);

        $(document).ready(function() {
            var allowedSymbols = "!\"#$%&'()*+,-./:;<=>?@[\\]^_`{|}~";
            $('#textInput').validateEnglishInput(allowedSymbols);

            $('#inputForm').on('submit', function(e) {
                e.preventDefault();
                var inputVal = $('#textInput').val();
                var regex = new RegExp('^[a-zA-Z0-9\s' + allowedSymbols + ']*$');
                if (!regex.test(inputVal)) {
                    $('#error-message').show();
                } else {
                    $('#error-message').hide();
                    $.ajax({
                        url: 'process.php',
                        type: 'POST',
                        data: { action: 'validate', input: inputVal },
                        dataType: 'json',
                        success: function(response) {
                            alert(response.message);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
