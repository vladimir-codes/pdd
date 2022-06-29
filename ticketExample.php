<?php
    include_once("bdconnection.php");
    include_once("questionExample.php");
    class TicketCase
    {
        private $questions=[];
        private $TicketId = 0;
        public function __construct($TicketId, &$db)
        {
            $this->TicketId = $TicketId;
            $questionsid = [];
            $questionsid = $db->FetchQuery("SELECT * FROM `questions` WHERE ticketId='$TicketId'"); 
            foreach ($questionsid as $key => $value) {
                $question = new QuestionCase($value,$db);
                array_push($this->questions,$question->GetQuestion());
            }
            
        }

        public function GetTicket()
        {
            return $this;
        }

        public function GetTicketId()
        {
            return $this->TicketId;
        }

        public function GetQuestions()
        {
            return $this->questions;
        }

        public function PrintTicketCase()
        {         
            echo("<div></form> <form method='POST'");
            echo("<div class='ticketExample form-group row'>");
            foreach ($this->questions as $key => $value) {
                if(isset($_SESSION[$this->TicketId]["ans"][$key]))
                {
                    $color = $_SESSION[$this->TicketId]["ans"][$key] ? "btn-success" : 'btn-danger'; 
                } 
                else 
                {
                    $color = "btn-secondary";
                }
               echo(" 
                    <input type='submit' class='btn $color btn-question col' value='".($key+1)."' name='question[$key]' id='question[$key]'></input>
                    
               ");
            }
            echo("</form>");
            if($_POST['question']){
                foreach ($_POST['question'] as $key => $value) {
                    if(isset($key))
                    {   
                        $this->questions[$key]->PrintCase($key,$this->TicketId);
                    }
                }
            }
            echo("</div></div>");
        }
        
    }
?>