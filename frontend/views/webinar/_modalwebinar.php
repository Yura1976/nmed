<div class="webinar-list w-100">
    <div class="webinar-item w-100 pb-5">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="/images/btn_close.svg" alt=""></span>
        </button>
    <?php
        echo \Yii::$app->view->renderFile('@app/views/webinar/_list.php',['model'=>$model]);
    ?>
    </div>
</div>