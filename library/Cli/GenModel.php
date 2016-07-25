<?php

namespace Illustrator\Cli;


use Exception;

trait GenModel
{
    /**
     * @param $type
     * @return mixed
     */
    public function inModel($type)
    {
        if (is_string($type)) {
            return $this->createModel($type);
        }

        return null;
    }

    /**
     * @param $tableName
     * @return bool
     * @throws Exception
     */
    protected function createModel($tableName)
    {
        $genModel = file_get_contents($this->dirGenerator . 'model.g');

        $replace =  str_replace('dummyClass', ucwords($tableName), str_replace('dummyTable', $tableName, $genModel));

        $model = $this->model . ucwords($tableName) . '.php';

        if (!file_exists($model)) {
            if (!$this->putContent($model, $replace)) {
                throw new Exception('Error to creating model');
            }
        }

        $this->msg($model);

        return true;
    }
}