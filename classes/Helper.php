<?php
class Helper
{
    static function clearString($str)
    {
        return trim(strip_tags($str));
    }
    static function clearInt($str)
    {
        return (int) $str;
    }
    static function formattedData($date){
       return date_format(date_create($date), 'd.m.Y');
    }

    static function formattedDataForDB($date){
        return date_format(date_create($date), 'Y-m-d');
    }
    static function printSelectOptions($key = array(), $options = array())
    {
        if ($options) {
            foreach ($options as $option) { ?>
                <option value="<?= $option['id']; ?>" <?= ($key == $option['id']) ? 'selected' : ''; ?>>
                    <?= $option['value']; ?>
                </option>
            <?php }
        }
    }
    static function printSelectOptionsByIdAndValue($options = array())
    {
        if ($options) {
            foreach ($options as $option) { ?>
                <option value="<?= $option['id']; ?>, <?= $option['value']; ?>">
                    <?= $option['value']; ?>
                </option>
            <?php }
        }
    }

    static function printSelectOptionsDate($options = array())
    {
        if ($options) {
            foreach ($options as $option) { ?>
                <option value="<?= $option['date']; ?>">
                    <?= $option['date']; ?>
                </option>
            <?php }
        }
    }

    public static function paginator($count = 1, $current = 1, $size = 30)
    {
        $numPages = ceil($count / $size);
        $href = $_SERVER['PHP_SELF'] . '?page=';
        echo '<ul class="pagination ">';
        for ($i = 1; $i <= $numPages; $i++) {
            if ($current == $i) {
                echo ' <li class="paginate_button active"><a href="' . $href . $i . '" data-dt-idx="' . $i . '" tabindex="0">' . $i . '</a></li>';
            } else {
                echo ' <li class="paginate_button"><a href="' . $href . $i . '" data-dt-idx="' . $i . '" tabindex="0">' . $i . '</a></li>';
            }
        }
        echo '</ul>';
    }
    public static function setFlash($message = '')
    {
        $_SESSION['flash'] = $message;
    }
    public static function getFlash()
    {
        $msg = $_SESSION['flash'];
        $_SESSION['flash'] = '';
        return $msg;
    }
    public static function hasFlash()
    {
        return (!empty($_SESSION['flash'])) ? true : false;
    }
    public static function can($role)
    {
        return ($role === $_SESSION['role']) ? true : false;
    }


    public static function getQuery($status)
    {
        $statuses = [
            'ok' => 'Успешно',
            'okDel' => 'Успешно удалено',
            'err' => 'Ошибка',
            'errDel' => 'Ошибка удаления',
            'errBranch' => 'Вы не принадлежите этому филиалу',
            'errgrades' => 'Ошибка при подтверждении оценки (Возможно у ученика закончились допуски к уроку)',
        ];

        if ($status == 'ok' || $status == 'okDel') {
            $message = '<span style="color: green;">' . $statuses[$status] . '</span>';
        } else {
            $message = '<span style="color: red;">' . $statuses[$status] . '</span>';
        }
        echo $message;
    }
}