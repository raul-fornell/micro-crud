<?php

namespace lib;

use fileDAO as DAO;
class CRUD
{
    static function create($payload)
    {        
        $row = DAO::write(uniqid(), $payload->name, $payload->type);
        http_response_code(201);
        return CRUD::returnRow($row);
    }

    static function read($id)
    {        
        $row = DAO::read($id);
        if (is_null($row)) {
            http_response_code(404);
            return null;
        } else {
            return CRUD::returnRow($row);
        }
    }

    static function readAll()
    {        
        return array_map("lib\CRUD::returnRow", DAO::readAll());
    }

    static function update($id, $payload)
    {        
        $found = CRUD::delete($id);
        if ($found == false) {
            http_response_code(404);
            return null;
        }
        $row = DAO::write($id, $payload->name, $payload->type);
        http_response_code(200);
        return CRUD::returnRow($row);
    }

    static function delete($id)
    {        
        $hasBeenDeleted = DAO::delete($id);
        if ($hasBeenDeleted == true) {
            http_response_code(200);
        } else {
            http_response_code(404);
        }
        return $hasBeenDeleted;
    }

    static private function returnRow($row)
    {
        return [
            "id" => $row[0],
            "name" => $row[1],
            "type" => $row[2]
        ];
    }
}
