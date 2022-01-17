<?php

$file = "../data.txt";

class fileDAO implements iDatabase
{
    static function write($id, $name, $type)
    {
        global $file;
        $row = [$id, $name, $type];
        $content = serialize($row) . PHP_EOL;
        file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
        return $row;
    }

    static function read($id)
    {
        $all = fileDAO::getAll();
        return $all[$id];
    }

    static function readAll()
    {
        $all = fileDAO::getAll();
        $list = [];
        foreach ($all as $item) {
            $list[] = $item;
        }
        return $list;
    }

    static function delete($id)
    {
        $response = false;
        global $file;
        $raw = file_get_contents($file);
        $rawItems = explode(PHP_EOL, $raw);
        $updatedContent = "";
        foreach ($rawItems as $line) {
            $row = unserialize($line);
            if ($row && $row[0] == $id) {
                $response = true;
            } else {
                if ($updatedContent != "") {
                    $updatedContent .= PHP_EOL;
                }
                $updatedContent .= $line;
            }
        }
        if ($response) {
            file_put_contents($file, $updatedContent);
        }
        return $response;
    }

    static function getAll()
    {
        global $file;
        $allData = [];
        $raw = file_get_contents($file);
        $rawItems = explode(PHP_EOL, $raw);
        foreach ($rawItems as $line) {
            $row = unserialize($line);
            if ($row) {
                $id = $row[0];
                if (is_null($id) != true) {
                    $allData[$id] = $row;
                }
            }
        }
        return $allData;
    }
}
