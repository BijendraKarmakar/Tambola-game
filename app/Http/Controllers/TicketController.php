<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tickets = array();
        $tickets_arr = '';
        $table = '';
        $ticket_tables = array();
        $ticket_table = array();
        $ticket_value = array();
        
        Ticket::truncate();
    
        for ($sheet=1; $sheet<=3; $sheet++) {
            for ($ticket_sheet=1; $ticket_sheet<=6; $ticket_sheet++) {
                $database_tickets = Ticket::select('t_value')->where('t_parent_id', '=', $sheet)->get()->toArray();
                $tickets = $this->createTickets($sheet, $ticket_sheet, $database_tickets);
                $tickets_arr = implode("-",$tickets[$sheet][$ticket_sheet]);
                $ticket_row = new Ticket();
                $ticket_row->t_parent_id = $sheet;
                $ticket_row->t_key = $ticket_sheet;
                $ticket_row->t_value = $tickets_arr;
                $ticket_row->save();
            }
        }
        
        $tickets_all = Ticket::all();
        $tickets_collect = collect($tickets_all);
        
        $ticket_value_index = 0;
        for ($sheet=1; $sheet<=3; $sheet++) {
            $ticket_table = $tickets_collect->filter(function ($value, $key) use($sheet){
                return data_get($value, 't_parent_id') == $sheet;
            })->all();
            $table .= "<p class='text-left mb-0'>Sheet: ". $sheet ."</p><table class='table table-bordered sheets sheet-1'>";

            for ($ticket_sheet=1; $ticket_sheet<=6; $ticket_sheet++) {
                if($ticket_sheet%3 == 1){
                    $table .= "<tr>";
                }
                $ticket_table = collect($ticket_table);
                $ticket_value = $ticket_table->filter(function ($value, $key) use($ticket_sheet){
                    return data_get($value, 't_key') == $ticket_sheet;
                })->all();
                $ticket_tables = $ticket_value[$ticket_value_index]['t_value'];
                $ticket_value_index++;
                $ticket_tables = explode("-",$ticket_tables);
                
                foreach($ticket_tables as $key=>$t){
                    if($t =='X'){
                        $ticket_tables[$key] = '';
                    }
                }
                $table .= "<td><p class='text-left mb-0'>Ticket No: ". $ticket_sheet ."</p><table class='table table-bordered table-dark ticket-sheets ticket-sheet-1 my-0'>";
                $ticket_tables_index = 0;
                for ($i=0; $i<3; $i++) {
                    $table .= "<tr>";
                    for ($j=0; $j<9; $j++){
                        $table .= "<td>" . $ticket_tables[$ticket_tables_index] ."</td>";
                        $ticket_tables_index++;
                    }
                    $table .= "</tr>";
                }
                $table .= "</table></td>";
                if($ticket_sheet%3 == 0){
                    $table .= "</tr>";
                }
            }
            $table .= "</table>";
        }

        return $table;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
    
    
    
    
    function createTickets($sheet, $ticket_sheet, $database_tickets){

        if(!empty($database_tickets)){

            $message = "database has ticket";
            Log::info($message);

            $old_ticket = array();

            for($i=0; $i<sizeof($database_tickets); $i++){
                $old_db_ticket = $database_tickets[$i]['t_value'];
                $old_db_ticket = explode("-",$old_db_ticket);
                $old_db_ticket = array_diff($old_db_ticket, ["X"]);
                $old_ticket = array_merge($old_ticket, $old_db_ticket);
            }

            $tambola = $this->creatingTambolaTickets($old_ticket);
   
        }else{
            $message = "inside else statement";
            Log::info($message);
            $tambola = $this->creatingTambolaTickets($old_ticket = array());
        }
        
        $sheet_no = $sheet;
        $ticket_no = $ticket_sheet;

        // serialising every column
        for($i=0; $i<9; $i++){

            ${'column_' . $i} = array($tambola['0'][$i]['value'],$tambola['1'][$i]['value'],$tambola['2'][$i]['value']);
            ${'serialize_column_' . $i} = array_diff(${'column_' . $i},["X"]);
            sort(${'serialize_column_' . $i});
            $insert_x = array('X');

            foreach(${'column_' . $i} as $key => $values){
                if($values == "X"){
                    array_splice(${'serialize_column_' . $i}, $key, 0, $insert_x);
                }
            }
        }

        // creating final array

        $new_array_0 = array();
        $new_array_1 = array();
        $new_array_2 = array();
        $final_array = array();

        for ($i=0; $i<9; $i++){
            $new_array_0[$i]['value'] = ${'serialize_column_' . $i}['0'];
            $new_array_1[$i]['value'] = ${'serialize_column_' . $i}['1'];
            $new_array_2[$i]['value'] = ${'serialize_column_' . $i}['2'];
        }
        
        for($i=0; $i<3; $i++){
            $final_array[$i] = ${'new_array_' . $i};
        }

        $tickets_table = array();
        
        for ($i=0; $i<sizeof($final_array); $i++) {
            for ($j=0; $j<9; $j++) {
                $tickets_table[$sheet_no][$ticket_no][] = $final_array[$i][$j]['value'];
            }
        }
        
        return $tickets_table;
    }

    function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

    function creatingTambolaTickets($old_ticket){

        do{

            $empty_index=array();
            $tambola=array();

            for ($i=0; $i <3 ; $i++) {
                $empty_index[$i][]= $this->UniqueRandomNumbersWithinRange(0,8,4);
            }

            while(array_intersect($empty_index[0][0],$empty_index[1][0],$empty_index[2][0])){
                $empty_index[2][0]= $this->UniqueRandomNumbersWithinRange(0,8,4);
            }
            
            $n=0;
            
            for ($i=0; $i <9 ; $i++) {
                if(!in_array($i, $empty_index[0][0])&&!in_array($i, $empty_index[1][0])){
                    $empty_index[2][0][$n]=$i;
                    $n++;
                }
            }
            
            $empty_count=count(array_unique($empty_index[2][0]));
            
            while($empty_count<4){
                for ($i=$empty_count; $i <4 ; $i++) { 
                    $temp=rand(0,8);
                    while(in_array($temp,array_intersect($empty_index[0][0],$empty_index[1][0]))){
                        $temp=rand(0,8);
                    }
                    $empty_index[2][0][$i]=$temp;
                    $empty_count=count(array_unique($empty_index[2][0]));
                }
            }
            
            $list=array();
            $first_column_Array = array();
            $second_column_Array = array();
            $third_column_Array = array();
            $fourth_column_Array = array();
            $fivth_column_Array = array();
            $sixth_column_Array = array();
            $seventh_column_Array = array();
            $eighth_column_Array = array();
            $nineth_column_Array = array();

            
            for ($row=0; $row <3 ; $row++) {
                for ($col=0; $col <9 ; $col++) {

                    if(empty($old_ticket)){

                        if($col == 0){
                            $min = 1;
                            $max = 9;
                        } elseif($col == 8){
                            $min=$col*10;
                            $max=$col*10+10;
                        }else{
                            $min=$col*10;
                            $max=$col*10+9;
                        }
                        
                        $tambola[$row][$col]['id']=$row.$col;
                        if(!in_array($col, $empty_index[$row][0])){
                            $temp=rand($min,$max);
                            while (in_array($temp, $list)) {
                                $temp=rand($min,$max);
                            }
                            $list[]=$temp;
                            $tambola[$row][$col]['value']=$temp;
                        }
                        else{
                            $tambola[$row][$col]['value']='X';   
                        }
                        $tambola[$row][$col]['meta_checked']=0;

                    }else{

                        foreach($old_ticket as $values){
                            
                            if($col == 0 && $values > 0 && $values < 10){
                                $first_column_Array[] = $values;
                            }elseif($col == 1 && $values > 9 && $values < 20){
                                $second_column_Array[] = $values;
                            }elseif($col == 2 && $values > 19 && $values < 30){
                                $third_column_Array[] = $values;
                            }elseif($col == 3 && $values > 29 && $values < 40){
                                $fourth_column_Array[] = $values;
                            }elseif($col == 4 && $values > 39 && $values < 50){
                                $fivth_column_Array[] = $values;
                            }elseif($col == 5 && $values > 49 && $values < 60){
                                $sixth_column_Array[] = $values;
                            }elseif($col == 6 && $values > 59 && $values < 70){
                                $seventh_column_Array[] = $values;
                            }elseif($col == 7 && $values > 69 && $values < 80){
                                $eighth_column_Array[] = $values;
                            }elseif($col == 8 && $values > 79 && $values < 91){
                                $nineth_column_Array[] = $values;
                            }
                        }

                        if($col == 0){

                            $first_column_range = range(1,9);
                            $first_column = array_diff($first_column_range, $first_column_Array);
                            $array_column_0 = $first_column[array_rand($first_column)];

                        }elseif($col == 1){

                            $second_column_range = range(10,19);
                            $second_column = array_diff($second_column_range, $second_column_Array);
                            $array_column_1 = $second_column[array_rand($second_column)];

                        }elseif($col == 2){

                            $third_column_range = range(20,29);
                            $third_column = array_diff($third_column_range, $third_column_Array);
                            $array_column_2 = $third_column[array_rand($third_column)];

                        }elseif($col == 3){

                            $fourth_column_range = range(30,39);
                            $fourth_column = array_diff($fourth_column_range, $fourth_column_Array);
                            $array_column_3 = $fourth_column[array_rand($fourth_column)];

                        }elseif($col == 4){

                            $fivth_column_range = range(40,49);
                            $fivth_column = array_diff($fivth_column_range, $fivth_column_Array);
                            $array_column_4 = $fivth_column[array_rand($fivth_column)];

                        }elseif($col == 5){

                            $sixth_column_range = range(50,59);
                            $sixth_column = array_diff($sixth_column_range, $sixth_column_Array);
                            $array_column_5 = $sixth_column[array_rand($sixth_column)];

                        }elseif($col == 6){

                            $seventh_column_range = range(60,69);
                            $seventh_column = array_diff($seventh_column_range, $seventh_column_Array);
                            $array_column_6 = $seventh_column[array_rand($seventh_column)];

                        }elseif($col == 7){

                            $eighth_column_range = range(70,79);
                            $eighth_column = array_diff($eighth_column_range, $eighth_column_Array);
                            $array_column_7 = $eighth_column[array_rand($eighth_column)];

                        }elseif($col == 8){

                            $nineth_column_range = range(80,90);
                            $nineth_column = array_diff($nineth_column_range, $nineth_column_Array);
                            $array_column_8 = $nineth_column[array_rand($nineth_column)];
                        }
                        
                        $tambola[$row][$col]['id']=$row.$col;
                        if(!in_array($col, $empty_index[$row][0])){
                            $temp = ${'array_column_' . $col};
                            while (in_array($temp, $list)) {
                                $temp = ${'array_column_' . $col};
                            }
                            $list[]=$temp;
                            $tambola[$row][$col]['value']=$temp;
                        }
                        else{
                            $tambola[$row][$col]['value']='X';   
                        }
                        $tambola[$row][$col]['meta_checked']=0;

                        $message = "test ticket created";

                        Log::info($message);

                        Log::info(print_r($tambola,true));
                    }

                }
            }

            // if(!empty($old_ticket)){
            //     echo "<pre>";
            //     print_r($tambola);
            //     exit;
            // }

            $message = "ticket created";

            Log::info($message);

            $simplified_ticket = "";

            foreach($tambola as $single_tickets){
                foreach($single_tickets as $single_values){
                    $simplified_ticket = $simplified_ticket . " " . $single_values['value'];
                }
            }

            $yes_ticket = implode(" ",$old_ticket);

            Log::info($simplified_ticket);
            Log::info($yes_ticket);

            $simplified_ticket = explode(" ", $simplified_ticket);
            $simplified_ticket = array_diff($simplified_ticket, ["X"]);


        }while(count(array_intersect($simplified_ticket, $old_ticket)) != 0);

        return $tambola;
    }
 
}
