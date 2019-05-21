<!DOCTYPE html>
<html>
<head>
    <title>Coalition Test</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
</head>
<body>


<div class="container">
    <h2>Products</h2>


    <div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>

    <div id="product_form">
        <form>
            {{ csrf_field() }}
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="product_quantity">Quantity in stock:</label>
                <input type="text" id="product_quantity" name="product_quantity" class="form-control">
            </div>
            <div class="form-group">
                <label for="product_unit_price">Price per item:</label>
                <input type="text" id="product_unit_price" name="product_unit_price" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-success btn-submit">Submit</button>
            </div>
        </form>
    </div>

    <br><br>
    
    <div id="product_table">
        <table border="solid">
            <thead>
                <tr>
                    <th style="padding:3px">
                        Product name
                    </th>
                    <th style="padding:3px">
                        Quantity in stock
                    </th>
                    <th style="padding:3px">
                        Price per item
                    </th>
                    <th style="padding:3px">
                        Datetiem submitted
                    </th>
                    <th style="padding:3px">
                        Total value number
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td style="padding:3px">
                            {{ $product->product_name }}
                        </td>
                        <td style="padding:3px; text-align: right;">
                            {{ $product->product_quantity }}
                        </td>
                        <td style="padding:3px; text-align: right;">
                            {{ $product->product_unit_price }}
                        </td>
                        <td style="padding:3px">
                            {{ $product->datetime_submitted }}
                        </td>
                        <td style="padding:3px; text-align: right;">
                            {{ $product->total_value_number }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="padding:3px;">Sum total</td>
                    <td style="padding:3px; text-align: right;">{{ $sum_total_values }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>


<script type="text/javascript">


    $(document).ready(function() {
        $(".btn-submit").click(function(e){
            e.preventDefault();


            var _token = $("input[name='_token']").val();
            var product_name = $("input[name='product_name']").val();
            var product_quantity = $("input[name='product_quantity']").val();
            var product_unit_price = $("input[name='product_unit_price']").val();


            var res = $.ajax({
                url: "/products",
                type:'POST',
                data: {_token:_token, product_name:product_name, product_quantity:product_quantity, product_unit_price:product_unit_price},
                success: function(data) {
                    if($.isEmptyObject(data.error)){
                        alert(data.success);
                        location.reload();
                    }else{
                        printErrorMsg(data.error);
                    }
                }
            });

        }); 


        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
    });


</script>


</body>
</html>