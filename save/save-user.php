<?php
require_once '../secure.php';

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
                header('Location: ../add/add-teacher?q=err');
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
                header('Location: ../add/add-parent?q=err');
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
                header('Location: ../add/add-student?q=err');
            }
        }
        exit();
    }

    if (isset($_POST['saveowner'])) {
        $owner = new owner();
        $owner->branch_id = Helper::clearInt($_POST['branch_id']);
        $owner->user_id = $user->user_id;
        $user->role_id = Helper::clearInt(2);
        if ((new ownerMap())->save($user, $owner)) {
            header('Location: ../profile/profile-owner?id=' . $owner->user_id);
        } else {
            if ($owner->user_id) {
                header('Location: ../profile/profile-owner?id=' . $owner->user_id);
            } else {
                header('Location: ../add/add-owner?q=err');
            }
        }
        exit();
    }

    if (isset($_POST['saveadmin'])) {
        $admin = new Admin();
        $admin->branch_id = Helper::clearInt($_SESSION['branch']);
        $admin->user_id = $user->user_id;
        $user->role_id = Helper::clearInt(3);

        if ((new AdminMap())->save($user, $admin)) {
            header('Location: ../profile/profile-admin?id=' . $admin->user_id);
        } else {
            if ($admin->user_id) {
                header('Location: ../profile/profile-admin?id=' . $admin->user_id);

            } else {
                header('Location: ../add/add-admin?q=err');
            }
        }
        exit();
    }
}