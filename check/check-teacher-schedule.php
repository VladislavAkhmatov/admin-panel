<?php
require_once '../secure.php';
require_once '../template/header.php';
$id = 0;
if ($_SESSION['id']) {
    $id = $_SESSION['id'];
} else {
    header('Location: 404');
}

$month = null;
$scheduleMap = new ScheduleMap();
$scheduleJson = null;
if (isset($_GET['month'])) {
    $month = $_GET['month'];
    $schedule = $scheduleMap->findScheduleByDateAndTeacherId($month, $id);
    $scheduleJson = json_encode($schedule);
}

$header = 'Мое расписание';

?>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <section class="content-header">
                    <h3><b><?= $header; ?></b></h3>
                    <ol class="breadcrumb">
                        <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>
                        <li class="active"><?= $header; ?></li>
                    </ol>
                </section>
                <div class="box-body">
                    <form id="filterForm">
                        <div class="form-group">
                            <label for="month">Месяц</label>
                            <input class="form-control" type="month" id="month" name="month">
                        </div>
                        <button type="submit" class="btn btn-primary">Показать расписание</button>
                    </form>
                </div>
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <script>
        // Преобразуем PHP переменную в JavaScript объект
        const scheduleData = <?php echo $scheduleJson; ?>;
        const createdIcons = {};
        console.log(scheduleData)

        function prepareCalendarEvents(schedule) {
            return schedule.map(item => {
                return {
                    title: `${item.subject} (${item.classroom})`,
                    start: item.date + 'T' + item.time,
                    extendedProps: {
                        teacher: item.user,
                        group: item.group_name
                    }
                };
            });
        }

        // Инициализация календаря с данными из переменной
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const events = prepareCalendarEvents(scheduleData);

            window.calendarInstance = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: events,
                aspectRatio: 1.35,
                eventContent: function (arg) {
                    let parentContainer = document.createElement('div');
                    let cellDate = arg.event.startStr.split('T')[0];

                    if (!createdIcons[cellDate]) {
                        let btn = document.createElement('button');
                        btn.innerHTML = '📅';
                        btn.style.border = 'none';
                        btn.style.background = 'transparent';
                        btn.style.cursor = 'pointer';
                        btn.style.marginLeft = '5px';

                        btn.addEventListener('click', function (event) {
                            event.stopPropagation();
                            openModal(cellDate);
                        });

                        parentContainer.appendChild(btn);
                        createdIcons[cellDate] = true;
                    }

                    return {domNodes: [parentContainer]};
                }
            });

            window.calendarInstance.render();
        });

        function openModal(date) {
            document.getElementById('modalDate').textContent = date;
            const scheduleList = document.getElementById('scheduleList');
            scheduleList.innerHTML = '';

            // Фильтруем занятия на выбранную дату
            const daySchedule = scheduleData.filter(item => item.date === date);

            if (daySchedule.length === 0) {
                scheduleList.innerHTML = '<li>Нет занятий</li>';
            } else {
                daySchedule.forEach(event => {
                    let li = document.createElement('li');
                    li.textContent = `${event.time} - ${event.subject}, ${event.user}, ${event.classroom}, ${event.group_name}`;
                    scheduleList.appendChild(li);
                });
            }

            document.getElementById('scheduleModal').style.display = 'block';
            document.querySelector('.close').addEventListener('click', function () {
                document.getElementById('scheduleModal').style.display = 'none';
            });
        }
    </script>

    <!-- Остальной HTML код (модальное окно и стили) остается без изменений -->
    <div id="scheduleModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Расписание на <span id="modalDate"></span></h2>
            <ul id="scheduleList"></ul>
        </div>
    </div>
<?php
require_once '../template/footer.php';
?>