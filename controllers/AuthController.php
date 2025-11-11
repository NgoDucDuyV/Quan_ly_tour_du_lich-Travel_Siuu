<?php
class AuthController
{
    public function showformSigninAdmin()
    {
        require_once "./views/Admin/signin.php";
    }

    public function signin($requestData)
    {
        header('Content-Type: application/json');
        if (
            $requestData['email'] == ''
            || $requestData['password'] == ''
        ) {
            $_SESSION['errorlogin'] = "Mời Nhập Tất Cả Các Trường Thông Tin !";
            header('Location:' . BASE_URL . '?mode=client&act=showfromlogin');
            exit;
        }

        $email = trim($requestData['email']);
        $password = trim($requestData['password']);

        $datauser = (new AuthModel())->getAllUser();
        // check emil
        $checkEmail = false;
        foreach ($datauser as $value) {
            if ($value['email'] == $email) {
                $checkEmail = true;
                break;
            }
        }
        if (!$checkEmail) {
            echo json_encode([
                'success' => false,
                'errorsignin' => "Email Không Tồn Tại or Lỗi Đăng Nhập!"
            ]);
            exit();
        }
        // check pasword
        $checkPassword = false;
        foreach ($datauser as $value) {
            if ($value['email'] == $email && $value['password'] == $password) {
                $checkPassword = true;
                break;
            }
        }
        if (!$checkPassword) {
            echo json_encode([
                'success' => false,
                'errorsignin' => "Email or Password Không Đúng or Lỗi Đăng Nhập!"
            ]);
            exit();
        }

        $auth = (new AuthModel())->signin($email, $password);

        $_SESSION['admin_role'] = $auth['role'];
        $_SESSION['admin_logged'] = $auth;

        echo json_encode([
            'success' => true,
            'redirect' => BASE_URL . '?mode=admin&act=dashboard',
            'errorsignin' => "Đăng Nhập Thành Công! Chuyển Hướng...",
            'datauser' => $auth
        ]);
        exit;
        // header("Location: " . BASE_URL . "?mode=admin&act=dashboard");
    }

    public function logout()
    {
        // Xử lý đăng xuất
        session_destroy();
        header("Location: index.php?mode=auth&act=showFormLogin");
        exit;
    }
}
