<?php
require_once 'secure.php';
require_once 'template/header.php';

// Initialize branch from GET or session
if (isset($_GET['id'])) {
    $_SESSION['branch'] = (int)$_GET['id'];
}
$id = $_SESSION['branch'];

// Load data
$userMap = new UserMap();
$branch = $userMap->findBranchById($id);
$branchWithoutCurrent = (new BranchMap())->arrBranchWithoutCurrent();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $branch->name ?? 'Главная' ?> | Образовательный портал</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <?php if (Helper::can('admin') || Helper::can('owner')): ?>
            <!-- Admin/Owner Dashboard -->
            <div class="dashboard-header">
                <h1 class="dashboard-title">
                    <?= isset($_GET['message']) ? '<span class="error-message">Неверный формат файла</span>' : htmlspecialchars($branch->name) ?>
                </h1>
                <p class="dashboard-subtitle">Дата основания: <span class="highlight"><?= $branch->date_founding ?></span></p>
                
                <?php if (Helper::can('owner')): ?>
                    <div class="branch-selector">
                        <p class="selector-title">Выберите филиал:</p>
                        <form id="branchSelectForm" class="branch-form">
                            <div class="branch-buttons">
                                <?php foreach ($branchWithoutCurrent as $item): ?>
                                    <button type="button" class="branch-button" onclick="submitBranch(<?= $item->id ?>)">
                                        <?= htmlspecialchars($item->value) ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" id="selectedId" name="id">
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <div class="stats-grid">
                <a href="list/list-teacher" class="stat-card teacher-card">
                    <div class="card-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="card-content">
                        <h3>Учителей</h3>
                        <p class="stat-value"><?= $userMap->teacherCount()->count ?></p>
                    </div>
                </a>

                <a href="list/list-student" class="stat-card student-card">
                    <div class="card-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="card-content">
                        <h3>Учеников</h3>
                        <p class="stat-value"><?= $userMap->studentCount()->count ?></p>
                    </div>
                </a>

                <a href="list/list-parent" class="stat-card parent-card">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-content">
                        <h3>Родителей</h3>
                        <p class="stat-value"><?= $userMap->parentCount()->count ?></p>
                    </div>
                </a>
            </div>

        <?php elseif (Helper::can('teacher')): ?>
            <!-- Teacher Dashboard -->
            <div class="dashboard-header">
                <h1 class="dashboard-title">Панель преподавателя</h1>
                <p class="dashboard-subtitle">Филиал: <span class="highlight"><?= htmlspecialchars($branch->name) ?></span></p>
            </div>

            <div class="action-buttons">
                <a href="/check/check-teacher-schedule" class="action-button primary">
                    <i class="fas fa-calendar-alt"></i> Расписание
                </a>
                <a href="/select-schedule" class="action-button secondary">
                    <i class="fas fa-edit"></i> Выставить оценки
                </a>
            </div>

        <?php elseif (Helper::can('procreator')): ?>
            <!-- Parent Dashboard -->
            <?php $students = (new StudentMap())->findStudentsFromParent(); ?>
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Панель родителя</h1>
                <p class="dashboard-subtitle">Ваши дети</p>
            </div>

            <div class="student-list">
                <?php if ($students): ?>
                    <div class="list-header">
                        <h3>Список детей</h3>
                    </div>
                    <div class="list-items">
                        <?php foreach ($students as $student): ?>
                            <a href="check/check-child?id=<?= $student->user_id ?>" class="student-item">
                                <i class="fas fa-child"></i>
                                <span><?= htmlspecialchars($student->fio) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-user-slash"></i>
                        <p>Нет привязанных студентов</p>
                    </div>
                <?php endif; ?>
            </div>

        <?php elseif (Helper::can('student')): ?>
            <!-- Student Dashboard -->
            <div class="dashboard-header">
                <h1 class="dashboard-title">Личный кабинет</h1>
                <p class="dashboard-subtitle">Филиал: <span class="highlight"><?= htmlspecialchars($branch->name) ?></span></p>
            </div>

            <div class="action-buttons">
                <a href="/check/check-grades?id=<?= $_SESSION['id'] ?>" class="action-button primary">
                    <i class="fas fa-star"></i> Мои оценки
                </a>
                <a href="/check/check-student-schedule?id=<?= $_SESSION['id'] ?>" class="action-button secondary">
                    <i class="fas fa-calendar-week"></i> Расписание
                </a>
                <a href="/check/check-balance?id=<?= $_SESSION['id'] ?>" class="action-button accent">
                    <i class="fas fa-coins"></i> Баланс уроков
                </a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function submitBranch(id) {
            document.getElementById('selectedId').value = id;
            document.getElementById('branchSelectForm').submit();
        }
    </script>

    <?php require_once 'template/footer.php'; ?>
</body>
</html>