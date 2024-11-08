<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/drag.css">
    <title>Image Viewer</title>
    <style>
        body {
            margin: 0;
            background-size: cover;
            background-position: center;
        }
        input[type=text], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=submit] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }
        div {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div id="myWindow" class="window">
        <div class="window-top">
            <p>Wrap up </p>
            <button class="round red"></button>    
        </div>
        <div class="window-content">
            <p class="paragraph">Iti place poza?</p>
            <p class="paragraph">Alege o optiune si apasa "Submit"</p>
            <form id="feedbackForm">
                <div class="radio-container">
                    <input type="radio" id="da" name="y_n" value="DA">
                    <label for="da">Da</label>
                </div>
                <div class="radio-container">
                    <input type="radio" id="nu" name="y_n" value="NU">
                    <label for="nu">Nu</label>
                </div>
                
                <div class="submit-container">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    
            const urlParams = new URLSearchParams(window.location.search);
            const imageName = urlParams.get('image');

            if (imageName) {
                document.body.style.backgroundImage = `url('${imageName}')`;
            } else {
                document.body.innerHTML = '<h1>No image found</h1>';
            }


            document.getElementById('feedbackForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(this);
                const response = formData.get('y_n');

                if (response === 'DA') {
                    if (imageName) {
                        const link = document.createElement('a');
                        link.href = imageName;
                        link.download = imageName.split('/').pop(); 
                        link.click();
                    }
                } else {
                    window.location.href = 'index.php';
                }
            });

        
            makeDraggable(document.querySelector('#myWindow'));
        });
    </script>

    <script src="Scripts/drag.js"></script>


    

</body>
</html>