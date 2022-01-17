<?php

interface iDatabase {
    static function write($id, $name, $type);    
    static function read($id);
    static function readAll();
    static function delete($id);
}