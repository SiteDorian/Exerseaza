<p>
    <?php
    if (isset($html)) echo $html;
    ?>
</p>

<h3>Products list: (sorting)</h3>

<?php
if (isset($data)) foreach ($data->data as $item) echo "<p>".$item["name"]."</p>";
?>