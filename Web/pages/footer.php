<?php 
foreach ($_REQUEST as $key => $value) {
    echo "<input type='hidden' name='DATA-FROM' value='{$value}' id='{$key}'/>";
} 
?>
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
    <b>Version</b> Alpha 0.1
    </div>
    <strong>Copyright &copy; 2019-2019 <a href="https://wnjxyk.keji.moe">WNJXYK</a>.</strong> All rights
    reserved.
</footer>