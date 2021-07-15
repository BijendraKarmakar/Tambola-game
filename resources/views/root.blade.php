
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housie Ticket</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        a:link, a:visited {
            color: blue;
        }

        .container {
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        #tbl {
            border: 1px solid black;
            border-spacing: 5px;
            max-width: 90vw;
            padding: 10px;
            margin-left: auto;
            margin-right: auto;
            display: none;
        }

        td {
            font-size: 22px;
            width: 50px;
            height: 50px;
            text-align: center;
            border: 1px solid black;
            vertical-align: middle;
            background-color: white;
            font-family: "courier New";
            font-weight: bold;
            cursor: pointer;
        }

        .selected {
            background-color: #ffff99;
        }

        #footer {
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
            color: #888;
        }

        .shake-it {
            animation-name: shake;
            animation-iteration-count: 4;
            animation-duration: 150ms;
        }

        @media screen and (max-width: 599px) {
            #tbl {
                padding: 5px;
                max-width: 100vw;
            }

            td {
                font-size: 18px;
                width: 30px;
                height: 30px;
            }
        }

        @keyframes shake {
            0%,50%,100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(2deg);
            }

            75% {
                transform: rotate(-2deg);
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="confetti.js"></script>
</head>
<body>
    <div class="container">
        <h2>Bingo/Housie/Tambola Ticket Generator</h2>
        <p>Click the number to mark it, click again to unmark</p>
        <table id="tbl"></table>
        <div style="margin-top: 20px; font-weight: bold;" id="marked">Marked: 0</div>
        <input type="button" value="Generate New Ticket" onclick="generateTicket(1)" style="margin-top: 20px; font-size: 15px; padding: 5px 20px;">
        <br><br>
        
		<a href="bingo.htm">Bingo/Housie/Tambola Number Generator</a>

		<div style="margin-top: 20px;">
			<span style="vertical-align: middle;">Get Housie app &nbsp;&nbsp;</span>
			<a href="https://play.google.com/store/apps/details?id=com.uconomix.housie"><img src="https://www.yash.info/blog/wp-content/uploads/2021/01/dl-google.png" style="width: 100px; height: auto; vertical-align: middle; border: 0"></a>
			&nbsp;&nbsp;&nbsp;
			<a href="https://apps.apple.com/in/app/housie-ticket-generator/id1549459502"><img src="https://www.yash.info/blog/wp-content/uploads/2021/01/dl-apple.png" style="width: 100px; height: auto; vertical-align: middle; border: 0"></a>
		</div>
    </div>
    <div id="notes" style="        display: none"></div>
    <div id="footer">
        Created by <a href="http://www.yash.info/blog/">Yash</a>.
    </div>

    <script>
        var firstFive = false, topRow = false, middleRow = false, bottomRow = false;

        function getRandom(arr, n) {
            var result = new Array(n),
                len = arr.length,
                taken = new Array(len);
            if (n > len)
                throw new RangeError("getRandom: more elements taken than available");
            while (n--) {
                var x = Math.floor(Math.random() * len);
                result[n] = arr[x in taken ? taken[x] : x];
                taken[x] = --len in taken ? taken[len] : len;
            }
            return result;
        }

        function getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        function getZeroOne() {
            return Math.round(Math.random());
        }

        function convertTo3ElementArray(arr) {
            $("#notes").append(arr.toString() + "<br>");
        }

        function getRandomColor() {
            return "#" + Math.floor(Math.random() * 16777215).toString(16);
        }

        function generateTicket(v) {
			if(v == 1){
				if(confirm("Are you sure you want to generate a new ticket?") == false)
					return;
			}

            firstFive = false; topRow = false; middleRow = false; bottomRow = false;
            $("#tbl").hide().html("");
            var columnok = false;
            var rows = [];

            while (columnok != true) {
                columnok = false;
                rows = [];
                for (r = 0; r < 3; r++) {
                    var row = [];
                    var onecount = 0;
                    while (onecount != 5) {
                        onecount = 0;
                        row = [];
                        for (c = 0; c < 9; c++) {
                            n = getZeroOne();
                            if (n == 1) onecount++;
                            row.push(n);
                        }
                    }
                    rows.push(row);
                    //$("#notes").append(row.toString() + "<br>");
                }

                //Check if all columns have at least one 1
                for (c = 0; c < 9; c++) {
                    if (rows[0][c] == 1 || rows[1][c] == 1 || rows[2][c] == 1) {
                        columnok = true;
                    }
                    else {
                        columnok = false;
                        //$("#notes").append("Not OK<br>");
                        break;
                    }
                }

                $("#tbl").css("background-color", getRandomColor()).show();
            }

            //Replace 1s with numbers
            for (c = 0; c < 9; c++) {
                //get count of 1s in this column
                var nums = rows[0][c] + rows[1][c] + rows[2][c];
                var min = c * 10 + 1;
                var max = min + 8;
                if (c == 8) max = 90;
                var tmp = [];
                for (n = min; n <= max; n++) {
                    tmp.push(n);
                }
                var arr = getRandom(tmp, nums).sort().reverse();
                for (r = 0; r < 3; r++) {
                    if (rows[r][c] == 1) {
                        rows[r][c] = arr.pop();
                    }
                }
            }

            var tblstr = "";
            for (r = 0; r < 3; r++) {
                tblstr += "<tr>";
                for (c = 0; c < 9; c++) {
                    if (rows[r][c] == 0) {
                        tblstr += "<td>&nbsp;</td>";
                    }
                    else {
                        tblstr += "<td>" + rows[r][c] + "</td>";
                    }

                }
                tblstr += "</tr>";
            }

            $("#tbl").html(tblstr);
        }

        $(function () {
            generateTicket(0);
        });

        $("#tbl").on("click", "td", function () {
            if ($(this).text().trim() != "") {
                if ($(this).hasClass("selected")) {
                    if (confirm("Are you sure you want to unmark " + $(this).text() + "?") == true) {
                        $(this).removeClass("selected")
                    }
                }
                else {
                    $(this).addClass("selected");
                }
                var marked = $("td.selected").length;
                $("#marked").html("Marked: " + marked);
                $("#tbl").removeClass("shake-it");

				if(marked < 5) firstFive = false;
                if (marked == 5 && firstFive == false) {
                    confetti.start(3000);
                    firstFive = true;
                    $("#tbl").addClass("shake-it");
                }

				if($("#tbl tr:first-child td.selected").length < 5) topRow = false;
                if ($("#tbl tr:first-child td.selected").length == 5 && topRow == false) {
                    confetti.start(3000);
                    topRow = true;
                    $("#tbl").addClass("shake-it");
                }

				if ($("#tbl tr:nth-child(2) td.selected").length < 5) middleRow = false;
                if ($("#tbl tr:nth-child(2) td.selected").length == 5 && middleRow == false) {
                    confetti.start(3000);
                    middleRow = true;
                    $("#tbl").addClass("shake-it");
                }

				if ($("#tbl tr:last-child td.selected").length < 5) bottomRow = false;
                if ($("#tbl tr:last-child td.selected").length == 5 && bottomRow == false) {
                    confetti.start(3000);
                    bottomRow = true;
                    $("#tbl").addClass("shake-it");
                }
            }
        });
    </script>
</body>
</html>










Array ( 
    [0] => Array ( 
        [0] => Array ( 
            [id] => 00 
            [value] => 
            [meta_checked] => 0 
        ) 
        [1] => Array ( 
            [id] => 01 
            [value] => 18 
            [meta_checked] => 0 
        ) 
        [2] => Array ( 
            [id] => 02 
            [value] => 22 
            [meta_checked] => 0 
        ) 
        [3] => Array ( 
            [id] => 03 
            [value] => 34 
            [meta_checked] => 0 
        ) 
        [4] => Array ( 
            [id] => 04 
            [value] => 43 
            [meta_checked] => 0 
        ) 
        [5] => Array ( 
            [id] => 05 
            [value] => 
            [meta_checked] => 0 
        )
        [6] => Array ( 
            [id] => 06 
            [value] => 
            [meta_checked] => 0 
        ) 
        [7] => Array ( 
            [id] => 07 
            [value] => 
            [meta_checked] => 0 
        ) 
        [8] => Array ( 
            [id] => 08 
            [value] => 86 
            [meta_checked] => 0 
        ) 
    ) 
    [1] => Array ( 
        [0] => Array ( 
            [id] => 10 
            [value] => 4 
            [meta_checked] => 0 
        ) 
        [1] => Array ( 
            [id] => 11 
            [value] => 17 
            [meta_checked] => 0 
        ) 
        [2] => Array ( 
            [id] => 12 
            [value] => 28 
            [meta_checked] => 0 
        ) 
        [3] => Array ( 
            [id] => 13 
            [value] => 39 
            [meta_checked] => 0 
        ) 
        [4] => Array ( 
            [id] => 14 
            [value] => 
            [meta_checked] => 0 
        ) 
        [5] => Array ( 
            [id] => 15 
            [value] => 
            [meta_checked] => 0 
        ) 
        [6] => Array ( 
            [id] => 16 
            [value] => 63 
            [meta_checked] => 0 
        ) 
        [7] => Array ( 
            [id] => 17 
            [value] => 
            [meta_checked] => 0 
        ) 
        [8] => Array ( 
            [id] => 18 
            [value] => 
            [meta_checked] => 0 
        ) 
    ) [2] => Array ( 
        [0] => Array ( 
            [id] => 20 
            [value] => 5 
            [meta_checked] => 0 
        ) 
        [1] => Array ( 
            [id] => 21 
            [value] => 
            [meta_checked] => 0 
        ) 
        [2] => Array ( 
            [id] => 22 
            [value] => 
            [meta_checked] => 0 
        ) 
        [3] => Array ( 
            [id] => 23 
            [value] => 
            [meta_checked] => 0 
        ) 
        [4] => Array ( 
            [id] => 24 
            [value] => 46 
            [meta_checked] => 0 
        )
        [5] => Array ( 
            [id] => 25 
            [value] => 53 
            [meta_checked] => 0 
        )
        [6] => Array ( 
            [id] => 26 
            [value] => 64 
            [meta_checked] => 0 
        ) 
        [7] => Array ( 
            [id] => 27 
            [value] => 79 
            [meta_checked] => 0 
        )
        [8] => Array ( 
            [id] => 28 
            [value] => 
            [meta_checked] => 0 
        ) 
    ) 
)