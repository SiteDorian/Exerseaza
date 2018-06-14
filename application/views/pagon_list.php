<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
</head>
<body>
<h1>Lista paginilor cu produse</h1>

<div class="w3ls_mobiles_grid_right_grid2_right">
    <select name="select_item" class="select_item" onchange="sorting(this);">
        <option <?php if ($sort==0) echo 'selected="selected"';?> value="0">Default sorting</option>
        <option <?php if ($sort==1) echo 'selected="selected"';?> value="1">Sort by popularity</option>
        <option <?php if ($sort==2) echo 'selected="selected"';?> value="2">Sort by average rating</option>
        <option <?php if ($sort==3) echo 'selected="selected"';?> value="3">Sort by newness</option>
        <option <?php if ($sort==4) echo 'selected="selected"';?> value="4">Sort by price: low to high</option>
        <option <?php if ($sort==5) echo 'selected="selected"';?> value="5">Sort by price: high to low</option>
    </select>
</div>

<div id="here">
    <p>
        <?php
        if (isset($html)) echo $html;
        ?>
    </p>

    <h3>Products list:</h3>

    <?php
    if (isset($data)) foreach ($data->data as $item) echo "<p>".$item["name"]."</p>";
    ?>
</div>

<script>
    function sorting(_this) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url();?>products/ajaxTestSortingProduct",
            data: {sort: $(_this).val(), category: '<?php echo $category; ?>'},
            dataType: 'JSON'
        })
            .done(function (reseponse) {
                console.log(reseponse.html);

                if (reseponse.success) {
                    //$('#here').html(reseponse.html);
                    window.location.replace('<?php echo site_url("products/ceva/$category/1"); ?>');

                }
            });

    }
</script>

</body>
</html>