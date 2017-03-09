<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>


    <style>
        .event-tab .event-content .btn {
            margin-top: 0px;
            display: none;
        }
        .event-container{margin-top: -30px;}
        .pj-main{display: none}
        html.loading {
            /* Replace #333 with the background-color of your choice */
            /* Replace loading.gif with the loading image of your choice */
            background: #f2f3f5 url('<?php echo Cake\Routing\Router::url('/', true) ?>img/default.gif') no-repeat 50% 50%;

            /* Ensures that the transition only runs in one direction */
            -webkit-transition: background-color 0;
            transition: background-color 0;
        }
       /* body {
            -webkit-transition: opacity 0s ease-in;
            transition: opacity 0s ease-in;
        }*/
        html.loading body {
            /* Make the contents of the body opaque during loading */
            opacity: 0;

            /* Ensures that the transition only runs in one direction */
            -webkit-transition: opacity 0;
            transition: opacity 0;

        }
        .eventsimg.placeholder-it a {
            font-size: 38px;
            color: #fff;
            line-height: 190px;
        }
        .eventsimg.placeholder-it {
            background: #735cb0;
        }

    </style>



    <?php if(strtolower($params['controller'])  == 'contests' && $params['action'] == 'enteries'){ 
        echo $this->AssetCompress->css('event');
        echo $this->AssetCompress->css('main');

    } else { ?>
        <noscript id="deferred-styles">
            <?php 
            if(strtolower($params['controller'])  == 'events'){
                echo $this->AssetCompress->css('event');
            }
            ?>
            <?= $this->AssetCompress->css('main'); ?>   
        </noscript>
        <script>
            var SiteUrl = '<?php echo Cake\Routing\Router::url('/', true) ?>';

            var loadDeferredStyles = function () {
                var addStylesNode = document.getElementById("deferred-styles");
                var replacement = document.createElement("div");
                replacement.innerHTML = addStylesNode.textContent;
                document.body.appendChild(replacement)
                addStylesNode.parentElement.removeChild(addStylesNode);
            };
            var raf = requestAnimationFrame || mozRequestAnimationFrame ||
            webkitRequestAnimationFrame || msRequestAnimationFrame;
            if (raf)
                raf(function () {
                    window.setTimeout(loadDeferredStyles, 0);
                });
            else
                window.addEventListener('load', loadDeferredStyles);
        </script>
    <?php } ?>

    <!--[if lt IE 9]>
               <script src="<?php echo $this->request->webroot; ?>js/html5shiv.js"></script>
               <script src="<?php echo $this->request->webroot; ?>js/respond.min.js"></script>
               <![endif]--> 
           </head>
