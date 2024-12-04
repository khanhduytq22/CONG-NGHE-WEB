<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <!-- Thêm Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <?php require 'header.php'; ?>
        <a href="index.php?action=create" class="btn btn-primary mb-3">Thêm</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= number_format($product['price']) ?> VND</td>
                        <td>
                            <a href="#editProductModal" class="edit" data-toggle="modal" data-id="<?= $product['id'] ?>" data-name="<?= htmlspecialchars($product['name']) ?>" data-price="<?= $product['price'] ?>">
                                <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
                            </a>
                        </td>
                        <td>
                            <a href="#deleteProductModal" class="delete" data-toggle="modal" data-id="<?= $product['id'] ?>">
                                <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    <?php require 'edit_form.php';?>
    <?php require 'delete_form.php';?>
    <?php require 'footer.php'; ?>

    <!-- Thêm Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
    // Cập nhật modal sửa
    $('#editProductModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // nút đã được nhấn
        var productId = button.data('id');
        var productName = button.data('name');
        var productPrice = button.data('price');
        
        var modal = $(this);
        modal.find('#edit-id').val(productId);
        modal.find('#edit-name').val(productName);
        modal.find('#edit-price').val(productPrice);
    });

    // Cập nhật modal xóa
    $('#deleteProductModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // nút đã được nhấn
        var productId = button.data('id');
        
        var modal = $(this);
        modal.find('#delete-id').val(productId);
    });
</script>

</body>

</html>