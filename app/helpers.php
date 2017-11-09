<?php

/**
 * Rupiah Format
 * @param  int $number money in integer format
 * @return string         money in string format
 */
function formatNo($number)
{
    return number_format($number, 0, ',', '.');
}

function formatRp($number)
{
    if ($number == 0) {return 'Rp. 0';}
    if ($number < 0) {
        return '- Rp. ' . formatNo(abs($number));
    }

    return 'Rp. ' . formatNo($number);
}

function formatDecimal($number)
{
    return number_format($number, 2, ',', '.');
}

/**
 * Delete button
 * @param  array $form_params Delete form attribute
 * @param  string $button_label   Button text
 * @param  array $button_options  Button option
 * @return string                 Delete Button Form
 */
function delete_button($form_params = [], $button_label = 'Delete', $button_options = [], $hiddenFields = [])
{
    $form_params['method'] = 'delete';
    $form_params['class'] = isset($form_params['class']) ? $form_params['class'] : 'del-form';
    $form_params['style'] = isset($form_params['style']) ? $form_params['style'] : 'display:inline';

    if (!isset($button_options['class'])) {
        $button_options['class'] = 'pull-right';
    }

    if (!isset($button_options['title'])) {
        $button_options['title'] = 'Delete this record';
    }

    $htmlForm = Form::open($form_params);
    if (!empty($hiddenFields)) {
        foreach ($hiddenFields as $k => $v) {
            $htmlForm .= Form::hidden($k, $v);
        }
    }
    $htmlForm .= Form::submit($button_label, $button_options);
    $htmlForm .= Form::close();

    return $htmlForm;
}

function formatDate($date)
{
    if (!$date || $date == '0000-00-00') {
        return null;
    }

    $explodedDate = explode('-', $date);

    if (count($explodedDate) == 3 && checkdate($explodedDate[1], $explodedDate[0], $explodedDate[2])) {
        return $explodedDate[2] . '-' . $explodedDate[1] . '-' . $explodedDate[0];
    } else if (count($explodedDate) == 3 && checkdate($explodedDate[1], $explodedDate[2], $explodedDate[0])) {
        return $explodedDate[2] . '-' . $explodedDate[1] . '-' . $explodedDate[0];
    }

    throw new App\Exceptions\InvalidDateException('Kesalahan format tanggal');
}

function dateId($date)
{
    if (is_null($date) || $date == '0000-00-00') {
        return '-';
    }

    $explodedDate = explode('-', $date);

    if (count($explodedDate) == 3 && checkdate($explodedDate[1], $explodedDate[2], $explodedDate[0])) {
        $months = getMonths();
        return $explodedDate[2] . ' ' . $months[$explodedDate[1]] . ' ' . $explodedDate[0];
    }

    throw new App\Exceptions\InvalidDateException('Kesalahan format tanggal');
}

function monthNumber($number)
{
    return str_pad($number, 2, "0", STR_PAD_LEFT);
}

function monthId($monthNumber)
{
    if (is_null($monthNumber)) {
        return $monthNumber;
    }

    $months = getMonths();
    $monthNumber = monthNumber($monthNumber);
    return $months[$monthNumber];
}

function getMonths()
{
    return [
        '' => 'Pilih Bulan',
        '01' => 'Januari',
        '02' => 'Pebruari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'Nopember',
        '12' => 'Desember',
    ];
}

function getYears()
{
    $yearRange = range(2014, date('Y'));
    foreach ($yearRange as $year) {
        $years[$year] = $year;
    }
    return $years;
}

function str_split_ucwords($string)
{
    return ucwords(str_replace('_', ' ', $string));
}

function getDays()
{
    return $days = [1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
}

function getDay($dayIndex = null)
{
    $days = getDays();
    if (!is_null($dayIndex) && in_array($dayIndex, range(1, 7))) {
        return $days[$dayIndex];
    }

    return '-';
}

function sanitizeNumber($number)
{
    return str_replace(',', '.', $number);
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

/**
 * Overide Laravel Collective  link_to_route helper function
 * @param  string $name       Name of route
 * @param  string $title      Text that displayed on view
 * @param  array  $parameters URL Parameter
 * @param  array  $attributes The anchor tag atributes
 */
function html_link_to_route($name, $title = null, $parameters = [], $attributes = [])
{
    if (array_key_exists('icon', $attributes)) {
        $title = '<i class="fa fa-' . $attributes['icon'] . '"></i> ' . $title;
    }

    return app('html')->decode(link_to_route($name, $title, $parameters, $attributes));
}

function getProjectStatusesList($statusId = null)
{
    $statuses = [1 => 'Planned', 'On Progress', 'Done', 'Closed', 'Canceled', 'On Hold'];

    if (is_null($statusId)) {
        return $statuses;
    }

    if (array_key_exists($statusId, $statuses)) {
        return $statuses[$statusId];
    }

    return null;
}

function dateDifference($date1, $date2, $differenceFormat = '%a')
{
    $datetime1 = date_create($date1);
    $datetime2 = date_create($date2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);
}

function paymentTypes($paymentTypeId = null)
{
    $paymentTypes = [1 => 'Project', 'Add Feature', 'Maintenance'];

    if (is_null($paymentTypeId)) {
        return $paymentTypes;
    }

    if (array_key_exists($paymentTypeId, $paymentTypes)) {
        return $paymentTypes[$paymentTypeId];
    }

    return null;
}
