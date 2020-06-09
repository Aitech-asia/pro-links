<?php

namespace ProCore\Systems;

class DLog
{
    /**
     * fuction private.
     * @param boolean $f
     * @param int $i
     * @return string
     */
    private static function trace($f=true, $i=2)
    {
        $t = debug_backtrace(null, 0);
        $c = count($t) - $i;
        $file = isset($t[$i]['file']) ? $t[$i-1]['file'] : '';
        $line = isset($t[$i]['line']) ? $t[$i-1]['line'] : '';
        $func = isset($t[$i]['function']) ? $t[$i]['function'] : '';
        $type = isset($t[$i]['type']) ? $t[$i]['type'] : '';
        $args = isset($t[$i]['args']) ? $t[$i]['args'] : array();
        $file = str_replace(__DIR__, '', $file);
        $file = str_replace('\\', '/', $file);
        $file = substr($file, 1);
        if ($f) {
            if (is_array($args)) {
                foreach ($args as &$v) {
                    if (is_resource($v)) {
                        $v = '(resource)';
                    } elseif (is_object($v)) {
                        $v = '(object)';
                    }
                }
                unset($v);
            }
            return '['.$c.']'.$file.':'.$line.','.$type.$func.json_encode($args, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        return '['.$c.']'.$file.':'.$line.','.$type.$func;
    }

    private static function arrayReplace(&$m)
    {
        foreach ($m as &$v) {
            if (is_resource($v)) {
                $v = '(resource)';
            } elseif (is_object($v)) {
                $v = '(object)';
            } elseif (is_array($v)) {
                self::arrayReplace($v);
            } elseif (is_null($v)) {
                $v = '(null)';
            } elseif (is_string($v)) {
                $v = mb_convert_encoding($v, "utf8", "EUC-JP, SJIS, UTF-8");
                $v = mb_convert_encoding($v, "utf8", "utf8");
            }
        }
    }

    /**
     * History debug.
     * @param boolean $f
     * @param string $m
     * @return void
     */
    public static function debug($f=true, $m='')
    {
        if (is_array($m)) {
            self::arrayReplace($m);
            $mm = json_encode($m, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } else {
            $mm = $m;
        }

        $log_filename = AFFILIATE_PLUGIN_DIR."/log";
        if (!file_exists($log_filename)) {
            // create directory/folder uploads.
            mkdir($log_filename, 0777, true);
        }
        $mmm =  date('c').',DEBUG:'.self::trace($f).':'.$mm.PHP_EOL;
        $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
        if (!file_exists($log_file_data)) {
            $fp = fopen($log_file_data, 'w');
            fwrite($fp, '----begin---');
            fclose($fp);
            chmod($log_file_data, 0777);
        }
        file_put_contents($log_file_data, $mmm . "\n", FILE_APPEND);
    }
}