
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <title>Results</title>
</head>

<body class="container">
    <div id="copy-url-button">
        <button class="copy-url-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z"/>
            </svg>
            <span class="ms-1">
                Share
            </span>
        </button>
    </div>
    <?php
    require 'ResultsGenerator.php';
    (new ResultsGenerator())->generate();
?>
</body>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    const copyUrlButton = document.getElementById("copy-url-button");

    copyUrlButton.addEventListener("click", function() {
        let course = document.getElementById('course').value;
        let number = document.getElementById('number').value;
        let sortBy = document.getElementById('sort_by').value;
        let currentUrl = `https://grades.jippylong12.xyz/?course=${course}&number=${number}&sort_by=${sortBy}`;
        navigator.clipboard.writeText(currentUrl);
        Toastify({
            text: "Copied!",
            duration: 1000,
            gravity: "bottom", // `top` or `bottom`
            position: "center", // `left`, `center` or `right`
            stopOnFocus: false, // Prevents dismissing of toast on hover
            style: {
                background: 'black'
            },
            className: "info",
        }).showToast();
    });
</script>
</html>
