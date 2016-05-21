<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($title) ? $title : ''; ?></title>
    <style>
        * {
            margin: 0px;
            padding: 0;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        div {
            width: 100%;
        }
        .row.bg-header-red {
            background: darkred;
            line-height: 50px;
            padding: 10px;
            font-size: 20px;
            color: white;
        }
        span.method {
            font-size: 20px;
        }
        .container {
            width: 90%;
            margin: 2em auto;
            padding: 10px;
            line-height: 25px;
            background: firebrick; /*rgb(245, 245, 245);*/
            color: wheat; /*black;*/
            line-height: 30px;
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.45);
        }
        .container p {
            background: rgba(255, 152, 152, 0.15);
            padding: 5px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
<header>
    <section class="row bg-header-red">
        <h2>
            <?php
            if(isset($show) && $show !== false){
                echo $type_handler;
            }else{
                echo 'hubo un  error al procesar tu solicitud oh ocurrio un error interno';
            }
            ?>
        </h2>
    </section>
</header>
<main>
    <section class="row">
        <?php if(isset($show) && $show !== false): ?>
        <div class="container">
            <?php if(isset($code) && $code !== 0): ?>
                <p><b>code: </b><?php echo $code; ?></p>
            <?php
                endif;
            if(isset($msg)):
                ?>
                <p><span class="msg">message: </span><?php echo $msg; ?></p>
                <?php
            endif;
            ?>
            <p><b>file: </b><?php echo $file ?></p>
            <p><b>line: </b><?php echo $line ?></p>
            <div class="trace"><?php echo $trace ?></div>
        </div>
        <?php endif; ?>
    </section>
</main>
</body>
</html>