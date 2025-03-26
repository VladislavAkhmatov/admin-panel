<?php
require_once '../secure.php';
require_once '../template/header.php';
$id = 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: 404");
}

$studentMap = new StudentMap();
$student = $studentMap->findStudentById($id);
$scheduleJson = null;
if ($student) {
    $scheduleMap = new ScheduleMap();
    $schedule = $scheduleMap->findByGroupId($student->gruppa_id);
    $scheduleJson = json_encode($schedule);
}
?>

<?php if (Helper::can('procreator')) {
    $header = "Расписание группы";
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

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            width: 50%;
            border-radius: 8px;
            position: relative;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
        }

        a.fc-daygrid-event {
            outline: none !important;
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        a.fc-daygrid-event:hover,
        a.fc-daygrid-event:focus {
            outline: none !important;
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }
    </style>
<?php } ?>
<?php
require_once '../template/footer.php';
?>