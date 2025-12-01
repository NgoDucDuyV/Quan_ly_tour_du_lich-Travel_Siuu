<?php 
// Đảm bảo các biến sau đã được truyền từ BookingController::showFormAddNewTour():
// $dataDestination, $dataActivities, $dataTypeodtouar, $dataDifficulty, $dataCategories_destinationModel

// Nếu chưa định nghĩa, đặt giá trị mặc định để tránh lỗi PHP
$dataDestination = $dataDestination ?? [];
$dataTypeodtouar = $dataTypeodtouar ?? [];
$dataDifficulty = $dataDifficulty ?? [];

// Dữ liệu mẫu cho các select box khác nếu Model chưa có
$dataActivities = $dataDestination; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tour Mới</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/layout.css">
    <link rel="stylesheet" href="public/css/quanlytour.css">
</head>
<body>

    <div class="container">
        <?php if (isset($_SESSION['errorInsertTouar'])): ?>
            <div class="alert alert-danger" style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 15px;">
                <?= $_SESSION['errorInsertTouar']; unset($_SESSION['errorInsertTouar']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['successInsertTouar'])): ?>
            <div class="alert alert-success" style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 15px;">
                <?= $_SESSION['successInsertTouar']; unset($_SESSION['successInsertTouar']); ?>
            </div>
        <?php endif; ?>

        <header class="header_breadcrumb">
            <div class="breadcrumb">
                <a href="<?= BASE_URL ?>?mode=admin&act=dashboard">Admin</a> /
                <a href="<?= BASE_URL ?>?mode=admin&act=booking">Quản lý Tour</a> / 
                <span>Thêm Tour Mới</span>
            </div>
        </header>

        <header class="header_edit_tour">
            <a href="<?= BASE_URL ?>?mode=admin&act=quanlyTouarHoatDong" class="back-icon"><i class="fa fa-chevron-left"></i></a>
            <h1 class="page-title">Thêm Tour Mới</h1>
        </header>

        <form action="<?= BASE_URL ?>?mode=admin&act=ThemTourMoi" method="post" enctype="multipart/form-data" class="tour-form">
            
            <div class="form-group">
                <label for="title">Tiêu Đề Tour</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Nhập Tiêu Đề Tour" required>
            </div>

            <div class="form-group">
                <label for="destination_id">Điểm Đến/Danh Mục</label>
                <select id="destination_id" name="destination_id" class="form-control" required>
                    <option value="">-- Chọn Điểm Đến --</option>
                    <?php 
                    // Lặp qua dữ liệu danh mục từ Model
                    foreach ($dataDestination as $dest): 
                        // Giả định đối tượng có thuộc tính id và name hoặc title
                        $id = $dest->id ?? $dest->category_id;
                        $name = $dest->name ?? $dest->title ?? $dest->category_name;
                    ?>
                        <option value="<?= htmlspecialchars($id) ?>">
                            <?= htmlspecialchars($name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="time_days">Thời Gian (Số Ngày)</label>
                <input type="number" id="time_days" name="time_days" class="form-control" placeholder="Ví dụ: 3 (ngày)" required min="1">
            </div>
            
            <div class="form-group">
                <label for="price">Giá Tour (VNĐ)</label>
                <input type="number" id="price" name="price" class="form-control" placeholder="Ví dụ: 5000000" required min="0">
            </div>

            <div class="form-group">
                <label for="image">Ảnh Đại Diện</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="description">Mô Tả Tour</label>
                <textarea id="description" name="description" class="form-control" rows="5" placeholder="Nhập mô tả chi tiết về tour..."></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Thêm Tour</button>
        </form>
    </div>

</body>
</html>