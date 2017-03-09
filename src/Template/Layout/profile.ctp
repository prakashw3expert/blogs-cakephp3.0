<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html ng-app="myapp">
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>
        <?= $this->AssetCompress->css('layout'); ?>
        <?= $this->fetch('meta') ?>
        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <?php echo $this->Html->script('/assets/js/modernizr.min.js'); ?>
        <script>
            var webroot = '<?php echo $this->request->webroot; ?>';
            var SiteUrl = '<?php echo \Cake\Routing\Router::url('/', true); ?>';
            var SiteAdminUrl = '<?php echo \Cake\Routing\Router::url('/', true) . 'admin/'; ?>';
        </script>
        <style>
            .mt10{margin-top: 10px;}
        </style>
    </head>
    <body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">
            <?php echo $this->element('header_login'); ?>
            <!-- ========== Left Sidebar Start ========== -->
            <?php echo $this->element('menus'); ?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page" >
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box" style="padding: 5px 20px 0px 20px;">
                                    <?php
                                    echo $this->Html->getCrumbList(
                                            [
                                                'lastClass' => 'active',
                                                'class' => 'breadcrumb',
                                                'style' => 'margin-bottom:8px;',
                                            ]
                                    );
                                    ?>

                                </div>
                            </div>
                        </div>
                        <?= $this->Flash->render() ?>
                        <?= $this->fetch('content') ?>
                    </div> <!-- container -->
                </div> <!-- content -->

                <footer class="footer text-right">
                    © 2016. All rights reserved.
                </footer>
            </div>
        </div>
        <!-- END wrapper -->

        <script>
            var resizefunc = [];
        </script>
        
        <?= $this->AssetCompress->script('layout'); ?>
        <?= $this->Html->script(['/assets/plugins/notifyjs/dist/notify.min.js','/assets/plugins/notifications/notify-metro.js','angular-apps']); ?>
        <?= $this->fetch('jsSection');?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });
                $(".knob").knob();

            });

            jQuery(document).ready(function () {

                $('.image-popup').magnificPopup({
                    type: 'image',
                    closeOnContentClick: true,
                    mainClass: 'mfp-fade',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                    }
                });

                //advance multiselect start
                $('#my_multi_select3').multiSelect({
                    selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                    selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                    afterInit: function (ms) {
                        var that = this,
                                $selectableSearch = that.$selectableUl.prev(),
                                $selectionSearch = that.$selectionUl.prev(),
                                selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                                selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                                .on('keydown', function (e) {
                                    if (e.which === 40) {
                                        that.$selectableUl.focus();
                                        return false;
                                    }
                                });

                        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                                .on('keydown', function (e) {
                                    if (e.which == 40) {
                                        that.$selectionUl.focus();
                                        return false;
                                    }
                                });
                    },
                    afterSelect: function () {
                        this.qs1.cache();
                        this.qs2.cache();
                    },
                    afterDeselect: function () {
                        this.qs1.cache();
                        this.qs2.cache();
                    }
                });

                // Select2
                $(".select2").select2();

                $(".select2-limiting").select2({
                    maximumSelectionLength: 2
                });

                $('.selectpicker').selectpicker();
                //$(":file").filestyle({input: false});
            });

            //Bootstrap-TouchSpin
            $(".vertical-spin").TouchSpin({
                verticalbuttons: true,
                verticalupclass: 'ion-plus-round',
                verticaldownclass: 'ion-minus-round'
            });
            var vspinTrue = $(".vertical-spin").TouchSpin({
                verticalbuttons: true
            });
            if (vspinTrue) {
                $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
            }

            $("input[name='demo1']").TouchSpin({
                min: 0,
                max: 100,
                step: 0.1,
                decimals: 2,
                boostat: 5,
                maxboostedstep: 10,
                postfix: '%'
            });
            $("input[name='demo2']").TouchSpin({
                min: -1000000000,
                max: 1000000000,
                stepinterval: 50,
                maxboostedstep: 10000000,
                prefix: '$'
            });
            $("input[name='demo3']").TouchSpin();
            $("input[name='demo3_21']").TouchSpin({
                initval: 40
            });
            $("input[name='demo3_22']").TouchSpin({
                initval: 40
            });

            $("input[name='demo5']").TouchSpin({
                prefix: "pre",
                postfix: "post"
            });
            $("input[name='demo0']").TouchSpin({});


            //Bootstrap-MaxLength
            $('input#defaultconfig').maxlength()

            $('input#thresholdconfig').maxlength({
                threshold: 20
            });

            $('input#moreoptions').maxlength({
                alwaysShow: true,
                warningClass: "label label-success",
                limitReachedClass: "label label-danger"
            });

            $('input#alloptions').maxlength({
                alwaysShow: true,
                warningClass: "label label-success",
                limitReachedClass: "label label-danger",
                separator: ' out of ',
                preText: 'You typed ',
                postText: ' chars available.',
                validate: true
            });

            $('textarea#textarea').maxlength({
                alwaysShow: true
            });

            $('input#placement').maxlength({
                alwaysShow: true,
                placement: 'top-left'
            });




            // Date Picker
            jQuery('.datepicker').datepicker({
                autoclose: true,
                format: "dd/mm/yyyy",
                todayHighlight: true
            });
            jQuery('#datepicker-inline').datepicker();
            jQuery('#datepicker-multiple-date').datepicker({
                format: "dd/mm/yyyy",
                clearBtn: true,
                multidate: true,
                multidateSeparator: ","
            });
            jQuery('#date-range').datepicker({
                toggleActive: true
            });

            //Clock Picker
            $('.clockpicker').clockpicker({
                donetext: 'Done'
            });

            $('.clockpicker').clockpicker({
                placement: 'bottom',
                align: 'left',
                autoclose: true,
                'default': 'now'
            });
            $('#check-minutes').click(function (e) {
                // Have to stop propagation here
                e.stopPropagation();
                $("#single-input").clockpicker('show')
                        .clockpicker('toggleView', 'minutes');
            });

            

            $(".group-checkable").change(function () {
                $(".checkboxes").prop('checked', $(this).prop("checked"));

            });

            $(".checkboxes").change(function () {
                if ($('.checkboxes:checked').length == $('.checkboxes').length) {
                    $(".group-checkable").prop('checked', true);
                } else {
                    $(".group-checkable").prop('checked', false);
                }

            });
            $('.bukl_action').change(function () {
                $('.bulk_form').attr('action', $(this).val());
            });

            
        </script>
        <?php echo $this->Html->script('/tinymce/tinymce.min.js'); ?>
        <script>
            tinymce.init({
                convert_urls: false,
                relative_urls: false,
                remove_script_host: false,
                selector: '#editor, .ckeditor',
                menubar: 'insert format table',
                height: 500,
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste filemanager twembed"
                ],
                toolbar: "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code filemanager media fullscreen twembed", //jbimages
                imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
                image_advtab: true,
                external_filemanager_path: SiteUrl+"tinymce/plugins/filemanager/",
                filemanager_title: "Responsive Filemanager",
                external_plugins: {"filemanager": "plugins/filemanager/plugin.min.js"},
                content_css: [
                    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                    '//www.tinymce.com/css/codepen.min.css'
                ],
                relative_urls: false
            });
        </script>

    </body>
</html>

