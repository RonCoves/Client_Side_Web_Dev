<?php
require_once "../includes/init.php";

//PLAY
if(isset($_POST["play"])){
    $arr = ["rock", "paper", "scissor"];
    $computer_choice = $arr[array_rand($arr)];
    $user_choice = $_POST["play"];
  
    if($user_choice == $computer_choice){
      $won = "draw";
    }else{
      if($user_choice == "rock" && $computer_choice == "paper" || $computer_choice == "rock" && $user_choice == "scissor" || $computer_choice == "scissor" && $user_choice == "paper"){
        $won = "computer";
      }elseif($user_choice == "rock" && $computer_choice == "scissor" || $computer_choice == "rock" && $user_choice == "paper" || $user_choice == "scissor" && $computer_choice == "paper"){
        $won = "user";
      }
      add_point($won);
    }
}
?>
<script>
    function points(player){
        $.ajax({
            url: "ajax/points.php",
            type: "post",
            data: {player: player},
            success: function(data){
                $("#" + player + "Points").text(data);
            }
        })
    }
</script>
<?php
    if(isset($won)){
        if($won == "draw"){
    ?>
    <div class="card alert alert-warning text-center p-3 animate__animated animate__hinge">
        <h4>Game Drawn</h4>
        <div class="d-flex justify-content-center">
            <div>
                <span>You: <?php echo ucfirst($user_choice); ?></span>
            </div>
            <div>
                <span class="px-3">vs</span>
            </div>
            <div>
                <span>Computer: <?php echo ucfirst($computer_choice); ?></span>
            </div>
        </div>
    </div>
    <?php
        }else{
            if($won == "user"){
                $color = "success";
                $winner = $user_choice;
                $loser = $computer_choice;
                $text = "You Won!  <i class='far fa-thumbs-up'></i>";
                $point_inc = "You have";
                echo "<script>startConfetti();setTimeout(function(){ stopConfetti(); }, 2000); points('user');</script>";
            }else{
                $color = "danger";
                $winner = $computer_choice;
                $loser = $user_choice;
                $text = "Computer Won! <i class='far fa-thumbs-down'></i>";
                $point_inc = "Computer has";
                echo "<script>points('computer');</script>";
            }
    ?>
        <div class="card alert alert-<?php echo $color; ?> text-center p-3 animate__animated animate__bounceInDown">
            <h4 class="animate__animated animate__tada"><?php echo $text; ?></h4>
            <p><?php echo ucfirst($winner); ?> beats <?php echo ucfirst($loser); ?></p>
            <p style="font-size: 11px"><?php echo $point_inc; ?> got one point!</p>
        </div>
        <div class="d-flex justify-content-between">
            <div class="card alert alert-<?php echo $color; ?> text-center p-3 animate__animated animate__bounceInLeft">
                <span <?php if($won == "user"){ ?> class="animate__animated animate__heartBeat" style="animation-delay: 2s;" <?php } ?>>You: <?php echo ucfirst($user_choice); ?></span>
            </div>
            <div class="card alert alert-<?php echo $color; ?> text-center p-3">
                <span class="px-3">vs</span>
            </div>
            <div class="card alert alert-<?php echo $color; ?> text-center p-3 animate__animated animate__bounceInRight">
                <span <?php if($won == "computer"){ ?> class="animate__animated animate__heartBeat" style="animation-delay: 2s;" <?php } ?>>Computer: <?php echo ucfirst($computer_choice); ?></span>
            </div>
        </div>
    <?php
        }
    }
?>