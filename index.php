<?php
require_once 'secure.php';
require_once 'template/header.php';

if (isset($_GET['id'])) {
    $_SESSION['branch'] = (int)$_GET['id'];
}
$id = $_SESSION['branch'];

$userMap = new UserMap();
$branch = $userMap->findBranchById($id);
$branchWithoutCurrent = (new BranchMap())->arrBranchWithoutCurrent();
$percentOfAttendanceByBranches = (new GradeMap())->percentOfAttendanceByBranches();
$countOfAttendanceByBranches = count($percentOfAttendanceByBranches);
$subjects = (new SubjectMap())->arrSubjects();

$b1 = 0;
foreach ($percentOfAttendanceByBranches as $item) {
    if ($item->attend == 1) {
        $b1++;
    }
}
$percent1 = ($b1 / $countOfAttendanceByBranches) * 100;

$subject = null;
$subject_id = $_GET['subject'] ?? 0;
if ($subject_id) {
    $subject = (new SubjectMap())->findById($subject_id);
    $percentOfAttendanceBySubject = (new GradeMap())->percentOfAttendanceBySubject($subject_id);
    $b2 = 0;
    $countOfAttendanceBySubject = count($percentOfAttendanceBySubject);
    foreach ($percentOfAttendanceBySubject as $item) {
        if ($item->attend == 1) {
            $b2++;
        }
    }
    if ($countOfAttendanceBySubject > 0) {
        $percent2 = ($b2 / $countOfAttendanceBySubject) * 100;
    }
}

// Данные для графика
$labels = ['1', '2', '3', '4'];
if ($subject) {
    // Пример — данные по предмету
    $values = [70, 80, 85, (int)$percent2];
} else {
    // Пример — общая динамика по филиалу
    $values = [60, 75, 85, (int)$percent1];
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $branch->name ?? 'Главная' ?> | Образовательный портал</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="dashboard-container">

    <?php if (Helper::can('admin') || Helper::can('owner')): ?>
        <div class="dashboard-header">
            <h1 class="dashboard-title">
                <?= isset($_GET['message']) ? '<span class="error-message">Неверный формат файла</span>' : htmlspecialchars($branch->name) ?>
            </h1>
            <p class="dashboard-subtitle">Дата основания: <span
                        class="highlight"><?= Helper::formattedData($branch->date_founding) ?></span></p>

            <?php if (Helper::can('owner')): ?>
                <div class="branch-selector">
                    <p class="selector-title">Выберите филиал:</p>
                    <form id="branchSelectForm" class="branch-form">
                        <div class="branch-buttons">
                            <?php foreach ($branchWithoutCurrent as $item): ?>
                                <button type="button" class="branch-button"
                                        onclick="submitBranchWithSubject(<?= $item->id ?>)">
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
                <div class="card-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="card-content">
                    <h3>Учителей</h3>
                    <p class="stat-value"><?= $userMap->teacherCount()->count ?></p>
                </div>
            </a>
            <a href="list/list-student" class="stat-card student-card">
                <div class="card-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="card-content">
                    <h3>Учеников</h3>
                    <p class="stat-value"><?= $userMap->studentCount()->count ?></p>
                </div>
            </a>
            <a href="list/list-parent" class="stat-card parent-card">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <div class="card-content">
                    <h3>Родителей</h3>
                    <p class="stat-value"><?= $userMap->parentCount()->count ?></p>
                </div>
            </a>
        </div>

        <div class="attendance-dashboard-grid">
            <!-- Левая карточка -->
            <div class="attendance-card-left">
                <p class="attendance-branch"><strong>Филиал:</strong> <?= htmlspecialchars($_SESSION['branch_name']) ?>
                </p>
                <form method="get" class="attendance-subject-form">
                    <input type="hidden" name="id" value="<?= (int)$id ?>">
                    <label for="subject">Выберите предмет:</label>
                    <select class="form-control" name="subject" id="subject">
                        <?php Helper::printSelectOptions($subject_id, $subjects); ?>
                    </select>
                    <button class="btn btn-primary" type="submit">Показать</button>
                </form>

                <?php if ($subject): ?>
                    <p class="attendance-subject">
                        Процент посещаемости учеников по предмету <strong><?= $subject->name ?></strong>:
                        <span class="attendance-percent"><?= (int)$percent2 ?>%</span>
                    </p>

                    <div style="width: 120px; height: 120px; margin: 0 auto;">
                        <canvas id="subjectDonutChart" width="120" height="120"></canvas>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const donutCtx = document.getElementById('subjectDonutChart').getContext('2d');
                        new Chart(donutCtx, {
                            type: 'doughnut',
                            data: {
                                labels: ['Посещаемость', 'Пропуски'],
                                datasets: [{
                                    data: [<?= (int)$percent2 ?>, <?= 100 - (int)$percent2 ?>],
                                    backgroundColor: ['#4caf50', '#e0e0e0'],
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                cutout: '75%',
                                responsive: false,
                                plugins: {
                                    legend: {display: false},
                                    tooltip: {enabled: false}
                                }
                            },
                            plugins: [{
                                id: 'centerText',
                                beforeDraw(chart) {
                                    const {width, height, ctx} = chart;
                                    ctx.restore();
                                    ctx.font = "bold 14px sans-serif";
                                    ctx.textBaseline = "middle";
                                    ctx.fillStyle = "#333";
                                    const text = "<?= (int)$percent2 ?>%";
                                    const textX = Math.round((width - ctx.measureText(text).width) / 2);
                                    const textY = height / 2;
                                    ctx.fillText(text, textX, textY);
                                    ctx.save();
                                }
                            }]
                        });
                    </script>
                <?php endif; ?>

            </div>

            <!-- Правая карточка -->
            <div class="attendance-card-right">
                <p class="attendance-percent"><strong>Общая посещаемость:</strong> <?= (int)$percent1 ?>%</p>
                <canvas id="attendanceChart" height="100"></canvas>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php if (Helper::can('teacher')): ?>
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
        <p class="dashboard-subtitle">Мои баллы: <span
                    class="highlight"><?= htmlspecialchars($_SESSION['points']) ?></span>
        </p>
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
    function submitBranchWithSubject(id) {
        const subject = document.getElementById('subject')?.value || '';
        const url = new URL(window.location.href);
        url.searchParams.set('id', id);
        if (subject) {
            url.searchParams.set('subject', subject);
        }
        window.location.href = url.toString();
    }

    const ctx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($labels, JSON_UNESCAPED_UNICODE) ?>,
            datasets: [{
                label: 'Посещаемость',
                data: <?= json_encode($values) ?>,
                borderColor: '#4f7df9',
                backgroundColor: 'rgba(79, 125, 249, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {legend: {display: false}},
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function (value) {
                            return value + '%';
                        }
                    }
                }
            }
        }
    });
</script>

<?php require_once 'template/footer.php'; ?>
</body>
</html>
