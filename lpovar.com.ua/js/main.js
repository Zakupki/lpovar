$(function(){
    loginAction();
    deleteCartProduct();
    changeCart();
    addDrink();
    registerValidation();
    subscribeValidation();
    promocodeAction();
    popupAction();
    buypopupAction();
    portionsAction();
    selfdeliverAction();
    newyearpopupAction();
    dietAction();
    makelikeAction();
    /*$('.tools .green-btn input').click(function(e){
     $(this).closest("form").submit();
     //alert(123);
     });*/
});

function selfdeliverAction(){
    $("#deliveryplace_id").change(function(){
        if($("#deliveryplace_id").val()>1)
            $('.delivery-blocks').hide();
        else
            $('.delivery-blocks').show();
    });

   /* $('#selfdeliver').change(function(){
        if($(this).attr("checked")){
            $('.delivery-blocks').hide();
        }else{
            $('.delivery-blocks').show();
        }
    });*/
}

function portionsAction(){
    $('.num-list li a').click(function(e){
        var _this = $(this);
        var portions=_this.attr('rel');
        if(!_this.parent().hasClass('active')){
            $('.num-list li.active input').attr('checked',false);
            $('.num-list li.active').removeClass('active');
            _this.parent().addClass('active');
            _this.parent().find('input').attr('checked',true);

        }
        console.log(portions);
        $('.buy-btn').attr('rel',portions);
        $('.buy-btn i').text(portions);
        $('.aside .total strong').text($('.aside .price').attr('rel')*portions);
        e.preventDefault();
    });
    /*$('.buy-btn').click(function(e){
     var _this = $(this);
     var portions=_this.attr('rel');
     $(location).attr('href',_this.attr('href')+'?q='+portions);
     e.preventDefault();
     });*/
}
function popupAction(){
    $('.call-popup').click(function(e){
        /*alert($(this).attr('rel'));*/
        $('#default-popup .popup-frame p').html($(this).attr('rel'));

        $('#default-popup').css('left', '0').hide().fadeIn(200);
        $('.bg').height(popups());
        if ($('#default-popup .popup').height() < $(window).height()) {
            $('#default-popup .popup').css({top:($(window).height()/2-$('#default-popup .popup').outerHeight()/2+$(window))});
        }
        e.preventDefault();
    });
    $('#diet-button a').click(function(e){

        $('#diet').css('left', '0').hide().fadeIn(200);
        /*$('.bg').height(popups());
        if ($('#default-popup .popup').height() < $(window).height()) {
            $('#default-popup .popup').css({top:($(window).height()/2-$('#default-popup .popup').outerHeight()/2+$(window))});
        }*/
        e.preventDefault();
    });
    $('.startvideo').click(function(e){
        /*alert($(this).attr('rel'));*/
        $('#video-popup .popup-frame p').html($('.popup-videodata').html());

        $('#video-popup').css('left', '0').hide().fadeIn(200);
        $('.bg').height(popups());
        if ($('#video-popup .popup').height() < $(window).height()) {
            $('#video-popup .popup').css({top:($(window).height()/2-$('#video-popup .popup').outerHeight()/2+$(window))});
        }
        e.preventDefault();
    });
    $('#video-popup .close').click(function(e){
        $('#video-popup .popup-frame p').html('');
    });
}
function buypopupAction(){
    /*$('.callbuy-popup,.callbuy-popup2 input:submit').click(function(e){
        $('#default-popup .popup-frame p').html('Заказ временно не доступен. Мы вернемся 4 января!');

        $('#default-popup').css('left', '0').hide().fadeIn(200);
        $('.bg').height(popups());
        if ($('#default-popup .popup').height() < $(window).height()) {
            $('#default-popup .popup').css({top:($(window).height()/2-$('#default-popup .popup').outerHeight()/2+$(window))});
        }
        e.preventDefault();
    });
    $('#video-popup .close').click(function(e){
        $('#video-popup .popup-frame p').html('');
    });
    return;*/
    $('.callbuy-popup').click(function(e){
        var quantity=$(this).attr('rel');
        var carturl=$(this).attr('href');

        //alert($(this).data('cat'));
        if($(this).data('cat')==10){
            $.post('/cart/checkdesert/',10).done(function(data){

                if(data.desert>1){
                    $('#buy-popup').css('left', '0').fadeIn(200);
                    $.post(carturl, 'q='+quantity).done(function(data){
                    });
                }else{
                    $('#default-popup .popup-frame p').html('Десерт вы можете заказать только при наличии позиции из основного меню');
                    $('#default-popup').css('left', '0').fadeIn(200);
                }
            });
        }else{
            $.post($(this).attr('href'), 'q='+quantity).done(function(data){

                var basket=$('.user-tools .cart em').html();
                $('.user-tools .cart em').html(Number(basket)+Number(quantity));

                $('#buy-popup').css('left', '0').hide().fadeIn(200);
                /*$('.bg').height(popups());
                 if ($('#buy-popup .popup').height() < $(window).height()) {
                 $('#buy-popup .popup').css({top:($(window).height()/2-$('#buy-popup .popup').outerHeight()/2+$(window).scrollTop())});
                 }*/
            });
        }
        e.preventDefault();
    });

    $(' .callbuy-popup2 input:submit').click(function(e){
        var f=$(this).closest("form");
        var rl=f.attr('rel');
        if(rl==10){
            $.post('/cart/checkdesert/',10).done(function(data){
                if(data.desert>1){
                    $('#buy-popup').css('left', '0').fadeIn(200);
                    $.post(f.attr('action'), 'q='+f.find('input[name=q]').val()).done(function(data){
                    });
                }else{
                    $('#default-popup .popup-frame p').html('Десерт вы можете заказать только при наличии позиции из основного меню');
                    $('#default-popup').css('left', '0').fadeIn(200);
                }
            });
        }else{
            $('#buy-popup').css('left', '0').fadeIn(200);
            $.post(f.attr('action'), 'q='+f.find('input[name=q]').val()).done(function(data){
            });
        }

        e.preventDefault();
    });

    /*
     var form=$('.callbuy-popup2');
     form.submit(function(e){
     $.post('/cart/checkdesert/',10).done(function(data){
     if(data.desert>1){
     $('#buy-popup').css('left', '0').fadeIn(200);
     $.post(form.attr('action'), 'q='+form.find('input[name=q]').val()).done(function(data){
     });


     }else{
     $('#default-popup .popup-frame p').html('Р”РµСЃРµСЂС‚ РІС‹ РјРѕР¶РµС‚Рµ Р·Р°РєР°Р·Р°С‚СЊ С‚РѕР»СЊРєРѕ РїСЂРё РЅР°Р»РёС‡РёРё РїРѕР·РёС†РёРё РёР· РѕСЃРЅРѕРІРЅРѕРіРѕ РјРµРЅСЋ')
     $('#default-popup').css('left', '0').fadeIn(200);
     }
     });
     return false;
     });*/

}

function newyearpopupAction(){
    $('#newyear-popup').css('left', '0').fadeIn(200);
    $('#newyear-popup2').css('left', '0').fadeIn(200);
    $('#tefal-popup').css('left', '0').fadeIn(200);
    $('#closed-popup').css('left', '0').fadeIn(200);
}

function subscribeValidation(){
    var form=$('.subscribe');
    input=$('.subscribe  input');
    form.submit(function(e){
        if(!(/^[-\._a-z0-9]+@(?:[a-z0-9][-a-z0-9]+\.)+[a-z]{2,6}$/ig).test(input.val())){
            e.preventDefault()
        }
    });

}
function registerValidation(){
    var form=$('.register-form'),
        input=$('.register-form .row.required input');
    input.blur(function(){
        var cur_input=$(this);
        if($(this).attr('name')=='RegisterForm[password]' || $(this).attr('name')=='RegisterForm[repeat_password]')
            var q='ajax=register-form&field='+$(this).attr('name')+'&RegisterForm[password]='+$('.register-form .row.required input[name="RegisterForm[password]"]').val()+'&RegisterForm[repeat_password]='+$('.register-form .row.required input[name="RegisterForm[repeat_password]"]').val();
        else
            var q='ajax=register-form&field='+$(this).attr('name')+'&'+$(this).attr('name')+'='+$(this).val();
        var emailerror=0;


        /*
         if($(this).val().trim()==""){
         $(this).closest('.input-holder').addClass('error');
         }else{
         $(this).closest('.input-holder').removeClass('error');
         }*/

        $.post(form.attr('action'), q, 'json').done(function(data){

            if(cur_input.attr('name')=='RegisterForm[email]'){
                if(!(/^[-\._a-z0-9]+@(?:[a-z0-9][-a-z0-9]+\.)+[a-z]{2,6}$/ig).test(cur_input.val())){
                    emailerror=true;
                }
            }

            if(data.error || emailerror){
                //alert(data.error);
                cur_input.parent('.input-holder').addClass('error');
                if(cur_input.attr('name')=='RegisterForm[password]' || cur_input.attr('name')=='RegisterForm[repeat_password]'){
                    $('.register-form .row.required input[name="RegisterForm[repeat_password]"]').parent('.input-holder').addClass('error');
                    $('.register-form .row.required input[name="RegisterForm[password]"]').parent('.input-holder').addClass('error');
                }


            }else{
                cur_input.parent('.input-holder').removeClass('error');
                if(cur_input.attr('name')=='RegisterForm[password]' || cur_input.attr('name')=='RegisterForm[repeat_password]'){
                    $('.register-form .row.required input[name="RegisterForm[repeat_password]"]').parent('.input-holder').removeClass('error');
                    $('.register-form .row.required input[name="RegisterForm[password]"]').parent('.input-holder').removeClass('error');
                }
            }
            cur_input.removeClass('ajaxPending');
            if(!form.find('input.ajaxPending').length){
                form.trigger('ajaxDone');
            }
        })
    })
    form.submit(function(e){
        if(form.hasClass('valid')){
            return true;
        }
        input.addClass('ajaxPending').trigger('blur');
        form.one('ajaxDone', function(){
            if (!form.find('.error').length) {
                form.addClass('valid').submit();
                return true;
            }
        });
        return false;
    });

    form.find('input:submit').unbind('click');
}
function addDrink(){
    $('form.add_drink').submit(function(e){
        $.post('/cart/adddrink/', $(this).serialize(), 'json').done(function(data){
            if(data.error){
            } else {
                $('#inerkassa_form input[name="ik_payment_amount"]').val(data.totalprice);
                $('#order_price').html(data.totalprice);
                $('.call-popup').click();
            }


        })
        e.preventDefault();
    });
}

function changeCart(){
    $('#cart-form .amount input').change(function(e){
        var newvalue=$(this).val();
        var dishid=$(this).parents('li.cart-item').attr('rel');



        $.post('/cart/updatesingle/', {'item': dishid, 'quantity': newvalue}, 'json').done(function(data){
            if(data.error){

            } else {
                var prices =data.totalcost.split('.');
                if(data.remove)
                    $('li.cart-item[rel='+dishid+']').fadeOut();
                $('.price-holder .num').html(prices[0]);
                $('.price-holder .currency span').html(prices[1]);

            }

        })

        //alert(dishid);
    });
    $('#cart-form .amount select').change(function(e){
        var newvalue=$(this).find(":selected").val()
        var dishid=$(this).parents('li.cart-item').attr('rel');

        $.post('/cart/updatesingle/', {'item': dishid, 'quantity': newvalue}, 'json').done(function(data){
            if(data.error){

            } else {
                var prices =data.totalcost.split('.');
                if(data.remove)
                    $('li.cart-item[rel='+dishid+']').fadeOut();
                $('.price-holder .num').html(prices[0]);
                $('.price-holder .currency span').html(prices[1]);

            }

        })
    });
    $('#cart-form').submit(function(e){
        e.preventDefault();
    });
    /*
     form.submit(function(e){
     login_status=$('#login-form .attention');
     login_status_text=$('#login-form .attention .text');
     e.preventDefault();
     login_status_text.empty();
     $.post(this.action, form.serialize(), 'json').done(function(data){
     if(data.error){
     login_status.addClass('active');
     login_status_text.append(data.status);
     } else {
     window.location.reload(true);
     }
     })
     });*/

}

function loginAction(){
    form = $('#login-form');
    form.submit(function(e){
        login_status=$('#login-form .attention');
        login_status_text=$('#login-form .attention .text');
        e.preventDefault();
        login_status_text.empty();
        $.post(this.action, form.serialize(), 'json').done(function(data){
            if(data.error){
                login_status.addClass('active');
                login_status_text.append(data.status);
            } else {
                login_status_text.hide();
                window.location.reload(true);
            }
        })
    });
}
function dietAction(){
    dietform = $('#diet-form');
    dietform.submit(function(e){
        login_status=$('#diet-form .attention');
        login_status_text=$('#diet-form .attention .text');
        e.preventDefault();
        login_status_text.empty();
        $.post(this.action, dietform.serialize(), 'json').done(function(data){
            if(data.error){
                login_status.addClass('active');
                login_status_text.append(data.status);
            } else {
                //login_status_text.hide();
                $('#diet').fadeOut(200);
                $('#default-popup .popup-frame p').html('Ваше сообщение успешно отправлено диетологу');
                $('#diet-form input').val('');
                $('#diet-form textarea').val('');
                $('#default-popup').css('left', '0').fadeIn(200);
                //window.location.reload(true);
            }
        })
    });
}

function promocodeAction(){
    var totaloldprice=$('#totaloldprice').attr('rel');
    form1 = $('#disccode');
    form1.submit(function(e){
        if(form1.find('input[name="code"]').val().trim()!="")
            $.post('/cart/adddiscount/', {'code': form1.find('input[name="code"]').val()}, 'json').done(function(data){
                if(data.id){
                    if(data.discounttype_id==3){
                        $('#discountblock').hide();
                        $('#totalprice').hide();
                        $('#discounttext').show();
                        $('#discounttext .payable').html(data.title);
                    }else{
                        var newtotal=totaloldprice/100*(100-parseInt(data.discount));
                        var totalarr=newtotal.toFixed(2).toString().split(".");
                        $('#discounttext').hide();
                        $('#discountblock').show();
                        $('#totalprice').show();
                        $('#totalprice .num').html(totalarr[0]);
                        $('#totalprice .currency span').html(totalarr[1]);
                        $('#percents').html(data.discount);
                    }
                    /*var newtotal=totaloldprice/100*(100-parseInt(data.discount));
                    var totalarr=newtotal.toFixed(2).toString().split(".");
                    $('#discountblock').show();
                    $('#totalprice').show();
                    $('#totalprice .num').html(totalarr[0]);
                    $('#totalprice .currency span').html(totalarr[1]);
                    $('#percents').html(data.discount);*/
                }
                $('#promo-code').css('left', '0').hide();
            })
        e.preventDefault();
    });

    /*
     $('.delivery-form input[email="code"]').blur(function(){
     alert(123);
     });*/
    /*
     $('.delivery-form').submit(function(){
     e.preventDefault();
     });*/
    var form=$('.delivery-form'),
        input=$('.delivery-form .row.required input');
    input.blur(function(){
        if($(this).attr('name')=='email' && !(/^[-\._a-z0-9]+@(?:[a-z0-9][-a-z0-9]+\.)+[a-z]{2,6}$/ig).test($(this).val())){
            $(this).parent('.input-holder').addClass('error');
        }
        else if($(this).val().trim()==""){
            $(this).closest('.input-holder').addClass('error');
        }else{
            /*
             if($(this).attr('name')=='phone' && $(this).val().trim!=""){
             $.post('/cart/adddeliverdata/', {'phone': $(this).val()}, 'json').done(function(data){
             });
             }
             if($(this).attr('name')=='delivery_from' && $(this).val().trim!=""){
             $.post('/cart/adddeliverdata/', {'delivery_from': $(this).val()}, 'json').done(function(data){
             });
             }
             if($(this).attr('name')=='delivery_to' && $(this).val().trim!=""){
             $.post('/cart/adddeliverdata/', {'delivery_to': $(this).val()}, 'json').done(function(data){
             });
             }*/



            if($(this).attr('name')=='email' && $(this).val().trim!=""){
                $.post('/cart/adddiscount/', {'email': $(this).val()}, 'json').done(function(data){
                    if(data.id){
                        //alert(data.discounttype_id);
                        if(data.discounttype_id==3){
                            $('#discounttext').show();
                            $('#discounttext .payable').html(data.title);
                        }else{
                            var newtotal=totaloldprice/100*(100-parseInt(data.discount));
                            var totalarr=newtotal.toFixed(2).toString().split(".");
                            $('#discountblock').show();
                            $('#totalprice').show();
                            $('#totalprice .num').html(totalarr[0]);
                            $('#totalprice .currency span').html(totalarr[1]);
                            $('#percents').html(data.discount);
                        }
                    }
                })
            }
            $(this).closest('.input-holder').removeClass('error');
        }
    });

    input_store=$('.delivery-form .row.store input');
    input_store.blur(function(){
        if($(this).attr('name')=='name' && $(this).val().trim!=""){
            $.post('/cart/adddeliverdata/', {'name': $(this).val()}, 'json').done(function(data){
            });
        }
        if($(this).attr('name')=='phone' && $(this).val().trim!=""){
            $.post('/cart/adddeliverdata/', {'phone': $(this).val()}, 'json').done(function(data){
            });
        }
        if($(this).attr('name')=='delivery_from' && $(this).val().trim!=""){
            $.post('/cart/adddeliverdata/', {'delivery_from': $(this).val()}, 'json').done(function(data){
            });
        }
        if($(this).attr('name')=='delivery_till' && $(this).val().trim!=""){
            $.post('/cart/adddeliverdata/', {'delivery_till': $(this).val()}, 'json').done(function(data){
            });
        }

    });
    textarea_store=$('.delivery-form .row.store textarea');
    textarea_store.blur(function(){
        if($(this).attr('name')=='delivery_addr' && $(this).val().trim!=""){
            $.post('/cart/adddeliverdata/', {'delivery_addr': $(this).val()}, 'json').done(function(data){
            });
        }
    });
    /*.first().blur(function(){
     if(!(/^[-\._a-z0-9]+@(?:[a-z0-9][-a-z0-9]+\.)+[a-z]{2,6}$/ig).test($(this).val())){
     $(this).parent('.input-holder').addClass('error');
     }else{
     $(this).parent('.input-holder').removeClass('error');
     }
     });*/

    form.submit(function(e){
        input.trigger('blur');
        if (form.find('.error').size()) {
            e.preventDefault();
        }
    });

    form.find('input:submit').unbind('click');
}

function deleteCartProduct(){
    cartItem = $('.delete');
    cartItem.click(function(e){
        $.post('/cart/delete/'+cartItem.attr('rel')).done(function(data){
            if(data.error){
                alert(data.error);
            } else {
                window.location.reload(true);
            }
        });
    })
}
function makelikeAction(){
    blogItem = $('.make-like');
    blogItem.click(function(e){
        lin=$(this);
        $.post('/blog/like/', {'id': $(this).attr('rel')}, 'json').done(function(data){
            if(data.error){
                //alert(data.error);
            } else {
                lin.html(data.likes);
            }
        });
        e.preventDefault();
    })
}