<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class HelperController extends Controller
{
    public static function formatDateToInt($dateText, $isN_E){
        if ($dateText !== '') {
            $dateParts = explode('.', $dateText);

            if (count($dateParts) === 3) {
                $formattedDate = $dateParts[2] . $dateParts[1] . $dateParts[0];
                $numericDate = (int) $formattedDate;

                if ($isN_E) {
                    $numericDate *= -1;
                }

                return $numericDate;
            }
        }

        return null;
    }

    public static function formatDateFromInt($dateInt){
        if (!$dateInt) {
            return '';
        }

        $date = abs($dateInt);
        $year = substr($date, 0, strlen($date)-4);
        $month = substr($date, strlen($date)-4, 2);
        $day = substr($date, strlen($date)-2, 2);
        while (strlen($year)<4) $year = '0'.$year;

        return $day . '.' . $month . '.' . $year;
    }

    public static function saveImg($img, $folder, $id){
        $img_path = $img;
        $img_id = $id;
        $u_id = Auth::id(); // Зверніть увагу на використання Auth
        $Err_img = '';

        // Перевірка, чи це картинка
        try{
            if (@get_headers($img_path)[0] !== 'HTTP/1.1 404 Not Found' && exif_imagetype($img_path)) {  
                list($width, $height, $type) = getimagesize($img_path);     
                switch ($type) {
                    case 1: $image = imagecreatefromgif($img_path);
                        break;
                    case 2: $image = imagecreatefromjpeg($img_path);
                        break;
                    case 3: $image = imagecreatefrompng($img_path);
                        break;
                    case 6: $image = imagecreatefrombmp($img_path);
                        break;
                    case 18: $image = imagecreatefromwebp($img_path);
                        break;   
                    default: $Err_img='Даний тип файлу не підтримується: '.$extension;
                }
                
                // Перевірка розміру та масштабування
                if ($height > 1200) {
                    $newHeight = 1200;
                    $newWidth = ($width / $height) * $newHeight;
                    $newImage = imagecreatetruecolor($newWidth, $newHeight);
                    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                    imagedestroy($image);
                    $image = $newImage;
                }

                // Збереження картинки
                $sid=str_pad($img_id, 8, "0", STR_PAD_LEFT); //формуємо маску для пошуку завантажених картинок
                $pattern='images\\'.$folder.'\\'.$sid.'*.*';
                $max='0';        
                foreach (glob($pattern) as $filename) { //визначаємо порядковий індекс нової картинки
                    $s=substr(pathinfo($filename,PATHINFO_FILENAME),9);
                    if ($s>$max) $max=$s;
                }
                $newname = str_pad($img_id, 8, "0", STR_PAD_LEFT) . '_' . ($max + 1) . '.jpg';
                
                imagejpeg($image, 'images/' . $folder . '/' . $newname, 75);
                imagedestroy($image);

            }
            else {
                // Якщо файл не є зображенням
                $Err_img = 'Файл ['.substr($img_path,0,30).'...] не є дійсним зображенням. ';
            }
            return $Err_img;
        }
        catch (\Exception $e) {return 'Файл ['.substr($img_path,0,30).'...] не є дійсним зображенням.';}
    }

    public static function getImgs($folder,$id){
        $img_id = $id;
        $sid=str_pad($img_id, 8, "0", STR_PAD_LEFT);                              //формуємо маску для пошуку існуючих ілюстрацій для книги
        $pattern='images/'.$folder.'/'.$sid.'*.*';
        $i=0;
        $imgs = null;
        foreach (glob($pattern) as $filename){
            $imgs[$i] = $filename;
            $i=$i+1;
        }
        return $imgs;
    }

    public static function delImg($del_img){
        unlink($del_img);     
    }

    // public function paginator($data, $page, $on_page, $num_links, $url){
    //     if ($count_pages > 1) {       //якщо є лише одна сторінка пейджинг не виводиться

    //         $cur_page = ($p==-1) ? ceil($start_row/$on_page) : $p;      //розраховуєм номер поточної сторінки
         
    //              //номер лінка стартової сторінки пейджинга
    //         $start = (($cur_page - $num_links) > 1) ? $cur_page - $num_links : 1;
    //              //номер лінка останньої сторінки
    //         $end   = (($cur_page + $num_links) < $count_pages) ? $cur_page + $num_links : $count_pages;
         
    //         $output= '<span class="ways">';
         
    //         //Формуємо посилання на першу сторінку
    //         if  ($cur_page > ($num_links+1)){
    //            $output .= '<a href="'.route($url, [1]).$params.'" title="Перша"> << </a>';
    //         }  
    //         //на попередню сторінку
    //         if  ($cur_page != 1){
    //            $output .= '<a href="'.route($url, [$cur_page-1]).$params.'" title="Попередня"><</a>';
    //         }
    //         // Формуємо список сторінок з врахуванням стартової і останньої
    //         for ($loop = $start; $loop <= $end; $loop++){
    //            if ($cur_page == $loop)
    //            {               
    //               $output .= '<span>'.$loop.' </span>';        //поточна сторінка
    //            }
    //            else
    //            {
    //                  $output .= '<a href="'.route($url, [$loop]).$params.'">'.$loop.'</a>';
    //            }
    //         }  
    //         //посилання на наступну сторінку
    //         if ($cur_page < $count_pages){
    //            $output .= '<a href="'.route($url, [$cur_page+1]).$params.'" title="Наступна">></a>';
    //         }
         
    //         //на останню сторінку
    //         if (($cur_page + $num_links) < $count_pages){
    //            $output .= '<a href="'.route($url, [$count_pages]).$params.'" title="Остання"> >> </a> <I>('.$count_pages.')</I>';
    //         }
         
    //         $output .= '</span>';
    //         $text.= '<div class="wrapPaging">'.$output.'</div>';
    //      }
    // }

    public static function paginator($data, $url, $page=1, $on_page=10, $num_links=2, $params='') {   
        if ($on_page>=count($data)) return [
            'data' => $data,
            'paginator' => '',
        ];       

        // Підраховуємо загальну кількість сторінок
        $count_pages = ceil(count($data) / $on_page);    
    
        // Отримуємо початкову і кінцеву сторінку для пагінатора
        if ($page < 1) $cur_page = 1;
        else if ($page > $count_pages) $cur_page = $count_pages;
        else $cur_page = $page;
        $start = max($cur_page - $num_links, 1);
        $end = min($cur_page + $num_links, $count_pages);

    
        $output = '<span class="paginator">';
    
        // Формуємо посилання на першу сторінку
        if ($cur_page > ($num_links + 1)) {
            $output .= '<a href="' . route($url, [1]) . $params . '" title="Перша"> << </a>';
        }
    
        // На попередню сторінку
        if ($cur_page != 1) {
            $output .= '<a href="' . route($url, [$cur_page - 1]) . $params . '" title="Попередня"><</a>';
        }
    
        // Формуємо список сторінок з врахуванням стартової і останньої
        for ($loop = $start; $loop <= $end; $loop++) {
            if ($cur_page == $loop) {
                $output .= '<b>' . $loop . ' </b>'; // поточна сторінка
            }
            else {
                $output .= '<a href="' . route($url, [$loop]) . $params . '" class="page-link">' . $loop . '</a>';
            }
        }
    
        // Посилання на наступну сторінку
        if ($cur_page < $count_pages) {
            $output .= '<a href="' . route($url, [$cur_page + 1]) . $params . '" title="Наступна">></a>';
        }
    
        // На останню сторінку
        if (($cur_page + $num_links) < $count_pages) {
            $output .= '<a href="' . route($url, [$count_pages]) . $params . '" title="Остання"> >> </a> <I>(' . $count_pages . ')</I>';
        }
    
        $output .= '</span>';
        $text = '<div class="wrapPaging">' . $output . '</div>';

        // Обрізаємо масив на основі поточної сторінки та кількості записів на сторінку
        $start_row = ($cur_page - 1) * $on_page;
        $sliced_data = $data->slice($start_row, $on_page);
    
        // Повертаємо результати обрізаного масиву та пагінатора
        return [
            'data' => $sliced_data,
            'paginator' => $text,
        ];
    }
    
}
