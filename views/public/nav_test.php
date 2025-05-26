<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VelloStore - Receipt</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
  <style>
    #receipt {
      width: 320px;
      padding: 20px;
      background: linear-gradient(to right, #ff8828, #e04204);
      color: #000;
      font-family: 'Segoe UI', sans-serif;
      box-shadow: 0 0 10px rgba(0,0,0,0.15);
    }
    #receipt img {
      height: 80px;
    }
    #receipt table {
      border-radius: 15px;
    }

    #receipt table th,
    #receipt table td {
      background-color: #20b5ff; 
      color:rgb(255, 255, 255);
    }

    .tablerounededCorner {
        border: 1px solidrgb(110, 231, 231);
        background-color: #ddd;
        border-radius: 1.2em;
    }

    .roundedTable {
        border-collapse: collapse;
        border-radius: 1.2em;
        overflow: hidden;
        width: 100%;
        margin: 0;
    }

    .roundedTable th,
    .roundedTable td {
        padding: .6em;
        background: #ddd;
        border-bottom: 1px solid white;
    }

    .roundedTable th {
        text-align: left;
    }

    .roundedTable tr:last-child td {
        border-bottom: none;
    }


  </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
  <div>
    <button class="btn btn-primary mb-4" onclick="generateReceipt()">Buy Now</button>
    <div id="receipt" class="tablerounededCorner">
      <div class="text-center mb-3">
        <img src="uploads/logos/Logo_2.png" alt="VelloStore Logo">
      </div>
      <table class="table table-sm roundedTable">
        <tbody>
          <tr><th>Product Name</th><td id="productName">Wireless Mouse</td></tr>
          <tr><th>Category</th><td id="productCategory">Accessories</td></tr>
          <tr><th>Description</th><td id="productDescription">Ergonomic 2.4GHz wireless mouse</td></tr>
          <tr><th>Price</th><td id="productPrice">$29.99</td></tr>
          <tr><th>Quantity</th><td id="productQuantity">2</td></tr>
          <tr><th>Total</th><td id="totalPrice">$59.98</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function generateReceipt() {
      const receipt = document.getElementById('receipt');
      html2canvas(receipt).then(canvas => {
        const link = document.createElement('a');
        link.download = 'VelloStore_Receipt.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
      });
    }
  </script>
</body>
</html>
