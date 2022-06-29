<?php
    include_once("template.php");
    include_once("questionExample.php");
    include_once("ticketExample.php");
?>

<div class='tickets'>
    <form method="GET">
    <div class='form-group row'>
    <?php
        $getCountOfTickets = $db->FetchQuery("SELECT count(id) FROM tickets WHERE 1")[0]['count(id)'];
        
        for ($i=1; $i <= $getCountOfTickets; $i++) { 
            echo("<div class='col-lg-3 form-group'>
                    <input type='submit' class='btn btn-secondary form-control' value='Билет $i' name='ticket[$i]'></input>
                </div>");
            if ($i%4==0)
            {
                echo("</div> <div class='form-group row'>");  
            }
            if ($i==$getCountOfTickets) 
            {
                echo("</div");
            }
        }
    ?>
    </form>
</div>

<script type="text/javascript">
    function clearContent(Selector){
        document.querySelector(Selector).remove();
    }
</script>

    <?php
        if($_GET['ticket']){
            foreach ($_GET['ticket'] as $key => $value) {
                if (isset($value)) {     
                    echo "<script type=\"text/javascript\"> clearContent('.tickets');</script>";
                    $ticket = new TicketCase($key,$db);
                    $ticket->PrintTicketCase();
                }
            }
        }
        if(isset($_SESSION[$ticket->GetTicketId()]['ans'])){
            if(count($_SESSION[$ticket->GetTicketId()]['ans'])==20)
            {
                $right=0;
                foreach ($SESSION[$ticket->GetTicketId()]['ans'] as $key => $value) {
                    if ($value==true) $right++;
                }
                print("У вас $right из 20!!!!!!!!!!!!!!!");

                // $_SESSION[$ticket->GetTicketId()]['ans'] = null;
            }
        }
    ?>


