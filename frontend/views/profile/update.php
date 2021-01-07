<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */

$this->title = 'Моя анкета';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-create position-relative">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
//    Pjax::begin( [ 'enablePushState' => false, 'timeout' => 5000, 'id' => 'pjax_form' ] );
    //var_dump($form2model);
    echo $this->render('_form1', ['profile' => $form1model,'arr' => $arr]);
    echo $this->render('_form2', ['profile' => $form2model,'arr' => $arr]);
    echo $this->render('_form3', ['profile' => $form3model,'arr' => $arr]) ;
    echo $this->render('_form4', ['profile' => $form4model,'arr' => $arr]) ;
//    Pjax::end();
?>
    <div id="uploadimageModal" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Обрезать и загрузить фото</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 text-center">
                            <div id="image_ava"></div>
                        </div>
                        <div class="col-md-4" style="padding-top:30px;">
                            <br />
                            <br />
                            <br/>
                            <button class="btn btn-success crop_image">Применить</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php



    $js = <<< JS
    $('.profileform').on('submit',function (event){
        event.preventDefault();
        var form = $(this);
        console.log(form);
        
        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: form.serialize(),
            success: function (result) {
                console.log(result);
                $('#modalnotice').modal('show');
                $('.modal-body').html('<div class="p-4 alert-success">'+result+'</div>');
              
            },
            error: function (result) {
                console.log(result);
                
                $('#modalnotice').modal('show');
                $('.modal-body').html(result);
            }
        });
    });

    $(document).ready(function(){
                    var image_crop = $('#image_ava').croppie({
                        enableExif: true,
                        viewport: {
                            width:160,
                            height:160,
                            type:'circle' 
                        },
                        boundary:{
                            width:200,
                            height:200
                        }
                    });

                    $('#upload_image').on('change', function(){
                        var reader = new FileReader();
                        reader.onload = function (event) {
                            image_crop.croppie('bind', {
                                url: event.target.result
                            }).then(function(){
                                console.log('jQuery bind complete');
                            });
                        }
                        reader.readAsDataURL(this.files[0]);
                        $('#uploadimageModal').modal('show');
                    });

                    $('.crop_image').click(function(event){
                        image_crop.croppie('result', {
                            type: 'canvas',
                            size: 'viewport',
                            // format: 'jpeg'
                        }).then(function(response){
                            $.ajax({
                                url:"/profile/upload-file",
                                type: "POST",
                                data:{"image": response},
                                success:function(data)
                                {
                                    event.preventDefault();
                                    // console.log(data);
                                    $('#uploaded_image .uploaded-ava').html(data);
                                    $('#uploadimageModal').modal('hide');
                                    $('#uploaded_image .uploaded-ava').html(data);
                                }
                            });
                        })
                    });

                });
JS;
    $this->registerJs( $js, $position = yii\web\View::POS_READY, $key = null  );

$this->registerJs("jQuery('#checkAll').change(function(){jQuery('.subscribe').prop('checked',this.checked?'checked':'');})");


$this->registerJsFile('@web/js/croppie.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('@web/css/croppie.css', ['depends' => [\yii\web\JqueryAsset::class]]);

?>
    <?php
    $this->registerJsFile('@web/js/nkomed.js', ['depends' => [\yii\web\JqueryAsset::class]]);
//    $this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
    ?>


    <?php
//    $this->render('_form', [
//        'profile' => $profile,
//        'arr' => $arr
//    ])
    ?>
