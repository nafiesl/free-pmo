<?php

/**
 * Rupiah Format.
 *
 * @param int $number money in integer format
 *
 * @return string money in string format
 */
function formatNo($number)
{
    return number_format($number, 0, ',', '.');
}

function formatRp($number)
{
    $moneySign = Option::get('money_sign', 'Rp.');

    if ($number == 0) {
        return $moneySign.' 0';
    }

    if ($number < 0) {
        return '- '.$moneySign.' '.formatNo(abs($number));
    }

    return $moneySign.' '.formatNo($number);
}

function formatDecimal($number)
{
    return number_format($number, 2, ',', '.');
}

function formatDate($date)
{
    if (!$date || $date == '0000-00-00') {
        return;
    }

    $explodedDate = explode('-', $date);

    if (count($explodedDate) == 3 && checkdate($explodedDate[1], $explodedDate[0], $explodedDate[2])) {
        return $explodedDate[2].'-'.$explodedDate[1].'-'.$explodedDate[0];
    } elseif (count($explodedDate) == 3 && checkdate($explodedDate[1], $explodedDate[2], $explodedDate[0])) {
        return $explodedDate[2].'-'.$explodedDate[1].'-'.$explodedDate[0];
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

        return $explodedDate[2].' '.$months[$explodedDate[1]].' '.$explodedDate[0];
    }

    throw new App\Exceptions\InvalidDateException('Kesalahan format tanggal');
}

function monthNumber($number)
{
    return str_pad($number, 2, '0', STR_PAD_LEFT);
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
        $bytes = number_format($bytes / 1073741824, 2).' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2).' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2).' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes.' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes.' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

/**
 * Overide Laravel Collective  link_to_route helper function.
 *
 * @param string $name       Name of route
 * @param string $title      Text that displayed on view
 * @param array  $parameters URL Parameter
 * @param array  $attributes The anchor tag atributes
 */
function html_link_to_route($name, $title = null, $parameters = [], $attributes = [])
{
    if (array_key_exists('icon', $attributes)) {
        $title = '<i class="fa fa-'.$attributes['icon'].'"></i> '.$title;
    }

    return app('html')->decode(link_to_route($name, $title, $parameters, $attributes));
}

function dateDifference($date1, $date2, $differenceFormat = '%a')
{
    $datetime1 = date_create($date1);
    $datetime2 = date_create($date2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);
}

function appLogoImage($attributes = [])
{
    return Html::image(
        appLogoPath(),
        'Logo '.Option::get('agency_name', 'Laravel'),
        $attributes
    );
}

function appLogoPath()
{
    $defaultLogoImagePath = 'default-logo.png';
    $optionLogoImagePath = Option::get('agency_logo_path');

    if (is_file(public_path('assets/imgs/'.$optionLogoImagePath))) {
        return asset('assets/imgs/'.$optionLogoImagePath);
    }

    return asset('assets/imgs/'.$defaultLogoImagePath);
}

function monthDateArray($year, $month)
{
    $dateCount = Carbon::parse($year.'-'.$month)->format('t');
    $dates = [];
    foreach (range(1, $dateCount) as $dateNumber) {
        $dates[] = str_pad($dateNumber, 2, '0', STR_PAD_LEFT);
    }

    return $dates;
}
