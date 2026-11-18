<?php
ob_start();
?>

<div class="appointments-page">
    <h2><?= t('Записаться на приём', 'Broneeri aeg') ?></h2>

    <p>
        <?= t(
            'Выберите услугу, мастера и удобное время.',
            'Vali teenus, meister ja sobiv aeg.'
        ) ?>
    </p>

    <?php if (!empty($error)): ?>
        <p class="error-message">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success-message">
            <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <form class="appointment-form" method="POST">

        <label for="service_id">
            <?= t('Услуга', 'Teenus') ?>
        </label>

        <select name="service_id" id="service_id" required>
            <option value="" <?= $selectedServiceId === null ? 'selected' : '' ?>>
                <?= t('Выберите услугу', 'Vali teenus') ?>
            </option>

            <?php foreach ($services as $service): ?>
                <option
                    value="<?= (int)$service['id'] ?>"
                    <?= $selectedServiceId === (int)$service['id'] ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars(
                        ($_SESSION['lang'] ?? 'ru') === 'et'
                            ? $service['name_et']
                            : $service['name_ru'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="employee_id">
            <?= t('Мастер', 'Meister') ?>
        </label>

        <select
            name="employee_id"
            id="employee_id"
            data-selected-employee="<?= (int)($selectedEmployeeId ?? 0) ?>"
            required
            disabled
        >
            <option value="">
                <?= t(
                    'Сначала выберите услугу',
                    'Vali kõigepealt teenus'
                ) ?>
            </option>

            <?php foreach ($employees as $employee): ?>
                <option
                    value="<?= (int)$employee['id'] ?>"
                    <?= $selectedEmployeeId === (int)$employee['id'] ? 'selected' : '' ?>
                    data-services="<?= htmlspecialchars(
                        implode(',', $employeeServices[$employee['id']] ?? []),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                >
                    <?= htmlspecialchars(
                        $employee['first_name'] . ' ' . $employee['last_name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="appointment_date">
            <?= t('Дата', 'Kuupäev') ?>
        </label>

        <input
            type="date"
            name="appointment_date"
            id="appointment_date"
            value="<?= htmlspecialchars($selectedDate, ENT_QUOTES, 'UTF-8') ?>"
            min="<?= date('Y-m-d') ?>"
            required
        >

        <label for="appointment_time">
            <?= t('Время', 'Kellaaeg') ?>
        </label>

        <select
            name="appointment_time"
            id="appointment_time"
            required
            disabled
        >
            <option value="">
                <?= t(
                    'Сначала выберите услугу, мастера и дату',
                    'Vali kõigepealt teenus, meister ja kuupäev'
                ) ?>
            </option>
        </select>

        <p id="availability-message" aria-live="polite"></p>

        <label for="comment">
            <?= t('Дополнительная информация', 'Lisainfo') ?>
        </label>

        <textarea
            name="comment"
            id="comment"
            rows="4"
            placeholder="<?= t(
                'Пожелания или дополнительная информация...',
                'Soovid või lisainfo...'
            ) ?>"
        ></textarea>

        <button type="submit">
            <?= t('Записаться на приём', 'Broneeri aeg') ?>
        </button>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const serviceSelect = document.getElementById('service_id');
    const employeeSelect = document.getElementById('employee_id');
    const dateSelect = document.getElementById('appointment_date');
    const timeSelect = document.getElementById('appointment_time');
    const availabilityMessage = document.getElementById('availability-message');

    const employees = Array.from(employeeSelect.options).slice(1);
    const initialEmployeeId = employeeSelect.dataset.selectedEmployee;
    let selectedTime = <?= json_encode(
        $selectedTime,
        JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
    ) ?>;
    let restoreEmployeeSelection = true;
    let availabilityRequest = 0;

    const chooseTimeText = <?= json_encode(t('Выберите время', 'Vali kellaaeg')) ?>;
    const chooseDetailsText = <?= json_encode(
        t(
            'Сначала выберите услугу, мастера и дату.',
            'Vali kõigepealt teenus, meister ja kuupäev.'
        )
    ) ?>;
    const loadingText = <?= json_encode(
        t('Проверяем свободное время...', 'Kontrollime vabu aegu...')
    ) ?>;
    const availableText = <?= json_encode(t('свободно', 'vaba')) ?>;
    const unavailableText = <?= json_encode(t('занято', 'hõivatud')) ?>;
    const noSlotsText = <?= json_encode(
        t('На этот день нет доступного времени.', 'Sellel päeval vabu aegu pole.')
    ) ?>;
    const requestErrorText = <?= json_encode(
        t(
            'Не удалось загрузить доступность. Попробуйте позже.',
            'Vabade aegade laadimine ebaõnnestus. Proovi hiljem uuesti.'
        )
    ) ?>;

    async function updateAvailability() {
        const requestId = ++availabilityRequest;
        const serviceId = serviceSelect.value;
        const employeeId = employeeSelect.value;
        const date = dateSelect.value;

        timeSelect.innerHTML = '';
        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = chooseTimeText;
        placeholder.selected = true;
        timeSelect.appendChild(placeholder);
        timeSelect.disabled = true;
        availabilityMessage.textContent = '';

        if (!serviceId || !employeeId || !date) {
            placeholder.textContent = chooseDetailsText;
            return;
        }

        placeholder.textContent = loadingText;

        const params = new URLSearchParams({
            service_id: serviceId,
            employee_id: employeeId,
            date: date
        });

        try {
            const response = await fetch(
                '/ilusalong/appointment-availability?' + params.toString(),
                { headers: { Accept: 'application/json' } }
            );

            if (!response.ok) {
                throw new Error('Availability request failed.');
            }

            const result = await response.json();

            if (requestId !== availabilityRequest) {
                return;
            }

            timeSelect.innerHTML = '';
            placeholder.textContent = chooseTimeText;
            timeSelect.appendChild(placeholder);

            if (!result.slots.length) {
                placeholder.textContent = noSlotsText;
                availabilityMessage.textContent = noSlotsText;
                return;
            }

            let hasAvailableSlots = false;

            result.slots.forEach(function (slot) {
                const option = document.createElement('option');
                option.value = slot.time;
                option.textContent = slot.time + ' — ' +
                    (slot.available ? availableText : unavailableText);
                option.disabled = !slot.available;

                if (slot.available) {
                    hasAvailableSlots = true;

                    if (slot.time === selectedTime) {
                        option.selected = true;
                        placeholder.selected = false;
                    }
                }

                timeSelect.appendChild(option);
            });

            timeSelect.disabled = false;
            selectedTime = '';

            if (!hasAvailableSlots) {
                availabilityMessage.textContent = noSlotsText;
            }
        } catch (error) {
            if (requestId !== availabilityRequest) {
                return;
            }

            placeholder.textContent = requestErrorText;
            availabilityMessage.textContent = requestErrorText;
        }
    }

    serviceSelect.addEventListener('change', function () {
        const selectedService = this.value;
        const employeeToRestore = restoreEmployeeSelection
            ? initialEmployeeId
            : '';

        employeeSelect.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';

        if (!selectedService) {
            placeholder.textContent = <?= json_encode(
                t('Сначала выберите услугу', 'Vali kõigepealt teenus')
            ) ?>;

            employeeSelect.appendChild(placeholder);
            employeeSelect.disabled = true;
            restoreEmployeeSelection = false;
            updateAvailability();
            return;
        }

        placeholder.textContent = <?= json_encode(
            t('Выберите мастера', 'Vali meister')
        ) ?>;

        employeeSelect.appendChild(placeholder);

        let count = 0;

        employees.forEach(function (employee) {
            const services = employee.dataset.services
                .split(',')
                .filter(Boolean);

            if (services.includes(selectedService)) {
                const option = employee.cloneNode(true);

                if (option.value === employeeToRestore) {
                    option.selected = true;
                }

                employeeSelect.appendChild(option);
                count++;
            }
        });

        if (count === 0) {
            placeholder.textContent = <?= json_encode(
                t(
                    'Нет мастеров для этой услуги',
                    'Selle teenuse jaoks pole meistreid'
                )
            ) ?>;

            employeeSelect.disabled = true;
        } else {
            employeeSelect.disabled = false;
        }

        restoreEmployeeSelection = false;
        updateAvailability();
    });

    employeeSelect.addEventListener('change', updateAvailability);
    dateSelect.addEventListener('change', updateAvailability);
    serviceSelect.dispatchEvent(new Event('change'));
});
</script>

<?php
$content = ob_get_clean();
include 'view/layout.php';
?>
