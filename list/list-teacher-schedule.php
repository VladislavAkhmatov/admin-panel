<?php
$header = 'Расписание и планы преподавателей';
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}

$teachers = (new TeacherMap())->arrTeachers();

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
                    <form id="filterForm" method="get">
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
                            <label for="teacher">Учитель</label>
                            <select class="form-control" id="teacher" name="teacher">
                                <?= Helper::printSelectOptions(0, (new TeacherMap())->arrTeachers()) ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="teacher">Кабинет</label>
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
                <div id="calendar"></div>
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
                    const calendarEl = document.getElementById('calendar');

                    if (window.calendarInstance) {
                        window.calendarInstance.destroy();
                    }

                    window.calendarInstance = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        initialDate: month + '-01',
                        events: eventsData,
                        headerToolbar: {
                            left: '',   // убираем все элементы слева (включая today)
                            center: 'title', // оставляем только заголовок месяца
                            right: ''   // убираем все элементы справа (включая стрелки)
                        },
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
            let dateOnly = date.split("T")[0];
            document.getElementById('modalDate').textContent = dateOnly;
            const teacher = document.getElementById('teacher').value;
            const group = document.getElementById('group').value;

            fetch(`../save/save-schedule.php`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({day: dateOnly, teacher: teacher, group: group})
            })
                .then(response => response.json())
                .then(data => {
                    const scheduleList = document.getElementById('scheduleList');
                    scheduleList.innerHTML = '';

                    if (!Array.isArray(data) || data.length === 0) {
                        scheduleList.innerHTML = '<li>Нет занятий</li>';
                        return;
                    }

                    data.forEach(event => {
                        let li = document.createElement('li');
                        li.dataset.eventId = event.id; // Сохраняем ID события
                        // Основное содержимое элемента
                        let contentSpan = document.createElement('span');
                        contentSpan.textContent = `${event.time} - Предмет: ${event.subject_name}, Учитель: ${event.teacher_fio}, Кабинет: ${event.classroom_name}, Группа: ${event.gruppa_name}`;

                        // Иконка редактирования
                        let editIcon = document.createElement('i');
                        editIcon.className = 'fa fa-pencil';
                        editIcon.style.cursor = 'pointer';
                        editIcon.style.marginLeft = '10px';

                        // Обработчик клика по иконке
                        editIcon.addEventListener('click', function () {
                            openEditForm(li, event);
                        });

                        li.appendChild(contentSpan);
                        li.appendChild(editIcon);
                        scheduleList.appendChild(li);
                    });
                })
                .catch(error => console.error('Ошибка загрузки расписания:', error));

            document.getElementById('scheduleModal').style.display = 'block';
            document.querySelector('.close').addEventListener('click', function () {
                document.getElementById('scheduleModal').style.display = 'none';
            });
        }

        function openEditForm(liElement, eventData) {
            // Создаем форму для редактирования
            let form = document.createElement('form');
            form.className = 'edit-form';

            let scheduleIdInput = document.createElement('input');
            scheduleIdInput.type = 'hidden';
            scheduleIdInput.name = 'schedule_id';
            scheduleIdInput.value = eventData.schedule_id;
            form.appendChild(scheduleIdInput);

            // Поле времени
            let timeDiv = document.createElement('div');
            timeDiv.innerHTML = `
        <label>Время:</label>
        <input type="time" name="time" value="${eventData.time}" required>
    `;

            // Добавляем временные заглушки для select'ов
            form.appendChild(timeDiv);

            // Создаем контейнеры для select'ов
            let subjectDiv = document.createElement('div');
            subjectDiv.innerHTML = '<label>Предмет:</label><select name="subject" required></select>';

            let teacherDiv = document.createElement('div');
            teacherDiv.innerHTML = '<label>Преподаватель:</label><select name="teacher" required></select>';

            let classroomDiv = document.createElement('div');
            classroomDiv.innerHTML = '<label>Кабинет:</label><select name="classroom" required></select>';

            let groupDiv = document.createElement('div');
            groupDiv.innerHTML = '<label>Группа:</label><select name="group" required></select>';

            form.appendChild(subjectDiv);
            form.appendChild(teacherDiv);
            form.appendChild(classroomDiv);
            form.appendChild(groupDiv);

            // Заменяем содержимое li на форму (пока без заполненных select'ов)
            liElement.innerHTML = '';
            liElement.appendChild(form);
            // Загружаем данные для каждого select'а
            loadSelectOptions('subject', eventData.subject_id);
            loadSelectOptions('teacher', eventData.teacher_id);
            loadSelectOptions('classroom', eventData.classroom_id);
            loadSelectOptions('group', eventData.gruppa_id);

            // Функция для загрузки опций
            function loadSelectOptions(fieldName, selectedId) {
                fetch(`../get-options.php?type=${fieldName}`, {
                    method: 'GET', // явно указываем метод GET
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(options => {
                        const select = form.querySelector(`[name="${fieldName}"]`);
                        select.innerHTML = '';

                        options.forEach(option => {
                            const optElement = document.createElement('option');
                            optElement.value = option.id;
                            optElement.textContent = option.value;
                            if (option.id == selectedId) {
                                optElement.selected = true;
                            }
                            select.appendChild(optElement);
                        });
                    })
                    .catch(error => console.error(`Ошибка загрузки ${fieldName}:`, error));
            }

            // Кнопки
            let buttonsDiv = document.createElement('div');
            buttonsDiv.style.marginTop = '10px';
            buttonsDiv.innerHTML = `
        <button type="submit" class="save-btn">Сохранить</button>
        <button type="button" class="cancel-btn">Отмена</button>
    `;

            form.appendChild(buttonsDiv);

            // Остальной код (обработчики событий) остается без изменений
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                saveChanges(liElement, eventData.id, form);
            });

            form.querySelector('.cancel-btn').addEventListener('click', function () {
                // Восстанавливаем исходное содержимое
                let contentSpan = document.createElement('span');
                contentSpan.textContent = `${eventData.time} - Предмет: ${eventData.subject_name}, Учитель: ${eventData.teacher_fio}, Кабинет: ${eventData.classroom_name}, Группа: ${eventData.gruppa_name}`;

                let editIcon = document.createElement('i');
                editIcon.className = 'fa fa-pencil';
                editIcon.style.cursor = 'pointer';
                editIcon.style.marginLeft = '10px';
                editIcon.addEventListener('click', function () {
                    openEditForm(liElement, eventData);
                });

                liElement.innerHTML = '';
                liElement.appendChild(contentSpan);
                liElement.appendChild(editIcon);
            });
        }

        function saveChanges(liElement, eventId, form) {
            const formData = {
                id: eventId,
                schedule_id: form.querySelector('[name="schedule_id"]').value,
                time: form.querySelector('[name="time"]').value,
                subject: form.querySelector('[name="subject"]').value,
                teacher: form.querySelector('[name="teacher"]').value,
                classroom: form.querySelector('[name="classroom"]').value,
                group: form.querySelector('[name="group"]').value
            };
            fetch('../update-schedule.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Обновляем отображение
                        let contentSpan = document.createElement('span');
                        contentSpan.textContent = `${formData.time} - Предмет: ${form.querySelector('[name="subject"] option:selected').textContent}, ` +
                            `Учитель: ${form.querySelector('[name="teacher"] option:selected').textContent}, ` +
                            `Кабинет: ${form.querySelector('[name="classroom"] option:selected').textContent}, ` +
                            `Группа: ${form.querySelector('[name="group"] option:selected').textContent}`;

                        let editIcon = document.createElement('i');
                        editIcon.className = 'fa fa-pencil';
                        editIcon.style.cursor = 'pointer';
                        editIcon.style.marginLeft = '10px';
                        editIcon.addEventListener('click', function () {
                            openEditForm(liElement, {
                                id: eventId,
                                time: formData.time,
                                subject_id: formData.subject,
                                subject_name: form.querySelector('[name="subject"] option:selected').textContent,
                                teacher_id: formData.teacher,
                                teacher_fio: form.querySelector('[name="teacher"] option:selected').textContent,
                                classroom_id: formData.classroom,
                                classroom_name: form.querySelector('[name="classroom"] option:selected').textContent,
                                gruppa_id: formData.group,
                                gruppa_name: form.querySelector('[name="group"] option:selected').textContent,
                            });
                        });

                        liElement.innerHTML = '';
                        liElement.appendChild(contentSpan);
                        liElement.appendChild(editIcon);

                        // Обновляем календарь
                        if (window.calendarInstance) {
                            window.calendarInstance.refetchEvents();
                        }
                    } else {
                        alert((data.message || ''));
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    alert('Произошла ошибка при сохранении изменений');
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
<?php
require_once '../template/footer.php';
?>