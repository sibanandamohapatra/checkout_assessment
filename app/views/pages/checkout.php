<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
        <table id="cart" class="table table-hover table-condensed">
            <thead>
                <tr>
                    <th style="width:50%">Product</th>
                    <th style="width:10%">Quantity</th>
                    <th style="width:8%">Price</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                    $total_price = 0.00;
                    if(!empty($data["products"]) && isset($data["products"])){
                        foreach($data["products"] as $product){
                            $total_price = $total_price + (float)$product["price"];
                ?>
                <tr>
                    <td><?=$product["name"]?></td>
                    <td><?=$product["qnt"]?></td>
                    <td>$<?=$product["price"]?></td>
                </tr>
                <?php
                        }
                    }
                ?>
            </tbody>
            <tfoot>
                <tr class="visible-xs">
                    <td class="text-center"><strong>Total $<span class="total-price"><?=$total_price?></span></strong></td>
                </tr>
                <tr>
                    <td colspan="2" class="hidden-xs text-right"><strong>Total $</strong></td>
                    <td class="hidden-xs text-left"><strong><span class="total-price"><?=$total_price?></span></strong></td>
                </tr>
            </tfoot>
        </table>
        <div>
            <strong>SKUs Scanned:</strong>
            <?php
                if(!empty($data["products"]) && isset($data["products"])){
                    foreach($data["products"] as $key => $product){
                        for($i = 1; $i <= $product["qnt"]; $i++){
                            echo $key ." , ";
                        }
                    }
                }
            ?>
        </div>
        <div>
            <strong>Total expected: $<?=$total_price?></strong>
        </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>