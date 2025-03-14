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
            const month = document.getElementById('month').value; // Выбранный месяц (формат YYYY-MM)

            fetch('../save/save-schedule', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ group, subject, teacher, month })
            })
                .then(response => response.json())
                .then(eventsData => {
                    const calendarEl = document.getElementById('calendar');
                    const calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        initialDate: month + '-01', // Устанавливаем начальную дату календаря
                        events: eventsData,
                        dateClick: function (info) {
                            // Парсим дату и сравниваем с выбранным месяцем
                            let clickedDate = new Date(info.dateStr);
                            let selectedMonth = new Date(`${month}-01`); // Приводим месяц из формы к формату YYYY-MM-01

                            if (
                                clickedDate.getFullYear() !== selectedMonth.getFullYear() ||
                                clickedDate.getMonth() !== selectedMonth.getMonth()
                            ) {
                                alert('Выбранная дата не соответствует указанному месяцу!');
                                return;
                            }

                            // Удаляем старые input, если есть
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

                            // Определяем позицию инпута внутри ячейки
                            let rect = cell.getBoundingClientRect();
                            input.style.left = `${rect.left + window.scrollX + 5}px`;
                            input.style.top = `${rect.top + window.scrollY + 5}px`;

                            document.body.appendChild(input);
                            input.focus();

                            input.addEventListener('change', function () {
                                fetch('../save/save-schedule.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        group,
                                        subject,
                                        teacher,
                                        month,
                                        day: info.dateStr,
                                        time: input.value
                                    })
                                })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert('Данные успешно сохранены!');
                                            calendar.refetchEvents();
                                        } else {
                                            alert('Ошибка при сохранении данных!');
                                        }
                                    });

                                input.remove();
                            });

                            // Закрываем input, если кликнули вне него
                            document.addEventListener('click', function outsideClick(e) {
                                if (!input.contains(e.target)) {
                                    input.remove();
                                    document.removeEventListener('click', outsideClick);
                                }
                            });
                        }
                    });

                    calendar.render();
                });
        });
    </script>

<?php
require_once '../template/footer.php';
?>