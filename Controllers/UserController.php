
<?php

require_once __DIR__ . '/../Config/Database.php';

class UserController
{
    public function showUsers(array $currentUser)
    {
        global $pdo;


        $stmt = $pdo->prepare("
            SELECT id, username, email, mobile, birth_date, profile_picture
            FROM users
            WHERE id = :id
            LIMIT 1
        ");

        $stmt->execute([
            'id' => $currentUser['id']
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            http_response_code(404);
            exit('User not found.');
        }


        $errors = $_SESSION['profile_errors'] ?? [];
        $success = $_SESSION['profile_success'] ?? null;

        unset($_SESSION['profile_errors']);
        unset($_SESSION['profile_success']);


        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $csrfToken = $_SESSION['csrf_token'];

        require __DIR__ . '/../Views/users.php';
    }


    public function updateProfile(array $currentUser)
    {
        global $pdo;


        $submittedToken = $_POST['csrf_token'] ?? '';

        if (
            empty($_SESSION['csrf_token']) ||
            !is_string($submittedToken) ||
            !hash_equals($_SESSION['csrf_token'], $submittedToken)
        ) {
            http_response_code(403);
            exit('Invalid CSRF token.');
        }


        $userId = $currentUser['id'];
        $username = trim($_POST['username'] ?? '');
        $errors = [];


        if ($username === '') {
            $errors[] = 'نام کاربری نمی‌تواند خالی باشد.';
        } elseif (mb_strlen($username) > 50) {
            $errors[] = 'نام کاربری نباید بیشتر از ۵۰ کاراکتر باشد.';
        }


        if (empty($errors)) {
            $stmt = $pdo->prepare("
                SELECT id
                FROM users
                WHERE username = :username
                AND id != :user_id
                LIMIT 1
            ");

            $stmt->execute([
                'username' => $username,
                'user_id' => $userId
            ]);

            if ($stmt->fetch()) {
                $errors[] = 'این نام کاربری قبلاً استفاده شده است.';
            }
        }



        $newImagePath = null;
        $file = $_FILES['profile_picture'] ?? null;

        if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {


            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errors[] = 'آپلود عکس با خطا مواجه شد.';
            } elseif ($file['size'] > 2 * 1024 * 1024) {
                $errors[] = 'حجم عکس نباید بیشتر از ۲ مگابایت باشد.';
            } else {

                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->file($file['tmp_name']);

                $allowedTypes = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp'
                ];

                if (
                    $mimeType === false ||
                    !isset($allowedTypes[$mimeType]) ||
                    getimagesize($file['tmp_name']) === false
                ) {
                    $errors[] = 'فقط تصاویر معتبر JPG، PNG و WEBP مجاز هستند.';
                } else {
                    $imageExtension = $allowedTypes[$mimeType];
                }
            }
        }



        if (!empty($errors)) {
            $_SESSION['profile_errors'] = $errors;
            header('Location: /users');
            exit;
        }



        if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {

            $uploadDirectory = __DIR__ . '/../uploads/profiles/';

            if (!is_dir($uploadDirectory) || !is_writable($uploadDirectory)) {
                $_SESSION['profile_errors'] = [
                    'پوشه آپلود وجود ندارد یا قابل نوشتن نیست.'
                ];

                header('Location: /users');
                exit;
            }


            $fileName = bin2hex(random_bytes(16)) . '.' . $imageExtension;

            $destination = $uploadDirectory . $fileName;

            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                $_SESSION['profile_errors'] = [
                    'ذخیره عکس با خطا مواجه شد.'
                ];

                header('Location: /users');
                exit;
            }

            $newImagePath = 'uploads/profiles/' . $fileName;
        }


        try {

            $pdo->beginTransaction();


            $stmt = $pdo->prepare("
                SELECT profile_picture
                FROM users
                WHERE id = :id
            ");

            $stmt->execute([
                'id' => $userId
            ]);

            $oldImagePath = $stmt->fetchColumn();


            if ($newImagePath !== null) {
                $stmt = $pdo->prepare("
                    UPDATE users
                    SET username = :username,
                        profile_picture = :picture
                    WHERE id = :id
                ");

                $stmt->execute([
                    'username' => $username,
                    'picture' => $newImagePath,
                    'id' => $userId
                ]);
            } else {
                $stmt = $pdo->prepare("
                    UPDATE users
                    SET username = :username
                    WHERE id = :id
                ");

                $stmt->execute([
                    'username' => $username,
                    'id' => $userId
                ]);
            }


            $pdo->commit();



            if (
                $newImagePath !== null &&
                $oldImagePath &&
                str_starts_with($oldImagePath, 'uploads/profiles/')
            ) {
                $oldFile = __DIR__ . '/../' . $oldImagePath;

                if (is_file($oldFile)) {
                    unlink($oldFile);
                }
            }

            $_SESSION['profile_success'] = 'پروفایل با موفقیت به‌روزرسانی شد.';
        } catch (Throwable $e) {


            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }


            if ($newImagePath !== null) {
                $newFile = __DIR__ . '/../' . $newImagePath;

                if (is_file($newFile)) {
                    unlink($newFile);
                }
            }

            $_SESSION['profile_errors'] = [
                'به‌روزرسانی پروفایل با خطا مواجه شد. ممکن است نام کاربری قبلاً ثبت شده باشد.'
            ];
        }

        header('Location: /users');
        exit;
    }
}
