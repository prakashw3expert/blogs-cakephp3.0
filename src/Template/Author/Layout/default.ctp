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
            <?php echo $this->element('header'); ?>
            <!-- ========== Left Sidebar Start ========== -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page" style="margin-left:120px; margin-right: 120px;">
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
                                            ], ['text' => 'Dashobard',
                                        'url' => ['controller' => 'blogs', 'action' => 'index'],]
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

        <?php
//        echo $this->Html->script(
//                array(
//                   // '/assets/js/jquery.min',
//                   // '/assets/js/bootstrap.min',
//                    '/assets/js/detect',
//                    '/assets/js/fastclick',
//                    '/assets/js/jquery.slimscroll',
//                    '/assets/js/jquery.blockUI.js',
//                    '/assets/js/waves.js',
//                    '/assets/js/wow.min.js',
//                    '/assets/js/jquery.nicescroll.js',
//                    '/assets/js/jquery.scrollTo.min.js',
//                    '/assets/plugins/peity/jquery.peity.min.js',
//                    '/assets/plugins/waypoints/lib/jquery.waypoints.js',
//                    '/assets/plugins/counterup/jquery.counterup.min.js',
//                    '/assets/plugins/raphael/raphael-min.js',
//                    '/assets/plugins/jquery-knob/jquery.knob.js',
//                   // '/assets/pages/jquery.dashboard.js',
//                    '/assets/js/jquery.core.js',
//                    '/assets/js/jquery.app.js',
//                    //'/assets/plugins/summernote/dist/summernote.min.js'
//                )
//        );
        ?>
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
                $(":file").filestyle({input: false});
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


//            // Time Picker
//            jQuery('#timepicker').timepicker({
//                defaultTIme: false
//            });
//            jQuery('#timepicker2').timepicker({
//                showMeridian: false
//            });
//            jQuery('#timepicker3').timepicker({
//                minuteStep: 15
//            });

            //colorpicker start

//            $('.colorpicker-default').colorpicker({
//                format: 'hex'
//            });
//            $('.colorpicker-rgba').colorpicker();

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


            //Date range picker
//            $('.input-daterange-datepicker').daterangepicker({
//                buttonClasses: ['btn', 'btn-sm'],
//                applyClass: 'btn-default',
//                cancelClass: 'btn-white'
//            });
//            $('.input-daterange-timepicker').daterangepicker({
//                timePicker: true,
//                format: 'MM/DD/YYYY h:mm A',
//                timePickerIncrement: 30,
//                timePicker12Hour: true,
//                timePickerSeconds: false,
//                buttonClasses: ['btn', 'btn-sm'],
//                applyClass: 'btn-default',
//                cancelClass: 'btn-white'
//            });
//            $('.input-limit-datepicker').daterangepicker({
//                format: 'MM/DD/YYYY',
//                minDate: '06/01/2015',
//                maxDate: '06/30/2015',
//                buttonClasses: ['btn', 'btn-sm'],
//                applyClass: 'btn-default',
//                cancelClass: 'btn-white',
//                dateLimit: {
//                    days: 6
//                }
//            });

//            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
//
//            $('#reportrange').daterangepicker({
//                format: 'MM/DD/YYYY',
//                startDate: moment().subtract(29, 'days'),
//                endDate: moment(),
//                minDate: '01/01/2012',
//                maxDate: '12/31/2015',
//                dateLimit: {
//                    days: 60
//                },
//                showDropdowns: true,
//                showWeekNumbers: true,
//                timePicker: false,
//                timePickerIncrement: 1,
//                timePicker12Hour: true,
//                ranges: {
//                    'Today': [moment(), moment()],
//                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
//                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
//                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
//                    'This Month': [moment().startOf('month'), moment().endOf('month')],
//                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
//                },
//                opens: 'left',
//                drops: 'down',
//                buttonClasses: ['btn', 'btn-sm'],
//                applyClass: 'btn-default',
//                cancelClass: 'btn-white',
//                separator: ' to ',
//                locale: {
//                    applyLabel: 'Submit',
//                    cancelLabel: 'Cancel',
//                    fromLabel: 'From',
//                    toLabel: 'To',
//                    customRangeLabel: 'Custom',
//                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
//                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
//                    firstDay: 1
//                }
//            }, function (start, end, label) {
//                console.log(start.toISOString(), end.toISOString(), label);
//                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
//            });

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
                convert_urls: true,
                relative_urls: false,
                remove_script_host: false,
                selector: '.ckeditor',
                menubar: false,
                height: 500,
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste imagetools"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code", //jbimages
                imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
                content_css: [
                    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                    '//www.tinymce.com/css/codepen.min.css'
                ],
                relative_urls: false
            });
        </script>
        <?php echo $this->element('froala'); ?>
    </body>
</html>
