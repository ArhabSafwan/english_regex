<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>English-Only Input Validation</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .error {
            color: red;
            display: none;
        }
    </style>
</head>

<body>
    <h2>English-Only Input Validation</h2>
    <form id="inputForm">
        <label for="textInput">Enter text:</label>
        <input type="text" id="textInput" name="textInput" required>
        <button type="submit">Submit</button>
    </form>

    <script>
        (function($) {
            $.fn.validateEnglishInput = function(allowedCharacters) {
                var regex = new RegExp('^[a-zA-Z0-9\s' + allowedCharacters + ']*$');
                var errorMessage = $('<p class="error">Only English letters, numbers, spaces, and allowed symbols are permitted.</p>');
                this.after(errorMessage);

                this.on('input', function() {
                    if (!regex.test($(this).val())) {
                        errorMessage.show();
                        $(this).val($(this).val().replace(new RegExp('[^a-zA-Z0-9\s' + allowedCharacters + ']', 'g'), ''));
                    } else {
                        errorMessage.hide();
                    }
                });

                this.closest('form').on('submit', function(e) {
                    e.preventDefault();
                    var inputVal = $(this).find('input[type="text"]').val();
                    if (!regex.test(inputVal)) {
                        errorMessage.show();
                    } else {
                        errorMessage.hide();
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

                return this;
            };
        })(jQuery);

        $(document).ready(function() {
            var allowedSymbols = "!\"#$%&'()*+,-./:;<=>?@[\\]^_`{|}~";
            $('#textInput').validateEnglishInput(allowedSymbols);
        });
    </script>
</body>

</html>