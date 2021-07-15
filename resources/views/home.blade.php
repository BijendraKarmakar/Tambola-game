<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf_token" content="{{ csrf_token() }}" />

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
    <body>
    <div class="container">
        <div class="row py-5">
            <div class="col-12 text-center">
                <button class="btn btn-primary" id="generate">Generate Ticket</button>
            </div>
        </div>
        
        <div class="ticket-list row py-5">
            <div class="col-12 text-center">
            </div>
        </div>
    </div>    
    
    <?php 

//    function createTickets(){
//
//        $empty_index=array();
//        $tambola=array();
//
//        for ($i=0; $i <10 ; $i++) { // here $i gives tickets count
//            //$empty_index[$i][]= $this->UniqueRandomNumbersWithinRange(0,8,4);
//            $empty_index[$i][]= UniqueRandomNumbersWithinRange(0,8,4);
//        }
//
//        while(array_intersect($empty_index[0][0],$empty_index[1][0],$empty_index[2][0])){
//            //$empty_index[2][0]= $this->UniqueRandomNumbersWithinRange(0,8,4);
//            $empty_index[2][0]= UniqueRandomNumbersWithinRange(0,8,4);
//        }
//        
//        $n=0;
//        
//        for ($i=0; $i <9 ; $i++) { 
//            if(!in_array($i, $empty_index[0][0])&&!in_array($i, $empty_index[1][0])){
//                $empty_index[2][0][$n]=$i;
//                $n++;
//            }
//        }
//        
//        $empty_count=count(array_unique($empty_index[2][0]));
//        
//        while($empty_count<4){
//            for ($i=$empty_count; $i <4 ; $i++) { 
//                $temp=rand(0,8);
//                while(in_array($temp,array_intersect($empty_index[0][0],$empty_index[1][0]))){
//                    $temp=rand(0,8);
//                }
//                $empty_index[2][0][$i]=$temp;
//                $empty_count=count(array_unique($empty_index[2][0]));
//            }
//        }
//        
//        $list=array();
//        
//        for ($row=0; $row <3 ; $row++) { 
//            for ($col=0; $col <9 ; $col++) {
//                $min=$col*10+1;
//                $max=$col*10+9;
//                $tambola[$row][$col]['id']=$row.$col;
//                if(!in_array($col, $empty_index[$row][0])){
//                    $temp=rand($min,$max);
//                    while (in_array($temp, $list)) {
//                        $temp=rand($min,$max);
//                    }
//                    $list[]=$temp;
//                    $tambola[$row][$col]['value']=$temp;
//                }
//                else{
//                    $tambola[$row][$col]['value']='';   
//                }
//                $tambola[$row][$col]['meta_checked']=0;
//            }
//        }
//
//        $table = "";
//        for ($i=0; $i<sizeof($tambola); $i++) {
//            $table .= "<tr>";
//            for ($j=0; $j<9; $j++) {
//                $final_number = $tambola[$i][$j]['value'];
//                $table .= "<td>$final_number</td>";
//            }
//            $table .= "</tr>";
//        }
//        $table = "<table class='table table-bordered table-dark tickets ticket-1 py-5'>$table</table>";
//        return $table;
//    }
//
//    function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
//        $numbers = range($min, $max);
//        shuffle($numbers);
//        return array_slice($numbers, 0, $quantity);
//    }
//        
//
//    $html =  "";
//    for ($i=0; $i<1; $i++) {
//        $html .= "
//        <tr>
//            <td>" . createTickets() . "</td>
//            <td>" . createTickets() . "</td>
//            <td>" . createTickets() . "</td>
//        </tr>
//        <tr>
//            <td>" . createTickets() . "</td>
//            <td>" . createTickets() . "</td>
//            <td>" . createTickets() . "</td>
//        </tr>";
//    }
//    echo "<table class='table table-bordered'>$html</table>";
?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>