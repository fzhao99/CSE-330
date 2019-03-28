<!DOCTYPE html>
<html lang="en">
<head><title>Calculator</title></head>
<body>


<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="GET">
    <p>
            <input type="radio" name="operation" value="add" id="add" /> <label for="add">Add</label> &nbsp;
            <input type="radio" name="operation" value="subtract" id="subtract" /> <label for="subtract">Subtract</label>
            <input type="radio" name="operation" value="multiply" id="multiply" /> <label for="multiply">Multiply</label> &nbsp;
            <input type="radio" name="operation" value="divide" id="divide" /> <label for="divide">Divide</label>
    
            <p>
		<label for="var1input">Value 1:</label>
		<input type="number" step ="any"  name="var1" id="var1input" value="<?php if(isset($_GET['var1'])){echo htmlentities($_GET['var1']);}?>"/>
		<label for="var2input">Value 2:</label>
		<input type="number" step ="any" name="var2" id="var2input" value="<?php if(isset($_GET['var2'])){echo htmlentities($_GET['var2']);}?>" />

	</p>
    
    <p>
		<input type="submit" value="Calculate" />
        <input type="reset">

	</p>

</form>



<?php


function add($x,$y){
    return $x+$y;
}

function multiply($x,$y){
    return $x*$y;
}

function subtract($x,$y){
    return $x-$y;
}

function divide($x,$y){
    if($y==0){
        return null;
    }
    else{
        return $x/ (float) $y;
    }
}


if(isset($_GET['var1'], $_GET['var2'],$_GET['operation'])){
    $selectedOp = $_GET['operation'];
    $var1 = $_GET['var1'];
    $var2 = $_GET['var2'];
    
    if($selectedOp == "add"){
        printf( "The answer to %d plus %d is: %d", $var1, $var2,htmlentities(add($var1,$var2)));
    }
    if($selectedOp == "subtract"){
        printf("The answer to %d minus %d is: %d", $var1, $var2,htmlentities(subtract($var1,$var2)));
    }
    if($selectedOp == "multiply"){
        printf("The answer to %d times %d is: %d", $var1, $var2,htmlentities(multiply($var1,$var2)));
    }
    if($selectedOp == "divide"){
        if($var2 != 0){
            printf("The answer to %d divided by %d is: %f", $var1, $var2,htmlentities(divide($var1,$var2)));
        }
        else{
            printf("Divide by zero error. Please change the value of Value 2 to a non-zero number");
        }
    }
}

?>


</body>
</html>