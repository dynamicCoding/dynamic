<?php

return [

    /**
     * ----------------------------------------------------------------------------
     * RUTA DE VISTA
     * ----------------------------------------------------------------------------
     *
     * indica donde se encuentra ubicado de la vista de los assets y de los compile
     * las especificacion se declara en arhivo ini
     */


    /**
      * root de la vista
      */

    'view' => config('app_path.view'),
    
    /**
     * otras opciones para el funcionamiento de la vista
     */
      
    'options' => [

        /**
         * si usa el sistema de platillas redis y la funcion al incluir los assets
         * buscara esta ruta para encontra los archivos especificados
         */

        'assets' => [

            'css' => config('app_path.css'),
            'js' => config('app_path.js')

        ],

        /**
         * ruta de donde se compila la vista
         */

        'compile' => config('app_path.view_compile'),

        /**
         * activar la cache, si es false se compilara con la funcion eval
         */

        'cache' => true
    ]
];