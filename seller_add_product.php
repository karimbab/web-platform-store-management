<form class='card-body' action='./apis/shop.php' method='POST'>
    <div class='row'>
        <div class='col'>
            <div class='form-group'>
                <label for='name'>Name:</label>
                <input type='text' class='form-control' name='name' placeholder='e.g. Dell Insipron' required>
            </div>
        </div>
        <div class='col'>
            <div class='form-group'>
                <label for='color'>Colors:</label>
                <input type='text' class='form-control' name='color' placeholder='e.g. Blue,Black' required>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col'>
            <div class='form-group'>
                <label for='price'>Best Price (in ₹):</label>
                <input type='number' class='form-control' name='price' placeholder='1' required>
            </div>
        </div>
        <div class='col'>
            <div class='form-group'>
                <label for='category'>Category:</label>
                <select class='form-control' name='category_id' required>
                    <?php
                    include('./apis/config.php');
                    $read_product_categories = "SELECT * FROM product_categories ";
                    $response = mysqli_query($conn, $read_product_categories) or die(mysqli_error($conn));
                    $available_categories = mysqli_fetch_all($response, MYSQLI_ASSOC);
                    for ($i = 0; $i < mysqli_num_rows($response); $i++) {
                        $category_id = $available_categories[$i]['category_id'];
                        $category_name = $available_categories[$i]['category_name'];
                        echo "<option value=$category_id>$category_name</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col'>
            <div class='form-group'>
                <label for='price'>Availability Status:</label>
                <select class='form-control' name='stock' required>
                    <option value='1'>In Stock</option>
                    <option value='0'>Out of Stock</option>
                </select>
            </div>
        </div>
        <div class='col'>
            <div class='form-group'>
                <label for='quantity'>Quantity:</label>
                <input class='form-control' type="number" name="quantity" id="" placeholder="1" required>
            </div>
        </div>
    </div>

    <div class='form-group'>
        <label for='descr'>Description:</label>
        <textarea type='text' class='form-control' name='descr' rows='5' minlength="20" maxlength='300' placeholder='Provide short and clear description of the product.' required></textarea>
    </div>
    <div class='text-center'>
        <button type='submit' class='btn btn-outline-primary w-50' name='add'>ADD</button>
    </div>
</form>