$(function (){

$('#profileformbtn1').click(function (){

    $('.toast').toast('show');
    
});

    $('.auth-link').on('click',function (event){
        event.preventDefault();
        $('#modal').modal('show');
        $('#modal .modal-content')
                .load($(this).attr('href'));
        return false;
    });

    $('.modallink').on('click',function (event){
        event.preventDefault();
        $('#modal').modal('show');
        $('#modal .modal-content')
                .load($(this).data('url'));
        return false;
    });



    // $('.auth-link').on('click',function (event){
    //     // alert($('.auth-form #loginform-email').val());
    //     console.log($(this)+' '+);
    //     $('.auth-form #loginform-email').val('test');
    // });
    // $('#modal').on('show.bs.modal', function (event) {
    //     var button = $(event.relatedTarget) ;
    //
    //     // $('.auth-form').trigger('reset');
    //     // $('#'+$(this).attr('id')+' '+' input').removeAttr('value');
    //     // console.log(('#'+$(this).attr('id')+' '+' input').val());
    //
    //     // $('#login-form').empty();
    //     $(this)
    //         .find('.modal-content')
    //         .load(button.attr('href'));
    //     // $('#login-form').empty();
    //     // $('#loginform-email').val('');
    //     // return false;
    // });


    // $('#modal').on('hidden.bs.modal', function() {
    //     // $(this)
    //     //     .find('.modal-content')
    //     //     .html('');
    //     // $('#'+$(this).attr('id')+' '+' input').removeAttr('value');
    //     // $('#'+$(this).attr('id')+' '+' input').trigger('reset');
    //     $('#modal .modal-body').html('');
    //
    //     $('#login-form').empty();
    // });

    $(document).on("submit", '#signup-form', function (e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: form.serialize(),
            success: function (result) {
                // console.log(result);
                    var html = '<div id="success alert alert-success p-5"><strong>Спасибо за регистрацию на сайте. Для подтверждения регистрации перейдите, пожалуйста, по ссылке, которая отправлена на e-mail, указанный Вами при регистрации.</strong></div>';
                    $('.tab-content').html(html);

                    setTimeout(function() {
                        $("#modal").modal('hide');
                    }, 15000);
                // }
            },
            error: function (result) {
                // console.log(result);
                var html = '<div id="success alert alert-success p-5"><strong>В данный момент невозможно зарегистрироваться. Попробуйте, пожалуйста позднее или обратитесь к администратору сайта.</strong></div>';
                $('.tab-content').html(html);
                $('.modal-body .alert').html(html);
                // setTimeout(function() { // скрываем modal через 4 секунды
                //     $("#modal").modal('hide');
                // }, 6000);
                // $('#success').html("<div class='alert alert-success p-5'>");
                // $('#success > .alert-danger').append("<strong>В данный момент невозможно зарегистрироваться. Попробуйте, пожалуйста позднее или обратитесь к администратору сайта.</strong>");
                // $('#success > .alert-danger').append('</div>');
            }
        });
    });




    /*
        Carousel
    */
    // $('#carousel-articles').on('slide.bs.carousel', function (e) {
    //     /*
    //         CC 2.0 License Iatek LLC 2018 - Attribution required
    //     */
    //     var $e = $(e.relatedTarget);
    //     var idx = $e.index();
    //     var itemsPerSlide = 5;
    //     var totalItems = $('.carousel-item').length;
    //
    //     if (idx >= totalItems-(itemsPerSlide-1)) {
    //         var it = itemsPerSlide - (totalItems - idx);
    //         for (var i=0; i<it; i++) {
    //             // append slides to end
    //             if (e.direction=="left") {
    //                 $('.carousel-item').eq(i).appendTo('.carousel-inner');
    //             }
    //             else {
    //                 $('.carousel-item').eq(0).appendTo('.carousel-inner');
    //             }
    //         }
    //     }
    // });

    // $('.slider-inner').each(function(){
    //     var slickInduvidual = $(this);
    //     slickInduvidual.slick({
    //         dots: false,
    //         infinite: true,
    //         speed: 300,
    //         slidesToShow: 3,
    //         slidesToScroll: 1,
    //         arrows: true,
    //         // appendArrows: $('.slick-arrow'),
    //         nextArrow: slickInduvidual.next().find('.right'),
    //         prevArrow: slickInduvidual.next().find('.left')
    //     });
    // })



    // $('.speakers-slider .slider-inner').slick({
    //     dots: false,
    //     infinite: true,
    //     speed: 300,
    //     slidesToShow: 3,
    //     slidesToScroll: 1,
    //         prevArrow: '<button id="prev1" type="button" class="btn btn-juliet arrows arrow-left"></button>',
    //         nextArrow: '<button id="next1" type="button" class="btn btn-juliet arrows arrow-right"></button>',
    // });
    // $('.articles-slider .slider-inner').slick({
    //         dots: false,
    //         infinite: true,
    //         speed: 300,
    //         slidesToShow: 2,
    //         slidesToScroll: 1,
    //         prevArrow: '<button id="prev2" type="button" class="btn arrows arrow-left"></button>',
    //         nextArrow: '<button id="next2" type="button" class="btn arrows arrow-right"></button>',
    //     });

    $('.speakers-slider .slider-inner').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        // appendArrows: $('.speakers-slick-arrow'),
        prevArrow: '<button id="prev1" type="button" class="btn arrows arrow-left"></button>',
        nextArrow: '<button id="next1" type="button" class="btn arrows arrow-right"></button>',
        responsive: [
            {
                breakpoint: 1500,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    // infinite: true,
                    // dots: true
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    // infinite: true,
                    // dots: true
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });



    $('#carousel1').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        // appendArrows: $('.articles-slider .slick-arrow'),
        prevArrow: '<button id="prev2" type="button" class="btn arrows arrow-left"></button>',
        nextArrow: '<button id="next2" type="button" class="btn arrows arrow-right"></button>',
        responsive: [
            {
                breakpoint: 1500,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    // infinite: true,
                    // dots: true
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    // infinite: true,
                    // dots: true
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    // $('.webinar-speaker-slick-slider').slick({
    //    infinite: true,
    //    slidesToShow: 1,
    //    slidesToScroll: 1
    // });

    // $('.slick-speaker').each(function(i, e){
    //
    //         $(e).slick({
    //             infinite: true,
    //             slidesToShow: 1,
    //             slidesToScroll: 1
    //         });
    //
    // })
    // var numSlick = 0;
    // $('.slick-speaker').each(function() {
    //     numSlick++;
    //     $(this).addClass( 'slider-' + numSlick ).slick({
    //         arrows: false,
    //         asNavFor: '.slider-nav.slider-' + numSlick,
    //         fade: true,
    //         slidesToScroll: 1,
    //         slidesToShow: 1,
    //     });
    // });

});