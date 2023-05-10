<?php
function calculate_sum($num1, $num2) {
    return $num1 + $num2;
}

// Sử dụng hàm trong block NOWDOC
$number1 = 5;
$number2 = 10;
$sum = <<<'DELIMETER'
    <p>Tổng của <?php echo $number1 ?> và <?php echo $number2 ?> là: <?= calculate_sum($number1, $number2) ?></p>
DELIMETER;

echo $sum;
?>