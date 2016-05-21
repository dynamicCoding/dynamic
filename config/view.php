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

    'paths' => [

        /**
         * root de la vista
         */

        'view' => config('app_path.view'),

        /**
         * si usa el sistema de platillas redis y la funcion al incluir los assets
         * buscara esta ruta para encontra los archivos especificados
         */

        'assets' => [

            'css' => config('app_path.css'),
            'js' => config('app_path.js')

        ],

        /**
         * ruta de donde se compila
         */

        'compile' => config('app_path.view_compile'),

        /**
         * activar la cache
         */

        'cache' => true

    ],

    /**
     * -----------------------------------------------------------------------------
     * RUTA DE COMPILACION
     * -----------------------------------------------------------------------------
     *
     * si utiliza la plantilla redis aqui es donde se especifica el archivo compilado
     * esta es una clave donde esta definida ya la ruta el ini
     */

    'compile' => config('app_path.view_compile')
];