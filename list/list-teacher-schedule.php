<?php
$header = 'Расписание и планы преподавателей';
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
require_once '../template/header.php';
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
                            <label for="group">Группа</label>
                            <select class="form-control" id="group" name="group">
                                <?= Helper::printSelectOptions(0, (new GruppaMap())->arrGruppas()) ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subject">Предмет</label>
                            <select class="form-control" id="subject" name="subject">
                                <?= Helper::printSelectOptions(0, (new SubjectMap())->arrSubjects()) ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="teacher">Преподаватель</label>
                            <select class="form-control" id="teacher" name="teacher">
                                <?= Helper::printSelectOptions(0, (new TeacherMap())->arrTeachers()) ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="teacher">Аудитория</label>
                            <select class="form-control" id="classroom" name="classroom">
                                <?= Helper::printSelectOptions(0, (new ClassroomMap())->arrClassrooms()) ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="month">Месяц</label>
                            <input class="form-control" type="month" id="month" name="month">
                        </div>
                        <button type="submit" class="btn btn-primary">Показать календарь</button>
                    </form>
                </div>
                <div class="box-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('filterForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const group = document.getElementById('group').value;
            const subject = document.getElementById('subject').value;
            const teacher = document.getElementById('teacher').value;
            const month = document.getElementById('month').value;
            const classroom = document.getElementById('classroom').value;
            const createdIcons = {};

            fetch('../save/save-schedule.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({group, subject, teacher, month, classroom})
            })
                .then(response => response.json())
                .then(eventsData => {
                    console.log(eventsData);
                    const calendarEl = document.getElementById('calendar');

                    if (window.calendarInstance) {
                        window.calendarInstance.destroy();
                    }

                    window.calendarInstance = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        initialDate: month + '-01',
                        events: eventsData,
                        eventContent: function (arg) {
                            let parentContainer = document.createElement('div');

                            // Получаем дату ячейки, в которой отображается событие
                            let cellDate = arg.event.startStr.split('T')[0]; // Убираем время, оставляем только дату

                            // Проверяем, была ли уже создана иконка для этой даты
                            if (!createdIcons[cellDate]) {
                                let btn = document.createElement('button');
                                btn.innerHTML = '📅'; // Иконка календаря
                                btn.style.border = 'none';
                                btn.style.background = 'transparent';
                                btn.style.cursor = 'pointer';
                                btn.style.marginLeft = '5px';

                                // Обработчик клика по иконке
                                btn.addEventListener('click', function (event) {
                                    event.stopPropagation();
                                    openModal(cellDate); // Открываем модальное окно с расписанием
                                });

                                parentContainer.appendChild(btn);

                                // Помечаем дату как обработанную
                                createdIcons[cellDate] = true;
                            }

                            return {domNodes: [parentContainer]};
                        },

                        dateClick: function (info) {
                            let clickedDate = new Date(info.dateStr);
                            let selectedMonth = new Date(`${month}-01`);

                            if (clickedDate.getFullYear() !== selectedMonth.getFullYear() || clickedDate.getMonth() !== selectedMonth.getMonth()) {
                                alert('Выбранная дата не соответствует указанному месяцу!');
                                return;
                            }

                            document.querySelectorAll('.time-input').forEach(el => el.remove());

                            let cell = document.querySelector(`[data-date="${info.dateStr}"]`);
                            if (!cell) return;

                            let input = document.createElement('input');
                            input.type = 'time';
                            input.classList.add('time-input');
                            input.style.position = 'absolute';
                            input.style.zIndex = '1000';
                            input.style.width = '80px';
                            input.style.background = 'white';
                            input.style.border = '1px solid #ccc';
                            input.style.padding = '2px';
                            input.style.marginTop = '5px';

                            let rect = cell.getBoundingClientRect();
                            input.style.left = `${rect.left + window.scrollX + 5}px`;
                            input.style.top = `${rect.top + window.scrollY + 5}px`;

                            document.body.appendChild(input);
                            input.focus();

                            input.addEventListener('change', function () {
                                fetch('../save/save-schedule.php', {
                                    method: 'POST',
                                    headers: {'Content-Type': 'application/json'},
                                    body: JSON.stringify({
                                        group, subject, teacher, month, classroom,
                                        day: info.dateStr, time: input.value
                                    })
                                })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert('Данные успешно сохранены!');
                                            window.calendarInstance.refetchEvents();
                                        } else {
                                            alert('Ошибка при сохранении данных!');
                                        }
                                    });

                                input.remove();
                            });

                            document.addEventListener('click', function outsideClick(e) {
                                if (!input.contains(e.target)) {
                                    input.remove();
                                    document.removeEventListener('click', outsideClick);
                                }
                            });
                        }
                    });

                    window.calendarInstance.render();
                })
                .catch(error => console.error("Ошибка при получении данных:", error));
        });

        function openModal(date) {
            let dateOnly = date.split("T")[0]; // Оставляем только "YYYY-MM-DD"
            document.getElementById('modalDate').textContent = dateOnly;

            // Получаем значение teacher из формы
            const teacher = document.getElementById('teacher').value;

            fetch(`../save/save-schedule.php`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({day: dateOnly, teacher: teacher}) // Добавляем teacher в запрос
            })
                .then(response => response.json())
                .then(data => {
                    console.log("Полученные данные:", data);
                    const scheduleList = document.getElementById('scheduleList');
                    scheduleList.innerHTML = '';

                    if (!Array.isArray(data) || data.length === 0) {
                        scheduleList.innerHTML = '<li>Нет занятий</li>';
                        return;
                    }

                    data.forEach(event => {
                        let li = document.createElement('li');
                        li.textContent = `${event.time} - ID предмета: ${event.subject_id}, Учитель ID: ${event.teacher_id}`;
                        scheduleList.appendChild(li);
                    });
                })
                .catch(error => console.error('Ошибка загрузки расписания:', error));

            document.getElementById('scheduleModal').style.display = 'block';
            document.querySelector('.close').addEventListener('click', function () {
                document.getElementById('scheduleModal').style.display = 'none';
            });
        }

    </script>
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
            z-index: 1000;
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
            outline: none !important; /* Убирает обводку */
            border: none !important; /* Убирает границу */
            box-shadow: none !important; /* Убирает тень */
            background: transparent !important; /* Убирает фон */
        }

        a.fc-daygrid-event:hover,
        a.fc-daygrid-event:focus {
            outline: none !important; /* Убирает обводку при наведении и фокусе */
            border: none !important; /* Убирает границу при наведении и фокусе */
            box-shadow: none !important; /* Убирает тень при наведении и фокусе */
            background: transparent !important; /* Убирает фон при наведении и фокусе */
        }
    </style>

<?php
require_once '../template/footer.php';
?>