<?php
session_start();
?>

<script type='text/javascript'>
    function ReColor(answer,question, right){
        let ans = document.getElementById(`answer[${answer}]`);
        let que = document.getElementById(`question[${question}]`);
        if(right==true)
        {
            ans.classList.add('btn-success');
            que.classList.add('btn-success');
        }
        else {
            ans.classList.add('btn-danger');
            que.classList.add('btn-danger');
        }
        ans.classList.remove('btn-light');
        que.classList.remove('btn-secondary');
        ans.setAttribute("disabled","true");
    }
</script>

<?php
include_once("bdconnection.php");
class QuestionCase
{
    private $question;
    public function __construct($questionID_OrQuestion, &$db)
    {

        if (is_int($questionID_OrQuestion)) {
            $this->question['question'] = $db->FetchQuery("SELECT * FROM `questions`  WHERE id='$questionID_OrQuestion'");
        } else {
            $this->question['question'] = $questionID_OrQuestion;
        }
        $queId = $this->question['question']['id'];
        $this->question['answers'] = $db->FetchQuery("SELECT * FROM `answers` WHERE questionId='$queId'");
    }

    public function GetQuestion()
    {
        return $this;
    }

    public function PrintCase($question,$TicketId)
    {
        echo ("   
                <div class='questionCase'>
                    <div class='row'>
                        <img src='" . $this->question['question']['image'] . "'>
                    </div>
                    <div class='row'>
                        <div class='col-lg-8'>" . $this->question['question']['text'] . "</div>
                        <div class='col-lg-3'>Тема " . $this->question['question']['themeId'] . "</div>
                        <div class='col-lg-1'>Билет " . $this->question['question']['ticketId'] . "</div>
                    </div>
                    
            ");
        echo ("<form method='POST'>");
        
        foreach ($this->question['answers'] as $key => $value) {
            if (!isset($_SESSION[$TicketId]["ans"]["$question"]))
            {
                $color= "btn-light";
                $active= "";
            }
            else if ($value['id'] == $this->question['question']['rightAnswer'])
            {
                $color= "btn-success";
                $active = "disabled";
            }
            else
            {
                $color='btn-danger';
                $active = 'disabled';
            }
            echo ("
                        <div class='form-group row col'>
                        <input $active type='submit' class='btn $color btn-answer' value='" . $value['text'] . "' name ='answer[$key]' id='answer[$key]'></input>
                        <input type='hidden' name='question[$question]' value='$question' />
                        </div>
                ");
        }
        echo ("</form>");



        if ($_POST['answer']) {
            foreach ($_POST['answer'] as $key => $value) {
                if (!isset($_SESSION[$TicketId]["ans"]["$question"])){
                    if ($this->question['answers'][$key]['id'] == $this->question['question']['rightAnswer']) {
                        echo "<script type=\"text/javascript\"> ReColor($key,$question,'1');</script>";
                        $_SESSION[$TicketId]["ans"]["$question"]= true;
                    }
                    else
                    {   
                        echo "<script type=\"text/javascript\"> ReColor($key,$question,'0');</script>";
                        $_SESSION[$TicketId]["ans"]["$question"] = false;
                    }
                }
            }
            echo("<pre>");
            print_r($_SESSION);
            echo("</pre>");
        }
    }
}
?>

