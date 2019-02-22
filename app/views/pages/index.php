<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <form action="<?=URLROOT?>/pages/index" method="POST">
        <table id="cart" class="table table-hover table-condensed">
            <thead>
                <tr>
                    <th style="width:50%">Product</th>
                    <th style="width:10%">Price</th>
                    <th style="width:8%">Quantity</th>
                    <th style="width:22%" class="text-center">Subtotal</th>
                    <th style="width:10%"></th>
                </tr>
            </thead>
            <tbody>
                
                <?php 
                    if(!empty($data["products"]) && isset($data["products"])){
                        foreach($data["products"] as $product){
                ?>
                <tr>
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-2 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                            <div class="col-sm-10">
                                <h4 class="nomargin"><?=$product->name?></h4>
                                <?php if($product->SKU == "atv"){ ?>
                                <p>We're going to have a 3 for 2 deal on Apple TVs. For example, if you buy 3 units of.Apple TVs, you will only pay for the price of 2 units.</p>
                                <?php } else if($product->SKU == "ipd"){ ?>
                                <p>The brand new Super iPad will have a bulk discount applied, where the price will drop to $499.99 each, if someone buys more than 4 units.</p>
                                <?php } else if($product->SKU == "mbp"){ ?>
                                <p>We will bundle in a VGA adapter free of charge with every MacBook Pro sold.</p>
                                <?php } ?>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">$<?=$product->price?></td>
                    <td data-th="Quantity">
                        <input type="text" class="form-control text-center quantity" data-price=<?=$product->price?> value="0" data-product="<?=$product->id?>" data-productname="<?=$product->SKU?>" name="quantity[<?=$product->SKU?>]" onkeypress="return isNumberKey(event,this.value);">
                    </td>
                    <td data-th="Subtotal" class="text-center net-price" id="net-price-<?=$product->id?>">0.00</td>
                    <td></td>
                </tr>
                <?php
                        }
                    }
                ?>
            </tbody>
            <tfoot>
                <tr class="visible-xs">
                    <td class="text-center"><strong>Total $<span class="total-price">0.00</span></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" class="hidden-xs"></td>
                    <td class="hidden-xs text-center"><strong>Total $<span class="total-price">0.00</span></strong></td>
                    <td>
                    <button class="btn btn-success btn-block" type="submit">Checkout <i class="fa fa-angle-right"></i></button></td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
<script>
    function isNumberKey(evt){
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $(".quantity").keyup(function(){
        var qnt = parseInt($(this).val());
        var product_id = $(this).attr("data-product");
        var price = parseFloat($(this).attr("data-price"));
        var pr_name = $(this).attr("data-productname");
        var vga_qnt = ($('*[data-product="4"]').val() != "")?parseInt($('*[data-product="4"]').val()):0;
        var mbp_qnt = ($('*[data-product="2"]').val() != "")?parseInt($('*[data-product="2"]').val()):0;
        var new_vga_qnt = 0;
        if(pr_name != "" && qnt != "" && qnt > 0){ 
            var net_price = qnt * price;
            if(pr_name == "ipd" && qnt > 4){
                net_price = net_price - 499.99;
            }
            if(pr_name == "atv"){
                net_price = net_price - (parseInt(qnt / 3) * price);
            }
            if(pr_name == "mbp"){
                if(mbp_qnt > vga_qnt || mbp_qnt == vga_qnt){
                    new_vga_qnt = 0;
                }
                else if(mbp_qnt < vga_qnt){
                    new_vga_qnt = vga_qnt - mbp_qnt;
                }
                console.log(new_vga_qnt);
                var vga_price = new_vga_qnt * parseFloat($('*[data-product="4"]').attr("data-price"));
                //console.log(vga_price);
                $("#net-price-4").text(vga_price.toFixed(2));
            }
            if(pr_name == "vga"){
                if(mbp_qnt > vga_qnt || mbp_qnt == vga_qnt){
                    qnt = 0;
                }
                else if(mbp_qnt < vga_qnt){
                    qnt = vga_qnt - mbp_qnt;
                }
                net_price = qnt * price;
            }

            
            $("#net-price-" + product_id).text(net_price.toFixed(2));
        }
        else{
            $("#net-price-" + product_id).text('0.00');
        }

        var totalprice = 0.00;
        $('.net-price').each(function(){
            totalprice += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
        });
        $('.total-price').text(totalprice.toFixed(2));
    });

</script>
