<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dashboard</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="container">
        <div class="row py-5">
            <div class="col-12 text-center">
<!--                <form method="post">-->
<!--                    <input type="submit" class="btn btn-primary" id="generate" value="Generate Ticket">-->
<!--                </form>-->
                                <button class="btn btn-primary" id="generate">Generate Ticket</button>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 text-center">
<!--
                <table class="table table-bordered table-dark tickets ticket-1 py-5">
                    <tr>
                        <td></td>
                        <td>13</td>
                        <td>23</td>
                        <td></td>
                        <td></td>
                        <td>50</td>
                        <td>62</td>
                        <td></td>
                        <td>83</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>15</td>
                        <td></td>
                        <td></td>
                        <td>40</td>
                        <td></td>
                        <td>64</td>
                        <td>71</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>17</td>
                        <td></td>
                        <td>32</td>
                        <td></td>
                        <td>58</td>
                        <td></td>
                        <td>76</td>
                        <td>87</td>
                    </tr>
                </table>
-->
            </div>
        </div>
        
        <?php
        //if(array_key_exists('generate', $_POST)) {
        function createTicket() {
            $numbers = range(1,90); // Range
            shuffle ( $numbers ); // Random unique number

            // Each ticket has 3 rows and each row has 4 blank spaces
            $row = [ ["", "", "", ""], ["", "", "", ""], ["", "", "", ""] ];
            //$row = [ [""], [""], [""] ];
            //$row = array('1', '2');
            //$row = [ ["", "", "", "", "", "", "", "", ""], ["", "", "", "", "", "", "", "", ""], ["", "", "", "", "", "", "", "", ""] ];
            
            // Each row has 5 numbers
            for ($i=0; $i<sizeof($row); $i++) {
                for ($j=0; $j<5; $j++) {
                    //$numbers = range(strval($j)1,strval($j)9); // Range
                    //shuffle ( $numbers );
                    //if($j==0){
                        //$numbers = range($j+1, 3*($i+1); // Range
                        //$numbers = range(strval($j).'0', strval($j).'9'); // Range
                        //shuffle ( $numbers ); // Random unique number
                        //echo strval($j+1) .'-'. 9 . ' @@@ ';
                    //}
                    //elseif($j==4){
                        //$numbers = range(strval($j).'0', strval($j+1).'0'); // Range
                        //shuffle ( $numbers ); // Random unique number
                        //echo strval($j).'0' .'-'. strval($j+1).'0' . ' @@@ ';
                    //}
                    //else{
                        //$numbers = range(strval($j).'0', strval($j).'9'); // Range
                        //shuffle ( $numbers ); // Random unique number
                        //echo strval($j).'0' .'-'. strval($j).'9' . ' @@@ ';
                    //}
                    //shuffle ( $numbers ); // Random unique number
                    array_push($row[$i],$numbers[$i*5+$j]);
                }
                // Let's shuffle to maintain randomness
                shuffle($row[$i]);
            }

            $table = "";

            for ($i=0; $i<sizeof($row); $i++) {
                $table .= "<tr>";
                for ($j=0; $j<9; $j++) {
                    $final_number = $row[$i][$j];
                    $table .= "<td>$final_number</td>";
                }
                $table .= "</tr>";
            }

            $table = "<table class='table table-bordered table-dark tickets ticket-1 py-5'>$table</table>";

            return $table;
        }
        
        $html =  "";

        // Generate 3x200 tickets per sheet
        for ($i=0; $i<1; $i++) {
                $html .= "
                <tr>
                    <td>" . createTicket() . "</td>
                    <td>" . createTicket() . "</td>
                    <td>" . createTicket() . "</td>
                </tr>
                <tr>
                    <td>" . createTicket() . "</td>
                    <td>" . createTicket() . "</td>
                    <td>" . createTicket() . "</td>
                </tr>";
        }
        echo "<table class='table table-bordered'>$html</table>";
        //}
        ?>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="{{ URL::asset('../resources/js/custom.js') }}"></script>
    </body>
</html>
