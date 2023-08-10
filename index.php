<link rel="stylesheet" type="text/css" href="style.css">

<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>


    <h1 class="title"> TAMU Free Grade Distribution</h1>

    <p>Enter the course information into the submission boxes below and the next page will have the grade distribution for
        all the professors over the last 18 semesters.</p>
    <p> I created this because we had access to a great scheduler and grade distribution website in myedu before A&M took that away and gave it to another
        website that doesn't even have a scheduler and it charges you per course you want to look up. I just want
        this to be helpful to whoever uses. It's very simple and I don't know how much I'll update in terms of aesthetics, but I
        will keep updating the course data as long as I can.</p>
    <p>It should have most of the classes. There are 12 total colleges I pull the data from and the whole list can be found
        <a href="https://goo.gl/snAx65">with the source code.</a> If you are interested in improving what I've done then feel free. If you want
        the csv files I use as the back end to the server they can be found <a href="https://goo.gl/bgahxe"> here.</a> Also you can find the
        php and css files I use for the server <a href="https://goo.gl/IRBoHK"> here. </a>
    </p>
    <p style="text-align: center"><b>I'm glad this website is helping people. </b> </p>
    <p style="text-align: center"><b>NEW! Honors are now highlighted.</b></p>
    <form action="L-Display.php" method="post" style="text-align: center">

        <body class="inputText">Course (Ex: CSCE)</body>

        <input name="my_html_input_tag" value="" />

        <body class="inputText">Course Number (Ex: 111)</body>

        <input name="my_html_input_tag1" value="" />

        <body class="inputText">Sort By: </body>
        <select name="SortBy">
            <option value="1">GPA</option>
            <option value="2">Professor Last Name</option>
        </select>

        <input style="text-align: center" type="submit" name="test2" value="Submit" />


    </form>
    <br>
    <div>
        <h4 class="suggestion">For Suggestions email: <a href="mailto: jippylong12@gmail.com">jippylong12@gmail.com</a> </h4>
        <h4 class="suggestion"> Data gathered from Spring 2012-Fall 2019</h4>
        <h4 class="suggestion"><a href="http://www.jippylong12.xyz">Me</a>  </h4>
    </div>
    <br>
    <div>
        <h4 class="suggestion"> Thanks & Acknowledgements</h4>
        <h5 class="credits">
            Matthew: adding the Q drop column.<br>
            Zubin: Pointing out the averaging problem.<br>
            Eric: Suggesting to distinguish honors sections.
        </h5>
    </div>
</body>

</html>
