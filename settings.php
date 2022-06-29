<?php
include_once("template.php");
?>


<script type="text/javascript">
    function addAnswerInput(index){
        let node = document.querySelector('.Answer');
        console.log(node.childNodes[2]);
        node.childNodes[2]
        document.querySelector('.AnswersArea').appendChild(node);
         <?php $index++;?>
    }
</script>


<?php
    $tickets = $db->FetchQuery("SELECT * From tickets");
    $themes = $db->FetchQuery("SELECT * From themes");
?>

<div class='AddQuestion'>
<div class="header row">Добавить вопрос</div>
<form method="POST"  enctype="multipart/form-data">
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputState">Номер билета</label>
      <select id="inputTicketState" class="form-control" name='ticket'>
        <?php
            foreach ($tickets as $key => $value) {
                echo("<option>".$value['id']."</option>");
            }
        ?>
      </select>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputState">Номер темы</label>
      <select id="inputThemeState" class="form-control" name='theme'>
        <?php
            foreach ($themes as $key => $value) {
                echo("<option>".$value['name']."</option>");
            }
        ?>
      </select>
    </div>
  </div>
  <div class="form-row row">
    <div class="form-group col-md-8">
      <label for="inputState">Сам вопрос</label>
      <input type="text" class="form-control" name='question'>
        
        </input>
    </div>
    <div class="form-group col-md-3">
      <label for="inputState">Картинка</label>
      <input type='file' name="img" accept="image/jpeg,image/gif,image/x-png"></input>
    </div>
  </div>
  
  <div class="form-row row AnswersArea">
    <div class='form-row row Answer'>
        <div class="form-group col-md-8">
        <input type="text" class="form-control" name="answer[0]" placeholder='Ответ'>
            
            </input>
        </div>
        <div class="form-group col-md-2">
        <label for="inputState">Это правильный ответ</label>
        <input type="radio" name="trueAnswer[0]" value='Правильный ответ'>
            
            </input>
        </div>
    </div>
    <div class='form-row row Answer'>
        <div class="form-group col-md-8">
        <input type="text" class="form-control" name="answer[1]" placeholder='Ответ'>
            
            </input>
        </div>
        <div class="form-group col-md-2">
        <label for="inputState">Это правильный ответ</label>
        <input type="radio"  name="trueAnswer[1]" value='Правильный ответ'>
            
            </input>
        </div>
    </div>
    <div class='form-row row Answer'>
        <div class="form-group col-md-8">
        <input type="text" class="form-control" name="answer[2]" placeholder='Ответ'>
            
            </input>
        </div>
        <div class="form-group col-md-2">
        <label for="inputState">Это правильный ответ</label>
        <input type="radio" name="trueAnswer[2]" value='Правильный ответ'>
            
            </input>
        </div>
    </div>
    <div class='form-row row Answer'>
        <div class="form-group col-md-8">
        <input type="text" class="form-control" name="answer[3]" placeholder='Ответ'>
            
            </input>
        </div>
        <div class="form-group col-md-2">
        <label for="inputState">Это правильный ответ</label>
        <input type="radio" name="trueAnswer[3]" value='Правильный ответ'>
            
            </input>
        </div>
    </div>
  </div>

  <div class="form-row row">
        <div class="form-group col-md-3">
            <!-- <button type='button' class="btn btn-secondary" onclick="addAnswerInput('<?php $index?>');">Добавить поле для ответа</button> -->
        </div>
  </div>

  <button type="submit" class="btn btn-primary" name='Add'>Добавить</button>
</form>
</div>

<script type="text/javascript">
    function alarm(message){
        alert(message);
    }
</script>

<?php
    if(isset($_POST['Add']))
    {
        if(!isset($_POST['question']))
        {
            echo "<script type=\"text/javascript\"> alarm('Введите вопрос');</script>";
            return;
        }
        if(!isset($_POST['answer']))
        {
            echo "<script type=\"text/javascript\"> alarm('Введите ответы');</script>";
            return;
        }
        if(!isset($_POST['trueAnswer']))
        {
            echo "<script type=\"text/javascript\"> alarm('Выберете правильный ответ');</script>";
            return;
        }


        $filename = $_FILES['img']['name'];
        $path = "images/$filename";
        move_uploaded_file($_FILES['img']['tmp_name'],$path);


        foreach ($themes as $key => $value) {
            if($value['name'] == $_POST['theme'])
            {
                $theme = $value['id'];
            }
        }
        $ticket = $_POST['ticket'];
        $question = $_POST['question'];
        $image = $path;
        $trueAnswer = 1;    
        $answers = $_POST['answer'];


        $countQuestion = $db->FetchQuery("SELECT count(id) FROM questions WHERE `ticketId`='$ticket'");

        if ($countQuestion[0]['count(id)']>=20)
        {
            echo "<script type=\"text/javascript\"> alarm('Вопросов в билете уже 20');</script>";
            return;
        }

        $db->Query("INSERT INTO `questions`( `themeId`, `ticketId`, `text`, `rightAnswer`, `image`) VALUES ('$theme','$ticket','$question','$trueAnswer','$image')");

        $newQuestionId = $db->FetchQuery("SELECT id FROM questions WHERE `text`='$question'")[0]['id'];
        
        foreach ($answers as $key => $value) {
            $db->Query("INSERT INTO `answers`(`questionId`, `text`) VALUES ($newQuestionId,'$value')");
            if ($key==$_POST["trueAnswer['$key']"])
            {
                $newAnswerId = $db->FetchQuery("SELECT id FROM answers WHERE `text`='$value'")[0]['id'];
                $db->Query("UPDATE `questions` SET rightAnswer='$newAnswerId' WHERE id='$newQuestionId'"); 
            }
        }
    }
?>