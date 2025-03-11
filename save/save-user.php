<?php
require_once '../secure.php';

if (isset($_POST['saveAvatarStudent'])) {
    $user = new User();
    $user->user_id = Helper::clearInt($_POST['saveAvatarStudent']);

    $types = array(
        '.jpg',
        '.JPG',
        '.jpeg',
        '.gif',
        '.bmp',
        '.png'
    );

    $user->photo = time() . '_' . $_FILES["photo"]["name"];
    $fileTmpName = $_FILES["photo"]["tmp_name"];

    $ext = strtolower(substr($_FILES["photo"]["name"], strrpos($_FILES["photo"]["name"], '.')));
    if (!in_array($ext, $types)) {
        header('Location: ../index?message=Err');
        exit;
    }
    move_uploaded_file($fileTmpName, "../avatars/" . $user->photo);

    if ($_SESSION['role'] == 'procreator') {
        if ((new UserMap())->updatePhoto($user)) {
            $_SESSION['photo'] = $user->photo;
            header('Location: ../profile/profile-student?id=' . $user->user_id);
            exit;
        }
    }

    if ($_SESSION['role'] == 'admin') {
        if ((new UserMap())->updatePhoto($user)) {
            $_SESSION['photo'] = $user->photo;
            header('Location: ../profile/profile-manager?id=' . $user->user_id);
            exit;
        }
    }

    if ($_SESSION['role'] == 'teacher') {
        if ((new UserMap())->updatePhoto($user)) {
            $_SESSION['photo'] = $user->photo;
            header('Location: ../profile/profile-teacher?id=' . $user->user_id);
            exit;
        }
    }

    if ($_SESSION['role'] == 'manager') {

        if ((new UserMap())->updatePhoto($user)) {
            $_SESSION['photo'] = $user->photo;
            header('Location: ../profile/profile-manager?id=' . $user->user_id);
            exit;
        }
    }
}

if (isset($_POST['user_id'])) {
    $user = new User();
    $user->lastname = Helper::clearString($_POST['lastname']);
    $user->user_id = Helper::clearInt($_POST['user_id']);
    $user->firstname = Helper::clearString($_POST['firstname']);
    $user->patronymic = Helper::clearString($_POST['patronymic']);
    $user->birthday = Helper::clearString($_POST['birthday']);
    $user->login = Helper::clearString($_POST['login']);
    $user->pass = password_hash(
        Helper::clearString($_POST['password']),
        PASSWORD_BCRYPT
    );
    $user->gender_id = Helper::clearInt($_POST['gender_id']);
    $user->branch_id = $_SESSION['branch'];
    $user->active = Helper::clearInt($_POST['active']);



    if (isset($_POST['saveTeacher'])) {
        $teacher = new Teacher();
        $teacher->user_id = $user->user_id;
        if ($_POST['award'] != NULL) {
            $teacher->award_subject_id = Helper::clearInt($_POST['subject_id']);
            $teacher->award = Helper::clearString($_POST['award']);
        }
        $user->role_id = Helper::clearInt(4);
        if ((new TeacherMap())->save($user, $teacher)) {

            header('Location: ../profile/profile-teacher?id=' . $teacher->user_id);

        } else {
            if ($teacher->user_id) {

                header('Location: ../profile/profile-teacher?id=' . $teacher->user_id);

            } else {
                header('Location: ../profile/profile-teacher');
            }
        }
        exit();
    }




    if (isset($_POST['saveParent'])) {
        $parent = new Procreator();
        $parent->user_id = $user->user_id;
        $user->role_id = Helper::clearInt(6);
        if ((new ProcreatorMap())->save($user, $parent)) {

            header('Location: ../profile/profile-parent?id=' . $parent->user_id);

        } else {
            if ($parent->user_id) {

                header('Location: ../profile/profile-parent?id=' . $parent->user_id);

            } else {
                header('Location: ../profile/profile-parent');
            }
        }
        exit();
    }

    if (isset($_POST['saveStudent'])) {
        $student = new Student();
        $student->gruppa_id = Helper::clearInt($_POST['gruppa_id']);
        $student->user_id = $user->user_id;
        $user->role_id = Helper::clearInt(5);

        if ((new StudentMap())->save($user, $student)) {

            header('Location: ../profile/profile-student?id=' . $student->user_id);

        } else {
            if ($student->user_id) {

                header('Location: ../profile/profile-student?id=' . $student->user_id);

            } else {
                header('Location: ../profile/profile-student');
            }
        }
        exit();
    }

    if (isset($_POST['saveAdmin'])) {
        $admin = new Admin();
        $admin->branch_id = Helper::clearInt($_POST['branch_id']);
        $admin->user_id = $user->user_id;
        $user->role_id = Helper::clearInt(2);
        if ((new AdminMap())->save($user, $admin)) {

            header('Location: ../profile/profile-admin?id=' . $admin->user_id);

        } else {
            if ($admin->user_id) {

                header('Location: ../profile/profile-admin?id=' . $admin->user_id);

            } else {
                header('Location: ../profile/profile-admin');
            }
        }
        exit();
    }

    if (isset($_POST['saveManager'])) {
        $manager = new Manager();
        $manager->branch_id = Helper::clearInt($_SESSION['branch']);
        $manager->user_id = $user->user_id;
        $user->role_id = Helper::clearInt(3);
        if ((new ManagerMap())->save($user, $manager)) {
            header('Location: ../profile/profile-manager?id=' . $manager->user_id);

        } else {
            if ($manager->user_id) {

                header('Location: ../profile/profile-manager?id=' . $manager->user_id);

            } else {
                header('Location: ../profile/profile-manager');
            }
        }
        exit();
    }
}