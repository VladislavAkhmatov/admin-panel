<?php
$userMap = new UserMap();
$user = $userMap->findById($id);
$role = null;
if (isset($_GET['k'])) {
    $role = $_GET['k'];
}
?>
<div class="form-group">
    <label>Фамилия</label>
    <input type="text" class="form-control" name="lastname" required="required" value="<?= $user->lastname; ?>">
</div>
<div class="form-group">
    <label>Имя</label>
    <input type="text" class="form-control" name="firstname" required="required" value="<?= $user->firstname; ?>">
</div>
<div class="form-group">
    <label>Отчество</label>
    <input type="text" class="form-control" name="patronymic" value="<?= $user->patronymic; ?>">
</div>
<div class="form-group">
    <label>Пол</label>
    <select class="form-control" name="gender_id">
        <?= Helper::printSelectOptions(
            $user->gender_id,
            $userMap->arrGenders()
        ); ?>
    </select>
</div>
<div class="form-group">
    <label>Дата рождения</label>
    <input type="date" class="form-control" name="birthday" value="<?= $user->birthday; ?>" required>
</div>
<div class="form-group">
    <label>Номер</label>
    <input type="tel" class="form-control" name="login" pattern="8\d{10}" placeholder="8XXXXXXXXXX"
           required="required"
           value="<?= $user->login; ?>">
</div>
<div class="form-group">
    <label>Дополнительный номер</label>
    <input type="tel" class="form-control" name="additional_number" pattern="8\d{10}" placeholder="8XXXXXXXXXX"
           required="required"
           value="<?= $user->additional_number; ?>">
</div>
<?php if ($role != 'student' && $role != 'teacher' && $role != 'parent'): ?>
    <div class="form-group">
        <label>Пароль</label>
        <input type="password" class="form-control" name="password">
    </div>
<?php endif; ?>
<input type="hidden" name="user_id" value="<?= $id; ?>"/>